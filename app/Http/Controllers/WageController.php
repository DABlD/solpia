<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wage;

class WageController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Processing');
    }

    public function index(){
        return $this->_view('index', [
            'title' => "Wage Scale"
        ]);
    }

    public function get(Request $req){
        $vessels = Wage::select($req->cols);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $vessels = $vessels->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $vessels = $vessels->where($req->where[0], $req->where[1]);
        }

        $vessels->join('ranks as r', 'r.id', '=', 'wages.rank_id');
        $vessels = $vessels->get();
        foreach($vessels as $wage){
            $wage->actions = $wage->actions;
        }

        // IF HAS GROUP
        if($req->group){
            $vessels = $vessels->groupBy($req->group);
        }

        echo json_encode($vessels);
    }

    public function create(Request $req){
        echo Wage::create($req->all());
    }

    public function delete(Request $req){
        echo Wage::where('id', $req->id)->delete();
    }

    public function update(Request $req){
        echo Wage::where('id', $req->id)->update($req->all());
    }

    private function _view($view, $data = array()){
        return view('wage.' . $view, $data);
    }
}