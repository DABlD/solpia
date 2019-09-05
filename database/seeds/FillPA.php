<?php

use Illuminate\Database\Seeder;
use App\Models\{ProcessedApplicant, Applicant};

class FillPA extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $applicants = Applicant::where('deleted_at', null)->get();
        foreach($applicants as $applicant){
        	if(ProcessedApplicant::where('applicant_id', $applicant->id)->count() == 0){
		        ProcessedApplicant::create([
		            'applicant_id' => $applicant->id,
		            'status' => 'Vacation'
		        ]);
        	}
        }
    }
}
