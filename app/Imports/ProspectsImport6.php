<?php

namespace App\Imports;

use App\User;
use App\Models\Prospect;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProspectsImport6 implements ToCollection, WithCalculatedFormulas
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
                $temp->name = $prospect[1];
                $temp->rank = $prospect[0];
                $temp->contact = $prospect[2];
                $temp->exp = $prospect[4];

                if(str_contains($prospect[7], "WITH US VISA") || str_contains($prospect[7], "/ US")){
                    $temp->usv = "W/ VISA";
                }
                elseif(str_contains($prospect[7], "EXPIRED US")){
                    $temp->usv = "EXPIRED";
                }

                $loc = strpos($prospect[7], "YRS OLD");
                if($loc){
                    $temp->age = substr($prospect[7], $loc-3,2);
                }
                $temp->remarks = $prospect[7] . "/ENDORSED To FLEET " . $prospect[5];

                $temp->save();
            }
        }
    }
}