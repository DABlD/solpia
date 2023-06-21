<?php

namespace App\Exports;

use App\Models\{Applicant};

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ShinkoDC implements FromView, WithEvents, WithColumnFormatting//, WithDrawings//, ShouldAutoSize
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
            [
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
                ]
            ],
            [
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ]
            ],
        ];

        $fillStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'EEECE1'
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
            [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ]
            ],
            [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
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

                $event->sheet->getDelegate()->getStyle('A4:N61')->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(29);

                // CHEAT

                if(isset($this->applicant->document_id->PASSPORT) && $this->applicant->document_id->PASSPORT->issue_date->diffInMonths($this->applicant->document_id->PASSPORT->expiry_date) < 18){
                    $event->sheet->getDelegate()->getStyle('F9:J9')->getFont()->getColor()->setRGB('FF0000');
                }

                // ROWS

                //'A:E', 'F:G', 'H:I', 'J:K', 'L:N',
                $rows = [
                    
                ];

                $ecdisRows = 0;
                foreach($this->applicant->document_lc as $key => $docu){
                    if(Str::startsWith($docu->type, 'ECDIS ') && $key > 0){
                        $ecdisRows++;
                    }
                }

                $ecdisRows = $ecdisRows <= 1 ? 0 : $ecdisRows - 1;

                // FUNCTIONS
                for($i = 6; $i <= (59 + $ecdisRows); $i++){
                    array_push($rows, "A$i:E$i");
                    array_push($rows, "F$i:G$i");
                    array_push($rows, "H$i:I$i");
                    array_push($rows, "J$i:K$i");
                    array_push($rows, "L$i:N$i");
                }

                // HEADINGS

                // HC B
                $h[0] = [
                	'A1:N1', 'A7:N7'
                ];

                // VT
                $h[1] = [
                	'A' . (49 + $ecdisRows), 'F' . (49 + $ecdisRows), 'J' . (49 + $ecdisRows)
                ];

                // HL B
                $h[2] = [
                	
                ];

                // HC
                $h[3] = [
                	'F8:L' . (56 + $ecdisRows)
                ];

                // HL
                $h[4] = [
                    
                ];

                // HC VC
                $h[5] = [
                    'A7:N7'
                ];

                // VC
                $h[6] = [
                    'A' . (57 + $ecdisRows) . ':J' . (57 + $ecdisRows)
                ];

                $h['wrap'] = [
                	'N7', 'A' . (57 + $ecdisRows), 'F' . (57 + $ecdisRows), 'J' . (57 + $ecdisRows)
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

                $event->sheet->getDelegate()->getStyle("A8:N" . (57 + $ecdisRows))->applyFromArray([
                    'alignment' => [
                        'shrinkToFit' => true
                    ],
                ]);

                // FILLS
                $fills = [
                    'A1', 'A3:A5', 'F3:F6', 'H6', 'J3:J6', 'L6',
                    'A7:A' . (59 + $ecdisRows), 'A7:N7'
                ];

                foreach($fills as $fill){
                	$event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle);	
                }

                // BORDERS
                $cells[0] = array_merge($rows, [
                    'A1:N1',
                    'A3:B3', 'C3:E3', 'F3:G3', 'H3:I3', 'J3:K3', 'L3:N3',
                    'A4:B4', 'C4:E4', 'F4:G4', 'H4:I4', 'J4:K4', 'L4:N4',
                    'A5:B5', 'C5:E5', 'F5:G5', 'H5:I5', 'J5:K5', 'L5:N5',
                    'A6:E6', 'F6:G6', 'H6:I6', 'J6:K6', 'L6:N6',
                ]);

                $cells[1] = [
                    'A3:N5', 'A7:N7', 'A7:N' . (59 + $ecdisRows)
                ];

                foreach($cells as $key => $cell){
                    foreach($cell as $mitochondria){
                        $event->sheet->getDelegate()->getStyle($mitochondria)->applyFromArray($borderStyle[$key]);
                    }
                }

                // SET SEPARATOR COLOR
                foreach(['A8', 'A13', 'A22', 'A28', 'A' . (53 + $ecdisRows)] as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->getColor()->setRGB('FF0000');
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray([
                        'font' => [
                            'bold' => true
                        ],
                    ]);

                }

                // COLOR FOR ISSUER
                $event->sheet->getDelegate()->getStyle('L8:L' . (56 + $ecdisRows))->getFont()->getColor()->setRGB('002060');

                // COLUMN RESIZE

                // $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(11);
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(36);
                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(20);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
