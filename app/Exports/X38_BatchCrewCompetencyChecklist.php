<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{Applicant, Vessel, Rank, ProcessedApplicant};

class X38_BatchCrewCompetencyChecklist implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($a,$b, $data){
        $vessel = Vessel::find($data['vid']);

        $lucs = ProcessedApplicant::where("vessel_id", $vessel->id)->where("status", "Lined-Up")->select("applicant_id", 'vessel_id')->get();
        $applicants = Applicant::find($lucs->pluck("applicant_id")->toArray());

        $applicants->load('document_flag');
        $applicants->load('document_id');
        $applicants->load('document_lc');
        $applicants->load('document_med_cert');
        $applicants->load('document_med');
        $applicants->load('pro_app');

        foreach ($applicants as $applicant) {
            foreach(['document_id', 'document_flag', 'document_lc', 'document_med', 'document_med_cert' ] as $docuType){
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

            $applicant->rank = Rank::find($applicant->pro_app->rank_id)->abbr;
            $applicant->vessel = Vessel::find($applicant->pro_app->vessel_id);
            $applicant->data = $data;
        }

        $this->vessel = $vessel;
        $this->applicants = $applicants;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $class = "App\Exports\\X11_CrewCompetencyChecklist";

        foreach($this->applicants as $applicant){
            array_push($sheets, new $class($applicant,'X11_CrewCompetencyChecklist',$applicant->data,$applicant->rank));
        }

        return $sheets;
    }
}