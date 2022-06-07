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
            [
                'MASTER',
                'MSTR',
                'DECK OFFICER',
                'OFFICER'
            ],
            [
                'CHIEF OFFICER',
                'C/O',
                'DECK OFFICER',
                'OFFICER'
            ],
            [
                '2ND OFFICER',
                '2/O',
                'DECK OFFICER',
                'OFFICER'
            ],
            [
                '3RD OFFICER',
                '3/O',
                'DECK OFFICER',
                'OFFICER'
            ],
            [
                'CHIEF ENGINEER',
                'C/E',
                'ENGINE OFFICER',
                'OFFICER'
            ],
            [
                '1ST ASST. ENGR',
                '1AE',
                'ENGINE OFFICER',
                'OFFICER'
            ],
            [
                '2ND ASST. ENGR',
                '2AE',
                'ENGINE OFFICER',
                'OFFICER'
            ],
            [
                '3RD ASST. ENGR',
                '3AE',
                'ENGINE OFFICER',
                'OFFICER'
            ],
            [
                'BOSUN',
                'BSN',
                'DECK RATING',
                'RATING'
            ],
            [
                'ABLE SEAMAN',
                'AB',
                'DECK RATING',
                'RATING'
            ],
            [
                'ORDINARY SEAMAN',
                'OS',
                'DECK RATING',
                'RATING'
            ],
            [
                'GP2-OS',
                'GP-OS',
                'DECK RATING',
                'RATING'
            ],
            [
                'APPRENTICE OFFICER',
                'A/O',
                'DECK RATING',
                'RATING'
            ],
            [
                'DECK CADET',
                'DCDT',
                'DECK RATING',
                'RATING'
            ],
            [
                'OLR NO. 1',
                'OLR1',
                'ENGINE RATING',
                'RATING'
            ],
            [
                'OILER',
                'OLR ',
                'ENGINE RATING',
                'RATING'
            ],
            [
                'WIPER',
                'WPR',
                'ENGINE RATING',
                'RATING'
            ],
            [
                'APPRENTICE OFFICER',
                'A/E',
                'ENGINE RATING',
                'RATING'
            ],
            [
                'ENGINE CADET',
                'ECDT',
                'ENGINE RATING',
                'RATING'
            ],
            [
                'GP2-WELDER',
                'GP-WLDR',
                'ENGINE RATING',
                'RATING'
            ],
            [
                'FITTER',
                'FTR',
                'ENGINE RATING',
                'RATING'
            ],
            [
                'ETO',
                'ETO',
                'ENGINE RATING',
                'RATING'
            ],
            [
                'TRAINEE ELECT',
                'T/ELECT',
                'ENGINE RATING',
                'RATING'
            ],
            [
                'CHIEF COOK',
                'CCK',
                'GALLEY',
                'RATING'
            ],
            [
                'COOK',
                'COOK',
                'GALLEY',
                'RATING'
            ],
            [
                '2ND COOK',
                '2CK',
                'GALLEY',
                'RATING'
            ],
            [
                'MESSMAN',
                'MSM',
                'GALLEY',
                'RATING'
            ],
            [
                'MESSBOY',
                'MBY',
                'GALLEY',
                'RATING'
            ],
            [
                'UTILITY',
                'UTY',
                'GALLEY',
                'RATING'
            ],
    	];

    	foreach($ranks as $rank){
	        Rank::create([
	        	'name' => $rank[0],
                'abbr' => $rank[1],
                'category' => $rank[2],
                'type' => $rank[3]
	        ]);
    	}
    }
}
