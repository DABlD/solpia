<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{Applicant, ProcessedApplicant};
use App\User;

class X41_BatchDispatchChecklist implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($a,$b, $data){
        $lucs = ProcessedApplicant::where('vessel_id', $data['vid'])->where('status', 'Lined-Up')->get();

        $applicants = [];

        foreach($lucs as $luc){
            array_push($applicants, $luc->applicant);
        }

        $this->applicants = $applicants;
        $this->req = $data;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $class = "App\Exports\\X28_DispatchChecklist";

        foreach($this->applicants as $applicant){
            array_push($sheets, new $class($applicant,'X28_DispatchChecklist', $this->req, $applicant->pro_app->rank->abbr));
        }

        return $sheets;
    }
}