<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\User;
use App\Models\{ProcessedApplicant, Applicant, LineUpContract};
use App\Models\{EducationalBackground, FamilyData, SeaService};
use App\Models\{Vessel, Rank, Principal, Wage};
use App\Models\{DocumentFlag, DocumentId, DocumentLC, DocumentMedCert, DocumentMed, DocumentMedExp};

use App\Models\{AuditTrail, Statistic, File as Fileszxc};

use Image;
use Browser;
use DB;
use File;

use App\Exports\AllApplicant;
// use App\Exports\Application;
use Maatwebsite\Excel\Facades\Excel;

// PDF CLASSES
use App\Exports\PDFExport;
use PDF;

class ApplicationsController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Encoder/Principal/Cadet/Crewing Manager/Crewing Officer/Training/Processing');
    }

    public function index(Request $req){
        $principals = Principal::select('id', 'slug', 'name', 'fleet')->where('active', 1)->get();
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();
        // $vessels = Vessel::select('id', 'name')->where('status', 'ACTIVE')->get();

        return $this->_view('index', [
            'title' => 'Crew Database',
            'principals' => $principals,
            'categories' => $ranks->groupBy('category'),
            // 'vessels' => $vessels
        ]);
    }

    public function index2(Request $req){
        // $principals = Principal::select('id', 'slug', 'name', 'fleet')->where('active', 1)->get();
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();
        // $vessels = Vessel::select('id', 'name')->where('status', 'ACTIVE')->get();

        return $this->_view('index2', [
            'title' => 'Crew Database',
            // 'principals' => $principals,
            'categories' => $ranks->groupBy('category'),
            // 'vessels' => $vessels
        ]);
    }

    public function create(){
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();
        $issuers = array_merge(
           DocumentId::pluck('issuer')->toArray(),
           DocumentLC::pluck('issuer')->toArray()
        );
               
        return $this->_view('create', [
            'title'         => 'Add Crew',
            'categories'    => $ranks->groupBy('category'),
            'issuers'       => collect($issuers)->unique()->toArray(),
            'regulations'   => DocumentLC::where('regulation', '!=', "[]")->pluck('regulation')->unique()->toArray(),
            'religions'     => Applicant::pluck('religion')->unique(),
            'schools'       => EducationalBackground::pluck('school')->unique()
        ]);
    }

    public function getIssuers(){
        $issuers = array_merge(
            DocumentId::pluck('issuer')->toArray(),
            DocumentLC::pluck('issuer')->toArray()
        );

        echo json_encode(collect($issuers)->unique());
    }

    public function getRanks(){
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();

        echo json_encode($ranks->groupBy('category'));
    }

    public function getRegulations(){
        $tempRegulations = DocumentLC::distinct()->pluck('regulation')->toArray();
        $regulations = array();

        foreach($tempRegulations as $tempRegulation){
            $temps = json_decode($tempRegulation);
            foreach($temps as $temp){
                array_push($regulations, $temp);
            }
        }

        echo json_encode(collect($regulations)->unique());
    }

    public function get2(Request $req){
        $applicant = Applicant::select($req->cols);
        $applicant->join('processed_applicants as pa', 'pa.applicant_id', '=', 'applicants.id');
        $applicant->join('users as u', 'u.id', '=', 'applicants.user_id');

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $applicant = $applicant->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $applicant = $applicant->where($req->where[0], $req->where[1]);
        }

        if($req->where2){
            $applicant = $applicant->where($req->where2[0], $req->where2[1]);
        }

        if($req->where3){
            $applicant = $applicant->where($req->where3[0], $req->where3[1]);
        }

        $applicant = $applicant->get();

        // IF HAS LOAD
        if($applicant->count() && $req->load){
            foreach($req->load as $table){
                $applicant->load($table);
            }
        }

        // IF HAS GROUP
        if($req->group){
            $applicant = $applicant->groupBy($req->group);
        }

        echo json_encode($applicant);
    }

    public function edit(Applicant $applicant){
        $applicant->load('user');
        $applicant->load('educational_background');
        $applicant->load('family_data');
        $applicant->load('document_id');
        $applicant->load('document_med_cert');
        $applicant->load('document_med');
        // $applicant->load('sea_service');
        // $applicant->load('document_flag');
        // $applicant->load('document_lc');
        $order = ['Father', 'Mother', 'Spouse', 'Partner', 'Son', 'Daughter', 'Beneficiary'];
        
        $applicant->family_data = $applicant->family_data->sortBy(function($model) use ($order){
            return array_search($model->type, $order);
        });
        
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();
        $issuers = array_merge(
            DocumentId::pluck('issuer')->toArray(),
            DocumentLC::pluck('issuer')->toArray()
        );

        $tempRegulations = DocumentLC::distinct()->pluck('regulation')->toArray();
        $regulations = array();

        foreach($tempRegulations as $tempRegulation){
            $temps = json_decode($tempRegulation);
            foreach($temps as $temp){
                array_push($regulations, $temp);
            }
        }

        // IF HAS 'EDIT' VALUE, WILL LOAD SCRIPT THAT WILL POPULATE THE FIELD WITH APPLICANT DETAILS FOR EDITING
        return $this->_view('create', [
            'title'         => 'Edit Crew Data',
            'categories'    => $ranks->groupBy('category'),
            'issuers'       => collect($issuers)->unique()->toArray(),
            'regulations'   => collect($regulations)->unique()->toArray(),
            'applicant'     => $applicant,
            'religions'     => Applicant::pluck('religion')->unique(),
            'schools'       => EducationalBackground::pluck('school')->unique(),
            'edit'          => true
        ]);
    }

    public function update(Request $req, $id){
        // SAVE APPLICANT
        $applicant = collect($req->only([
            'provincial_address','provincial_contact',
            'birth_place','religion','age','waistline',
            'shoe_size','height','weight','bmi','blood_type',
            'civil_status', 'tin', 'sss', 'eye_color', 'clothes_size'
        ]));

        $applicant['provincial_address'] = strtoupper($applicant['provincial_address']);
        $applicant['birth_place'] = strtoupper($applicant['birth_place']);
        $applicant['religion'] = strtoupper($applicant['religion']);

        $applicant = Applicant::where('user_id', $id)->update($applicant->all());

        $user = collect($req->only([
            'fname','mname','lname', 'suffix',
            'birthday','address','contact',
            'email','gender'
        ]));

        $user['fname'] = strtoupper($user['fname']);
        $user['mname'] = strtoupper($user['mname']);
        $user['lname'] = strtoupper($user['lname']);
        $user['suffix'] = strtoupper($user['suffix']);

        if($req->hasFile('avatar')){
            // UPLOAD AVATAR
            $image = $req->file('avatar');
            $avatar = Image::make($image);

            $name = $req->fname . '_' . $req->lname . '_avatar.'  . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/');

            $name = str_replace('Ñ', 'N', $name);
            $avatar->resize(209,196);
            $avatar->save($destinationPath . $name);

            $user->put('avatar', 'uploads/' . $name);
        }

        // SAVE USER
        $user = User::where('id', $id)->update($user->all());

        $applicant = Applicant::where('user_id', $id)->first();
        $applicant->load('educational_background');
        $applicant->load('family_data');
        $applicant->load('sea_service');

        $applicant->load('document_id');
        $applicant->load('document_flag');
        $applicant->load('document_lc');
        $applicant->load('document_med_cert');
        $applicant->load('document_med');

        // SAVE FAMILY DATA
        $fd = json_decode($req->fd);
        foreach($fd as $data){
            $data->applicant_id = $applicant->id;
            $data->birthday = $data->birthday == "" ? null : $data->birthday;
            $data->age = $data->birthday == "" ? null : now()->parse($data->birthday)->age;

            if(isset($data->id)){
                FamilyData::where('id', $data->id)->update((array)$data);
            }
            else{
                FamilyData::create((array)$data);
            }
        }

        // DELETE FAMILY DATA
        $this->clearData($applicant->family_data, $req->fd, 'family_datas');

        // SAVE SEA SERVICE
        $ss = json_decode($req->ss);
        foreach($ss as $data){
            $data->applicant_id = $applicant->id;
            $data->sign_on = $data->sign_on == "" ? null : $data->sign_on;
            $data->sign_off = $data->sign_off == "" ? null : $data->sign_off;
            $data->previous_salary = $data->previous_salary == "" ? null : $data->previous_salary;

            if(isset($data->id)){
                SeaService::where('id', $data->id)->update((array)$data);
            }
            else{
                SeaService::create((array)$data);
            }

            if(Vessel::where('imo', $data->imo)->count() == 0){
            // if(Vessel::where('name', $data->vessel_name)->count() == 0){
                $principal = Principal::where('name', $data->principal)->get();
                if($principal->count()){
                    Vessel::create([
                        'principal_id'  => $principal->first()->id,
                        'manning_agent' => $data->manning_agent,
                        'name'          => $data->vessel_name,
                        'flag'          => $data->flag,
                        'type'          => $data->vessel_type,
                        'engine'        => $data->engine_type,
                        'gross_tonnage' => $data->gross_tonnage,
                        'BHP'           => $data->bhp_kw,
                        'trade'         => $data->trade,
                        'imo'           => $data->imo
                    ]);
                }
                else{
                    $name = $data->principal;

                    $user = new User();
                    $user->fname = $name;
                    $user->username = strtolower(camel_case($name));
                    $user->role = 'Principal';
                    $user->applicant = false;
                    $user->email = camel_case(strtolower($name)) . '@solpia.email';
                    $user->email_verified_at = now()->toDateTimeString();
                    $user->password = '123456';

                    $user->mname = "";
                    $user->lname = "";
                    $user->birthday = now();
                    $user->gender = "";
                    $user->address = "";
                    $user->contact = "";

                    $user->save();

                    $principal = new Principal();
                    $principal->user_id = $user->id;
                    $principal->name = $name;
                    $principal->slug = camel_case(strtolower($name));
                    $principal->save();

                    Vessel::create([
                        'principal_id'  => $principal->id,
                        'manning_agent' => $data->manning_agent,
                        'name'          => $data->vessel_name,
                        'flag'          => $data->flag,
                        'type'          => $data->vessel_type,
                        'engine'        => $data->engine_type,
                        'gross_tonnage' => $data->gross_tonnage,
                        'BHP'           => $data->bhp_kw,
                        'trade'         => $data->trade,
                        'imo'           => $data->imo
                    ]);
                }
            }
        }

        // DELETE SEA SERVICE
        $this->clearData($applicant->sea_service, $req->ss, 'sea_services');

        // SAVE EDUCATIONAL BACKGROUND
        $eb = json_decode($req->eb);
        foreach($eb as $data){
            $data->applicant_id = $applicant->id;

            if(isset($data->id)){
                EducationalBackground::where('id', $data->id)->update((array)$data);

            }
            else{
                EducationalBackground::create((array)$data);
            }
        }

        // DELETE EDUCATIONAL BACKGROUND
        $this->clearData($applicant->educational_background, $req->eb, 'educational_backgrounds');

        // SAVE DOCUMENT ID
        $docu_id = json_decode($req->docu_id);
        foreach($docu_id as $data){
            $data->type = $data->type == "SEAMAN BOOK" ? "SEAMAN'S BOOK" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;

            if(isset($data->id)){
                DocumentId::where('id', $data->id)->update((array)$data);
            }
            else{
                DocumentId::create((array)$data);
            }
        }

        // DELETE DOCUMENT ID
        $this->clearData($applicant->document_id, $req->docu_id, 'document_ids');

        // SAVE DOCUMENT FLAG
        $docu_flag = json_decode($req->docu_flag);
        foreach($docu_flag as $data){
            $data->type = $data->type == "SHIP COOK ENDORSEMENT" ? "SHIP'S COOK ENDORSEMENT" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;

            if(isset($data->id)){
                DocumentFlag::where('id', $data->id)->update((array)$data);
            }
            else{
                DocumentFlag::create((array)$data);
            }
        }

        // DELETE DOCUMENT FLAG
        $this->clearData($applicant->document_flag, $req->docu_flag, 'document_flags');

        // SAVE DOCUMENT LC
        $docu_lc = json_decode($req->docu_lc);
        foreach($docu_lc as $data){
            $data->type = $data->type == "SAFETY OFFICER TRAINING COURSE" ? "SAFETY OFFICER'S TRAINING COURSE" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->regulation = json_encode($data->regulation);
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;

            if(isset($data->id)){
                DocumentLC::where('id', $data->id)->update((array)$data);
            }
            else{
                DocumentLC::create((array)$data);
            }
        }

        // DELETE DOCUMENT LC
        $this->clearData($applicant->document_lc, $req->docu_lc, 'document_l_cs');

        // SAVE DOCUMENT MED CERT
        $docu_med_cert = json_decode($req->docu_med_cert);
        foreach($docu_med_cert as $data){
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;

            if(isset($data->id)){
                DocumentMedCert::where('id', $data->id)->update((array)$data);
            }
            else{
                DocumentMedCert::create((array)$data);
            }
        }

        // DELETE DOCUMENT MED CERT
        $this->clearData($applicant->document_med_cert, $req->docu_med_cert, 'document_med_certs');

        // SAVE DOCUMENT MED
        $docu_med = json_decode($req->docu_med);
        foreach($docu_med as $data){
            $data->applicant_id = $applicant->id;
            $data->year = $data->year == "" ? null : $data->year;

            if(isset($data->id)){
                DocumentMed::where('id', $data->id)->update((array)$data);
            }
            else{
                DocumentMed::create((array)$data);
            }
        }

        // DELETE DOCUMENT MED
        $this->clearData($applicant->document_med, $req->document_med, 'document_meds');

        if(true){
            $req->session()->flash('success', 'Applicant Successfully Updated.');
        }
        else{
            $req->session()->flash('error', 'There was a problem updating the applicant. Try again.');
        }

        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "updated " . $req->lname . ', ' . $req->fname,
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        return redirect()->route('applications.index');
        // return back();
    }

    public function clearData($old, $new, $table){
        $a = $old->pluck('id')->toArray();
        $b = collect(json_decode($new))->pluck('id')->toArray();
        $ids = array_diff($a, array_intersect($a, $b));

        foreach($ids as $id){
            DB::table($table)->where('id', $id)->update(['deleted_at' => now()]);
        }
    }

    public function exportAll(){
        return Excel::download(new AllApplicant, 'Applicants.xlsx');
    }

    public function exportApplication(Applicant $applicant, $type = null, Request $req){
        if(!$type){
            $type = Principal::find(ProcessedApplicant::where('applicant_id', $applicant->id)->first()->principal_id)->slug;
        }

        $applicant->load('user');
        $applicant->load(['educational_background' => function ($query) {
            $query->orderBy('year', 'desc');
        }]);
        $applicant->load('family_data');
        $applicant->load('sea_service');

        $applicant->load('document_id');
        $applicant->load('document_flag');
        $applicant->load('document_lc');
        $applicant->load('document_med_cert');
        $applicant->load('document_med');

        $applicant->ranks = Rank::pluck('abbr', 'name');
        $applicant->ranks2 = Rank::all()->groupBy('id');
        $applicant->ranks[''] = '';

        if($applicant->document_flag->count()){
            $applicant->flagRank = Rank::find($applicant->document_flag->last()->rank);
        }

        foreach(['document_id', 'document_flag', 'document_lc', 'document_med', 'document_med_cert' ] as $docuType){
            foreach($applicant->$docuType as $key => $data){

                // if($docuType == 'document_flag'){
                //     $temp = $data->country;
                // }
                                       //FOR DOCS WITH NO
                if(isset($data->no)){
                    if($data->no == ""){
                        $applicant->$docuType->forget($key);
                        continue;
                    }
                }
                elseif(isset($data->number)){
                    if($docuType == "document_med_cert"){
                        if(str_starts_with($data->type, 'MEDICAL CERTIFICATE')){
                            if($data->expiry_date == ""){
                                $applicant->$docuType->forget($key);
                                continue;
                            }
                        }
                        elseif(!str_starts_with($data->type, 'COVID') && !str_contains($data->type, 'MMR')){
                            if($data->number == ""){
                                $applicant->$docuType->forget($key);
                                continue;
                            }
                        }
                    }
                    elseif($data->number == ""){
                        $applicant->$docuType->forget($key);
                        continue;
                    }
                }

                // if($docuType == 'document_med'){
                //     $temp = $data->case;
                // }
                // else{
                    $temp = $data->type;
                // }


                if(isset($data->expiry_date)){
                    if($data->expiry_date == "" || $data->expiry_date == null){
                        $data->expiry_date == "UNLIMITED";
                    }
                }

                // FOR COC ? // GET LATEST DOCUMENT OF SAME TYPE
                if(isset($applicant->$docuType->$temp)){
                    if($data->issue_date > $applicant->$docuType->$temp->issue_date){
                        $applicant->$docuType->$temp = $data;
                        continue;
                    }
                }

                if(!isset($applicant->$docuType->$temp)){
                    $applicant->$docuType->$temp = $data;
                }
                else{
                    $size = 0;
                    if(is_array($applicant->$docuType->$temp)){
                        $size = sizeof($applicant->$docuType->$temp);
                    }
                    $temp .= $size;
                    $applicant->$docuType->$temp = $data;
                }

                // $applicant->$docuType->$temp = $data;
            }
        }

        // REMOVE DOCUMENTS WITHOUT NUMBER
        // foreach(['document_id', 'document_flag', 'document_lc'] as $type){
        //     foreach($applicant->$type as $key => $data){
        //         $type2 = $data->type;
        //         $col = 'number';

        //         if($type == 'document_lc'){
        //             $col = 'no';
        //         }

        //         if($applicant->$type->$type2->$col == ""){
        //             $applicant->$type->$type2->forget($key);
        //         }
        //     }
        // }

        // IF NAME IS EMPTY, REMOVE
        $order = ['Father', 'Mother', 'Spouse', 'Son', 'Daughter', 'Beneficiary', 'Partner'];
        
        $applicant->family_data = $applicant->family_data->sortBy(function($model) use ($order){
            return array_search($model->type, $order);
        });


        foreach($applicant->family_data as $key => $value){
            if($value->lname == ""){
                $applicant->family_data->forget($key);
            }
        }

        // FILTER FAMILY DATA. REMOVE BENEFICIARY (SIR JEFF)
        $applicant->family_data = $applicant->family_data->filter(function($fd){
            return $fd->type != "Beneficiary";
        });

        // IF FAMILY_DATA IS ODD ADD EMPTY TO FILL
        if($applicant->family_data->count() % 2 != 0){
            $fd = new FamilyData;
            $fd->type = "";
            $fd->name = "";
            $fd->age = "";
            $fd->birthday = now()->create(0, 1, 1);
            $fd->address = "";
            $fd->occupation = "";

            $applicant->family_data->push($fd);
        }

        $temp = ProcessedApplicant::where('applicant_id', $applicant->id)->first();
        if($temp->status == "Lined-Up" || $temp->status == "On Board"){
            $applicant->rank = Rank::find($temp->rank_id);
            $applicant->vessel = Vessel::find($temp->vessel_id);
        }
        else{
            if($applicant->sea_service->count()){
                $name = $applicant->sea_service->sortByDesc('sign_off')->first()->rank;
                $applicant->rank = Rank::where('name', $name)->first();
            }
            elseif($applicant->document_flag->count() || isset($applicant->flagRank)){
                $applicant->rank = $applicant->flagRank;
            }
            else{
                $applicant->rank = null;
            }
        }

        // SORT
        if(in_array($type, ['western', 'toei'])){
            $applicant->sea_service = $applicant->sea_service->sortBy('sign_off');

            if($applicant->pro_app->status == "On Board" && $type == "toei"){
                $applicant->sea_service->take(11);

                $lup = $applicant->line_up_contracts->last();

                $temp2 = new SeaService();
                $temp2->vessel_name = $lup->vessel->name;
                $temp2->vessel_type = $lup->vessel->type;
                $temp2->gross_tonnage = $lup->vessel->gross_tonnage;
                $temp2->manning_agent = "SOLPIA MARINE";
                $temp2->sign_on = $lup->joining_date;
                $temp2->flag = $lup->vessel->flag;
                $temp2->crew_nationality = "FULL CREW";
                $temp2->rank = $lup->rank->name;
                $temp2->bhp_kw = $lup->vessel->bhp_kw;
                $temp2->trade = $lup->vessel->trade;
                $temp2->ship_manager = $lup->vessel->ship_manager;
                $temp2->principal = $lup->vessel->principal->name;
                $temp2->sign_off = null;
                $temp2->remarks = "On Board";

                $applicant->sea_service->push($temp2);
            }

            if($type == "western" && $temp->status != "Vacation" && $temp->vessel->flag == "LIBERIA"){
                $type = "westernLiberia";
            }
        }
        else{
            $applicant->sea_service = $applicant->sea_service->sortByDesc('sign_off');
        }
        // END SORT

        // ARRANGE KEYS AFTER SORT
        $temp = [];

        foreach($applicant->sea_service as $ss){
            array_push($temp, $ss);
        }
        $applicant->sea_service = collect($temp);
        // END

        // FIX MINIMUM VESSELS
        $minVessels = 0;

        if(in_array($type, ['kosco', 'imsco', 'ckMaritime'])){
            $minVessels = 12;
        }
        elseif(in_array($type, ['klcsmBulk', 'harbourLink'])){
            $minVessels = 10;
        }
        else{
            $minVessels = 5;
        }

        if(sizeof($applicant->sea_service) < $minVessels){
            for($i = sizeof($applicant->sea_service); $i < $minVessels; $i++){
                $applicant->sea_service->push((object)[
                    'vessel_name' => null,
                    'previous_salary' => null,
                    'sign_on' => null,
                    'sign_off' => null,
                    'rank' => null,
                    'vessel_type' => null,
                    'gross_tonnage' => null,
                    'manning_agent' => null,
                    'remarks' => null,
                    'engine_type' => null,
                    'bhp_kw' => null,
                    'principal' => null,
                    'trade' => null,
                    'flag' => null,
                    'owner' => null,
                    'crew_nationality' => null,
                    'bhp' => null
                ]);
            }
        }

        if(isset($req->ecdises)){
            $applicant->ecdises = json_decode($req->ecdises);
        }

        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "exported " . $applicant->user->lname . ', ' . $applicant->user->fname,
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        $smtech = [
            "M/V CMB VAN DIJCK", 
            "M/V MARITIME LONGEVITY", 
            "M/V MARITIME KING", 
            "M/V ULTRA REGINA"
        ];

        //KSSLINE USE HMM FORMAT
        if($type == "kssline"){
            $type = "hmm";
        }

        if(isset($applicant->vessel) && in_array($applicant->vessel->name, $smtech)){
            $type = "smtech";
        }

        $class = "App\\Exports\\" . ucfirst($type);

        Statistic::where('name', 'export')->increment('count');
        $pname = $type == "western" ? "NITTA_TOEI" : $type;

        // $defaultName = $applicant->user->fname . '_' . $applicant->user->lname . ' Application - ' . $pname . '.xlsx';
        $rAbbr = isset($applicant->rank) ? str_replace('/', '', $applicant->rank->abbr) : null;

        $fn = $req->fn ?? "BIODATA";
        $defaultName = $rAbbr . ' ' . $applicant->user->lname . ', ' . $applicant->user->fname . " - $fn.xlsx";

        if($type == "KSSLine"){
            $fn = "Qualification Checklist";
        }

        return Excel::download(new $class($applicant, $type), $defaultName);
    }

    public function exportLineUpApplication(ProcessedApplicant $applicant, $type){
        $applicant->load('applicant');
        $applicant->load('vessel');
        
        $applicant->ranks = Rank::pluck('abbr', 'name');
        $applicant->ranks[''] = '';

        // move $applicant->applicant properties to $applicant
        foreach(array_keys($applicant->applicant->toArray()) as $property){
            if(!in_array($property, ['id', 'created_at', 'updated_at', 'deleted_at'])){
                $applicant->{$property} = $applicant->applicant->{$property};
            }
        }

        unset($applicant->applicant);

        $applicant->user                    = User::where('id', $applicant->applicant->user_id)->first();
        $applicant->educational_background  = EducationalBackground::where('applicant_id', $applicant->applicant_id)->get();
        $applicant->family_data             = FamilyData::where('applicant_id', $applicant->applicant_id)->get();
        $applicant->sea_service             = SeaService::where('applicant_id', $applicant->applicant_id)->get();
        $applicant->document_id             = DocumentId::where('applicant_id', $applicant->applicant_id)->get();
        $applicant->document_flag           = DocumentFlag::where('applicant_id', $applicant->applicant_id)->get();
        $applicant->document_lc             = DocumentLC::where('applicant_id', $applicant->applicant_id)->get();
        $applicant->document_med        = DocumentMed::where('applicant_id', $applicant->applicant_id)->get();
        $applicant->document_med_cert       = DocumentMedCert::where('applicant_id', $applicant->applicant_id)->get();

        foreach(['document_id', 'document_flag', 'document_lc', 'document_med', 'document_med_cert'] as $docuType){
            foreach($applicant->$docuType as $key => $data){

                if(isset($data->no)){
                    if($data->no == ""){
                        $applicant->$docuType->forget($key);
                        continue;
                    }
                }
                elseif(isset($data->number)){
                    if($data->number == ""){
                        $applicant->$docuType->forget($key);
                        continue;
                    }
                }

                $temp = $data->type;

                if(isset($data->expiry_date)){
                    if($data->expiry_date == "" || $data->expiry_date == null){
                        $data->expiry_date == "UNLIMITED";
                    }
                }

                $applicant->$docuType->$temp = $data;
            }
        }

        // IF NAME IS EMPTY, REMOVE
        foreach($applicant->family_data as $key => $value){
            if($value->lname == ""){
                $applicant->family_data->forget($key);
            }
        }

        // IF FAMILY_DATA IS ODD ADD EMPTY TO FILL
        if($applicant->family_data->count() % 2 != 0){
            $fd = new FamilyData;
            $fd->type = "";
            $fd->name = "";
            $fd->age = "";
            $fd->birthday = now()->create(0, 1, 1);
            $fd->address = "";
            $fd->occupation = "";

            $applicant->family_data->push($fd);
        }

        $class = "App\\Exports\\" . ucfirst($type);

        $pname = $type == "western" ? "NITTA_TOEI" : $type;
        return Excel::download(new $class($applicant, $type), $applicant->user->fname . '_' . $applicant->user->lname . ' Application - ' . $pname . '.xlsx');
    }

    public function store(Request $req){
        $user = collect($req->only([
            'fname','mname','lname', 'suffix',
            'birthday','address','contact',
            'email','gender'
        ]))->put('password', '123456')->put('role', 'Applicant');

        $user['fname'] = strtoupper($user['fname']);
        $user['mname'] = strtoupper($user['mname']);
        $user['lname'] = strtoupper($user['lname']);
        $user['suffix'] = strtoupper($user['suffix']);
        $user['applicant'] = auth()->user()->status;

        if($user['applicant']){
            $user['fleet'] = auth()->user()->fleet;
        }

        // UPLOAD AVATAR
        if($req->hasFile('avatar')){
            $image = $req->file('avatar');
            $avatar = Image::make($image);

            $name = $req->fname . '_' . $req->lname . '_avatar.'  . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/');

            $avatar->resize(209,196);
            $name = str_replace('Ñ', 'N', $name);
            $avatar->save($destinationPath . $name);
            $user->put('avatar', 'uploads/' . $name);
        }
        else{
            $user->put('avatar', 'images/default_avatar.jpg');
        }


        // SAVE USER
        $user = User::create($user->all());

        // SAVE APPLICANT
        $applicant = collect($req->only([
            'provincial_address','provincial_contact',
            'birth_place','religion','age','waistline',
            'shoe_size','height','weight','bmi','blood_type',
            'civil_status', 'tin', 'sss', 'eye_color', 'clothes_size'
        ]))->put('user_id', $user->id);

        $applicant['provincial_address'] = strtoupper($applicant['provincial_address']);
        $applicant['birth_place'] = strtoupper($applicant['birth_place']);
        $applicant['religion'] = strtoupper($applicant['religion']);

        $applicant = Applicant::create($applicant->all());

        // SAVE FAMILY DATA
        $fd = json_decode($req->fd);
        foreach($fd as $data){
            $data->applicant_id = $applicant->id;
            $data->birthday = $data->birthday == "" ? null : $data->birthday;
            $data->age = $data->birthday == "" ? null : now()->parse($data->birthday)->age;
            FamilyData::create((array)$data);
        }

        // SAVE SEA SERVICE
        $ss = json_decode($req->ss);
        foreach($ss as $data){
            $data->applicant_id = $applicant->id;
            $data->sign_on = $data->sign_on == "" ? null : $data->sign_on;
            $data->sign_off = $data->sign_off == "" ? null : $data->sign_off;
            $data->previous_salary = $data->previous_salary == "" ? null : $data->previous_salary;

            SeaService::create((array)$data);
            
            if(Vessel::where('imo', $data->imo)->count() == 0){
            // if(Vessel::where('name', $data->vessel_name)->count() == 0){
                $principal = Principal::where('name', $data->principal)->get();
                if($principal->count()){
                    Vessel::create([
                        'principal_id'  => $principal->first()->id,
                        'manning_agent' => $data->manning_agent,
                        'name'          => $data->vessel_name,
                        'flag'          => $data->flag,
                        'type'          => $data->vessel_type,
                        'engine'        => $data->engine_type,
                        'gross_tonnage' => $data->gross_tonnage,
                        'BHP'           => $data->bhp_kw,
                        'trade'         => $data->trade,
                        'imo'           => $data->imo
                    ]);
                }
                else{
                    $name = $data->principal;

                    $user = new User();
                    $user->fname = $name;
                    $user->username = strtolower(camel_case($name));
                    $user->role = 'Principal';
                    $user->applicant = false;
                    $user->email = camel_case(strtolower($name)) . '@solpia.email';
                    $user->email_verified_at = now()->toDateTimeString();
                    $user->password = '123456';

                    $user->mname = "";
                    $user->lname = "";
                    $user->birthday = now();
                    $user->gender = "";
                    $user->address = "";
                    $user->contact = "";

                    $user->save();

                    $principal = new Principal();
                    $principal->user_id = $user->id;
                    $principal->name = $name;
                    $principal->slug = camel_case(strtolower($name));
                    $principal->save();

                    Vessel::create([
                        'principal_id'  => $principal->id,
                        'manning_agent' => $data->manning_agent,
                        'name'          => $data->vessel_name,
                        'flag'          => $data->flag,
                        'type'          => $data->vessel_type,
                        'engine'        => $data->engine_type,
                        'gross_tonnage' => $data->gross_tonnage,
                        'BHP'           => $data->bhp_kw,
                        'trade'         => $data->trade,
                        'imo'           => $data->imo
                    ]);
                }
            }
        }

        // SAVE EDUCATIONAL BACKGROUND
        $eb = json_decode($req->eb);
        foreach($eb as $data){
            $data->applicant_id = $applicant->id;
            EducationalBackground::create((array)$data);
        }

        // SAVE DOCUMENT ID
        $docu_id = json_decode($req->docu_id);
        foreach($docu_id as $data){
            $data->type = $data->type == "SEAMAN BOOK" ? "SEAMAN'S BOOK" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;
            DocumentId::create((array)$data);
        }

        // SAVE DOCUMENT FLAG
        $docu_flag = json_decode($req->docu_flag);
        foreach($docu_flag as $data){
            $data->type = $data->type == "SHIP COOK ENDORSEMENT" ? "SHIP'S COOK ENDORSEMENT" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;
            DocumentFlag::create((array)$data);
        }

        // SAVE DOCUMENT LC
        $docu_lc = json_decode($req->docu_lc);
        foreach($docu_lc as $data){
            $data->type = $data->type == "SAFETY OFFICER TRAINING COURSE" ? "SAFETY OFFICER'S TRAINING COURSE" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->regulation = json_encode($data->regulation);
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;
            DocumentLC::create((array)$data);
        }

        // SAVE DOCUMENT MED CERT
        $docu_med_cert = json_decode($req->docu_med_cert);
        foreach($docu_med_cert as $data){
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;
            DocumentMedCert::create((array)$data);
        }

        // SAVE DOCUMENT MED
        $docu_med = json_decode($req->docu_med);
        foreach($docu_med as $data){
            $data->applicant_id = $applicant->id;
            $data->year = $data->year == "" ? null : $data->year;
            DocumentMed::create((array)$data);
        }

        ProcessedApplicant::create([
            'applicant_id' => $applicant->id,
            'status' => 'Vacation'
        ]);

        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "encoded " . $user['lname'] . ', ' . $user['fname'],
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        if(true){
            $req->session()->flash('success', 'Applicant Successfully Added.');
            return redirect()->route('applications.index');
        }
        else{
            $req->session()->flash('error', 'There was a problem adding the applicant. Try again.');
            return back();
        }
    }

    public function lineUp(Request $req){
        $id = $req->applicant_id;
        Applicant::where('id', $id)->update(['status' => 'Lined-Up']);
        echo ProcessedApplicant::where('applicant_id', $id)->update(array_merge($req->all(), ['status' => 'Lined-Up']));
    }

    public function updateData(Request $req){
        echo Applicant::where('id', $req->id)->update($req->except('_token'));
    }

    public function getVesselCrew(Request $req, $id = null){
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();

        $linedUps = ProcessedApplicant::where('processed_applicants.vessel_id', $id ?? $req->id)
                        ->where('processed_applicants.status', 'Lined-Up')
                        ->join('applicants as a', 'a.id', '=', 'processed_applicants.applicant_id')
                        ->join('users as u', 'u.id', '=', 'a.user_id')
                        ->join('ranks as r', 'r.id', '=', 'processed_applicants.rank_id')
                        ->select('processed_applicants.*', 'a.user_id', 'a.remarks', 'u.fname', 'u.lname', 'u.mname', 'u.suffix', 'u.birthday', 'r.abbr', 'a.birth_place', 'r.order')
                        ->get();

        // SORT
        $linedUps = $linedUps->sortBy('order');
        $linedUps->load('applicant.document_med_cert');
        $linedUps->load('applicant.document_id');
        $linedUps->load('applicant.sea_service');
        // dd($linedUps->toArray());

        foreach($linedUps as $linedUp){
            $temp = $linedUp->applicant->document_id;
            $linedUp->covidVaccines = $linedUp->applicant->document_med_cert->where('type', 'LIKE' ,'%COVID%');

            $linedUp->age = now()->parse($linedUp->birthday)->diff(now())->format('%y');
            $linedUp->status2 = "NEW-HIRE";

            foreach($temp as $docu){
                if($docu->type != ""){
                    $linedUp->{$docu->type} = $docu->expiry_date;
                    $linedUp->{$docu->type . 'i'} = $docu->issue_date;
                    $linedUp->{$docu->type . 'n'} = $docu->number;
                }
            }
            
            $sea_services = $linedUp->applicant->sea_service;
            foreach($sea_services as $service){
                if(strpos(strtoupper($service->manning_agent), 'SOLPIA') !== false){
                    $linedUp->status2 = 'EX-CREW';
                }
            }
        }

        // END OF LINEDUPS
        // START OF ONBOARDS

        $crews = LineUpContract::where('vessel_id', $id ?? $req->id)
                                ->where('line_up_contracts.status','On Board')
                                ->join('applicants as a', 'a.id', '=', 'line_up_contracts.applicant_id')
                                ->join('users as u', 'u.id', '=', 'a.user_id')
                                ->join('ranks as r', 'r.id', '=', 'line_up_contracts.rank_id')
                                ->select('line_up_contracts.*', 'a.user_id', 'a.remarks', 'u.fname', 'u.lname', 'u.mname', 'u.suffix', 'u.birthday', 'r.abbr', 'a.birth_place', 'r.order')
                                ->get();

        $crews = $crews->sortBy('order');
        $crews->load('applicant.document_med_cert');
        $crews->load('applicant.document_id');

        $onBoards = array();
        foreach($crews as $crew){
            $temp = $crew->applicant->document_id;
            $crew->covidVaccines = $crew->applicant->document_med_cert->where('type', 'LIKE' ,'%COVID%');
            $crew->age = now()->parse($crew->birthday)->diff(now())->format('%y');
            $crew->seniority = $crew->applicant->pro_app->seniority;

            foreach($temp as $docu){
                if($docu->type != ""){
                    $crew->{$docu->type} = $docu->expiry_date;
                    $crew->{$docu->type . 'i'} = $docu->issue_date;
                    $crew->{$docu->type . 'n'} = $docu->number;
                }
            }

            array_push($onBoards, $crew);
        }

        $vname = Vessel::find($id ?? $req->id);

        $temp = collect();
        foreach($linedUps as $key => $linedUp){
            $temp->add($linedUp);
            $linedUps->pull($key);
        }

        $linedUps = $temp;

        if($id){
            return [$onBoards, $linedUps, $vname];
        }
        else{
            echo json_encode([$onBoards, $linedUps, $vname, $ranks->keyBy('id')]);
        }

    }

    public function updateStatus($id, $status, $vessel_id = null, Request $req){
        $temp = ProcessedApplicant::where('applicant_id', $id)->first();
        $temp->status = $status;

        if($req->rank){
            $temp->rank_id = $req->rank;
        }
        $temp->save();

        if($status == "On Board"){
            $temp->joining_port = $req->port;
            $temp->joining_date = $req->date;

            if($temp->months == null){
                $temp->months = $req->months;
            }

            LineUpContract::create($temp->toArray());
        }

        $lin_con = LineUpContract::where('applicant_id', $id)->orderBy('id', 'desc')->first();

        // IF DISEMBARKATION
        // if(in_array($status, ['VACATION', 'OWN WILL', 'DISMISSAL' ,'MEDICAL REPAT', 'VESSEL SOLD'])){
        if($status != "On Board"){
            $vessel     = Vessel::find($vessel_id);
            $pro_app    = ProcessedApplicant::where('applicant_id', $id)->first();

            // SAVE SEA SERVICE
            SeaService::create([
                'applicant_id'      => $id,
                'vessel_name'       => $vessel->name,
                'rank'              => Rank::find($pro_app->rank_id)->name,
                'vessel_type'       => $vessel->type,
                'gross_tonnage'     => $vessel->gross_tonnage,
                'engine_type'       => $vessel->engine,
                'bhp_kw'            => $vessel->BHP,
                'flag'              => $vessel->flag,
                'trade'             => $vessel->trade,
                'manning_agent'     => $vessel->manning_agent,
                'ship_manager'      => $vessel->ship_manager,
                'principal'         => Principal::find($vessel->principal_id)->name,
                'imo'               => $vessel->imo,
                // 'crew_nationality'  => $
                'sign_on'           => $lin_con->joining_date,
                'sign_off'          => $req->disembarkation_date ? now()->parse($req->disembarkation_date) : now()->parse($lin_con->joining_date)->addMonths($lin_con->months),
                'total_months'      => $req->disembarkation_date ? now()->parse($lin_con->joining_date)->diffInMonths(now()->parse($req->disembarkation_date)) : $lin_con->months,
                'remarks'           => $status == "Vacation" ? "FINISHED CONTRACT" : $status
            ]);

            $temp->eld = null;
            $temp->mob = null;
            $temp->status = "Vacation";
            $temp->save();
            Applicant::where('id', $id)->update(['status' => "Vacation"]);
        }

        // LineUpContract::where('applicant_id', $id)->where('status', 'On Board')->update($lucs);
        $lin_con->disembarkation_port = $req->disembarkation_port ?? null;
        $lin_con->disembarkation_date = $req->disembarkation_date ?? null;
        $lin_con->months = $req->disembarkation_date ? now()->parse($lin_con->joining_date)->diffInMonths(now()->parse($req->disembarkation_date)) : $lin_con->months;
        $lin_con->status = $status;
        $lin_con->save();


        echo $vessel_id ?? '';
    }

    public function updateLineUpContract(Request $req){
        if($req->type == "Embark"){
            LineUpContract::where('applicant_id', $req->id)->where('status', 'On Board')->update(["reliever" => $req->reliever]);
        }
        else{
            $lineup = LineUpContract::where('applicant_id', $req->id)->where('status', 'On Board')->first();
            $vessel = Vessel::find($lineup->vessel_id);
            $principal = Principal::find($lineup->principal_id);

            $disembarkation_date = $req->disembarkation_date;

            if(isset($req->ed)){
                $disembarkation_date = $req->ed;
            }

            $months = now()->parse($disembarkation_date)->diffInDays(now()->parse($lineup->joining_date)) / 30;
            $lineup->months = $months;
            $lineup->save();

            SeaService::create([
                'applicant_id' => $req->id,
                'vessel_name' => $vessel->name,
                'imo' => $vessel->imo,
                'rank' => Rank::find($lineup->rank_id)->name,
                'vessel_type' => $vessel->type,
                'gross_tonnage' => $vessel->gross_tonnage,
                'engine_type' => $vessel->engine,
                'bhp_kw' => $vessel->BHP,
                'flag' => $vessel->flag,
                'trade' => $vessel->trade,
                'manning_agent' => $vessel->manning_agent,
                'principal' => $principal->name,
                'sign_on' => $lineup->joining_date,
                'sign_off' => $disembarkation_date,
                'total_months' => $months,
                'remarks' => $req->remark == "Vacation" ? 'FINISHED CONTRACT' : $req->remark
            ]);

            $lineup->disembarkation_date = $disembarkation_date;
            $lineup->disembarkation_port = $req->disembarkation_port;
            if($req->type = "On Board Promotion"){
                $lineup->status = "On Board Promotion";
            }
            $lineup->save();
        }
    }

    function updateProApp(Request $req){
        echo ProcessedApplicant::where($req->col, $req->val)->update($req->update);
    }

    function updateContract(Request $req){
        echo LineUpContract::where($req->col, $req->val)->update($req->update);
    }

    function extendContract(Request $req){
        $lup = LineUpContract::where([
            ["applicant_id", '=', $req->id],
            ["status", '=', "On Board"],
            ["disembarkation_date", '=', null],
        ])->first();

        $temp = $lup->extensions;

        if($temp){
            $temp = json_decode($temp);
            array_push($temp, $req->months);
            $lup->extensions = json_encode($temp);
        }
        else{
            $lup->extensions = json_encode([$req->months]);
        }

        echo $lup->save();
    }

    function exportOnOff($id, $type, Request $req){
        $vesselCrew = $this->getVesselCrew(new Request(), $id);

        $onBoards = array_filter($vesselCrew[0], function($vesselCrew){
            return $vesselCrew->reliever;
        });

        $linedUps = $vesselCrew[1];

        foreach($linedUps as $linedUp){
            $lastShip = SeaService::where('applicant_id', $linedUp->applicant_id)->where('manning_agent', 'LIKE', '%SOLPIA%')->get()->sortByDesc('sign_off')->first();
            if($lastShip){
                $temp = explode(' ', $lastShip->vessel_name);
                array_shift($temp);
                $vessel = implode(' ', $temp);
                $vesselMatch = Vessel::where('name', 'LIKE', "%$vessel%")
                                // ->where('fleet', auth()->user()->fleet)
                                ->first();

                if($vesselMatch){
                    $lastShip = $vesselMatch->name;
                }
                else{
                    $lastShip = "EX-SOLPIA";
                }
            }
            else{
                $lastShip = "NEW HIRE";
            }
            $linedUp->lastShip = $lastShip;
        }

        $class = "App\\Exports\\OnOff\\" . $type;

        $vesselCrew[2]->name = str_replace("/", "", $vesselCrew[2]->name);
        $name = $vesselCrew[2]->name;
        $data = null;
        if($req->data){
            $data = $req->data;
        }


        return Excel::download(new $class($linedUps, $onBoards, $type, $data), "$name Onsigners and Offsigners.xlsx");
    }

    function exportDocument($id, $type, Request $req){
        $folder = $req->folder ?? null;

        if(str_starts_with($type, 'OnBoardVessel')){
            $ad = ['a.id', 'a.remarks'];
            $cd = ['fname', 'lname', 'suffix', 'mname', 'birthday'];
            $lud = ['joining_date', 'joining_port', 'months', 'reliever', 'extensions', 'vessel_id'];
            $rd = ['abbr'];

            $applicant = LineUpContract::where([
                ['line_up_contracts.status', '=', 'On Board'],
                ['vessel_id', '=', $req->id]
            ])
            ->join('applicants as a', 'a.id', 'line_up_contracts.applicant_id')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->join('ranks as r', 'r.id', '=', 'line_up_contracts.rank_id')
            ->select(array_merge($ad, $cd, $lud, $rd))
            ->get();

            foreach($applicant as $crew){
                $temp = DocumentId::where('applicant_id', $crew->id)->select('type', 'expiry_date', 'number')->get();
                $crew->age = now()->parse($crew->birthday)->age;

                if($crew->reliever != "No Reliever" && $crew->reliever != ""){
                    $temp2 = Applicant::find($crew->reliever)->load('user');
                    $crew->reliever = $temp2->user->lname . ', ' . $temp2->user->fname;
                }

                foreach($temp as $docu){
                    if($docu->type){
                        $crew->{$docu->type} = $docu->expiry_date;
                    }
                }
            }

            $folder = "OnBoard\\";
        }
        else{
            $applicant = Applicant::withTrashed()->find($id)->load('user');

            if(str_starts_with($type, 'DocumentChecklist') || str_starts_with($type, 'X')) {
                if($req->data['status'] == "Vacation"){
                    $tRank = Rank::find($req->data['rank']);
                    $applicant->rank = $tRank->abbr;
                    $applicant->rank2 = $tRank;
                }
                else{
                    $pa = ProcessedApplicant::where('applicant_id', $id)->first();
                    if($pa){
                        $rank = Rank::find($pa->rank_id);
                        if($rank){
                            $applicant->rank = $rank->abbr;
                            
                            $vessel = Vessel::find($pa->vessel_id);
                            $applicant->vessel = $vessel;
                            $applicant->departure = $pa->eld;
                            $applicant->rank2 = $rank;
                        }
                        else{
                            $temp = SeaService::where('applicant_id', $id)->latest('sign_on')->first();
                            $applicant->rank = null;

                            if($temp && $temp->rank != ""){
                                $applicant->rank = Rank::where('name', $temp->rank)->first()->abbr;
                            }
                            elseif(isset($req->data->rank)){
                                $tRank = Rank::find($req->data['rank']);
                                $applicant->rank = $tRank->abbr;
                                $applicant->rank2 = $tRank;
                            }
                        }
                    }
                }

                if($type == "DocumentChecklist"){
                    $req->filename = $applicant->user->fullname . ' - ' . "FinalDocumentChecklist";
                }
            }
            elseif(str_starts_with($type, 'Y')){
                $applicant->data = $req->all();
            }
        }

        if($req->data){
            $applicant->data = $req->data;
        }
        if($req->data2){
            $applicant->data2 = $req->data2;
        }

        // SET IF PDF OR EXCEL
        $exportType = $req->exportType ?? "xlsx";

        $default = isset($applicant->user) ? $applicant->user->fname . ' ' . $applicant->user->lname . ' - ' . $type : "-";
        $fileName = $req->filename ? $req->filename : (isset($req->data['filename']) ? $applicant->user->fname . ' ' . $applicant->user->lname . ' - ' . $req->data['filename'] : $default);
        $class = "App\\Exports\\" . $folder . $type;
        
        if($exportType == "xlsx"){
            return Excel::download(new $class($applicant, $type, $req->all()), "$fileName.xlsx");
        }
        else{
            $pdf = new PDFExport($applicant, $type, $fileName, $req->all());
            $pdf->getData();
            return $pdf->download();
        }
    }

    function getFiles_old(Request $req){
        $files = Fileszxc::where('applicant_id', $req->id)->select('name', 'type')->get()->groupBy('type')->toArray();

        $temp = Applicant::find($req->id);
        $temp->load('user');

        $full_name = $temp->user->fname . ' ' . $temp->user->lname;

        echo json_encode(
            [$files, $full_name]
        );
    }

    function getFiles(Request $req){
        if(in_array($req->type, ['eval', 'reco', 'comment'])){
            echo json_encode(DB::table("evaluations")->where('id', $req->id)->select('file')->first());
        }
        else{
            echo json_encode(DB::table('document_' . $req->type)->where('id', $req->id)->select('file')->first());
        }
    }

    function uploadFiles_old(Request $req){
        $file = $req->file('file');

        $name = $file->getClientOriginalName();
        $file->move(public_path().'/files/' . $req->aId . '/', $name);

        if(in_array($req->type, ['eval', 'reco', 'comment'])){
            DB::table("evaluations")->where('id', $req->id)->update(['file' => $name]);
        }
        else{
            DB::table('document_' . $req->type)->where('id', $req->id)->update(['file' => $name]);
        }

        echo "<script>window.close();</script>";
    }

    function uploadFiles(Request $req){
        $files = $req->file('files');
        $filenames = [];

        foreach($files as $file){
            $name = $file->getClientOriginalName();

            $type = strtoupper($file->getClientOriginalExtension());
            if(in_array($type, ["JPG", 'PNG', 'GIF', 'WEBP', 'JPEG'])){
                // $file->move(public_path().'/files/' . $req->aId . '/', $name);

                $img = Image::make($file);
                $img->orientate();

                $save_path = public_path().'/files/' . $req->aId;

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $img->save($save_path . '/' . $name);
            }
            else{
                $file->move(public_path().'/files/' . $req->aId . '/', $name);
            }

            array_push($filenames, $name);
        }
        
        if(in_array($req->type, ['eval', 'reco', 'comment'])){
            DB::table("evaluations")->where('id', $req->id)->update(['file' => json_encode($filenames)]);
        }
        else{
            DB::table('document_' . $req->type)->where('id', $req->id)->update(['file' => json_encode($filenames)]);
        }
        echo "<script>window.close();</script>";
    }

    public function deleteFile_old(Request $req){
        if(in_array($req->type, ['eval', 'reco', 'comment'])){
            DB::table("evaluations")->where('id', $req->id)->update(['file' => null]);
        }
        else{
            DB::table('document_' . $req->type)->where('id', $req->id)->update(['file' => null]);
        }

        if(!file_exists(public_path("del\\" . $req->aId))){
            mkdir(public_path("del\\files\\" . $req->aId));
        }

        rename(public_path("files\\" . $req->aId . "\\" . $req->file), public_path("del\\files\\" . $req->aId . "\\" . time() . '_' . $req->file));
    }

    public function deleteFile(Request $req){
        $files = null;

        if(in_array($req->type, ['eval', 'reco', 'comment'])){
            $files = DB::table("evaluations")->where('id', $req->id)->first();
        }
        else{
            $files = DB::table('document_' . $req->type)->where('id', $req->id)->first();
        }

        // if(!file_exists(public_path("del\\" . $req->aId))){
        //     mkdir(public_path("del\\files\\" . $req->aId));
        // }

        foreach (json_decode($files->file) as $file) {
            rename(public_path("files\\" . $req->aId . "\\" . $file), public_path("del\\files\\" . $req->aId . "\\" . time() . '_' . $file));
        }

        // die;

        $files->file = null;

        if(in_array($req->type, ['eval', 'reco', 'comment'])){
            DB::table("evaluations")->where('id', $req->id)->update(['file' => null]);
        }
        else{
            DB::table('document_' . $req->type)->where('id', $req->id)->update(['file' => null]);
        }
    }

    public function uploadSSfile(Request $req){
        $ss = SeaService::find($req->id);
        $aid = $ss->applicant_id;

        $file = $req->file('file');
        $name = "SSFILE$aid-$ss->id-" . time() . "." . $file->getClientOriginalExtension();

        if (!File::exists("ssFile\\$aid")) {
            File::makeDirectory("ssFile\\$aid", 0755, true);
        }

        $file->move(public_path("ssFile\\$aid\\"), $name);

        $ss->file = "ssFile/$aid/" . $name;
        $ss->save();
    }

    public function goToPrincipal(Applicant $applicant, Request $req){
        $user = User::find($applicant->user_id);
        $user->applicant = $req->principal;
        echo $user->save();
    }

    public function delete(User $user){
        $user->deleted_at = now()->toDateTimeString();
        echo $user->save();
    }

    public function get(User $user){
        echo json_encode($user);
    }

    public function getAddDetails(Applicant $applicant){
        $applicant->load('sea_service');
        $applicant->load('document_flag');
        $applicant->load('document_lc');

        $countries = array();
        foreach($applicant->document_flag as $key => $data){
            $country = $data->country;
            if(!isset($countries[$country])){
                $countries[$country] = array();
            }

            array_push($countries[$country], $data);
            $applicant->document_flag->forget($key);
        }

        foreach($countries as $key => $country){
            $applicant->document_flag->put($key, $country);
        }

        echo json_encode($applicant);
    }

    public function getAllInfo(Request $req){
        $applicant = Applicant::find($req->id);
        $applicant->load('user');
        $applicant->load(['educational_background' => function ($query) {
            $query->orderBy('year', 'desc');
        }]);
        $applicant->load('family_data');
        $applicant->load(['sea_service' => function ($query) {
            $query->orderBy('sign_on', 'desc');
        }]);
        $applicant->load('document_id');
        $applicant->load('document_flag');
        $applicant->load('document_lc');
        $applicant->load('document_med_cert');
        $applicant->load('document_med');
        $applicant->load('document_med_exp');
        $applicant->load('pro_app.vessel');
        $applicant->load('evaluation');

        if($applicant->pro_app->status == "On Board"){
            $applicant->lup = LineUpContract::where([
                ["applicant_id", '=', $req->id],
                ["status", '=', "On Board"],
                ["disembarkation_date", '=', null],
            ])->first();
        }

        echo json_encode($applicant);
    }

    public function awardees(){
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $details = [];

        $id = 3689;
        $id = 9999;

        $applicants = SeaService::select('sea_services.*', 'u.fname', 'u.mname', 'u.lname', 'u.suffix', 'u.fleet', 'u.address', 'pa.status as pa_s')
                    // ->where('manning_agent', 'LIKE', '%SOLPIA%')
                    // ->where('sea_services.applicant_id', $id)
                    ->whereNull('u.deleted_at')
                    ->join('applicants as a', 'a.id', '=', 'sea_services.applicant_id')
                    ->join('users as u', 'u.id', '=', 'a.user_id')
                    ->join('processed_applicants as pa', 'pa.applicant_id', '=', 'a.id')
                    // ->join('ranks as r', 'r.id', '=', 'pa.rank_id')
                    ->get()->groupBy('applicant_id');

        $ranks = Rank::pluck('abbr', 'importName');
        $rank2 = Rank::pluck('abbr', 'name');
        $ranks[""] = "-";
        
        foreach($applicants as $sss){
            $sss = $sss->sortByDesc('sign_on');

            $rname = "-";

            if($sss->first()->rank != ""){
                $rname = $ranks[$sss->first()->rank] ?? $rank2[$sss->first()->rank];
            }

            // echo $sss->first()->applicant_id . ' - ' . $sss->first()->rank . '<br>';

            $details[$sss->first()->applicant_id] = [
                "fname" => $sss->first()->fname,
                "mname" => $sss->first()->mname,
                "lname" => $sss->first()->lname,
                "address" => $sss->first()->address,
                "suffix" => $sss->first()->suffix,
                // "rname" => isset($ranks[$sss->first()->rank]) ? $ranks[$sss->first()->rank] : isset($rank2[$sss->first()->rank]) ? $rank2[$sss->first()->rank] : "-",
                "rname" => $rname,
                "fleet" => $sss->first()->fleet,
                "last_vessel" => $sss->first(),
                "pa_s" => $sss->first()->pa_s
            ];
            
            $total = 0;
            foreach($sss as $key => $ss){
                if(str_contains($ss->manning_agent, 'SOLPIA')){
                    if(isset($ss->sign_on) && isset($ss->sign_off)){
                        $total += $ss->sign_off->diffInDays($ss->sign_on) / 30;
                        if($ss->applicant_id == $id){
                            echo $ss->sign_on . ' - ' . $ss->sign_off . ' = ' . $ss->sign_off->diffInDays($ss->sign_on) / 30 . '<br>';
                        }
                    }
                }
                else{
                    break;
                }
            }

            $luc = LineUpContract::where('applicant_id', $sss->first()->applicant_id)->where('status', 'On Board')->first();
            if($luc){
                // $total += now()->diffInDays($luc->joining_date) / 30;
                $total += $luc->months;
                if($luc->extensions){
                    $extensions = json_decode($luc->extensions);
                    foreach($extensions as $ex){
                        $total += $ex;
                    }
                }

                $details[$luc->applicant_id]['last_vessel'] = $luc->vessel;
            }

            if($ss->applicant_id == $id){
                echo $total;
                die;
            }

            if($total == 0){
                if(isset($ss->sign_on) && isset($end)){
                    $total = $end->diffInDays($ss->sign_on) / 30;
                }
            }

            if($total >= 48 && $total <= 72){
                array_push($array1, $ss->applicant_id);
            }
            if($total >= 108 && $total <= 132){
                array_push($array2, $ss->applicant_id);
            }
            if($total >= 168){
                array_push($array3, $ss->applicant_id);
            }

            $details[$sss->first()->applicant_id]['total'] = $total;
        }

        $array1 = array_diff($array1, $array2);
        $array1 = array_unique($array1);
        $array2 = array_unique($array2);
        $array3 = array_unique($array3);

        $FYfleets = [
            "FLEET A" => [],
            "FLEET B" => [],
            "FLEET C" => [],
            "FLEET D" => [],
            "FLEET E" => [],
            "TOEI" => [],
            "FISHING" => [],
            "" => []
        ];
        $TYfleets = [
            "FLEET A" => [],
            "FLEET B" => [],
            "FLEET C" => [],
            "FLEET D" => [],
            "FLEET E" => [],
            "TOEI" => [],
            "FISHING" => [],
            "" => []
        ];
        $FTYfleets = [
            "FLEET A" => [],
            "FLEET B" => [],
            "FLEET C" => [],
            "FLEET D" => [],
            "FLEET E" => [],
            "TOEI" => [],
            "FISHING" => [],
            "" => []
        ];

        foreach($array1 as $id){
            array_push($FYfleets[$details[$id]['fleet']], $details[$id]);
        }

        foreach($array2 as $id){
            array_push($TYfleets[$details[$id]['fleet']], $details[$id]);
        }

        foreach($array3 as $id){
            array_push($FTYfleets[$details[$id]['fleet']], $details[$id]);
        }

        ksort($FYfleets);
        ksort($TYfleets);
        ksort($FTYfleets);

        return $this->_view('awardees', [
            'title' => 'Crew Awardees',
            'FYfleets' => $FYfleets,
            'TYfleets' => $TYfleets,
            'FTYfleets' => $FTYfleets
        ]);
    }

    public function testFunc(){
        $users = User::where('role', 'Applicant')->where('fleet', 'FLEET B')->get();

        foreach($users as $user){
            if(isset($user->crew->pro_app) && $user->crew->pro_app->status == "On Board" && $user->crew->pro_app->vessel->principal_id == 256){
                echo $user->lname . ';' . $user->fname . ';' . $user->mname . ';' . $user->crew->civil_status . ';' . $user->crew->pro_app->rank->abbr . ';' . $user->birthday . ';' . $user->crew->pro_app->updated_at . '<br>';
            }
        }
    }

    public function testFunc2(){
        $temp = ProcessedApplicant::whereIn('rank_id', [10,16])->get()->load('applicant.user');
        $array = [];

        $temp = $temp->filter(function($value, $key){
            return $value->applicant;
        });

        foreach($temp as $pa){
            $bool = true;

            if($pa->applicant->user->applicant == 4 || $pa->applicant->user->fleet == "FLEET A"){
                $bool = true;
            }

            if($bool){
                $hl = DocumentLC::where('applicant_id', $pa->applicant_id)->where('type', "COC")->where('no', '!=', '')->where(function($q) {
                    $q->whereRaw('json_contains(regulation, \'["II/1"]\')')->get();
                    $q->whereRaw('json_contains(regulation, \'["III/1"]\')')->get();
                })->count();

                if($hl){
                    $array[$pa->applicant_id]["name"] = $pa->applicant->user->namefull;
                    $array[$pa->applicant_id]["rank"] = $pa->rank->name;
                    $array[$pa->applicant_id]["fleet"] = $pa->applicant->user->fleet;
                }
            }
        }

        echo "<table><tbody>";
        foreach($array as $crew){
            $name = $crew['name'];
            $rank = $crew['rank'];
            $fleet = $crew['fleet'];

            echo "
                <tr>
                    <td>$name</td>
                    <td>$rank</td>
                    <td>$fleet</td>
                </tr>
            ";
        }
        echo "</tbody></table>";
    }

    public function tempfunc2(Request $req){

        $sss = SeaService::where('manning_agent', 'like', "%" . 'SOLPIA' . "%")->where(function($q){
            $q->where('vessel_name', 'like', "%" . "MARITE" . "%");
            $q->orWhere('vessel_name', 'like', "%" . "WISTERIA" . "%");
            $q->orWhere('vessel_name', 'like', "%" . "ALDEBARAN" . "%");
        })->get();

        foreach($sss as $ss){
            echo $ss->applicant->user->namefull . ';' . $ss->rank2->abbr . ';' . $ss->vessel_name . ';' . $ss->sign_on . '<br>';
        }

    }

    // CE JOEY
    public function tempfunc(Request $req){
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
    }

    //name, current rank, present vessel, date embarked

    public function generateApplicantFleet(){
        $applicants = User::where("role", 'Applicant')
                        ->where('fleet', null)
                        ->select('users.id as uid', 'users.role',
                                'a.id as aid', 'a.user_id',
                                'pa.vessel_id', 'pa.status', 'pa.principal_id'
                        )
                        ->join('applicants as a', 'a.user_id', '=', 'users.id')
                        ->join('processed_applicants as pa', 'pa.applicant_id', '=', 'a.id')
                        ->get();

        $principals = Principal::where('fleet', '!=', null)->get();
        $ctr = 0;

        foreach($applicants as $applicant){
            $fleet = null;
            $reason = null;

            if($applicant->status == "Lined-Up" || $applicant->status == "On Board"){
                $fleet = Vessel::where('id', $applicant->vessel_id)->first()->fleet;
                $reason = "Based on Lined-Up/On Board vessel's fleet";
            }
            else{
                $ss = SeaService::where('applicant_id', $applicant->aid)->get()->sortByDesc('sign_off')->first();
                if($ss){
                    $vessel = Vessel::where([['name', '=', $ss->vessel_name], ['fleet','!=',null]])->get();
                    if($vessel->count()){
                        $fleet = $vessel->first()->fleet;
                        $reason = "Based on previous vessel name's fleet";
                    }
                    else{
                        foreach ($principals as $principal) {
                            if($ss->principal != null && (strtoupper($ss->principal) == strtoupper($principal->name) || str_contains(strtoupper($ss->principal), strtoupper($principal->name)))){
                                $fleet = $principal->fleet;
                                $reason = "Based on previous vessel's principal name or same name";
                                break;
                            }
                        }
                    }
                }
            }

            if($fleet){
                User::where('id', $applicant->uid)->update(['fleet' => $fleet]);
                echo $applicant->uid . ' Successfully added to ' . $fleet . ' - ' . $reason . '<br>';
                $ctr++;
            }
        }

        echo '<br> Total Updated: ' . $ctr;
    }

    public function generateSeaServiceSizeAndOwner(){
        $this->generateSSDetails('owner');
        echo "<br>~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~<br>";
        $this->generateSSDetails('size');
        echo "<br>~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~<br>";
        $this->generateSSDetails('engine', "", 'engine_type');
    }

    private function generateSSDetails($col, $operator = null, $alt = null){
        $vessels = Vessel::where($col, '!=', null)->select($col, 'name')->get();
        
        foreach($vessels as $vessel){
            $names = [];
            array_push($names, $vessel['name']);

            if(str_contains($vessel['name'], "M/V")){
                array_push($names, str_replace('/', '', $vessel['name']));
            }
            elseif(str_contains($vessel['name'], "MV")){
                array_push($names, str_replace('MV', 'M/V', $vessel['name']));
            }
            elseif(str_contains($vessel['name'], "M/T")){
                array_push($names, str_replace('/', '', $vessel['name']));
            }
            elseif(str_contains($vessel['name'], "MT")){
                array_push($names, str_replace('MT', 'M/T', $vessel['name']));
            }

            $temp = $alt ?? $col;
            $query = SeaService::whereIn('vessel_name', $names)
                    ->where($temp, "=", $operator);

            echo "Updated $temp of sea_services of " . $vessel['name'] . ". #" . $query->count();
            echo " - " . $alt ? $vessel[$col] : " - ";
            echo "<br>";
            $query->update([$temp => $vessel[$col]]);
        }
    }

    private function _view($view, $data = array()){
        return view('applications.' . $view, $data);
    }
}
