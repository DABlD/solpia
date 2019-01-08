<?php

namespace App\Http\Controllers;

use App\Models\{Applicant, EducationalBackground, FamilyData};
use Illuminate\Http\Request;
use App\User;

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

    public function store(Request $req){
        $data = $req->except(['confirm_password', '_token']);

        if(User::create($data)){
            $req->session()->flash('success', 'User Successfully Added.');
            return redirect()->route('users.index');
        }
        else{
            $req->session()->flash('error', 'There was a problem adding the user. Try again.');
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
