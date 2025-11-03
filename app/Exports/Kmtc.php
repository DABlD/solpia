<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Kmtc implements WithMultipleSheets
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

        if($this->applicant->rank->category == "DECK OFFICER"){
            array_push($sheets, new KmtcDO($this->applicant, $this->type . 'do'));
        }
        else if($this->applicant->rank->category == "ENGINE OFFICER"){
            array_push($sheets, new KmtcEO($this->applicant, $this->type . 'eo'));
        }
        else{
            array_push($sheets, new KmtcR($this->applicant, $this->type . 'r'));
        }
        array_push($sheets, new Kmtc2($this->applicant, $this->type . '2'));
        
        return $sheets;
    }
}