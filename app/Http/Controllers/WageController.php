<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Wage, Vessel, AuditTrail};
use Browser;

class WageController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Processing/Encoder/Cadet/Crewing Manager/Crewing Officer');
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

        // IF HAS WHERE
        if($req->where2){
            $vessels = $vessels->where($req->where2[0], $req->where2[1]);
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

    public function getVessels(Request $req){
        $vessels = Vessel::where('imo', '!=', null)->select('id', 'name', 'imo')->get();
        echo json_encode($vessels);
    }

    public function duplicate(Request $req){
        Wage::where('vessel_id', $req->vid2)->delete();

        $wages = Wage::where('vessel_id', $req->vid)->get();
        foreach ($wages as $wage) {
            $temp = $wage;

            $temp2 = $temp->replicate();
            $temp2->vessel_id = $req->vid2;
            $temp2->created_at = now();
            $temp2->save();
        }

        echo "Success";
    }

    public function create(Request $req){
        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "Created Wage for vid: $req->vessel_id rid: $req->rank_id",
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        echo Wage::create($req->all());
    }

    public function delete(Request $req){
        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "Deleted Wage for vid: $req->vessel_id rid: $req->rank_id",
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        echo Wage::where('id', $req->id)->delete();
    }

    public function update(Request $req){
        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "Updated Wage for vid: $req->id rid: $req->rank_id",
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        echo Wage::where('id', $req->id)->update($req->all());
    }

    private function _view($view, $data = array()){
        return view('wage.' . $view, $data);
    }
}