<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Candidate, Requirement, Prospect};
use DB;

class CandidateController extends Controller
{
    public function __construct(){
        $this->table = "candidates";
    }

    public function get(Request $req){
        $array = Candidate::select($req->select ?? "*");

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
        }

        $array = $array->get();

        // IF HAS LOAD
        if($array->count() && $req->load){
            foreach($req->load as $table){
                $array->load($table);
            }
        }

        // IF HAS GROUP
        if($req->group){
            $array = $array->groupBy($req->group);
        }

        if($req->where[0] == "requirement_id"){
            $requirement = Requirement::with('rank', 'vessel')->find($req->where[1]);
            $array = ["req" => $requirement, "candidates" => $array];
        }

        echo json_encode($array);
    }

    public function store(Request $req){
        $data = new Candidate();
        $data->requirement_id = $req->requirement_id;
        $data->prospect_id = $req->prospect_id;
        $data->vessel_id = $req->vessel_id;
        $data->save();

        Prospect::where('id', $data->prospect_id)->update(["status" => "ON PROCESS"]);
    }

    public function update(Request $req){
        $query = DB::table($this->table);

        if($req->where){
            $query = $query->where($req->where[0], $req->where[1])->update($req->except(['id', '_token', 'where']));
        }
        else{
            $query = $query->where('id', $req->id)->update($req->except(['id', '_token']));
        }

        if(isset($req->status)){
            if($req->status == "FOR APPROVAL"){
                $can = Candidate::find($req->id);                
                Prospect::where('id', $can->prospect_id)->update(["status" => "ENDORSED"]);
            }
            elseif($req->status == "REJECTED"){
                $can = Candidate::find($req->id);                
                Prospect::where('id', $can->prospect_id)->update(["status" => "AVAILABLE"]);
            }
            elseif($req->status == "ON BOARD"){
                $can = Candidate::find($req->id);                
                Prospect::where('id', $can->prospect_id)->update(["status" => "HIRED"]);
            }
        }
    }
}
