<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class Western implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
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
        $borderStyle = 
        [
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
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ],
            [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ],
            [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
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
        ];

        $fillStyle = [
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'FFCC99'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'CCFFCC'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'CCCCCC'
                    ]
                ],
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
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            [
                'font' => [
                    'bold' => true
                ],
            ],
            [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]
        ];

        $lock = [
            'protection' => [
                'locked' => \PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED
            ]
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle, $lock) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('Nitta Kisen - Biodata', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                $event->sheet->getDelegate()->getStyle('A1:AJ150')->getFont()->setSize(10);
                $event->sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);

                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

                // FONT SIZES

                // EDUCATION ROWS
                $ebSize = sizeof($this->applicant->educational_background);
                $ebRows = '';

                if($ebSize){
                    $ebRows = 'A23:' . 'AH' . (22 + $ebSize);
                }

                // SEA SERVICE ROWS
                $ssSize = sizeof($this->applicant->sea_service);
                $ssRows = '';
                $sSsRows = [];
                $sSsRows2 = [];

                if($ssSize){
                    $ssRows = 'A' . (105 + $ebSize) . ':' . 'AH' . (104 + $ebSize + ($ssSize * 2));
                }

                $ctr = 103;
                for($i = 0; $i <= sizeof($this->applicant->sea_service); $i++){
                    array_push($sSsRows, 'A' . ($ctr + $ebSize) . ':' . 'F' . ($ctr + $ebSize));
                    array_push($sSsRows, 'G' . ($ctr + $ebSize) . ':' . 'J' . ($ctr + $ebSize));
                    array_push($sSsRows, 'K' . ($ctr + $ebSize) . ':' . 'P' . ($ctr + $ebSize));
                    array_push($sSsRows, 'W' . ($ctr + $ebSize) . ':' . 'AB' . ($ctr + $ebSize));

                    array_push($sSsRows2, 'A' . ($ctr + $ebSize + 1) . ':' . 'F' . ($ctr + $ebSize + 1));
                    array_push($sSsRows2, 'G' . ($ctr + $ebSize + 1) . ':' . 'J' . ($ctr + $ebSize + 1));
                    array_push($sSsRows2, 'K' . ($ctr + $ebSize + 1) . ':' . 'P' . ($ctr + $ebSize + 1));
                    array_push($sSsRows2, 'Q' . ($ctr + $ebSize) . ':' . 'V' . ($ctr + $ebSize + 1));
                    array_push($sSsRows2, 'W' . ($ctr + $ebSize + 1) . ':' . 'AB' . ($ctr + $ebSize + 1));
                    array_push($sSsRows2, 'AC' . ($ctr + $ebSize) . ':' . 'AH' . ($ctr + $ebSize + 1));

                    $ctr+=2;
                }

                // FUNCTIONS
                $ar = function($c1, $r1, $c2 = null, $r2 = null) use($ebSize){
                    $temp = $c1 . ($r1 + $ebSize);
                    if($c2 != null){
                        $temp .= ':' . $c2 . ($r2 + $ebSize);
                    }

                    return $temp;
                };

                $fillables = [
                    $ar('F', 25, 'AH', 29), $ar('K', 32, 'AH', 38),
                    $ar('K', 41, 'AH', 71)
                ];

                // FILLS
                $fills[0] = [
                    'A1:AH11', 'A12:' . $ar('AH', (104 + ($ssSize *2) + 8))
                ];

                $fills[1] = array_merge($fillables, [
                    'P9:AA9', 'AA11:AH11', 'E13:H13', 'K13:N13', 'T13:W13', 'AA13:AH13', 'C14:L14', 'N14:W14', 'Y14:AH14', 'D16:Y16', 'AD16:AH16', 'D17:Y17', 'AD17:AH16', 'E18:J18', 'M18:N18', 'S18:Y18', 'AD18:AH18', 'E19:J19', 'N19:P19', 'U19:W19', 'AD19:AH19', 'D20:J20', 'M20:Q20', 'V20:W20', 'AE20:AH20', $ar('K', 74, 'AH', 80), $ar('AC', 83, 'AC', 84), $ar('AC', 86, 'AC', 87), $ar('L', 90, 'AH', 92), $ar('AC', 95), $ar('AC', 97, 'AC', 101), $ssRows, $ar('A', (106 + ($ssSize * 2))), $ar('K', (110 + ($ssSize * 2))), $ar('H', (112 + ($ssSize * 2))), $ar('W', (112 + ($ssSize * 2)))
                ]);

                if($ebRows != ""){
                    array_push($fills[1], $ebRows);
                }

                $fills[2] = [
                    'AA1:AH1', 'A22:AH22', $ar('A', 24, 'AH', 24), $ar('A', 31, 'AH', 31), $ar('A', 40, 'AH', 40), $ar('A', 52, 'AH', 52), $ar('A', 73, 'AH', 73), $ar('A', 82, 'AH', 82), $ar('A', 85, 'AH', 85), $ar('A', 89, 'AH', 89), $ar('A', 94, 'AH', 94), $ar('A', 97, 'N', 101), $ar('A', 103, 'AH', 104)
                ];

                foreach($fills as $key => $value){
                    foreach($value as $fill){
                        $event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle[$key]);  
                    }
                }

                // HEADINGS

                // HC B
                $h[0] = [
                    
                ];

                // VT
                $h[1] = [
                    
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = array_merge($fills[1], $fillables, [
                    'A1:AH15', 'A22:' . $ar('AH', 22), $ar('A', 24, 'AH', 24), $ar('A', 36), $ar('A', 56), $ar('A', (103 + ($ssSize * 2) + 6)), $ar('A', (103 + ($ssSize * 2) + 8)), $ar('P', (103 + ($ssSize * 2) + 8)), $ar('A', 31, 'AH', 31), $ar('A', 40, 'AH', 40), $ar('A', 52, 'AH', 52), $ar('A', 73, 'AH', 73), $ar('A', 82, 'AH', 82), $ar('A', 85, 'AH', 85), $ar('A', 90, 'AH', 89), $ar('A', 94, 'AH', 94), $ar('A', 103, 'AH', 104)
                ]);

                // HL
                $h[4] = [
                    
                ];

                // HC VC
                $h[5] = [
                    
                ];

                // B
                $h[6] = [
                    'A21', $ar('A', 23), $ar('A', 30), $ar('A', 39), $ar('A', 51), $ar('A', 72), $ar('A', 77), $ar('A', 88), $ar('A', 93), $ar('A', 96), $ar('A', 102), $ar('A', (104 + ($ssSize * 2) + 1)), $ar('A', (104 + ($ssSize * 2) + 6)), $ar('AB', (104 + ($ssSize * 2) + 9))
                ];

                // VC
                $h[7] = [
                    'A1:AJ155',
                ];

                $h['wrap'] = [
                    $ar('A', 60), $ar('A', 61), $ar('A', 62)
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    $ar('A', 25, 'K', 71), $ar('K', 105, 'K', (105 + ($ssSize * 2))), 'S18', $ar('AC', 25, 'AC', 103), $ar('F', 25, 'F', 32), $ar('A', 104, 'A', (104 + ($ssSize * 2))), $ar('G', 104, 'G', (104 + ($ssSize * 2))), $ar('Q', 104, 'V', (104 + ($ssSize * 2)))
                ];

                foreach($h as $key => $value) {
                    foreach($value as $col){
                        if($key === 'wrap'){
                            $event->sheet->getDelegate()->getStyle($col)->getAlignment()->setWrapText(true);
                        }
                        elseif($key == 'stf'){
                            $event->sheet->getDelegate()->getStyle($col)->applyFromArray([
                                'alignment' => [
                                    'shrinkToFit' => true
                                ],
                            ]);
                        }
                        else{
                            $event->sheet->getDelegate()->getStyle($col)->applyFromArray($headingStyle[$key]);
                        }
                    }
                }

                // UNLOCK CELLS
                foreach($fills[1] as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($lock);
                }

                // BORDERS
                $cells[0] = array_merge([
                    'A1:H11', $ar('A', (104 + ($ssSize *2) + 4), 'AH', (104 + ($ssSize *2) + 8))
                ]);

                $cells[1] = array_merge([
                    'AA1:AH4', 'A22:' . $ar('AH', 102), $ar('A', (104 + ($ssSize *2) + 1), 'AH', (104 + ($ssSize *2) + 4))
                ]);

                $cells[2] = array_merge([
                    'P9:AA9', 'AA11:AH11', 'E13:H13', 'K13:N13', 'T13:W13', 'AA13:AH13', 'C14:L14', 'N14:W14', 'Y14:AH14', 'D16:Y16', 'AD16:AH16', 'D17:Y17', 'AD17:AH17', 'E18:J18', 'M18:N18', 'S18:Y18', 'AD18:AH18', 'E19:J19', 'N19:P19', 'U19:W19', 'AD19:AH19', 'D20:J20', 'M20:Q20', 'V20:W20', 'AE20:AH20'
                ]);

                $cells[3] = $sSsRows;
                $cells[4] = $sSsRows2;

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $columns = [
                    'A', 'B', 'D', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                    'AB', 'AD', 'AF', 'AH'
                ];

                foreach($columns as $col){
                    $event->sheet->getDelegate()->getColumnDimension($col)->setWidth(3);
                }

                $columns = ['C', 'E'];

                foreach($columns as $col){
                    $event->sheet->getDelegate()->getColumnDimension($col)->setWidth(4.3);
                }

                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(3.6);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(3.6);
                $event->sheet->getDelegate()->getColumnDimension('AA')->setWidth(4.5);
                $event->sheet->getDelegate()->getColumnDimension('AC')->setWidth(4.3);
                $event->sheet->getDelegate()->getColumnDimension('AE')->setWidth(4.3);
                $event->sheet->getDelegate()->getColumnDimension('AG')->setWidth(3.7);

                $event->sheet->getDelegate()->getRowDimension(61 + $ebSize)->setRowHeight(43.50);
                $event->sheet->getDelegate()->getRowDimension(62 + $ebSize)->setRowHeight(30);

                // FORMAT CELLS
                $event->sheet->getDelegate()->getStyle('D20')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
                $event->sheet->getDelegate()->getStyle('M20')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
                $event->sheet->getDelegate()->getStyle($ar('K', 25, 'AH', 71))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

                // SETTING PRINT AREA
                $event->sheet->getDelegate()->getPageSetup()->setPrintArea('A1:' . $ar('AH', (104 + ($ssSize * 2)) + 8));
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path($this->applicant->user->avatar));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(219);
        $drawing->setWidth(186);
        // $drawing->setOffsetX(3);
        // $drawing->setOffsetY(3);
        $drawing->setCoordinates('A1');

        return $drawing;
    }
}