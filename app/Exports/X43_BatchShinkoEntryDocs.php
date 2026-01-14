<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{Applicant, Vessel, Rank, ProcessedApplicant};

class X43_BatchShinkoEntryDocs implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($a,$b, $data){
        $applicants = Applicant::whereIn('id', $data['ids'])->get();

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

            $applicant->rank = str_replace('/', '', Rank::find($applicant->pro_app->rank_id)->abbr);
            $applicant->vessel = Vessel::find($applicant->pro_app->vessel_id);
            $applicant->data = $data;
        }

        $this->applicants = $applicants;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $class = "App\Exports\\X42_ShinkoEntryDocs";

        foreach($this->applicants as $applicant){
            array_push($sheets, new $class($applicant,'X42_ShinkoEntryDocs',$applicant->rank));
        }

        return $sheets;
    }
}