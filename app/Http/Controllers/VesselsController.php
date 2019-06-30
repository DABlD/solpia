<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Vessel, Principal};

class VesselsController extends Controller
{
    public function get(Request $req, $id = null){
    	echo json_encode(
            !$id ?
    		Vessel::where('principal_id', $req->id)
    			->where('status', 'ACTIVE')
    			->get()
            :
            Vessel::select('vessels.*')->where('id', $id)->with('principal')->first()
    	);
    }

    public function getAll(Request $req){
    	// echo json_encode(Vessel::all());
    	echo json_encode(
    		Vessel::with('principal')->get()
    	);
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