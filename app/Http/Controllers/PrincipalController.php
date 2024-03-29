<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Principal, Applicant, AuditTrail};
use Maatwebsite\Excel\Facades\Excel;

use Browser;
use DB;

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
        $this->table = "principals";
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Principals'
        ]);
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

    public function getOnboardCrew(Principal $principal){
        $pa = ['pa.applicant_id as id', 'pa.vessel_id as vid', 'pa.principal_id as pid', 'pa.rank_id as rid', 'seniority'];
        $p = ['p.name as pname'];
        $v = ['v.name as vname', 'v.flag', 'v.type'];
        $r = ['r.abbr as rname', 'r.type as rtype'];
        $lup = ['lup.joining_date', 'lup.months'];
        $u = ['fname', 'mname', 'lname', 'suffix', 'birthday'];

        $obcs = Applicant::where('pa.status', 'On Board')
                    ->where('pa.principal_id', $principal->id)
                    ->join('processed_applicants as pa', 'pa.applicant_id', '=', 'applicants.id')
                    ->join('principals as p', 'p.id', '=', 'pa.principal_id')
                    ->join('vessels as v', 'v.id', '=', 'pa.vessel_id')
                    ->join('ranks as r', 'r.id', '=', 'pa.rank_id')
                    ->join('line_up_contracts as lup', function($join){
                            $join->on('lup.applicant_id', '=', 'pa.applicant_id');
                            $join->on('lup.status', '=', "pa.status");
                        })
                    ->join('users as u', 'u.id', '=', 'applicants.user_id')
                    ->select(array_merge($pa, $p, $v, $r, $lup, $u))
                    ->with('document_id')
                    ->with('document_flag')
                    ->with('document_lc')
                    ->with('document_med_cert')
                    ->get();

        foreach($obcs as $obc){
            foreach(['document_id', 'document_flag', 'document_lc', 'document_med_cert' ] as $docuType){
                foreach($obc->$docuType as $key => $doc){
                    $name = $doc->type;
                    if(!isset($obc->$docuType->$name)){
                        $obc->$docuType->$name = $doc;
                    }
                    else{
                        $size = 0;
                        if(is_array($obc->$docuType->$name)){
                            $size = sizeof($obc->$docuType->$name);
                        }
                        $name .= $size;
                        $obc->$docuType->$name = $doc;
                    }
                    $obc->$docuType->forget($key);
                }
            }
        }
        
        $fileName = str_replace('/', '_', $principal->name) . ' Onboard Crew - ' . now()->format('d-M-y');
        if(in_array($principal->name, ["KOSCO", 'HMM', 'CK MARITIME'])){
            $class = "App\\Exports\\X10_PrincipalOnboardCrew";
        }
        elseif(in_array($principal->name, ["SHINKO"])){
            $class = "App\\Exports\\X12_PrincipalOnboardCrew";
        }
        elseif(in_array($principal->name, ["NITTA/TOEI"])){
            $class = "App\\Exports\\X13_PrincipalOnboardCrew";
        }
        return Excel::download(new $class($obcs), "$fileName.xlsx");
    }

    public function update(Request $req){
        $query = DB::table($this->table);

        if($req->where){
            $query = $query->where($req->where[0], $req->where[1])->update($req->except(['id', '_token', 'where']));
        }
        else{
            $query = $query->where('id', $req->id)->update($req->except(['id', '_token']));
        }

        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "Updated Principal $req->name",
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}
