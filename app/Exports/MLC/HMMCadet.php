<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HMMCadet implements FromView, WithEvents//, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $title = "HMM MLC"){
        $array1 = [
            'M/V HMM MIR', 'M/V HYUNDAI BRAVE', 'M/V HYUNDAI FAITH', 'M/V HMM ST. PETERSBURG', 'M/V HMM LE HAVRE', 'M/V HYUNDAI COURAGE', 'M/V HMM RAON', 'M/V HMM GARAM', 'M/V HMM NURI', 'M/V HMM HANBADA', 'M/V HYUNDAI FORCE', 'M/V HYUNDAI UNITY', 'M/V HYUNDAI GRACE', 'M/V HYUNDAI COLOMBO', 'M/V HYUNDAI ANTWERP', 'M/V HYUNDAI ULSAN'
        ];

        $array2 = [
            'MT C. GUARDIAN', 'MT UNIVERSAL CHALLENGER', 'MT PACIFIC M', "MT NEPTUNE M"
        ];

        $array3 = [
            'M/V HMM ALGECIRAS', 'M/V HMM OSLO', 'M/V HMM COPENHAGEN', 'M/V HMM GDANSK', 'M/V HMM HAMBURG', 'M/V HMM SOUTHAMPTON'
        ];

        $array4 = [
            'M/V HMM AMETHYST'
        ];

        $array5 = [
            'M/V ATLANTIC AFFINITY', 'M/V PACIFIC CHAMP'
        ];

        // minus two;
        $mt = false;

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
                ];

                // HC VC
                $h[4] = [
                    'A1:A2', 'A4:A12', 'B4:B12', 'B12:G12',
                    'A15:H17', 'A18', 'A20:H22'
                ];

                // HL
                $h[5] = [
                ];

                // B
                $h[6] = [
                    'A1', 'A3',
                    'A13:A14', 'A19', 'A23', 'A25'
                ];

                // VC
                $h[7] = [
                    "D4:D11",
                    'A13', 'A24', 'B18', 'A26:H27'
                ];

                // UNDERLINE
                $h[8] = [
                    "A1"
                ];

                // JUSTIFY
                $h[9] = [
                    'A24', 'B18',
                    'A26', 'A27'
                ];

                $h['wrap'] = [
                    'D8', 'G12',
                    'D15', 'A18',
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
                    'A4:H12',
                    'A15:H18','A20:B22', 'A24:H24'
                ]);

                // ALL BORDER MEDIUM
                $cells[1] = array_merge([
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                    'C20:H21', 'C22:H22', 'A26:H27'
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
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(19);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(6);

                $event->sheet->getDelegate()->getRowDimension(18)->setRowHeight(50);
                $event->sheet->getDelegate()->getRowDimension(24)->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension(26)->setRowHeight(70);
                $event->sheet->getDelegate()->getRowDimension(27)->setRowHeight(40);

                $rows = [
                    [
                        30, //ROW HEIGHT
                        1,12 //START ROW, END ROW
                    ],
                    [22,13,17],
                    [15,20,21],
                ];

                $rows2 = [
                    [
                        22,
                        [2,3,19,22,23,25]
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
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setName('Arial');
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
        $drawing->setHeight(115);
        $drawing->setWidth(2200);
        $drawing->setOffsetX(4);
        $drawing->setOffsetY(4);
        $drawing->setCoordinates('C1');

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setName('Avatar');
        $drawing2->setDescription('Avatar');
        $drawing2->setPath(public_path($this->data->user->avatar));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(230);
        $drawing2->setWidth(230);
        $drawing2->setOffsetX(5);
        $drawing2->setOffsetY(2);
        $drawing2->setCoordinates('C3');

        return [$drawing, $drawing2];
    }
}
