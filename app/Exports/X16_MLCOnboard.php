<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{LineUpContract, Applicant, Vessel, Rank, Wage, Principal};

class X16_MLCOnboard implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($a,$b, $data){
        $vessel = Vessel::find($data['vid']);
        $ranks = Rank::get()->groupBy('id');
        $wage = Wage::where('vessel_id', $vessel->id)->get()->groupBy("rank_id");

        $lucs = LineUpContract::where("vessel_id", $vessel->id)->where("status", "On Board")->select("applicant_id", "joining_date", "months", 'vessel_id', 'extensions')->get();
        $applicants = Applicant::find($lucs->pluck("applicant_id")->toArray());

        $lucs = $lucs->groupBy("applicant_id");

        $applicants->load('pro_app');
        $applicants->load('document_id');
        $applicants->load('document_med_cert');

        foreach ($applicants as $applicant) {
            $applicant->vessel = $vessel;
            $applicant->wage = isset($wage[$applicant->pro_app->rank_id]) ? $wage[$applicant->pro_app->rank_id][0] : 0;

            $rank = $ranks[$applicant->pro_app->rank_id][0];
            $applicant->position = $rank->name;
            $applicant->abbr = $rank->abbr;

            foreach($applicant->document_id as $docu){
                if($docu->type){
                    $applicant->{$docu->type} = $docu->number;
                }
            }

            foreach($applicant->document_med_cert as $docu){
                if($docu->type == "MEDICAL CERTIFICATE"){
                    $applicant->med_date = $docu->expiry_date;
                }
            }

            $date = $lucs[$applicant->id][0]["joining_date"];
            $months = $lucs[$applicant->id][0]["months"];
            $extensions = $lucs[$applicant->id][0]["extensions"];

            if($extensions){
                $extensions = json_decode($extensions);
                $date = now()->parse($date)->add($months, 'months');

                for($i = 0, $j = 1; $i < sizeof($extensions); $i++, $j++){
                    $months = $extensions[$i];
                    if($j < sizeof($extensions)){
                        $date = $date->add($months, 'months');
                    }
                }
            }

            $applicant->date_processed    = now()->toDateString();
            $applicant->effective_date    = $date->toDateString();
            $applicant->employment_months = $months;
            $applicant->valid_till        = $date->add($months, "months");
        }

        $this->principal = Principal::find($vessel->principal_id)->name;
        $this->applicants = $applicants;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        foreach($this->applicants as $applicant){
            $class = "App\Exports\MLC\\" . $this->principal;
            array_push($sheets, new $class($applicant, $applicant->abbr));
        }

        return $sheets;
    }
}