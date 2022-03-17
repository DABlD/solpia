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

    private function _view($view, $data = array()){
        return view('wage.' . $view, $data);
    }
}
