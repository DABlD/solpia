<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\User;
use App\Models\{Applicant, ProcessedApplicant};
use App\Models\{Vessel, Rank, Principal};
use App\Models\{AuditTrail, SeaService};

use DB;

class DatatablesController extends Controller
{
	public function users(){
		$users = User::
					// ->where('role', '!=', 'Applicant')
					where([
						['role', '!=', 'Applicant'],
						['role', '!=', 'Principal'],
					])
					->orWhere('role', null)
					->get();

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($users as $user){
			$user->fullname = $user->fullname;
			$user->actions = $user->actions;
		}

    	return Datatables::of($users)->rawColumns(['actions'])->make(true);
	}

	public function applications(Request $req){
		$applicants = Applicant::select(
							'applicants.id', 'applicants.remarks',
							'avatar', 'fname', 'lname', 'contact', 'birthday',
							'pa.status', 'pa.rank_id', 'pa.vessel_id',
						)
						->join('users as u', 'u.id', '=', 'applicants.user_id')
						->join('processed_applicants as pa', 'pa.applicant_id', '=', 'applicants.id')
						->get();

		$ranks = [];
		$ranks2 = [];
		$temps = Rank::select('id', 'abbr', 'name')->get();

		foreach($temps as $temp){
			$ranks[$temp->id] = $temp->abbr;
			$ranks2[$temp->name] = $temp->abbr;
		}

		$vesselszxc = Vessel::pluck('name', 'id');

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($applicants as $key => $applicant){
			$applicant->remarks = json_decode($applicant->remarks);
			$applicant->row = ($key + 1);
			$applicant->actions = $applicant->actions;
			$applicant->age = $applicant->birthday ? now()->parse($applicant->birthday)->diffInYears(now()) : '-';

			$vessels = SeaService::select('vessel_name', 'sign_off')->where('applicant_id', $applicant->id)->get()->sortBy('sign_off');

			if($vessels->count()){
				$applicant->last_vessel = $vessels->last()->vessel_name;
			}
			else{
				$applicant->last_vessel = "-----";
			}

			if($applicant->pro_app->status == "Lined-Up"){
			    $applicant->rank = $ranks[$applicant->pro_app->rank_id];
			    $applicant->vessel = $vesselszxc[$applicant->pro_app->vessel_id];
			}
			else{
			    if($vessels->count()){
			        $name = $vessels->last()->rank;
			        $applicant->rank = $name != "" ? ($ranks2[$name] ? $rank : 'N/A') : 'N/A';
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
		$vessels = Vessel::where('status', 'ACTIVE')->select('vessels.*')->with('principal')->get();

		// ADD ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		$principals = Principal::where('active', 1)->pluck('id')->toArray();
		foreach($vessels as $key => $vessel){
			if(!in_array($vessel->principal_id, $principals)){
				$vessels->forget($key);
			}
			else{
				$vessel->actions = $vessel->actions;
			}
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