<?php

namespace App\Exports\MLC;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KSSLine implements WithMultipleSheets
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
        array_push($sheets, new KSSLine1($this->applicant, $this->type . '1'));
        array_push($sheets, new KSSLine2($this->applicant, $this->type . '2'));
        array_push($sheets, new KSSLine3($this->applicant, $this->type . '3'));

        return $sheets;
    }
}
