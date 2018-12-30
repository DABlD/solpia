<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(){
    	return $this->_view('index', [
    		'title' => 'User Management'
    	]);
    }

    private function _view($view, $data = array()){
    	return view('users.' . $view, $data);
    }
}
