<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Models\{Applicant, Vessel, Rank, ProcessedApplicant};

class X38_BatchCrewCompetencyChecklist2 implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($applicant,$type,$data){
        $this->applicant = $applicant;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $vessel = Vessel::find($this->data['vid']);

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
            $applicant->data = $this->data;

            $type = null;   //VESSELTYPE
            if(str_contains($applicant->vessel->type, "CONT") || str_contains($applicant->vessel->type, "BULK")){
                $type = 1;
            }
            else{
                $type = 2;
            }

            $type2 = null; //RANK CATEGORY
            if(str_contains($applicant->pro_app->rank->category, "DECK OFFICER")){
                $type2 = 1;
            }
            elseif(str_contains($applicant->pro_app->rank->category, "ENGINE OFFICER")){
                $type2 = 2;
            }
            else{
                $type2 = 3;
            }

            if($type == 1){ // CONT/BULK
                if($type2 == 1){ // DECK OFFICER
                    array_push($sheets, new HMM\CrewCompetencyChecklistCBDO($applicant, "OFF-CNTRBLK"));
                }
                elseif($type2 == 2){ // ENGINE OFFICERS
                    array_push($sheets, new HMM\CrewCompetencyChecklistCBEO($applicant, "ENG-CNTRBLK"));
                }
                else{ // RATINGS
                    array_push($sheets, new  HMM\CrewCompetencyChecklistCBRatings($applicant, "RTN-CNTRBLK"));
                }
            }
            else{ // TANKER
                if($type2 == 1){ // DECK OFFICER
                    array_push($sheets, new HMM\CrewCompetencyChecklistTDO($applicant, "OFF-TNKR"));
                }
                elseif($type2 == 2){ // ENGINE OFFICERS
                    array_push($sheets, new HMM\CrewCompetencyChecklistTEO($applicant, "ENG-TNKR"));
                }
                else{ // RATINGS
                    array_push($sheets, new  HMM\CrewCompetencyChecklistTRatings($applicant, "RTN-TNKR"));
                }
            }
        }

        return $sheets;
    }
}