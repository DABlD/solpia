<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Prospect, Candidate};

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Reports\Prospect as ProspectReport;
use App\Exports\Reports\Deployment as DeploymentReport;
use App\Exports\Reports\Prospect2 as ProspectReport2;

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
        $data->height = $req->height;
        $data->weight = $req->weight;
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
        $data->source = $req->source;
        $data->save();
    }

    public function update(Request $req){
        $query = DB::table($this->table);
        
        if($req->where){
            $query = $query->where($req->where[0], $req->where[1])->update(array_merge($req->except(['id', '_token', 'where']), ['updated_at' => now()]));
        }
        else{
            $query = $query->where('id', $req->id)->update(array_merge($req->except(['id', '_token']), ['updated_at' => now()]));
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
        // DB::enableQueryLog();
        // $data = Prospect::whereBetween('updated_at', [$from, $to])->get();
        $data = Prospect::where('updated_at', ">=", $from . " 00:00:00")->where('updated_at', "<=", $to . " 23:59:59")->get();
        // dd(DB::getQueryLog());
        $data->load('candidates');

        $from = now()->parse($from)->toFormattedDateString();
        $to = now()->parse($to)->toFormattedDateString();

        $fileName = "$from - $to Applicants";

        return Excel::download(new ProspectReport($data->toArray(), $from, $to), "$fileName.xlsx");
    }

    public function deploymentReport($year){
        $temp = Candidate::where('status', 'ON BOARD')->get();
        $sources = [];

        $candidates = [];
        foreach($temp as $value){
            if(isset($value->requirement->joining_date)){
                if(str_starts_with($value->requirement->joining_date, $year)){
                    $value->month = now()->parse($value->requirement->joining_date)->format('M');
                    array_push($candidates, $value);
                    array_push($sources, $value->prospect->source);
                }
            }
            elseif(str_starts_with($value->updated_at, $year)){
                array_push($candidates, $value);
                $value->month = now()->parse($value->updated_at)->format('M');
                array_push($sources, $value->prospect->source);
            }
        }

        $sources = array_unique($sources);

        $fileName = "$year Deployment Report";

        return Excel::download(new DeploymentReport(collect($candidates), $year), "$fileName.xlsx");
    }

    public function prospectReport($from, $to){
        // DB::enableQueryLog();
        // $data = Prospect::whereBetween('updated_at', [$from, $to])->get();
        $data = Prospect::where('created_at', ">=", $from . " 00:00:00")->where('created_at', "<=", $to . " 23:59:59")->get();
        // dd(DB::getQueryLog());

        $from = now()->parse($from)->toFormattedDateString();
        $to = now()->parse($to)->toFormattedDateString();

        $fileName = "$from - $to Prospects";

        return Excel::download(new ProspectReport2($data->toArray(), $from, $to), "$fileName.xlsx");
    }

    function uploadFile(Request $req){
        $file = $req->file('files');
        $filename = null;

        $name = $file->getClientOriginalName();
        $name = str_replace(' ', '_', $name);

        $type = strtoupper($file->getClientOriginalExtension());
        $file->move(public_path().'/prospectForms/' . $req->id . '/', $name);
        
        Prospect::where('id', $req->id)->update(['file' => $name, 'updated_at' => now()]);
        echo "<script>window.close();</script>";
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}