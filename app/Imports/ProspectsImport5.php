<?php

namespace App\Imports;

use App\User;
use App\Models\Prospect;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProspectsImport5 implements ToCollection, WithCalculatedFormulas
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
                $temp->contracts = $prospect[4];
                $temp->usv = $prospect[5];
                $temp->last_disembark = $prospect[6];
                $temp->age = $prospect[7];
                $temp->contact = $prospect[8];
                $temp->location = $prospect[9];
                $temp->remarks = "KALAW";

                $temp->save();
            }
        }
    }
}