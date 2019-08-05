<?php

namespace App\Imports;

use App\User;
use App\Models\{Vessel, Principal};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class VesselsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $data)
    {
        $size = sizeof($data);
        $principals = Principal::pluck('name')->toArray();

        for($i = 2; $i < $size; $i++)
        {
            $name = strtoupper(trim($data[$i][1]));

            // IF PRINCIPAL EXISTS AND VESSEL NAME HAS NO MATCH YET IN DATABASE
            if(in_array($name, $principals)){
                if(Vessel::where('name', $data[$i][2])->count() == 0){
                    $id = Principal::where('name', $name)->first()->id;
                    
                    Vessel::create([
                        'principal_id'  => $id,
                        'name'          => $data[$i][2],
                        'flag'          => $data[$i][3],
                        'type'          => $data[$i][4],
                        'year_build'    => $data[$i][5],
                        'builder'       => $data[$i][6],
                        'engine'        => $data[$i][7],
                        'gross_tonnage' => $data[$i][8],
                        'BHP'           => $data[$i][10],
                        'trade'         => $data[$i][11],
                        'ecdis'         => $data[$i][12],
                        'status'        => $data[$i][13],
                        'manning_agent' => "SOLPIA",
                    ]);
                }
            }
            else{ // IF PRINCIPAL NOT EXIST. CREATE PRINCIPAL THEN ADD VESSEL
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
                    'name'          => $data[$i][2],
                    'flag'          => $data[$i][3],
                    'type'          => $data[$i][4],
                    'year_build'    => $data[$i][5],
                    'builder'       => $data[$i][6],
                    'engine'        => $data[$i][7],
                    'gross_tonnage' => $data[$i][8],
                    'BHP'           => $data[$i][10],
                    'trade'         => $data[$i][11],
                    'ecdis'         => $data[$i][12],
                    'status'        => $data[$i][13],
                    'manning_agent' => "SOLPIA",
                ]);
            }
        }
    }
}
