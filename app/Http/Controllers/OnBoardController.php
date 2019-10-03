<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnBoardController extends Controller
{
    
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Cadet/Encoder');
    }

    public function index(){
    	echo 'yay';
    }
}
