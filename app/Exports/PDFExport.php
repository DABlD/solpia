<?php

namespace App\Exports;

use PDF;
use App\Models\{LineUpContract, ProcessedApplicant, DocumentId, Applicant, Vessel, Rank, Wage, DocumentMedCert};

class PDFExport
{
    public function __construct($data, $type, $fileName){
        $this->data = $data;
        $this->type = $type;
        $this->fileName = $fileName;
    }

    public function getData(){
        $this->data = $this->{$this->type}($this->data);
    }

    public function Y01_OnsignerDocs(){
        $applicants = ProcessedApplicant::where([
            ['status', '=', 'Lined-Up'],
            ['vessel_id', '=', $this->data->data['id']],
        ])
        ->select('applicant_id', 'rank_id', 'order')
        ->join('ranks as r', 'r.id', '=', 'processed_applicants.rank_id')
        ->get();

        foreach($applicants as $applicant){
            $docs = [];

            $w = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', '=', "PASSPORT"],
            ];
            $w2 = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', '=', "SEAMAN'S BOOK"],
            ];

            $temp = DocumentId::where($w)->first();
            $temp2 = DocumentId::where($w2)->first();
            
            $temp ? array_push($docs, $temp->file) : '';
            $temp2 ? array_push($docs, $temp2->file) : '';

            $applicant->docs = $docs;
        }

        $applicants = $applicants->sortBy('order');
        return $applicants;
    }

    public function Y02_OffsignerDocs(){
        $applicants = LineUpContract::where([
            ['line_up_contracts.status', '=', 'On Board'],
            ['vessel_id', '=', $this->data->data['id']],
            ['disembarkation_date', '=', null]
        ])
        ->select('applicant_id', 'rank_id', 'order', 'reliever')
        ->join('ranks as r', 'r.id', '=', 'line_up_contracts.rank_id')
        ->get();

        foreach($applicants as $applicant){
            $docs = [];

            $w = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', '=', "PASSPORT"],
            ];
            $w2 = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', '=', "SEAMAN'S BOOK"],
            ];

            $temp = DocumentId::where($w)->first();
            $temp2 = DocumentId::where($w2)->first();

            $temp ? array_push($docs, $temp->file) : '';
            $temp2 ? array_push($docs, $temp2->file) : '';

            $applicant->docs = $docs;
        }

        $applicants = $applicants->sortBy('order');
        return $applicants;
    }

    public function Y03_LetterOfOathMarpol(){
        $applicant = Applicant::find($this->data->data['id']);
        $applicant->load('user');
        $applicant->load('document_id');
        $applicant->load('pro_app');

        $applicant->vessel = Vessel::find($applicant->pro_app->vessel_id)->name;
        $applicant->rank = Rank::find($applicant->pro_app->rank_id)->name;

        return $applicant;
    }

    public function Y04_LetterOfOath(){
        $applicant = Applicant::find($this->data->data['id']);
        $applicant->load('user');
        $applicant->load('document_id');
        $applicant->load('pro_app');

        $applicant->vessel = Vessel::find($applicant->pro_app->vessel_id)->name;
        $applicant->rank = Rank::find($applicant->pro_app->rank_id)->name;

        return $applicant;
    }

    public function Y05_ClearanceAffidavit(){
        $applicant = Applicant::find($this->data->data['id']);
        $applicant->load('user');
        $applicant->load('document_id');

        foreach(['document_id'] as $docuType){
            foreach($applicant->$docuType as $key => $doc){
                $name = $doc->type;
                if(!isset($applicant->$docuType->$name)){
                    $applicant->$docuType->$name = $doc;
                }
                else{
                    $size = 0;
                    if(is_array($applicant->$docuType->$name)){
                        $size = sizeof($applicant->$docuType->$name);
                    }
                    $name .= $size;
                    $applicant->$docuType->$name = $doc;
                }
                $applicant->$docuType->forget($key);
            }
        }

        return $applicant;
    }

    public function Y06_EMSDeclaration(){
        $applicant = Applicant::find($this->data->data['id']);
        $applicant->load('pro_app');

        $applicant->vessel = Vessel::find($applicant->pro_app->vessel_id)->name;
        $applicant->rank = Rank::find($applicant->pro_app->rank_id)->name;

        return $applicant;
    }

    public function Y07_TOEIMLCQuestionnaire(){
        $applicant = Applicant::find($this->data->data['id']);
        $applicant->load('document_id');
        $applicant->load('pro_app');

        foreach(['document_id'] as $docuType){
            foreach($applicant->$docuType as $key => $doc){
                $name = $doc->type;
                $applicant->$docuType->$name = $doc;
                $applicant->$docuType->forget($key);
            }
        }

        $applicant->wage = Wage::where('rank_id', $applicant->pro_app->rank_id)->where('vessel_id', $applicant->pro_app->vessel_id)->first();
        $applicant->vessel = Vessel::find($applicant->pro_app->vessel_id);
        
        return $applicant;
    }

    public function Y08_OnsignerUSV(){
        $applicants = ProcessedApplicant::where([
            ['status', '=', 'Lined-Up'],
            ['vessel_id', '=', $this->data->data['id']],
        ])
        ->select('applicant_id', 'rank_id', 'order')
        ->join('ranks as r', 'r.id', '=', 'processed_applicants.rank_id')
        ->get();

        foreach($applicants as $applicant){
            $docs = [];

            $w = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', '=', "US-VISA"],
            ];

            $temp = DocumentId::where($w)->first();
            
            $temp ? array_push($docs, $temp->file) : '';

            $applicant->docs = $docs;
        }

        $applicants = $applicants->sortBy('order');
        return $applicants;
    }

    public function Y09_OffsignerUSV(){
        $applicants = LineUpContract::where([
            ['line_up_contracts.status', '=', 'On Board'],
            ['vessel_id', '=', $this->data->data['id']],
            ['disembarkation_date', '=', null]
        ])
        ->select('applicant_id', 'rank_id', 'order', 'reliever')
        ->join('ranks as r', 'r.id', '=', 'line_up_contracts.rank_id')
        ->get();

        foreach($applicants as $applicant){
            $docs = [];

            $w = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', '=', "US-VISA"],
            ];

            $temp = DocumentId::where($w)->first();
            
            $temp ? array_push($docs, $temp->file) : '';

            $applicant->docs = $docs;
        }

        $applicants = $applicants->sortBy('order');
        return $applicants;
    }

    public function Y10_OnsignerCovid(){
        $applicants = ProcessedApplicant::where([
            ['status', '=', 'Lined-Up'],
            ['vessel_id', '=', $this->data->data['id']],
        ])
        ->select('applicant_id', 'rank_id', 'order')
        ->join('ranks as r', 'r.id', '=', 'processed_applicants.rank_id')
        ->get();

        foreach($applicants as $applicant){
            $docs = [];

            $w = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', 'like', "COVID-19 1ST DOSE"],
            ];

            $w2 = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', 'like', "COVID-19 2ND DOSE"],
            ];

            $w3 = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', 'like', "COVID-19 3RD DOSE"],
            ];

            $temp = DocumentMedCert::where($w)->get();
            $temp2 = DocumentMedCert::where($w2)->get();
            $temp3 = DocumentMedCert::where($w3)->get();

            $temp ? array_push($docs, $temp->file) : '';
            $temp2 ? array_push($docs, $temp2->file) : '';
            $temp3 ? array_push($docs, $temp3->file) : '';

            $applicant->docs = $docs;
        }

        $applicants = $applicants->sortBy('order');
        return $applicants;
    }

    public function Y11_OffsignerCovid(){
        $applicants = LineUpContract::where([
            ['line_up_contracts.status', '=', 'On Board'],
            ['vessel_id', '=', $this->data->data['id']],
            ['disembarkation_date', '=', null]
        ])
        ->select('applicant_id', 'rank_id', 'order', 'reliever')
        ->join('ranks as r', 'r.id', '=', 'line_up_contracts.rank_id')
        ->get();

        foreach($applicants as $applicant){
            $docs = [];

            $w = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', 'like', "COVID-19 1ST DOSE"],
            ];

            $w2 = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', 'like', "COVID-19 2ND DOSE"],
            ];

            $w3 = [
                ['applicant_id', '=', $applicant->applicant_id],
                ['type', 'like', "COVID-19 3RD DOSE"],
            ];

            $temp = DocumentMedCert::where($w)->get();
            $temp2 = DocumentMedCert::where($w2)->get();
            $temp3 = DocumentMedCert::where($w3)->get();

            $temp ? array_push($docs, $temp->file) : '';
            $temp2 ? array_push($docs, $temp2->file) : '';
            $temp3 ? array_push($docs, $temp3->file) : '';

            $applicant->docs = $docs;
        }

        $applicants = $applicants->sortBy('order');
        return $applicants;
    }

    public function download(){
        $pdf = PDF::loadView('exports.forms.' . lcfirst($this->type), ['data' => $this->data]);
        $pdf->setPaper('a4', 'Portrait');
        return $pdf->download($this->fileName . '.pdf');
    }
}
