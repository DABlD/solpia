<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\User;
use App\Models\{Applicant, ProcessedApplicant};
use App\Models\{Vessel, Rank, Principal};
use App\Models\{AuditTrail, SeaService};

class DatatablesController extends Controller
{
	public function users(){
		$users = User::where('deleted_at', null)
					// ->where('role', '!=', 'Applicant')
					// ->orWhere('role', null)
					->where([
						['role', '!=', 'Applicant'],
						['role', '!=', 'Principal']
					])
					->get();

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($users as $user){
			$user->fullname = $user->fullname;
			$user->actions = $user->actions;
		}

    	return Datatables::of($users)->rawColumns(['actions'])->make(true);
	}

	public function applications(){
		$applicants = Applicant::select('id', 'user_id', 'status', 'remarks')
						->with('user:id,avatar,fname,lname,contact,birthday')
						->get();

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($applicants as $key => $applicant){
			$applicant->row = ($key + 1);
			$applicant->actions = $applicant->actions;
			$applicant->age = $applicant->user->birthday->diffInYears();

			$vessels = SeaService::select('vessel_name', 'sign_off')->where('applicant_id', $applicant->id)->get();

			if($vessels->count()){
				$applicant->last_vessel = $vessels->sortBy('sign_off')->last()->vessel_name;
			}
			else{
				$applicant->last_vessel = "-----";
			}

			$temp = ProcessedApplicant::where('applicant_id', $applicant->id)->first();

			if($temp->status == "Lined-Up"){
			    $applicant->rank = Rank::find($temp->rank_id)->abbr;
			    $applicant->vessel = Vessel::find($temp->vessel_id)->name;
			}
			else{
			    if($applicant->sea_service->count()){
			        $name = $applicant->sea_service->sortByDesc('sign_off')->first()->rank;
			        $applicant->rank = Rank::where('name', $name)->first()->abbr;
			    }
			    else{
			    	$applicant->rank = "N/A";
			    }
			}
		}

    	return Datatables::of($applicants)->rawColumns(['actions'])->make(true);
	}

	public function processedApplicant($id){
		$applicants = ProcessedApplicant::select('*')
						->with('applicant:id,user_id')
						->with('vessel:id,name')
						->with('rank:id,name')
						->where('principal_id', $id)
						// ->where('processed_applicants.status')
						->get();

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($applicants as $applicant){
			$applicant->actions = $applicant->actions;
			$applicant->user = User::where('id', $applicant->applicant->user_id)->select('fname', 'lname', 'avatar')->first();
		}

    	return Datatables::of($applicants)->rawColumns(['actions'])->make(true);
	}

	public function vessels(){
		$vessels = Vessel::select('vessels.*')->with('principal')->get();

		// ADD ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($vessels as $vessel){
			$vessel->actions = $vessel->actions;
		}

    	return Datatables::of($vessels)->rawColumns(['actions'])->make(true);
	}

	public function auditTrail(){
		$vessels = AuditTrail::join('users', 'audit_trails.user_id', '=', 'users.id')
							->select('audit_trails.*', 'users.username')
							->get();
		// ADD ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		// foreach($vessels as $vessel){
		// 	$vessel->actions = $vessel->actions;
		// }

    	return Datatables::of($vessels)->rawColumns(['actions'])->make(true);
	}
}