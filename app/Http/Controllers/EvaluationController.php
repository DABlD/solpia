<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Evaluation;
use DB;

class EvaluationController extends Controller
{
    public function get(Request $req){
        $array = DB::table('evaluations')->select($req->select);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
        }

        // IF HAS WHERE2
        if($req->where){
            $array = $array->where($req->where2[0], $req->where2[1]);
        }

        // IF HAS JOIN
        if($req->join){
            $alias = substr($req->join, 1);
            $array = $array->join("$req->join as $alias", "$alias.fid", '=', 'evaluations.id');
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

        echo json_encode($array);
    }

    public function create(Request $req){
        $data = new Evaluation();
        $data->applicant_id = $req->applicant_id;
        $data->type = $req->type;
        $data->value = $req->value;
        $data->vessel = $req->vessel;
        $data->date = $req->date;
        $data->file = $req->file;

        echo $data->save();
    }

    public function update(Request $req){
        echo DB::table('evaluations')->where('id', $req->id)->update($req->except(['id', '_token']));
    }
}
