<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AuditTrail;

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

    public function export(){
        $data = AuditTrail::all();
        
        $class = "App\\Exports\\Logs";
        $first = "NA";
        $last = "NA";

        if($data->count()){
            $first = $data->first()->created_at->format('F j, Y');
            $last = $data->last()->created_at->format('F j, Y');
        }

        $datas = AuditTrail::join('users', 'audit_trails.user_id', '=', 'users.id')
                        ->select('audit_trails.*', 'users.username')
                        ->limit(1000)
                        ->get()
                        ->reverse();

        return Excel::download(new $class($datas), $first . ' - ' . $last . '.xlsx');
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
