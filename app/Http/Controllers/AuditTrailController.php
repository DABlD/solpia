<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin');
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Audit Trail'
        ]);
    }

    public function delete(User $user){
        $user->deleted_at = now()->toDateTimeString();
        echo $user->save();
    }

    public function get(User $user){
    	echo json_encode($user);
    }

    private function _view($view, $data = array()){
    	return view('auditTrail.' . $view, $data);
    }
}
