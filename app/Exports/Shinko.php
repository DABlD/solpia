<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class Shinko implements FromView, ShouldAutoSize, WithEvents, WithDrawings
{
    public function __construct($applicant,$type){
        $this->applicant = $applicant;
        $this->type = $type;
    }

    public function view(): View
    {
    	return view('exports.' . $this->type, [
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

        $headingStyle = [
            [
            	'font' => [
            	    'bold' => true
            	],
            	'alignment' => [
            	    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            	]
            ],
            [
            	'alignment' => [
            	    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            	    'wrap' => TRUE
            	]
            ],
            [
            	'font' => [
            	    'bold' => true
            	],
            	'alignment' => [
            	    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            	]
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // FONT SIZES
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(24);
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->setSize(18);

                // HEADINGS
                $event->sheet->getDelegate()->getStyle('A1:A2')->applyFromArray($headingStyle[0]);
                $event->sheet->getDelegate()->getStyle('H3')->applyFromArray($headingStyle[1]);
                $event->sheet->getDelegate()->getStyle('C7:C10')->applyFromArray($headingStyle[2]);
                $event->sheet->getDelegate()->getStyle('I7:I10')->applyFromArray($headingStyle[2]);
                $event->sheet->getDelegate()->getStyle('A11:H11')->applyFromArray($headingStyle[0]);

                // FILLS
                $fills = [
                	'H3:I6',
                	'A7:B7', 'G7:H7',
                	'A8:B8', 'G8:H8',
                	'A9:B9', 'G9:H9',
                	'A10:B10', 'G10:H10',
                	'A11', 'H11',
                ];

                foreach($fills as $fill){
                	$event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle);	
                }

                // BORDERS
                $cells = [
                    'H3:I6','J3:K6','L3:N10',
                	'A7:B7', 'G7:H7', 'C7:F7', 'I7:K7',
                	'A8:B8', 'G8:H8', 'C8:F8', 'I8:K8',
                	'A9:B9', 'G9:H9', 'C9:F9', 'I9:K9', 'K9',
                	'A10:B10', 'G10:H10', 'C10:F10', 'I10:K10', 'K10',
                	'A11:G11', 'H11:N11',
                ];

                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle);
                }

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('N')->setAutoSize(false);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(4);
            },
        ];
    }



    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
        $drawing->setPath(public_path($this->applicant->user->avatar));
        $drawing->setHeight(158);
		$drawing->setCoordinates('L3');

        return $drawing;
    }
}
