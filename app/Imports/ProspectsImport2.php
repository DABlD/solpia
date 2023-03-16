<?php

namespace App\Imports;

use App\User;
use App\Models\Prospect;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProspectsImport2 implements ToCollection, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $prospects)
    {
        foreach($prospects as $key => $prospect){
            if($key > 0 && trim($prospect[2]) != ""){
                $temp = new Prospect();
                $temp->name = $prospect[2];
                $temp->age = $prospect[3];
                $temp->contact = $prospect[4];
                $temp->contracts = $prospect[7];
                $temp->rank = $prospect[5];
                $temp->exp = $prospect[8];
                $temp->location = $prospect[12];
                $temp->previous_salary = $prospect[13];
                $temp->previous_agency = $prospect[14];
                $temp->email = $prospect[15];
                $temp->remarks = $prospect[16];

                if($prospect[16] == ""){
                    $temp->remarks .= "Docs - " . $prospect[11];
                }
                else{
                    $temp->remarks .= " / Docs - " . $prospect[11];
                }

                // dd($prospect[9], $prospect[10]);
                if(trim($prospect[6]) && (is_numeric($prospect[6]) && $prospect[6] > 40000)){
                    try {
                        $temp->usv = gmdate("Y-m-d", ($prospect[6] - 25569) * 86400);
                    } catch (\Exception $e) {
                        $temp->usv = null;
                    }
                }
                if(trim($prospect[9])){
                    try {
                        $temp->availability = gmdate("Y-m-d", ($prospect[9] - 25569) * 86400);
                    } catch (\Exception $e) {
                        $temp->availability = null;
                    }
                }
                if(trim($prospect[10])){
                    try {
                        $temp->last_disembark = gmdate("Y-m-d", ($prospect[10] - 25569) * 86400);
                    } catch (\Exception $e) {
                        $temp->last_disembark = null;
                    }
                }

                $temp->save();
            }
        }
    }
}