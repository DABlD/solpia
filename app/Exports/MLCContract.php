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

        $this->applicant->position = Rank::find($this->applicant->pro_app->rank_id)->name;
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

        $sheets = [];
        $class = "App\Exports\MLC\\" . Principal::find($this->applicant->vessel->principal_id)->name;
        array_push($sheets, new $class($this->applicant, $this->type, $this->req));

        return $sheets;
    }
}