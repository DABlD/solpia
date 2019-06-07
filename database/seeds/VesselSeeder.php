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

        Vessel::create([
        	'principal_id'	=> 1,
        	'name'			=> 'M/V AFRICAN ARROW',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2015',
        	'builder'		=> 'IMABARI SHIPBUILDING',
        	'engine'		=> 'MITSUI MAN B&W 6S50ME-B9.3',
        	'gross_tonnage'	=> '34778',
        	'BHP'			=> '11072',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 3,
        	'name'			=> 'M/V AFRICAN LEOPARD',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2016',
        	'builder'		=> '',
        	'engine'		=> 'HITACHI-MAN B&W 6S50ME-B9',
        	'gross_tonnage'	=> '35810',
        	'BHP'			=> '10138',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'FURUNO_FMD 3300',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 3,
        	'name'			=> 'M/V AMIS QUEEN',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2019',
        	'builder'		=> 'IWAGI ZOSEN, JAPAN',
        	'engine'		=> 'MITSUI-MAN B&W 6S50ME-B9.3',
        	'gross_tonnage'	=> '35832',
        	'BHP'			=> '10134',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'FURUNO_FMD 3300',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 9,
        	'name'			=> 'M/V ANCASH QUEEN',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2014',
        	'builder'		=> 'IMABARI SHIPBUILDING',
        	'engine'		=> 'MITSUI MAN B&W 6S50ME-C8.2',
        	'gross_tonnage'	=> '30657',
        	'BHP'			=> '10241',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-701B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 9,
        	'name'			=> 'M/V ATLANTIC BUENAVISTA',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2019',
        	'builder'		=> 'OSHIMA SHIPBUILDING',
        	'engine'		=> 'KAWASAKI MAN B&W 5S50ME-C8.5',
        	'gross_tonnage'	=> '22669',
        	'BHP'			=> '7576',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-9201',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 9,
        	'name'			=> 'M/V ATLANTIC OASIS',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2011',
        	'builder'		=> 'SHIN KURUSHIMA',
        	'engine'		=> 'MITSUBISHI 6UEC45LSE',
        	'gross_tonnage'	=> '21290',
        	'BHP'			=> '8498',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 10,
        	'name'			=> 'M/V AUTO BANNER',
        	'flag'			=> 'MARSHALL ISLANDS',
        	'type'			=> 'CAR CARRIER',
        	'year_build'	=> '',
        	'builder'		=> '',
        	'engine'		=> '',
        	'gross_tonnage'	=> '',
        	'BHP'			=> '',
        	'trade'			=> '',
        	'ecdis'			=> '',
        	'status'		=> 'INACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 3,
        	'name'			=> 'M/V BERGE SNOWDON',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'LOG BULK',
        	'year_build'	=> '2015',
        	'builder'		=> 'SHIMANAMI SHIPBUILDING',
        	'engine'		=> 'MAKITA MITSUI MAN B&W 6S46ME-B8.3',
        	'gross_tonnage'	=> '23281',
        	'BHP'			=> '9142',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-9201',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 10,
        	'name'			=> 'M/V BORYEONG',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '1993',
        	'builder'		=> '',
        	'engine'		=> 'KAWASAKI MAN B&W 5L80MC-E',
        	'gross_tonnage'	=> '77372',
        	'BHP'			=> '16900',
        	'trade'			=> 'AUS-KOR',
        	'ecdis'			=> '',
        	'status'		=> 'INACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 7,
        	'name'			=> 'M/V BRILLIANT JOURNEY',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2012',
        	'builder'		=> '',
        	'engine'		=> 'HITACHI MAN B&W 6S50MC-C',
        	'gross_tonnage'	=> '34974',
        	'BHP'			=> '11488',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-9201',
        	'status'		=> 'INACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 3,
        	'name'			=> 'M/V CLIPPER IWAGI',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'LOG BULK',
        	'year_build'	=> '2010',
        	'builder'		=> 'SHIMANAMI SHIPBUILDING',
        	'engine'		=> 'MAKITA-MITSUI-MAN B&W 6S42MC',
        	'gross_tonnage'	=> '17009',
        	'BHP'			=> '7844',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-9201',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 7,
        	'name'			=> 'M/V CLIPPER KAMOSHIO',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2009',
        	'builder'		=> '',
        	'engine'		=> 'MITSUBISHI 6UEC52LA',
        	'gross_tonnage'	=> '20236',
        	'BHP'			=> '8878',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-701B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 4,
        	'name'			=> 'M/V CMB CHARDONNAY',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2012',
        	'builder'		=> '',
        	'engine'		=> 'MITSUI MAN B&W 6S50MC-C',
        	'gross_tonnage'	=> '50626',
        	'BHP'			=> '17359',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-701B',
        	'status'		=> 'INACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 2,
        	'name'			=> 'M/V DAEBO GLADSTONE',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2013',
        	'builder'		=> '',
        	'engine'		=> 'HYUNDAI MAN B&W 7S50MC-C8',
        	'gross_tonnage'	=> '44102',
        	'BHP'			=> '12802',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 2,
        	'name'			=> 'M/V DAEBO NEWCASTLE',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2011',
        	'builder'		=> '',
        	'engine'		=> 'HYUNDAI MAN B&W 7S50MC-C8',
        	'gross_tonnage'	=> '44102',
        	'BHP'			=> '13539',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'INACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 8,
        	'name'			=> 'M/V DK INITIO',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2010',
        	'builder'		=> '',
        	'engine'		=> 'STX MAN B&W 6S50MC-MK8',
        	'gross_tonnage'	=> '32600',
        	'BHP'			=> '13542',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'FURUNO FEA-2107',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 8,
        	'name'			=> 'M/V DK IONE',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2010',
        	'builder'		=> '',
        	'engine'		=> 'STX MAN B&W 6S50MC-C',
        	'gross_tonnage'	=> '34349',
        	'BHP'			=> '13351',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'FURUNO FEA-2107',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 1,
        	'name'			=> 'M/V DOUBLE PROSPERITY',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2005',
        	'builder'		=> '',
        	'engine'		=> 'MITSUI MAN B&W 6S60MC',
        	'gross_tonnage'	=> '39727',
        	'BHP'			=> '14031',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'INACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 1,
        	'name'			=> 'M/V FAIR OCEAN',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2013',
        	'builder'		=> 'SHIN KURISHIMA',
        	'engine'		=> 'KOBE DIESEL MITSUBISHI 6UEC45LSE-1',
        	'gross_tonnage'	=> '21220',
        	'BHP'			=> '8042',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 3,
        	'name'			=> 'M/V FEDERAL IMABARI',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2016',
        	'builder'		=> 'IMABARI SHIPBUILDING',
        	'engine'		=> 'HITATCHI MAN B&W 6S50ME-B9.3',
        	'gross_tonnage'	=> '35832',
        	'BHP'			=> '10134',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'FURUNO FMD-3300',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 5,
        	'name'			=> 'M/V GNS HARMONY',
        	'flag'			=> 'MARSHALL ISLANDS',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2001',
        	'builder'		=> 'SASEBO HEAVY INDUSTRIES',
        	'engine'		=> 'MITSUI MAN B&W 5S60MC6',
        	'gross_tonnage'	=> '43462',
        	'BHP'			=> '13206',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'TRANSAS NAVI SAILOR 4000',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 5,
        	'name'			=> 'M/V GNS HOPE',
        	'flag'			=> 'KOREA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '1994',
        	'builder'		=> 'SASEBO HEAVY INDUSTRIES',
        	'engine'		=> 'MITSUI MAN B&W 5S60MC',
        	'gross_tonnage'	=> '36074',
        	'BHP'			=> '10379',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'TRANSAS NAVI SAILOR 4000',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 1,
        	'name'			=> 'M/V GRACE OCEAN',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2013',
        	'builder'		=> 'SHIN KURISHIMA',
        	'engine'		=> 'KOBE-MITSUBISHI 6UEC45LSE-1',
        	'gross_tonnage'	=> '21220',
        	'BHP'			=> '8042',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 3,
        	'name'			=> 'M/V HAPPINESS FRONTIER',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2011',
        	'builder'		=> 'IMABARI SHIPBUILDING',
        	'engine'		=> 'MAKITA-MITSUI BANDW6S42',
        	'gross_tonnage'	=> '17019',
        	'BHP'			=> '7844',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC-JAN-901-B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 12,
        	'name'			=> 'M/V HL ATLAS',
        	'flag'			=> 'KOREA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '1994',
        	'builder'		=> '',
        	'engine'		=> 'HYUNDAI MAN B&W 7S50MC',
        	'gross_tonnage'	=> '76068',
        	'BHP'			=> '14000',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 11,
        	'name'			=> 'M/V HL PIONEER',
        	'flag'			=> 'PANAMA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '2015',
        	'builder'		=> '',
        	'engine'		=> 'DALIAN MAN B&W 6G70ME-C9.2(Tier II)',
        	'gross_tonnage'	=> '94879',
        	'BHP'			=> '20590',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'JRC JAN-901B',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 2,
        	'name'			=> 'M/V HL POWER',
        	'flag'			=> 'KOREA',
        	'type'			=> 'BULK CARRIER',
        	'year_build'	=> '1997',
        	'builder'		=> '',
        	'engine'		=> 'HYUNDAI MAN B&W 5S70MC',
        	'gross_tonnage'	=> '76068',
        	'BHP'			=> '17600',
        	'trade'			=> 'W.W',
        	'ecdis'			=> 'MECYS PM3D',
        	'status'		=> 'ACTIVE'
        ]);

        Vessel::create([
        	'principal_id'	=> 1,
        	'name'			=> '',
        	'flag'			=> 'PANAMA',
        	'type'			=> '',
        	'year_build'	=> '2017',
        	'builder'		=> '',
        	'engine'		=> '',
        	'gross_tonnage'	=> '29770',
        	'BHP'			=> '9732',
        	'trade'			=> 'W.W',
        	'ecdis'			=> '',
        	'status'		=> 'ACTIVE'
        ]);
    }
}
