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
		// DB::connection()->enableQueryLog();

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

		if($search){
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
				->where([$condition])
				// ->where('u.fleet', 'like', auth()->user()->fleet ?? "%%")
				->where(function($q) use($search){
					$q->where('applicants.remarks', 'LIKE', "%$search%");
					$q->orWhere('fname', 'LIKE', "%$search%");
					$q->orWhere('lname', 'LIKE', "%$search%");
					$q->orWhere('pro_app.status', 'LIKE', "%$search%");
					$q->orWhere('r.abbr', '=', $search);
					$q->orWhere('v.name', 'LIKE', "%$search%");
				});
				// ->get();
				// ->orWhere('vessel_name', 'LIKE', "%" . $search . "%")
				// ->orWhere('rank', 'LIKE', "%" . $search . "%")
			if(auth()->user()->fleet){
				// MA'AM JOBELLE
				if(in_array(auth()->user()->id, [4504, 4545, 4861, 4988])){
					$applicants->where(function($q) use($search){
						$q->where('u.fleet', 'like', auth()->user()->fleet);
						$q->orWhere('u.fleet', 'like', "FLEET A");
					});
				}
				else{
					$applicants->where('u.fleet', 'like', auth()->user()->fleet);
				}
			}
			$applicants = $applicants->get();

			$temp = Vessel::where('name', 'LIKE', '%' . $search . "%")->pluck('name')->toArray();
			// $sss = SeaService::whereIn('vessel_name', $temp)->get();
			// $sss = SeaService::orderByDesc('sign_on')->groupBy('applicant_id')->whereIn('vessel_name', $temp)->pluck('applicant_id');

			// GET ALL CREW WHOSE LAST SEA SERVICE = SEARCH
			$sss = SeaService::whereIn('vessel_name', $temp)->groupBy('applicant_id')->pluck('applicant_id');
			$sss2 = [];
			
			foreach ($sss as $key => $id) {
				$ss = SeaService::where('applicant_id', $id)
                        ->join('applicants as a', 'a.id', '=', 'sea_services.applicant_id')
                        ->join('users as u', 'u.id', '=', 'a.user_id');
      //                   ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? "%%")
						// ->orderByDesc('sign_on')->first();

				
				if(auth()->user()->fleet){
					// MA'AM JOBELLE
					if(in_array(auth()->user()->id, [4504, 4545, 4861, 4988])){
						$ss->where(function($q) use($search){
							$q->where('u.fleet', 'like', auth()->user()->fleet);
							$q->orWhere('u.fleet', 'like', "FLEET A");
						});
					}
					else{
						$ss->where('u.fleet', 'like', auth()->user()->fleet);
					}
				}

				$ss = $ss->orderByDesc('sign_on')->first();

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
				->where('applicants.id', $id);
				// ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? '%%')
				// ->first();

				if(auth()->user()->fleet){
					// MA'AM JOBELLE
					if(in_array(auth()->user()->id, [4504, 4545, 4861, 4988])){
						$temp->where(function($q) use($search){
							$q->where('u.fleet', 'like', auth()->user()->fleet);
							$q->orWhere('u.fleet', 'like', "FLEET A");
						});
					}
					else{
						$temp->where('u.fleet', 'like', auth()->user()->fleet);
					}
				}

				$temp = $temp->first();

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
					->where('applicants.id', $id);
					// ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? '%%')
					// ->first();

					if(auth()->user()->fleet){
						// MA'AM JOBELLE
						if(in_array(auth()->user()->id, [4504, 4545, 4861, 4988])){
							$temp->where(function($q) use($search){
								$q->where('u.fleet', 'like', auth()->user()->fleet);
								$q->orWhere('u.fleet', 'like', "FLEET A");
							});
						}
						else{
							$temp->where('u.fleet', 'like', auth()->user()->fleet);
						}
					}

					$temp = $temp->first();

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
					// ['u.fleet', 'LIKE', auth()->user()->fleet ?? '%%']
				]);
				// ->get();

				if(auth()->user()->fleet){
					// MA'AM JOBELLE
					if(in_array(auth()->user()->id, [4504, 4545, 4861, 4988])){
						$temp1->where(function($q) use($search){
							$q->where('u.fleet', 'like', auth()->user()->fleet);
							$q->orWhere('u.fleet', 'like', "FLEET A");
						});
					}
					else{
						$temp1->where('u.fleet', 'like', auth()->user()->fleet);
					}
				}

				$temp1 = $temp1->get();

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
					// ['u.fleet', 'LIKE', auth()->user()->fleet ?? '%%']
				]);
				// ->get();

				if(auth()->user()->fleet){
					// MA'AM JOBELLE
					if(in_array(auth()->user()->id, [4504, 4545, 4861, 4988])){
						$temp2->where(function($q) use($search){
							$q->where('u.fleet', 'like', auth()->user()->fleet);
							$q->orWhere('u.fleet', 'like', "FLEET A");
						});
					}
					else{
						$temp2->where('u.fleet', 'like', auth()->user()->fleet);
					}
				}

				$temp2 = $temp2->get();

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
						// ['u.fleet', 'LIKE', auth()->user()->fleet ?? '%%']
					]);
					// ->count();

			if(auth()->user()->fleet){
				// MA'AM JOBELLE
				if(in_array(auth()->user()->id, [4504, 4545, 4861, 4988])){
					$tc->where(function($q) use($search){
						$q->where('u.fleet', 'like', auth()->user()->fleet);
						$q->orWhere('u.fleet', 'like', "FLEET A");
					});
				}
				else{
					$tc->where('u.fleet', 'like', auth()->user()->fleet);
				}
			}

			$tc = $tc->count();

			$applicants = Applicant::select(
					'applicants.id', 'applicants.remarks', 'u.fleet',
					'avatar', 'fname', 'lname', 'contact', 'birthday',
					'pro_app.vessel_id as pa_vid', 'pro_app.rank_id as pa_ri', 'pro_app.status as pa_s'
				)
				->join('users as u', 'u.id', '=', 'applicants.user_id')
				->join('processed_applicants as pro_app', 'pro_app.applicant_id', '=', 'applicants.id')
				->where([
					$condition,
					// ['u.fleet', 'LIKE', auth()->user()->fleet ?? '%%']
				])
				->offset($req->start)
				->limit($req->length);
				// ->get();

			
			if(auth()->user()->fleet){
				// MA'AM JOBELLE
				if(in_array(auth()->user()->id, [4504, 4545, 4861, 4988])){
					$applicants->where(function($q) use($search){
						$q->where('u.fleet', 'like', auth()->user()->fleet);
						$q->orWhere('u.fleet', 'like', "FLEET A");
					});
				}
				else{
					$applicants->where('u.fleet', 'like', auth()->user()->fleet);
				}
			}

			$applicants = $applicants->get();
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
				])
				->join('principals as p', 'p.id', '=', 'vessels.principal_id')
				->select('vessels.*', 'p.name as pname');

			// MA'AM JOBELLE
			if(in_array(auth()->user()->id, [4504, 4545, 4861, 4988])){
				$vessels->where(function($q){
					$q->where('vessels.fleet', 'like', auth()->user()->fleet);
					$q->orWhere('vessels.fleet', 'like', "FLEET A");
				});
			}
			else{
				$vessels->where('vessels.fleet', 'like', auth()->user()->fleet);
			}

			$vessels = $vessels->get();
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
		$wages = Wage::select('wages.id', 'p.name as pname', 'v.name as vname', 'v.imo', 'r.name as rname', 'basic', 'leave_pay', 'fot', 'ot', 'sub_allow', 'retire_allow', 'sup_allow', 'updated_at')
			->join('principals as p', 'p.id', '=', 'wages.principal_id')
			->join('ranks as r', 'r.id', '=', 'wages.rank_id')
			->join('vessels as v', 'v.id', '=', 'wages.vessel_id')
			->get()->sortByDesc('updated_at');

		foreach($wages as $wage){
			$wage->actions = $wage->actions;
		}

		return Datatables::of($wages)->rawColumns(['actions'])->make(true);
	}

	public function prospects(Request $req){
        $array = Prospect::select($req->select)->orderBy('id', 'desc');

        $filters = $req->filters;
		$search = $req->search["value"];
		
		$array = $array->where(function($q) use($filters){
			if($filters["min_age"] && $filters["max_age"]){
				$q->whereBetween('age', [$filters["min_age"], $filters["max_age"]]);
			}
			elseif($filters["min_age"]){
				$q->where('age', ">", $filters["min_age"]);
			}
			elseif($filters["max_age"]){
				$q->where('age', ">", $filters["max_age"]);
			}
		});

		if(isset($filters["name"]) && $filters["name"] != ""){
			$array = $array->where(function($q) use($filters){
				$name = $filters["name"];
				$q->where("name", 'like', "%$name%");
			});
		}
		if(isset($filters["remarks"]) && $filters["remarks"] != ""){
			$array = $array->where(function($q) use($filters){
				$q->where("remarks", 'like', "%" . $filters["remarks"] . "%");
			});
		}
		if(isset($filters["ranks"])){
			$array = $array->whereIn('rank', $filters["ranks"]);
		}
		if(isset($filters["exp"])){
			$exps = $filters["exp"];
			$array = $array->where(function($q) use($exps){
				foreach($exps as $key => $exp){
					if($key > 0){
						$q->orWhere('exp', 'like', '%' . $exp . '%');
					}
					else{
						$q->where('exp', 'like', '%' . $exp . '%');
					}
				}
			});
		}
		if(isset($filters["usv"]) && $filters["usv"] != ""){
			$array = $array->where(function($q) use($filters){
				$q->where('usv', '>', now()->toDateString());
				$q->orWhere("usv", ">", now()->format("Y"));
				$q->orWhere("usv", "YES");
				$q->orWhere("usv", "W/ VISA");
			});
		}

    	$tc = $array->count();
    	$array = $array->offset($req->start)->limit($req->length);

		$array = $array->get();

        foreach($array as $item){
            $item->actions = $item->actions;
        }

		$array = $array->toArray();

		for ($i=0; $i < $req->start; $i++) { 
			array_unshift($array, "");
		}

	    return Datatables::of($array)
    		->setTotalRecords($tc)
            ->setFilteredRecords($tc)
    		->rawColumns(['actions'])
    		->make(true);
	}

	public function requirements(Request $req){
		$array = Requirement::where('fleet', 'like', $req->fleet)
					->where('vessel_id', 'like', $req->vessel)
					->where('rank', 'like', $req->rank)
					->where('joining_date', 'like', $req->date)
					->where('status', 'like', $req->status)
					->get();

        foreach($array as $item){
            $item->actions = $item->actions;
        }

        // IF HAS LOAD
        if($array->count() && $req->load){
            foreach($req->load as $table){
                $array->load($table);
            }
        }

		$array = $array->toArray();

	    return Datatables::of($array)
    		->rawColumns(['actions'])
    		->make(true);
	}

    public function suggestCandidate(Request $req){
    	if($req->search["value"] == ""){
	        $suggestions = Prospect::where('rank', $req->rank)
								->where('status', "AVAILABLE")
	                            ->where(function($q) use($req){
	                                $bday = now()->subYears($req->age)->toDateString();

	                                $q->where('age', '<=', $req->age);
	                                $q->orWhere('birthday','>=', $bday);
	                            });

	        if($req->usv){
	            $suggestions->whereNotNull('usv');
	        }

	        $suggestions = $suggestions->latest()->take(10)->get();

	        foreach($suggestions as $item){
	            $item->actions2 = $item->actions2;
	        }

	        $suggestions = $suggestions->toArray();

		    return Datatables::of($suggestions)
	    		->make(true);
    	}
    	else{
    		$search = $req->search["value"];
			$array = Prospect::where('name', 'like', "%$search%")
								->where('status', "AVAILABLE")
								->get();

	        foreach($array as $item){
	            $item->actions2 = $item->actions2;
	        }

			$array = $array->toArray();

		    return Datatables::of($array)
	    		->make(true);
    	}
    }

	public function principals(Request $req){
		$array = Principal::where('fleet', 'like', $req->fleet)->get();

        foreach($array as $item){
            $item->actions = $item->actions;
        }

		$array = $array->toArray();

	    return Datatables::of($array)
    		->rawColumns(['actions'])
    		->make(true);
	}
}