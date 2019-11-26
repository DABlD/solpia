<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ProcessedApplicant, Principal, Applicant};

class LineUpController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Crewing Manager/Principal');
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Lined-Up Applicants',
            'principal' => Principal::where('user_id', auth()->user()->id)->first()
            // 'principal' => camel_case(strtolower(auth()->user()->fname))
        ]);
    }

    public function remove(Request $req){
        Applicant::where('id', $req->id)->update(['status' => 'Vacation']);

        return ProcessedApplicant::where('applicant_id', $req->id)->update([
            'principal_id' => null,
            'vessel_id' => null,
            'rank_id' => null,
            'status' => 'Vacation',
            'remarks' => null
        ]);
    }

    // public function create(){
    // 	return $this->_view('create', [
    // 		'title' => 'Add User'
    // 	]);
    // }

    // public function edit(User $user){
    //     return $this->_view('edit', [
    //         'title' => 'Edit User Details',
    //         'user' => array_except($user, ['password'])
    //     ]);
    // }

    // public function store(Request $req){
    //     $data = $req->except(['confirm_password', '_token']);

    //     if(User::create($data)){
    //         $req->session()->flash('success', 'User Successfully Added.');
    //         return redirect()->route('users.index');
    //     }
    //     else{
    //         $req->session()->flash('error', 'There was a problem adding the user. Try again.');
    //         return back();
    //     }
    // }

    public function update(Request $req){
        if(ProcessedApplicant::where('id', $req->id)->update($req->except(['_token']))){
            $req->session()->flash('success', 'Applicant Successfully Updated.');
            return redirect()->route('lineUp.index');
        }
        else{
            $req->session()->flash('error', 'There was a problem updating the Applicant. Try again.');
            return back();
        }
    }

    public function get(ProcessedApplicant $processedApplicant){
    	echo json_encode($processedApplicant);
    }

    private function _view($view, $data = array()){
    	return view('lineUp.' . $view, $data);
    }
}
