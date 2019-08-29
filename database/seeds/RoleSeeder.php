<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::create(['name' => 'Admin']);
        // Role::create(['name' => 'Cadet']);
        // Role::create(['name' => 'Encoder']);
        // Role::create(['name' => 'Applicant']);
        // Role::create(['name' => 'Principal']);
        // Role::create(['name' => 'Crewing Manager']);
        // Role::create(['name' => 'Crewing Officer']);
        // Role::create(['name' => 'Processing']);
        $roles = [
            'Admin',
            'Cadet',
            'Encoder',
            'Applicant',
            'Principal',
            'Crewing Manager',
            'Crewing Officer',
            'Processing'
        ];

        foreach($roles as $role){
            if(!Role::where("name", $role)->count()){
                Role::create(["name" => $role]);
            }
        }
    }
}
