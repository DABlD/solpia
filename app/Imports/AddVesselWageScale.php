<?php

namespace App\Imports;

use App\Models\{Vessel, Wage, Rank};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{ToCollection, WithHeadingRow};

class AddVesselWageScale implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $temp = Vessel::where('status', 'active')->get();
        $vessels = [];

        foreach($temp as $vessel){
            $name = str_replace("/", "", $vessel->name);
            $vessels[$name] = $vessel;
        }

        $ranks = Rank::all()->groupBy('importName');
        $temp2 = array_keys($vessels);

        $rows = $rows->groupBy('vessel');

        foreach($rows as $key => $vwage){
            // CHECK IF VESSEL IS ACTIVE IN CMS
            if(in_array($key, $temp2)){
                // GET WAGE;
                $wages = Wage::where('vessel_id', $vessels[$key]->id)->get()->groupBy('rank_id');

                foreach($vwage as $wage){
                    $position = trim($wage['position']);

                    if(isset($ranks[$this->getPosition($position)])){
                        $rank = $ranks[$this->getPosition($position)]->first();
                    }
                    else{
                        continue;
                    }

                    if(sizeof($rank)){
                        // IF WAGE EXIST FOR THAT RANK
                        if(isset($wages[$rank->id])){
                            // UPDATE VALUES
                            $temp = $wages[$rank->id]->first();
                            // if($temp->ot_per_hour == ""){
                            if($temp->ot_per_hour == ""){
                                $oph = ($wage['got'] != "" && $wage['got'] != 0) ? $wage['got'] / 103 : null;
                                if($oph){
                                    // $temp = round($oph * 2) / 2;
                                    // echo $oph . ' - ' . $temp . '<br>';
                                    // $temp->ot_per_hour = $oph;
                                }
                            }
                            if($wage['leave_pay_calculation_month'] != ""){
                                $temp->leave_per_month = preg_replace("/[^0-9\.]/", '', $wage['leave_pay_calculation_month']);
                            }

                            $temp->save();
                        }
                        // CREATE ENTRY
                        else{
                            $temp = new Wage();
                            $temp->rank_id = $rank->id;
                            $temp->vessel_id = $vessels[$key]->id;
                            $temp->principal_id = $vessels[$key]->principal_id;
                            $temp->basic = is_numeric($wage["basic"]) ? $wage["basic"] : null;
                            $temp->leave_pay = is_numeric($wage["lp"]) ? $wage["lp"] : null;
                            $temp->fot = is_numeric($wage["fot"]) ? $wage["fot"] : null;
                            $temp->ot = is_numeric($wage["got"]) ? $wage["got"] : null;
                            $temp->sub_allow = is_numeric($wage["sub_allow"]) ? $wage["sub_allow"] : null;
                            $temp->retire_allow = is_numeric($wage["retire_allow"]) ? $wage["retire_allow"] : null;
                            $temp->sup_allow = is_numeric($wage["sup_allow"]) ? $wage["sup_allow"] : null;
                            $temp->aca = is_numeric($wage["aca"]) ? $wage["aca"] : null;
                            $temp->other_allow = is_numeric($wage["other_allow"]) ? $wage["other_allow"] : null;
                            $temp->engine_allow = is_numeric($wage["engine_allow"]) ? $wage["engine_allow"] : null;
                            $temp->voyage_allow = is_numeric($wage["voyage_allow"]) ? $wage["voyage_allow"] : null;
                            $temp->owner_allow = is_numeric($wage["owner_allow"]) ? $wage["owner_allow"] : null;
                            $temp->tanker_allow = is_numeric($wage["tanker_allow"]) ? $wage["tanker_allow"] : null;
                            $temp->total = ($temp->basic ?? 0) + ($temp->leave_pay ?? 0) + ($temp->fot ?? 0) + ($temp->ot ?? 0) + ($temp->sub_allow ?? 0) + ($temp->retire_allow ?? 0) + ($temp->sup_allow ?? 0) + ($temp->aca ?? 0) + ($temp->other_allow ?? 0) + ($temp->engine_allow ?? 0) + ($temp->voyage_allow ?? 0) + ($temp->owner_allow ?? 0) + ($temp->tanker_allow ?? 0);

                            $oph = ($wage['got'] != "" && $wage['got'] != 0) ? $wage['got'] / 103 : null;
                            if($oph){
                                $temp->ot_per_hour = round($oph * 2) / 2;
                            }

                            if($wage['leave_pay_calculation_month'] != ""){
                                $temp->leave_per_month = preg_replace("/[^0-9\.]/", '', $wage['leave_pay_calculation_month']);
                            }

                            $temp->save();
                        }
                    }
                }
            }
        }

        // die;
    }

    private function getPosition($name){
        if($name == "TRAINEE ELECTRICIAN" || $name == "ELECTRICIAN TRAINEE"){
            $name = "TRAINEE ELECTRICIAN";
        }
        elseif($name == "TRAINEE REEFERMAN" || $name == "REEFERMAN TRAINEE" || $name == "TRAINEE REFFERMAN"){
            $name = "TRAINEE REEFERMAN";
        }
        elseif($name == "REEFERMAN" || $name == "REFFERMAN"){
            $name = "REEFERMAN";
        }
        elseif($name == "DECK BOY" || $name == "DECKBOY"){
            $name = "DECK BOY";
        }
        elseif($name == "DECK HAND" || $name == "DECKHAND"){
            $name = "DECK HAND";
        }
        elseif($name == "ELECTRICIAN" || $name == "ELECTRCIAN"){
            $name = "ELECTRICIAN";
        }

        return $name;
    }
}

// TRIM ALL RANKS FIRST
//TRAINEE ELECTRICIAN / ELECTRICIAN TRAINEE
//TRAINEE REEFERMAN / REEFERMAN TRAINEE / TRAINEE REFFERMAN
//REEFERMAN / REFFERMAN
// DECK BOY / DECKBOY
// DECK HAND / DECKHAND