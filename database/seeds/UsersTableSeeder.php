<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\{Applicant, EducationalBackground, FamilyData};

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
            'fname' => 'Admin',
            'mname' => 'admin',
            'lname' => 'Istrator',
            'role' => 'Admin',
            'email' => 'admin@admin.com',
            'birthday' => '1997-11-12',
            'gender' => 'Male',
            'address' => 'Manila, Phillipines',
            'contact' => '09123456789',
            'applicant' => false,
            'email_verified_at' => now()->toDateTimeString(),
            'password' => '123456'
        ]);

        User::create([
        	'fname' => 'App',
            'mname' => 'Lic',
            'lname' => 'Cant',
            'role' => 'Applicant',
            'email' => 'applicant@applicant.com',
            'birthday' => '1997-11-12',
            'gender' => 'Male',
            'address' => 'Manila, Phillipines',
            'contact' => '09789456132',
            'applicant' => true,
            'email_verified_at' => now()->toDateTimeString(),
            'password' => '123456'
        ]);

        Applicant::create([
            'user_id' => 2,
            'birth_place' => 'Somewhere in Phillipines',
            'religion' => 'Catholic',
            'provincial_address' => 'Manila, Phillipines',
            'provincial_contact' => '09123456789',
            'age' => 20,
            'height' => 5.5,
            'weight' => 60,
            'bmi' => 23,
            'blood_type' => 'O',
            'civil_status' => 'Single',
            'tin' => 17238172937,
            'sss' => 128736182736,
            'waistline' => 5.9,
            'shoe_size' => 8,
            'clothes_size' => 'M',
            'eye_color' => 'Black'
        ]);

        EducationalBackground::create([
            'applicant_id' => 1,
            'type' => 'Elementary',
            'course' => null,
            'year' => '2003-2009',
            'school' => 'Some Elementary School',
            'address' => 'Somewhere in Phillipines',
        ]);

        EducationalBackground::create([
            'applicant_id' => 1,
            'type' => 'High School',
            'course' => null,
            'year' => '2009-2013',
            'school' => 'Some High School',
            'address' => 'Somewhere in Phillipines',
        ]);

        EducationalBackground::create([
            'applicant_id' => 1,
            'type' => 'College',
            'course' => 'BSIT',
            'year' => '2013-2019',
            'school' => 'FEU Institute of Technology',
            'address' => 'Sampaloc, Manila',
        ]);

        FamilyData::create([
            'applicant_id' => 1,
            'type' => 'Father',
            'name' => 'Fa Ther Cant',
            'age' =>  40,
            'birthday' => '1997-11-12', 
            'address' => 'Manila, Phillipines',
            'occupation' => 'Seaman',
        ]);

        FamilyData::create([
            'applicant_id' => 1,
            'type' => 'Mother',
            'name' => 'Mo Ther Cant',
            'age' =>  38,
            'birthday' => '1997-11-12', 
            'address' => 'Manila, Phillipines',
            'occupation' => 'Housewife',
        ]);

        FamilyData::create([
            'applicant_id' => 1,
            'type' => 'Brother',
            'name' => 'Bro Ther Cant',
            'age' =>  22,
            'birthday' => '1997-11-12', 
            'address' => 'Manila, Phillipines',
        ]);
    }
}
