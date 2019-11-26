<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\{Applicant, LineUpContract};

class DashboardController extends Controller
{
    public function index(){
        if($this->checkIfNotAllowed()){
            return redirect()->route('applications.index');
        }

        $condition = array();

        // STATUS = WHAT PRINCIPAL IS STAFF UNDER SO I USED THIS
        $status = auth()->user()->status;

        if($status == 1){
            $condition = ['u.applicant', '>', 0];
        }
        elseif($status > 1){
            $condition = ['u.applicant', '=', $status];
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

    function checkIfNotAllowed(){
        $toDatabase = ['Cadet', 'Encoder', 'Crewing Officer', 'Processing'];
        return in_array(auth()->user()->role, $toDatabase);
    }

    private function _view($view, $data = array()){
    	return view($view, $data);
    }
}
