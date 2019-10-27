<?php

use Illuminate\Database\Seeder;
use App\Models\{Vessel, Rank, Wage};

class WageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$array = [
    		[
    			'rank' 			=> 'MSTR',
    			'basic'	 		=> '2395',
    			'leave_pay'		=> '719',
    			'fot' 			=> '1783',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '80',
    			'sup_allow'	 	=> '3435',
    			'ot' 			=> '0',
    		],
    		[
    			'rank' 			=> 'C/O',
    			'basic'	 		=> '1671',
    			'leave_pay'		=> '502',
    			'fot' 			=> '1244',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '80',
    			'sup_allow'	 	=> '2885',
    			'ot' 			=> '0',
    		],
    		[
    			'rank' 			=> '2/O',
    			'basic'	 		=> '1090',
    			'leave_pay'		=> '327',
    			'fot' 			=> '812',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '80',
    			'sup_allow'	 	=> '983',
    			'ot' 			=> '0',
    		],
    		[
    			'rank' 			=> '3/O',
    			'basic'	 		=> '972',
    			'leave_pay'		=> '292',
    			'fot' 			=> '724',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '80',
    			'sup_allow'	 	=> '524',
    			'ot' 			=> '0',
    		],
    		[
    			'rank' 			=> 'C/E',
    			'basic'	 		=> '2266',
    			'leave_pay'		=> '680',
    			'fot' 			=> '1687',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '80',
    			'sup_allow'	 	=> '3354',
    			'ot' 			=> '0',
    		],
    		[
    			'rank' 			=> '1AE',
    			'basic'	 		=> '1671',
    			'leave_pay'		=> '502',
    			'fot' 			=> '1244',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '80',
    			'sup_allow'	 	=> '2885',
    			'ot' 			=> '0',
    		],
    		[
    			'rank' 			=> '2AE',
    			'basic'	 		=> '1090',
    			'leave_pay'		=> '327',
    			'fot' 			=> '812',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '80',
    			'sup_allow'	 	=> '983',
    			'ot' 			=> '0',
    		],
    		[
    			'rank' 			=> '3AE',
    			'basic'	 		=> '972',
    			'leave_pay'		=> '292',
    			'fot' 			=> '724',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '80',
    			'sup_allow'	 	=> '524',
    			'ot' 			=> '0',
    		],
    		[
    			'rank' 			=> 'BSN',
    			'basic'	 		=> '702',
    			'leave_pay'		=> '216',
    			'fot' 			=> '523',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '50',
    			'sup_allow'	 	=> '0',
    			'ot' 			=> '5.07',
    		],
    		[
    			'rank' 			=> 'AB',
    			'basic'	 		=> '641',
    			'leave_pay'		=> '193',
    			'fot' 			=> '477',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '50',
    			'sup_allow'	 	=> '0',
    			'ot' 			=> '4.63',
    		],
    		[
    			'rank' 			=> 'OS',
    			'basic'	 		=> '478',
    			'leave_pay'		=> '144',
    			'fot' 			=> '356',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '50',
    			'sup_allow'	 	=> '0',
    			'ot' 			=> '3.45',
    		],
    		[
    			'rank' 			=> 'DCDT',
    			'basic'	 		=> '300',
    		],
    		[
    			'rank' 			=> 'OLR1',
    			'basic'	 		=> '702',
    			'leave_pay'		=> '216',
    			'fot' 			=> '523',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '50',
    			'sup_allow'	 	=> '0',
    			'ot' 			=> '5.07',
    		],
    		[
    			'rank' 			=> 'OLR',
    			'basic'	 		=> '641',
    			'leave_pay'		=> '193',
    			'fot' 			=> '477',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '50',
    			'sup_allow'	 	=> '0',
    			'ot' 			=> '4.63',
    		],
    		[
    			'rank' 			=> 'WPR',
    			'basic'	 		=> '478',
    			'leave_pay'		=> '144',
    			'fot' 			=> '356',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '50',
    			'sup_allow'	 	=> '0',
    			'ot' 			=> '3.45',
    		],
    		[
    			'rank' 			=> 'ECDT',
    			'basic'	 		=> '300',
    		],
    		[
    			'rank' 			=> 'CCK',
    			'basic'	 		=> '702',
    			'leave_pay'		=> '216',
    			'fot' 			=> '523',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '50',
    			'sup_allow'	 	=> '0',
    			'ot' 			=> '5.07',
    		],
    		[
    			'rank' 			=> 'MSM',
    			'basic'	 		=> '478',
    			'leave_pay'		=> '144',
    			'fot' 			=> '356',
    			'sub_allow'	 	=> '68',
    			'retire_allow' 	=> '50',
    			'sup_allow'	 	=> '0',
    			'ot' 			=> '3.45',
    		],
    	];

        foreach($array as $arr){
        	Wage::create([
        		'rank_id'		=> Rank::where('abbr', $arr['rank'])->first()->id,
        		'principal_id'	=> 9,
        		'currency'		=> 'DOLLAR',
        		'basic'			=> $arr['basic'] ?? '0',
        		'leave_pay'		=> $arr['leave_pay'] ?? '0',
        		'fot'			=> $arr['fot'] ?? '0',
        		'ot'			=> $arr['ot'] ?? '0',
        		'sub_allow'		=> $arr['sub_allow'] ?? '0',
        		'retire_allow'	=> $arr['retire_allow'] ?? '0',
        		'sup_allow'		=> $arr['sup_allow'] ?? '0',
        	]);
        }
    }
}
