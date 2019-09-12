<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\User;
use App\Models\{ProcessedApplicant, Applicant};
use App\Models\{EducationalBackground, FamilyData, SeaService};
use App\Models\{Vessel, Rank, Principal};
use App\Models\{DocumentFlag, DocumentId, DocumentLC, DocumentMedCert, DocumentMed, DocumentMedExp};

use Image;
use DB;

use App\Exports\AllApplicant;
// use App\Exports\Application;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationsController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Encoder/Principal/Cadet');
    }

    public function index(Request $req){
        $principals = Principal::select('id', 'slug', 'name')->get();
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
            DocumentLC::pluck('issuer')->toArray(),
        );

        $tempRegulations = DocumentLC::pluck('regulation')->toArray();
        $regulations = array();

        foreach($tempRegulations as $tempRegulation){
            $temps = json_decode($tempRegulation);
            foreach($temps as $temp){
                array_push($regulations, $temp);
            }
        }

    	return $this->_view('create', [
            'title'         => 'Add Crew',
            'categories'    => $ranks->groupBy('category'),
            'issuers'       => collect($issuers)->unique()->toArray(),
            'regulations'   => collect($regulations)->unique()->toArray(),
            'religions'     => Applicant::pluck('religion')->unique(),
            'schools'       => EducationalBackground::pluck('school')->unique()
    	]);
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
        
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();
        $issuers = array_merge(
            DocumentId::pluck('issuer')->toArray(),
            DocumentLC::pluck('issuer')->toArray(),
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

        // $applicant = Applicant::where('user_id', $id)->update($applicant->all());

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

            $avatar->resize(209,196);
            $avatar->save($destinationPath . $name);

            $user->put('avatar', 'uploads/' . $name);
        }

        // SAVE USER
        // $user = User::where('id', $id)->update($user->all());

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
            $data->age = $data->birthday == "" ? null : 0;

            if(isset($data->id)){
                echo $data->id . ' - ' . 'Update<br>';
                // FamilyData::where('id', $data->id)->update((array)$data);
            }
            else{
                echo 'Create<br>';
                // FamilyData::create((array)$data);
            }
        }


        // DELETE FAMILY DATA
        $this->clearData($applicant->family_data, $req->fd, 'family_datas');

        die;

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

            if(Vessel::where('name', $data->vessel_name)->count() == 0){
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
        $this->clearData($applicant->document_med_cert, $req->docu_med_cert, 'docu_med_certs');

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

        return back();
    }

    public function clearData($old, $new, $table){
        $a = $old->pluck('id')->toArray();
        $b = collect(json_decode($new))->pluck('id')->toArray();
        $ids = array_diff($a, array_intersect($a, $b));

        // dd($a, $b, array_intersect($a, $b), $ids);

        echo '<br>';

        foreach($ids as $id){
            echo 'Deleting' . ' - id# ' . $id . '<br>';
            // DB::table($table)->where('id', $id)->delete();
        }
    }

    public function exportAll(){
        return Excel::download(new AllApplicant, 'Applicants.xlsx');
    }

    public function exportApplication(Applicant $applicant, $type){
        $applicant->load('user');
        $applicant->load('educational_background');
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
        $applicant->family_data = $applicant->family_data->sortBy('type');
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
        if($temp->status == "Lined-Up"){
            $applicant->rank = Rank::find($temp->rank_id);
            $applicant->vessel = Vessel::find($temp->vessel_id);
        }
        else{
            if($applicant->sea_service->count()){
                $name = $applicant->sea_service->sortByDesc('sign_off')->first()->rank;
                $applicant->rank = Rank::where('name', $name)->first();
            }
        }

        return Excel::download(new $class($applicant, $type), $applicant->user->fname . '_' . $applicant->user->lname . ' Application - ' . ucfirst($type) . '.xlsx');
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

        return Excel::download(new $class($applicant, $type), $applicant->user->fname . '_' . $applicant->user->lname . ' Application - ' . ucfirst($type) . '.xlsx');
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

        // UPLOAD AVATAR
        $image = $req->file('avatar');
        $avatar = Image::make($image);

        $name = $req->fname . '_' . $req->lname . '_avatar.'  . $image->getClientOriginalExtension();
        $destinationPath = public_path('uploads/');

        $avatar->resize(209,196);
        $avatar->save($destinationPath . $name);

        $user->put('avatar', 'uploads/' . $name);

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
            $data->age = $data->birthday == "" ? null : 0;
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
            
            if(Vessel::where('name', $data->vessel_name)->count() == 0){
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

    private function _view($view, $data = array()){
    	return view('applications.' . $view, $data);
    }
}
