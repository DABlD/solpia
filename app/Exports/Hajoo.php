<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Hajoo implements WithMultipleSheets
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

        array_push($sheets, new HajooBD($this->applicant, $this->type . 'BD'));
        array_push($sheets, new HajooDC($this->applicant, $this->type . 'DC'));
        array_push($sheets, new HajooLC($this->applicant, $this->type . 'LC'));

        return $sheets;
    }
}