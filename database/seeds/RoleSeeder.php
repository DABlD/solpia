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
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Cadet']);
        Role::create(['name' => 'Encoder']);
        Role::create(['name' => 'Applicant']);
        Role::create(['name' => 'Principal']);
    }
}
