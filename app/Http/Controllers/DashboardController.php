<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\{Applicant, LineUpContract};

use DB;

class DashboardController extends Controller
{
    public function index(){
        $condition = array();
        if(auth()->user()->status == 2){
            $condition = ['u.applicant', '=', 2];
        }
        elseif(auth()->user()->status > 0){
            $condition = ['u.applicant', '>', 0];
        }

    	$onBoard = LineUpContract::join('applicants as a', 'a.id', '=', 'line_up_contracts.applicant_id')
                                ->join('users as u', 'u.id', '=', 'a.user_id')
                                ->where([
                                    ['line_up_contracts.status', '=', 'On Board'], 
                                    $condition
                                    
                                ])
                                ->get();

    	$applicants = Applicant::join('users as u', 'u.id', '=', 'applicants.user_id')
                                ->where([$condition])
                                ->get();

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
