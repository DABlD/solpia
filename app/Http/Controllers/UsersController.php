<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin');
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
        return $this->_view('edit', [
            'title' => 'Edit User Details',
            'user' => array_except($user, ['password'])
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

    public function update(Request $req){
        if(User::where('id', $req->id)->update($req->except(['_token']))){
            $req->session()->flash('success', 'User Successfully Updated.');
            return redirect()->route('users.index');
        }
        else{
            $req->session()->flash('error', 'There was a problem updating the user. Try again.');
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
    	return view('users.' . $view, $data);
    }
}
