<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HARBOURLINK implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $title = "MLC Contract"){
        $this->data     = $data;
        $this->title     = $title;
    }

    public function view(): View
    {
        $exportView = str_replace(' ', '_', $this->data->vessel->fleet) . '.harbourLink';
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
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED
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
            [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                ]
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
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                $event->sheet->getDelegate()->getPageSetup()->setFirstPageNumber(1);

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));
                
                // SET DEFAULT FONT
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial Narrow');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(11);

                $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter('&R&8&BPage | &P');

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
                    'A60:J62',
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    'A1', 'F16', 'C19', 'C22', 'C29',
                    'A30', 'A51', 'A68',

                    'A84', 'A86:A91', 'G97:J98',
                    'F97:F98',
                    'A99', 'A110:A113', 
                    'A116', 'A120:A124'
                ];

                // HC VC
                $h[4] = [
                ];

                // HL
                $h[5] = [
                ];

                // B
                $h[6] = [
                    'A1',
                    'A5:I7', 'A9:I13',
                    'A15', 'A18', 'A21',
                    'F16', 'C19', 'C22',
                    'C29:F29', 'F25:F29',

                    'A30', 'A32', 'A36', 'A41:A42', 'A44:A45', 'A48:A49',
                    'A51', 'A66',
                    'A68', 'A72', 'A76', 'A77', 'A79', 'A82', 'A85',
                    'A84', 'A93', 'B93', 'G93',
                    'A99', 'A100', 'A114', 'A116',
                    'A125'
                ];

                // VC
                $h[7] = [
                    'A1:J57', 'A59:J84', //only changed the last 100 and just skip in betweens like 58
                    'A86:J126'
                ];

                // UNDERLINE
                $h[8] = [
                    'A1', 'A30', 'A51', 'A68', 'A84', 'A99', 'A116'
                ];

                // JUSTIFY
                $h[9] = [
                    'A38', 'A39', 'A43', 'A50',
                    'A52:A67',
                    'A69:A83',
                    'B86:J91',
                    'A101:J109', 'A114:J115',
                    'A117:J119', 'B120:B124', 'A125:J126'
                ];

                // HR
                $h[10] = [
                    'A60:A62',
                    // 'A88:A89'
                ];

                $h['wrap'] = [
                    'E11',

                    'A33', 'A34', 'A38', 'A39', 'A43', 'A46', 'A47', 'A50',
                    'A51:A67', 'B60:B62',
                    'A68:A83',
                    'B86:J91',
                    'A101:J115',
                    'A117:J126'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'B93'
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
                    'F16:G16', 'C19:F19', 'C22',
                    'F28:I28', 'F29:I29',
                    'G97:J97', 'G98:J98',
                ]);

                // BBD
                $cells[13] = array_merge([
                    'B92:E92', 'G92:J92'
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(17);

                // ROW RESIZE
                $rows = [
                    [
                        23, //ROW HEIGHT
                        2,50 //START ROW, END ROW
                    ],
                    [
                        23, //ROW HEIGHT
                        97,98 //START ROW, END ROW
                    ],
                    [
                        17, //ROW HEIGHT
                        110,113 //START ROW, END ROW
                    ],
                ];

                $rows2 = [
                    [
                        30,
                        [1, 30, 42, 44, 48, 51, 53, 66, 68, 76, 78, 80, 88, 109, 114, 115, 120, 125, 126]
                    ],
                    [
                        40,
                        [33, 34, 46, 57, 62, 63, 70, 72, 73, 77, 79, 82, 83, 85, 99, 116]
                    ],
                    [
                        50,
                        [57, 58, 59]
                    ],
                    [
                        60,
                        [
                            11, 13, 38, 39, 43, 47, 50, 61, 81, 103, 105, 106, 107, 118
                        ]
                    ],
                    [
                        70,
                        [
                            74, 86, 87, 104, 121,122
                        ]
                    ],
                    [
                        80,
                        [
                            101
                        ]
                    ],
                    [
                        85,
                        [54, 55, 56, 64, 71, 75, 89, 91, 92]
                    ],
                    [
                        90,
                        [102, 124]
                    ],
                    [
                        105,
                        [117]
                    ],
                    [
                        110,
                        [123]
                    ],
                    [
                        130,
                        [108]
                    ],
                    [
                        140,
                        [
                            90, 119
                        ]
                    ],
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
                $rows = [29, 50, 67, 83, 98, 115];
                foreach($rows as $row){
                    $event->sheet->getParent()->getActiveSheet()->setBreak('A' . $row, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                }
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle('A30')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A30')->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle('A51')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A51')->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle('A68')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A68')->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle('A84')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A84')->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle('A99')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A99')->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle('A116')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A116')->getFont()->setName('Arial');

                $event->sheet->getDelegate()->getStyle('A34')->getFont()->setStrikeThrough(true);
                $event->sheet->getDelegate()->getStyle('A46')->getFont()->setStrikeThrough(true);
                $event->sheet->getDelegate()->getStyle('A47')->getFont()->setStrikeThrough(true);
                $event->sheet->getDelegate()->getStyle('A50')->getFont()->setStrikeThrough(true);

                $event->sheet->getDelegate()->getStyle('E11:E13')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('E11:E13')->getFont()->setName('Arial Narrow');

                $event->sheet->getDelegate()->getStyle('A110:J115')->getFont()->setSize(9.5);
                $event->sheet->getDelegate()->getStyle('A125')->getFont()->setSize(9.5);

                // rich texts

                // 2ND PAGE
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Monthly Allotments are being processed until every")->getFont();
                $rt->createTextRun(" 18th ")->getFont()->setUnderline(true)->setBold(true);
                $rt->createTextRun("day of the following month or earlier in case of non- banking days, Saturdays, Sundays, and holidays.");
                $event->sheet->getParent()->getActiveSheet()->getCell("A33")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("You are entitled to take  ")->getFont();
                $rt->createTextRun(" 4.5 working days per 1 month as paid leave of continuous service.")->getFont()->setUnderline(true)->setBold(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("A37")->setValue($rt);

                $start = now()->parse();
                $end = $start->copy()->addMonths($this->data->employment_months);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Your employment is for a period commencing on ")->getFont();
                $rt->createTextRun($start->format('F j, Y'))->getFont()->setUnderline(true)->setBold(true);
                $rt->createTextRun(" and ending on ")->getFont();
                $rt->createTextRun($end->format('F j, Y'))->getFont()->setUnderline(true)->setBold(true);
                $rt->createTextRun(" unless it is terminated for justified reasons in advance of this point or the ship is at sea at that point time in which event it will continue until its arrival in port at which point it will terminate")->getFont();
                $event->sheet->getParent()->getActiveSheet()->getCell("A43")->setValue($rt);

                // 3RD PAGE
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Health And Social Security Benefits ")->getFont()->setBold(true);
                $rt->createTextRun("(see Notes 7 and 8)");
                $event->sheet->getParent()->getActiveSheet()->getCell("A53")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("If you become sick or injured whilst on a voyage, you will be paid you normal basic wages until you have been repatriated in accordance with the repatriation provisions set out below. After you have been repatriated you will be paid ");
                $rt->createTextRun("100")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" per cent [insert number] of your normal basic wages up to maximum of ");
                $rt->createTextRun("17")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" weeks. [insert number which shall be 16 or above].");
                $event->sheet->getParent()->getActiveSheet()->getCell("A54")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("In the event of sickness or incapacity, you will be provided with medical care, including medical treatment and the supply of necessary medicines and therapeutic devices and board and lodging away of a permanent character, subject to a maximum period of  ");
                $rt->createTextRun("17")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" weeks [insert number which shall be 16 or above]. In addition, the shipowner will meet the cost of the return of your property left on board to you or your next of kin.");
                $event->sheet->getParent()->getActiveSheet()->getCell("A56")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Repatriation ")->getFont()->setBold(true);
                $rt->createTextRun("(see Note 9)");
                $event->sheet->getParent()->getActiveSheet()->getCell("A58")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("The entitlement to repatriation entails transport by ");
                $rt->createTextRun("air flight/land transport")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" (whichever is applicable) to ");
                $rt->createTextRun("Manila, Philippines")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" (insert place name or country):");
                $event->sheet->getParent()->getActiveSheet()->getCell("A63")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("NOTE")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" – You may not be entitled to repatriation at the expense of the shipowner in circumstances where you have been dismissed on disciplinary grounds or have breached your obligations under this agreement. In such circumstances the shipowner will still be liable to repatriation you but is entitled to recover from any wages due to you the cost of doing so");
                $event->sheet->getParent()->getActiveSheet()->getCell("A64")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("The minimum period of service following which you will be entitled repatriation at no cost to you is ");
                $rt->createTextRun("21")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" weeks.");
                $event->sheet->getParent()->getActiveSheet()->getCell("A67")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Applicable Collective Bargaining Agreement(s) (delete if not applicable) ")->getFont()->setBold(true);
                $rt->createTextRun("(see Note 11)");
                $event->sheet->getParent()->getActiveSheet()->getCell("A70")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Your employment will also be subject to the Collective  Bargaining  Agreement(s)  entered  into  on (insert date (s) between the shipowner and  (insert details of the other parties to the collective bargaining agreement(s) expect that where any provision(s) of such collection bargaining agreement(s) conflict with International or UK law such provisions(s) shall not apply to your employment under this Agreement.")->getFont()->setStrikeThrough(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("A71")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Your normal hours of work are ");
                $rt->createTextRun("0600 hours")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" [insert time] to ");
                $rt->createTextRun("1800 hours")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" [insert time] on ");
                $rt->createTextRun("Monday")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" [insert day of week] to ");
                $rt->createTextRun("Sunday")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" [insert day of week] inclusive.");
                $event->sheet->getParent()->getActiveSheet()->getCell("A73")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("If you are dissatisfied with any disciplinary decision taken in relation to you, you should refer to the disciplinary procedure set out in the Code of Conduct which can be obtained from ");
                $rt->createTextRun("the Company’s SMS")->getFont()->setBold(true)->setUnderline(true);
                $rt->createTextRun(" [state from where Code of Conduct can be obtained].");
                $event->sheet->getParent()->getActiveSheet()->getCell("A81")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Where you lose personal property, as a result of the result of the vessel on which you are serving foundering or being lost, the shipowner will pay compensation up to a maximum of ");
                $rt->createTextRun("RM500.00.")->getFont()->setBold(true)->setUnderline(true);
                $event->sheet->getParent()->getActiveSheet()->getCell("A83")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 1 – “insert date of birth or age”")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun("- normally the date of birth should be inserted in full. Only in exceptional circumstances should the seafarer’s “age” be inserted. This should be the seafarer’s age at the time the SEC was signed and should be inserted only where there is no means of establishing the seafarer’s actual dare of birth e.g. because the seafarer comes from a country where birth records are not accurate or for various reasons no longer exist and the seafarer himself does not know his actual date of birth.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A101")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 2 - “capacity in which seafarer is to be employed”")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – This will be the capacity in which the seafarer is to be employed at the time the SEC is signed by the parties to it. Given that an SEC may run for a considerable length of time if the seafarer remains with the same shipowner, it is possible that the capacity in which the seafarer is employed could change over time. The shipowner may wish to consider whether a new SEA will be issued at such time or alternatively include a provision indicating how any changes to capacity will be dealt with e.g. by means of a letter setting out the new capacity and the relevant wage scale.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A102")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 3- “Place Of Work”")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" should state either the name of the vessel on which the Seafarer is to be employed where this is know or may state that :” Place of Work may be on any vessel owned, managed or chartered by the shipowner”. Where the seafarer may be employed on more than one vessel.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A103")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 4 – Wages")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" - As with “Capacity”( Note 2 Above) wages payable to the seafarer are likely to change if employed bye the same shipowner over a significant period of time. When completing the “Wages” entry SEC, shipowner will therefore need to bear this mind and include appropriate wording to over any future wage increases e.g. by providing for the wage increase as notified to the seafarer in writing.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A104")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 5 – “Paid Annual Leave”")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" - the period of paid annual leave must be not less than that specified in the Maritime labour Convention, 2006 Standard A2.4. Where it is more appropriate to do so, the formula to be used for calculating annual leave, e.g. 2.5 days per month of employment, may be inserted instead of an actual number of days.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A105")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 6 – Notice of Termination of Employment")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – The period of notice required to be given to the shipowner must not be less than that required to be given to the shipowner bye seafarer and, expect in the case of a fixed term or voyage agreement, must be not less that seven days.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A106")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 7 – Health And Social Security Benefits")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" - The provision of medical care includes any surgical or medical treatment or such dental or optical treatment (including the repair or replacement of any appliance) as cannot be postponed without impairing efficiency.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A107")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 8 – Social Security Benefits")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – These include payment bye the shipowner of any costs incurred in respect of any sickness or injury occurring between the date on which they commenced duty on board a ship and the date on which they are required to make in respect of the death or long term disability of a seafarer due to an occupational injury, illness or hazard occurring while the seafarer is serving under a seafarer’s employment contact or arising from their employment under such contract. Where appropriate, account should protection benefits and the SEC should specify what, if any social security contributions are being made by the shipowner on the seafarer’s behalf and to which administration. If no contributions are being made, the SEC should state that the seafarer should make their own arrangements to pay social security contributions where appropriate.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A108")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 9 – Repatriation")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – the term and condition governing entitlement or otherwise to repatriation for seafarers shall identify the destination as one of the following:")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A109")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 11 – Applicable Collective Bargaining Agreement(S)")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – Seafarers Employment Contract may, where applicable, incorporate any applicable collective bargaining agreements. Therefore the term and conditions contained in a collective bargaining agreement should be appended to, or incorporated by reference into, and thus from part of a seafarer Employment Contract. Collective bargaining Agreements may not however be substituted entirely for individual Seafarer Employment Agreement. \nIt should also be noted that in event of any conflict between the provisions of a collective bargaining agreement and the Malaysian general or merchant shipping legislation, the relevant Malaysian legislation will prevail.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A117")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 12 – Hours of Work")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – The hours of work for seafarers employed on Malaysian registered vessels must comply with the requirements of the Merchant Shipping (Manning, Hours of Work and Watch-keeping) Rules 1999 (as amended) or any subsequent Regulations which may further amend or replace those Regulations.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A118")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 13 – “Inclusion of Additional Provisions by Shipowner”")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – It is recognized that there will be occasions on which shipowners wish to include provisions additional to those set out in the Maritime Labour Convention. There is no objection to the inclusion of such additional provisions of the Malaysian general or merchant shipping legislation or any international instruments which have been ratified by Malaysia. The Marine Department Malaysia will not be checking and approving additional provisions, and it will therefore be the responsibility of the shipowner to ensure that there is no conflict. Failure to do so may result in refusal to issue a Maritime Certificate or its cancellation if one has already been issued. \nIn the context of non compliance, some provisions have previously been found in crew agreements which, if included in Seafarer Employment contract, could result in refusal to issue, or cancellation of, a Maritime Labour Certificate. Examples of these, which would apply also to Seafarer Employment Agreements, include:-")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A119")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Requiring that all seafarers belong to a union")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – Under Malaysia law there is no obligation on any worker to belong to a union.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("B120")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Requiring that seafarers join a specified union")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – Apart from the previous provision regarding choice on whether or not to join a union, such a provision would also conflict with the International Labour Organization Convention on Freedom of Association. This Convention ha been ratified by Malaysia and provides that workers shall be free to form and join organizations of their choosing.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("B121")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Requiring that by signing the agreement seafarers automatically agree to medical information about themselves being passed to the shipowner or another party acting on behalf of the shipowner")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – This is not acceptable and may be only be done with the specific prior authority of the seafarer on each occasion the shipowner requests that such information be made available.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("B122")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Requiring that by signing the agreement seafarers automatically agree to sensitive personal data about them being passed to other individuals or organizations as determined appropriate by the shipowner or another party acting on behalf of the shipowner")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – This also is not acceptable as such individuals/organizations may potentially be located in countries that do not have data protection legislation or have legislation that does not provide similar protection to that of the Malaysia. Such transfer of “sensitive personal information” may only be undertaken with the specific prior authority of the seafarer on each occasion the shipowner proposes that such information be passed to another individual or organization.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("B123")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Requiring that a seafarer bear the cost of his repatriation, and the cost of providing his replacement, should he terminate his employment prior to completing the specified period of employment even though he gave the period of notice to terminate his employment that was required by the agreement")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" – A seafarer can only be charged the cost of his repatriation if he has breached his obligations under the agreement or has been dismissed on disciplinary grounds. The giving of the period of notice specified in the agreement would not constitute breach of the seafarer’s obligations even if it terminated his employment before the date envisaged in the agreement.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("B124")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("Note 14 – “The Place where Agreement is entered into”")->getFont()->setSize(9.5)->setBold(true);
                $rt->createTextRun(" should state the name of village, town or city and country where Agreement is signed by the parties to it.")->getFont()->setSize(9.5);
                $event->sheet->getParent()->getActiveSheet()->getCell("A126")->setValue($rt);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path("images/maam_thea_sig.png"));
        $drawing->setHeight(80);
        $drawing->setWidth(150);
        $drawing->setOffsetX(-30);
        $drawing->setOffsetY(30);
        $drawing->setCoordinates('H92');

        return [$drawing];
    }
}