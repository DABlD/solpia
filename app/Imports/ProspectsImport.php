<?php

namespace App\Imports;

use App\User;
use App\Models\Prospect;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProspectsImport implements ToCollection, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $prospects)
    {
        foreach($prospects as $key => $prospect){
            if($key > 0 && trim($prospect[3]) != ""){
                $temp = new Prospect();
                $temp->name = $prospect[3];
                $temp->age = $prospect[5];
                $temp->contact = $prospect[6];
                $temp->usv = $prospect[8];
                $temp->rank = $prospect[2];
                $temp->exp = $prospect[7];
                $temp->remarks = $prospect[17];

                if(trim($prospect[4])){
                    $temp->birthday = gmdate("Y-m-d", ($prospect[4] - 25569) * 86400);
                }

                $temp->save();
            }
        }
    }
}
