<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Hanjoo implements WithMultipleSheets
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

        // array_push($sheets, new HanjooBD($this->applicant, $this->type . 'BD'));
        // array_push($sheets, new HanjooDC($this->applicant, $this->type . 'DC'));
        // array_push($sheets, new HanjooLC($this->applicant, $this->type . 'LC'));
        array_push($sheets, new HanjooI1($this->applicant, $this->type . 'I1'));
        // array_push($sheets, new HanjooI2($this->applicant, $this->type . 'I2'));
        // array_push($sheets, new HanjooI3($this->applicant, $this->type . 'I3'));
        
        return $sheets;
    }
}