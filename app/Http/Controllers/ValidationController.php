<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class ValidationController extends Controller
{
    public function index(Request $req){
		$validator = Validator::make($req->all(), [
            key($req->all()) => $req->rules
        ]);

        echo json_encode($validator->errors());
    }
}
