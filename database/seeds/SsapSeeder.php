<?php

use Illuminate\Database\Seeder;
use App\Models\{Ssap};
use App\User;

class SsapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('applicant', 0)->get();

        foreach($users as $user){
        	Ssap::create(['user_id' => $user->id]);
        }
    }
}
