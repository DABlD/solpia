<!-- GENERATE LOCATION STATISTICS -->
public function tempFunc(){
    $provinces = ["ABRA","AGUSAN DEL NORTE","AGUSAN DEL SUR","AKLAN","ALBAY","ANTIQUE","APAYAO","AURORA","BASILAN","BATAAN","BATANES","BATANGAS","BENGUET","BILIRAN","BOHOL","BUKIDNON","BULACAN","CAGAYAN","CAMARINES NORTE","CAMARINES SUR","CAMIGUIN","CAPIZ","CATANDUANES","CAVITE","CEBU","COTABATO","DAVAO","DINAGAT ISLANDS","EASTERN SAMAR","GUIMARAS","IFUGAO","ILOCOS NORTE","ILOCOS SUR","ILOILO","ISABELA","KALINGA","LA UNION","LAGUNA","LANAO DEL NORTE","LANAO DEL SUR","LEYTE","MAGUINDANAO","MARINDUQUE","MASBATE","MISAMIS OCCIDENTAL","MISAMIS ORIENTAL","MOUNTAIN PROVINCE","NEGROS OCCIDENTAL","NEGROS ORIENTAL","NORTHERN SAMAR","NUEVA ECIJA","NUEVA VIZCAYA","OCCIDENTAL MINDORO","ORIENTAL MINDORO","PALAWAN","PAMPANGA","PANGASINAN","QUEZON","QUIRINO","RIZAL","ROMBLON","SAMAR","SARANGANI","SIQUIJOR","SORSOGON","SOUTH COTABATO","SOUTHERN LEYTE","SULTAN KUDARAT","SULU","SURIGAO DEL NORTE","SURIGAO DEL SUR","TARLAC","TAWI-TAWI","WESTERN SAMAR","ZAMBALES","ZAMBOANGA DEL NORTE","ZAMBOANGA DEL SUR","ZAMBOANGA SIBUGAY"];

    $cities = ["CALOOCAN","LAS PIÑAS","MAKATI","MALABON","MANDALUYONG","MANILA","MARIKINA","MUNTINLUPA","NAVOTAS","PARAÑAQUE","PASAY","PASIG","PATEROS","QUEZON CITY","SAN JUAN","TAGUIG","VALENZUELA"];

    $crews = User::where('role', 'Applicant')
            ->where(function($q){

                $i1 = "DAVAO";
                $i2 = "SOUTH COTOBATO";
                $i3 = "GEN. SAN";

                $q->where('address', 'like', "%$i1%");
                // $q->orWhere('address', 'like', "%$i2%");
                // $q->orWhere('address', 'like', "%$i3%");
                $q->orWhere('a.provincial_address', 'like', "%$i1%");
                // $q->orWhere('a.provincial_address', 'like', "%$i2%");
                // $q->orWhere('a.provincial_address', 'like', "%$i3%");
            })
            ->join('applicants as a', 'a.user_id', '=', 'users.id')
            ->select('address', 'fname', 'lname', 'contact', 'fleet', 'users.id', 'a.id as aid', 'a.provincial_address')
            ->get();

    foreach($crews as $crew){
        // GET RANK
        $rank = null;
        if(isset($crew->crew->pro_app->rank)){
            $rank = $crew->crew->pro_app->rank->abbr;
        }
        else{
            continue;
        }

        if($crew->contact == ""){
            $crew->contact = $crew->crew->provincial_contact;
        }

        echo "$crew->fname $crew->lname ; $crew->fleet ; $rank ; $crew->contact ; $crew->address ; $crew->provincial_address <br>";
    }
}

<!-- GET ALL NEW HIRE TOEI CREW WITHIN PAST 2 YEARS -->

$applicants = User::whereIn('fleet', ["TOEI", "FLEET A"])->where('role', 'Applicant')->get();
$applicants->load('crew.sea_service');

$newHires = $applicants->filter(function($applicant){
    // return $applicant->crew->sea_service
    if(isset($applicant->crew->sea_service)){
        $sss = collect($applicant->crew->sea_service->sortBy('sign_on')->values());

        $luc = $applicant->crew->line_up_contracts->sortByDesc('joining_date');
        $nH = false;
        $xCrew = false;

        foreach($sss as $key => $ss){
            if(str_contains($ss->manning_agent, 'SOLPIA')){
                if($ss->sign_on >= "2021-09-01"){
                    $applicant->ss = $ss;
                    if($key > 0){
                        $applicant->previous_manning = $sss[$key - 1]->manning_agent;
                    }
                    else{
                        $applicant->previous_manning = "FIRST";
                    }

                    if(str_contains($applicant->previous_manning, "FAIRVIEW")){
                        $xCrew = true;
                        break;
                    }
                    else{
                        $nH = true;
                        break;
                    }
                }
                else{
                    $xCrew = true;
                    break;
                }
            }
        }

        if($nH == false && $xCrew == false && $luc->count()){
            $applicant->previous_manning = $sss->count() ? $sss->last()->manning_agent : "FIRST";

            if(!str_contains($applicant->previous_manning, "FAIRVIEW")){
                $nH = true;
            }
        }

        return $nH;
    }
});

// DISPLAY
$newHires->load('crew.line_up_contracts.vessel');
$newHires->load('crew.line_up_contracts.rank');
echo $newHires->count() . '<br>';

foreach($newHires as $nH){
    $lup = $nH->crew->line_up_contracts->count() ? $nH->crew->line_up_contracts->sortBy('joining_date')->first() : $nH->ss ?? "";

    $rank = isset($nH->ss) ? (isset($nH->ss->rank2) ? $nH->ss->rank2->abbr : "-") : (isset($lup->rank) ? $lup->rank->abbr : "-");
    $name = $nH->namefull;
    $vessel = isset($nH->ss) ? $nH->ss->vessel_name : (isset($lup->vessel) ? $lup->vessel->name : "-");
    $age = $nH->birthday ? $nH->birthday->age : "";
    $sign_on = isset($nH->ss) ? $nH->ss->sign_on : $lup->joining_date;
    $manning_agent = $nH->previous_manning;

    if(str_contains($manning_agent, "LEONIS") || str_contains($manning_agent, "MAINE") || str_contains($manning_agent, "SPLASH") || str_contains($manning_agent, "ALPHA") || str_contains($manning_agent, "LEONES")){
        echo "$rank;$name;$vessel;$age;$sign_on;$manning_agent<br>";
    }
}

<!-- IDK WHAT THIS DO -->
$vIds = [22, 71, 72, 4661, 4621];
$linedUp = LineUpContract::whereIn('vessel_id', $vIds)->whereNull('disembarkation_date')->pluck('applicant_id');
$pro_app = ProcessedApplicant::whereIn('vessel_id', $vIds)->where('status', 'Lined-Up')->pluck('applicant_id');

$aIds = array_merge($linedUp->toArray(), $pro_app->toArray());
$uIds = Applicant::whereIn('id', $aIds)->pluck('user_id')->toArray();
User::whereIn('id', $uIds)->update(["fleet" => "FLEET D"]);

<!-- GET ALL TOEI CREW CE 1AE THAT HAS HIGHER LICENSE -->
$tc = User::where('role', 'Applicant')->where('fleet', 'TOEI')->get();

$tc = $tc->filter(function($temp){
    if(isset($temp->crew->pro_app->rank)){
        return $temp->crew->pro_app->rank_id == 7 || $temp->crew->pro_app->rank_id == 8 || $temp->crew->pro_app->rank_id == 53 || $temp->crew->pro_app->rank_id == 54 || $temp->crew->pro_app->rank_id == 55;
    }

    return false;
});

$array = [];
// $tc = $tc->groupBy('crew.pro_app.rank_id');

foreach($tc as $temp){
    $docus = $temp->crew->document_lc->filter(function($docu){
        return $docu->type == "COC";
    });

    foreach($docus as $docu){
        if(str_starts_with($docu->no, "CCE") || str_starts_with($docu->no, "C2E")){
            $temp->hl = $docu->no;
            array_push($array, $temp);
        }
    }
}

foreach($array as $temp){
    echo $temp->namefull . ';' . $temp->crew->pro_app->rank->abbr . ';' . $temp->hl . '<br>';
}

// ENYE ñ
$users = User::where('fname', 'like', '%?%')->orWhere('lname', 'like', '%?%')->get();
foreach($users as $user){
    $user->fname = str_replace('?', 'Ñ', $user->fname);
    $user->lname = str_replace('?', 'Ñ', $user->lname);
    $user->save();
}

foreach($users as $user){
    echo $user->fname . ' - ' . $user->lname . '<br>';
}

die;