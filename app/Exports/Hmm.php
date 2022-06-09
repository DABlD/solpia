<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\HMM\InterviewSheet;

class Hmm implements WithMultipleSheets
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
        // array_push($sheets, new Hmm1($this->applicant, $this->type . '1'));

        if(auth()->user()->fleet == "FLEET B" || auth()->user()->role == "Admin" || auth()->user()->role == "Principal"){
            $rank = $this->applicant->rank->abbr;
            $rank = "2/O";

            if($rank == "2/O"){
                $rows = 33;
                $rank = "2O";
            }
            elseif($rank == "3/O"){
                $rows = 36;
                $rank = "3O";
            }

            array_push($sheets, new InterviewSheet($this->applicant, $rows, "hmm", $rank));
        }

        return $sheets;
    }
}
