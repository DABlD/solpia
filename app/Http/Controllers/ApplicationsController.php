<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\User;
use App\Models\{ProcessedApplicant, Applicant, LineUpContract};
use App\Models\{EducationalBackground, FamilyData, SeaService};
use App\Models\{Vessel, Rank, Principal};
use App\Models\{DocumentFlag, DocumentId, DocumentLC, DocumentMedCert, DocumentMed, DocumentMedExp};

use App\Models\{AuditTrail, Statistic, File as Fileszxc};

use Image;
use Browser;
use DB;
use File;

use App\Exports\AllApplicant;
// use App\Exports\Application;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationsController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Encoder/Principal/Cadet/Crewing Manager/Crewing Officer');
    }

    public function index(Request $req){
        $principals = Principal::select('id', 'slug', 'name')->where('active', 1)->get();
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();
        $vessels = Vessel::select('id', 'name')->where('status', 'ACTIVE')->get();

        return $this->_view('index', [
            'title' => 'Crew Database',
            'principals' => $principals,
            'categories' => $ranks->groupBy('category'),
            'vessels' => $vessels
        ]);
    }

    public function create(){
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();
        $issuers = array_merge(
           DocumentId::pluck('issuer')->toArray(),
           DocumentLC::pluck('issuer')->toArray()
        );

        $tempRegulations = DocumentLC::pluck('regulation')->toArray();
        $regulations = array();
               
    	return $this->_view('create', [
            'title'         => 'Add Crew',
            'categories'    => $ranks->groupBy('category'),
            'issuers'       => collect($issuers)->unique()->toArray(),
            'regulations'   => collect($regulations)->unique()->toArray(),
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
        $tempRegulations = DocumentLC::pluck('regulation')->toArray();
        $regulations = array();

        foreach($tempRegulations as $tempRegulation){
            $temps = json_decode($tempRegulation);
            foreach($temps as $temp){
                array_push($regulations, $temp);
            }
        }

        echo json_encode(collect($regulations)->unique());
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
        $order = ['Father', 'Mother', 'Spouse', 'Son', 'Daughter', 'Beneficiary'];
        
        $applicant->family_data = $applicant->family_data->sortBy(function($model) use ($order){
            return array_search($model->type, $order);
        });
        
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();
        $issuers = array_merge(
            DocumentId::pluck('issuer')->toArray(),
            DocumentLC::pluck('issuer')->toArray()
        );

        $tempRegulations = DocumentLC::pluck('regulation')->toArray();
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
						'imo'			=> $data->imo
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
						'imo'			=> $data->imo
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
        $applicant->ranks[''] = '';

        foreach(['document_id', 'document_flag', 'document_lc', 'document_med', 'document_med_cert' ] as $docuType){
            foreach($applicant->$docuType as $key => $data){

                // if($docuType == 'document_flag'){
                //     $temp = $data->country;
                // }
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

                $applicant->$docuType->$temp = $data;
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
        $order = ['Father', 'Mother', 'Spouse', 'Son', 'Daughter', 'Beneficiary'];
        
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

        $class = "App\\Exports\\" . ucfirst($type);

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
			else{
				$applicant->rank = null;
			}
        }

        if(in_array($type, ['western'])){
            $applicant->sea_service = $applicant->sea_service->sortBy('sign_off');
        }
        else{
            $applicant->sea_service = $applicant->sea_service->sortByDesc('sign_off');
        }

        // FIX MINIMUM VESSELS
        $minVessels = 0;

        if(in_array($type, ['kosco', 'imsco'])){
            $minVessels = 12;
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
                    'flag' => null
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

        Statistic::where('name', 'export')->increment('count');
		$pname = $type == "western" ? "NITTA_TOEI" : $type;
        return Excel::download(new $class($applicant, $type), $applicant->user->fname . '_' . $applicant->user->lname . ' Application - ' . $pname . '.xlsx');
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
        $linedUps = ProcessedApplicant::where('processed_applicants.vessel_id', $id ?? $req->id)
                        ->where('processed_applicants.status', 'Lined-Up')

                        ->join('applicants as a', 'a.id', '=', 'processed_applicants.applicant_id')
                        ->join('users as u', 'u.id', '=', 'a.user_id')
                        ->join('ranks as r', 'r.id', '=', 'processed_applicants.rank_id')
                        // ->join('document_ids as d', 'd.applicant_id', '=', 'processed_applicants.applicant_id')
                        // ->join('sea_services as s', 's.applicant_id', '=', 'processed_applicants.applicant_id')
                        ->select('processed_applicants.*', 'a.user_id', 'a.remarks', 'u.fname', 'u.lname', 'u.mname', 'u.suffix', 'u.birthday', 'r.abbr')
                        ->get();

        $temp = collect();
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();

        // SORT BY RANK
        foreach($ranks as $abbr){
            foreach($linedUps as $key => $linedUp){
                if($linedUp->abbr == $abbr->abbr){
                    $temp->push($linedUp);
                    $linedUps->pull($key);
                }
            }
        }

        $linedUps = $temp;

        foreach($linedUps as $linedUp){
            $temp = DocumentId::where('applicant_id', $linedUp->applicant_id)->select('type', 'expiry_date', 'number')->get();

            $linedUp->age = now()->parse($linedUp->birthday)->diff(now())->format('%y');
            $linedUp->status2 = "NEW-HIRE";

            foreach($temp as $docu){
                if($docu->type != ""){
                    $linedUp->{$docu->type} = $docu->expiry_date;
                    $linedUp->{$docu->type . 'n'} = $docu->number;
                }
            }
            
            $sea_services = SeaService::where('applicant_id', $linedUp->applicant_id)->get();
            foreach($sea_services as $service){
                if(strpos(strtoupper($service->manning_agent), 'SOLPIA') !== false){
                    $linedUp->status2 = 'EX-CREW';
                }
            }
        }

        $crews = LineUpContract::where('vessel_id', $id ?? $req->id)
                                ->where('line_up_contracts.status','On Board')
                                ->join('applicants as a', 'a.id', '=', 'line_up_contracts.applicant_id')
                                ->join('users as u', 'u.id', '=', 'a.user_id')
                                ->join('ranks as r', 'r.id', '=', 'line_up_contracts.rank_id')
                                ->select('line_up_contracts.*', 'a.user_id', 'a.remarks', 'u.fname', 'u.lname', 'u.mname', 'u.suffix', 'u.birthday', 'r.abbr')
                                ->get();

        $temp = collect();

        // SORT BY RANK
        foreach($ranks as $abbr){
            foreach($crews as $key => $crew){
                if($crew->abbr == $abbr->abbr){
                    $temp->push($crew);
                    $crews->pull($key);
                }
            }
        }

        $crews = $temp;

        $onBoards = array();
        $onSigners = array();

        foreach($crews as $crew){
            $temp = DocumentId::where('applicant_id', $crew->applicant_id)->select('type', 'expiry_date', 'number')->get();
            $crew->age = now()->parse($crew->birthday)->diff(now())->format('%y');

            foreach($temp as $docu){
                if($docu->type != ""){
                    $crew->{$docu->type} = $docu->expiry_date;
                    $crew->{$docu->type . 'n'} = $docu->number;
                }
            }

            array_push($onBoards, $crew);
        }

        $vname = Vessel::find($id ?? $req->id)->name;

        if($id){
            return [$onBoards, $linedUps, $vname];
        }
        else{
            echo json_encode([$onBoards, $linedUps, $vname, $ranks->keyBy('id')]);
        }

    }

    public function updateStatus($id, $status, $vessel_id = null, Request $req){
        $pas = ['status' => $status];
        $lucs = ['status' => $status];
        $as = ['status' => $status];

        $temp = ProcessedApplicant::where('applicant_id', $id)->first();
        $temp->status = $status;
        if($req->rank){
            $temp->rank_id = $req->rank;
        }
        $temp->save();

        if($status == "On Board"){
            $temp->joining_port = $req->port;
            $temp->joining_date = $req->date;
            $temp->months = $req->months;

            LineUpContract::create($temp->toArray());
        }

        $lin_con = LineUpContract::where('applicant_id', $id)->orderBy('id', 'desc')->first();

        // IF DISEMBARKATION
        if(in_array($status, ['VACATION', 'OWN WILL', 'DISMISSAL' ,'MEDICAL REPAT'])){
            $pas['principal_id'] = null;
            $pas['vessel_id'] = null;
            $pas['rank_id'] = null;

            $lucs['status'] = 'Finished';

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
                'principal'         => Principal::find($vessel->principal_id)->name,
                // 'crew_nationality'  => $
                'sign_on'           => $lin_con->joining_date,
                'sign_off'          => now()->parse($lin_con->joining_date)->addMonths($lin_con->months),
                'total_months'      => $lin_con->months,
                'remarks'           => $status
            ]);
        }

        // LineUpContract::where('applicant_id', $id)->where('status', 'On Board')->update($lucs);
        $lin_con->status = $status;
        $lin_con->save();

        Applicant::where('id', $id)->update($as);

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

            $months = now()->parse($req->disembarkation_date)->diffInDays(now()->parse($lineup->joining_date)) / 30;
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
                'sign_off' => $req->disembarkation_date,
                'total_months' => $months,
                'remarks' => $req->remark == "Vacation" ? 'FINISHED CONTRACT' : $req->remark
            ]);

            $lineup->disembarkation_date = $req->disembarkation_date;
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

    function exportOnOff($id, $type){
        $vesselCrew = $this->getVesselCrew(new Request(), $id);

        $onBoards = array_filter($vesselCrew[0], function($vesselCrew){
            return $vesselCrew->reliever;
        });

        $linedUps = $vesselCrew[1];

        foreach($linedUps as $linedUp){
            $count = SeaService::where('applicant_id', $linedUp->applicant_id)->where('manning_agent', 'LIKE', '%SOLPIA%')->count();
            $linedUp->lastShip = $count ? 'EX-SOLPIA' : 'NEW HIRE';
        }

        $class = "App\\Exports\\" . $type;

        $name = substr($vesselCrew[2], 4);

        return Excel::download(new $class($linedUps, $onBoards, $type), "$name Onsigners and Offsigners.xlsx");
    }

    function exportDocument($id, $type, Request $req){
        if($type == "OnBoardVessel"){
            $ad = ['a.id', 'a.remarks'];
            $cd = ['fname', 'lname', 'suffix', 'mname', 'birthday'];
            $lud = ['joining_date', 'joining_port', 'months', 'reliever'];
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
                    $crew->{$docu->type} = $docu->expiry_date;
                }
            }
        }
        else{
            $applicant = Applicant::withTrashed()->find($id)->load('user');
        }

        $fileName = $req->filename ?? $applicant->user->fname . ' ' . $applicant->user->lname . ' - ' . $type;

        $class = "App\\Exports\\" . $type;
        
        return Excel::download(new $class($applicant, $type, $req->all()), "$fileName.xlsx");
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
        echo json_encode(DB::table('document_' . $req->type)->where('id', $req->id)->select('file')->first());
    }

    function uploadFiles_old(Request $req){
        $file = $req->file('file');

        $name = $file->getClientOriginalName();
        $file->move(public_path().'/files/' . $req->aId . '/', $name);

        DB::table('document_' . $req->type)->where('id', $req->id)->update(['file' => $name]);

        echo "<script>window.close();</script>";
    }

    function uploadFiles(Request $req){
        $files = $req->file('files');
        $filenames = [];

        foreach($files as $file){
            $name = $file->getClientOriginalName();
            $file->move(public_path().'/files/' . $req->aId . '/', $name);
            array_push($filenames, $name);
        }
        
        DB::table('document_' . $req->type)->where('id', $req->id)->update(['file' => json_encode($filenames)]);
        echo "<script>window.close();</script>";
    }

    public function deleteFile_old(Request $req){
        DB::table('document_' . $req->type)->where('id', $req->id)->update(['file' => null]);

        if(!file_exists(public_path("del\\" . $req->aId))){
            mkdir(public_path("del\\files\\" . $req->aId));
        }

        rename(public_path("files\\" . $req->aId . "\\" . $req->file), public_path("del\\files\\" . $req->aId . "\\" . time() . '_' . $req->file));
    }

    public function deleteFile(Request $req){
        $files = DB::table('document_' . $req->type)->where('id', $req->id)->first();

        // if(!file_exists(public_path("del\\" . $req->aId))){
        //     mkdir(public_path("del\\files\\" . $req->aId));
        // }

        foreach (json_decode($files->file) as $file) {
            rename(public_path("files\\" . $req->aId . "\\" . $file), public_path("del\\files\\" . $req->aId . "\\" . time() . '_' . $file));
        }

        // die;

        $files->file = null;
        DB::table('document_' . $req->type)->where('id', $req->id)->update(['file' => null]);
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

        echo json_encode($applicant);
    }

    private function _view($view, $data = array()){
    	return view('applications.' . $view, $data);
    }
}
