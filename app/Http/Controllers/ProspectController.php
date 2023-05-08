<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prospect;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Reports\Prospect as ProspectReport;

use DB;

class ProspectController extends Controller
{
    public function __construct(){
        $this->table = "prospects";
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Applicants'
        ]);
    }

    public function get(Request $req){
        $array = Prospect::select($req->select);

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
        $data = new Prospect();
        $data->name = $req->name;
        $data->birthday = $req->birthday;
        $data->age = $req->birthday ? now()->parse($req->birthday)->age : $req->age;
        $data->contact = $req->contact;
        $data->email = $req->email;
        $data->rank = $req->rank;
        $data->usv = $req->usv;
        $data->contracts = $req->contracts;
        $data->exp = json_encode($req->exp);
        $data->availability = $req->availability;
        $data->last_disembark = $req->last_disembark;
        $data->location = $req->location;
        $data->previous_salary = $req->previous_salary;
        $data->previous_agency = $req->previous_agency;
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

    public function delete(Request $req){
        Prospect::find($req->id)->delete();
    }

    public function import(Request $req){
    	$class = "App\Imports\\" . $req->import;
        Excel::import(new $class, $req->file('file'));

        if(true){
            $req->session()->flash('success', 'Successfully Imported');
            return back();
        }
        else{
            $req->session()->flash('error', 'Please Try Again.');
            return back();
        }
    }

    public function report($from, $to){
        $data = Prospect::whereBetween('created_at', [$from, $to])->get();
        $data->load('candidates');

        $from = now()->parse($from)->toFormattedDateString();
        $to = now()->parse($to)->toFormattedDateString();

        $fileName = "$from - $to Applicants";

        return Excel::download(new ProspectReport($data->toArray(), $from, $to), "$fileName.xlsx");
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}
