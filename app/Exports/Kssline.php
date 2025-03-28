<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Kssline implements WithMultipleSheets
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
            array_push($sheets, new KsslineDO($this->applicant, $this->type . 'do'));
        }
        else if($this->applicant->rank->category == "ENGINE OFFICER"){
            array_push($sheets, new KsslineEO($this->applicant, $this->type . 'eo'));
        }
        array_push($sheets, new Kssline2($this->applicant, $this->type . '2'));
        
        return $sheets;
    }
}