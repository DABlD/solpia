<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class ValidationController extends Controller
{
    public function index(Request $req){
		$validator = Validator::make($req->all(), [
            key($req->all()) => $req->rules
        ]);

        echo json_encode($validator->errors());
    }

    public function update(Request $req){
    	$validator = Validator::make($req->all(), [
    	    $req->column => [
    	    	//can add array here for additional rules
    	        Rule::unique($req->table)->ignore($req->id),
    	    ],
    	]);

        echo json_encode($validator->errors());
    }
}
