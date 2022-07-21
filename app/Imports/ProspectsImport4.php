<?php

namespace App\Imports;

use App\User;
use App\Models\Prospect;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProspectsImport4 implements ToCollection, WithCalculatedFormulas
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
                $temp->rank = $prospect[1];
                $temp->exp = $prospect[3];
                $temp->contact = $prospect[4];
                $temp->remarks = $prospect[8];

                if(str_contains($prospect[8], "WITH US VISA")){
                    $temp->usv = "W/ VISA";
                }
                elseif(str_contains($prospect[8], "EXPIRED US")){
                    $temp->usv = "EXPIRED";
                }

                $loc = strpos($prospect[8], "YRS OLD");
                if($loc){
                    $temp->age = substr($prospect[8], $loc-3,2);
                }

                $temp->save();
            }
        }
    }
}