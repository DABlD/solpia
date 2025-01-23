<?php

namespace App\Exports\MLC;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class HMM implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($applicant){
        $this->applicant = $applicant;
    }

    public function sheets(): array
    {
        dd('testzxczczxc');
        // NOT USED
        // NOT USED
        // NOT USED
        // NOT USED
        // NOT USED
        // NOT USED
        // NOT USED
        // NOT USED
        // NOT USED
        // NOT USED
        $sheets = [];

        $cm1 = [6791, 7569, 7169, 6245, 7947, 6517, 4433, 33, 36, 37, 38, 4101, 4627, 3822, 4628, 4629, 2069, 2044, 39, 42, 2725, 8630, 8841, 8828, 8827, 8791];
        $cm2 = [6072, 5801, 5842, 5553, 4623, 4637, 6829, 7108, 7141, 7517, 7917, 7998, 8169];

        if(in_array($this->applicant->vessel->id, $cm1)){
            array_push($sheets, new HMMCM1($this->applicant, $this->title));
        }
        else{
            array_push($sheets, new HMMCM2($this->applicant, $this->title));
        }

        return $sheets;
    }
}