<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Vessel, Principal};

class VesselController extends Controller
{
    public function get(Request $req){
    	echo json_encode(
    		Vessel::where('principal_id', $req->id)
    			->where('status', 'ACTIVE')
    			->get()
    	);
    }

    public function getAll(Request $req){
    	// echo json_encode(Vessel::all());
    	echo json_encode(
    		Vessel::with('principal')->get()
    	);
    }
}