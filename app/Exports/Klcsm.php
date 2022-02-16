<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Klcsm implements WithMultipleSheets
{
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
        array_push($sheets, new Klcsm1($this->applicant, $this->type . '1'));
        array_push($sheets, new Klcsm2($this->applicant, $this->type . '2'));
        // array_push($sheets, new Klcsm3($this->applicant, $this->type . '3'));
        // array_push($sheets, new Klcsm4($this->applicant, $this->type . '4'));
        // array_push($sheets, new Klcsm5($this->applicant, $this->type . '5'));
        // array_push($sheets, new Klcsm6($this->applicant, $this->type . '6'));

        return $sheets;
    }
}
