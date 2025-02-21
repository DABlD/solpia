<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Models\{ProcessedApplicant, Applicant};

class X37_LinedUpFinalBriefing implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($data, $type, $req){
        $this->data = $req;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $pas = ProcessedApplicant::where('vessel_id', $this->data['vid'])->where('status', 'Lined-Up')->pluck('applicant_id');
        $crews = Applicant::whereIn('id', $pas)->get();

        foreach($crews as $crew){
            $this->data['fn'] = $crew->user->lname;
            array_push($sheets, new X29_FinalBriefing($crew, 'X29_FinalBriefing', $this->data));
        }

        return $sheets;
    }
}
