<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class X46_NewHireEncodingCompletion implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $type){
        $this->data     = $data;
        $this->type     = $type;
    }

    public function view(): View
    {
        return view('exports.forms.' . lcfirst($this->type), [
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
                        'rgb' => 'bdb9b9'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'ebf8a4'
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
                // $event->sheet->getDelegate()->setTitle('', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));
                
                // SET DEFAULT FONT
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Aptos (Body)');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(11);

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
                    'A16'  
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    'A2',
                    'A4:A7', 'A9:A15', 'A19:A23'
                ];

                // HC VC
                $h[4] = [
                    'A2'
                ];

                // HL
                $h[5] = [
                ];

                // B
                $h[6] = [
                    'A2:A23'
                ];

                // VC
                $h[7] = [
                    'A1:B23'
                ];

                // UNDERLINE
                $h[8] = [
                ];

                // JUSTIFY
                $h[9] = [
                ];

                $h['wrap'] = [
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
                ];

                $fills[1] = [
                    
                ];

                foreach($fills as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($fillStyle[$key]);
                    }
                }

                // BORDERS

                // ALL BORDER THIN
                $cells[0] = array_merge([
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(80);

                // ROW RESIZE
                $rows = [
                    [
                        25, //ROW HEIGHT
                        1,23 //START ROW, END ROW
                    ],
                ];

                $rows2 = [
                    // [
                    //     70,
                    //     [17]
                    // ],
                    [
                        70,
                        [1,17]
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
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setSize(14);
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setName('Arial');

                // RICH TEXTS
                $temp = $event->sheet->getParent()->getActiveSheet()->getCell("B4")->getValue();
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp . ' ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun(str_pad($this->data->user->namefull, (70 - mb_strlen($temp)), " ", STR_PAD_BOTH))->getFont()->setUnderline(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("B4")->setValue($rt);

                $temp = $event->sheet->getParent()->getActiveSheet()->getCell("B5")->getValue();
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp . ' ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun(str_pad(optional($this->data->pro_app->rank)->abbr ?? "\u{00A0}", (70 - mb_strlen($temp)), " ", STR_PAD_BOTH))->getFont()->setUnderline(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("B5")->setValue($rt);

                $temp = $event->sheet->getParent()->getActiveSheet()->getCell("B6")->getValue();
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp . ' ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun(str_pad(optional($this->data->pro_app->vessel)->name ?? "\u{00A0}", (70 - mb_strlen($temp)), " ", STR_PAD_BOTH))->getFont()->setUnderline(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("B6")->setValue($rt);

                $temp = $event->sheet->getParent()->getActiveSheet()->getCell("B7")->getValue();
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp . ' ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun(str_pad(optional($this->data->pro_app->eld)->toDateString() ?? "\u{00A0}", (70 - mb_strlen($temp)), " ", STR_PAD_BOTH))->getFont()->setUnderline(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("B7")->setValue($rt);

                $temp = explode(':', $event->sheet->getParent()->getActiveSheet()->getCell("B9")->getValue(), 2);
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp[0] . ': ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun($temp[1]);
                $event->sheet->getParent()->getActiveSheet()->getCell("B9")->setValue($rt);

                $temp = explode(':', $event->sheet->getParent()->getActiveSheet()->getCell("B10")->getValue(), 2);
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp[0] . ': ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun($temp[1]);
                $event->sheet->getParent()->getActiveSheet()->getCell("B10")->setValue($rt);

                $temp = explode(':', $event->sheet->getParent()->getActiveSheet()->getCell("B11")->getValue(), 2);
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp[0] . ': ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun($temp[1]);
                $event->sheet->getParent()->getActiveSheet()->getCell("B11")->setValue($rt);

                $temp = explode(':', $event->sheet->getParent()->getActiveSheet()->getCell("B12")->getValue(), 2);
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp[0] . ': ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun($temp[1]);
                $event->sheet->getParent()->getActiveSheet()->getCell("B12")->setValue($rt);

                $temp = explode(':', $event->sheet->getParent()->getActiveSheet()->getCell("B13")->getValue(), 2);
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp[0] . ': ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun($temp[1]);
                $event->sheet->getParent()->getActiveSheet()->getCell("B13")->setValue($rt);

                $temp = explode(':', $event->sheet->getParent()->getActiveSheet()->getCell("B14")->getValue(), 2);
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp[0] . ': ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun($temp[1]);
                $event->sheet->getParent()->getActiveSheet()->getCell("B14")->setValue($rt);

                $temp = explode(':', $event->sheet->getParent()->getActiveSheet()->getCell("B15")->getValue(), 2);
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp[0] . ': ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun($temp[1]);
                $event->sheet->getParent()->getActiveSheet()->getCell("B15")->setValue($rt);

                $temp = $event->sheet->getParent()->getActiveSheet()->getCell("B19")->getValue();
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp . ' ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun(str_pad(optional($this->data->pro_app->eld)->toDateString() ?? "\u{00A0}", (70 - mb_strlen($temp)), " ", STR_PAD_BOTH))->getFont()->setUnderline(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("B19")->setValue($rt);

                $temp = $event->sheet->getParent()->getActiveSheet()->getCell("B20")->getValue();
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp . ' ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun(str_pad(optional($this->data->pro_app->eld)->toDateString() ?? "\u{00A0}", (70 - mb_strlen($temp)), " ", STR_PAD_BOTH))->getFont()->setUnderline(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("B20")->setValue($rt);

                $temp = $event->sheet->getParent()->getActiveSheet()->getCell("B21")->getValue();
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp . ' ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun(str_pad(optional($this->data->pro_app->eld)->toDateString() ?? "\u{00A0}", (70 - mb_strlen($temp)), " ", STR_PAD_BOTH))->getFont()->setUnderline(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("B21")->setValue($rt);

                $temp = $event->sheet->getParent()->getActiveSheet()->getCell("B22")->getValue();
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp . ' ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun(str_pad(optional($this->data->pro_app->eld)->toDateString() ?? "\u{00A0}", (70 - mb_strlen($temp)), " ", STR_PAD_BOTH))->getFont()->setUnderline(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("B22")->setValue($rt);

                $temp = $event->sheet->getParent()->getActiveSheet()->getCell("B23")->getValue();
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun($temp . ' ')->getFont()->setBold(true)->setSize(12);
                $rt->createTextRun(str_pad(optional($this->data->pro_app->eld)->toDateString() ?? "\u{00A0}", (70 - mb_strlen($temp)), " ", STR_PAD_BOTH))->getFont()->setUnderline(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("B23")->setValue($rt);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Letter Head');
        $drawing->setDescription('Letter Head');
        $drawing->setPath(public_path("images/letter_head.jpg"));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(80);
        $drawing->setWidth(665);
        $drawing->setOffsetX(2);
        $drawing->setOffsetY(2);
        $drawing->setCoordinates('A1');

        return [$drawing];
    }
}
