<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HMMCM1P5 implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $title = "HMM MLC"){
        $this->applicant     = $applicant;
        $this->shipownerA    = [];
        $this->shipownerB    = [];
        $this->shipmanager   = [];

        $array1 = [
            "M/V GLOBAL ENTERPRISE","M/V HMM CEBU",
            'M/V MPV THALIA', 'M/V MPV URANIA',
            'M/V HMM NARU'
        ];

        if(in_array($applicant->vessel->name, $array1)){
            $this->shipowner['company'] = "HMM Company Limited";
            $this->shipowner['president'] = "CHOI WONHYOK";
            $this->shipowner['address'] = "TOWER 1, PARC.1, 108, YEOUI-DAERO, YEONGDEUNGPO-GU, SEOUL, REPUBLIC OF KOREA";

            $this->shipmanager['company'] = "HMM Ocean Service Co., Ltd.";
            $this->shipmanager['address'] = "5TH FLOOR,BUSAN POST OFFICE BUILDING,JUNGANG-DAERO 63, JUNG-GU, BUSAN, REBUBLIC OF KOREA";
        }

        $this->title = $title;
    }

    public function view(): View
    {
        $principal = "hmmcm1p5";
        $exportView = str_replace(' ', '_', $this->applicant->vessel->fleet) . '.' . $principal;
        
        return view('exports.mlc.' . $exportView, [
            'data' => $this->applicant,
            'shipowner' => $this->shipowner,
            'shipmanager' => $this->shipmanager
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
                $event->sheet->getDelegate()->setTitle($this->title, false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.4);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.2);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                $event->sheet->getDelegate()->getPageSetup()->setScale(98);

                //SET FIRST PAGE NUMBER
                $event->sheet->getDelegate()->getPageSetup()->setFirstPageNumber(1);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                $line = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
                $line->setPath(public_path('/images/horizontal_line.png'));
                $line->setHeight(15);

                $event->sheet->getDelegate()->getHeaderFooter()->setOddHeader('&L&G &L&8STANDARD SEAFARER’S EMPLOYMENT AGREEMENT &R&8Ch2.1 / Page &P ');
                // $event->sheet->getDelegate()->getHeaderFooter()->setOddHeader('&L&G &L&8표준근로계약서(STANDARD SEAFARER’S EMPLOYMENT AGREEMENT) &R&I&8Ch.2 / Page &P');
                $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter('&L&G &L&8PC-302/2025.09.10/DCN25005');
                $event->sheet->getDelegate()->getHeaderFooter()->addImage($line);

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));
                
                // SET DEFAULT FONT
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Times New Roman');
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
                    'A44', 'D44'
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    'A44', 'D44', 'A43', 'D43'
                ];

                // HC VC
                $h[4] = [
                    "A3:A4", "A6:A16", 'A18:A20', 'A22:A27', 'B22:H25', 'A29:A31', 'B29:H30'
                ];

                // HL
                $h[5] = [
                    'C16'
                ];

                // B
                $h[6] = [
                    'A3', 'A5', 'A17', 'A21', 'A28', 'A32', 'A34', 'A36', 'A38', 'A40'
                ];

                // VC
                $h[7] = [
                    'A1:H2', 'B6:H16', 'B18:H20', 'B26:B27', 'B31', 'A33', 'A35', 'A37', 'A39', 'A41', 'A45:H46'
                ];

                // UNDERLINE
                $h[8] = [
                    // REMOVED SEP 5 2025
                    // 'A3', 'B9', 'A11:B12', 'A38:A39'
                ];

                // JUSTIFY
                $h[9] = [
                ];

                $h['wrap'] = [
                    'C6', 'G7', 'B18', 'C22', 'E22', 'B23:B25', 'E24', 'A29:B30'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'C7:C15', 'A43', 'D43'
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
                    'A6:H16', 'A18:H20', 'A22:H27', 'A29:H31', 'A45:H46'
                ]);

                // ALL BORDER MEDIUM
                $cells[1] = array_merge([
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                    'A33:H33', 'A35:H35', 'A37:H37', 'A39:H39', 'A41:H41'
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
                    'A43:B43', 'D43:G43'
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(19);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(3);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(22.5);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(14);

                // ROW RESIZE
                $rows = [
                    [
                        27, //ROW HEIGHT
                        1,4 //START ROW, END ROW
                    ],
                    [26,5,31],
                    [18,44,46]
                ];

                $rows2 = [
                    [
                        25,
                        [32,34,36,38,39,40]
                    ],
                    [
                        25,
                        [32,34,36,38,40]
                    ],
                    [80,[20]],[40,[26,27]],[145,[35,37]],[140,[41]],[100,[43]],[65,[33,42]]
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

                $event->sheet->getDelegate()->getStyle('A3')->getFont()->setSize(14);

                //SIZE 8
                $cells = ["G7", "B23:H23", "B25:H25"];
                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize(8);
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setName('Times New Roman');
                }

                //SIZE 9
                $cells = ["B20", "B26:B27", 'A33', 'A35', 'A37', 'A39', 'A41'];
                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize(9);
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setName('Times New Roman');
                }

                //SIZE 10
                $cells = ['A42', 'A45'];
                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize(10);
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setName('Times New Roman');
                }

                //SIZE 11
                $cells = ["A1", "A2", "A5", 'A17', 'A21', 'A28', 'A32', 'A34', 'A36', 'A38', 'A40'];
                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize(11);
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setName('Times New Roman');
                }

                // REMOVED SEP 5, 2025
                // RICH TEXTS
                // $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                // $rt->createTextRun("1. Seafarer/Shipowner/")->getFont()->setBold(true)->setName("Times New Roman")->setSize(11);
                // $rt->createTextRun("Ship Manager")->getFont()->setUnderline(true)->setBold(true)->setName("Times New Roman")->setSize(11);
                // $rt->createTextRun("/Agent/Ship")->getFont()->setBold(true)->setName("Times New Roman")->setSize(11);
                // $event->sheet->getParent()->getActiveSheet()->getCell("A5")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                if($this->applicant->rankType == "OFFICER"){
                    $rt->createTextRun("(Fixed)")->getFont()->setName("Times New Roman")->setSize(10);
                    $rt->createTextRun("Guaranteed")->getFont()->setName("Times New Roman")->setSize(10);
                }
                else{
                    $rt->createTextRun("Fixed")->getFont()->setName("Times New Roman")->setSize(10);
                    $rt->createTextRun("(Guaranteed)")->getFont()->setName("Times New Roman")->setSize(10);
                }
                $rt->createText(PHP_EOL);
                $rt->createTextRun("Overtime Allowance")->getFont()->setName("Times New Roman")->setSize(10);
                $event->sheet->getParent()->getActiveSheet()->getCell("C22")->setValue($rt);

                // $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                // $rt->createTextRun("Provident Fund/")->getFont()->setName("Times New Roman")->setSize(10);
                // $rt->createText(PHP_EOL);
                // $rt->createTextRun("(Contract Completion Bonus)")->getFont()->setName("Times New Roman")->setSize(9);
                // $event->sheet->getParent()->getActiveSheet()->getCell("E24")->setValue($rt);
            },
        ];
    }

    public function drawings()
    {
        $sig = $this->applicant->vessel->fleet == "FLEET B" ? 'images/mlc_hmm_sig.png' : 'images/shirley_sig.png';

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path('images/MLC_SEAL.png'));
        $drawing->setCoordinates("F43");
        $drawing->setHeight(120);
        $drawing->setWidth(120);
        $drawing->setOffsetX(50);
        $drawing->setOffsetY(3);

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setPath(public_path($sig));
        $drawing3->setOffsetX(40);
        $drawing3->setOffsetY(2);
        $drawing3->setCoordinates("D43");
        $drawing3->setResizeProportional(false);
        $drawing3->setHeight(90);
        $drawing3->setWidth(90);

        return [$drawing, $drawing3];
    }
}
