<?php

namespace App\Imports;

use App\Models\{Vessel, Wage, Rank};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{ToCollection, WithHeadingRow};

class AddVesselWageScale implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $ranks = Rank::all();
        foreach($ranks as $rank){
            $rank->importName = $rank->name;
            $rank->save();
        }

        

        // $temp = Vessel::where('status', 'active')->get();
        // $vessels = [];

        // foreach($temp as $vessel){
        //     $name = str_replace("/", "", $vessel->name);
        //     $vessels[$name] = $vessel;
        // }

        // $names = $rows->unique('vessel')->pluck('vessel')->toArray();
        // $temp2 = array_keys($vessels);

        // $match = [];
        // $nomatch = [];

        // foreach($temp2 as $name){
        //     if(in_array($name, $names)){
        //         array_push($match, $name);
        //     }
        //     else{
        //         array_push($nomatch, $name);
        //     }
        // }

        // dd('match', $match, 'nomatch', $nomatch, $temp2);
        // $ranks = Rank::all()->groupBy('name');

        // foreach($rows as $row){
        // }
    }
}

// foreach($names as $name){
//     $name = trim($name);

//     if($name == "TRAINEE ELECTRICIAN" || $name == "ELECTRICIAN TRAINEE"){
//         $name = "TRAINEE ELECTRICIAN";
//     }
//     elseif($name == "TRAINEE REEFERMAN" || $name == "REEFERMAN TRAINEE" || $name == "TRAINEE REFFERMAN"){
//         $name = "TRAINEE REEFERMAN";
//     }
//     elseif($name == "REEFERMAN" || $name == "REFFERMAN"){
//         $name = "REEFERMAN";
//     }
//     elseif($name == "DECK BOY" || $name == "DECKBOY"){
//         $name = "DECK BOY";
//     }
//     elseif($name == "DECK HAND" || $name == "DECKHAND"){
//         $name = "DECK HAND";
//     }
//     elseif($name == "ELECTRICIAN" || $name == "ELECTRCIAN"){
//         $name = "ELECTRICIAN";
//     }
// }

// TRIM ALL RANKS FIRST
//TRAINEE ELECTRICIAN / ELECTRICIAN TRAINEE
//TRAINEE REEFERMAN / REEFERMAN TRAINEE / TRAINEE REFFERMAN
//REEFERMAN / REFFERMAN
// DECK BOY / DECKBOY
// DECK HAND / DECKHAND