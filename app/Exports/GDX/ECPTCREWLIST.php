<?php

namespace App\Exports\GDX;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Models\LineUpContract;
use App\Models\ProcessedApplicant;

class ECPTCREWLIST implements WithMultipleSheets
{
    public function __construct($applicant,$type, $data){
        $vessels = [];

        foreach($data['vessels'] as $vid){
            if($data['type'] == "lun"){
                array_push($vessels, ProcessedApplicant::where('vessel_id', $vid)->where('status', 'Lined-Up')->get());
            }
            else{
                array_push($vessels, LineUpContract::where('vessel_id', $vid)->where('status', 'On Board')->get());
            }
        }


        $this->vessels = $vessels;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach($this->vessels as $vessel){
            if($vessel->count()){
                array_push($sheets, new ECPTCREWLISTSHEET($vessel, $vessel->first()->vessel->name));
            }
        }

        return $sheets;
    }
}
