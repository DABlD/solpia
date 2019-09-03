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
            'regulations'   => collect($regulations)->unique()->toArray()
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
            'edit'          => true
        ]);
    }

    public function update(Request $req){
        dd($req->all());
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
