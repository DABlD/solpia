<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\HMM\InterviewSheet;

class Sinocrew2 implements WithMultipleSheets
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

        if(str_contains($this->applicant->rank->category, 'ENGINE')){
            array_push($sheets, new Sinocrew2_Engine($this->applicant, $this->type));
        }
        else{
            array_push($sheets, new Sinocrew2_Deck($this->applicant, $this->type));
        }


        return $sheets;
    }
}
