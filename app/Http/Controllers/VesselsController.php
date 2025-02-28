<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Vessel, Principal, AuditTrail};
use App\Models\{LineUpContract};
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\{VesselsImport, AddVesselDetails, AddVesselWageScale};

use Browser;

class VesselsController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Encoder/Cadet/Crewing Manager/Crewing Officer/Principal/Training/Processing/Recruitment Officer');
    }

    public function import(Request $req){
        if($req->type == "default"){
            Excel::import(new VesselsImport, $req->file('file'));
        }
        elseif($req->type == "addVesselWageScale"){
            Excel::import(new AddVesselWageScale, $req->file('file'));
        }
        elseif($req->type == "addVesselDetails"){
            Excel::import(new AddVesselDetails, $req->file('file'));
        }

        if(true){
            $req->session()->flash('success', 'Vessels successfully imported');
            return back();
        }
        else{
            $req->session()->flash('error', 'There was a problem importing the vessels. Please try again.');
            return back();
        }
    }

    public function export(Request $req, $type = ""){
        $class = "App\\Exports\\Vessels";
        // $datas = Vessel::where('status', 'LIKE', $type . '%')
        $datas = Vessel::where('status', 'ACTIVE')
                        ->where('manning_agent', 'LIKE', '%SOLPIA%')
                        ->join('principals as p', 'p.id', '=', 'vessels.principal_id')
                        ->select('vessels.*', 'p.name as pname')
                        ->get();

        $principals = Principal::where('active', 1)->pluck('id')->toArray();
        foreach($datas as $key => $vessel){
            if(!in_array($vessel->principal_id, $principals)){
                $datas->forget($key);
            }
        }

        return Excel::download(new $class($datas, 'vessels'), 'Vessels.xlsx');
    }

    public function get(Request $req, $id = null){
    	echo json_encode(
            !$id ?
    		Vessel::where('principal_id', $req->id)
    			->where('status', 'ACTIVE')
    			->get()
            :
            Vessel::select('vessels.*')->where('id', $id)->where('status', 'ACTIVE')->with('principal')->first()
    	);
    }

    public function get2(Request $req){
        $vessels = Vessel::select($req->cols);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $vessels = $vessels->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            // $vessels = $vessels->where($req->where[0], $req->where[1]);

            if($req->where[0] == "fleet"){
                if(in_array(auth()->user()->id, [4504, 4545, 4861, 4988, 5013, 6011, 6016, 5963, 6014, 6080, 5907])){
                    $vessels = $vessels->where(function($q){
                        $q->where('fleet', 'like', auth()->user()->fleet);
                        $q->orWhere('fleet', 'like', "FLEET A");
                    });
                }
                elseif(in_array(auth()->user()->id, [4520])){
                    $vessels = $vessels->where(function($q){
                        $q->where('fleet', 'like', auth()->user()->fleet);
                        $q->orWhere('fleet', 'like', "FLEET C");
                    });
                }
                else{
                    $vessels = $vessels->where($req->where[0], 'like', $req->where[1]);
                }
            }
            else{
                $vessels = $vessels->where($req->where[0], 'like', $req->where[1]);
            }
        }

        // IF HAS WHERE2
        if($req->where2){
            $vessels = $vessels->where($req->where2[0], 'like', $req->where2[1]);
        }

        // IF HAS WHEREIN
        if($req->whereIn){
            $vessels = $vessels->whereIn($req->whereIn[0], $req->whereIn[1]);
        }

        $vessels = $vessels->get();

        // IF HAS GROUP
        if($req->group){
            $vessels = $vessels->groupBy($req->group);
        }

        echo json_encode($vessels);
    }

    public function getAll(Request $req){
    	// echo json_encode(Vessel::all());
    	echo json_encode(
    		Vessel::select(
                'imo', 'principal_id', 'manning_agent', 'vessels.name', 'flag',
                'type', 'engine', 'gross_tonnage', 'BHP', 'trade', 'year_build',
                'p.name as pname'
                )
                ->where('imo', '!=', null)
                ->join('principals as p', 'p.id', '=', 'vessels.principal_id')
                ->get()
    	);
    }

    public function update(Request $req){
        $res = Vessel::where('id', $req->id)->update([$req->column => $req->value]);

        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "Updated Vessel $req->name",
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        echo $res;
    }

    public function updateAll(Request $req){
        $res = Vessel::where('id', $req->id)->update($req->all());

        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "Updated Vessel $req->name",
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        echo $res;
    }

    public function getParticular(Request $req){
        echo Vessel::where('id', $req->id)->select('particulars')->first()->particulars;
    }

    public function updateParticular(Request $req){
        $file = $req->file('file')[0];
        $name = $file->getClientOriginalName();
        $file->move(public_path().'/particulars/', $name);

        Vessel::where('id', $req->id)->update(['particulars' => $name]);
        echo "<script>window.close();</script>";
    }

    public function exportMonitoring(Request $req){
        $vessel = Vessel::find($req->id);

        $obcs = LineUpContract::where('vessel_id', $req->id)->where('status', "On Board")->get();
        $obcs->load('document_id');
        $obcs->load('document_flag');
        $obcs->load('document_lc');
        $obcs->load('document_med_cert');
        $obcs->load('applicant.user.crew.pro_app');

        $fileName = str_replace("/", "", $vessel->name) . " Document Monitoring";
        $class = "App\\Exports\\Monitoring\\" . ucfirst($vessel->principal->slug);
        
        return Excel::download(new $class($obcs, $vessel), "$fileName.xlsx");
    }

    public function getOnboardCrew(Request $req){
        $vessel = Vessel::find($req->id);

        $obcs = LineUpContract::where('vessel_id', $req->id)->where('status', "On Board")->get();
        $obcs->load('document_id');
        $obcs->load('document_flag');
        $obcs->load('document_lc');
        $obcs->load('document_med_cert');
        $obcs->load('applicant.user.crew.pro_app.rank');
        
        echo json_encode([$obcs, $vessel]);
    }

    public function add(Request $req){
        $res = Vessel::create([
            'principal_id' => $req->principal_id,
            'manning_agent' => $req->manning_agent,
            'name' => $req->name,
            'imo' => $req->imo,
            'flag' => $req->flag,
            'type' => $req->type,
            'year_build' => $req->year_build,
            'builder' => $req->builder,
            'engine' => $req->engine,
            'gross_tonnage' => $req->gross_tonnage,
            'bhp' => $req->bhp,
            'trade' => $req->trade,
            'ecdis' => $req->ecdis,
            'status' => 'ACTIVE',
            'fleet' => auth()->user()->fleet,
            'former_agency' => $req->former_agency,
            'former_principal' => $req->former_principal,
            'mlc_shipowner' => $req->mlc_shipowner,
            'mlc_shipowner_address' => $req->mlc_shipowner_address,
            'registered_shipowner_address' => $req->registered_shipowner_address,
            'registered_shipowner' => $req->registered_shipowner,
            'work_hours' => $req->work_hours,
            'ot_hours' => $req->ot_hours,
            'cba_affiliation' => $req->cba_affiliation,
            'classification' => $req->classification,
            'months_in_contract' => $req->months_in_contract
        ]);

        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "Created Vessel $req->name",
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        echo $res;
    }

    public function index(){
        $principals = Principal::where('active', 1)->where('fleet', 'LIKE', auth()->user()->fleet ?? "%%")->select('name', 'id', 'fleet')->get();

        $vessels = Vessel::select('flag', 'type', 'cba_affiliation', 'trade', 'ecdis', 'status')->get();
        $flags = $vessels->unique('flag');
        $flags2 = $vessels->filter(function($vessel){
            return $vessel->status == "ACTIVE";
        })->unique('flag');
        $types = $vessels->unique('type');
        $cba = $vessels->unique('cba_affiliation');
        $trade = $vessels->unique('trade');
        $ecdis = $vessels->unique('ecdis');

        return $this->_view('index', [
            'title' => "Vessels",
            'principals' => $principals->sortBy('name'),
            'flags' => $flags->sortBy('flag'),
            'flags2' => $flags2->sortBy('flag'),
            'types' => $types->sortBy('type'),
            'cbas' => $cba,
            'trades' => $trade,
            'ecdiss' => $ecdis
        ]);
    }

    private function _view($view, $data = array()){
        return view('vessels.' . $view, $data);
    }
}