<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class Application implements FromView, ShouldAutoSize, WithEvents, WithDrawings
{
    public function __construct($applicant){
        $this->applicant = $applicant;
    }

    public function view(): View
    {
    	return view('exports.application', [
            'applicant' => $this->applicant
        ]);
    }

    public function registerEvents(): array
    {
        $borderStyle = [
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $fillStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'ced4da'
                ]
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle) {
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(18);
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->setSize(12);

                $event->sheet->getDelegate()->getStyle('A1:A2')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ]);

                // FILLS
                $event->sheet->getDelegate()->getStyle('A3:A8')->applyFromArray($fillStyle);
                $event->sheet->getDelegate()->getStyle('E3:E5')->applyFromArray($fillStyle);
                $event->sheet->getDelegate()->getStyle('J3:J5')->applyFromArray($fillStyle);
                $event->sheet->getDelegate()->getStyle('J3:J5')->applyFromArray($fillStyle);
                $event->sheet->getDelegate()->getStyle('G8:L8')->applyFromArray($fillStyle);

                $cells = [
                    'A1:N1','A2:N2','A3:B3','C3:D3','A4:B4',
                    'C4:D4','A5:B5','C5:D5','E3:F3','G3:I3',
                    'E4:F4','G4:I4','E5:F5','G5:I5','J3',
                    'K3:L3','K4','L4','G4:I4','J5','K5','L5',
                    'A6:C6', 'D6:L6', 'A7:C7', 'D7:L7',
                    'A8:C8', 'D8:F8', 'G8:L8', 'G8:L8', 'M3:N8',
                ];

                // BORDERS
                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle);
                }
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
        $drawing->setPath(public_path($this->applicant->user->avatar));
        $drawing->setHeight(119);
        $drawing->setOffsetX(1);
        $drawing->setOffsetY(1);
		$drawing->setCoordinates('M3');

        return $drawing;
    }
}
