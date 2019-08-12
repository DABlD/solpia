<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ShinkoDC implements FromView, WithEvents//, WithDrawings//, ShouldAutoSize
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
            [
            	'alignment' => [
            	    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            	]
            ],
            [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ]
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('DOCUMENT CHECKLIST', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                // FONT SIZES

                $event->sheet->getDelegate()->getStyle('A4:N60')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(18);
                $event->sheet->getDelegate()->getStyle('A42')->getFont()->setSize(10);

                // CHEAT

                if(isset($this->applicant->document_id->PASSPORT) && $this->applicant->document_id->PASSPORT->issue_date->diffInMonths(now()) > 18){
                    $event->sheet->getDelegate()->getStyle('F15:J15')->getFont()->getColor()->setRGB('FF0000');
                }

                // ROWS

                //'A:E', 'F:G', 'H:I', 'J:K', 'L:N',
                $rows = [
                    
                ];

                // FUNCTIONS
                for($i = 6; $i < 45; $i++){
                    if($i < 29 || $i > 31){
                        array_push($rows, "A$i:E$i");
                    }
                    else{
                        array_push($rows, "D$i:E$i");
                    }
                    array_push($rows, "F$i:G$i");
                    array_push($rows, "H$i:I$i");
                    array_push($rows, "J$i:K$i");
                    array_push($rows, "L$i:N$i");
                }

                array_push($rows, "A29:C31");
                array_push($rows, "A45:E47");
                array_push($rows, "F45:I47");
                array_push($rows, "J45:N47");

                // HEADINGS

                // HC B
                $h[0] = [
                	'A1:N1'
                ];

                // VT
                $h[1] = [
                	'A29', 'A45', 'F45', 'J45'
                ];

                // HL B
                $h[2] = [
                	
                ];

                // HC
                $h[3] = [
                	'A6:N6'
                ];

                // HL
                $h[4] = [
                    'F7:L44'
                ];

                $h['wrap'] = [
                	'A42', 'A45', 'F45', 'J45'
                ];

                // $event->sheet->getDelegate()->getStyle('A1:N60')->getAlignment()->setWrapText(true);
                foreach($h as $key => $value) {
            		foreach($value as $col){
            			if($key === 'wrap'){
            				$event->sheet->getDelegate()->getStyle($col)->getAlignment()->setWrapText(true);
            			}
            			else{
	            			$event->sheet->getDelegate()->getStyle($col)->applyFromArray($headingStyle[$key]);
            			}
            		}
                }

                // FILLS
                $fills = [
                    'A1', 'A3:A6', 'F3:F6', 'H6', 'J3:J6', 'L6',
                    'A7:E45'
                ];

                foreach($fills as $fill){
                	$event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle);	
                }

                // BORDERS
                $cells = array_merge($rows, [
                    'A1:N1',
                    'A3:B3', 'C3:E3', 'F3:G3', 'H3:I3', 'J3:K3', 'L3:N3',
                    'A4:B4', 'C4:E4', 'F4:G4', 'H4:I4', 'J4:K4', 'L4:N4',
                    'A5:B5', 'C5:E5', 'F5:G5', 'H5:I5', 'J5:K5', 'L5:N5',
                    'A6:E6', 'F6:G6', 'H6:I6', 'J6:K6', 'L6:N6',
                ]);

                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle);
                }

                // COLUMN RESIZE

                // $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(11);
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(25);
            },
        ];
    }
}
