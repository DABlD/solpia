<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vessel;

class VesselController extends Controller
{
    public function get(Request $req){
    	echo json_encode(
    		Vessel::where('principal_id', $req->id)
    			->where('status', 'ACTIVE')
    			->get()
    	);
    }
}
