<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\{Applicant, LineUpContract, ProcessedApplicant, Vessel, DocumentId};
use App\Models\{AuditTrail};
use Browser;
use DB;

class DashboardController extends Controller
{
    public function index(){
        DB::connection()->enableQueryLog();

        if($this->checkIfNotAllowed()){
            return redirect()->route('applications.index');
        }

        $condition = array();

        // STATUS = WHAT PRINCIPAL IS STAFF UNDER SO I USED THIS
        $status = auth()->user()->status;

        // if($status == 1){
        //     $condition = ['u.applicant', '>', 0];
        // }
        // elseif($status > 1){
        //     $condition = ['u.applicant', '=', $status];
        // }
        $applicants = Applicant::select('applicants.id', 'u.fname', 'u.lname', 'u.contact')
                            ->join('users as u', 'u.id', '=', 'applicants.user_id')
                            ->get()->keyBy('id');

        $vacation = ProcessedApplicant::where('status', 'Vacation')->select('id', 'applicant_id')->get()->keyBy('applicant_id');
        $onBoard = ProcessedApplicant::where('status', 'On Board')->select('id', 'applicant_id')->get()->keyBy('applicant_id');
        $linedUp = ProcessedApplicant::where('status', 'Lined-Up')->select('id', 'applicant_id')->get()->keyBy('applicant_id');
        $vessels = Vessel::where('status', 'ACTIVE')->select('id', 'name')->count();

        $fleets = array_keys(Vessel::where('fleet', '!=', "")->get()->groupBy('fleet')->toArray());
        sort($fleets);

    	return $this->_view('dashboard', [
    		'title' 		=> 'Dashboard',
    		'applicants'	=> sizeof($applicants),
            'vacation'       => $vacation->count(),
    		'onBoard' 		=> $onBoard->count(),
            'linedUp'       => $linedUp->count(),
            'vessels'       => $vessels,
            'fleets'        => array_merge($fleets, ["Vacation"])
    	]);
    }

    function checkIfNotAllowed(){
        $toDatabase = ['Cadet', 'Encoder', 'Crewing Officer', 'Processing'];
        return in_array(auth()->user()->role, $toDatabase);
    }

    function getCrewWithExpiredDocs(Request $req){
        $vacation = ProcessedApplicant::where('status', 'Vacation')->select('id', 'applicant_id')->get()->keyBy('applicant_id');
        $fleets;

        $crew =  DocumentId::where('expiry_date', '<=', now()->addMonths(2)->toDateString())
                        ->select('applicant_id', 'expiry_date', 'type', 'u.fname', 'u.lname', 'u.contact')
                        ->join('applicants as a', 'a.id', '=', 'document_ids.applicant_id')
                        ->join('users as u', 'u.id', '=', 'a.user_id')
                        ->get()
                        ->groupBy('applicant_id');
                        
        foreach($crew as $id => $docs){
            $temp['fname'] = $docs[0]->fname;
            $temp['lname'] = $docs[0]->lname;
            $temp['contact'] = $docs[0]->contact;
            $temp['docs'] = [];
            $bool = false;

            foreach($docs as $doc){
                if($doc->type == "PASSPORT" || $doc->type == "US-VISA" || $doc->type == "SEAMAN'S BOOK"){
                    $temp['docs'][sizeof($temp['docs'])] = [
                        "type" => $doc->type, 
                        "expiry" => $doc->expiry_date->toDateString()
                    ];
                    // echo $id . ' - ' . $doc->expiry_date . '<br>';
                    $bool = true;
                }
            }

            if($bool){
                $fleets['Vacation'][$id] = $temp;
            }
        }

        // die;

        foreach($fleets['Vacation'] as $id => $crew){
            if(!array_key_exists($id, $vacation->toArray())){
                $fleet = Vessel::where('pa.applicant_id', $id)
                                    ->select('vessels.fleet', 'vessels.name')
                                    ->join('processed_applicants as pa', 'pa.vessel_id', '=', 'vessels.id')
                                    ->first();

                if(!array_key_exists($fleet->fleet, $fleets)){
                    $fleets[$fleet->fleet] = [];
                }

                if(!$fleet->fleet == ""){
                    $fleets[$fleet->fleet][$id] = $fleets['Vacation'][$id];
                    unset($fleets['Vacation'][$id]);
                }
                else{
                    $name = $fleet->name;

                    AuditTrail::create([
                        'user_id'   => auth()->user()->id,
                        'action'    => "WARNING: VESSEL $name HAS NO FLEET ASSIGNMENT",
                        'ip'        => $req->getClientIp(),
                        'hostname'  => gethostname(),
                        'device'    => Browser::deviceFamily(),
                        'browser'   => Browser::browserName(),
                        'platform'  => Browser::platformName()
                    ]);
                }

            }
        }

        echo json_encode($fleets);
    }

    function clean(){
        // DB::connection()->enableQueryLog();
        // DB::connection()->getQueryLog();

        $temp = Applicant::onlyTrashed()->pluck('id');
        foreach($temp as $id){
            echo "ID: " . $id . '<br>';
            LineUpContract::where('applicant_id', $id)->delete();
            ProcessedApplicant::where('applicant_id', $id)->delete();
            DocumentId::where('applicant_id', $id)->delete();
        }

        echo "Success";
        die;

    }

    private function _view($view, $data = array()){
    	return view($view, $data);
    }
}
