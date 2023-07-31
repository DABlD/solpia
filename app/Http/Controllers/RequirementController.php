<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Requirement, Prospect};
use DB;

class RequirementController extends Controller
{
    public function __construct(){
        $this->table = "requirements";
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Requirements'
        ]);
    }

    public function get(Request $req){
        $array = Requirement::select($req->select);

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

        echo json_encode($array);
    }

    public function store(Request $req){
        $data = new Requirement();
        $data->vessel_id = $req->vessel_id;
        $data->rank = $req->rank;
        $data->joining_date = $req->joining_date;
        $data->joining_port = $req->joining_port;
        $data->usv = $req->usv;
        $data->salary = $req->salary;
        $data->remarks = $req->remarks;
        $data->max_age = $req->max_age;
        $data->fleet = $req->fleet;
        $data->save();
    }

    public function update(Request $req){
        $query = DB::table($this->table);

        if($req->where){
            $query = $query->where($req->where[0], $req->where[1])->update($req->except(['id', '_token', 'where']));
        }
        else{
            $query = $query->where('id', $req->id)->update($req->except(['id', '_token']));
        }
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}
