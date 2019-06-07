<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\User;
use App\Models\{ProcessedApplicant, Applicant};
use App\Models\{EducationalBackground, FamilyData, SeaService};
use App\Models\{Vessel, Rank, Principal};
use App\Models\{DocumentFlag, DocumentId, DocumentLC};

use Image;

use App\Exports\AllApplicant;
// use App\Exports\Application;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationsController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Encoder/Principal');
    }

    public function index(){

        $principals = Principal::select('id', 'slug', 'name')->get();
        $ranks = Rank::select('id', 'name')->get();
        $vessels = Vessel::select('id', 'name')->where('status', 'ACTIVE')->get();

        return $this->_view('index', [
            'title' => 'Applications',
            'principals' => $principals,
            'ranks' => $ranks,
            'vessels' => $vessels
        ]);
    }

    public function create(){
    	return $this->_view('create', [
    		'title' => 'Add Application'
    	]);
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

        // DEFINE ALL DOCUMENT REQUIREMENTS
        // $r_docu_id = ['SEAMANS BOOK', 'PASSPORT', 'US-VISA'];
        // $r_docu_flag = [''];
        // $r_docu_lc = ['COC', 'GDSSM GOC'];
    
        // CHECK IF COMPLETE DOCUMENT_ID REQUIREMENTS
        // foreach($r_docu_id as $req){
        //     $applicant->document_id->$req = "N/A";

        //     foreach($applicant->document_id as $data){
        //         if($data->type == $req){
        //             $applicant->document_id->$req = $data;
        //             break;
        //         }
        //     }
        // }
        
        // CHECK IF COMPLETE DOCUMENT_FLAG REQUIREMENTS
        // foreach($r_docu_flag as $req){
        //     $applicant->document_flag->$req = "N/A";

        //     foreach($applicant->document_flag as $data){
        //         if($data->country == $req){
        //             $applicant->document_flag->$req = $data;
        //             break;
        //         }
        //     }
        // }
        
        // CHECK IF COMPLETE DOCUMENT_LC REQUIREMENTS
        // foreach($r_docu_lc as $req){
        //     $applicant->document_lc->$req = "N/A";

        //     foreach($applicant->document_lc as $data){
        //         if($data->type == $req){
        //             $applicant->document_lc->$req = $data;
        //             break;
        //         }
        //     }
        // }

        foreach(['document_id', 'document_flag', 'document_lc'] as $docuType){
            foreach($applicant->$docuType as $data){
                $temp = $docuType == 'document_flag' ? $data->country : $data->type;
                $applicant->$docuType->$temp = $data;
            }
        }

        // IF FAMILY_DATA IS ODD
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
            'fname','mname','lname',
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
            'civil_status', 'tin', 'sss' 
        ]))->put('user_id', $user->id);

        $applicant = Applicant::create($applicant->all());

        // SAVE FAMILY DATA
        $fd = json_decode($req->fd);
        foreach($fd as $data){
            $data->applicant_id = $applicant->id;
            FamilyData::create((array)$data);
        }

        // SAVE SEA SERVICE
        $ss = json_decode($req->ss);
        foreach($ss as $data){
            $data->applicant_id = $applicant->id;
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
            $data->applicant_id = $applicant->id;
            DocumentId::create((array)$data);
        }

        // SAVE DOCUMENT FLAG
        $docu_flag = json_decode($req->docu_flag);
        foreach($docu_flag as $data){
            $data->applicant_id = $applicant->id;
            DocumentFlag::create((array)$data);
        }

        // SAVE DOCUMENT LC
        $docu_lc = json_decode($req->docu_lc);
        foreach($docu_lc as $data){
            $data->applicant_id = $applicant->id;
            DocumentLC::create((array)$data);
        }

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
        echo ProcessedApplicant::create(array_merge($req->all(), ['status' => 'Lined-Up']));
    }

    public function delete(User $user){
        $user->deleted_at = now()->toDateTimeString();
        echo $user->save();
    }

    public function get(User $user){
    	echo json_encode($user);
    }

    private function _view($view, $data = array()){
    	return view('applications.' . $view, $data);
    }
}
