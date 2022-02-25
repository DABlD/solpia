<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Vessel, Principal};
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VesselsImport;

class VesselsController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Encoder/Cadet/Crewing Manager/Crewing Officer/Principal');
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

    public function getAll(Request $req){
    	// echo json_encode(Vessel::all());
    	echo json_encode(
    		Vessel::with('principal')->get()
    	);
    }

    public function update(Request $req){
        echo Vessel::where('id', $req->id)->update([$req->column => $req->value]);
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
            'ecdis' => $req->ecdis
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