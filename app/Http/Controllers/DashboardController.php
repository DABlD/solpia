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
                            ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? "%%")
                            ->get()->keyBy('id');

        $vacation = ProcessedApplicant::where('processed_applicants.status', 'Vacation')
                            ->join('applicants as a', 'a.id', '=', 'processed_applicants.applicant_id')
                            ->join('users as u', 'u.id', '=', 'a.user_id')
                            ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? "%%")
                            ->select('processed_applicants.id', 'applicant_id')->get()->keyBy('applicant_id');

        $onBoard = ProcessedApplicant::where('processed_applicants.status', 'On Board')
                            ->join('applicants as a', 'a.id', '=', 'processed_applicants.applicant_id')
                            ->join('users as u', 'u.id', '=', 'a.user_id')
                            ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? "%%")
                            ->select('processed_applicants.id', 'applicant_id')->get()->keyBy('applicant_id');

        $linedUp = ProcessedApplicant::where('processed_applicants.status', 'Lined-Up')
                            ->join('applicants as a', 'a.id', '=', 'processed_applicants.applicant_id')
                            ->join('users as u', 'u.id', '=', 'a.user_id')
                            ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? "%%")
                            ->select('processed_applicants.id', 'applicant_id')->get()->keyBy('applicant_id');

        $vessels = Vessel::where('status', 'ACTIVE')->where('fleet', 'LIKE', auth()->user()->fleet ?? "%%")->select('id', 'name')->count();

        $fleets = array_keys(Vessel::where('fleet', '!=', "")->get()->groupBy('fleet')->toArray());
        sort($fleets);

        if(auth()->user()->fleet){
            $fleets = [auth()->user()->fleet];
        }

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
        $vacation = ProcessedApplicant::where('processed_applicants.status', 'Vacation')
                        ->join('applicants as a', 'a.id', '=', 'processed_applicants.applicant_id')
                        ->join('users as u', 'u.id', '=', 'a.user_id')
                        ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? "%%")
                        ->select('processed_applicants.id', 'applicant_id')
                        ->get()->keyBy('applicant_id');
        
        $fleets = [];
        $fleets['Vacation'] = [];
        $crew =  DocumentId::where('expiry_date', '<=', now()->addMonths(2)->toDateString())
                        ->select('applicant_id', 'expiry_date', 'type', 'u.fname', 'u.lname', 'u.contact', 'u.fleet')
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
                if(auth()->user()->role == "Admin" && auth()->user()->fleet == null){
                    $fleets['Vacation'][$id] = $temp;
                }
                else{
                    if($docs[0]->fleet == auth()->user()->fleet){
                        $fleets['Vacation'][$id] = $temp;
                    }
                }
            }
        }

        foreach($fleets['Vacation'] as $id => $crew){
            if(!array_key_exists($id, $vacation->toArray())){
                $fleet = Vessel::where('pa.applicant_id', $id)
                    ->select('vessels.fleet', 'vessels.name')
                    ->join('processed_applicants as pa', 'pa.vessel_id', '=', 'vessels.id')
                    ->first();

                if($fleet){
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
        }

        echo json_encode($fleets);
    }

    function report1(Request $req){
        DB::enableQueryLog();
        // $type = $req->type;
        $type = "Weekly";
    
        if($type == "Range"){
        // $start = $req->start . ' 00:00:00';
        // $start = $req->end . ' 11:59:59';
            $start = "2022-01-01 00:00:00";
            $end = "2022-03-02 11:59:59";
        }
        else{
            if($type == "Weekly"){
                $start = now()->subMonths(6)->startOfDay()->toDateTimeString();
                $end = now()->endOfDay()->toDateTimeString();
            }
            else{
                $start = now()->subMonths(12)->startOfDay()->toDateTimeString();
                $end = now()->endOfDay()->toDateTimeString();
            }
        }

        // $pas = ProcessedApplicant::select('updated_at', 'status')
        //     ->whereColumn('updated_at', '!=', 'created_at')
        //     ->whereBetween('updated_at', [$start, $end])
        //     ->where('status', 'Lined-Up')
        //     ->get();

        // DISEMBARKING CREW
        $dcs = LineUpContract::select('disembarkation_date', 'joining_date')
                // ->where('disembarkation_date', '>=', $start)
                // ->where('disembarkation_date', '<=', $end)
                ->whereBetween('disembarkation_date', [$start, $end])
                ->orWhereBetween('joining_date', [$start, $end])
                ->join('applicants as a', 'a.id', '=', 'line_up_contracts.applicant_id')
                ->join('users as u', 'u.id', '=', 'a.user_id')
                ->where('u.fleet', 'LIKE', auth()->user()->fleet ?? "%%")
                ->get();

        $data = [];
        // $data["Lined-Up"] = [];
        $data["On Board"] = [];
        $data["Disembarked"] = [];

        $names = [];

        $tempEnd = $end;
        if($type == "Weekly"){
            $tempEnd = now()->parse($start)->addWeek()->endOfDay()->toDateTimeString();
        }
        else{
            $tempEnd = now()->parse($start)->addMonth()->endOfDay()->toDateTimeString();
        }

        $ctr = 0;

        while($start < $tempEnd){
            $startName = now()->parse($start)->toFormattedDateString();
            $startEnd = now()->parse($tempEnd)->toFormattedDateString();
            array_push($names, $startName . ' - ' . $startEnd);

            $luCtr = 0;
            $obCtr = 0;
            $dCtr = 0;

            // foreach($pas as $pa){
            //     if($pa->updated_at > $start && $pa->updated_at < $tempEnd){
            //         $luCtr++;
            //     }
            // }

            foreach($dcs as $dc){
                if($dc->disembarkation_date){
                    if($dc->disembarkation_date > $start && $dc->disembarkation_date < $tempEnd){
                        $dCtr++;
                    }
                }
                else{
                    if($dc->joining_date > $start && $dc->joining_date < $tempEnd){
                        $obCtr++;
                    }
                }
            }

            if($type == "Weekly"){
                $start = now()->parse($start)->addWeek()->toDateTimeString();
                if($start <= $end){
                    $tempEnd = now()->parse($start)->addWeek()->endOfDay()->toDateTimeString();
                }
            }
            else{
                $start = now()->parse($start)->addMonth()->toDateTimeString();
                if($start <= $end){
                    $tempEnd = now()->parse($start)->addMonth()->endOfDay()->toDateTimeString();
                }
            }

            // array_push($data['Lined-Up'], $luCtr);
            array_push($data['On Board'], $obCtr);
            array_push($data['Disembarked'], $dCtr);
            $ctr++;
        }

        // $data["Disembarked"] = [
        //     33,55,20,30,43,
        //     28,49,15,25,38,
        //     25,46,12,22,35,
        //     22,43,9,19,32,
        //     19,40,6,10,14,
        //     12,3
        // ];
        
        echo json_encode(['names' => $names, 'data' => $data]);
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
