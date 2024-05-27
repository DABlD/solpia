<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\{Applicant, ProcessedApplicant};
use App\Models\{Vessel, Rank, Principal};
use App\Models\{AuditTrail, SeaService, Opening};

use App\Models\{TempApplicant, TempSeaService};
use App\Models\{Wage};
use App\Models\{Prospect, Requirement, Candidate};

use App\Models\{DocumentFlag};

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
		DB::enableQueryLog();
		$applicants = Applicant::select('applicants.*', 'pa.status as pas')
								->orderBy('created_at', 'DESC')
								->join('users as u', 'u.id', '=', 'applicants.user_id')
								->join('processed_applicants as pa', 'pa.applicant_id', '=', 'applicants.id')
								->where('pa.status', 'like', $req->filters['fStatus'])
								->where(function($q){
									if(auth()->user()->fleet){
										$q->where('u.fleet', 'like', auth()->user()->fleet);
									}
								});

		// IF DID NOT USE FILTER AND ONLY SEARCH VALUE
		if($req->search['value']){
			$applicants = $applicants->where(function($q) use($req){
									 	$q->where('u.fname', 'like', "%" . $req->search['value'] . "%");
									 	$q->orWhere('u.lname', 'like', "%" . $req->search['value'] . "%");
									 });
		}
		else{
			// APPLY FILTERS
			$filters = $req->filters;

			// NAME FILTER
			$applicants = $applicants->where(function($q) use($filters){
										$q->where('u.fname', 'LIKE', "%" . $filters["fFname"] ?? "" . "%");
										$q->where('u.lname', 'LIKE', "%" . $filters["fLname"] ?? "" . "%");
									});

			// AGE FILTER
			if(isset($filters['fMin_age'])){
				$max_date = now()->subYears($filters['fMin_age'])->format('Y-m-d');

				if(isset($filters['fMax_age'])){
					$min_date = now()->subYears($filters['fMax_age'])->format('Y-m-d');
					$applicants = $applicants->whereBetween('u.birthday', [$min_date, $max_date]);
				}
				else{
					$applicants = $applicants->where('u.birthday', '<=', $max_date);
				}
			}
			elseif(isset($filters['fMax_age'])){
				$min_date = now()->subYears($filters['fMax_age'])->format('Y-m-d');
				$applicants = $applicants->where('u.birthday', '>=', $min_date);
			}

			// INIT RANK FILTER
			if(isset($filters['fRanks'])){
				$applicants->whereIn('pa.rank_id', $filters['fRanks']);
			}
		}

    	$tc = $applicants->count();
    	$applicants = $applicants->offset($req->start)->limit($req->length);
    	$applicants = $applicants->get();

    	dd(DB::getQueryLog(), $tc);

    	// GETTING ADDITIONAL DETAILS
    	$applicants->load('user');
    	$applicants->load('pro_app.vessel');
    	foreach($applicants as $applicant){
    		// RANK FILTER


    		$last_vessel = SeaService::where('applicant_id', $applicant->id)->orderBy('created_at', 'DESC')->first();
    		$latest_flag = DocumentFlag::where('applicant_id', $applicant->id)->orderBy('issue_date', 'DESC')->first();

    		$applicant->last_vessel = $last_vessel ?? ["vessel_name" => "-", "sign_off" => null];
    		$applicant->age = $applicant->user->birthday ? now()->diffInYears($applicant->user->birthday) : $applicant->user->age;

    		// SETTING RANK
    		$applicant->rank = "-";

    		if(isset($applicant->pro_app->rank)){
    			$applicant->rank = $applicant->pro_app->rank->abbr;
    		}
    		elseif(isset($last_vessel->rank2)){
    			$applicant->rank = $last_vessel->rank2->abbr;
    		}
    		elseif(isset($latest_flag->rankz)){
    			$applicant->rank = $latest_flag->rankz->abbr;
    		}

    		// REMARKS
    		$applicant->remarks = json_decode($applicant->remarks);

    		// ACTIONS
    		$applicant->actions = $applicant->actions;
    	}

    	// SORTING DATA
    	$array = [];

    	// FILL IN FRONT
    	for($i = $req->start; $i > 0; $i--){
    		array_push($array, []);
    	}

    	// MERGE ACTUAL VISIBLE DATA
    	$array = array_merge($array, $applicants->toArray());

    	// FILL IN END
    	// for($i = $req->start; $i <= $tc; $i++){
    	// 	array_push($array, []);
    	// }

    	// dd($array);

	    return Datatables::of($array)
    		->setTotalRecords($tc)
            ->setFilteredRecords($tc)
    		->rawColumns(['actions'])
    		->make(true);
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

		$f = $req->filters; //FILTERS
		$vessels = Vessel::join('principals as p', 'p.id', '=', 'vessels.principal_id')
			->select('vessels.*', 'p.name as pname')
			->where(function($q) use($f){
				$q->where('vessels.fleet', 'like', $f['fleet']);
				$q->where('principal_id', 'like', $f['principal']);
				$q->where('flag', 'like', $f['flag']);
				$q->where('type', 'like', $f['type']);
				$q->where('status', 'like', $f['status']);
			})->get();

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
		// DB::enableQueryLog();
        $array = Prospect::select($req->select ?? "*")->orderBy('updated_at', 'desc');

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

		// $start = 20;
    	$tc = $array->count();
    	$array = $array->offset($start ?? $req->start)->limit($req->length);

		$array = $array->get();

		// dd($array->toArray());

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
					// ->where('vessel_id', 'like', $req->vessel)
					->where(function($q) use($req){
					    if($req->vessel == "%%"){
						    $q->where('vessel_id', 'like', $req->vessel);
						    $q->orWhereNull('vessel_id');
					    }
					    else{
						    $q->where('vessel_id', 'like', $req->vessel);
					    }
					})
					->where('rank', 'like', $req->rank)
					// ->where('joining_date', 'like', $req->date)
					->where('status', 'like', $req->status);

		if($req->user_id){
			$array = $array->where('user_id', 'like', $req->user_id);
		}

		$array = $array->get();

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

	public function candidates(Request $req){
		$array = Candidate::where('candidates.status', 'like', $req->status)
					->where(function($q) use($req){
					    if($req->vessel == "%%"){
						    $q->where('candidates.vessel_id', 'like', $req->vessel);
						    $q->orWhereNull('candidates.vessel_id');
					    }
					    else{
						    $q->where('candidates.vessel_id', 'like', $req->vessel);
					    }
					})
					->join('prospects as p', 'p.id', '=', 'candidates.prospect_id')
					->join('requirements as r', 'r.id', '=', 'candidates.requirement_id')
					->where('r.rank', 'like', $req->rank)
					->where('r.fleet', 'like', $req->fleet)
					->select('candidates.*', 'r.fleet as fleet');

		$array = $array->get();

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