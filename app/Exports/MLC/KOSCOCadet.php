<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KOSCOCadet implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $type){
        $array1 = [
            'M/V DONG-A OKNOS', 'M/V DONG-A ASTREA'
        ];

        $array2 = [
            'M/V SUNNY LILY', 'M/V SUNNY COSMOS'
        ];

        $array3 = [
            'M/V KMARIN AZUR'
        ];

        $array4 = [
            'M/V KMARIN ATLANTICA'
        ];

        $array5 = [
            'M/V KMARIN ULSAN'
        ];

        $array6 = [
            'M/V KMARIN MELBOURNE'
        ];

        $array7 = [
            'M/V BOKM NINGBO'
        ];

        $array8 = [
            "M/V BOKM SHANGHAI"
        ];

        $array9 = [
            'M/V PACIFIC BLESS', 'M/V PACIFIC CROWN',
        ];

        $array10 = [
            'M/V DONG-A GLAUCOS'
        ];

        $array11 = [
            'M/V DAEBO GLADSTONE'
        ];

        $array12 = [
            'M/V DONG-A METIS'
        ];

        $array13 = [
            'M/V GLOVIS COUNTESS'
        ];

        if(in_array($applicant->vessel->name, $array1)){
            $applicant->shipowner = "DONG-A TANKER CO., LTD.";
            $applicant->sAddress = "#905, 18, Gwangbok-ro 97beon-gil, Jung-gu, Busan, Republic of Korea";
        }
        elseif(in_array($applicant->vessel->name, $array2)){
            $applicant->shipowner = 'EA SHIPPING CO., LTD.';
            $applicant->sAddress = "#906, 18, Gwangbok-ro 97beon-gil, Jung-gu, Busan, Republic of Korea";
        }
        elseif(in_array($applicant->vessel->name, $array3)){
            $applicant->shipowner = 'KMARIN NO.21A S.A.';
            $applicant->sAddress = "BICSA Financial Center, 60th Floor, Balboa Avenue, Panama City, Panama";
        }
        elseif(in_array($applicant->vessel->name, $array4)){
            $applicant->shipowner = 'KMARIN NO.21B S.A.';
            $applicant->sAddress = "BICSA Financial Center, 60th Floor, Balboa Avenue, Panama City, Panama";
        }
        elseif(in_array($applicant->vessel->name, $array5)){
            $applicant->shipowner = 'HI GOLD OCEAN KMARIN NO.9B S.A.';
            $applicant->sAddress = "19th Floor, Banco General Tower, Aquilino de la Guardia Street, Marbella, Panama city, Panama";
        }
        elseif(in_array($applicant->vessel->name, $array6)){
            $applicant->shipowner = 'KMARIN NO.16B S.A.';
            $applicant->sAddress = "19th Floor, Banco General Tower, Aquilino de la Guardia Street, Marbella, Panama city, Panama";
        }
        elseif(in_array($applicant->vessel->name, $array7)){
            $applicant->shipowner = 'XIANG B32 HK INTERNATIONAL SHIP LEASE CO., LIMITED';
            $applicant->sAddress = "1st Floor, Far East Consortium Building, 121 Des Voeux Road, Central, Hong Kong";
        }
        elseif(in_array($applicant->vessel->name, $array8)){
            $applicant->shipowner = 'XIANG B3 HK INTERNATIONAL SHIP LEASE CO., LIMITED';
            $applicant->sAddress = "18/F, 20 Pedder Street, Central, HONG KONG";
        }
        elseif(in_array($applicant->vessel->name, $array9)){
            $applicant->shipowner = 'KMARIN NO.3A S.A.';
            $applicant->sAddress = "BICSA Financial Center, 60th Floor, Balboa Avenue, Panama City, Panama";
        }
        elseif(in_array($applicant->vessel->name, $array10)){
            $applicant->shipowner = 'DAT PACIFIC ETERNITY S.A.';
            $applicant->sAddress = "Trust Company Complex, Ajeltake Road, Ajeltake Island, Majuro, MH96960, Marshall Island";
        }
        elseif(in_array($applicant->vessel->name, $array11)){
            $applicant->shipowner = 'KSF GLOBAL NO.31 S.A.';
            $applicant->sAddress = "Bisca Financial Center, 60th Floor, Balboa Avenue, Panama City, Republic of Panama";
        }
        elseif(in_array($applicant->vessel->name, $array12)){
            $applicant->shipowner = 'DAT Metis Maritime S.A';
            $applicant->sAddress = "BICSA Financial Center, 60th Floor, Balboa Avenue, Panama City, Panama";
        }
        elseif(in_array($applicant->vessel->name, $array13)){
            $applicant->shipowner = 'DAT COUNTESS MARITIME 2 S.A.';
            $applicant->sAddress = "Trust Company Complex, Ajeltake Road, Ajeltake Island, Majuro, MH96960, Marshall Island";
        }

        $this->applicant= $applicant;
        $this->type     = $type;
    }

    public function view(): View
    {
        $exportView = str_replace(' ', '_', $this->applicant->vessel->fleet) . '.kosco_cadet';
        return view('exports.mlc.' . $exportView, [
            'data' => $this->applicant,
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
                $event->sheet->getDelegate()->setTitle('CADET MLC', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.7);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                $event->sheet->getDelegate()->getHeaderFooter()->setOddHeader('&R Page &P/&N');
                $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter('&LF-SPM-0204 / 2018. 03. 01 Established &CKOSCO &RRev. 1 / 2021.02.01');

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));
                
                // SET DEFAULT FONT
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Calibri');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(9);

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
                    'A23',
                    'E25'
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    
                ];

                // HC VC
                $h[4] = [
                    'A1', 'A3:B14', 'E9:E14',
                    'A16:F19',
                    'A20:A22'
                ];

                // HL
                $h[5] = [
                ];

                // B
                $h[6] = [
                    'A1', 'A3:A14',
                    'A16:A22'
                ];

                // VC
                $h[7] = [
                    'A2', 'C3:C14', 'F9:F14',
                    'A15',
                    'B20:B22'
                ];

                // UND
                $h[8] = [
                ];

                // JUSTIFY
                $h[9] = [
                    'A15', 'B19',
                    'B20:B22',
                    'A23'
                ];

                $h['wrap'] = [
                    'A2:A7', 'F11',
                    'A16:A22',
                    'A25'
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
                    'A3:F14',
                    'A16:F22'
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
                    'A25:C25', 'E25:F25'
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(12.5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(9);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(30);

                $event->sheet->getDelegate()->getRowDimension(15)->setRowHeight(150);
                $event->sheet->getDelegate()->getRowDimension(19)->setRowHeight(80);
                $event->sheet->getDelegate()->getRowDimension(20)->setRowHeight(180);
                $event->sheet->getDelegate()->getRowDimension(21)->setRowHeight(180);
                $event->sheet->getDelegate()->getRowDimension(22)->setRowHeight(140);
                $event->sheet->getDelegate()->getRowDimension(23)->setRowHeight(140);

                // ROW RESIZE
                $rows = [
                    [
                        26.5, //ROW HEIGHT
                        3,14 //START ROW, END ROW
                    ],
                    [
                        26.5, //ROW HEIGHT
                        16,18 //START ROW, END ROW
                    ],
                    [
                        26.5, //ROW HEIGHT
                        24,26 //START ROW, END ROW
                    ],
                ];

                $rows2 = [
                    [
                        45,
                        [1]
                    ],
                    [
                        30,
                        [2]
                    ],
                ];

                // FONTS
                $fRows = [
                    [
                        14, //FONT SIZE
                        ["A1"] //CELL
                    ],
                    [
                        9, //FONT SIZE
                        ["A15", 'B20:B22', "A23", 'E25'] //CELL
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

                foreach($fRows as $row){
                    foreach($row[1] as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->getFont()->setSize($row[0]);
                    }
                }

                // PAGE BREAKS
                $rows = [19];
                foreach($rows as $row){
                    $event->sheet->getParent()->getActiveSheet()->setBreak('A' . $row, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                }

                $allowance = 12.0;

                $cba = "IBF KFSU CA(BBCHP)";
                $leave = 9;

                $v = $this->applicant->vessel->name;
                $tFot = null;
                if(in_array($v, ['M/V DONG-A OKNOS', 'M/V DONG-A EOS'])){
                    $allowance = 11.1;
                }
                elseif(in_array($v, ['M/V KMARIN ULSAN', 'M/V KMARIN MELBOURNE'])){
                    $allowance = 12;
                }
                elseif(in_array($v, ['M/V KMARIN AZUR', "M/V BOKM SHANGHAI", 'M/V BOKM NINGBO'])){
                    // $allowance = 11;
                    $cba = "IBF FKSU/AMOSUP-KSA CBA";
                }
                elseif(in_array($v, ['M/V KMARIN ATLANTICA'])){
                    $allowance = 12;
                    $cba = "IBF FKSU/AMOSUP-KSA CBA";
                }
                elseif(in_array($v, ['M/V DAEBO GLADSTONE'])){
                    $allowance = 12;
                    $cba = "IBF FKSU CA(BBCHP)";
                }
                elseif(in_array($v, ['M/V GLOVIS COUNTESS'])){
                    $cba = "IBF FKSU CA(BBCHP)";
                    $allowance = 12;
                    $leave = 10;
                }
                elseif(in_array($v, ['M/V DONG-A GLAUCOS'])){
                    $cba = "IBF FKSU CA(BBCHP)";
                    $allowance = 12;
                }
                elseif(in_array($v, ['M/V DONG-A METIS'])){
                    $allowance = 10.5;
                    $cba = "IBF FKSU CA(BBCHP)";
                }

                $cell = "B18";
                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();

                $rt->createText("Costs for food shall be ( ");
                $rt->createTextRun($allowance . " US dollars")->getFont()->setBold(true)->setName("Calibri")->setSize(9);
                $rt->createTextRun(" ) per person/day excluding shipment cost.")->getFont()->setName("Calibri")->setSize(9);

                $event->sheet->getParent()->getActiveSheet()->getCell($cell)->setValue($rt);
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setSize(14);
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setName('Arial');
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('SIR KIT SIG');
        $drawing->setDescription('SIR KIT SIG');
        $drawing->setPath(public_path("images/sir_kit_sig.png"));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(70);
        $drawing->setWidth(260);
        $drawing->setOffsetX(3);
        $drawing->setOffsetY(-40);
        $drawing->setCoordinates('A24');

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setName('MLC SEAL');
        $drawing2->setDescription('MLC SEAL');
        $drawing2->setPath(public_path("images/MLC_SEAL_BLUE.png"));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(110);
        $drawing2->setWidth(125);
        $drawing2->setOffsetX(40);
        $drawing2->setOffsetY(-40);
        $drawing2->setCoordinates('C24');

        return [$drawing, $drawing2];
    }
}
