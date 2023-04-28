<?php

namespace App\Exports\POEA;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{ProcessedApplicant, Applicant, Vessel, Rank, Wage, Principal};

class X26_POEALinedUp implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($a,$b, $data){
        $vessel = Vessel::find($data['vid']);
        $ranks = Rank::get()->groupBy('id');

        $wage = Wage::where('vessel_id', $vessel->id)->get()->groupBy("rank_id");

        $lucs = ProcessedApplicant::where("vessel_id", $vessel->id)->where("status", "Lined-Up")->select("applicant_id", 'vessel_id')->get();
        $applicants = Applicant::find($lucs->pluck("applicant_id")->toArray());

        $lucs = $lucs->groupBy("applicant_id");

        $applicants->load('pro_app.rank', 'pro_app.vessel');
        $applicants->load('document_id');
        $applicants->load('document_lc');
        $applicants->load('document_flag');
        $applicants->load('document_med_cert');
        $applicants->load('educational_background');

        foreach ($applicants as $applicant) {
            $applicant->wage = isset($wage[$applicant->pro_app->rank_id]) ? $wage[$applicant->pro_app->rank_id][0] : null;

            foreach(['document_id', 'document_flag', 'document_lc', 'document_med_cert' ] as $docuType){
                foreach($applicant->$docuType as $key => $doc){
                    $name = $doc->type;
                    if(!isset($applicant->$docuType->$name)){
                        $applicant->$docuType->$name = $doc;
                    }
                    else{
                        $size = 0;
                        if(is_array($applicant->$docuType->$name)){
                            $size = sizeof($applicant->$docuType->$name);
                        }
                        $name .= $size;
                        $applicant->$docuType->$name = $doc;
                    }
                    $applicant->$docuType->forget($key);
                }
            }

            $applicant->employment_months = $data["employment_months"];
        }

        $this->applicants = $applicants;
        $this->data = $data;
        // dd($data);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        foreach($this->applicants as $applicant){
            $class = "App\Exports\\" . $this->data['folder'] . $this->data['format'];

            if($applicant->vessel->id == 6005){
                $class .= "2";
            }

            array_push($sheets, new $class($applicant, $this->data['format'], $this->data, $applicant->pro_app->rank->abbr));
        }

        return $sheets;
    }
}