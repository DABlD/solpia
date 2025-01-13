<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{TempApplicant, TempSeaService, TempUser, Rank};

class OnlineController extends Controller
{
    public function index(Request $req){
        $ranks = Rank::select('id', 'name', 'abbr', 'category')->get();

        return $this->_view('index', [
            'title'         => 'SOLPIA ONLINE APPLICATION',
            'categories'    => $ranks->groupBy('category'),
        ]);
    }

    public function store(Request $req){
        $user = collect($req->only([
            'fname','mname','lname', 'suffix',
            'birthday','address','contact',
            'email','gender'
        ]))->put('password', '123456')->put('role', 'Applicant');

        $user['fname'] = strtoupper($user['fname']);
        $user['mname'] = strtoupper($user['mname']);
        $user['lname'] = strtoupper($user['lname']);
        $user['suffix'] = strtoupper($user['suffix']);
        $user['applicant'] = auth()->user()->status;

        if($user['applicant']){
            $user['fleet'] = auth()->user()->fleet;
        }

        // UPLOAD AVATAR
        if($req->hasFile('avatar')){
            $image = $req->file('avatar');
            $avatar = Image::make($image);

            $name = $req->fname . '_' . $req->lname . '_avatar.'  . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/');

            $avatar->resize(209,196);
            $name = str_replace('Ñ', 'N', $name);
            $avatar->save($destinationPath . $name);
            $user->put('avatar', 'uploads/' . $name);
        }
        else{
            $user->put('avatar', 'images/default_avatar.jpg');
        }


        // SAVE USER
        $user = User::create($user->all());

        // SAVE APPLICANT
        $applicant = collect($req->only([
            'provincial_address','provincial_contact',
            'birth_place','religion','age','waistline',
            'shoe_size','height','weight','bmi','blood_type',
            'civil_status', 'tin', 'sss', 'eye_color', 'clothes_size'
        ]))->put('user_id', $user->id);

        $applicant['provincial_address'] = strtoupper($applicant['provincial_address']);
        $applicant['birth_place'] = strtoupper($applicant['birth_place']);
        $applicant['religion'] = strtoupper($applicant['religion']);

        $applicant = Applicant::create($applicant->all());

        // SAVE FAMILY DATA
        $fd = json_decode($req->fd);
        foreach($fd as $data){
            $data->applicant_id = $applicant->id;
            $data->birthday = $data->birthday == "" ? null : $data->birthday;
            $data->age = $data->birthday == "" ? null : now()->parse($data->birthday)->age;
            FamilyData::create((array)$data);
        }

        // SAVE SEA SERVICE
        $ss = json_decode($req->ss);
        foreach($ss as $data){
            $data->applicant_id = $applicant->id;
            $data->sign_on = $data->sign_on == "" ? null : $data->sign_on;
            $data->sign_off = $data->sign_off == "" ? null : $data->sign_off;
            $data->previous_salary = $data->previous_salary == "" ? null : $data->previous_salary;

            SeaService::create((array)$data);
            
            if(Vessel::where('imo', $data->imo)->count() == 0){
            // if(Vessel::where('name', $data->vessel_name)->count() == 0){
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
                        'imo'           => $data->imo
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
                        'imo'           => $data->imo
                    ]);
                }
            }
        }

        // SAVE EDUCATIONAL BACKGROUND
        $eb = json_decode($req->eb);
        foreach($eb as $data){
            $data->applicant_id = $applicant->id;
            EducationalBackground::create((array)$data);
        }

        // SAVE DOCUMENT ID
        $docu_id = json_decode($req->docu_id);
        foreach($docu_id as $data){
            $data->type = $data->type == "SEAMAN BOOK" ? "SEAMAN'S BOOK" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;
            DocumentId::create((array)$data);
        }

        // SAVE DOCUMENT FLAG
        $docu_flag = json_decode($req->docu_flag);
        foreach($docu_flag as $data){
            $data->type = $data->type == "SHIP COOK ENDORSEMENT" ? "SHIP'S COOK ENDORSEMENT" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;
            DocumentFlag::create((array)$data);
        }

        // SAVE DOCUMENT LC
        $docu_lc = json_decode($req->docu_lc);
        foreach($docu_lc as $data){
            $data->type = $data->type == "SAFETY OFFICER TRAINING COURSE" ? "SAFETY OFFICER'S TRAINING COURSE" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->regulation = json_encode($data->regulation);
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;
            DocumentLC::create((array)$data);
        }

        // SAVE DOCUMENT MED CERT
        $docu_med_cert = json_decode($req->docu_med_cert);
        foreach($docu_med_cert as $data){
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;
            DocumentMedCert::create((array)$data);
        }

        // SAVE DOCUMENT MED
        $docu_med = json_decode($req->docu_med);
        foreach($docu_med as $data){
            $data->applicant_id = $applicant->id;
            $data->year = $data->year == "" ? null : $data->year;
            DocumentMed::create((array)$data);
        }

        ProcessedApplicant::create([
            'applicant_id' => $applicant->id,
            'status' => 'Vacation'
        ]);

        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "encoded " . $user['lname'] . ', ' . $user['fname'],
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        if(true){
            $req->session()->flash('success', 'Applicant Successfully Added.');
            return redirect()->route('applications.index');
        }
        else{
            $req->session()->flash('error', 'There was a problem adding the applicant. Try again.');
            return back();
        }
    }

    public function update(Request $req, $id){
        // SAVE APPLICANT
        $applicant = collect($req->only([
            'provincial_address','provincial_contact',
            'birth_place','religion','age','waistline',
            'shoe_size','height','weight','bmi','blood_type',
            'civil_status', 'tin', 'sss', 'eye_color', 'clothes_size'
        ]));

        $applicant['provincial_address'] = strtoupper($applicant['provincial_address']);
        $applicant['birth_place'] = strtoupper($applicant['birth_place']);
        $applicant['religion'] = strtoupper($applicant['religion']);

        $applicant = Applicant::where('user_id', $id)->update($applicant->all());

        $user = collect($req->only([
            'fname','mname','lname', 'suffix',
            'birthday','address','contact',
            'email','gender'
        ]));

        $user['fname'] = strtoupper($user['fname']);
        $user['mname'] = strtoupper($user['mname']);
        $user['lname'] = strtoupper($user['lname']);
        $user['suffix'] = strtoupper($user['suffix']);

        if($req->hasFile('avatar')){
            // UPLOAD AVATAR
            $image = $req->file('avatar');
            $avatar = Image::make($image);

            $name = $req->fname . '_' . $req->lname . '_avatar.'  . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/');

            $name = str_replace('Ñ', 'N', $name);
            $avatar->resize(209,196);
            $avatar->save($destinationPath . $name);

            $user->put('avatar', 'uploads/' . $name);
        }

        // SAVE USER
        $user = User::where('id', $id)->update($user->all());

        $applicant = Applicant::where('user_id', $id)->first();
        $applicant->load('educational_background');
        $applicant->load('family_data');
        $applicant->load('sea_service');

        $applicant->load('document_id');
        $applicant->load('document_flag');
        $applicant->load('document_lc');
        $applicant->load('document_med_cert');
        $applicant->load('document_med');

        // SAVE FAMILY DATA
        $fd = json_decode($req->fd);
        foreach($fd as $data){
            $data->applicant_id = $applicant->id;
            $data->birthday = $data->birthday == "" ? null : $data->birthday;
            $data->age = $data->birthday == "" ? null : now()->parse($data->birthday)->age;

            if(isset($data->id)){
                FamilyData::where('id', $data->id)->update((array)$data);
            }
            else{
                FamilyData::create((array)$data);
            }
        }

        // DELETE FAMILY DATA
        $this->clearData($applicant->family_data, $req->fd, 'family_datas');

        // SAVE SEA SERVICE
        $ss = json_decode($req->ss);
        foreach($ss as $data){
            $data->applicant_id = $applicant->id;
            $data->sign_on = $data->sign_on == "" ? null : $data->sign_on;
            $data->sign_off = $data->sign_off == "" ? null : $data->sign_off;
            $data->previous_salary = $data->previous_salary == "" ? null : $data->previous_salary;

            if(isset($data->id)){
                SeaService::where('id', $data->id)->update((array)$data);
            }
            else{
                SeaService::create((array)$data);
            }

            if(Vessel::where('imo', $data->imo)->count() == 0){
            // if(Vessel::where('name', $data->vessel_name)->count() == 0){
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
                        'imo'           => $data->imo
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
                        'imo'           => $data->imo
                    ]);
                }
            }
        }

        // DELETE SEA SERVICE
        $this->clearData($applicant->sea_service, $req->ss, 'sea_services');

        // SAVE EDUCATIONAL BACKGROUND
        $eb = json_decode($req->eb);
        foreach($eb as $data){
            $data->applicant_id = $applicant->id;

            if(isset($data->id)){
                EducationalBackground::where('id', $data->id)->update((array)$data);

            }
            else{
                EducationalBackground::create((array)$data);
            }
        }

        // DELETE EDUCATIONAL BACKGROUND
        $this->clearData($applicant->educational_background, $req->eb, 'educational_backgrounds');

        // SAVE DOCUMENT ID
        $docu_id = json_decode($req->docu_id);
        foreach($docu_id as $data){
            $data->type = $data->type == "SEAMAN BOOK" ? "SEAMAN'S BOOK" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;

            if(isset($data->id)){
                DocumentId::where('id', $data->id)->update((array)$data);
            }
            else{
                DocumentId::create((array)$data);
            }
        }

        // DELETE DOCUMENT ID
        $this->clearData($applicant->document_id, $req->docu_id, 'document_ids');

        // SAVE DOCUMENT FLAG
        $docu_flag = json_decode($req->docu_flag);
        foreach($docu_flag as $data){
            $data->type = $data->type == "SHIP COOK ENDORSEMENT" ? "SHIP'S COOK ENDORSEMENT" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;

            if(isset($data->id)){
                DocumentFlag::where('id', $data->id)->update((array)$data);
            }
            else{
                DocumentFlag::create((array)$data);
            }
        }

        // DELETE DOCUMENT FLAG
        $this->clearData($applicant->document_flag, $req->docu_flag, 'document_flags');

        // SAVE DOCUMENT LC
        $docu_lc = json_decode($req->docu_lc);
        foreach($docu_lc as $data){
            $data->type = $data->type == "SAFETY OFFICER TRAINING COURSE" ? "SAFETY OFFICER'S TRAINING COURSE" : $data->type;
            $data->applicant_id = $applicant->id;
            $data->regulation = json_encode($data->regulation);
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;

            if(isset($data->id)){
                DocumentLC::where('id', $data->id)->update((array)$data);
            }
            else{
                DocumentLC::create((array)$data);
            }
        }

        // DELETE DOCUMENT LC
        $this->clearData($applicant->document_lc, $req->docu_lc, 'document_l_cs');

        // SAVE DOCUMENT MED CERT
        $docu_med_cert = json_decode($req->docu_med_cert);
        foreach($docu_med_cert as $data){
            $data->applicant_id = $applicant->id;
            $data->issue_date = $data->issue_date == "" ? null : $data->issue_date;
            $data->expiry_date = $data->expiry_date == "" ? null : $data->expiry_date;

            if(isset($data->id)){
                DocumentMedCert::where('id', $data->id)->update((array)$data);
            }
            else{
                DocumentMedCert::create((array)$data);
            }
        }

        // DELETE DOCUMENT MED CERT
        $this->clearData($applicant->document_med_cert, $req->docu_med_cert, 'document_med_certs');

        // SAVE DOCUMENT MED
        $docu_med = json_decode($req->docu_med);
        foreach($docu_med as $data){
            $data->applicant_id = $applicant->id;
            $data->year = $data->year == "" ? null : $data->year;

            if(isset($data->id)){
                DocumentMed::where('id', $data->id)->update((array)$data);
            }
            else{
                DocumentMed::create((array)$data);
            }
        }

        // DELETE DOCUMENT MED
        $this->clearData($applicant->document_med, $req->document_med, 'document_meds');

        if(true){
            $req->session()->flash('success', 'Applicant Successfully Updated.');
        }
        else{
            $req->session()->flash('error', 'There was a problem updating the applicant. Try again.');
        }

        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "updated " . $req->lname . ', ' . $req->fname,
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        return redirect()->route('applications.index');
        // return back();
    }

    private function _view($view, $data = array()){
        return view('online.' . $view, $data);
    }
}
