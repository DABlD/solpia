<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class Toei implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant,$type){
        $this->applicant = $applicant;
        $this->type = $type;
    }

    public function view(): View
    {
        return view('exports.' . $this->type, [
            'applicant' => $this->applicant
        ]);
    }

    public function registerEvents(): array
    {
        $borderStyle = [
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
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
            [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '808080'
                        ]
                    ],
                ],
            ]
        ];

        $fillStyle = [
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'ced4da'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'ffc000'
                    ]
                ],
            ],
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
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('BIODATA', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                $event->sheet->getParent()->getActiveSheet()->getDefaultColumnDimension()->setWidth(11);
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);

                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

                // $event->sheet->getDelegate()->getStyle('E19')->getFont()->getColor()->setRGB('FF0000');
                // $event->sheet->getDelegate()->getStyle('H19')->getFont()->getColor()->setRGB('FF0000');
                // $event->sheet->getDelegate()->getStyle('B20')->getFont()->getColor()->setRGB('FF0000');
                // $event->sheet->getDelegate()->getStyle('F20')->getFont()->getColor()->setRGB('FF0000');

                // $start = 31 + $this->applicant->educational_background->count();
                // for($i = $start; $i < $start + 4; $i++){
                //     $event->sheet->getDelegate()->getStyle("A$i")->getFont()->getColor()->setRGB('FF0000');
                // }

                // $start = $i + 2;
                // for($i = $start; $i < $start + 6; $i++){
                //     $event->sheet->getDelegate()->getStyle("A$i")->getFont()->getColor()->setRGB('FF0000');
                //     if(($i + 1) == ($start + 6)){
                //         $event->sheet->getDelegate()->getStyle("H$i")->getFont()->getColor()->setRGB('FF0000');
                //     }
                // }

                // $event->sheet->getDelegate()->getDefaultStyle()->getFont()->setName('Arial');
                // $event->sheet->getDelegate()->getDefaultStyle()->getFont()->setSize(10);

                // FONT SIZES

                // ROWS
                $rows = [

                ];

                // FOR BORDER BOTOTM
                $cells[2] = array();

                // EDUCATION BACKGROUND ROWS
                $ebRows = array();
                $temp = $this->applicant->educational_background->count();
                $rae = 27 + $temp; //Row # AFTER EDUC BACKGROUND

                for($i = 0, $row = 28; $i < $temp; $i++, $row++){
                    array_push($ebRows, "A$row");
                    array_push($ebRows, "B$row");
                    array_push($ebRows, "C$row:F$row");
                    array_push($ebRows, "G$row:I$row");
                }

                // LICENSES ROWS
                $lRows = array();
                $temp = 5;
                $ral = $rae + 2 + $temp; //Row # AFTER LICENSES

                for($i = 0, $row = $rae + 2; $i < $temp; $i++, $row++){
                    array_push($lRows, "A$row:B$row");
                    array_push($lRows, "C$row:D$row");
                    array_push($lRows, "E$row");
                    array_push($lRows, "F$row");
                    array_push($lRows, "G$row");
                    array_push($lRows, "H$row:I$row");
                }

                // CERTIFICATE ROWS
                $cRows = array();
                $temp = 7;
                $rac = $ral + 1 + $temp; //Row # AFTER CERTIFICATES

                for($i = 0, $row = $ral + 1; $i < $temp; $i++, $row++){
                    array_push($cRows, "A$row:B$row");
                    array_push($cRows, "C$row:D$row");
                    array_push($cRows, "E$row");
                    array_push($cRows, "F$row");
                    array_push($cRows, "G$row");
                    array_push($cRows, "H$row:I$row");
                }

                // OTHER CERTIFICATE ROWS
                $ocRows = array();
                $temp = 16;
                $raoc = $rac + 1 + $temp; //Row # AFTER OTHER CERTIFICATES

                for($i = 0, $row = $rac + 1; $i < $temp; $i++, $row++){
                    array_push($ocRows, "A$row:D$row");
                    array_push($ocRows, "E$row");
                    array_push($ocRows, "F$row");
                    array_push($ocRows, "G$row");
                    array_push($ocRows, "H$row:I$row");
                }

                // PIYC
                $piycRows = array(); //WILL BE FILLED AFTER FUNCTIONS
                $rapiyc = $raoc + 1 + 6; //Row # AFTER PIYC (5 = rows)

                // EAJL CERTIFICATE ROWS
                $eajlRows = array();
                $temp = 3;
                $raeajl = $rapiyc + 1 + $temp; //Row # AFTER OTHER PIYC

                for($i = 0, $row = $rapiyc + 1; $i < $temp; $i++, $row++){
                    array_push($eajlRows, "A$row:B$row");
                    array_push($eajlRows, "C$row");
                    array_push($eajlRows, "D$row");
                    array_push($eajlRows, "E$row");
                    array_push($eajlRows, "F$row");
                    array_push($eajlRows, "G$row");
                    array_push($eajlRows, "H$row");
                    array_push($eajlRows, "I$row");
                }

                // TESMS CERTIFICATE ROWS
                $tesmsRows = array();
                $temp = 3;
                $ratesms = $raeajl + 1 + $temp; //Row # AFTER TESMS

                for($i = 0, $row = $raeajl + 1; $i < $temp; $i++, $row++){
                    array_push($eajlRows, "A$row:D$row");
                    array_push($eajlRows, "E$row");
                    array_push($eajlRows, "F$row:G$row");
                    array_push($eajlRows, "H$row:I$row");
                }

                // AOW CERTIFICATE ROWS
                $aowRows = array();
                $temp = 2;
                $raaow = $ratesms + 1 + $temp; //Row # AFTER AOW

                for($i = 0, $row = $ratesms + 1; $i < $temp; $i++, $row++){
                    array_push($aowRows, "A$row:B$row");
                    array_push($aowRows, "C$row");
                    array_push($aowRows, "D$row");
                    array_push($aowRows, "E$row");
                    array_push($aowRows, "F$row");
                    array_push($aowRows, "G$row");
                    array_push($aowRows, "H$row:I$row");
                }

                // SH1 ROWS
                $sh1Rows = array();
                $temp = 6;
                $rash1 = $raaow + 1 + $temp; //Row # AFTER sh1

                for($i = 0, $row = $raaow + 1; $i < $temp; $i++, $row++){
                    array_push($sh1Rows, "A$row");

                    if(($i+1) == $temp){
                        $row++;
                        $event->sheet->getDelegate()->getStyle("D$row")->getFont()->setSize(9);
                        $row++;
                        $event->sheet->getDelegate()->getStyle("H$row")->getFont()->setSize(9);
                    }
                }

                // SH2 ROWS
                $sh2Rows = array();
                $row = $rash1;
                $row2 = $rash1+1;
                $rash2 = $rash1 + 2; //Row # AFTER sh2;

                array_push($sh2Rows, "A$row:B$row2");
                array_push($sh2Rows, "C$row:C$row2");
                array_push($sh2Rows, "D$row:E$row2");
                array_push($sh2Rows, "F$row:F$row2");
                array_push($sh2Rows, "G$row:G$row2");
                array_push($sh2Rows, "H$row:I$row2");

                // SH3 ROWS
                $sh3Rows = array();
                $temp = $this->applicant->sea_service->count();
                $rash3 = $rash2 + ($temp * 2) + 1; //Row # AFTER sh2;

                for($i = 0, $row = $rash2, $row2 = $row+1; $i < $temp; $i++, $row+=2, $row2+=2){
                    array_push($sh3Rows, "A$row:B$row2");
                    array_push($sh3Rows, "C$row:C$row2");
                    array_push($sh3Rows, "D$row:E$row2");
                    array_push($sh3Rows, "F$row:F$row2");
                    array_push($sh3Rows, "G$row:G$row2");
                    array_push($sh3Rows, "H$row:I$row2");

                    $event->sheet->getDelegate()->getStyle("D$row2")->getFont()->setSize(10);
                    $event->sheet->getDelegate()->getStyle("C$row")->getFont()->setSize(10);

                    // FOR BOTTOM BORDER
                    array_push($cells[2], "A$row:I$row");
                }

                // NUMBER HEADING ROWS
                $nhr = [
                    'A26', 'A' . ($rae + 1), 'A' . $ral, 'A' . $rac, 'A' . $raoc, 'A' . $rapiyc, 'A' . $raeajl,
                    'A' . $ratesms, 'A' . $raaow
                ];

                // FUNCTIONS
                $piyc = function($col, $inc) use($raoc){
                    return $col . ($raoc + $inc);
                };

                $piycRows = array(
                    // $piyc('A', 1) . ':' . $piyc('D', 1), $piyc('E', 1), $piyc('F', 1), $piyc('G', 1), $piyc('H', 1) . ':' . $piyc('I', 1),
                    // $piyc('A', 2) . ':' . $piyc('D', 3), $piyc('E', 2), $piyc('E', 3), $piyc('F', 2) . ':' . $piyc('F', 3),
                    // $piyc('G', 2) . ':' . $piyc('G', 3), $piyc('H', 2) . ':' . $piyc('H', 3), $piyc('I', 2) . ':' . $piyc('I', 3),

                    $piyc('A', 1) . ':' . $piyc('D', 1), $piyc('E', 1), $piyc('F', 1), $piyc('G', 1), $piyc('H', 1), $piyc('I', 1),
                    $piyc('A', 2) . ':' . $piyc('D', 2), $piyc('E', 2), $piyc('F', 2), $piyc('G', 2), $piyc('H', 2), $piyc('I', 2),
                    $piyc('A', 3) . ':' . $piyc('D', 3), $piyc('E', 3), $piyc('F', 3), $piyc('G', 3), $piyc('H', 3), $piyc('I', 3),
                    $piyc('A', 4) . ':' . $piyc('D', 4), $piyc('E', 4), $piyc('F', 4), $piyc('G', 4), $piyc('H', 4), $piyc('I', 4),
                    $piyc('A', 5) . ':' . $piyc('D', 5), $piyc('E', 5), $piyc('F', 5), $piyc('G', 5), $piyc('H', 5), $piyc('I', 5),
                    $piyc('A', 6) . ':' . $piyc('D', 6), $piyc('E', 6), $piyc('F', 6), $piyc('G', 6), $piyc('H', 6), $piyc('I', 6),
                );
                
                // HEADINGS

                // HC B
                $h[0] = [
                    
                ];

                // VT
                $h[1] = [
                    
                ];

                // HC
                $h[3] = [
                    'A1:I150'
                ];

                // HL B
                $h[2] = array_merge($nhr, [
                    
                ]);

                // HL
                $h[4] = array_merge($sh1Rows, [
                    ('A' . ($rapiyc - 5) . ':' . 'A' . ($rapiyc - 1)), //A#:A# PIYC ROWS
                    ('A' . ($raeajl - 2) . ':' . 'A' . ($raeajl - 1)), //A#:A# PIYC ROWS
                    ('A' . ($ratesms - 2) . ':' . 'A' . ($ratesms - 1)), //A#:A# PIYC ROWS
                    ('A' . ($raaow - 1)), //A#:A# PIYC ROWS
                    'B15', 'B25'
                ]);

                // HC VC
                $h[5] = [
                    ('A' . ($rapiyc - 6) . ':' . 'I' . ($rapiyc - 6))
                ];

                // B
                $h[6] = [
                    
                ];

                $h['stf'] = [
                    "A1:I$rash3"
                ];

                $h['wrap'] = [
                    ('E' . ($rapiyc - 6))
                ];

                // $event->sheet->getDelegate()->getStyle('A1:N60')->getAlignment()->setWrapText(true);
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
                $fills = array_merge($sh2Rows, [
                    
                ]);

                foreach($fills as $fill){
                    $event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle[0]);
                }

                foreach($nhr as $fill){
                    $event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle[0]);
                }

                $event->sheet->getDelegate()->getStyle("D11")->applyFromArray($fillStyle[1]);
                $event->sheet->getDelegate()->getStyle("H11:I11")->applyFromArray($fillStyle[1]);

                // BORDERS

                // $sh3Rows = array();
                // ALL AROUND
                $cells[0] = array_merge($rows, $ebRows, $lRows, $cRows, $ocRows, $piycRows, $eajlRows, $aowRows, $sh2Rows, $sh3Rows, [
                    'A2:B9', 'H1:I1', 'H2', 'I2', 'H3:H5', 'I3:I5',
                    'A27:B27', 'C27:F27', 'G27:I27',
                ]);

                // BOTTOM ONLY
                $cells[1] = [
                    'E7:F7', 'H7:I7', 'H9:I9', 'B11', 'D11', 'D19', 'H20', 'F11', 'H11:I11', 'B12:G12',
                    'B15:F15', 'H15:I15', 'H16:I16', 'B17', 'D17', 'F17:G17', 'I17',
                    'G17', 'I17', 'B18:C18', 'E18', 'G18', 'B19:C19', 'E19', 'G19', 'I19',
                    'F20', 'I20', 'D21:E21', 'G22:I22', 'B23:I23', 'B25:F25', 'G25:I25',
                    "C$rash3:E$rash3", "G$rash3:I$rash3"
                ];


                foreach($cells as $key => $value) {
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // COLUMN RESIZE

                // $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(12.5);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(13);
                $event->sheet->getDelegate()->getStyle("G$rash3")->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle("G$rash3")->getFont()->setSize(9);
                // $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                // $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                // $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(4);

                for($i = 11; $i <= ($rash3 + 1); $i++){
                    if($i = ($rapiyc - 6)){
                        return;
                    }
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(15);
                }

                $rash3 += 1;

                // SET PRINT AREA
                $event->sheet->getDelegate()->getPageSetup()->setPrintArea("A1:I$rash3");
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path($this->applicant->user->avatar));
        $drawing->setResizeProportional(false);
        $drawing->setWidth(152);
        $drawing->setHeight(134);
        $drawing->setOffsetX(2);
        $drawing->setOffsetY(1);
        $drawing->setCoordinates('A2');

        return $drawing;
    }
}