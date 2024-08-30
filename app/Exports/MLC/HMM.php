<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;

class HMM implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $title = "HMM MLC"){
        $array1 = [
            'M/V HMM MIR', 'M/V HYUNDAI BRAVE', 'M/V HYUNDAI FAITH', 'M/V HMM ST. PETERSBURG', 'M/V HMM LE HAVRE', 'M/V HYUNDAI COURAGE', 'M/V HMM RAON', 'M/V HMM GARAM', 'M/V HMM NURI', 'M/V HMM HANBADA', 'M/V HYUNDAI FORCE', 'M/V HYUNDAI UNITY', 'M/V HYUNDAI GRACE', 'M/V HYUNDAI COLOMBO'
        ];

        $array2 = [
            'MT C. GUARDIAN', 'MT PACIFIC M', "MT NEPTUNE M"
        ];

        $array3 = [
            'M/V HMM ALGECIRAS', 'M/V HMM OSLO', 'M/V HMM COPENHAGEN', 'M/V HMM GDANSK', 'M/V HMM HAMBURG', 'M/V HMM SOUTHAMPTON'
        ];

        $array4 = [
            'M/V HMM AMETHYST'
        ];

        $array5 = [
            'M/V ATLANTIC AFFINITY', 'M/V PACIFIC CHAMP', 'M/V HYUNDAI ANTWERP', 'M/V HYUNDAI ULSAN', 'MT UNIVERSAL CHALLENGER', 'M/T ORIENTAL AQUAMARINE', 'M/T UNIVERSAL FRONTIER'
        ];

        // minus two;
        $mt = false;

        // FOR FLEET C
        if($applicant->vessel->fleet == "FLEET C" && !in_array($applicant->vessel->id, [6072, 5842, 5553])){
            $mt = true;
            $applicant->shipowner = 'HMM Ocean Service Co., Ltd.';
            $applicant->sAddress = '5TH FLOOR,BUSAN POST OFFICE BUILDING,JUNGANG-DAERO 63, JUNG-GU, BUSAN, REBUBLIC OF KOREA';
        }
        else //FOR FLEET B
        {
            if(in_array($applicant->vessel->name, $array1)){
                $applicant->shipowner = "HMM Company Limited";
                $applicant->sAddress = "TOWER 1, PARC.1, 108, YEOUI-DAERO, YEONGDEUNGPO-GU, SEOUL, REPUBLIC OF KOREA";
                $applicant->crewManager = "HMM Ocean Service Co., Ltd.";
                $applicant->cAddress = "5TH FLOOR,BUSAN POST OFFICE BUILDING,JUNGANG-DAERO 63, JUNG-GU, BUSAN, REBUBLIC OF KOREA";
            }
            elseif(in_array($applicant->vessel->name, $array2)){
                $mt = true;
                $applicant->shipowner = 'HMM Ocean Service Co., Ltd.';
                $applicant->sAddress = '5TH FLOOR,BUSAN POST OFFICE BUILDING,JUNGANG-DAERO 63, JUNG-GU, BUSAN, REBUBLIC OF KOREA';
            }
            elseif(in_array($applicant->vessel->name, $array3)){
                $applicant->shipowner = "HMM Company Limited";
                $applicant->sAddress = 'TOWER 1, PARC.1, 108, YEOUI-DAERO, YEONGDEUNGPO-GU, SEOUL, REPUBLIC OF KOREA';
                $applicant->crewManager = "HMM Ocean Service Co., Ltd.";
                $applicant->cAddress = "5TH FLOOR,BUSAN POST OFFICE BUILDING,JUNGANG-DAERO 63, JUNG-GU, BUSAN, REBUBLIC OF KOREA";
            }
            elseif(in_array($applicant->vessel->name, $array4)){
                $applicant->shipowner = "HMM Company Limited";
                $applicant->sAddress = "108, YEOUI-DAERO, YEONGDEUNGPO-GU, SEOUL, REPUBLIC OF KOREA";
                $applicant->crewManager = "HMM Ocean Service Co., Ltd.";
                $applicant->cAddress = "63 JUNGANG-DAERO, JUNG-GU, BUSAN, KOREA";
            }
            elseif(in_array($applicant->vessel->name, $array5)){
                $applicant->shipowner = "HMM Co., LTD.";
                $applicant->sAddress = "108, Yeouido-daero, Yeongdeungpo-gu, SEOUL, KOREA";
                $applicant->shipowner2 = "HMM Ocean Service Co., Ltd.";
                $applicant->sAddress2 = "63, JUNGANG-DAERO, JUNG-GU, BUSAN, KOREA";
                $applicant->crewManager = "HMM Ocean Service Co., Ltd.";
                $applicant->cAddress = "63 JUNGANG-DAERO, JUNG-GU, BUSAN, KOREA";
            }
            else{
                // DEFAULT
                $applicant->shipowner = "HMM Company Limited";
                $applicant->sAddress = "TOWER 1, PARC.1, 108, YEOUI-DAERO, YEONGDEUNGPO-GU, SEOUL, REPUBLIC OF KOREA";
                $applicant->crewManager = "HMM Ocean Service Co., Ltd.";
                $applicant->cAddress = "5TH FLOOR,BUSAN POST OFFICE BUILDING,JUNGANG-DAERO 63, JUNG-GU, BUSAN, REBUBLIC OF KOREA";
            }
        }

        $this->applicant    = $applicant;
        $this->title        = $title;
        $this->mt           = $mt;
    }

    public function view(): View
    {
        $principal = "hmm";

        $exportView = str_replace(' ', '_', $this->applicant->vessel->fleet) . '.' . $principal;

        return view('exports.mlc.' . $exportView, [
            'data' => $this->applicant,
        ]);
    }

    public function registerEvents(): array
    {
        $borderStyle = 
        [
            [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ],
            [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ],
            [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ]
            ],
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
                ]
            ],
            [
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
                ]
            ],
            [
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
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
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ]
            ],
        ];

        $fillStyle = [
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => '26b36c'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'ced4da'
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
            ],
            [
                'font' => [
                    'bold' => true,
                    'italic' => true
                ],
            ],
        ];

        $title = $this->title;
        $mt = $this->mt ? -2 : 0;

        // IF PACIFIC CHAMP AND AFFINITY CHUCHU
        if(in_array($this->applicant->vessel->id, [7141, 7517, 4623, 4637, 6072, 5842, 5553])){
            $mt += 3;
        }

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle, $title, $mt) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle(str_replace('/', '', $title), false);


                if(in_array($this->applicant->vessel->id, [7141, 7517, 4623, 4637, 6072, 5842, 5553])){
                    $event->sheet->getDelegate()->getHeaderFooter()->setOddHeader("&L표준근로계약서(STANDARD SEAFARER’S EMPLOYMENT AGREEMENT) &R&ICh.2 / Page &P");
                    $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter("&LPC-302/2022.01.26/DCN22001");

                    $event->sheet->getDelegate()->getHeaderFooter()->setEvenHeader("&L표준근로계약서(STANDARD SEAFARER’S EMPLOYMENT AGREEMENT) &R&ICh.2 / Page &P");
                    $event->sheet->getDelegate()->getHeaderFooter()->setEvenFooter("&LPC-302/2022.01.26/DCN22001");
                }

                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.2);

                $event->sheet->getDelegate()->getStyle('A1:I' . (62 + $mt))->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle('A4:I' . (62 + $mt))->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('B21')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('A' . (43 + $mt))->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('A' . (46 + $mt))->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('A' . (52 + $mt))->getFont()->setSize(8);

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

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
                    'B' . (22 + $mt)
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                ];

                // HL
                $h[4] = [
                ];

                // HC VC
                $h[5] = [
                ];

                // B
                $h[6] = [
                ];

                // VC
                $h[7] = [
                    'A1:I' . (21 + $mt),
                    'A' . (22 + $mt), 'B' . (22 + $mt),
                    'A' . (23 + $mt) . ':I' . (62 + $mt),
                ];

                // B I
                $h[8] = [
                ];

                $h['wrap'] = [
                    'A' . (22 + $mt), 'A' . (33 + $mt), 'B' . (27 + $mt), 'C' . (24 + $mt), 'E' . (24 + $mt), 
                    'E' . (27 + $mt), 'B' . (22 + $mt), 'B' . (30 + $mt), 'B' . (31 + $mt), 'A' . (40 + $mt),
                    'A' . (43 + $mt), 'A' . (46 + $mt), 'A' . (52 + $mt), 'A' . (54 + $mt), 'A' . (60 + $mt)
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'F8', 'E' . (58 + $mt), 'C7', 'H8', 'C' . (13 + $mt),
                ];

                // IF PACIFIC CHAMP AND AFFINITY CHUCHU
                if(in_array($this->applicant->vessel->id, [7141, 7517, 4623, 4637, 6072, 5842, 5553])){
                    array_push($h[5], 'B9');
                    array_push($h[5], 'B12');

                    array_push($h['stf'], 'D7');
                    array_push($h['stf'], 'D19');
                }

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
                    'A7:I' . (17 + $mt), 'A' . (20 + $mt) . ':I' . (22 + $mt), 'A' . (24 + $mt) . ':I' . (31 + $mt), 
                    'A' . (33 + $mt) . ':I' . (36 + $mt), 'A' . (40 + $mt) . ':I' . (40 + $mt), 'A' . (43 + $mt) . ':I' . (43 + $mt),
                    'A' . (49 + $mt) . ':I' . (49 + $mt),
                    'A' . (46 + $mt) . ':I' . (46 + $mt), 'A' . (52 + $mt) . ':I' . (52 + $mt), 'A' . (60 + $mt) . ':I' . (61 + $mt)
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

                // BOTTOM BORDER THIN
                $cells[7] = array_merge([
                    'A' . (56 + $mt) . ':C' . (56 + $mt), 'E' . (56 + $mt) . ':H' . (56 + $mt)
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20.5);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(9);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(21);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(9);

                // ROW RESIZE
                for($i = 1; $i <= (60 + $mt); $i++){
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(21);
                }

                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(1);
                $event->sheet->getDelegate()->getRowDimension(3)->setRowHeight(17);
                $event->sheet->getDelegate()->getRowDimension(5)->setRowHeight(17);
                $event->sheet->getDelegate()->getRowDimension(18 + $mt)->setRowHeight(17);
                $event->sheet->getDelegate()->getRowDimension(22 + $mt)->setRowHeight(110);
                $event->sheet->getDelegate()->getRowDimension(24 + $mt)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(25 + $mt)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(27 + $mt)->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension(28 + $mt)->setRowHeight(25);
                $event->sheet->getDelegate()->getRowDimension(29 + $mt)->setRowHeight(25);
                $event->sheet->getDelegate()->getRowDimension(30 + $mt)->setRowHeight(50);
                $event->sheet->getDelegate()->getRowDimension(31 + $mt)->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension(33 + $mt)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(34 + $mt)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(35 + $mt)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(36 + $mt)->setRowHeight(35);

                // TO PAGE 2
                $event->sheet->getDelegate()->getRowDimension(37 + $mt)->setRowHeight(5);
                $event->sheet->getDelegate()->getRowDimension(38 + $mt)->setRowHeight(5);
                // END

                $event->sheet->getDelegate()->getRowDimension(40 + $mt)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(43 + $mt)->setRowHeight(95);
                $event->sheet->getDelegate()->getRowDimension(46 + $mt)->setRowHeight(115);
                $event->sheet->getDelegate()->getRowDimension(49 + $mt)->setRowHeight(46);
                $event->sheet->getDelegate()->getRowDimension(52 + $mt)->setRowHeight(80);
                $event->sheet->getDelegate()->getRowDimension(54 + $mt)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(55 + $mt)->setRowHeight(120);
                $event->sheet->getDelegate()->getRowDimension(56 + $mt)->setRowHeight(17);
                $event->sheet->getDelegate()->getRowDimension(57 + $mt)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(58 + $mt)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(60 + $mt)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(61 + $mt)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(62 + $mt)->setRowHeight(16);

                if($mt){
                    $event->sheet->getDelegate()->getRowDimension(36)->setRowHeight(40);
                }

                // IF PACIFIC CHAMP AND AFFINITY CHUCHU
                if(in_array($this->applicant->vessel->id, [7141, 7517, 4623, 4637, 6072, 5842, 5553])){
                    $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(16.5);
                    $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(8.5);

                    $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(50);
                    $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(30);
                    $event->sheet->getDelegate()->getRowDimension(3)->setRowHeight(10);

                    $event->sheet->getDelegate()->getRowDimension(5)->setRowHeight(10);
                    $event->sheet->getDelegate()->getRowDimension(21)->setRowHeight(1);

                    $event->sheet->getDelegate()->getRowDimension(25)->setRowHeight(70);
                    $event->sheet->getDelegate()->getRowDimension(28)->setRowHeight(23);
                    $event->sheet->getDelegate()->getRowDimension(31)->setRowHeight(23);
                    $event->sheet->getDelegate()->getRowDimension(34)->setRowHeight(30);
                    $event->sheet->getDelegate()->getRowDimension(36)->setRowHeight(25);
                    $event->sheet->getDelegate()->getRowDimension(37)->setRowHeight(25);
                    $event->sheet->getDelegate()->getRowDimension(38)->setRowHeight(25);
                    $event->sheet->getDelegate()->getRowDimension(39)->setRowHeight(25);

                    $event->sheet->getDelegate()->getRowDimension(40)->setRowHeight(10);
                    $event->sheet->getDelegate()->getRowDimension(41)->setRowHeight(10);
                }

                $event->sheet->getParent()->getActiveSheet()->setBreak('A' . (36 + $mt), \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);

                $event->sheet->getDelegate()->getStyle('C24')->getFont()->setSize(7);
                
                // RICH TEXTS
                if(!in_array($this->applicant->vessel->id, [7108, 7517, 7141, 4637, 4623, 6072, 5842, 5553])){
                    $cell = "A6";
                    $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();

                    $rt->createText("1. Seafarer/Shipowner/");
                    $rt->createTextRun("Ship Manager")->getFont()->setUnderline(true)->setBold(true)->setName("Times New Roman")->setSize(10);
                    $rt->createTextRun("/Agent/Ship")->getFont()->setBold(true)->setName("Times New Roman")->setSize(10);

                    $event->sheet->getParent()->getActiveSheet()->getCell($cell)->setValue($rt);

                    $cell = "A12";
                    $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();

                    $rt->createTextRun("Ship Manager")->getFont()->setUnderline(true)->setName("Times New Roman")->setSize(10);

                    $event->sheet->getParent()->getActiveSheet()->getCell($cell)->setValue($rt);

                    $cell = "C24";
                    $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();

                    $rt->createTextRun("Fixed/")->getFont()->setName("Times New Roman")->setSize(10);
                    $rt->createTextRun("Guaranteed")->getFont()->setUnderline(true)->setName("Times New Roman")->setSize(10);
                    $rt->createText(PHP_EOL);
                    $rt->createTextRun("Overtime Allowance")->getFont()->setName("Times New Roman")->setSize(10);

                    $event->sheet->getParent()->getActiveSheet()->getCell($cell)->setValue($rt);
                }
            },
        ];
    }

    public function drawings()
    {
        $mt = $this->mt ? -2 : 0;

        $sig = $this->applicant->vessel->fleet == "FLEET B" ? 'images/mlc_hmm_sig.jpg' : 'images/maam_jen_sig.jpg';

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path('images/MLC_SEAL.png'));
        $drawing->setCoordinates('G' . (55 + $mt));
        $drawing->setHeight(154);
        $drawing->setWidth(154);
        $drawing->setOffsetX(35);
        $drawing->setOffsetY(3);

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setName('mlc_hmm_sig');
        $drawing3->setDescription('mlc_hmm_sig');
        $drawing3->setPath(public_path($sig));
        $drawing3->setOffsetX(2);
        $drawing3->setOffsetY(2);
        $drawing3->setCoordinates('E' . (55 + $mt));
        $drawing3->setHeight(140);
        $drawing3->setWidth(140);

        if(in_array($this->applicant->vessel->id, [7141, 7517, 4623, 4637, 6072, 5842, 5553])){
            $drawing->setCoordinates('G' . (58 + $mt));
            $drawing3->setCoordinates('E' . (58 + $mt));
        }

        return [$drawing, $drawing3];
    }
}
