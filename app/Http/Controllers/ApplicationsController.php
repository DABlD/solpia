<?php

namespace App\Http\Controllers;

use App\Models\{Applicant, EducationalBackground, FamilyData};
use Illuminate\Http\Request;
use App\User;
use Image;

use App\Exports\AllApplicant;
// use App\Exports\Application;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationsController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Encoder');
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Applications'
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
        $applicant->load('family_data');

        $class = "App\\Exports\\'ucfirst($type)'";

        return Excel::download(new $class($applicant), $applicant->user->fname . '_' . $applicant->user->lname . ' Application - ' . ucfirst($type) . '.xlsx');
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

        $fd = json_decode($req->fd);
        foreach($fd as $data){
            $data->applicant_id = $applicant->id;
            FamilyData::create((array)$data);
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
