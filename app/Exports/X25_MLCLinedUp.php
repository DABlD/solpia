<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{ProcessedApplicant, Applicant, Vessel, Rank, Wage, Principal};

class X25_MLCLinedUp implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($a,$b, $data){
        $vessel = Vessel::find($data['vid']);
        $ranks = Rank::get()->groupBy('id');
        $wage = Wage::where('vessel_id', $vessel->id)->get()->groupBy("rank_id");

        $lucs = ProcessedApplicant::where("vessel_id", $vessel->id)->where("status", "Lined-Up")->select("applicant_id", 'vessel_id')->get();
        $applicants = Applicant::find($lucs->pluck("applicant_id")->toArray());

        $lucs = $lucs->groupBy("applicant_id");

        $applicants->load('pro_app');
        $applicants->load('document_id');
        $applicants->load('document_med_cert');

        foreach ($applicants as $applicant) {
            $applicant->vessel = $vessel;
            $applicant->wage = isset($wage[$applicant->pro_app->rank_id]) ? $wage[$applicant->pro_app->rank_id][0] : null;

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

            $date = now()->parse($data["joining_date"]);
            $months = $data["months"];

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

            if($applicant->vessel->id == 6005){
                $class .= "2";
            }

            array_push($sheets, new $class($applicant, $applicant->abbr));
        }

        return $sheets;
    }
}