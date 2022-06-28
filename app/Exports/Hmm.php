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
        array_push($sheets, new Hmm1($this->applicant, $this->type . '1'));

        $ranks = ['C/O', '2/O', '3/O', 'BSN', 'AB', 'OS', 'AO', 'DCDT', '1AE', '2AE', '3AE', 'OLR1', 'OLR', 'ELECT', 'A/E', 'CCK', '2CK'];
        if((auth()->user()->fleet == "FLEET B" || auth()->user()->role == "Admin") && in_array($this->applicant->rank->abbr, $ranks)){
            $rank = $this->applicant->rank->abbr;

            if($rank == "C/O"){
                $rows = 34;
                $rank = "CO";
            }
            elseif($rank == "2/O"){
                $rows = 33;
                $rank = "2O";
            }
            elseif($rank == "3/O"){
                $rows = 32;
                $rank = "3O";
            }
            elseif($rank == "A/O"){
                $rows = 30;
                $rank = "AO";
            }
            elseif($rank == "3AE"){
                $rows = 33;
                $rank = "3AE";
            }
            elseif($rank == "A/E"){
                $rows = 30;
                $rank = "AE";
            }
            elseif($rank == "OLR"){
                $rows = 30;
                $rank = "OLR";
            }
            elseif($rank == "OLR1"){
                $rows = 30;
                $rank = "OLR1";
            }
            elseif($rank == "1AE"){
                $rows = 33;
                $rank = "1AE";
            }
            elseif($rank == "CCK"){
                $rows = 30;
                $rank = "CCK";
            }
            elseif($rank == "BSN"){
                $rows = 30;
                $rank = "BSN";
            }
            elseif($rank == "AB"){
                $rows = 30;
                $rank = "AB";
            }
            elseif($rank == "2CK"){
                $rows = 30;
                $rank = "2CK";
            }
            elseif($rank == "OS"){
                $rows = 30;
                $rank = "OS";
            }
            elseif($rank == "ELECT"){
                $rows = 34;
                $rank = "ELECT";
            }
            elseif($rank == "2AE"){
                $rows = 33;
                $rank = "2AE";
            }
            elseif($rank == "DCDT"){
                $rows = 30;
                $rank = "DCDT";
            }

            array_push($sheets, new InterviewSheet($this->applicant, $rows, "hmm", $rank));
        }

        return $sheets;
    }
}
