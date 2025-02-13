<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HMMCM2 implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $title = "HMM MLC"){
        $this->applicant     = $applicant;
        $this->shipownerA    = [];
        $this->shipownerB    = [];
        $this->shipmanager   = [];

        $array1 = [
            "M/V HMM HARMONY","M/V HMM MASTER","M/V HMM MIRACLE","M/V HYUNDAI ANTWERP","M/V HYUNDAI ULSAN",
            "M/V HYUNDAI PARAMOUNT","M/V ATLANTIC AFFINITY","M/V OCEAN FLORA","M/V PACIFIC CHAMP",
            "M/T ORIENTAL AQUAMARINE", "M/T UNIVERSAL CHALLENGER", "M/T UNIVERSAL FRONTIER", "M/T UNIVERSAL INNOVATOR"
        ];

        if(in_array($applicant->vessel->name, $array1)){
            $this->shipownerA['company'] = "HMM Co., LTD.";
            $this->shipownerA['president'] = "Kim Kyung Bae";
            $this->shipownerA['address'] = "108, Yeouido-daero, Yeongdeungpo-gu, SEOUL, KOREA";

            $this->shipownerB['company'] = "HMM Ocean Service Co., Ltd.";
            $this->shipownerB['president'] = "Kim Gyoubong";
            $this->shipownerB['address'] = "5th Floor, Busan office Building, Jungang-daero 63, Jung-gu, Busan 600-711, Korea";

            $this->shipmanager['company'] = "HMM Ocean Service Co., Ltd.";
            $this->shipmanager['address'] = "5th Floor, Busan office Building, Jungang-daero 63, Jung-gu, Busan 600-711, Korea";
        }

        $this->title = $title;
    }

    public function view(): View
    {
        $principal = "hmmcm2";
        $exportView = str_replace(' ', '_', $this->applicant->vessel->fleet) . '.' . $principal;
        
        return view('exports.mlc.' . $exportView, [
            'data' => $this->applicant,
            'shipownerA' => $this->shipownerA,
            'shipownerB' => $this->shipownerB,
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
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.4);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.2);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);

                //SET FIRST PAGE NUMBER
                $event->sheet->getDelegate()->getPageSetup()->setFirstPageNumber(1);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                $line = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
                $line->setPath(public_path('/images/horizontal_line.png'));
                $line->setHeight(15);

                $event->sheet->getDelegate()->getHeaderFooter()->setOddHeader('&L&G &L&8표준근로계약서(STANDARD SEAFARER’S EMPLOYMENT AGREEMENT) &R&I&8Ch.2 / Page &P');
                $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter('&L&G &L&8PC-302/2022.01.26/DCN22001');
                $event->sheet->getDelegate()->getHeaderFooter()->addImage($line);

                // HEADERS FOOTERS
                // $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
                // $drawing->setPath(public_path('images/horizontal_line.png'));
                // $drawing->setHeight(2);
                // $drawing->setWidth(500);

                // $event->sheet->getDelegate()->getHeaderFooter()->setImages([$drawing]);

                // $event->sheet->getDelegate()->getHeaderFooter()->setOddHeader("&L&G &L&8표준근로계약서(STANDARD SEAFARER’S EMPLOYMENT AGREEMENT) &R&I&8Ch.2 / Page &P");
                // $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter("&L&8PC-302/2022.01.26/DCN22001");

                // $event->sheet->getDelegate()->getHeaderFooter()->setEvenHeader("&L&8표준근로계약서(STANDARD SEAFARER’S EMPLOYMENT AGREEMENT) &R&I&8Ch.2 / Page &P");
                // $event->sheet->getDelegate()->getHeaderFooter()->setEvenFooter("&L&8PC-302/2022.01.26/DCN22001");

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

                // TEXT INDENT
                // $event->sheet->getDelegate()->getStyle('A6:K19')->getAlignment()->setIndent(1);

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
                    'A47:K47'
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    'A6:A19', 'A47:K47', 'A46', 'F46'
                ];

                // HC VC
                $h[4] = [
                    'A3:A4', 'A21:A23', 'A25:K28', 'A29:A30', 'A32:K34'
                ];

                // HL
                $h[5] = [
                    'E19', 'B34'
                ];

                // B
                $h[6] = [
                    'A3', 'A5', 'A20', 'A24', 'A31', 'A35', 'A37', 'A39', 'A41', 'A43'
                ];

                // VC
                $h[7] = [
                    'A1:B4', 'A6:K19', 'B21:K23', 'B29:B30', 'A48:K49'
                ];

                // UNDERLINE
                $h[8] = [
                    'A3', 'B8:D13', 'A14:D15'
                ];

                // JUSTIFY
                $h[9] = [
                ];

                $h['wrap'] = [
                    'J7', 'A25:K28', 'B21', 'A32', 'B33'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'A6', 'A7', 'E6:E18', 'F47', 'A46', 'F46'
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
                    'A6:K19', 'A21:K23', 'A25:K30', 'A32:K34', 'A36:K36', 'A38:K38', 'A40:K40', 'A42:K42', 'A44:K44', 'A48:K49'
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
                    'A46:C46', 'F46:J46'
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(6.5);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(14.5);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(6.5);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(6.5);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(16.5);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(8.5);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(9.7);

                // ROW RESIZE
                $rows = [
                    [
                        27, //ROW HEIGHT
                        1,4 //START ROW, END ROW
                    ],
                    [25,5,28],
                    [27,31,36],
                    [18,48,49],
                ];

                $rows2 = [
                    [
                        90, //ROW HEIGHT
                        [23] //CELLS
                    ],
                    [40,[29]], [27,[30,37,39,41,42,43,45,47]], [135,[38]], [145, [40]], [105, [44]], [110,[46]]
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
                $rows = ['A28', 'A44'];
                foreach($rows as $row){
                    $event->sheet->getParent()->getActiveSheet()->setBreak('A' . $row, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                }
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                // HMM PARAHRAPH CELLS
                $cells = ["B23", 'A25', 'B29:B30', 'A34', 'A36', 'A38', 'A40', 'A42', 'A44', 'A45', 'A48'];
                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize(9);
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setName('Times New Roman');
                }

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('A3')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle('A5')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('J7')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('A20')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('B26:K26')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('B28:K28')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('A25')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('A44')->getFont()->setSize(8.7);
                $event->sheet->getDelegate()->getStyle('A45')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('A48')->getFont()->setSize(10);

                // RICH TEXTS
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("1. Seafarer/Shipowner/")->getFont()->setBold(true)->setName("Times New Roman")->setSize(11);
                $rt->createTextRun("Ship Manager")->getFont()->setUnderline(true)->setBold(true)->setName("Times New Roman")->setSize(11);
                $rt->createTextRun("/Agent/Ship")->getFont()->setBold(true)->setName("Times New Roman")->setSize(11);
                $event->sheet->getParent()->getActiveSheet()->getCell("A5")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createText("2.1.2 PHILIPPINE CREW");
                $rt->createTextRun("(Non Korea Flag Vessel)")->getFont()->setUnderline(true)->setName("Times New Roman")->setSize(10);
                $event->sheet->getParent()->getActiveSheet()->getCell("A2")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                if($this->applicant->rankType == "OFFICER"){
                    $rt->createTextRun("(Fixed)")->getFont()->setUnderline(true)->setName("Times New Roman")->setSize(10);
                    $rt->createTextRun("/Guaranteed")->getFont()->setName("Times New Roman")->setSize(10);
                }
                else{
                    $rt->createTextRun("Fixed/")->getFont()->setName("Times New Roman")->setSize(10);
                    $rt->createTextRun("(Guaranteed)")->getFont()->setUnderline(true)->setName("Times New Roman")->setSize(10);
                }
                $rt->createText(PHP_EOL);
                $rt->createTextRun("Overtime Allowance")->getFont()->setName("Times New Roman")->setSize(10);
                $event->sheet->getParent()->getActiveSheet()->getCell("E25")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Provident Fund/")->getFont()->setName("Times New Roman")->setSize(10);
                $rt->createText(PHP_EOL);
                $rt->createTextRun("(Contract Completion Bonus)")->getFont()->setUnderline(true)->setName("Times New Roman")->setSize(9);
                $event->sheet->getParent()->getActiveSheet()->getCell("H27")->setValue($rt);

                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setSize(14);
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setName('Arial');
            },
        ];
    }

    public function drawings()
    {
        $sig = $this->applicant->vessel->fleet == "FLEET B" ? 'images/mlc_hmm_sig.jpg' : 'images/shirley_sig.png';

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path('images/MLC_SEAL.png'));
        $drawing->setCoordinates("I46");
        $drawing->setHeight(130);
        $drawing->setWidth(130);
        $drawing->setOffsetX(35);
        $drawing->setOffsetY(3);

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setName('mlc_hmm_sig');
        $drawing3->setDescription('mlc_hmm_sig');
        $drawing3->setPath(public_path($sig));
        $drawing3->setOffsetX(2);
        $drawing3->setOffsetY(2);
        $drawing3->setCoordinates("F46");
        $drawing3->setResizeProportional(false);
        $drawing3->setHeight(120);
        $drawing3->setWidth(130);

        return [$drawing, $drawing3];
    }
}
