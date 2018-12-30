<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'fname' => 'David',
            'mname' => 'Roga',
            'lname' => 'Mendoza',
            'role' => 'Admin',
            'email' => 'davidmendozaofficial@gmail.com',
            'birthday' => '1997-11-12',
            'gender' => 'Male',
            'address' => 'Rm. 628, Park Avenue Mansions, Park Avenue St.,, Barangay 81',
            'contact' => '09154590172',
            'email_verified_at' => now()->toDateTimeString(),
            'password' => '$2y$10$c.B00sqGwH6Vg3ymlGb1LuIHnIXPq9T4CsBhu5jxbGEmiPU82eqSy'
        ]);
    }
}
