<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ScMarine implements WithMultipleSheets
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

        array_push($sheets, new ScMarineBD($this->applicant, $this->type . 'BD'));
        array_push($sheets, new ScMarineDC($this->applicant, $this->type . 'DC'));
        array_push($sheets, new ScMarineLC($this->applicant, $this->type . 'LC'));

        return $sheets;
    }
}
