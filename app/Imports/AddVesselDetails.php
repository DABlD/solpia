<?php

namespace App\Imports;

use App\Models\{Vessel};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{ToCollection, WithHeadingRow};

class AddVesselDetails implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $temp = Vessel::where('status', 'active')->get();
        $vessels = [];

        foreach($temp as $vessel){
            $name = str_replace("/", "", $vessel->name);
            $vessels[$name] = $vessel;
        }

        foreach($rows as $row){
            if(in_array($row['vessel_name'], array_keys($vessels))){
                $temp = $vessels[$row['vessel_name']];

                if($temp->imo == null && $row['imo_number'] != ""){
                    $temp->imo = $row['imo_number'];
                }
                if($temp->flag == null && $row['flag_port_of_registry'] != ""){
                    $temp->flag = $row['flag_port_of_registry'];
                }
                if($temp->year_build == null && $row['yr_built'] != ""){
                    $temp->year_build = $row['yr_built'];
                }
                if($temp->engine == null && $row['engine_make'] != ""){
                    $temp->engine = $row['engine_make'];
                }
                if($temp->gross_tonnage == null && $row['grt'] != ""){
                    $temp->gross_tonnage = $row['grt'];
                }
                if($temp->trade == null && $row['trading'] != ""){
                    $temp->trade = $row['trading'];
                }
                if($temp->mlc_shipowner == null && $row['mlc_ships_owner_name'] != ""){
                    $temp->mlc_shipowner = $row['mlc_ships_owner_name'];
                }
                if($temp->mlc_shipowner_address == null && $row['ships_owner_address'] != ""){
                    $temp->mlc_shipowner_address = $row['ships_owner_address'];
                }
                if($temp->former_agency == null && $row['former_agency'] != "" && $row['former_agency'] != "NONE" && $row['former_agency'] != "SAME"){
                    $temp->former_agency = $row['former_agency'];
                }
                if($temp->former_principal == null && $row['former_principal'] != "" && $row['former_principal'] != "NONE" && $row['former_principal'] != "SAME"){
                    $temp->former_principal = $row['former_principal'];
                }

                $temp->save();
            }
        }
    }
}