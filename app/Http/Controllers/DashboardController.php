<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
    	return $this->_view('dashboard', [
    		'title' => 'Dashboard'
    	]);
    }

    private function _view($view, $data = array()){
    	return view($view, $data);
    }
}
