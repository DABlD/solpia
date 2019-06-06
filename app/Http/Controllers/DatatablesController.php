<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\User;
use App\Models\{Applicant};

class DatatablesController extends Controller
{
	public function users(){
		$users = User::where('deleted_at', null)
					->where('role', '!=', 'Applicant')
					->get();

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($users as $user){
			$user->fullname = $user->fullname;
			$user->actions = $user->actions;
		}

    	return Datatables::of($users)->rawColumns(['actions'])->make(true);
	}

	public function applications(){
		$applicants = Applicant::select('id', 'age', 'user_id')
						->with('user:id,avatar,fname,mname,lname,contact')->get();

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($applicants as $applicant){
			$applicant->actions = $applicant->actions;
		}

    	return Datatables::of($applicants)->rawColumns(['actions'])->make(true);
	}
}
