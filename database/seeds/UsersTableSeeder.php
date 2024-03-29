<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\{Applicant, EducationalBackground, FamilyData, Principal, DocumentId};
use App\Models\{Ssap, ProcessedApplicant};

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
            'username' => 'admin',
            'role' => 'Admin',
            'email' => 'admin@admin.com',
            'birthday' => '1997-11-12',
            'gender' => 'Male',
            'address' => 'Manila, Phillipines',
            'contact' => '09123456789',
            'applicant' => false,
            'email_verified_at' => now()->toDateTimeString(),
            'status' => 1,
            'password' => '123456'
        ]);

        Ssap::create(["token" => strrev('123456')]);

        // User::create([
        // 	'fname' => 'App',
        //     'mname' => 'Lic',
        //     'lname' => 'Cant',
        //     'role' => 'Applicant',
        //     'email' => 'applicant@applicant.com',
        //     'birthday' => '1997-11-12',
        //     'gender' => 'Male',
        //     'address' => 'Manila, Phillipines',
        //     'contact' => '09789456132',
        //     'applicant' => true,
        //     'email_verified_at' => now()->toDateTimeString(),
        //     'password' => '123456'
        // ]);

        // Ssap::create(["token" => strrev('123456')]);

        $principals = [
            'SHINKO', 'KOSCO', 'TOEI', 'SMTECH', 'SC MARINE',
            'IMSCO', 'SEYEONG', 'HANJOO', 'WESTERN', 'KLCSM', 
            'H-LINE', 'DINTEC', 'HMM', 'NAUTICA'
        ];

        foreach($principals as $name){
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

            Ssap::create(["token" => strrev('123456')]);
        }

        // Applicant::create([
        //     'user_id' => 2,
        //     'birth_place' => 'Somewhere in Phillipines',
        //     'religion' => 'Catholic',
        //     'provincial_address' => 'Manila, Phillipines',
        //     'provincial_contact' => '09123456789',
        //     'age' => 20,
        //     'height' => 5.5,
        //     'weight' => 60,
        //     'bmi' => 23,
        //     'blood_type' => 'O',
        //     'civil_status' => 'Single',
        //     'tin' => 17238172937,
        //     'sss' => 128736182736,
        //     'waistline' => 5.9,
        //     'shoe_size' => 8,
        //     'clothes_size' => 'M',
        //     'eye_color' => 'Black'
        // ]);

        // EducationalBackground::create([
        //     'applicant_id' => 1,
        //     'type' => 'Elementary',
        //     'course' => null,
        //     'year' => '2003-2009',
        //     'school' => 'Some Elementary School',
        //     'address' => 'Somewhere in Phillipines',
        // ]);

        // EducationalBackground::create([
        //     'applicant_id' => 1,
        //     'type' => 'High School',
        //     'course' => null,
        //     'year' => '2009-2013',
        //     'school' => 'Some High School',
        //     'address' => 'Somewhere in Phillipines',
        // ]);

        // EducationalBackground::create([
        //     'applicant_id' => 1,
        //     'type' => 'College',
        //     'course' => 'BSIT',
        //     'year' => '2013-2019',
        //     'school' => 'FEU Institute of Technology',
        //     'address' => 'Sampaloc, Manila',
        // ]);

        // FamilyData::create([
        //     'applicant_id' => 1,
        //     'type' => 'Father',
        //     'fname' => 'Fa',
        //     'mname' => 'Ther',
        //     'lname' => 'Cant',
        //     'age' =>  40,
        //     'birthday' => '1997-11-12', 
        //     'address' => 'Manila, Phillipines',
        //     'occupation' => 'Seaman',
        // ]);

        // FamilyData::create([
        //     'applicant_id' => 1,
        //     'type' => 'Mother',
        //     'fname' => 'Mo',
        //     'mname' => 'Ther',
        //     'lname' => 'Cant',
        //     'age' =>  38,
        //     'birthday' => '1997-11-12', 
        //     'address' => 'Manila, Phillipines',
        //     'occupation' => 'Housewife',
        // ]);

        // FamilyData::create([
        //     'applicant_id' => 1,
        //     'type' => 'Brother',
        //     'name' => 'Bro Ther Cant',
        //     'age' =>  22,
        //     'birthday' => '1997-11-12', 
        //     'address' => 'Manila, Phillipines',
        // ]);

        // DocumentId::create([
        //     'applicant_id' => 1,
        //     'type' => 'PASSPORT',
        //     'issuer' => 'DFA',
        //     'number' => '123456',
        //     'issue_date' => now()->startOfMonth(),
        //     'expiry_date' => now()->endOfMonth(),
        // ]);

        // DocumentId::create([
        //     'applicant_id' => 1,
        //     'type' => "SEAMAN'S BOOK",
        //     'issuer' => 'MARINA',
        //     'number' => '654321',
        //     'issue_date' => now()->startOfMonth(),
        //     'expiry_date' => now()->endOfMonth(),
        // ]);

        // DocumentId::create([
        //     'applicant_id' => 1,
        //     'type' => 'US-VISA',
        //     'issuer' => 'US EMBASSY',
        //     'number' => '756159',
        //     'issue_date' => now()->startOfMonth(),
        //     'expiry_date' => now()->endOfMonth(),
        // ]);

        // ProcessedApplicant::create([
        //     'applicant_id' => 1,
        //     'status' => 'Vacation'
        // ]);
    }
}
