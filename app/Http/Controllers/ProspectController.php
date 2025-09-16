<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Prospect, Candidate, Rank, Requirement};

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Reports\Prospect as ProspectReport;
use App\Exports\Reports\Deployment as DeploymentReport;
use App\Exports\Reports\Prospect2 as ProspectReport2;

use DB;

class ProspectController extends Controller
{
    public function __construct(){
        $this->table = "prospects";
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Applicants'
        ]);
    }

    public function get(Request $req){
        $array = Prospect::select($req->select);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
        }

        $array = $array->get();

        // IF HAS LOAD
        if($array->count() && $req->load){
            foreach($req->load as $table){
                $array->load($table);
            }
        }

        // IF HAS GROUP
        if($req->group){
            $array = $array->groupBy($req->group);
        }

        echo json_encode($array);
    }

    public function store(Request $req){
        $data = new Prospect();
        $data->name = $req->name;
        $data->birthday = $req->birthday;
        $data->age = $req->birthday ? now()->parse($req->birthday)->age : $req->age;
        $data->height = $req->height;
        $data->weight = $req->weight;
        $data->contact = $req->contact;
        $data->email = $req->email;
        $data->rank = $req->rank;
        $data->usv = $req->usv;
        $data->contracts = $req->contracts;
        $data->exp = json_encode($req->exp);
        $data->availability = $req->availability;
        $data->last_disembark = $req->last_disembark;
        $data->location = $req->location;
        $data->previous_salary = $req->previous_salary;
        $data->previous_agency = $req->previous_agency;
        $data->remarks = $req->remarks;
        $data->source = $req->source;
        $data->save();
    }

    public function update(Request $req){
        $query = DB::table($this->table);
        
        if($req->where){
            $query = $query->where($req->where[0], $req->where[1])->update(array_merge($req->except(['id', '_token', 'where']), ['updated_at' => now()]));
        }
        else{
            $query = $query->where('id', $req->id)->update(array_merge($req->except(['id', '_token']), ['updated_at' => now()]));
        }
    }

    public function delete(Request $req){
        Prospect::find($req->id)->delete();
    }

    public function import(Request $req){
    	$class = "App\Imports\\" . $req->import;
        Excel::import(new $class, $req->file('file'));

        if(true){
            $req->session()->flash('success', 'Successfully Imported');
            return back();
        }
        else{
            $req->session()->flash('error', 'Please Try Again.');
            return back();
        }
    }

    public function report($from, $to){
        // DB::enableQueryLog();
        // $data = Prospect::whereBetween('updated_at', [$from, $to])->get();
        $data = Prospect::where('updated_at', ">=", $from . " 00:00:00")->where('updated_at', "<=", $to . " 23:59:59")->get();
        // dd(DB::getQueryLog());
        $data->load('candidates');

        $from = now()->parse($from)->toFormattedDateString();
        $to = now()->parse($to)->toFormattedDateString();

        $fileName = "$from - $to Applicants";

        return Excel::download(new ProspectReport($data->toArray(), $from, $to), "$fileName.xlsx");
    }

    public function deploymentReport($year){
        $temp = Candidate::where('status', 'ON BOARD')->get();
        $sources = [];

        $candidates = [];
        foreach($temp as $value){
            if(isset($value->requirement->joining_date)){
                if(str_starts_with($value->requirement->joining_date, $year)){
                    $value->month = now()->parse($value->requirement->joining_date)->format('M');
                    array_push($candidates, $value);
                    array_push($sources, $value->prospect->source);
                }
            }
            elseif(str_starts_with($value->updated_at, $year)){
                array_push($candidates, $value);
                $value->month = now()->parse($value->updated_at)->format('M');
                array_push($sources, $value->prospect->source);
            }
        }

        $sources = array_unique($sources);

        $fileName = "$year Deployment Report";

        return Excel::download(new DeploymentReport(collect($candidates), $year), "$fileName.xlsx");
    }

    public function prospectReport($from, $to){
        // DB::enableQueryLog();
        // $data = Prospect::whereBetween('updated_at', [$from, $to])->get();
        $data = Prospect::where('created_at', ">=", $from . " 00:00:00")->where('created_at', "<=", $to . " 23:59:59")->get();
        // dd(DB::getQueryLog());

        $from = now()->parse($from)->toFormattedDateString();
        $to = now()->parse($to)->toFormattedDateString();

        $fileName = "$from - $to Prospects";

        return Excel::download(new ProspectReport2($data->toArray(), $from, $to), "$fileName.xlsx");
    }

    public function statisticsReport($from, $to){
        $results = Prospect::where('created_at', ">=", $from . " 00:00:00")->where('created_at', "<=", $to . " 23:59:59")->select('source', 'rank')->get();
                        // ->select('source', DB::raw('COUNT(*) as total'))
                        // ->groupBy('source')
                        // ->pluck('total', 'source')
                        // ->toArray();

        $rankList = Rank::pluck('name', 'id');

        // MSTR,C/O,2/O,3/O,C/E,1AE,2AE,3AE,ELECT,BSN,PMN,AB,OS,OLR1,OLR,WPR,CCK,2CK,MSM,DCDT,ECDT,DHAND,FTR,GE,RMAN
        $ranks = [1,2,3,4,5,6,7,8,22,9,30,10,11,15,16,17,24,26,27,14,19,34,21,57,31];

        $allSources = [
            "Kalaw" => 0,
            "Online" => 0,
            "Walk-in" => 0,
            "Source" => 0,
            "Job Fair" => 0,
        ];

        // unset($results[null]);
        $applicants = [];
        foreach($results as $result){
            isset($applicants[$result->rank][$result->source]) ? $applicants[$result->rank][$result->source]++ : ($applicants[$result->rank][$result->source] = 1);
        }

        // FOR CANDIDATES
        $candidates = Candidate::where('created_at', ">=", $from . " 00:00:00")->where('created_at', "<=", $to . " 23:59:59")->get();

        $temp1 = []; //SUCCESSFUL APPLICANT
        $temp2 = []; //UNSUCCESSFUL APPLICANT
        $temp3 = []; //REJECTED
        $temp4 = []; //DISAPPROVED BY PRINCIPAL
        $temp5 = []; //UNFIT PEME

        foreach ($ranks as $rank) {
            $temp1[$rankList[$rank]] = $allSources;
            $temp2[$rankList[$rank]] = $allSources;
            $temp3[$rankList[$rank]] = $allSources;
            $temp4[$rankList[$rank]] = $allSources;
            $temp5[$rankList[$rank]] = $allSources;
        }

        $temp6 = ["On time" => 0, "No" => 0]; //TIMELY SUBMISSION TOP 4
        $temp7 = ["On time" => 0, "No" => 0]; //TIMELY SUBMISSION JUNIOR OFFICERS
        $temp8 = ["On time" => 0, "No" => 0]; //TIMELY SUBMISSION RATINGS

        foreach($candidates as $candidate){
            $source = $candidate->prospect->source;
            $rank = $rankList[$candidate->requirement->rank];

            if(in_array($candidate->status, ['FOR APPROVAL', 'FOR MEDICAL', 'PASSED', 'ON BOARD'])){
                isset($temp1[$rank][$source]) ? $temp1[$rank][$source]++ : ($temp1[$rank][$source] = 1);
            }
            elseif($candidate->status == "REJECTED"){
                $remark = strtoupper($candidate->remarks);
                if(str_contains($remark, 'DECLINE') || str_contains($remark, 'WITHDRAW') || str_contains($remark, 'FAILED')){
                    isset($temp2[$rank][$source]) ? $temp2[$rank][$source]++ : ($temp2[$rank][$source] = 1);
                }
                elseif(str_contains($remark, "DISAPPROVED")){
                    isset($temp4[$rank][$source]) ? $temp4[$rank][$source]++ : ($temp4[$rank][$source] = 1);
                }
                elseif(str_contains($remark, "UNFIT")){
                    isset($temp5[$rank][$source]) ? $temp5[$rank][$source]++ : ($temp5[$rank][$source] = 1);
                }
            }

            if(str_contains($candidate->prospect->remarks, "BACKED OUT") || 
                str_contains($candidate->prospect->remarks, "BACK OUT") || 
                str_contains($candidate->remarks, "BACKED OUT") || 
                str_contains($candidate->remarks, "BACK OUT")){

                isset($temp3[$rank][$source]) ? $temp3[$rank][$source]++ : ($temp3[$rank][$source] = 1);
            }

            // for timely submission
            $deadline = $candidate->requirement->deadline ?? $candidate->requirement->joining_date;
            $key = "No";
            if($candidate->requirement->date_provided < $deadline){
                $key = "On time";
            }

            if(in_array($candidate->requirement->rank, [1,2,5,6])){
                $temp6[$key]++;
            }
            elseif($candidate->requirement->rank2->type == "OFFICER"){
                $temp7[$key]++;
            }
            else{
                $temp8[$key]++;
            }
        }

        $temp6["Percent"] = ($temp6["On time"] / array_sum($temp6)) * 100;
        $temp7["Percent"] = ($temp7["On time"] / array_sum($temp7)) * 100;
        $temp8["Percent"] = ($temp8["On time"] / array_sum($temp8)) * 100;

        // FOR REQUIREMENT/REQUESTS

        $temp9 = [];
        $requirements = Requirement::where('created_at', ">=", $from . " 00:00:00")->where('created_at', "<=", $to . " 23:59:59")->get();
        foreach($requirements as $requirement){
            isset($temp9[$rankList[$requirement->rank]]) ? $temp9[$rankList[$requirement->rank]]++ : ($temp9[$rankList[$requirement->rank]] = 1);
        }

        dd(
            ["Total number of recruited crew", $applicants],
            ["Total of successful applicants (For approval, For Medical, Passed, On board status)", $temp1],
            ["Total of unsuccessful (Rejected status with DECLINE, WITHDRAW, FAILED remark)", $temp2],
            ["Total of disapproved (Rejected status with DISAPPROVED remark)", $temp4],
            ["Total of unfit (Rejected status with UNFIT remark)", $temp5],
            ["Total of backed out/back out (Back out/Backed out remarks)", $temp3],
            '~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~',
            'Requested Crew',
            $temp9,
            '~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~',
            'Timely Submissions',
            ["All", [
                        "On time" => $temp6['On time'] + $temp7['On time'] + $temp8['On time'],
                        "No" => $temp6['No'] + $temp7['No'] + $temp8['No'],
                        "Percent" => (($temp6['On time'] + $temp7['On time'] + $temp8['On time']) / ($temp6['On time'] + $temp7['On time'] + $temp8['On time'] + $temp6['No'] + $temp7['No'] + $temp8['No'])) * 100
                    ]],
            ["Top 4", $temp6],
            ["Junior Officers", $temp7],
            ["Ratings", $temp8]
        );

        // $fileName = "$from - $to Statistic Report";
        // return Excel::download(new StatisticReport($applicants, $candidates), "$fileName.xlsx");
    }

    function uploadFile(Request $req){
        $file = $req->file('files');
        $filename = null;

        $name = $file->getClientOriginalName();
        $name = str_replace(' ', '_', $name);

        $type = strtoupper($file->getClientOriginalExtension());
        $file->move(public_path().'/prospectForms/' . $req->id . '/', $name);
        
        Prospect::where('id', $req->id)->update(['file' => $name, 'updated_at' => now()]);
        echo "<script>window.close();</script>";
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}