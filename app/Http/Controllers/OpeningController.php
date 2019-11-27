<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Opening, Rank};

class OpeningController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin');
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Job Openings'
        ]);
    }

    public function store(Request $req){
    	echo Opening::create([
    		'user_id' 	=> auth()->user()->id,
    		'rank' 		=> $req->rank,
    		'type' 		=> $req->type,
    		'remarks'	=>	$req->remarks,
    	]);
    }

    public function delete(Request $req){
    	echo Opening::find($req->id)->delete();
    }

    public function statusUpdate(Request $req){
        echo Opening::where('id', $req->id)->update([$req->column => $req->value]);
    }

    private function _view($view, $data = array()){
    	$ranks = Rank::select('id', 'abbr')->get();

    	$string = "";
    	foreach($ranks as $rank){
    		$abbr = $rank->abbr;

    		$string .= "<option value='$abbr'>$abbr</option>";
    	}

    	$data['options'] = $string;
    	return view('openings.' . $view, $data);
    }
}
