<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Vessel, Principal};
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VesselsImport;

class VesselsController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Encoder/Cadet/Crewing Manager/Crewing Officer/Principal/Training');
    }

    public function import(Request $req){
        Excel::import(new VesselsImport, $req->file('file'));

        if(true){
            $req->session()->flash('success', 'Vessels successfully imported');
            return back();
        }
        else{
            $req->session()->flash('error', 'There was a problem importing the vessels. Please try again.');
            return back();
        }
    }

    public function export(Request $req, $type = ""){
        $class = "App\\Exports\\Vessels";
        $datas = Vessel::where('status', 'LIKE', $type . '%')->get();
        $datas->load('principal');

        $principals = Principal::where('active', 1)->pluck('id')->toArray();
        foreach($datas as $key => $vessel){
            if(!in_array($vessel->principal_id, $principals)){
                $datas->forget($key);
            }
        }

        return Excel::download(new $class($datas), 'Vessels.xlsx');
    }

    public function get(Request $req, $id = null){
    	echo json_encode(
            !$id ?
    		Vessel::where('principal_id', $req->id)
    			->where('status', 'ACTIVE')
    			->get()
            :
            Vessel::select('vessels.*')->where('id', $id)->where('status', 'ACTIVE')->with('principal')->first()
    	);
    }

    public function get2(Request $req){
        $vessels = Vessel::select($req->cols);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $vessels = $vessels->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $vessels = $vessels->where($req->where[0], $req->where[1]);
        }

        // IF HAS WHERE2
        if($req->where2){
            $vessels = $vessels->where($req->where2[0], 'like', $req->where2[1]);
        }

        // IF HAS WHEREIN
        if($req->whereIn){
            $vessels = $vessels->whereIn($req->whereIn[0], $req->whereIn[1]);
        }

        $vessels = $vessels->get();

        // IF HAS GROUP
        if($req->group){
            $vessels = $vessels->groupBy($req->group);
        }

        echo json_encode($vessels);
    }

    public function getAll(Request $req){
    	// echo json_encode(Vessel::all());
    	echo json_encode(
    		Vessel::select(
                'imo', 'principal_id', 'manning_agent', 'vessels.name', 'flag',
                'type', 'engine', 'gross_tonnage', 'BHP', 'trade',
                'p.name as pname'
                )
                ->where('imo', '!=', null)
                ->join('principals as p', 'p.id', '=', 'vessels.principal_id')
                ->get()
    	);
    }

    public function update(Request $req){
        echo Vessel::where('id', $req->id)->update([$req->column => $req->value]);
    }

    public function updateAll(Request $req){
        echo Vessel::where('id', $req->id)->update($req->all());
    }

    public function getParticular(Request $req){
        echo Vessel::where('id', $req->id)->select('particulars')->first()->particulars;
    }

    public function updateParticular(Request $req){
        $file = $req->file('file')[0];
        $name = $file->getClientOriginalName();
        $file->move(public_path().'/particulars/', $name);

        Vessel::where('id', $req->id)->update(['particulars' => $name]);
        echo "<script>window.close();</script>";
    }

    public function add(Request $req){
        echo Vessel::create([
            'principal_id' => $req->principal_id,
            'manning_agent' => $req->manning_agent,
            'name' => $req->name,
            'imo' => $req->imo,
            'flag' => $req->flag,
            'type' => $req->type,
            'year_build' => $req->year_build,
            'builder' => $req->builder,
            'engine' => $req->engine,
            'gross_tonnage' => $req->gross_tonnage,
            'bhp' => $req->bhp,
            'trade' => $req->trade,
            'ecdis' => $req->ecdis,
            'status' => 'INACTIVE'
        ]);
    }

    public function index(){
        return $this->_view('index', [
            'title' => "Vessels"
        ]);
    }

    private function _view($view, $data = array()){
        return view('vessels.' . $view, $data);
    }
}