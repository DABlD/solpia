<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Smtech implements FromView, WithEvents, WithDrawings, WithColumnFormatting//, ShouldAutoSize
{
    public function __construct($applicant,$type){
        $this->applicant = $applicant;
        $this->type = $type;
        $this->formatCols = [];
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
            ],
            [
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                    ],
                ]
            ],
            [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [
                'borders' => [
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
                    ],
                ]
            ],
            [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
                    ],
                ]
            ],
            [
                'borders' => [
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
                    ],
                ]
            ],
            [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
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
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
            [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
                    ],
                ],
            ]
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
                        'rgb' => 'B8CCE4'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'D8E4BC'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => '92D050'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'FDE9D9'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'FFC000'
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
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.2);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);

                $event->sheet->getParent()->getActiveSheet()->getDefaultColumnDimension()->setWidth(11);
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Times New Roman');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(8.5);

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
                // $event->sheet->getDelegate()->getDefaultStyle()->getFont()->setSize(9.5);

                // FONT SIZES

                // ROWS
                $rows = [

                ];

                // FOR BORDER BOTOTM
                $cells[2] = array();
                // BORDER HAIR TOP
                $cells[7] = array();
                // BORDER HAIR BOTTON
                $cells[8] = array();
                // BORDER HAIR LEFT
                $cells[9] = array();
                // BORDER HAIR RIGHT
                $cells[10] = array();
                // BORDER THIN BOTTOM
                $cells[11] = array();
                // BORDER THIN LR
                $cells[12] = array();
                // BORDER HAIR R
                $cells[13] = array();

                // EDUCATION BACKGROUND ROWS
                $ebRows = array();
                $temp = $this->applicant->educational_background->count();
                $rae = 29 + $temp; //Row # AFTER EDUC BACKGROUND

                for($i = 0, $row = 29; $i < $temp; $i++, $row++){
                    if ($i+1 == $temp) {
                        array_push($cells[11], "A$row");
                        array_push($cells[11], "B$row");
                        array_push($cells[11], "C$row:F$row");
                        array_push($cells[11], "G$row:I$row");
                    }

                    if($i >= 1){
                        array_push($cells[7], "A$row");
                        array_push($cells[7], "B$row");
                        array_push($cells[7], "C$row:F$row");
                        array_push($cells[7], "G$row:I$row");
                    }

                    array_push($cells[12], "A$row");
                    array_push($cells[12], "B$row");
                    array_push($cells[12], "C$row:F$row");
                    array_push($cells[12], "G$row:I$row");
                }

                // LICENSES ROWS
                $lRows = array();
                $temp = 5;
                $ral = $rae + 2 + $temp; //Row # AFTER LICENSES

                for($i = 0, $row = $rae + 2; $i < $temp; $i++, $row++){
                    if($i == 0){
                        array_push($lRows, "A$row:B$row");
                        array_push($lRows, "C$row:D$row");
                        array_push($lRows, "E$row");
                        array_push($lRows, "F$row");
                        array_push($lRows, "G$row");
                        array_push($lRows, "H$row:I$row");
                    }
                    elseif($i+1 == $temp){
                        array_push($cells[11], "A$row:B$row");
                        array_push($cells[11], "C$row:D$row");
                        array_push($cells[11], "E$row");
                        array_push($cells[11], "F$row");
                        array_push($cells[11], "G$row");
                        array_push($cells[11], "H$row:I$row");
                    }

                    if($i >= 2){
                        array_push($cells[7], "A$row:B$row");
                        array_push($cells[7], "C$row:D$row");
                        array_push($cells[7], "E$row");
                        array_push($cells[7], "F$row");
                        array_push($cells[7], "G$row");
                        array_push($cells[7], "H$row:I$row");
                    }

                    array_push($cells[12], "A$row:B$row");
                    array_push($cells[12], "C$row:D$row");
                    array_push($cells[12], "E$row");
                    array_push($cells[12], "F$row");
                    array_push($cells[12], "G$row");
                    array_push($cells[12], "H$row:I$row");
                }

                // CERTIFICATE ROWS
                $cRows = array();
                $temp = 9;
                $rac = $ral + 1 + $temp; //Row # AFTER CERTIFICATES

                for($i = 0, $row = $ral + 1; $i < $temp; $i++, $row++){
                    if($i == 0){
                        array_push($cRows, "A$row:B$row");
                        array_push($cRows, "C$row:D$row");
                        array_push($cRows, "E$row");
                        array_push($cRows, "F$row");
                        array_push($cRows, "G$row");
                        array_push($cRows, "H$row:I$row");
                    }
                    elseif($i+1 == $temp){
                        array_push($cells[11], "A$row:B$row");
                        array_push($cells[11], "C$row:D$row");
                        array_push($cells[11], "E$row");
                        array_push($cells[11], "F$row");
                        array_push($cells[11], "G$row");
                        array_push($cells[11], "H$row:I$row");
                    }

                    if($i >= 2){
                        array_push($cells[7], "A$row:B$row");
                        array_push($cells[7], "C$row:D$row");
                        array_push($cells[7], "E$row");
                        array_push($cells[7], "F$row");
                        array_push($cells[7], "G$row");
                        array_push($cells[7], "H$row:I$row");
                    }

                    array_push($cells[12], "A$row:B$row");
                    array_push($cells[12], "C$row:D$row");
                    array_push($cells[12], "E$row");
                    array_push($cells[12], "F$row");
                    array_push($cells[12], "G$row");
                    array_push($cells[12], "H$row:I$row");
                }

                // OTHER CERTIFICATE ROWS
                $ocRows = array();
                $temp = 18;

                // IF RANK IS CO ADD 1 ROW BECAUSE OF SHIP SAFETY OFFICER
                if($this->applicant->rank->id == 2){
                    $temp += 1;
                }

                $raoc = $rac + 1 + $temp; //Row # AFTER OTHER CERTIFICATES

                $hl = false;
                if($this->applicant->rank){
                    foreach($this->applicant->document_lc as $lc){
                        if($lc->type == "COC"){
                            $regulations = json_decode($lc->regulation);

                            if(in_array("II/1", $regulations) || in_array("III/1", $regulations)){
                                $hl = true;
                            }
                        }
                    }
                }

                // FOR MARINA COP
                // if($this->applicant->rank){
                //     // DECK
                //     $rid = $this->applicant->rank->id;

                //     if(($rid == 10 && $hl) || ($rid == 16 && $hl) || ($rid == 11 && $hl) || ($rid == 17 && $hl)){
                //         $start = $raoc;
                //         $end = $raoc;
                //         $start2 = $start+1;
                //         $end2 = $end+1;
                //         $raoc += 2;
                //         $temp += 2;
                //     }
                //     elseif(in_array($rid, [10,16]) || ($rid == 11 && $hl) || ($rid == 17 && $hl)){
                //         $start = $raoc;
                //         $end = $raoc;
                //         $raoc += 1;
                //         $temp += 1;
                //     }
                // }

                for($i = 0, $row = $rac + 1; $i < $temp; $i++, $row++){
                    if($i == 0){
                        array_push($ocRows, "A$row:D$row");
                        array_push($ocRows, "E$row");
                        array_push($ocRows, "F$row");
                        array_push($ocRows, "G$row");
                        array_push($ocRows, "H$row:I$row");
                    }
                    elseif($i+1 == $temp){
                        array_push($cells[11], "A$row:D$row");
                        array_push($cells[11], "E$row");
                        array_push($cells[11], "F$row");
                        array_push($cells[11], "G$row");
                        array_push($cells[11], "H$row:I$row");
                    }

                    if($i >= 2){
                        array_push($cells[7], "A$row:D$row");
                        array_push($cells[7], "E$row");
                        array_push($cells[7], "F$row");
                        array_push($cells[7], "G$row");
                        array_push($cells[7], "H$row:I$row");
                    }

                    array_push($cells[12], "A$row:D$row");
                    array_push($cells[12], "E$row");
                    array_push($cells[12], "F$row");
                    array_push($cells[12], "G$row");
                    array_push($cells[12], "H$row:I$row");

                    array_push($cells[13], "A$row");
                }

                // PIYC
                $piycRows = array(); //WILL BE FILLED AFTER FUNCTIONS
                $rapiyc = $raoc + 1 + 7; //Row # AFTER PIYC (5 = rows)

                // COVID
                $covidRows = array(); //WILL BE FILLED AFTER FUNCTIONS
                $temp = 3;
                $racovid = $rapiyc + 1 + 3; //Row # AFTER COVID (5 = rows)

                for($i = 0, $row = $rapiyc + 1; $i < $temp; $i++, $row++){
                    if($i == 0){
                        array_push($covidRows, "A$row:C$row");
                        array_push($covidRows, "D$row");
                        array_push($covidRows, "E$row");
                        array_push($covidRows, "F$row");
                        array_push($covidRows, "G$row");
                        array_push($covidRows, "H$row");
                        array_push($covidRows, "I$row");
                    }
                    elseif($i+1 == $temp){
                        array_push($cells[11], "A$row:C$row");
                        array_push($cells[11], "D$row");
                        array_push($cells[11], "E$row");
                        array_push($cells[11], "F$row");
                        array_push($cells[11], "G$row");
                        array_push($cells[11], "H$row");
                        array_push($cells[11], "I$row");
                    }

                    if($i >= 2){
                        array_push($cells[7], "A$row:C$row");
                        array_push($cells[7], "D$row");
                        array_push($cells[7], "E$row");
                        array_push($cells[7], "F$row");
                        array_push($cells[7], "G$row");
                        array_push($cells[7], "H$row");
                        array_push($cells[7], "I$row");
                    }

                    array_push($cells[12], "A$row:C$row");
                    array_push($cells[12], "D$row");
                    array_push($cells[12], "E$row");
                    array_push($cells[12], "F$row");
                    array_push($cells[12], "G$row");
                    array_push($cells[12], "H$row");
                    array_push($cells[12], "I$row");

                    array_push($cells[13], "A$row");
                }

                // EAJL CERTIFICATE ROWS
                $eajlRows = array();
                $temp = 3;
                $raeajl = $racovid + 1 + $temp; //Row # AFTER OTHER EAJL

                for($i = 0, $row = $racovid + 1; $i < $temp; $i++, $row++){

                    if($i == 0){
                        array_push($eajlRows, "A$row:B$row");
                        array_push($eajlRows, "C$row");
                        array_push($eajlRows, "D$row");
                        array_push($eajlRows, "E$row");
                        array_push($eajlRows, "F$row");
                        array_push($eajlRows, "G$row");
                        array_push($eajlRows, "H$row");
                        array_push($eajlRows, "I$row");
                    }
                    elseif($i+1 == $temp){
                        array_push($cells[11], "A$row:B$row");
                        array_push($cells[11], "C$row");
                        array_push($cells[11], "D$row");
                        array_push($cells[11], "E$row");
                        array_push($cells[11], "F$row");
                        array_push($cells[11], "G$row");
                        array_push($cells[11], "H$row");
                        array_push($cells[11], "I$row");
                    }

                    if($i >= 2){
                        array_push($cells[7], "A$row:B$row");
                        array_push($cells[7], "C$row");
                        array_push($cells[7], "D$row");
                        array_push($cells[7], "E$row");
                        array_push($cells[7], "F$row");
                        array_push($cells[7], "G$row");
                        array_push($cells[7], "H$row");
                        array_push($cells[7], "I$row");
                    }
                    
                    array_push($cells[12], "A$row:B$row");
                    array_push($cells[12], "C$row");
                    array_push($cells[12], "D$row");
                    array_push($cells[12], "E$row");
                    array_push($cells[12], "F$row");
                    array_push($cells[12], "G$row");
                    array_push($cells[12], "H$row");
                    array_push($cells[12], "I$row");
                }

                // TESMS CERTIFICATE ROWS
                $tesmsRows = array();
                $temp = 3;
                $ratesms = $raeajl + 1 + $temp; //Row # AFTER TESMS

                for($i = 0, $row = $raeajl + 1; $i < $temp; $i++, $row++){
                    if($i == 0){
                        array_push($eajlRows, "A$row:D$row");
                        array_push($eajlRows, "E$row");
                        array_push($eajlRows, "F$row:G$row");
                        array_push($eajlRows, "H$row:I$row");
                    }
                    elseif($i+1 == $temp){
                        array_push($cells[11], "A$row:D$row");
                        array_push($cells[11], "E$row");
                        array_push($cells[11], "F$row:G$row");
                        array_push($cells[11], "H$row:I$row");
                    }

                    if($i >= 2){
                        array_push($cells[7], "A$row:D$row");
                        array_push($cells[7], "E$row");
                        array_push($cells[7], "F$row:G$row");
                        array_push($cells[7], "H$row:I$row");
                    }

                    array_push($cells[12], "A$row:D$row");
                    array_push($cells[12], "E$row");
                    array_push($cells[12], "F$row:G$row");
                    array_push($cells[12], "H$row:I$row");
                }

                // AOW CERTIFICATE ROWS
                $aowRows = array();
                $temp = 2;
                $raaow = $ratesms + 1 + $temp; //Row # AFTER AOW

                for($i = 0, $row = $ratesms + 1; $i < $temp; $i++, $row++){
                    if($i == 0){
                        array_push($aowRows, "A$row:B$row");
                        array_push($aowRows, "C$row");
                        array_push($aowRows, "D$row");
                        array_push($aowRows, "E$row");
                        array_push($aowRows, "F$row");
                        array_push($aowRows, "G$row");
                        array_push($aowRows, "H$row:I$row");
                    }
                    elseif($i+1 == $temp){
                        array_push($cells[11], "A$row:B$row");
                        array_push($cells[11], "C$row");
                        array_push($cells[11], "D$row");
                        array_push($cells[11], "E$row");
                        array_push($cells[11], "F$row");
                        array_push($cells[11], "G$row");
                        array_push($cells[11], "H$row:I$row");
                    }

                    if($i >= 2){
                        array_push($cells[7], "A$row:B$row");
                        array_push($cells[7], "C$row");
                        array_push($cells[7], "D$row");
                        array_push($cells[7], "E$row");
                        array_push($cells[7], "F$row");
                        array_push($cells[7], "G$row");
                        array_push($cells[7], "H$row:I$row");
                    }

                    array_push($cells[12], "A$row:B$row");
                    array_push($cells[12], "C$row");
                    array_push($cells[12], "D$row");
                    array_push($cells[12], "E$row");
                    array_push($cells[12], "F$row");
                    array_push($cells[12], "G$row");
                    array_push($cells[12], "H$row:I$row");
                }

                // SH1 ROWS
                $sh1Rows = array();
                $temp = 6;
                $rash1 = $raaow + 1 + $temp; //Row # AFTER sh1

                for($i = 0, $row = $raaow + 1; $i < $temp; $i++, $row++){
                    array_push($sh1Rows, "A$row");

                    if(($i+1) == $temp){
                        $row++;
                        $event->sheet->getDelegate()->getStyle("D$row")->getFont()->setSize(8.5);
                        $row++;
                        $event->sheet->getDelegate()->getStyle("H$row")->getFont()->setSize(8.5);
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
                if($temp > 12){
                    $temp = 12;
                }
                $rash3 = $rash2 + ($temp * 2) + 1; //Row # AFTER sh2;

                for($i = 0, $row = $rash2, $row2 = $row+1; $i < $temp; $i++, $row+=2, $row2+=2){
                    array_push($sh3Rows, "A$row:B$row2");
                    array_push($sh3Rows, "C$row:C$row2");
                    array_push($sh3Rows, "D$row:E$row2");
                    array_push($sh3Rows, "F$row:F$row2");
                    array_push($sh3Rows, "G$row:G$row2");
                    array_push($sh3Rows, "H$row:I$row2");

                    // $p1 = "ISBLANK(G" . $row2 . ")";
                    // $p2 = 'DATEDIF(G' . $row . ',G' . $row2 . ',"y")&" yrs, "&';
                    // $p3 = 'DATEDIF(G' . $row . ',G' . $row2 . ',"ym")&" mos, "&';
                    // $p4 = 'DATEDIF(G' . $row . ',G' . $row2 . ',"md")&" days';
                    // $blank = '""';
                    // $value = "=IF(" . $p1 . "," . $blank . "," . $p2 . $p3 . $p4 .'")';
                    // $event->sheet->getParent()->getActiveSheet()->setCellValue('H' . $row2, $value);

                    // $sign_in = $event->sheet->getParent()->getActiveSheet()->getCell('G' . $row, $value)->getValue();
                    // $sign_off = $event->sheet->getParent()->getActiveSheet()->getCell('G' . $row2, $value)->getValue();

                    // $event->sheet->getParent()->getActiveSheet()->setCellValue('G' . $row, now()->parse($sign_in)->format('M j, Y'));
                    // $event->sheet->getParent()->getActiveSheet()->setCellValue('G' . $row2, now()->parse($sign_off)->format('M j, Y'));

                    $event->sheet->getDelegate()->getStyle("D$row2")->getFont()->setSize(9.5);
                    $event->sheet->getDelegate()->getStyle("C$row")->getFont()->setSize(9.5);

                    // FOR BOTTOM BORDER
                    array_push($cells[8], "A$row:I$row");
                    array_push($cells[9], "E$row2");
                }

                // dd($cells, $borderStyle[8], $borderStyle[9]);

                // NUMBER HEADING ROWS
                $nhr = [
                    'A28', 'A' . ($rae + 1), 'A' . $ral, 'A' . $rac, 'A' . $raoc, 'A' . $rapiyc, 'A' . $raeajl,
                    'A' . $ratesms, 'A' . $raaow
                ];

                // FUNCTIONS
                $piyc = function($col, $inc) use($raoc){
                    return $col . ($raoc + $inc);
                };

                $tempPiycRows = array(
                    // $piyc('A', 1) . ':' . $piyc('D', 1), $piyc('E', 1), $piyc('F', 1), $piyc('G', 1), $piyc('H', 1) . ':' . $piyc('I', 1),
                    // $piyc('A', 2) . ':' . $piyc('D', 3), $piyc('E', 2), $piyc('E', 3), $piyc('F', 2) . ':' . $piyc('F', 3),
                    // $piyc('G', 2) . ':' . $piyc('G', 3), $piyc('H', 2) . ':' . $piyc('H', 3), $piyc('I', 2) . ':' . $piyc('I', 3),

                    $piyc('A', 1) . ':' . $piyc('D', 1), $piyc('E', 1), $piyc('F', 1), $piyc('G', 1), $piyc('H', 1), $piyc('I', 1),
                    $piyc('A', 2) . ':' . $piyc('D', 2), $piyc('E', 2), $piyc('F', 2), $piyc('G', 2), $piyc('H', 2), $piyc('I', 2),
                    $piyc('A', 3) . ':' . $piyc('D', 3), $piyc('E', 3), $piyc('F', 3), $piyc('G', 3), $piyc('H', 3), $piyc('I', 3),
                    $piyc('A', 4) . ':' . $piyc('D', 4), $piyc('E', 4), $piyc('F', 4), $piyc('G', 4), $piyc('H', 4), $piyc('I', 4),
                    $piyc('A', 5) . ':' . $piyc('D', 5), $piyc('E', 5), $piyc('F', 5), $piyc('G', 5), $piyc('H', 5), $piyc('I', 5),
                    $piyc('A', 6) . ':' . $piyc('D', 6), $piyc('E', 6), $piyc('F', 6), $piyc('G', 6), $piyc('H', 6), $piyc('I', 6),
                    $piyc('A', 7) . ':' . $piyc('D', 7), $piyc('E', 7), $piyc('F', 7), $piyc('G', 7), $piyc('H', 7), $piyc('I', 7)
                    // $piyc('A', 8) . ':' . $piyc('D', 8), $piyc('E', 8), $piyc('F', 8), $piyc('G', 8), $piyc('H', 8), $piyc('I', 8), //REMOVED AFTER SEPARATING COVID
                    // $piyc('A', 9) . ':' . $piyc('D', 9), $piyc('E', 9), $piyc('F', 9), $piyc('G', 9), $piyc('H', 9), $piyc('I', 9), //REMOVED AFTER SEPARATING COVID
                );


                for ($i=0; $i <= 11; $i++) { 
                    array_push($piycRows, $tempPiycRows[$i]);
                }

                array_push($cells[11], $tempPiycRows[36]);
                array_push($cells[11], $tempPiycRows[37]);
                array_push($cells[11], $tempPiycRows[38]);
                array_push($cells[11], $tempPiycRows[39]);
                array_push($cells[11], $tempPiycRows[40]);
                array_push($cells[11], $tempPiycRows[41]);

                for ($i=8; $i < 42; $i++) { 
                    array_push($cells[7], $tempPiycRows[$i]);
                }

                // dd($cells[7]);

                foreach ($tempPiycRows as $cell) {
                    array_push($cells[12], $cell);
                }

                // dd($cells[7], $cells[12]);

                
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
                    ('A' . ($raeajl - 2) . ':' . 'A' . ($raeajl - 1)), //A#:A# PIYC ROWS
                    ('A' . ($raeajl - 4)),
                    ('A' . ($ratesms - 2) . ':' . 'A' . ($ratesms - 1)), //A#:A# PIYC ROWS
                    ('A' . ($raaow - 1)), //A#:A# PIYC ROWS
                    'B26'
                ]);

                // HC VC
                $h[5] = [
                    ('A' . ($rapiyc - 9) . ':' . 'I' . ($rapiyc - 9)), "A" . ($racovid - 3) . ':' . "I" . ($racovid - 1),'B26', 'I24', 'A59:D62',
                ];

                // B
                $h[6] = [
                    
                ];

                $h['stf'] = [
                    "A1:I$rash3", "E" . ($racovid - 3) . ':' . "I" . ($racovid - 1)
                ];

                $h['wrap'] = [
                    ('E' . ($rapiyc - 7)), "A" . ($racovid - 3) . ':' . "I" . ($racovid - 3), "H" . ($racovid - 2) . ':' . "I" . ($racovid - 1),'H24'
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

                // GREYY FILL
                // foreach($fills as $fill){
                //     $event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle[0]);
                // }

                // foreach($nhr as $fill){
                //     $event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle[0]);
                // }

                // $event->sheet->getDelegate()->getStyle("D19:E19")->applyFromArray($fillStyle[0]);
                // $event->sheet->getDelegate()->getStyle("A20:I21")->applyFromArray($fillStyle[0]);
                $event->sheet->getDelegate()->getStyle("D20:E21")->applyFromArray($fillStyle[0]);
                $event->sheet->getDelegate()->getStyle("A21:I22")->applyFromArray($fillStyle[0]);
                // $event->sheet->getDelegate()->getStyle("C" . ($rae + 3) . ':D' . ($rae + 3))->applyFromArray($fillStyle[0]);
                $event->sheet->getDelegate()->getStyle("A" . ($ral + 7) . ':B' . ($ral + 7))->applyFromArray($fillStyle[0]);
                // $event->sheet->getDelegate()->getStyle("H" . ($ral + 5) . ':I' . ($ral + 5))->applyFromArray($fillStyle[0]);

                // $event->sheet->getDelegate()->getStyle("H" . ($ral + 5) . ':I' . ($ral + 5))->applyFromArray($fillStyle[0]);

                // $event->sheet->getDelegate()->getStyle("A" . ($rac + 3) . ':B' . ($rac + 3))->applyFromArray($fillStyle[0]);

                $temp = 1;
                // if($this->applicant->rank->id == 2){
                    // $event->sheet->getDelegate()->getStyle("A" . ($raoc + 5) . ':D' . ($raoc + 5))->applyFromArray($fillStyle[0]);
                    // $temp += 1;
                // }



                $event->sheet->getDelegate()->getStyle("A" . ($rac + $temp + 3) . ':I' . ($rac + $temp + 3))->applyFromArray($fillStyle[1]);
                $event->sheet->getDelegate()->getStyle("A" . ($rac + $temp + 4) . ':I' . ($rac + $temp + 4))->applyFromArray($fillStyle[2]);
                $event->sheet->getDelegate()->getStyle("A" . ($rac + $temp + 5) . ':I' . ($rac + $temp + 5))->applyFromArray($fillStyle[4]);
                $event->sheet->getDelegate()->getStyle("H" . ($raaow - 1) . ':I' . ($raaow - 1))->applyFromArray($fillStyle[5]);

                $event->sheet->getDelegate()->getStyle("F17:I17")->applyFromArray($fillStyle[3]);
                $event->sheet->getDelegate()->getStyle("A" . ($raoc + $temp - 1) . ':I' . ($raoc + $temp + 6))->applyFromArray($fillStyle[3]);
                $event->sheet->getDelegate()->getStyle("A" . ($rapiyc + $temp - 1) . ':I' . ($rapiyc + $temp + 2))->applyFromArray($fillStyle[0]);

                $event->sheet->getDelegate()->getStyle("F" . ($rash1 + $temp))->applyFromArray($fillStyle[0]);

                // BORDERS

                // $sh3Rows = array();
                // ALL AROUND
                $cells[0] = array_merge($rows, $ebRows, $lRows, $cRows, $ocRows, $piycRows, $covidRows, $eajlRows, $aowRows, $sh2Rows, $sh3Rows, [
                    'A2:B9', 'H1:I1', 'H2', 'I2', 'H3:H5', 'I3:I5',
                    'A29:B29', 'C29:F29', 'G29:I29'
                ]);

                // BOTTOM ONLY
                $cells[1] = [
                    "C$rash3:E$rash3", "G$rash3:I$rash3"
                ];

                // REMOVE TOP
                $cells[3] = [
                    $piyc('E', 2),
                    $piyc('F', 2),
                    $piyc('G', 2),
                    $piyc('H', 2),
                    $piyc('I', 2),
                ];

                // REMOVE BOTTON
                $cells[4] = [
                    $piyc('E', 1),
                    $piyc('F', 1),
                    $piyc('G', 1),
                    $piyc('H', 1),
                    $piyc('I', 1),
                ];

                // REMOVE LEFT
                $cells[5] = [

                ];

                // REMOVE RIGHT
                $cells[6] = [

                ];

                // HAIR BOTTOM
                $cells[8] = array_merge($cells[8], [
                    'E7:F7', 'H7:I7', 'H9:I9', 'B11', 'D11', 'F11', 'H11:I11', 'B12:I12',
                    'B15:F15', 'H16:I16', 'H17:I17', 'B18', 'D18', 'F18:G18', 'I18',
                    'G18', 'I19', 'B19:C19', 'E19', 'G19', 'B20:C20', 'E20', 'G20', 'I20',
                    'C21:D21', 'F21', 'I21', 'H22', 'D22:E22', 'G23:I23', 'B24:I24', 'B26:F26', 'G27:I27'
                ]);

                // 2,7,8,9,10 on top

                foreach($cells as $key => $value) {
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // COLUMN RESIZE

                // $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(12.5);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(13);
                $event->sheet->getDelegate()->getStyle("G$rash3")->getFont()->setSize(8.5);
                $event->sheet->getDelegate()->getStyle("G$rash3")->getFont()->setSize(8.5);
                // $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                // $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                // $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(4);

                for($i = 11; $i <= ($rash3 + 1); $i++){
                    if($i = ($rapiyc - 8)){
                        $i = ($rash3+1) + 1;
                    }
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(14.5);
                }

                for($i = 1; $i < 130; $i++){
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(13.7);
                }
                $event->sheet->getDelegate()->getRowDimension(10)->setRowHeight(13);
                $event->sheet->getDelegate()->getRowDimension(14)->setRowHeight(13.5);

                $event->sheet->getDelegate()->getRowDimension(3)->setRowHeight(10);
                $event->sheet->getDelegate()->getRowDimension(4)->setRowHeight(10);
                $event->sheet->getDelegate()->getRowDimension(5)->setRowHeight(10);
                $event->sheet->getDelegate()->getRowDimension(6)->setRowHeight(10);
                $event->sheet->getDelegate()->getRowDimension(8)->setRowHeight(10);
                $event->sheet->getDelegate()->getRowDimension(14)->setRowHeight(11);

                $event->sheet->getDelegate()->getRowDimension($racovid - 3)->setRowHeight(24);

                $rash3 += 1;
                $event->sheet->getDelegate()->getStyle("E1:E102")->getFont()->setSize(8.5);
                $event->sheet->getDelegate()->getStyle("E1:E132")->getFont()->setName('Times New Roman');
                
                $event->sheet->getDelegate()->getStyle("F" . ($racovid - 3) . ':' . "H" . ($racovid - 3))->getFont()->setSize(8.5);
                $event->sheet->getDelegate()->getStyle("F" . ($racovid - 3) . ':' . "H" . ($racovid - 3))->getFont()->setName('Times New Roman');

                $event->sheet->getDelegate()->getStyle("G23")->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle("G23")->getFont()->setSize(8.5);

                $event->sheet->getDelegate()->getStyle("G17")->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle("G17")->getFont()->setSize(8.5);

                $event->sheet->getDelegate()->getStyle("H21")->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle("H21")->getFont()->setSize(8.5);

                $event->sheet->getDelegate()->getStyle("F22")->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle("F22")->getFont()->setSize(8.5);

                $event->sheet->getDelegate()->getStyle("A21:A102")->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle("A21:A102")->getFont()->setSize(8.5);

                // SET PRINT AREA
                $event->sheet->getDelegate()->getPageSetup()->setPrintArea("A1:I$rash3");

                // PAGE BREAK
                $event->sheet->getParent()->getActiveSheet()->setBreak('A' . ($raoc - 1), \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E30:E35' => "0",
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path($this->applicant->user->avatar));
        $drawing->setResizeProportional(false);
        $drawing->setWidth(123);
        $drawing->setHeight(118);
        $drawing->setOffsetX(2);
        $drawing->setOffsetY(1);
        $drawing->setCoordinates('A2');

        return $drawing;
    }
}