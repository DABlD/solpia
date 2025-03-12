<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KLCSMBULK implements FromView, WithEvents, WithColumnFormatting, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $title){
        $data->official_no = "-";
        
        if($data->vessel->name == "M/V CH BELLA"){
            $data->official_no = "JJR-106189";
        }
        elseif($data->vessel->name == "M/V CH CLARE"){
            $data->official_no = "JJR-102152";
        }
        elseif($data->vessel->name == "M/V CH DORIS"){
            $data->official_no = "JJR-105192";
        }
        elseif($data->vessel->name == "M/V CK ANGIE"){
            $data->official_no = "JJR-111063";
        }
        elseif($data->vessel->name == "M/V CK BLUEBELL"){
            $data->official_no = "JJR-111067";
        }

        $this->data     = $data;
        $this->title     = $title;
    }

    public function view(): View
    {
        $exportView = str_replace(' ', '_', $this->data->vessel->fleet) . '.klcsmbulk';
        
        return view('exports.mlc.' . $exportView, [
            'data' => $this->data
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
                        'rgb' => 'BDD7EE'
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
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
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
                $event->sheet->getDelegate()->setTitle(str_replace('/', '', $this->title), false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.1);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                $event->sheet->getDelegate()->getHeaderFooter()->setOddHeader('&LDOC/REV.NO.:MLC-FO4/O8 &R2022.10.20');

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));
                
                // SET DEFAULT FONT
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Calibri');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);

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
                    'A148'
                ];

                // HR 
                $h[2] = [
                    'A145', 'A148'
                ];

                // HC
                $h[3] = [
                    'D14:K14', 'E16',
                    'L133', 'L135',
                    'F142', 'F144', 'H147'
                ];

                // HC VC
                $h[4] = [
                    'A1:M10', 'B29:M30',
                    'E63', 'B68:B77', 'C70:C74',
                    'F68', 'F75', 'E70:E74'
                ];

                // HL
                $h[5] = [
                    'A12:A144'
                ];

                // B
                $h[6] = [
                    'A1', 'A3', 'A6',
                    'A12:B12', 'A18:B18', 'A25:B25', 'A27:B27', 'C32:D32', 'A34:B34', 'C36',
                    'C39', 'C49', 'B53', 'B63:I63', 'B65', 'C67', 'F68', 'E70:E74', 'F75',
                    'C81', 'C84', 'B87', 'B104',
                    'B133:M133', 'B135:M135', 'F142:M142', 'F144:M144', 'H147:M147'
                ];

                // VC
                $h[7] = [
                    'C70:M79'
                ];

                // UNDERLINE
                $h[8] = [
                ];

                // JUSTIFY
                $h[9] = [
                ];

                $h['wrap'] = [
                    'A3:M10'
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
                    'A3', 'A6', 'B29:B30', 'J29:J30'
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
                    'A3:M10', 'B29:M30'
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
                    'F68:G68', 'E70:F70', 'E71:F71', 'E72:F72', 'E73:F73', 'E74:F74', 'F75:G75',
                    'L133:M133', 'L135:M135'
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(4.3);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(3.5);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(5.5);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(3.5);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(3.5);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(3.5);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(23);

                // ROW RESIZE
                $rows = [
                    [
                        30, //ROW HEIGHT
                        3,10 //START ROW, END ROW
                    ],
                    [20,68,79]
                ];

                $rows2 = [
                    [
                        40,
                        [1,2]
                    ],
                    [28,[29,30,132,136,146,149]],
                    [70,[38,141,143]], //FOOTERS
                    [150,[80]], //FOOTERS
                    [90,[131,145]], //FOOTERS
                    [220,[154]], //FOOTERS
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
                $rows = [38, 80, 131];
                foreach($rows as $row){
                    $event->sheet->getParent()->getActiveSheet()->setBreak('A' . $row, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                }
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(20);
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle('A39:M131')->getFont()->setSize(11);
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setName('Arial');
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path("images/smcmshipping.png"));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(30);
        $drawing->setWidth(150);
        $drawing->setOffsetX(2);
        $drawing->setOffsetY(60);
        $drawing->setCoordinates('M38');

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setPath(public_path("images/smcmshipping.png"));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(30);
        $drawing2->setWidth(150);
        $drawing2->setOffsetX(2);
        $drawing2->setOffsetY(161);
        $drawing2->setCoordinates('M80');

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setPath(public_path("images/smcmshipping.png"));
        $drawing3->setResizeProportional(false);
        $drawing3->setHeight(30);
        $drawing3->setWidth(150);
        $drawing3->setOffsetX(2);
        $drawing3->setOffsetY(60);
        $drawing3->setCoordinates('M131');

        $drawing4 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing4->setPath(public_path("images/changmyungshipping.png"));
        $drawing4->setResizeProportional(false);
        $drawing4->setHeight(90);
        $drawing4->setWidth(420);
        $drawing4->setOffsetX(-20);
        $drawing4->setOffsetY(2);
        $drawing4->setCoordinates('I143');

        $drawing5 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing5->setPath(public_path("images/MLC_SEAL.png"));
        $drawing5->setResizeProportional(false);
        $drawing5->setHeight(100);
        $drawing5->setWidth(100);
        $drawing5->setOffsetX(50);
        $drawing5->setOffsetY(2);
        $drawing5->setCoordinates('M145');

        $drawing6 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing6->setPath(public_path("images/shirley_sig.png"));
        $drawing6->setResizeProportional(false);
        $drawing6->setHeight(90);
        $drawing6->setWidth(150);
        $drawing6->setOffsetX(50);
        $drawing6->setOffsetY(2);
        $drawing6->setCoordinates('K145');

        $drawing7 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing7->setPath(public_path("images/smcmshipping.png"));
        $drawing7->setResizeProportional(false);
        $drawing7->setHeight(30);
        $drawing7->setWidth(150);
        $drawing7->setOffsetX(2);
        $drawing7->setOffsetY(10);
        $drawing7->setCoordinates('M155');

        return [$drawing, $drawing2, $drawing3, $drawing4, $drawing5, $drawing6, $drawing7];
    }
}