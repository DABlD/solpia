<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KSSLine1 implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $title){
        $this->data     = $data;
        $this->title     = $title;
    }

    public function view(): View
    {
        $exportView = str_replace(' ', '_', $this->data->vessel->fleet) . '.' . 'kssline';

        return view('exports.mlc.' . $exportView, [
            'data' => $this->data,
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
                        'rgb' => 'B8CCE4'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'D9D9D9'
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
                $event->sheet->getDelegate()->setTitle($this->title ?? 'MLC Contract', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.3);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter('&LKSQ-4113D / 2024.01.01 / RETENTION:permanent &RKSS LINE LTD.');
                $event->sheet->getDelegate()->getHeaderFooter()->setEvenFooter('&LKSQ-4113D / 2024.01.01 / RETENTION:permanent &RKSS LINE LTD.');

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));
                
                // SET DEFAULT FONT
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('맑은 고딕');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(9);

                $event->sheet->getDelegate()->getPageSetup()->setScale(85);

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
                    'A43:C43','F43:H43', 'F44'
                ];

                // HC VC
                $h[4] = [
                    'A1:A3', 'A6:I14', 'A16:I17', 'A19:I32',
                    'A33:A37',
                ];

                // HL
                $h[5] = [
                    'B16:B17',
                    'C21:C29', 'B31:B32'
                ];

                // B
                $h[6] = [
                    'A1', 'A43:I44'
                ];

                // VC
                $h[7] = [
                    'B33:B37', 'A39:I41'
                ];

                // UNDERLINE
                $h[8] = [
                    'A1'
                ];

                // JUSTIFY
                $h[9] = [
                    'A39'
                ];

                $h['wrap'] = [
                    'B6', 'B8', 'C23', 'A31', 'A33:B37', 'A39'
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
                    'C10', 'G10', 'G11', 'B17', 'E19', 'D20:E20', 'G20:I20'
                ];

                $fills[1] = [
                    'C12:C14', 'G13:G14', 'F21:G29'
                ];

                foreach($fills as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($fillStyle[$key]);
                    }
                }

                // BORDERS

                // ALL BORDER THIN
                $cells[0] = array_merge([
                    'A6:I14', 'A16:I17', 'A19:I32', 'A33:I37'
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
                    'B43:C43', 'G43:H43'
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(11.5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(11.5);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(11.5);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(11.5);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(11.5);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(11.5);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(11.5);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(11.5);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(11.5);

                // ROW RESIZE
                $rows = [
                    // [
                    //     12, //ROW HEIGHT
                    //     1,4 //START ROW, END ROW
                    // ],
                    [25,6,14],[25,16,17],
                    [17,19,30],
                ];

                $rows2 = [
                    // [
                    //     40,
                    //     [11,14,17,20]
                    // ]
                    [20, [15,18]],
                    [130, [31,36]],
                    [50, [32,38,42]],
                    [193,[33]],
                    [210,[34]],
                    [60,[35]],
                    [23,[23]],
                    [30,[37]],
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
                $rows = [32];
                foreach($rows as $row){
                    $event->sheet->getParent()->getActiveSheet()->setBreak('A' . $row, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                }
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setSize(14);
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setName('Arial');
                $cells = ["B31:B32"];
                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setSize(9);
                    $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setName('맑은 고딕');
                }

                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(16);

                // rich texts
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("C) Leave pay (9days)ㅤㅤ")->getFont()->setSize(9);
                $rt->createTextRun("*See Note below 'Paid Leave'")->getFont()->setSize(8);
                $event->sheet->getParent()->getActiveSheet()->getCell("C23")->setValue($rt);
                $event->sheet->getDelegate()->getStyle('C23')->getFont()->setName('맑은 고딕');

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("I) FKSU Member fee ")->getFont()->setSize(9);
                $rt->createTextRun("(Deducted from crew wage)")->getFont()->setSize(8);
                $event->sheet->getParent()->getActiveSheet()->getCell("C29")->setValue($rt);
                $event->sheet->getDelegate()->getStyle('C29')->getFont()->setName('맑은 고딕');

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Shipowner provides medical care, sickness benefit, employment injury benefit, maternity benefit, retirement benefit, invalidity benefit and survivors' benefit, death and funeral benefit to the seafarer in accordance with the collective bargaining agreement(")->getFont()->setSize(9);
                $rt->createTextRun(" IBF-FKSU-CA ")->getFont()->setBold(true)->setSize(9);
                $rt->createTextRun(") or POEA Term and Conditions or national regulations")->getFont()->setSize(9);
                $event->sheet->getParent()->getActiveSheet()->getCell("B35")->setValue($rt);
                $event->sheet->getDelegate()->getStyle('B35')->getFont()->setName('맑은 고딕');

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("1. Shipowner shall promptly repatriate the seafarer who leaves a ship at the place of which is not the seafarer's country of residence or the place at which the seafarer agreed to enter into the engagement as ship owner's expenses to place where seafare’s residence or where the seafarer agreed to enter into the engagement or where seafarer want to repatriated . However, in case where ship owner paid the expense of repatriation according to the request of seafarer, shipowner does not have any responsibility for the repatriation. Provided that, this shall not apply where the ship owner reimburses expenses incurred in the repartriation at the request of the seafarer. The details will apply the seafarer’s Act.")->getFont()->setSize(9);
                $rt->createText(PHP_EOL);
                $rt->createText(PHP_EOL);
                $rt->createTextRun("2. Maximum period of uninterrupted service on board, upon termination of which Seafarers shall be entitled to be repatriated. : such periods less than ")->getFont()->setSize(9);
                $rt->createTextRun("11 Months.")->getFont()->setBold(true)->setSize(9);
                $event->sheet->getParent()->getActiveSheet()->getCell("B36")->setValue($rt);
                $event->sheet->getDelegate()->getStyle('B36')->getFont()->setName('맑은 고딕');

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Any facts which are not defined in this contract, these are complied with Flag state regulation, Seafarer’s Act(Korea) or the collective bargaining agreement(")->getFont()->setSize(9);
                $rt->createTextRun(" IBF-FKSU-CA ")->getFont()->setBold(true)->setSize(9);
                $rt->createTextRun(") or POEA Term and Conditions")->getFont()->setSize(9);
                $event->sheet->getParent()->getActiveSheet()->getCell("B37")->setValue($rt);
                $event->sheet->getDelegate()->getStyle('B37')->getFont()->setName('맑은 고딕');
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path("images/shirley_sig.png"));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(60);
        $drawing->setWidth(130);
        $drawing->setOffsetY(-30); 
        $drawing->setCoordinates('G43');

        // $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        // $drawing2->setName('Avatar');
        // $drawing2->setDescription('Avatar');
        // $drawing2->setPath(public_path($this->data->user->avatar));
        // $drawing2->setResizeProportional(false);
        // $drawing2->setHeight(230);
        // $drawing2->setWidth(230);
        // $drawing2->setOffsetX(5);
        // $drawing2->setOffsetY(2);
        // $drawing2->setCoordinates('C3');

        return [$drawing];
    }
}
