<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{Rank, Vessel, Wage, Principal};

class MLCContract implements WithMultipleSheets
{
    public function __construct($applicant, $type, $req){
        $this->applicant    = $applicant;
        $this->type         = $type;
        $this->req          = $req;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $this->applicant->load('pro_app');
        $this->applicant->load('document_id');
        $this->applicant->vessel = Vessel::find($this->applicant->pro_app->vessel_id);

        $rank = Rank::find($this->applicant->pro_app->rank_id);
        $this->applicant->position = $rank->name;
        $this->applicant->rankType = $rank->type;
        $this->applicant->wage = Wage::where('rank_id', $this->applicant->pro_app->rank_id)
                                    ->where('vessel_id', $this->applicant->pro_app->vessel_id)
                                    ->first();

        foreach($this->applicant->document_id as $docu){
            if($docu->type){
                $this->applicant->{$docu->type} = $docu->number;
            }
        }

        $this->applicant->date_processed    = $this->req['date_processed'];
        $this->applicant->effective_date    = $this->req['effective_date'];
        $this->applicant->valid_till        = $this->req['valid_till'];
        $this->applicant->med_date          = $this->req['med_date'];
        $this->applicant->employment_months = $this->req['employment_months'];
        $this->applicant->port = $this->req['port'];

        $sheets = [];
        $class = "App\Exports\MLC\\" . Principal::find($this->applicant->vessel->principal_id)->name;

        // FOR SINOCREW
        if($this->applicant->vessel->id == 6005){
            $class .= "2";
        }
        if($this->applicant->vessel->id == 6094){
            $class .= "3";
        }

        // FOR HMM VESSEL SPECIFIC CADETS AND BOY
        $p1 = in_array($this->applicant->vessel->id, [4101, 4629, 4627, 3822, 4628, 2069, 4433, 2044]); // ALGECIRAS, OSLO, COPENHAGEN, GDANSK, HAMBURG, SOUTHAMPTON, LE HAVRE, ST PETERSBURG
        $p2 = $this->applicant->vessel->principal_id == 2; //KOSCO

        if(($p1 && in_array($this->applicant->pro_app->rank->id, [14, 19, 40, 41])) || ($p2 && in_array($this->applicant->pro_app->rank->id, [14, 19]))){
            $class .= "Cadet";
        }

        $class = str_replace(' ', '', $class);

        if(isset($this->req['itf'])){
            $class .= "_" . $this->req['itf'];
        }

        array_push($sheets, new $class($this->applicant, $this->type, $this->req));

        return $sheets;
    }
}