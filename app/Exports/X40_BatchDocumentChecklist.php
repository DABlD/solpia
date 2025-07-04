<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{Applicant, Vessel, Rank, ProcessedApplicant};
use App\User;

class X40_BatchDocumentChecklist implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($a,$b, $data){
        $vessel = Vessel::find($data['vid']);

        $ranks = ['MSTR', '2/O', 'BSN', 'C/E', '2AE', 'OLR', 'ELECT', 'CCK'];
        $applicants = [];

        foreach($ranks as $rank){
            $temp = new Applicant();
            $temp->user = new User();

            $temp->user->fname = " ";
            $temp->user->mname = " ";
            $temp->user->lname = " ";
            $temp->user->birthday = now();

            $tRank = Rank::where('abbr', $rank)->first();
            $temp->rank = $tRank->abbr;
            $temp->vessel = $vessel;

            $temp->data = ['type' => "template", 'fleet' => "FLEET B", 'rank' => $rank];

            array_push($applicants, $temp);
        }

        $this->vessel = $vessel;
        $this->applicants = $applicants;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $class = "App\Exports\\DocumentChecklist";

        foreach($this->applicants as $applicant){
            array_push($sheets, new $class($applicant,'X40_BatchDocumentChecklist', null));
        }

        return $sheets;
    }
}