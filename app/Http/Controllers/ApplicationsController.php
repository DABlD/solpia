<?php

namespace App\Http\Controllers;

use App\Models\{Applicant, EducationalBackground, FamilyData};
use Illuminate\Http\Request;
use App\User;

use App\Exports\AllApplicant;
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

    public function export(){
        return Excel::download(new AllApplicant, 'Applicants.xlsx');
        // return Excel::create('Applicants.xlsx', function($sheet){
        //     $applicants = Applicant::with('user')->get();

        //     foreach($applicants as $index => $applicant){
        //         $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        //         $drawing->setPath(public_path($applicant->user->avatar));
        //         $drawing->setCoordinates('B' . $index + 2);
        //         $drawing->setWorksheet($sheet);
        //     }
        // });
    }

    public function store(Request $req){
        $user = collect($req->only([
            'fname','mname','lname',
            'birthday','address','contact',
            'email','gender'
        ]))->put('password', '123456')->put('role', 'Applicant');

        $user = User::create($user->all());

        $applicant = collect($req->only([
            'provincial_address','provincial_contact',
            'birth_place','religion','age','waistline',
            'shoe_size','height','weight','bmi','blood_type',
            'civil_status', 'tin', 'sss' 
        ]))->put('user_id', $user->id);

        if(Applicant::create($applicant->all())){
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
