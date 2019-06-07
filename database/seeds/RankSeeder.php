<?php

use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$ranks = [
    		'Captain', 'Deck officers', 'Chief mate', 'Second mate', 'Third mate', 'Deck cadet', 'Deck ratings', 'Boatswain', 
    		'Able seaman', 'Ordinary seaman', 'Engineering officers', 'Chief engineer', 'Second engineer', 'Third engineer',
    		'Fourth engineer', 'Motorman', 'Oiler', 'Wiper', 'Electro-technical officer', 'Chief steward', 'Chief cook',
    		'Wardroom officer', 'Standing officer', 'Cockpit mate', 'Senior petty officer', 'Petty officer'
    	];

    	foreach($ranks as $rank){
	        Rank::create([
	        	'name' => $rank
	        ]);
    	}
    }
}
