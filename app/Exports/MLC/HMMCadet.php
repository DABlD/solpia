<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HMMCadet implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $title = "HMM MLC"){
        // minus two;
        $mt = false;

        $array1 = [
            "M/V HMM DIAMOND", "M/V HMM OPAL", "M/V HMM SAPPHIRE", "M/V HMM AQUAMARINE",
            "M/V HMM GARNET", "M/V HMM PERIDOT", "M/V HMM LE HAVRE", "M/V HYUNDAI BRAVE",
            "M/V HYUNDAI COURAGE", "M/V HYUNDAI FAITH", "M/V HYUNDAI FORCE", "M/V HMM ALGECIRAS",
            "M/V HMM COPENHAGEN", "M/V HMM GDANSK", "M/V HMM HAMBURG", "M/V HMM OSLO",
            "M/V HMM SOUTHAMPTON", "M/V HMM ST. PETERSBURG", "M/V HYUNDAI GRACE", "M/V HYUNDAI UNITY",
            "M/V HMM COLOMBO", "M/V HMM VICTORY", "M/V HMM PRIDE", "M/V HMM FOREST", "M/V HMM GREEN",
            'M/V HYUNDAI JAKARTA'
        ];

        // FLEET C LAST 1 LINE
        $array2 = [
            "M/V HMM HARMONY","M/V HMM MASTER","M/V HMM MIRACLE","M/V HYUNDAI ANTWERP","M/V HYUNDAI ULSAN",
            "M/V HYUNDAI PARAMOUNT","M/V ATLANTIC AFFINITY","M/V OCEAN FLORA","M/V PACIFIC CHAMP",
            "M/V KRISTIAN OLDENDORFF","M/V ATLANTIC BONANZA",
            "M/T ORIENTAL AQUAMARINE", "M/T UNIVERSAL CHALLENGER", "M/T UNIVERSAL FRONTIER", "M/T UNIVERSAL INNOVATOR",
        ];

        $array3 = [
            "M/V GLOBAL ENTERPRISE","M/V HMM CEBU",
            'M/V MPV THALIA', 'M/V MPV URANIA'
        ];

        if(in_array($applicant->vessel->name, $array1)){
            $applicant->shipowner = "HMM Company Limited";
            $applicant->sPresident = "CHOI WONHYOK";
            $applicant->sAddress = "TOWER 1, PARC.1, 108, YEOUI-DAERO, YEONGDEUNGPO-GU, SEOUL, REPUBLIC OF KOREA";

            $applicant->crewManager = "HMM Ocean Service Co., Ltd.";
            $applicant->cAddress = "5TH FLOOR,BUSAN POST OFFICE BUILDING,JUNGANG-DAERO 63, JUNG-GU, BUSAN, REBUBLIC OF KOREA";
        }
        elseif(in_array($applicant->vessel->name, $array2)){
            $applicant->shipowner = "HMM Co., LTD.";
            $applicant->sPresident = "CHOI WONHYOK";
            $applicant->sAddress = "108, Yeouido-daero, Yeongdeungpo-gu, SEOUL, KOREA";

            $applicant->shipowner2 = "HMM Ocean Service Co., Ltd.";
            $applicant->sPresident2 = "Kim Gyoubong";
            $applicant->sAddress2 = "5th Floor, Busan office Building, Jungang-daero 63, Jung-gu, Busan 600-711, Korea";

            $applicant->crewManager = "HMM Ocean Service Co., Ltd.";
            $applicant->cAddress = "5th Floor, Busan office Building, Jungang-daero 63, Jung-gu, Busan 600-711, Korea";
        }
        elseif(in_array($applicant->vessel->name, $array3)){
            $applicant->shipowner = "HMM Company Limited";
            $applicant->sPresident = "CHOI WONHYOK";
            $applicant->sAddress = "TOWER 1, PARC.1, 108, YEOUI-DAERO, YEONGDEUNGPO-GU, SEOUL, REPUBLIC OF KOREA";

            $applicant->crewManager = "HMM Ocean Service Co., Ltd.";
            $applicant->cAddress = "5TH FLOOR,BUSAN POST OFFICE BUILDING,JUNGANG-DAERO 63, JUNG-GU, BUSAN, REBUBLIC OF KOREA";
        }

        $this->applicant    = $applicant;
        $this->title        = $title;
        $this->mt           = $mt;
    }

    public function view(): View
    {
        $principal = "hmm_cadet";

        $exportView = str_replace(' ', '_', $this->applicant->vessel->fleet) . '.' . $principal;

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
                $event->sheet->getDelegate()->setTitle($this->title, false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.4);
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
                    
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    'A36', 'E36'
                ];

                // HC VC
                $h[4] = [
                    'A1:A2', 'A4:A12', 'B4:B12', 'B12:G12',
                    'A15:H17', 'A18', 'A20:H22',
                    'A37:A39', 'E37:F39'
                ];

                // HL
                $h[5] = [
                ];

                // B
                $h[6] = [
                    'A1', 'A3',
                    'A13:A14', 'A19', 'A23', 'A25',
                    'A28', 'A30', 'A32'
                ];

                // VC
                $h[7] = [
                    "D4:D11",
                    'A13', 'A24', 'B18', 'A26:H27',
                    'A29', 'A31', 'A33'
                ];

                // UNDERLINE
                $h[8] = [
                    "A1"
                ];

                // JUSTIFY
                $h[9] = [
                    'A24', 'B18',
                    'A26', 'A27',
                    'A33', 'A34'
                ];

                $h['wrap'] = [
                    'D8', 'G12',
                    'D15', 'A18',
                    'A38'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'A36'
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
                    'A4:H12',
                    'A15:H18','A20:B22', 'A24:H24',
                    'A38:H39'
                ]);

                // ALL BORDER MEDIUM
                $cells[1] = array_merge([
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                    'C20:H21', 'C22:H22', 'A26:H27',
                    'A29:H29','A31:H31','A33:H33',
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
                    'A36:C36', 'E36:G36'
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
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(28);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(9);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(10);

                $event->sheet->getDelegate()->getRowDimension(17)->setRowHeight(31);
                $event->sheet->getDelegate()->getRowDimension(18)->setRowHeight(50);
                $event->sheet->getDelegate()->getRowDimension(24)->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension(26)->setRowHeight(65);
                $event->sheet->getDelegate()->getRowDimension(27)->setRowHeight(35);
                $event->sheet->getDelegate()->getRowDimension(29)->setRowHeight(190);
                $event->sheet->getDelegate()->getRowDimension(31)->setRowHeight(65);
                $event->sheet->getDelegate()->getRowDimension(33)->setRowHeight(80);
                $event->sheet->getDelegate()->getRowDimension(34)->setRowHeight(50);
                $event->sheet->getDelegate()->getRowDimension(35)->setRowHeight(210);

                $rows = [
                    [
                        30, //ROW HEIGHT
                        1,12 //START ROW, END ROW
                    ],
                    [22,13,16],
                    [15,20,21],
                ];

                $rows2 = [
                    [
                        22,
                        [2,3,19,22,23,25,28,30,32,36,37,38,39,40]
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

                // ROW RESIZE
                // $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(90);
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->setSize(11);

                $event->sheet->getDelegate()->getStyle('A29:A33')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('A29:A33')->getFont()->setName('Times New Roman');

                $event->sheet->getDelegate()->getStyle('D17')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('D17')->getFont()->setName('Times New Roman');

                $event->sheet->getDelegate()->getStyle('D15')->getFont()->setSize(9);

                $event->sheet->getParent()->getActiveSheet()->setBreak('A27', \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path('images/MLC_SEAL.png'));
        $drawing->setCoordinates('F36');
        $drawing->setHeight(120);
        $drawing->setWidth(120);
        $drawing->setOffsetX(100);
        $drawing->setOffsetY(-100);

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setName('mlc_hmm_sig');
        $drawing3->setDescription('mlc_hmm_sig');
        $drawing3->setPath(public_path("images/mlc_hmm_sig.jpg"));
        $drawing3->setCoordinates('E36');
        $drawing3->setHeight(110);
        $drawing3->setWidth(110);
        $drawing3->setOffsetX(2);
        $drawing3->setOffsetY(-100);

        return [$drawing3, $drawing];
    }
}
