<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HMMCM1 implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $title = "HMM MLC"){
        $this->applicant     = $applicant;
        $this->shipownerA    = [];
        $this->shipownerB    = [];
        $this->shipmanager   = [];

        $array1 = [
            "M/V HMM DIAMOND", "M/V HMM OPAL", "M/V HMM SAPPHIRE", "M/V HMM AQUAMARINE",
            "M/V HMM GARNET", "M/V HMM PERIDOT", "M/V HMM LE HAVRE", "M/V HYUNDAI BRAVE",
            "M/V HYUNDAI COURAGE", "M/V HMM ALGECIRAS", "M/V HYUNDAI FAITH", "M/V HYUNDAI FORCE",
            "M/V HMM COPENHAGEN", "M/V HMM GDANSK", "M/V HMM HAMBURG", "M/V HMM OSLO",
            "M/V HMM SOUTHAMPTON", "M/V HMM ST. PETERSBURG", "M/V HYUNDAI GRACE", "M/V HYUNDAI UNITY",
            "M/V HMM COLOMBO", "M/V HMM VICTORY", "M/V HMM PRIDE", "M/V HMM FOREST", "M/V HMM GREEN", "M/V HMM SAGE",
            'M/V HMM JAKARTA', 'M/V HMM LEAF', 'M/V HMM TACOMA', 'M/V HMM JUNIPER', 'M/V HMM IVY', 'M/V HMM CLOVER'
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
        $principal = "hmmcm1";
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
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.4);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.2);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                //SET FIRST PAGE NUMBER
                $event->sheet->getDelegate()->getPageSetup()->setFirstPageNumber(1);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                $line = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
                $line->setPath(public_path('/images/horizontal_line.png'));
                $line->setHeight(15);

                $event->sheet->getDelegate()->getHeaderFooter()->setOddHeader('&L&G &L&8MANNING MANAGEMENT &R&8APP.4 / Page &P');
                $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter('&L&G &L&8PC-305/2024.12.20/DCN24008');
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
                    'A42', 'D42'
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    'A16', 'A41:A42', 'D41:D42'
                ];

                // HC VC
                $h[4] = [
                    'A1:A2', 'A4:A14', 'A18', 'A20:A25', 'B20:H23', 'A27:A29', 'B27:H28'
                ];

                // HL
                $h[5] = [
                    'C14'
                ];

                // B
                $h[6] = [
                    'A1', 'A3', 'A15', 'A19', 'A26', 'A30', 'A32', 'A34', 'A36', 'A38'
                ];

                // VC
                $h[7] = [
                    'A4:H14', 'A16:H17', 'B29', 'A43:H44'
                ];

                // UNDERLINE
                $h[8] = [
                    // 'A9', 'A36:A37',
                ];

                // JUSTIFY
                $h[9] = [
                ];

                $h['wrap'] = [
                    'G5', 'B16', 'C20', 'E20', 'B21:H21', 'B22', 'E22', 'B23:H23', 'A27', 'B28'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'C4:C13'
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
                    'A4:H14', 'A16:H18', 'A20:H25', 'A27:H29', 'A43:H44'
                ]);

                // ALL BORDER MEDIUM
                $cells[1] = array_merge([
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                    'A31:H31', 'A33:H33', 'A35:H35', 'A37:H37', 'A39:H39'
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
                    'A41:B41', 'D41:G41'
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
                        24, //ROW HEIGHT
                        1,32 //START ROW, END ROW
                    ],
                    [18,42,44]
                ];

                $rows2 = [
                    [
                        85, //row height
                        [18] // rows
                    ],
                    [14, [30]],[35, [24,40]], [24,[34,36,37,38]], [125,[33,35]], [180, [39]], [100,[41]],
                    [40, [40]],[95, [41]]
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
                $rows = ["A29"];
                foreach($rows as $row){
                    $event->sheet->getParent()->getActiveSheet()->setBreak('A' . $row, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                }
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setSize(14);
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setName('Arial');

                // SECTIONS
                $event->sheet->getDelegate()->getStyle('A15')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A19')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A26')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A30')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A32')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A34')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A36')->getFont()->setSize(11);

                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle('A3')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A40')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('A40')->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle('A43')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('A43')->getFont()->setName('Times New Roman');

                // HMM PARAHRAPH CELLS SIZE 8
                $cells = ["G5", "B21:H21", "B23:H23", 'B24:B25'];
                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize(8);
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setName('Times New Roman');
                }

                //SIZE 8.5
                $cells = ['A33', 'A35'];
                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize(8.5);
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setName('Times New Roman');
                }

                //SIZE 9
                $cells = ["B18", 'A31', 'A37', 'A39'];
                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize(9);
                    $event->sheet->getDelegate()->getStyle($cell)->getFont()->setName('Times New Roman');
                }

                // RICH TEXTS
                // $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                // $rt->createTextRun("1. Seafarer/Shipowner/")->getFont()->setBold(true)->setName("Times New Roman")->setSize(11);
                // $rt->createTextRun("Ship Manager")->getFont()->setUnderline(true)->setBold(true)->setName("Times New Roman")->setSize(11);
                // $rt->createTextRun("/Agent/Ship")->getFont()->setBold(true)->setName("Times New Roman")->setSize(11);
                // $event->sheet->getParent()->getActiveSheet()->getCell("A3")->setValue($rt);

                // $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                // if($this->applicant->rankType == "OFFICER"){
                //     $rt->createTextRun("(Fixed)")->getFont()->setUnderline(true)->setName("Times New Roman")->setSize(10);
                //     $rt->createTextRun("/Guaranteed")->getFont()->setName("Times New Roman")->setSize(10);
                // }
                // else{
                //     $rt->createTextRun("Fixed/")->getFont()->setName("Times New Roman")->setSize(10);
                //     $rt->createTextRun("(Guaranteed)")->getFont()->setUnderline(true)->setName("Times New Roman")->setSize(10);
                // }
                // $rt->createText(PHP_EOL);
                // $rt->createTextRun("Overtime Allowance")->getFont()->setName("Times New Roman")->setSize(10);
                // $event->sheet->getParent()->getActiveSheet()->getCell("C20")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Provident Fund/")->getFont()->setName("Times New Roman")->setSize(10);
                $rt->createText(PHP_EOL);
                $rt->createTextRun("(Contract Completion Bonus)")->getFont()->setName("Times New Roman")->setSize(9);
                $event->sheet->getParent()->getActiveSheet()->getCell("E22")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $text = "Any facts which are not defined in this agreement, these are complied with the law of flag state or Applicable collective bargaining agreement.";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);

                if($this->applicant->vessel->id == 39){
                    $text = "※  As per 2022 amendments to MLC 2006, Standard A 2.1.7 / A 2.2.7 / Guideline B 2.5.1.8, this agreement including the wage, and";
                }
                else{
                    $text = "※  As per 2018 amendments to MLC 2006, Standard A 2.1.7 / A 2.2.7 / Guideline B 2.5.1.8, this agreement including the wage, and";
                }

                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);
                $text = "entitlement to repatriation continues to have effect while a seafarer is held captive on or off the ship as a result of acts of piracy or armed";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);
                $text = "robbery against ships.";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);
                $text = "※   Additional clause for Marshall Islands flag";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);
                $text = "The terms and conditions laid down herein shall be subject to the applicable provisions of the Maritime Law and Regulations of the Republic";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);
                $text = "of the Marshall Islands and any dispute as to the terms and conditions of this contract shall be resolved in accordance with the Maritime Law";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);
                $text = "and Regulations of the Republic of the Marshall Islands.";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);

                $rt->createText(PHP_EOL);
                $text = "Seafarers, prior to or in the process of engagement, shall be informed about their rights under the seafarers’ recruitment and placement services’";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);
                $text = "system of protection, to compensate seafarers for monetary loss that they may incur as a result of the failure of the recruitment and placement";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);
                $text = "service or the relevant shipowner under the seafarers’ employment agreement to meet its obligations to them.";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);
                $text = "After consultation with the shipowners’ and seafarers’ organizations, the Administration has determined that seafarers’ wages may be paid to an";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);
                $rt->createText(PHP_EOL);
                $text = "account other than the seafarers’ designated bank account, if this is requested in writing by the seafarer.";
                $rt->createTextRun($text)->getFont()->setName("Times New Roman")->setSize(9);

                $event->sheet->getParent()->getActiveSheet()->getCell("A39")->setValue($rt);
                $event->sheet->getDelegate()->getStyle('A39')->getAlignment()->setIndent(true);
            },
        ];
    }

    public function drawings()
    {
        $sig = $this->applicant->vessel->fleet == "FLEET B" ? 'images/mlc_hmm_sig.png' : 'images/shirley_sig.png';

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path('images/MLC_SEAL.png'));
        $drawing->setCoordinates("F41");
        $drawing->setHeight(130);
        $drawing->setWidth(130);
        $drawing->setOffsetX(50);
        $drawing->setOffsetY(3);

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setPath(public_path($sig));
        $drawing3->setOffsetX(2);
        $drawing3->setOffsetY(2);
        $drawing3->setCoordinates("D41");
        $drawing3->setResizeProportional(false);
        $drawing3->setHeight(115);
        $drawing3->setWidth(130);

        return [$drawing, $drawing3];
    }
}
