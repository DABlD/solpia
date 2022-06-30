<?php

namespace App\Exports;

use PDF;
use App\Models\{LineUpContract, ProcessedApplicant, DocumentId, Applicant, Vessel, Rank};

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
        ->select('applicant_id')
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

            array_push($docs, DocumentId::where($w)->first()->file);
            array_push($docs, DocumentId::where($w2)->first()->file);
            $applicant->docs = $docs;
        }

        return $applicants;
    }

    public function Y02_OffsignerDocs(){
        $applicants = LineUpContract::where([
            ['line_up_contracts.status', '=', 'On Board'],
            ['vessel_id', '=', $this->data->data['id']],
            ['disembarkation_date', '=', null]
        ])
        ->select('applicant_id', 'reliever')
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

            array_push($docs, DocumentId::where($w)->first()->file);
            array_push($docs, DocumentId::where($w2)->first()->file);
            $applicant->docs = $docs;
        }

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

    public function download(){
        $pdf = PDF::loadView('exports.forms.' . lcfirst($this->type), ['data' => $this->data]);
        $pdf->setPaper('a4', 'Portrait');
        return $pdf->download($this->fileName . '.pdf');
    }
}
