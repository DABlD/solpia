<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\{Rank, Appointment};
use Yajra\Datatables\Datatables;
use DB;

class AppointmentController extends Controller
{
    public function __construct(){
        $this->table = "appointments";
    }

    public function index(){
        $ranks = Rank::select('name', 'abbr')->get();
        $users = User::whereIn('role', ['Crewing Manager', 'Crewing Officer', 'Processing', 'Training', 'Recruitment Officer'])
                        ->where('status', 1)
                        ->select('fname', 'lname', 'gender')->get();

        return $this->_view('index', [
            'title' => 'Appointment',
            'ranks' => $ranks,
            'users' => $users
        ]);
    }

    public function get(Request $req){
        $array = Appointment::select($req->select ?? "*");

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

        foreach($array as $item){
            $item->actions = $item->actions;
        }

        if(isset($req->columns)){
            return Datatables::of($array)->rawColumns(['actions'])->make(true);
        }
        else{
            echo json_encode($array);
        }
    }

    public function store(Request $req){
        $data = new Appointment();
        $data->rank = $req->rank;
        $data->name = $req->name;
        $data->assigned_vessel = $req->assigned_vessel;
        $data->person_to_visit = $req->person_to_visit;
        $data->purpose_of_visit = $req->purpose_of_visit;
        $data->status = $req->status;
        $data->remarks = $req->remarks;
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
