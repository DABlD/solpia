<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Ssap, Applicant};
use App\User;
use Hash;

class UsersController extends Controller
{
    public function __construct(){
        // REMOVE CADET AND ENCODER AFTER ADDING FLEET TO CREW
        $this->middleware('permissions:' . 'Admin/Cadet/Encoder');
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'User Management'
        ]);
    }

    public function create(){
    	return $this->_view('create', [
    		'title' => 'Add User'
    	]);
    }

    public function edit(User $user){
        $user->load('ssap');

        return $this->_view('edit', [
            'title' => 'Edit User Details',
            'user' => array_except($user, ['password'])
        ]);
    }

    // ALL STORING OF USER, SAVE ALSO TO Ssap. Double check if ids match. ssap.id should be = user.id
    public function store(Request $req){
        $data = $req->except(['confirm_password', '_token']);

        if($data['role'] != "Applicant"){
            $data['applicant'] = 0;
            $data['status'] = 1;
        }

        if(User::create($data)){
            Ssap::create(['token' => strrev($req->password)]);
            $req->session()->flash('success', 'User Successfully Added.');
            return redirect()->route('users.index');
        }
        else{
            $req->session()->flash('error', 'There was a problem adding the user. Try again.');
            return back();
        }
    }

    public function update(Request $req){
        $token = strrev($req->password);
        $req->merge(['password' => Hash::make($req->password)]);
        
        if(User::where('id', $req->id)->update($req->except(['_token']))){
            $ssap = Ssap::where('user_id', $req->id)->first();
            if($ssap){
                Ssap::where('id', $req->id)->update(['token' => $token]);
            }
            else{
                Ssap::create([
                    'user_id' => $req->id,
                    'token' => $token
                ]);
            }
            
            $req->session()->flash('success', 'User Successfully Updated.');
            return redirect()->route('users.index');
        }
        else{
            $req->session()->flash('error', 'There was a problem updating the user. Try again.');
            return back();
        }
    }

    public function ajaxUpdate(Request $req){
        echo User::where('id', $req->id)->update([$req->column => $req->value]);
    }

    // using Applicant ID
    public function ajaxUpdate2(Request $req){
        $user = User::find(Applicant::find((int)$req->id)->user_id);
        $user->{$req->column} = $req->value;
        echo $user->save();
    }

    public function delete(User $user){
        $user->deleted_at = now()->toDateTimeString();
        echo $user->save();
    }

    public function get(User $user){
    	echo json_encode($user);
    }

    private function _view($view, $data = array()){
    	return view('users.' . $view, $data);
    }
}
