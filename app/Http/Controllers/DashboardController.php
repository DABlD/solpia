<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\{Applicant, LineUpContract};

class DashboardController extends Controller
{
    public function index(){
    	$onBoard = LineUpContract::where('status', 'On Board')->get();
    	$applicants = Applicant::select('id')->get();

    	return $this->_view('dashboard', [
    		'title' 		=> 'Dashboard',
    		'applicants'	=> $applicants,
    		'onBoard' 		=> $onBoard,
    	]);
    }

    private function _view($view, $data = array()){
    	return view($view, $data);
    }
}
