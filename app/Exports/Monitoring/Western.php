<?php

namespace App\Exports\Monitoring;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Western implements FromView, WithEvents, WithColumnFormatting//, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $vessel){
        $this->data     = $data;
        $this->vessel     = $vessel;
    }

    public function view(): View
    {
        return view('exports.monitoring.toei', [
            'data' => $this->data,
            'vessel' => $this->vessel,
        ]);
    }

    public function registerEvents(): array
    {
        $borderStyle = 
        [
            [//0
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ],
            [//1
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ],
            [//2
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ]
            ],
            [//3
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
            [//4
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ],
            [//5
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
            [//6
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [//7
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [//8
                'borders' => [
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [//9
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [//10
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ]
            ],
            [//11
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ]
            ],
            [//12
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ]
            ],
            [//13
                'borders' => [
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ]
            ],
            [//14
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ]
            ],
        ];

        $fillStyle = [
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'D9D9D9'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'ED7D31'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'FFC000'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'FF99FF'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => '92D050'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'F8CBAD'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'BDD7EE'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => '66FFCC'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => '00B0F0'
                    ]
                ],
            ]
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
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ]
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
            ],
            [
                'font' => [
                    'underline' => true
                ],
            ],
            [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                ],
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->getPageSetup()->setOrientation("landscape");
                $event->sheet->getDelegate()->setTitle('DOCUMENTS.MONITORING', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.1);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                // SET PAGE BREAK PREVIEW
                // $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                // $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));
                
                // SET DEFAULT FONT
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('ARIAL NARROW');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(8);

                // CELL COLOR
                // $event->sheet->getDelegate()->getStyle('E3:E7')->getFont()->getColor()->setRGB('0000FF');

                // TEXT ROTATION
                // $event->sheet->getDelegate()->getStyle('B11')->getAlignment()->setTextRotation(90);

                // FUNCTIONS
                // $osSize = sizeof($this->linedUps);
                // $ofsSize = sizeof($this->onBoards);

                // GET AFTER ONSIGNERS
                // $ar = function($c1, $r1, $c2 = null, $r2 = null, $ofs = false) use($osSize, $ofsSize){
                //     $size = $osSize;
                //     $temp = $c1 . ($r1 + $size);
                //     if($c2 != null){
                //         $temp .= ':' . $c2 . ($r2 + ($size + ($ofs ? $ofsSize : 0)));
                //     }

                //     return $temp;
                // };

                // FONT SIZES

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
                $h[3] = [
                    
                ];

                // HC VC
                $h[4] = [
                    'A3:AJ4',
                    'A5:AJ' . (sizeof($this->data) + 4)
                ];

                // HL
                $h[5] = [
                    'E5:E' . (sizeof($this->data) + 4)
                ];

                // B
                $h[6] = [
                    'B1:C2',
                    'L3:AJ3', 'A4:AJ4',
                ];

                // VC
                $h[7] = [
                    'B2:D4'
                ];

                // UNDERLINE
                $h[8] = [
                    'B1', 'A4:AJ4'
                ];

                // JUSTIFY
                $h[9] = [
                ];

                $h['wrap'] = [
                    'A4:AJ4'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                ];

                foreach($h as $key => $value) {
                    foreach($value as $col){
                        if($key === 'wrap'){
                            $event->sheet->getDelegate()->getStyle($col)->getAlignment()->setWrapText(true);
                        }
                        elseif($key == 'stf'){
                            $event->sheet->getDelegate()->getStyle($col)->getAlignment()->setWrapText(false);
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

                // FILLS
                $fills[0] = [
                    // 'A4:H4', 'K4', 'M4', 'O4:P4', 'R4:AJ4',
                ];

                $fills[1] = [
                    // 'I4:J4', 'L4', 'N4', 'Q4',
                ];

                $fills[2] = [
                    // 'L3:R3'
                ];

                $fills[3] = [
                    // 'S3:Y3'
                ];

                $fills[4] = [
                    // 'Z3:AC3'
                ];

                $fills[5] = [
                    // 'AD3:AG3'
                ];

                $fills[6] = [
                    // 'AH3'
                ];

                $fills[7] = [
                    // 'AI3'
                ];

                $fills[8] = [
                    // 'AJ3'
                ];

                foreach($fills as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($fillStyle[$key]);
                    }
                }

                // BORDERS

                // ALL BORDER THIN
                $cells[0] = array_merge([
                    'L3:AJ3', 'A4:AJ4',
                    'A5:AJ' . (sizeof($this->data) + 4)
                ]);

                // ALL BORDER MEDIUM
                $cells[1] = array_merge([
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                ]);

                // OUTSIDE BORDER MEDIUM
                $cells[4] = array_merge([
                ]);

                // OUTSIDE BORDER THICK
                $cells[5] = array_merge([
                ]);

                // TOP REMOVE BORDER
                $cells[6] = array_merge([
                ]);

                // BRB
                $cells[7] = array_merge([
                ]);

                // LRB
                $cells[8] = array_merge([

                ]);

                // RRB
                $cells[9] = array_merge([
                ]);

                // TRB
                $cells[10] = array_merge([
                ]);

                // TBT - TOP BORDER THIN
                $cells[11] = array_merge([
                ]);

                // BBT
                $cells[12] = array_merge([
                ]);

                // LBT
                $cells[13] = array_merge([
                ]);

                // RBT
                $cells[14] = array_merge([
                ]);
                
                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(45);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('S')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('T')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('U')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('V')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('W')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('X')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('Y')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('Z')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AA')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AB')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AC')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AD')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AE')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AF')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AG')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AH')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AI')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AJ')->setWidth(80);

                // ROW RESIZE
                $rows = [
                    [
                        20, //ROW HEIGHT
                        5,(sizeof($this->data) + 4) //START ROW, END ROW
                    ],
                ];

                $rows2 = [
                    [
                        50,
                        [4]
                    ]
                ];

                foreach($rows as $row){
                    for($i = $row[1]; $i <= $row[2]; $i++){
                        $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight($row[0]);
                    }
                }

                foreach($rows2 as $row){
                    foreach($row[1] as $cell){
                        $event->sheet->getDelegate()->getRowDimension($cell)->setRowHeight($row[0]);
                    }
                }

                // PAGE BREAKS
                $rows = [];
                foreach($rows as $row){
                    $event->sheet->getParent()->getActiveSheet()->setBreak('A' . $row, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                }
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('B1')->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A4:AJ' . (sizeof($this->data) + 4))->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('A4:AJ' . (sizeof($this->data) + 4))->getFont()->setName('Arial Narrow');

                // CONDITIONAL FORMATTING
                // $conditional = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
                // $conditional->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CELLIS);
                // $conditional->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_EQUAL);
                // $conditional->addCondition('"N/A"');
                // $conditional->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                // $conditional->getStyle()->getFill()->getStartColor()->setARGB("999999");
                // $conditional->getStyle()->getFill()->getEndColor()->setARGB("999999");

                // $conditionalStyles = $event->sheet->getDelegate()->getStyle('L5:AI' . (sizeof($this->data) + 4))->getConditionalStyles();
                // $conditionalStyles[] = $conditional;

                // $event->sheet->getDelegate()->getStyle('L5:AJ' . (sizeof($this->data) + 4))->setConditionalStyles($conditionalStyles);

                // CONDITIONAL FOR DATE YELLOW
                $conditional = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
                $conditional->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CELLIS);
                $conditional->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_LESSTHANOREQUAL);
                $conditional->addCondition('TODAY()+45');
                $conditional->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $conditional->getStyle()->getFill()->getStartColor()->setARGB("FF0000");
                $conditional->getStyle()->getFill()->getEndColor()->setARGB("FF0000");

                // CONDITIONAL FORMATTING FOR DATES YELLOW
                $conditional2 = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
                $conditional2->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CELLIS);
                $conditional2->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_LESSTHANOREQUAL);
                $conditional2->addCondition('TODAY()+90');
                $conditional2->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $conditional2->getStyle()->getFill()->getStartColor()->setARGB("FFFF00");
                $conditional2->getStyle()->getFill()->getEndColor()->setARGB("FFFF00");

                $event->sheet->getDelegate()->getStyle('J5:J' . (sizeof($this->data) + 4))->setConditionalStyles([$conditional, $conditional2]);
                $event->sheet->getDelegate()->getStyle('L5:AI' . (sizeof($this->data) + 4))->setConditionalStyles([$conditional, $conditional2]);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_XLSX15,
            'H' => NumberFormat::FORMAT_DATE_XLSX15,
            'J' => NumberFormat::FORMAT_DATE_XLSX15,
            'M' => NumberFormat::FORMAT_DATE_XLSX15,
            'O' => NumberFormat::FORMAT_DATE_XLSX15,
            'P' => NumberFormat::FORMAT_DATE_XLSX15,
            'R' => NumberFormat::FORMAT_DATE_XLSX15,
            'Q' => NumberFormat::FORMAT_NUMBER,
            'U' => NumberFormat::FORMAT_DATE_XLSX15,
            'V' => NumberFormat::FORMAT_DATE_XLSX15,
            'W' => NumberFormat::FORMAT_DATE_XLSX15,
            'X' => NumberFormat::FORMAT_DATE_XLSX15,
            'Y' => NumberFormat::FORMAT_DATE_XLSX15,
            'Z' => NumberFormat::FORMAT_DATE_XLSX15,
            'AA' => NumberFormat::FORMAT_DATE_XLSX15,
            'AB' => NumberFormat::FORMAT_DATE_XLSX15,
            'AC' => NumberFormat::FORMAT_DATE_XLSX15,
            'AD' => NumberFormat::FORMAT_DATE_XLSX15,
            'AE' => NumberFormat::FORMAT_DATE_XLSX15,
            'AF' => NumberFormat::FORMAT_DATE_XLSX15,
            'AG' => NumberFormat::FORMAT_DATE_XLSX15,
            'AH' => NumberFormat::FORMAT_DATE_XLSX15,
            'AI' => NumberFormat::FORMAT_DATE_XLSX15,
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Letter Head');
        $drawing->setDescription('Letter Head');
        $drawing->setPath(public_path("images/letter_head.jpg"));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(115);
        $drawing->setWidth(2200);
        $drawing->setOffsetX(4);
        $drawing->setOffsetY(4);
        $drawing->setCoordinates('C1');

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setName('Avatar');
        $drawing2->setDescription('Avatar');
        $drawing2->setPath(public_path($this->data->user->avatar));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(230);
        $drawing2->setWidth(230);
        $drawing2->setOffsetX(5);
        $drawing2->setOffsetY(2);
        $drawing2->setCoordinates('C3');

        return [$drawing, $drawing2];
    }
}
