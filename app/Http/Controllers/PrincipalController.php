<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Principal;

class PrincipalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get(Request $req){
        $principals = Principal::select($req->cols);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $principals = $principals->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $principals = $principals->where($req->where[0], $req->where[1]);
        }

        $principals = $principals->get();

        // IF HAS GROUP
        if($req->group){
            $principals = $principals->groupBy($req->group);
        }
        echo json_encode($principals);
    }
}
