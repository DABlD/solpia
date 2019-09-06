<?php

use Illuminate\Database\Seeder;
use App\Models\{Vessel, Principal, SeaService};
use App\User;

class FillVessel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vessels = SeaService::all();
        foreach($vessels as $data){
        	if(Vessel::where('name', $data->vessel_name)->count() == 0){
        	    $principal = Principal::where('name', $data->principal)->get();
        	    if($principal->count()){
        	        Vessel::create([
        	            'principal_id'  => $principal->first()->id,
        	            'manning_agent' => $data->manning_agent,
        	            'name'          => $data->vessel_name,
        	            'flag'          => $data->flag,
        	            'type'          => $data->vessel_type,
        	            'engine'        => $data->engine_type,
        	            'gross_tonnage' => $data->gross_tonnage,
        	            'BHP'           => $data->bhp_kw,
        	            'trade'         => $data->trade,
        	        ]);
        	    }
        	    else{
        	        $name = $data->principal;

        	        $user = new User();
        	        $user->fname = $name;
        	        $user->username = strtolower(camel_case($name));
        	        $user->role = 'Principal';
        	        $user->applicant = false;
        	        $user->email = camel_case(strtolower($name)) . '@solpia.email';
        	        $user->email_verified_at = now()->toDateTimeString();
        	        $user->password = '123456';

        	        $user->mname = "";
        	        $user->lname = "";
        	        $user->birthday = now();
        	        $user->gender = "";
        	        $user->address = "";
        	        $user->contact = "";

        	        $user->save();

        	        $principal = new Principal();
        	        $principal->user_id = $user->id;
        	        $principal->name = $name;
        	        $principal->slug = camel_case(strtolower($name));
        	        $principal->save();

        	        Vessel::create([
        	            'principal_id'  => $principal->id,
        	            'manning_agent' => $data->manning_agent,
        	            'name'          => $data->vessel_name,
        	            'flag'          => $data->flag,
        	            'type'          => $data->vessel_type,
        	            'engine'        => $data->engine_type,
        	            'gross_tonnage' => $data->gross_tonnage,
        	            'BHP'           => $data->bhp_kw,
        	            'trade'         => $data->trade,
        	        ]);
        	    }
        	}
        }
    }
}
