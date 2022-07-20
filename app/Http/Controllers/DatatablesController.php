<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\{Applicant, ProcessedApplicant};
use App\Models\{Vessel, Rank, Principal};
use App\Models\{AuditTrail, SeaService, Opening};

use App\Models\{TempApplicant, TempSeaService};
use App\Models\{Wage};
use App\Models\{Prospect, Requirement};

use App\{User, TempUser};

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

	public function recruitments(Request $req){
		$applicants = TempApplicant::select(
							'temp_applicants.id',
							'avatar', 'fname', 'lname', 'contact', 'birthday', 'temp_applicants.created_at', 'temp_applicants.rank'
						)
						->join('temp_users as u', 'u.id', '=', 'temp_applicants.user_id')
						->get();

		$rank = [];
		$temps = Rank::select('id', 'abbr', 'name')->get();

		foreach($temps as $temp){
			$rank[$temp->name] = $temp->abbr;
		}

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($applicants as $key => $applicant){
			$applicant->row = ($key + 1);
			$applicant->actions = $applicant->actions;
			$applicant->age = $applicant->birthday ? now()->parse($applicant->birthday)->diffInYears(now()) : '-';
			$applicant->status = $applicant->pa_s;

			$vessels = TempSeaService::select('vessel_name', 'sign_off', 'rank')->where('applicant_id', $applicant->id)->get()->sortBy('sign_off');

			// GET LAST VESSEL
			if($vessels->count()){
				$applicant->last_vessel = $vessels->last()->vessel_name;
			}
			else{
				$applicant->last_vessel = "-----";
			}

			// GET RANK
		    if($vessels->count()){
		        $name = $vessels->last()->rank;
		        $applicant->rank = $rank[$name] ?? 'N/A';
		    }
		}
		
    	return Datatables::of($applicants)->rawColumns(['actions'])->make(true);
	}

	public function applications(Request $req){
	// public function applications(Request $req){
		DB::connection()->enableQueryLog();

		$ranks = [];
		$ranks2 = [];
		$temps = Rank::select('id', 'abbr', 'name')->get()->keyBy('abbr')->toArray();

		foreach($temps as $temp){
			$ranks[$temp['id']] = $temp['abbr'];
			$ranks2[$temp['name']] = $temp['abbr'];
		}

		$vesselszxc = Vessel::pluck('name', 'id');
		
		// STATUS = WHAT PRINCIPAL IS STAFF UNDER SO I USED THIS
		$status = auth()->user()->status;
		$search = $req->search["value"];

		if($status == 1){
		    $condition = ['u.applicant', '>', 0];
		}
		elseif($status > 1){
		    $condition = ['u.applicant', '=', $status];
		}

		// if($search){
		// 	$condition = [
		// 		$condition, 
		// 		['u.deleted_at', '=', null], 
		// 		['applicants.remarks', 'LIKE', "%" . $search . "%"],
		// 		['fname', 'LIKE', "%" . $search . "%"],
		// 		['lname', 'LIKE', "%" . $search . "%"],
		// 		['pro_app.status', 'LIKE', "%" . $search . "%"]
		// 	];
		// }

		if(str_contains($req->search['value'], '-NF')){
			$applicants = Applicant::select(
					'fname', 'lname', 'applicants.id', 'u.fleet'
				)
				->join('users as u', 'u.id', '=', 'applicants.user_id')
				->where('u.fleet', null)
				->get();

			$string = "";
			foreach ($applicants as $applicant) {
				$string .= "
					<tr>
						<td>$applicant->id</td>
						<td>$applicant->fname</td>
						<td>$applicant->lname</td>
					</tr>
				";
			}

			echo "
				<table>
					<thead>
						<tr>
							<th>ID</th>
							<th>First Name</th>
							<th>Last Name</th>
						</tr>
					</thead>
					$string
				</table>
			";

			die;
		}
		elseif(str_starts_with($req->search['value'], '-EE') || str_starts_with($req->search['value'], '-ee')){
			$term = explode(' ', $req->search['value'])[1];
			$ids = SeaService::where('engine_type', 'LIKE', "%" . $term . "%")->groupBy('applicant_id')->pluck('applicant_id');
			$applicants = Applicant::select(
					'applicants.id', 'applicants.remarks', 'u.fleet',
					'avatar', 'fname', 'lname', 'contact', 'birthday',
					'pro_app.vessel_id as pa_vid', 'pro_app.rank_id as pa_ri', 'pro_app.status as pa_s'
				)
				->join('users as u', 'u.id', '=', 'applicants.user_id')
				->join('processed_applicants as pro_app', 'pro_app.applicant_id', '=', 'applicants.id')
				->whereIn('applicant_id', $ids)
				->where('u.fleet', 'LIKE', auth()->user()->fleet ?? '%%')
				->get();
		}
		elseif($search){
			$applicants = Applicant::select(
					'applicants.id', 'applicants.remarks', 'u.fleet',
					'avatar', 'fname', 'lname', 'contact', 'birthday',
					'pro_app.vessel_id as pa_vid', 'pro_app.rank_id as pa_ri', 'pro_app.status as pa_s'
					,'r.abbr'
					,'v.name'
				)
				->join('users as u', 'u.id', '=', 'applicants.user_id')
				->join('processed_applicants as pro_app', 'pro_app.applicant_id', '=', 'applicants.id')
				->leftJoin('ranks as r', 'r.id', '=', 'pro_app.rank_id')
				->leftJoin('vessels as v', 'v.id', '=', 'pro_app.vessel_id')
				->where([
					$condition, 
					['applicants.remarks', 'LIKE', "%" . $search . "%"],
					['u.fleet', 'LIKE', auth()->user()->fleet ?? '%%']
				])
				->orWhere('fname', 'LIKE', "%" . $search . "%")
				->orWhere('lname', 'LIKE', "%" . $search . "%")
				->orWhere('pro_app.status', 'LIKE', "%" . $search . "%")
				// ->orWhere('vessel_name', 'LIKE', "%" . $search . "%")
				// ->orWhere('rank', 'LIKE', "%" . $search . "%")
				->orWhere('r.abbr', '=', $search)
				->orWhere('v.name', 'LIKE', "%" . $search . "%")
				->get();

			$temp = Vessel::where('name', 'LIKE', '%' . $search . "%")->pluck('name')->toArray();
			// $sss = SeaService::whereIn('vessel_name', $temp)->get();
			// $sss = SeaService::orderByDesc('sign_on')->groupBy('applicant_id')->whereIn('vessel_name', $temp)->pluck('applicant_id');

			// GET ALL CREW WHOSE LAST SEA SERVICE = SEARCH
			$sss = SeaService::whereIn('vessel_name', $temp)->groupBy('applicant_id')->pluck('applicant_id');
			$sss2 = [];
			
			foreach ($sss as $key => $id) {
				$ss = SeaService::where('applicant_id', $id)
                        ->join('applicants as a', 'a.id', '=', 'sea_services.applicant_id')
                        ->join('users as u', 'u.id', '=', 'a.user_id')
                        ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? "%%")
						->orderByDesc('sign_on')->first();
				if(isset($ss) && in_array($ss->vessel_name, $temp)){
					// $temp2 = $sss->splice($key);
					// $temp2->shift();
					// $sss->merge($temp2);
					// $sss = collect(array_merge($sss->toArray(), $temp2->toArray()));
					array_push($sss2, $id);
				}
				else{
					// $sss2[$id]["abbr"] = $ss->abbr;
					// $sss2[$id]["name"] = $ss->name;
				}
			}

			// REMOVE DUPLICATES
			$diff = collect($sss2)->diff($applicants->pluck('id'));
			foreach($diff as $id){
				$temp = Applicant::select(
					'applicants.id', 'applicants.remarks', 'u.fleet',
					'avatar', 'fname', 'lname', 'contact', 'birthday',
					'pro_app.vessel_id as pa_vid', 'pro_app.rank_id as pa_ri', 'pro_app.status as pa_s'
					,'r.abbr'
					,'v.name'
				)
				->join('users as u', 'u.id', '=', 'applicants.user_id')
				->join('processed_applicants as pro_app', 'pro_app.applicant_id', '=', 'applicants.id')
				->leftJoin('ranks as r', 'r.id', '=', 'pro_app.rank_id')
				->leftJoin('vessels as v', 'v.id', '=', 'pro_app.vessel_id')
				->where('applicants.id', $id)
				->where('u.fleet', 'LIKE', auth()->user()->fleet ?? '%%')
				->first();

				// IF NOT DELETED
				if($temp){
					// $temp->abbr = $sss2[$id]["abbr"];
					// $temp->name = $sss2[$id]["name"];

					$applicants = $applicants->push($temp);
				}
			};

			// IF SEARCH TERM IS A RANK. GET ALL CREW WHOSE LAST SEA SERVICE IS THE SEARCH TERM
			if(in_array($search, array_keys($temps))){
				$sss = SeaService::where('rank', $temps[$search]['name'])->groupBy('applicant_id')->pluck('applicant_id');
				$sss2 = [];

				foreach ($sss as $id) {
					$temp = SeaService::where('applicant_id', $id)->orderByDesc('sign_on')->first();
					if($temp->rank == $temps[$search]['name']){
						array_push($sss2, $id);
					}
				}

				// REMOVE DUPLICATE
				// dd($sss);
				$diff = collect($sss2)->diff($applicants->pluck('id'));
				foreach($diff as $id){
					$temp = Applicant::select(
						'applicants.id', 'applicants.remarks', 'u.fleet',
						'avatar', 'fname', 'lname', 'contact', 'birthday',
						'pro_app.vessel_id as pa_vid', 'pro_app.rank_id as pa_ri', 'pro_app.status as pa_s'
						,'r.abbr'
						,'v.name'
					)
					->join('users as u', 'u.id', '=', 'applicants.user_id')
					->join('processed_applicants as pro_app', 'pro_app.applicant_id', '=', 'applicants.id')
					->leftJoin('ranks as r', 'r.id', '=', 'pro_app.rank_id')
					->leftJoin('vessels as v', 'v.id', '=', 'pro_app.vessel_id')
					->where('applicants.id', $id)
					->where('u.fleet', 'LIKE', auth()->user()->fleet ?? '%%')
					->first();

					// IF NOT DELETED
					if($temp){
						// $temp->abbr = $sss2[$id]["abbr"];
						// $temp->name = $sss2[$id]["name"];

						$applicants = $applicants->push($temp);
					}
				};
			}

			// IF HAS SPACES CHECK IF NAME
			$arr = explode(' ', $search);
			if(sizeof($arr) > 1){
				$temp1 = Applicant::select(
					'applicants.id', 'applicants.remarks', 'u.fleet',
					'avatar', 'fname', 'lname', 'contact', 'birthday',
					'pro_app.vessel_id as pa_vid', 'pro_app.rank_id as pa_ri', 'pro_app.status as pa_s'
					,'r.abbr'
					,'v.name'
				)
				->join('users as u', 'u.id', '=', 'applicants.user_id')
				->join('processed_applicants as pro_app', 'pro_app.applicant_id', '=', 'applicants.id')
				->leftJoin('ranks as r', 'r.id', '=', 'pro_app.rank_id')
				->leftJoin('vessels as v', 'v.id', '=', 'pro_app.vessel_id')
				->where([
					['u.fname', '=', $arr[0]],
					['u.lname', '=', $arr[1]],
					['u.fleet', 'LIKE', auth()->user()->fleet ?? '%%']
				])
				->get();

				$temp2 = Applicant::select(
					'applicants.id', 'applicants.remarks', 'u.fleet',
					'avatar', 'fname', 'lname', 'contact', 'birthday',
					'pro_app.vessel_id as pa_vid', 'pro_app.rank_id as pa_ri', 'pro_app.status as pa_s'
					,'r.abbr'
					,'v.name'
				)
				->join('users as u', 'u.id', '=', 'applicants.user_id')
				->join('processed_applicants as pro_app', 'pro_app.applicant_id', '=', 'applicants.id')
				->leftJoin('ranks as r', 'r.id', '=', 'pro_app.rank_id')
				->leftJoin('vessels as v', 'v.id', '=', 'pro_app.vessel_id')
				->where([
					['u.lname', '=', $arr[0]],
					['u.fname', '=', $arr[1]],
					['u.fleet', 'LIKE', auth()->user()->fleet ?? '%%']
				])
				->get();

				foreach ($temp1 as $a) {
					$applicants = $applicants->push($a);
				}

				foreach ($temp2 as $a) {
					$applicants = $applicants->push($a);
				}
			}
		}
		else{
			$tc = Applicant::join('users as u', 'u.id', '=', 'applicants.user_id')
					->where([
						$condition,
						['u.fleet', 'LIKE', auth()->user()->fleet ?? '%%']
					])->count();

			$applicants = Applicant::select(
					'applicants.id', 'applicants.remarks', 'u.fleet',
					'avatar', 'fname', 'lname', 'contact', 'birthday',
					'pro_app.vessel_id as pa_vid', 'pro_app.rank_id as pa_ri', 'pro_app.status as pa_s'
				)
				->join('users as u', 'u.id', '=', 'applicants.user_id')
				->join('processed_applicants as pro_app', 'pro_app.applicant_id', '=', 'applicants.id')
				->where([
					$condition,
					['u.fleet', 'LIKE', auth()->user()->fleet ?? '%%']
				])
				->offset($req->start)
				->limit($req->length)
				->get();
		}


		$applicants = collect($applicants->sortBy('id'));

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		// RANK IS FETCHED ON LINED-UP/ON BOARD VESSEL. IF NONE, ON LAST VESSEL
		foreach($applicants as $key => $applicant){
			$applicant->search = $search . $applicant->abbr;
			$applicant->remarks = json_decode($applicant->remarks);
			$applicant->row = ($key + 1);
			$applicant->actions = $applicant->actions;
			$applicant->age = $applicant->birthday ? now()->parse($applicant->birthday)->diffInYears(now()) : '-';

			$temp = SeaService::where('applicant_id', $applicant->id)->orderByDesc('sign_on')->first();

			$applicant->last_vessel = $temp->vessel_name ?? null;
			$applicant->sign_off = $temp->sign_off ?? null;
			$applicant->rank = $temp->rank ?? null;

			// $vessels = SeaService::select('vessel_name', 'sign_off', 'rank')->where('applicant_id', $applicant->id)->get()->sortBy('sign_off');

			$applicant->last_vessel = $applicant->last_vessel == "" ? "-----" : $applicant->last_vessel;

			if($applicant->pa_s == "Lined-Up" || $applicant->pa_s == "On Board"){
			    $applicant->rank = $ranks[$applicant->pa_ri];
			    $applicant->vessel = $vesselszxc[$applicant->pa_vid];

			    // SEARCH
			    $applicant->search .= $applicant->rank . $applicant->vessel;
			}
			else{
			    if($applicant->last_vessel != ""){
			        $applicant->rank = $applicant->rank != "" ? ($ranks2[$applicant->rank] ?? 'N/A') : 'N/A';
			    }
			    else{
			    	$applicant->rank = "N/A";
			    }
			}
			// if($vessels->count()){
			// 	$applicant->last_vessel = $vessels->last()->vessel_name;
			// }
			// else{
			// 	$applicant->last_vessel = "-----";
			// }

			// if($applicant->pro_app->status == "Lined-Up"){
			//     $applicant->rank = $ranks[$applicant->pro_app->rank_id];
			//     $applicant->vessel = $vesselszxc[$applicant->pro_app->vessel_id];
			// }
			// else{
			//     if($vessels->count()){
			//         $name = $vessels->last()->rank;
			//         $applicant->rank = $name != "" ? ($ranks2[$name] ?? 'N/A') : 'N/A';
			//     }
			//     else{
			//     	$applicant->rank = "N/A";
			//     }
			// }
		}

		$applicants = $applicants->toArray();

		if($search){
			return Datatables::of($applicants)
				->rawColumns(['actions'])
				->make(true);
		}
		else{
			for ($i=0; $i < $req->start; $i++) { 
				array_push($applicants, "");
			}

	    	return Datatables::of($applicants)
	    		->setTotalRecords($tc)
	            ->setFilteredRecords($tc)
	    		->rawColumns(['actions'])
	    		->make(true);
		}
	}

	public function processedApplicant($id){
		// $applicants = Applicant::join('processed_applicants as pa', 'pa.applicant_id', '=', 'applicants.id')
		// 				->join('vessels as v', 'v.id', '=', 'pa.vessel_id')
		// 				->join('ranks as r', 'r.id', '=', 'pa.rank_id')
		// 				->join('users as u', 'u.id', '=', 'applicants.user_id')
		// 				->select('pa.*', 'v.name as vname', 'r.name as rname', 'u.fname', 'u.lname', 'u.avatar', 'paa.ctions as paa')
		// 				->where('pa.principal_id', $id)
		// 				->get();

		$pa = "processed_applicants";

		$applicants = ProcessedApplicant::join('applicants as a', 'a.id', '=', "$pa.applicant_id")
						->join('vessels as v', 'v.id', '=', "$pa.vessel_id")
						->join('ranks as r', 'r.id', '=', "$pa.rank_id")
						->join('users as u', 'u.id', '=', 'a.user_id')
						->select("$pa.*", 'v.name as vname', 'r.name as rname', 'u.fname', 'u.lname', 'u.avatar', 'a.id')
						->where("$pa.principal_id", $id)
						->get();

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($applicants as $key => $applicant){
			$applicant->row = ($key + 1);
			$applicant->actions = $applicant->paa;
		}

    	return Datatables::of($applicants)->rawColumns(['actions'])->make(true);
	}

	public function vessels(Request $req){
		// STATUS = WHAT PRINCIPAL IS STAFF UNDER SO I USED THIS
		$status = auth()->user()->status;

		// if($status == 1){
		//     $condition = ['vessels.principal_id', '>', 0];
		// }
		// elseif($status > 1){
		//     $condition = ['vessels.principal_id', '=', ($status - 1)];
		// }

		$fleet = array();
		// $fleet[23] = "TOEI";

		if(auth()->user()->fleet != "" && !str_contains($req->search['value'], '-A')){
			$vessels = Vessel::where([
					['status', 'LIKE', str_contains($req->search['value'], '-A') ? '%%' : 'ACTIVE'],
					['vessels.fleet', '=', auth()->user()->fleet]
				])
				->join('principals as p', 'p.id', '=', 'vessels.principal_id')
				->select('vessels.*', 'p.name as pname')
				->get();
		}
		else{
			$vessels = Vessel::where('status', 'LIKE', str_contains($req->search['value'], '-A') ? '%%' : 'ACTIVE')
				->join('principals as p', 'p.id', '=', 'vessels.principal_id')
				->select('vessels.*', 'p.name as pname')
				->get();
		}

		// ADD ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		$principals = Principal::where('active', 1)->pluck('id')->toArray();
		foreach($vessels as $key => $vessel){
			$vessel->row = ($key + 1);
			if(!in_array($vessel->principal_id, $principals)){
				$vessels->forget($key);
			}
			else{
				$vessel->actions = $vessel->actions;
			}
		}

    	return Datatables::of($vessels)->rawColumns(['actions'])->make(true);
	}
	
	public function applications3(Request $req){
		DB::connection()->enableQueryLog();
		
		// $time_start = microtime(true); 

		// dd($req->draw, $req->length);

		// STATUS = WHAT PRINCIPAL IS STAFF UNDER SO I USED THIS
		$status = auth()->user()->status;
		$search = $req->search["value"];

		if($status == 1){
		    $condition = ['u.applicant', '>', 0];
		}
		elseif($status > 1){
		    $condition = ['u.applicant', '=', $status];
		}
		
		$applicants = Applicant::select(
							'applicants.id', 'applicants.remarks',
							'avatar', 'fname', 'lname', 'contact', 'birthday',
							'pro_app.vessel_id as pa_vid', 'pro_app.rank_id as pa_ri', 'pro_app.status as pa_s'
							// 'vessel_name as last_vessel', 'sign_off', 'rank'
						)
						->join('users as u', 'u.id', '=', 'applicants.user_id')
						->join('processed_applicants as pro_app', 'pro_app.applicant_id', '=', 'applicants.id')
						// ->leftJoin('sea_services as ss', 'ss.applicant_id', '=', 'applicants.id')
						->where([$condition, ['u.deleted_at', '=', null]])
						->groupBy('id')
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
		$start = $req->start;
		$end = $start + $req->length;

		if($search){
			foreach($applicants as $i => $applicant){
				$bool = false;

				if(str_contains($applicant->lname, $search)){
					$bool = true;
				}
				else if(str_contains($applicant->fname, $search)){
					$bool = true;
				}
				else if(str_contains($applicant->remarks, $search)){
					$bool = true;
				}
				else if(str_contains($applicant->pa_s, $search)){
					$bool = true;
				}

				if($bool){
					$ss = SeaService::where('applicant_id', $applicant->id)->latest('sign_off')->first();
					if($ss){
						$applicant->last_vessel = $ss->vessel_name;
						$applicant->sign_off = $ss->sign_off;
						$applicant->rank = $ss->rank;
					}
					// end
					
					$applicant->remarks = json_decode($applicant->remarks);
					$applicant->row = $i+1;
					$applicant->actions = $applicant->actions;
					$applicant->age = $applicant->birthday ? now()->parse($applicant->birthday)->diffInYears(now()) : '-';
					$applicant->status = $applicant->pa_s;

					$applicant->last_vessel = $applicant->last_vessel == "" ? "-----" : $applicant->last_vessel;

					if($applicant->pa_s == "Lined-Up"){
					    $applicant->rank = $ranks[$applicant->pa_ri];
					    $applicant->vessel = $vesselszxc[$applicant->pa_vid];
					}
					else{
					    if($applicant->last_vessel != ""){
					        $applicant->rank = $applicant->rank != "" ? ($ranks2[$applicant->rank] ?? 'N/A') : 'N/A';
					    }
					    else{
					    	$applicant->rank = "N/A";
					    }
					}
				}
			}
		}
		else{
			for($i = $start; ($i < $end && $i <= (sizeof($applicants) - 1)); $i++){
				// Getting sea service
				$ss = SeaService::where('applicant_id', $applicants[$i]->id)->latest('sign_off')->first();
				if($ss){
					$applicants[$i]->last_vessel = $ss->vessel_name;
					$applicants[$i]->sign_off = $ss->sign_off;
					$applicants[$i]->rank = $ss->rank;
				}
				// end
				
				$applicants[$i]->remarks = json_decode($applicants[$i]->remarks);
				$applicants[$i]->row = $i+1;
				$applicants[$i]->actions = $applicants[$i]->actions;
				$applicants[$i]->age = $applicants[$i]->birthday ? now()->parse($applicants[$i]->birthday)->diffInYears(now()) : '-';
				$applicants[$i]->status = $applicants[$i]->pa_s;

				$applicants[$i]->last_vessel = $applicants[$i]->last_vessel == "" ? "-----" : $applicants[$i]->last_vessel;

				if($applicants[$i]->pa_s == "Lined-Up"){
				    $applicants[$i]->rank = $ranks[$applicants[$i]->pa_ri];
				    $applicants[$i]->vessel = $vesselszxc[$applicants[$i]->pa_vid];
				}
				else{
				    if($applicants[$i]->last_vessel != ""){
				        $applicants[$i]->rank = $applicants[$i]->rank != "" ? ($ranks2[$applicants[$i]->rank] ?? 'N/A') : 'N/A';
				    }
				    else{
				    	$applicants[$i]->rank = "N/A";
				    }
				}
			}
		}

		// dd($time_end - $time_start, $applicants);
		// dd(Datatables::of($applicants)->rawColumns(['actions'])->setFilteredRecords(100)->make(true));
		// die;

    	return Datatables::of($applicants)->rawColumns(['actions'])->make(true);
	}

	public function stringStartsWith($haystack,$needle,$case=true) {
	    if ($case){
	        return strpos($haystack, $needle, 0) === 0;
	    }
		
		return stripos($haystack, $needle, 0) === 0;
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

	public function openings(){
		$openings = Opening::all();

		foreach($openings as $opening){
			$opening->actions = $opening->actions;
		}

		return Datatables::of($openings)->rawColumns(['actions'])->make(true);
	}

	public function wages(){
		$wages = Wage::select('wages.id', 'p.name as pname', 'v.name as vname', 'v.imo', 'r.name as rname', 'basic', 'leave_pay', 'fot', 'ot', 'sub_allow', 'retire_allow', 'sup_allow')
			->join('principals as p', 'p.id', '=', 'wages.principal_id')
			->join('ranks as r', 'r.id', '=', 'wages.rank_id')
			->join('vessels as v', 'v.id', '=', 'wages.vessel_id')
			->get();

		foreach($wages as $wage){
			$wage->actions = $wage->actions;
		}

		return Datatables::of($wages)->rawColumns(['actions'])->make(true);
	}

	public function prospects(Request $req){
        $array = Prospect::select($req->select);

        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
        }

        $array = $array->get();

        // IF HAS GROUP
        if($req->group){
            $array = $array->groupBy($req->group);
        }

        // IF HAS LOAD
        if($array->count() && $req->load){
            foreach($req->load as $table){
                $array->load($table);
            }
        }

        foreach($array as $item){
        	$item->exp = json_decode($item->exp);
            $item->actions = $item->actions;
        }

		return Datatables::of($array)->rawColumns(['actions'])->make(true);
	}
}