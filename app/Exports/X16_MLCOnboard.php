<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{LineUpContract, Applicant, Vessel, Rank, Wage, Principal};

class X16_MLCOnboard implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($a,$b, $data){
        $vessel = Vessel::find($data['vid']);
        $ranks = Rank::get()->groupBy('id');
        $wage = Wage::where('vessel_id', $vessel->id)->get()->groupBy("rank_id");

        $lucs = LineUpContract::where("vessel_id", $vessel->id)->where("status", "On Board")->select("applicant_id", "joining_date", "months", 'vessel_id', 'extensions')->get();
        $applicants = Applicant::find($lucs->pluck("applicant_id")->toArray());

        $lucs = $lucs->groupBy("applicant_id");

        $applicants->load('pro_app');
        $applicants->load('document_id');
        $applicants->load('document_med_cert');

        foreach ($applicants as $applicant) {
            $applicant->vessel = $vessel;
            $applicant->wage = isset($wage[$applicant->pro_app->rank_id]) ? $wage[$applicant->pro_app->rank_id][0] : null;

            $rank = $ranks[$applicant->pro_app->rank_id][0];
            $applicant->rankType = $rank->type;
            $applicant->abbr = $rank->abbr;
            $applicant->position = $rank->name;

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

            $date = $lucs[$applicant->id][0]["joining_date"];
            $months = $lucs[$applicant->id][0]["months"];
            $extensions = $lucs[$applicant->id][0]["extensions"];

            if($extensions){
                $extensions = json_decode($extensions);
                $date = now()->parse($date)->add($months, 'months');

                for($i = 0, $j = 1; $i < sizeof($extensions); $i++, $j++){
                    $months = $extensions[$i];
                    if($j < sizeof($extensions)){
                        $date = $date->add($months, 'months');
                    }
                }
            }

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
        $class = "App\Exports\MLC\\" . $principal;

        // FOR KLCSM BULK
        if(str_contains($this->vessel->type, "BULK") && $principal == "KLCSM"){
            $class .= "BULK";
        }

        foreach($this->applicants as $applicant){

            // FOR HMM VESSEL SPECIFIC CADETS AND BOY
            $p1 = in_array($applicant->vessel->id, [4101, 4629, 4627, 3822, 4628, 2069, 4433, 2044, 2725, 8630, 8841]); // ALGECIRAS, OSLO, COPENHAGEN, GDANSK, HAMBURG, SOUTHAMPTON, LE HAVRE, ST PETERSBURG
            $p2 = $applicant->vessel->principal_id == 2; //KOSCO

            if(($p1 && in_array($applicant->pro_app->rank->id, [14, 19, 40, 41])) || ($p2 && in_array($applicant->pro_app->rank->id, [14, 19]))){
                $class .= "Cadet";
            }
            
            $title = str_replace('/', '', $applicant->abbr);

            // IF HMM
            if($class == "App\Exports\MLC\HMM"){
                $cm1 = [6791, 7569, 7169, 6245, 7947, 6517, 4433, 33, 36, 37, 38, 4101, 4627, 3822, 4628, 4629, 2069, 2044, 39, 42, 2725, 8630, 8841, 8828, 8827, 9379];
                $cm1p5 = [8791, 8478];
                $cm2 = [6072, 5801, 5842, 5553, 4623, 4637, 6829, 7108, 7141, 7517, 7917, 7998, 8169, 9274, 9218, 9438];

                // CHANGE ALSO IN X16, X25

                if(in_array($applicant->vessel->id, $cm1)){
                    array_push($sheets, new MLC\HMMCM1($applicant, $title));
                }
                elseif(in_array($applicant->vessel->id, $cm2)){
                    array_push($sheets, new MLC\HMMCM2($applicant, $title));
                }
                elseif(in_array($applicant->vessel->id, $cm1p5)){
                    array_push($sheets, new MLC\HMMCM1P5($applicant, $title));
                }
            }
            elseif($class == "App\Exports\MLC\KSSLine"){
                array_push($sheets, new MLC\KSSLine1($applicant, $applicant->abbr));
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