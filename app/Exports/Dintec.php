<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Dintec implements WithMultipleSheets
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
        array_push($sheets, new Klcsm1($this->applicant, 'klcsm1'));
        array_push($sheets, new Klcsm2($this->applicant, 'klcsm2'));
        array_push($sheets, new Klcsm3($this->applicant, 'klcsm3'));
        array_push($sheets, new Klcsm4($this->applicant, 'klcsm4'));
        array_push($sheets, new Klcsm5($this->applicant, 'klcsm5'));

        return $sheets;
    }
}
