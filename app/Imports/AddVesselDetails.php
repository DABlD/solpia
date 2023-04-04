<?php

namespace App\Imports;

use App\User;
use App\Models\{Vessel, Principal};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use DB;

class AddVesselDetails implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $data)
    {
        $ctr = 0;
        $ctr2 = 0;

        DB::enableQueryLog();

        $vessels = [];
        $temp = Vessel::where('status', 'active')->get();
        foreach($temp as $vessel){
            $vessel->name = str_replace("/", "", $vessel->name);
            $vessels[$vessel->name] = $vessel;
        }

        $names = $temp->pluck('name')->toArray();
        $size = sizeof($data);

        for($i = 1; $i < $size; $i++){
            $vname = $data[$i][1];

            if(in_array($vname, $names)){
                if($vessels[$vname]->imo == "" && $data[$i][15] != ""){
                    $vessels[$vname]->imo = $data[$i][15];
                }
                if($vessels[$vname]->flag == "" && $data[$i][13] != ""){
                    $vessels[$vname]->flag = $data[$i][13];
                }
                if($vessels[$vname]->year_build == "" && $data[$i][9] != ""){
                    $vessels[$vname]->year_build = $data[$i][9];
                }
                if($vessels[$vname]->engine == "" && $data[$i][8] != ""){
                    $vessels[$vname]->engine = $data[$i][8];
                }
                if($vessels[$vname]->gross_tonnage == "" && $data[$i][3] != ""){
                    $vessels[$vname]->gross_tonnage = $data[$i][3];
                }
                if($vessels[$vname]->trade == "" && $data[$i][21] != ""){
                    $vessels[$vname]->trade = $data[$i][21];
                }
                if($vessels[$vname]->mlc_shipowner == "" && $data[$i][64] != ""){
                    $vessels[$vname]->mlc_shipowner = $data[$i][64];
                }
                if($vessels[$vname]->mlc_shipowner_address == "" && $data[$i][65] != ""){
                    $vessels[$vname]->mlc_shipowner_address = $data[$i][65];
                }
                if($vessels[$vname]->former_agency == "" && $data[$i][26] != "" && $data[$i][26] != "NONE" && $data[$i][26] != "SAME"){
                    $vessels[$vname]->former_agency = $data[$i][26];
                }
                if($vessels[$vname]->former_principal == "" && $data[$i][27] != "" && $data[$i][27] != "NONE" && $data[$i][27] != "SAME"){
                    $vessels[$vname]->former_principal = $data[$i][27];
                }

                $vessels[$vname]->save();
            }
        }

        // foreach($data as $vessel){
        //     $vname = $vessel[1];
        //     $array = [];

        //     if(in_array($vname, $names)){
        //         $ctr2++;
        //         if($vessels[$vname]->imo == "" && $vessel[15] != ""){
        //             // $array["imo"] = $vessel[15];
        //             $vessels[$vname]->imo = $vessel[15];
        //             $ctr++;
        //         }
        //         if($vessels[$vname]->flag == "" && $vessel[13] != ""){
        //             // $array["flag"] = $vessel[13];
        //             $vessels[$vname]->flag = $vessel[13];
        //             $ctr++;
        //         }
        //         if($vessels[$vname]->year_build == "" && $vessel[9] != ""){
        //             // $array["year_build"] = $vessel[9];
        //             $vessels[$vname]->year_build = $vessel[9];
        //             $ctr++;
        //         }
        //         if($vessels[$vname]->engine == "" && $vessel[8] != ""){
        //             // $array["engine"] = $vessel[8];
        //             $vessels[$vname]->engine = $vessel[8];
        //             $ctr++;
        //         }
        //         if($vessels[$vname]->gross_tonnage == "" && $vessel[3] != ""){
        //             // $array["gross_tonnage"] = $vessel[3];
        //             $vessels[$vname]->gross_tonnage = $vessel[3];
        //             $ctr++;
        //         }
        //         if($vessels[$vname]->trade == "" && $vessel[21] != ""){
        //             // $array["trade"] = $vessel[21];
        //             $vessels[$vname]->trade = $vessel[21];
        //             $ctr++;
        //         }
        //         if($vessels[$vname]->mlc_shipowner == "" && $vessel[64] != ""){
        //             // $array["mlc_shipowner"] = $vessel[64];
        //             $vessels[$vname]->mlc_shipowner = $vessel[64];
        //             $ctr++;
        //         }
        //         if($vessels[$vname]->mlc_shipowner_address == "" && $vessel[65] != ""){
        //             // $array["mlc_shipowner_address"] = $vessel[65];
        //             $vessels[$vname]->mlc_shipowner_address = $vessel[65];
        //             $ctr++;
        //         }
        //         if($vessels[$vname]->former_agency == "" && $vessel[26] != "" && $vessel[26] != "NONE" && $vessel[26] != "SAME"){
        //             // $array["former_agency"] = $vessel[26];
        //             $vessels[$vname]->former_agency = $vessel[26];
        //             $ctr++;
        //         }
        //         if($vessels[$vname]->former_principal == "" && $vessel[27] != "" && $vessel[27] != "NONE" && $vessel[27] != "SAME"){
        //             // $array["former_principal"] = $vessel[27];
        //             $vessels[$vname]->former_principal = $vessel[27];
        //             $ctr++;
        //         }

        //         echo $vessels[$vname]->save();
        //     }
        // }
    }
}
