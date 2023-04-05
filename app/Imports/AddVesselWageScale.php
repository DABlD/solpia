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

        // dd($rows->first());
        $names = $rows->unique('position')->pluck('position')->toArray();
        $ranks = Rank::all()->pluck('name')->toArray();
        
        $match = [];
        $nomatch = [];

        foreach($names as $name){
            $name = trim($name);

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

            if(in_array($name, $ranks)){
                array_push($match, $name);
            }
            else{
                array_push($nomatch, $name);
            }
        }

        dd('match', $match, 'no match', $nomatch, '----', $ranks);
    }
}

// TRIM ALL RANKS FIRST
//TRAINEE ELECTRICIAN / ELECTRICIAN TRAINEE
//TRAINEE REEFERMAN / REEFERMAN TRAINEE / TRAINEE REFFERMAN
//REEFERMAN / REFFERMAN
// DECK BOY / DECKBOY
// DECK HAND / DECKHAND