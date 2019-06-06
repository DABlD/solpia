<?php

use Illuminate\Database\Seeder;
use App\Models\Vessel;

class VesselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vessel::create([
        	'principal_id'	=> 10,
        	'name'			=> 'M/T SM FALCON',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'OIL/CHEM',
        	'year_build'	=> '2017',
        	'builder'		=> '',
        	'engine'		=> 'WARTSILA 6RT-FLEX50-D (TIER II)',
        	'gross_tonnage'	=> '29770',
        	'BHP'			=> '9732',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 10,
        	'name'			=> 'M/T SM NAVIGATOR',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'PROD. TANKER',
        	'year_build'	=> '2008',
        	'builder'		=> '',
        	'engine'		=> 'HYUNDAI MAN B&W 6S50MC-C',
        	'gross_tonnage'	=> '30964',
        	'BHP'			=> '12900',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'MECYS PM3D',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 10,
        	'name'			=> 'M/T SM OSPREY',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'OIL/CHEM',
        	'year_build'	=> '2017',
        	'builder'		=> '',
        	'engine'		=> 'WARTSILA 6RT-FLEX50-D (TIER II)',
        	'gross_tonnage'	=> '29770',
        	'BHP'			=> '9732',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'ACTIVE'
        ]);
    }
}
