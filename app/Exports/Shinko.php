<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Shinko implements WithMultipleSheets
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

        array_push($sheets, new ShinkoBD($this->applicant, $this->type . 'BD'));
        array_push($sheets, new ShinkoDC($this->applicant, $this->type . 'DC'));
        // array_push($sheets, new ShinkoBD($this->applicant, $this->type));

        return $sheets;
    }
}
