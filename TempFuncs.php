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


<!-- CE JOEY CADETS LIST -->

$start = $req->start;
        $end = $req->end;

        echo $start . ' -> ' . $end . '<br><br>';

        $lups = LineUpContract::select('line_up_contracts.*', 'a.id as aid', 'u.id as uid', 'fname', 'lname', 'fleet')
                            ->join('applicants as a', 'line_up_contracts.applicant_id', '=', 'a.id')
                            ->join('users as u', 'u.id', '=', 'a.user_id')
                            ->where('joining_date', '>=', $start)
                            ->where('joining_date', '<=', $end)
                            ->where('fleet', '=', 'TOEI')
                            ->get();

        $lups->load('rank');
        $lups->load('vessel');
        $lups->load('applicant.user');
        $lups->load('applicant.sea_service');

        foreach($lups as $lup){
            $temp = $lup->applicant->sea_service->sortBy('sign_on');
            $bool = false;

            if(in_array($lup->rank_id, [14, 19])){
                $bool = true;
            }
            elseif(sizeof($temp)){
                foreach($temp as $ss){
                    if(in_array($ss->rank, ["DECK CADET", "ENGINE CADET"]) && str_contains($ss->manning_agent, "SOLPIA")){
                        $bool = true;
                    }
                }
            }
            else{
                $bool = true;
            }

            if($bool){
                echo $lup->lname . ', ' . $lup->fname . ';' . $lup->rank->abbr . ';' . $lup->vessel->name . ';' . $lup->joining_date . '<br>';
            }
        }

        echo '<br><br><br>';
        echo '~~~~~~~~~~~~~~~~~~~';
        echo '<br>';

        $lups = LineUpContract::select('line_up_contracts.*', 'a.id as aid', 'u.id as uid', 'fname', 'lname', 'fleet')
                                    ->join('applicants as a', 'line_up_contracts.applicant_id', '=', 'a.id')
                                    ->join('users as u', 'u.id', '=', 'a.user_id')
                                    ->where('disembarkation_date', '>=', $start)
                                    ->where('disembarkation_date', '<=', $end)
                                    ->where('fleet', '=', 'TOEI')
                                    ->get();

        $lups->load('rank');
        $lups->load('vessel');
        $lups->load('applicant.user');
        $lups->load('applicant.sea_service');

        foreach($lups as $lup){
            $temp = $lup->applicant->sea_service->sortBy('sign_on');
            $bool = false;

            foreach($temp as $ss){
                if(in_array($ss->rank, ["DECK CADET", "ENGINE CADET"]) && str_contains($ss->manning_agent, "SOLPIA")){
                    $bool = true;
                }
            }

            if($bool){
                if(str_contains($lup->status, "On Board")){
                    echo $lup->lname . ', ' . $lup->fname . ';' . $lup->rank->abbr . ';' . $lup->vessel->name . ';' . $lup->disembarkation_date . '<br>';
                }
                else{
                    $temp2 = $temp->last();
                    echo $lup->lname . ', ' . $lup->fname . ';' . $temp2->rank2->abbr . ';' . $temp2->vessel_name . ';' . $temp2->sign_off . '<br>';
                }
            }
        }

<!-- FLEET B ALL ONBOARD HMM CREW -->
$users = User::where('role', 'Applicant')->where('fleet', 'FLEET B')->get();

foreach($users as $user){
    if(isset($user->crew->pro_app) && $user->crew->pro_app->status == "On Board" && $user->crew->pro_app->vessel->principal_id == 256){
        echo $user->lname . ';' . $user->fname . ';' . $user->mname . ';' . $user->crew->civil_status . ';' . $user->crew->pro_app->rank->abbr . ';' . $user->birthday . ';' . $user->crew->pro_app->updated_at . '<br>';
    }
}


<!-- FLEET B ALL ONBOARD CREW WITH US VISA -->

$lucs = LineUpContract::where('status', 'On Board')->where('principal_id', 256)->get();

foreach($lucs as $luc){
    $usv = DocumentId::where('type', 'US-VISA')->where('applicant_id', $luc->applicant_id)->orderBy('issue_date', 'desc')->first();
    
    if($usv == null || $usv->expiry_date < now()->toDateString()){
        echo $luc->rank->abbr . ';' . $luc->applicant->user->namefull . ';' . $luc->joining_date . ';' . $luc->vessel->name . ';' . ($usv ? $usv->expiry_date : "N/A") . '<br>';
    }
}

<!-- ACTIVE TOEI CREW THAT HAS RECORD IN FAIRVIEW -->
DB::enableQueryLog();

$applicants = Applicant::select('applicants.id', 'u.fname', 'u.lname', 'u.contact')
    ->join('users as u', 'u.id', '=', 'applicants.user_id')
    ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? "%%")
    ->get()->keyBy('id');

$applicants->load('sea_service');

$onboard = 0;
$vacation = 0;
$linedup = 0;

foreach($applicants as $applicant){
    $seaServices = $applicant->sea_service;

    // check if ANY of the records has "FAIRVIEW" in manning_agent
    $hasFairview = $seaServices->contains(function ($s) {
        return stripos($s->manning_agent, 'FAIRVIEW') !== false;
    });

    // get the latest record (sign_off if present, else sign_on)
    $ss = $seaServices
        ->filter(function ($s) {
            return $s->sign_off || $s->sign_on;
        })
        ->sortByDesc(function ($s) {
            return $s->sign_off ?: $s->sign_on;
        })
        ->first();

    if($ss && ($ss->sign_off ? ($ss->sign_off->toDateString() >= "2024-05-01") : ($ss->sign_on->toDateString() >= "2023-12-01")) && $hasFairview){
        if($applicant->pro_app->status == "On Board"){
            $onboard++;
        }
        elseif($applicant->pro_app->status == "Vacation"){
            $vacation++;
        }
        else{
            $linedup++;
        }
    }
}

dd($onboard, $vacation, $linedup);

<!-- active/inactive crew by fleet -->
DB::enableQueryLog();

$applicants = Applicant::select('applicants.id', 'u.fname', 'u.lname', 'u.contact')
    ->join('users as u', 'u.id', '=', 'applicants.user_id')
    ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? "%%")
    ->get()->keyBy('id');

$applicants->load('sea_service');

$active = 0;
$inactive = 0;

foreach($applicants as $applicant){
    $ss = $applicant->sea_service
        ->filter(function ($s) {
            return $s->sign_off || $s->sign_on;
        })
        ->sortByDesc(function ($s) {
            return $s->sign_off ?: $s->sign_on;
        })
        ->first();

    if($ss && ($ss->sign_off ? ($ss->sign_off->toDateString() >= "2024-05-01") : ($ss->sign_on->toDateString() >= "2023-12-01"))){
        $active++;
    }
    else{
        $inactive++;
    }
}

dd($active, $inactive);

<!-- CHECK ALL CREW PROMOTED TO OFFICER ON SPECIFIED YEARS. REQUESTED BY FLEET B SIR KIT -->
$users = User::where('role', 'Applicant')->where('fleet', 'FLEET B')->get();

$pro['2023'] = [];
$pro['2024'] = [];
$pro['2025'] = [];

$i = 0;

foreach($users as $user){
    $sss = optional($user->crew)->sea_service;

    if($sss){
        $sss = $sss->filter(function ($item) {
                    return !empty($item->sign_on) && $item->sign_on > '2021-12-31';
                })
                ->sortBy('sign_on');
        $last = null;

        foreach($sss as $ss){
            if($last){
                if(isset($ss->rank2) && ($ss->rank2->order <= $last->order) && ($ss->rank2->id != $last->id) && ($ss->rank2->type == "OFFICER")){
                    $yr = $ss->sign_on->format('Y');

                    if($yr >= 2023){
                        array_push($pro[$yr], ["last" => $last, "new" => $ss, 'user' => $user]);
                    }
                }
            }

            $last = $ss->rank2;
        }

        if($last && isset($user->crew->pro_app) && $user->crew->pro_app->status == "On Board"){
            $cl = $user->crew->current_lineup;

            if(($cl->rank->order <= $last->order) && ($cl->rank->id != $last->id) && ($cl->rank->type == "OFFICER")){
                $yr = $cl->joining_date->format('Y');

                $cl->rank2 = $cl->rank;
                $cl->sign_on = $cl->joining_date;

                if($yr >= 2023){
                    array_push($pro[$yr], ["last" => $last, "new" => $cl, 'user' => $user]);
                }
            }
        }

        $i++;
    }
}

foreach($pro['2023'] as $temp){
    echo $temp['new']->rank2->abbr . ';' . $temp['user']->namefull . ';' . $temp['user']->birthday . ';' . $temp['last']->abbr . ';' . $temp['new']->rank2->abbr . ';' . $temp['new']->sign_on . '<br>';
}

echo "<br>~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~<br>";

foreach($pro['2024'] as $temp){
    echo $temp['new']->rank2->abbr . ';' . $temp['user']->namefull . ';' . $temp['user']->birthday . ';' . $temp['last']->abbr . ';' . $temp['new']->rank2->abbr . ';' . $temp['new']->sign_on . '<br>';
}

echo "<br>~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~<br>";

foreach($pro['2025'] as $temp){
    echo $temp['new']->rank2->abbr . ';' . $temp['user']->namefull . ';' . $temp['user']->birthday . ';' . $temp['last']->abbr . ';' . $temp['new']->rank2->abbr . ';' . $temp['new']->sign_on . '<br>';
}

echo "<br>~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~<br>";

<!-- GET CREW AGE MAX MIN AND MEDIAN PER FLEET REMOVING WITHDRAWN, NFR AND THE LIKES -->
$crews = ProcessedApplicant::select('u.birthday', 'u.fname', 'u.lname', 'processed_applicants.rank_id', 'processed_applicants.status', 'u.fleet', 'processed_applicants.applicant_id')
            ->join('applicants as a', 'a.id', '=', 'processed_applicants.applicant_id')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->whereNull('a.deleted_at')
            ->where('u.fleet', 'TOEI')
            ->where('a.remarks', 'NOT LIKE', '%WITHDRAW%')
            ->where('a.remarks', 'NOT LIKE', '%WD%')
            ->where('a.remarks', 'NOT LIKE', '%POOR%')
            ->where('a.remarks', 'NOT LIKE', '%P&I%')
            ->where('a.remarks', 'NOT LIKE', '%NFR%')
            ->where('a.remarks', 'NOT LIKE', '%AGE%')
            ->where('a.remarks', 'NOT LIKE', '%PROBLEM%')
            ->where('a.remarks', 'NOT LIKE', '%COLLISION%')
            ->get();

$rankList = Rank::pluck('abbr', 'id');

$array = [];

foreach($crews as $crew){
    if(!isset($array[$crew->status][$crew->rank_id])){
        $array[$crew->status][$crew->rank_id] = [];
    }

    if($crew->rank_id){
        array_push($array[$crew->status][$crew->rank_id], $crew);
    }
    else{
        if($crew->applicant->sea_service->count() && isset($crew->applicant->sea_service->last()->rank2)){
            $crew->rank_id = $crew->applicant->sea_service->last()->rank2->id;

            if(!isset($array[$crew->status][$crew->rank_id])){
                $array[$crew->status][$crew->rank_id] = [];
            }

            array_push($array[$crew->status][$crew->rank_id], $crew);
        }
        else{
            echo $crew->lname . '<br>';
        }
    }
}

echo '<br>';

foreach($array as $status => $ranks){
    echo "-------------" . $status . "---------------" . '<br>';

    foreach($ranks as $rank => $crews){
        if($rank){
            $high = 0;
            $low = 100;

            foreach($crews as $crew){
                $age = now()->parse($crew->birthday)->age;
                if($age > $high){
                    $high = $age;
                }

                if($age < $low){
                    $low = $age;
                }

                if($age == 63){
                    dd($crew);
                }
            }
            $median = ($high + $low) / 2;
            echo "$rankList[$rank];$high;$low;$median<br>";
        }

        echo "\n\n\n";
    }

    echo "\n\n\n";
}

<!-- GET ALL CREW WITH SPECIFIC VESSEL EXPERIENCE -->
$applicants = SeaService::where('vessel_type', 'LIKE', '%WOOD%')
                ->join('applicants as a', 'a.id', '=', 'sea_services.applicant_id')
                ->join('users as u', 'u.id', '=', 'a.user_id')
                ->whereNull('a.deleted_at')
                ->where('u.fleet', 'TOEI')
                ->where('a.remarks', 'NOT LIKE', '%WITHDRAW%')
                ->where('a.remarks', 'NOT LIKE', '%WD%')
                ->where('a.remarks', 'NOT LIKE', '%POOR%')
                ->where('a.remarks', 'NOT LIKE', '%P&I%')
                ->where('a.remarks', 'NOT LIKE', '%NFR%')
                ->where('a.remarks', 'NOT LIKE', '%AGE%')
                ->where('a.remarks', 'NOT LIKE', '%PROBLEM%')
                ->where('a.remarks', 'NOT LIKE', '%COLLISION%')
                ->get()
                ->groupBy('applicant_id');

$array = [];

// IF COUNT ONLY
// foreach($applicants as $sss){
//     $ss = $sss->sortByDesc('sign_off')->first();

//     if(!isset($array[$ss->rank])){
//         $array[$ss->rank] = 0;
//     }

//     $array[$ss->rank]++;
// }

// dd($array);

// IF WITH CREW NAME
foreach($applicants as $sss){
    $ss = $sss->sortByDesc('sign_off')->first();

    if(!isset($array[$ss->rank])){
        $array[$ss->rank] = [];
    }

    array_push($array[$ss->rank], $ss);
}

$ranks = [
    "MASTER",
    "CHIEF OFFICER",
    "2ND OFFICER",
    "3RD OFFICER",
    "BOSUN",
    "ABLE SEAMAN",
    "ORDINARY SEAMAN"
];

foreach($ranks as $rank){
    foreach($array[$rank] as $crew){
        echo $crew->rank2->abbr . ';' . $crew->lname . ', ' . $crew->fname . ';' . $crew->sign_off . '<br>';
    }
}