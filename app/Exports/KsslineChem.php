<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KsslineChem implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($applicant,$type){
        $this->applicant = $applicant;
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        // if($this->applicant->rank->category == "DECK OFFICER"){
        //     array_push($sheets, new KsslineDO($this->applicant, $this->type . 'do'));
        // }
        // else if($this->applicant->rank->category == "ENGINE OFFICER"){
        //     array_push($sheets, new KsslineEO($this->applicant, $this->type . 'eo'));
        // }
        // else{
        //     array_push($sheets, new KsslineR($this->applicant, $this->type . 'r'));
        // }
        array_push($sheets, new KsslineChemR($this->applicant, $this->type . 'r'));
        array_push($sheets, new Kssline2($this->applicant, 'kssline2'));
        
        return $sheets;
    }
}