<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Hms implements WithMultipleSheets
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
        array_push($sheets, new Hms1($this->applicant, $this->type . '1'));

        return $sheets;
    }
}
