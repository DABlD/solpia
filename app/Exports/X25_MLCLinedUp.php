<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{ProcessedApplicant, Applicant, Vessel, Rank, Wage, Principal};

class X25_MLCLinedUp implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($a,$b, $data){
        $vessel = Vessel::find($data['vid']);
        $ranks = Rank::get()->groupBy('id');
        $wage = Wage::where('vessel_id', $vessel->id)->get()->groupBy("rank_id");

        $lucs = ProcessedApplicant::where("vessel_id", $vessel->id)->where("status", "Lined-Up")->select("applicant_id", 'vessel_id')->get();
        $applicants = Applicant::find($lucs->pluck("applicant_id")->toArray());

        $lucs = $lucs->groupBy("applicant_id");

        $applicants->load('pro_app');
        $applicants->load('document_id');
        $applicants->load('document_med_cert');

        foreach ($applicants as $applicant) {
            $applicant->vessel = $vessel;
            $applicant->wage = isset($wage[$applicant->pro_app->rank_id]) ? $wage[$applicant->pro_app->rank_id][0] : null;

            $rank = $ranks[$applicant->pro_app->rank_id][0];
            $applicant->position = $rank->name;
            $applicant->rankType = $rank->type;
            $applicant->abbr = $rank->abbr;

            foreach($applicant->document_id as $docu){
                if($docu->type){
                    $applicant->{$docu->type} = $docu->number;
                }
            }

            foreach($applicant->document_med_cert as $docu){
                if($docu->type == "MEDICAL CERTIFICATE"){
                    $applicant->med_date = $docu->expiry_date;
                }
            }

            $date = now()->parse($data["joining_date"]);
            $months = $data["months"];

            $applicant->date_processed    = now()->toDateString();
            $applicant->effective_date    = $date->toDateString();
            $applicant->employment_months = $months;
            $applicant->valid_till        = $date->add($months, "months");
        }

        $this->principal = Principal::find($vessel->principal_id)->name;
        $this->vessel = $vessel;
        $this->applicants = $applicants;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $principal = str_replace(' ', '', $this->principal);

        foreach($this->applicants as $applicant){
            $class = "App\Exports\MLC\\" . $principal;
            
            // FOR KLCSM BULK
            if($applicant->vessel->principal_id == 10){
                if(str_contains($applicant->vessel->type, "BULK")){
                    $class .= "BULK";
                }
                elseif(str_contains($applicant->vessel->type, "LNG")){
                    $class .= "LNG";
                }
            }

            if($applicant->vessel->id == 6005){
                $class .= "2";
            }

            // FOR HMM VESSEL SPECIFIC CADETS AND BOY
            $p1 = in_array($applicant->vessel->id, [4101, 4629, 4627, 3822, 4628, 2069, 4433, 2044, 2725, 8630, 8841]); // ALGECIRAS, OSLO, COPENHAGEN, GDANSK, HAMBURG, SOUTHAMPTON, LE HAVRE, ST PETERSBURG
            $p2 = $applicant->vessel->principal_id == 2; //KOSCO

            if(($p1 && in_array($applicant->pro_app->rank->id, [14, 19, 40, 41])) || ($p2 && in_array($applicant->pro_app->rank->id, [14, 19]))){
                $class .= "Cadet";
            }
            
            $title = str_replace('/', '', $applicant->abbr);

            // IF HMM
            if($class == "App\Exports\MLC\HMM"){
                $cm1 = [6791, 7569, 7169, 6245, 7947, 6517, 4433, 33, 36, 37, 38, 4101, 4627, 3822, 4628, 4629, 2069, 2044, 39, 42, 2725, 8630, 8828, 8827, 9379, 9564, 9557, 9539];
                $cm1v2 = [8841]; //PRIDE
                $cm1p5 = [8791, 8478, 9218, 9438];
                $cm2 = [6072, 5801, 5842, 5553, 4623, 4637, 6829, 7108, 7141, 7517, 7917, 7998, 8169, 9274];

                // CHANGE ALSO IN MLCCONTRACT, X16

                if(in_array($applicant->vessel->id, $cm1)){
                    array_push($sheets, new MLC\HMMCM1($applicant, $title));
                }
                elseif(in_array($applicant->vessel->id, $cm1v2)){
                    array_push($sheets, new MLC\HMMCM1V2($applicant, $title));
                }
                elseif(in_array($applicant->vessel->id, $cm2)){
                    array_push($sheets, new MLC\HMMCM2($applicant, $title));
                }
                elseif(in_array($applicant->vessel->id, $cm1p5)){
                    array_push($sheets, new MLC\HMMCM1P5($applicant, $title));
                }
            }
            elseif($class == "App\Exports\MLC\KSSLine"){
                array_push($sheets, new MLC\KSSLine1($applicant, $title));
                // array_push($sheets, new MLC\KSSLine2($applicant, $title));
                // array_push($sheets, new MLC\KSSLine3($applicant, $title));
            }
            else{
                array_push($sheets, new $class($applicant, $applicant->abbr, $title));
            }
        }

        if($class == "App\Exports\MLC\KSSLine"){
            // array_push($sheets, new MLC\KSSLine1($applicant, $title));
            array_push($sheets, new MLC\KSSLine2($applicant, $title));
            array_push($sheets, new MLC\KSSLine3($applicant, $title));
        }

        return $sheets;
    }
}