<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
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

    public function get(User $user){
    	echo json_encode($user);
    }

    private function _view($view, $data = array()){
    	return view('users.' . $view, $data);
    }
}
