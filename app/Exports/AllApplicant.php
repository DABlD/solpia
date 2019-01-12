<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AllApplicant implements FromView, ShouldAutoSize, WithTitle, WithDrawings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	$applicants = Applicant::with('user')->get();

        return view('exports.all_applicants', [
            'applicants' => $applicants
        ]);
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
		$drawing->setPath(public_path('/images/default_avatar.jpg'));
		$drawing->setHeight(36);
		$drawing->setCoordinates('B2');

        return $drawing;
    }

    public function title(): string
    {
        return 'Applicants';
    }
}
