<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KOSCO implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
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
            $applicant->shipowner = 'KOTAM NO.21A S.A.';
            $applicant->sAddress = "80 Broad Street, Monrovia, Liberia";
        }
        elseif(in_array($applicant->vessel->name, $array4)){
            $applicant->shipowner = 'KOTAM NO.21A S.A.';
            $applicant->sAddress = "80 Broad Street, Monrovia, Liberia";
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

        $this->applicant     = $applicant;
        $this->type         = $type;
    }

    public function view(): View
    {
        $exportView = str_replace(' ', '_', $this->applicant->vessel->fleet) . '.kosco';
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
                        'rgb' => 'FFFF00'
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
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                ],
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                $type = str_replace('/', '', $this->type);
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle($type ?? 'KOSCO MLC', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getHeaderFooter()->setOddHeader('&R Page &P/&N');
                $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter('&LF-SPM-0205 / 2018. 03. 01 Established &CKOSCO &RRev. 1 / 2021.02.01');

                $event->sheet->getDelegate()->getPageMargins()->setTop(0.39);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.19);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.39);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.19);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.19);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.19);

                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                // DEFAULT FONT AND STYLE FOR WHOLE PAGE
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Calibri');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                // $event->sheet->getDelegate()->getStyle('F3')->getFont()->setSize(14);
                // $event->sheet->getDelegate()->getStyle('A1:A2')->getFont()->setName('Arial');

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

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
                    
                ];

                // HC VC
                $h[4] = [
                    'C9:C15',
                    'B24:I24'
                ];

                // HL
                $h[5] = [
                    'F24'
                ];

                // B
                $h[6] = [
                ];

                // VC
                $h[7] = [
                    'A1:I15',
                    'A17:I28',
                    'A32:I33'
                ];

                // JUSTIFYT
                $h[8] = [
                ];

                $h['wrap'] = [
                    'A1:I33'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    
                ];

                if(in_array($this->applicant->vessel->name, ['M/V KMARIN ATLANTICA', 'M/V KMARIN AZUR'])){
                    $h[1] = [];
                    $h[4] = ['C9:C16','B25:I25'];
                    $h[7] = ['A1:I17','A18:I29'];
                    $h['wrap'] = ['A1:I32'];
                }

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
                    'A3:I23',
                    'A24', 'A25:I28',
                    'A32:I33'
                ]);

                // ALL BORDER MEDIUM
                $cells[1] = array_merge([
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                    'B24:I24'
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
                $cells[10] = array_merge([
                ]);

                // TBT - TOP BORDER THIN
                $cells[11] = array_merge([
                ]);

                // BBT
                $cells[12] = array_merge([
                    'A30:D30', 'F30:I30'
                ]);

                // LBT
                $cells[13] = array_merge([
                ]);

                // RBT
                $cells[14] = array_merge([
                ]);

                if(in_array($this->applicant->vessel->name, ['M/V KMARIN ATLANTICA', 'M/V KMARIN AZUR'])){
                    $cells[0] = array_merge(['A3:I24','A25', 'A26:I29']);
                    $cells[3] = array_merge(['B25:I25']);
                    $cells[12] = array_merge(['A31:D31', 'F31:I31']);
                }
                
                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                $event->sheet->getDelegate()->getStyle('A2:I33')->getFont()->setName('Calibri');
                $event->sheet->getDelegate()->getStyle('A2:I33')->getFont()->setSize(9);

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(11.2);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(11.2);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10.6);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(10.6);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(16.5);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(10);

                // ROW RESIZE
                $addRows = 1;
                $arr = [1, 15, 21, 22, 24, 25, 26, 27, 28, 29];

                if(in_array($this->applicant->vessel->name, ['M/V KMARIN ATLANTICA', 'M/V KMARIN AZUR'])){
                    $event->sheet->getDelegate()->getStyle('A2:I32')->getFont()->setName('Calibri');
                    $event->sheet->getDelegate()->getStyle('A2:I32')->getFont()->setSize(9);
                    $arr = [1, 16, 22, 23, 25, 26, 27, 28, 29, 30];
                }

                for($i = 1; $i <= 32; $i++){
                    if(!in_array($i, $arr)){
                        $event->sheet->getDelegate()->getRowDimension($i + $addRows)->setRowHeight(25);
                    }
                }

                if(in_array($this->applicant->vessel->name, ['M/V KMARIN ATLANTICA', 'M/V KMARIN AZUR'])){
                    $event->sheet->getParent()->getActiveSheet()->setBreak('A22', \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                }
                else{
                    $event->sheet->getParent()->getActiveSheet()->setBreak('A24', \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                }
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");
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
        $drawing->setOffsetY(50);
        $drawing->setCoordinates('A30');

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setName('MLC SEAL');
        $drawing2->setDescription('MLC SEAL');
        $drawing2->setPath(public_path("images/MLC_SEAL_BLUE.png"));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(110);
        $drawing2->setWidth(125);
        $drawing2->setOffsetX(40);
        $drawing2->setOffsetY(30);
        $drawing2->setCoordinates('C30');

        if(in_array($this->applicant->vessel->name, ['M/V KMARIN ATLANTICA', 'M/V KMARIN AZUR'])){
            $drawing->setOffsetY(30);
            $drawing->setCoordinates('A31');
            $drawing2->setOffsetY(10);
            $drawing2->setCoordinates('C31');
        }

        return [$drawing, $drawing2];
    }
}
