<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ShinkoBD implements FromView, WithEvents, WithDrawings, WithColumnFormatting//, ShouldAutoSize
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
                ],
            ],
            [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '808080'
                        ]
                    ],
                ],
            ],
            [
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '808080'
                        ]
                    ],
                ],
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
                ],
            ]
        ];

        $fillStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    // 'rgb' => 'ced4da'
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
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            [
                'font' => [
                    'italic' => true
                ],
            ]
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('BIO DATA', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                // FONT SIZES

                $event->sheet->getDelegate()->getStyle('A4:O60')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(28);
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->setSize(20);

                // FAMILY DATA ROWS
                $fdRows = array();
                $temp = $this->applicant->family_data->count() / 2;
                $raf = 22 + $temp; //Row # After Family Data

                for($i = 0, $row = 23; $i < $temp; $i++, $row++){
                	array_push($fdRows, 'A' . $row . ':B' . $row);
                	array_push($fdRows, 'C' . $row . ':D' . $row);
                	array_push($fdRows, 'E' . $row . ':F' . $row);
                	array_push($fdRows, 'G' . $row);
                	array_push($fdRows, 'H' . $row);
                	array_push($fdRows, 'I' . $row . ':K' . $row);
                	array_push($fdRows, 'L' . $row . ':M' . $row);
                	array_push($fdRows, 'N' . $row . ':O' . $row);

                    $event->sheet->getDelegate()->getStyle("A$row:O$row")->applyFromArray([
                        'alignment' => [
                            'shrinkToFit' => true
                        ],
                    ]);
                }

                // SS DATA ROWS
                $ssRows = array();
                $temp = $this->applicant->sea_service->count();
                $ras = $raf + 2 + ($temp*2); //Row # after Sea Service

                for($i = 0, $row = $raf + 4; $i < $temp; $i++, $row+=2){
                    $next = $row + 1;
                    array_push($ssRows, 'A' . $row . ':A' . $next);
                    array_push($ssRows, 'B' . $row . ':D' . $next);
                    array_push($ssRows, 'E' . $row . ':E' . $next);
                    array_push($ssRows, 'F' . $row);
                    array_push($ssRows, 'F' . $next);
                    array_push($ssRows, 'G' . $row . ':G' . $next);
                    array_push($ssRows, 'H' . $row . ':H' . $next);
                    array_push($ssRows, 'I' . $row . ':J' . $row);
                    array_push($ssRows, 'I' . $next . ':J' . $next);
                    array_push($ssRows, 'K' . $row);
                    array_push($ssRows, 'K' . $next);
                    array_push($ssRows, 'L' . $row . ':M' . $row);
                    array_push($ssRows, 'L' . $next . ':M' . $next);
                    array_push($ssRows, 'N' . $row . ':O' . $next);

                    // $event->sheet->getDelegate()->getRowDimension($row)->setRowHeight(35);
                    // $event->sheet->getDelegate()->getRowDimension($row+1)->setRowHeight(35);
                    $event->sheet->getDelegate()->getStyle('I' . $next)->getFont()->setSize(10);
                    // $event->sheet->getDelegate()->getRowDimension($next)->setRowHeight(25);

                    $event->sheet->getDelegate()->getStyle("N$row")->getAlignment()->setWrapText(true);

                    $event->sheet->getDelegate()->getStyle("B$row:M$next")->applyFromArray([
                        'alignment' => [
                            'shrinkToFit' => true
                        ],
                    ]);
                }

                // FUNCTIONS
                $x = function($let1, $inc1, $let2 = null, $inc2 = null, $temp = null) use ($raf, $ras){
                    $temp = $temp==null? $raf : $ras;

                	if($let2 == null){
                		return $let1 . ($temp + $inc1);
                	}
                	else{
                		$inc2 = $inc2 == null? $inc1 : $inc2;
                		return $let1 . ($temp + $inc1) . ':' . $let2 . ($temp + $inc2);
                	}
                };

                // HEADINGS

                // HC B
                $h[0] = [
                	'A1:A2', 'A11:I11', 'A21','H17', 'B21', $x('A', 1),
                ];

                // VT
                $h[1] = array_merge($fdRows, $ssRows, [
                	'H3', 'H12:J12', 'B13:B17',
                ]);

                // HL B
                $h[2] = [
                	'D7:D10', 'J7:J10',
                ];

                // HC
                $h[3] = [
                	'A22:O22', $x('A', 2, 'O', 2), $x('I', 10, 'N', 10, true),
                    'A' . ($raf + 4) . ':' . 'A' . ($ras + 2),
                    'E' . ($raf + 4) . ':' . 'O' . ($ras + 2),
                    $x('I', 3, 'M', 3, true), $x('J', 11, '', '', true),
                ];

                // HL
                $h[4] = [
                    'D13:F20', 'J19'
                ];

                // VC
                $h[5] = [
                    'A' . ($raf + 4) . ':' . 'B' . ($ras + 2)
                ];

                // ITALIC
                $h[7] = [
                    $x('A', 7, '', '', true)
                ];

                $h['wrap'] = array_merge([
                	'J12', $x('A', 2, 'O'), //'B13', $x('A', 7, 'O', 7, true),
                    $x('A', 7, 'O', 7,true)
                ]);

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
                	// 'H3:I6',
                	'A7:C7', 'H7:I7',
                	'A8:C8', 'H8:I8',
                	'A9:C9', 'H9:I9',
                	'A10:C10', 'H10:I10',
                	'A11', 'I11',
                	'A12', 'D12', 'F12', 'H12',
                	'A13:C21', 'C13:C18', 'H14:H20',
                	'A22:O22',
                	$x('A', 1, 'O', 2)
                ];

                foreach($fills as $fill){
                	$event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle);	
                }

                // BORDERS
                $cells = array_merge($fdRows, $ssRows, [
                    // 'H3:I6','J3:L6',
                    'M3:O10',
                	'A7:C7', 'H7:I7', 'D7:G7', 'J7:L7',
                	'A8:C8', 'H8:I8', 'D8:G8', 'J8:L8',
                	'A9:C9', 'H9:I9', 'D9:G9', 'J9:L9', 'L9',
                	'A10:C10', 'H10:I10', 'D10:G10', 'J10:L10', 'L10',
                	'A11:H11', 'I11:O11',
                	'A12:C12', 'D12:E12', 'F12:G12', 'H12:I13', 'J12:O13',

                	'A15:C16', 'C15', 'D13:E13', 'F13:G14',
                	'C16', 'D14:E14', 'F14:G14', 'H14:I14', 'J14:O14',

                	'A17:B18', 'C17', 'C18', 'D15:E15', 'F15:G15', 'H15:I15', 'J15:O15',
                	'D16:E16', 'F16:G16', 'H16:I16', 'J16:O16',

                	'A19:B20', 'C19', 'C20', 'D17:E17', 'F17:G17', 'H17:I17', 'J17:O17',
                	'D18:E18', 'F18:G18', 'H18:I18', 'J18:O18',

                	'A13:C13', 'D19:E19', 'F19:G19', 'H19:I19', 'J19:O19',
                	'A14:C14', 'D20:E20', 'F20:G20', 'H20:I20', 'J20:O20',

                	'A21:O21', 'A22:B22', 'C22:D22', 'E22:F22', 'G22', 'H22', 'I22:K22', 'L22:M22', 'N22:O22',
                	$x('A', 1, 'O'),

                	$x('A', 2, 'A', 3), $x('B', 2, 'D', 3), $x('E', 2, 'E', 3), $x('F', 2, 'F', 3),
                	$x('G', 2, 'G', 3), $x('H', 2, 'H', 3), $x('I', 2, 'J', 3), $x('K', 2, 'K', 3),
                	$x('L', 2, 'M', 3), $x('N', 2, 'O', 3),

                    $x('I', 3, 'K', 3, true), $x('M', 3, 'N', 3, true), $x('L', 3, '', '', true), $x('O', 3, '', '', true),
                    $x('I', 4, 'O', 4, true),
                    $x('I', 5, 'O', 5, true),
                    $x('I', 10, 'N', 10, true),
                ]);

                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[0]);
                }

                $size = sizeof($ssRows);

                for($i = 0; $i < $size; $i+=14){
                    $event->sheet->getDelegate()->getStyle($ssRows[($i + 3)])->applyFromArray($borderStyle[1]);
                    $event->sheet->getDelegate()->getStyle($ssRows[($i + 7)])->applyFromArray($borderStyle[1]);
                    $event->sheet->getDelegate()->getStyle($ssRows[($i + 9)])->applyFromArray($borderStyle[1]);
                    $event->sheet->getDelegate()->getStyle($ssRows[($i + 11)])->applyFromArray($borderStyle[1]);
                }

                for($i = 0; $i < $size; $i+=14){
                    $event->sheet->getDelegate()->getStyle($ssRows[($i + 4)])->applyFromArray($borderStyle[2]);
                    $event->sheet->getDelegate()->getStyle($ssRows[($i + 8)])->applyFromArray($borderStyle[2]);
                    $event->sheet->getDelegate()->getStyle($ssRows[($i + 10)])->applyFromArray($borderStyle[2]);
                    $event->sheet->getDelegate()->getStyle($ssRows[($i + 12)])->applyFromArray($borderStyle[2]);
                }
                
                $event->sheet->getDelegate()->getStyle("A3:" . $x('O', 11, '', '', true))->applyFromArray($borderStyle[3]);

                // FOR THE CHECK
                $event->sheet->getDelegate()->getStyle($x('L', 3, '', '', true))->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle($x('O', 3, '', '', true))->getFont()->setName('Marlett');

                foreach(['D7', 'J7', $x('A', 1, 'O')] as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize(14);
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->getColor()->setRGB('FF0000');
                }

                // COLUMN RESIZE

                // $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(9.7);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(6.9);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(5.5);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(4);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
        $drawing->setPath(public_path($this->applicant->user->avatar));
        $drawing->setHeight(150);
        // $drawing->setWidth(165);
        $drawing->setOffsetX(1);
        $drawing->setOffsetY(3);
		$drawing->setCoordinates('M3');

        return $drawing;
    }
}
