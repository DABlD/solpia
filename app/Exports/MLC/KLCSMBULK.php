<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KLCSMBULK implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $title = "MLC Contract"){
        $officialNo = null;
        $shipowner = null;
        $phoneNumber = null;
        $address = null;
        $employer = null;
        $identification = null;

        $temp = [
            'M/T SM NAVIGATOR' => "50983-19",
            'M/T SM FALCON' => "48922-17",
            "M/T SM OSPREY" => "48789-17",
            "M/T SM VENUS2" => "51157-20",
            "M/V CH BELLA" => "JJR-106189",
            "M/V CH CLARE" => "JJR-102152",
            "M/V CH DORIS" => "JJR-105192",
            "M/V CK ANGIE" => "JJR-111063",
            "M/V CK BLUEBELL" => "JJR-111067",
        ];

        if(in_array($applicant->vessel->name, ['M/T SM NAVIGATOR', 'M/T SM FALCON', 'M/T SM OSPREY', "M/T SM ALBATROSS", "M/T K. LOTUS", "M/T SM KESTREL", "FUELNG VENOSA"])){
            $shipowner = "KOREA LINE CORPORATION";
            $phoneNumber = "+82-2-3701-0114";
            $address = "SM R&D Center 78, Magkjungang 8-ro, Gangseo-gu, Seoul, Korea";
            $employer = "HAN SU HAN";
            $identification = "101-81-24624";
        }
        elseif(in_array($applicant->vessel->name, ["M/V CH BELLA","M/V CH CLARE","M/V CH DORIS","M/V CK ANGIE","M/V CK BLUEBELL"])){
            $shipowner = "CHANG MYUNG SHIPPING CO., LTD.";
            $phoneNumber = "+82-2-2175-7000";
            $address = "3F 30, Sinchonnyeok-ro, Seodaemun-gu, Seoul, Korea";
            $employer = "JUNG SUNG HO";
            $identification = "110-81-36497";
        }

        $applicant->vofficialNo = $temp[$applicant->vessel->name] ?? "-";
        $applicant->vshipowner = $shipowner;
        $applicant->vphoneNumber = $phoneNumber;
        $applicant->vaddress = $address;
        $applicant->vemployer = $employer;
        $applicant->videntification = $identification;

        if($applicant->pro_app->status != "Lined-Up"){
            $applicant->port = "ONBOARD " . $applicant->vessel->name;
        }

        $this->applicant    = $applicant;
        $this->title        = $title;
    }

    public function view(): View
    {
        $exportView = str_replace(' ', '_', $this->applicant->vessel->fleet) . '.klcsmBulk';
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
                        'rgb' => 'FFC000'
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
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.7);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.4);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.4);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.4);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.3);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

                $line = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
                $line->setPath(public_path('/images/horizontal_line.png'));
                $line->setHeight(10);

                $event->sheet->getDelegate()->getHeaderFooter()->setOddHeader('&LDOC/REV.NO. : MLC-F04/01 &G &R2025.04.11');
                $event->sheet->getDelegate()->getHeaderFooter()->addImage($line);
                
                // SET DEFAULT FONT
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(9);

                // CELL COLOR
                $event->sheet->getDelegate()->getStyle('D9:D13')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('K9:K11')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('C16')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('E16')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('C17')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('B25:B27')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('F24:F26')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('G56')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('C60')->getFont()->getColor()->setRGB('FF0000');
                $event->sheet->getDelegate()->getStyle('I73')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('G74')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('E110')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('E112')->getFont()->getColor()->setRGB('0000FF');

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
                    'D16', 'C16:C17', 'E16', 'F24:I26',
                    'D56:D62', 'E56:E62', 'I73', 'G74',
                    'E114:J121'
                ];

                // HC VC
                $h[4] = [
                    'A1', 'A3:A13', 'D3:D13', 'J3:K11',
                ];

                // HL
                $h[5] = [
                ];

                // B
                $h[6] = [
                    'A1', 'D3:D13', 'K3:K11',
                    'A15', 'A19', 'A22', 'A29', 'A43', 'C16:C17', 'E16', 'B25:B27', 'F24:F26',
                    'A51', 'D56:E63', 'A72', 'A87', 'A89', 'A110:K112', 'F121'
                ];

                // VC
                $h[7] = [
                    'B11', 'A20'
                ];

                // UNDERLINE
                $h[8] = [
                    'A59:C61'
                ];

                // JUSTIFY
                $h[9] = [
                    'A20'
                ];

                // RIGHT
                $h[10] = [
                    'H114'
                ];

                $h['wrap'] = [
                    'D9' ,'K11', 'D13', 'A20', 'A28:A49',
                    'A65:A99',
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'D5', 'F121'
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
                    'A62:K62'
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
                    'A3:K13', 'A25:I26'
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(4.5);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(4.5);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(4.5);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(20);

                // ROW RESIZE
                $rows = [
                    // [
                    //     12, //ROW HEIGHT
                    //     1,4 //START ROW, END ROW
                    // ],
                ];

                $rows2 = [
                    [
                        25,
                        [11,36,38,45,47,65,81,83,94,96,99]
                    ],
                    [40,[20,102]], [5,[35,37]], [60,[1]], [86,[108]], [50,[104,106]],
                    [17,[103,105,107,109,111]]
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
                $rows = [50, 100];
                foreach($rows as $row){
                    $event->sheet->getParent()->getActiveSheet()->setBreak('A' . $row, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
                }
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(20);
                // $event->sheet->getDelegate()->getStyle('A1:L150')->getFont()->setName('Arial');

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("10. ")->getFont()->setBold(true)->setName('Arial')->setSize(9);
                $rt->createText($event->sheet->getParent()->getActiveSheet()->getCell("A102")->getValue());
                $event->sheet->getParent()->getActiveSheet()->getCell("A102")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("11. ")->getFont()->setBold(true)->setName('Arial')->setSize(9);
                $rt->createText($event->sheet->getParent()->getActiveSheet()->getCell("A104")->getValue());
                $event->sheet->getParent()->getActiveSheet()->getCell("A104")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("12. ")->getFont()->setBold(true)->setName('Arial')->setSize(9);
                $rt->createText($event->sheet->getParent()->getActiveSheet()->getCell("A106")->getValue());
                $event->sheet->getParent()->getActiveSheet()->getCell("A106")->setValue($rt);

                $rt = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $rt->createTextRun("13. ")->getFont()->setBold(true)->setName('Arial')->setSize(9);
                $rt->createText($event->sheet->getParent()->getActiveSheet()->getCell("A108")->getValue());
                $event->sheet->getParent()->getActiveSheet()->getCell("A108")->setValue($rt);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path("images/smcmshipping.png"));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(27);
        $drawing->setWidth(100);
        $drawing->setOffsetX(20);
        $drawing->setOffsetY(100);
        $drawing->setCoordinates('K50');

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setPath(public_path("images/smcmshipping.png"));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(27);
        $drawing2->setWidth(100);
        $drawing2->setOffsetX(20);
        $drawing2->setOffsetY(100);
        $drawing2->setCoordinates('K100');

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setPath(public_path("images/smcmshipping.png"));
        $drawing3->setResizeProportional(false);
        $drawing3->setHeight(27);
        $drawing3->setWidth(100);
        $drawing3->setOffsetX(20);
        $drawing3->setOffsetY(150);
        $drawing3->setCoordinates('K122');

        $drawing4 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing4->setPath(public_path("images/shirley_sig.png"));
        $drawing4->setResizeProportional(false);
        $drawing4->setHeight(60);
        $drawing4->setWidth(185);
        $drawing4->setOffsetX(-25);
        $drawing4->setOffsetY(5);
        $drawing4->setCoordinates('J117');

        $drawing5 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing5->setPath(public_path("images/MLC_SEAL.png"));
        $drawing5->setResizeProportional(false);
        $drawing5->setHeight(100);
        $drawing5->setWidth(100);
        $drawing5->setOffsetX(-20);
        $drawing5->setOffsetY(1);
        $drawing5->setCoordinates('K117');

        $drawing6 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing6->setPath(public_path("images/mlc_klcsm_bulk.png"));
        $drawing6->setResizeProportional(false);
        $drawing6->setHeight(95);
        $drawing6->setWidth(300);
        $drawing6->setOffsetX(1);
        $drawing6->setOffsetY(1);
        $drawing6->setCoordinates('F115');

        // $drawing7 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        // $drawing7->setPath(public_path("images/cmshippingsig.png"));
        // $drawing7->setResizeProportional(false);
        // $drawing7->setHeight(70);
        // $drawing7->setWidth(160);
        // $drawing7->setOffsetX(-50);
        // $drawing7->setOffsetY(-15);
        // $drawing7->setCoordinates('K115');

        return [$drawing, $drawing2, $drawing3, $drawing4, $drawing5, $drawing6];
    }
}
