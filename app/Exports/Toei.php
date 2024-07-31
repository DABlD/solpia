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

class Toei implements FromView, WithEvents, WithDrawings, WithColumnFormatting//, ShouldAutoSize
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
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'FF0000'
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
                $rae = 27 + $temp; //Row # AFTER EDUC BACKGROUND

                for($i = 0, $row = 28; $i < $temp; $i++, $row++){
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
                $temp = 7;
                $ral = $rae + 3 + $temp; //Row # AFTER LICENSES

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
                $temp = 8;
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
                $temp = 21;
                $raoc = $rac + 1 + $temp; //Row # AFTER OTHER CERTIFICATES

                $hl = false;
                $regs['dr'] = ["II/4", "II/5", "II/1", "II/2"];
                $regs['er'] = ["III/4", "III/5", "III/1", "III/2"];
                $rt = isset($this->applicant->rank) && str_starts_with($this->applicant->rank->category, "ENGINE") ? "er" : "dr";

                if($this->applicant->rank){
                    if(isset($this->applicant->document_lc->NCIII)){
                        $raoc+=1;
                    }

                    foreach($this->applicant->document_lc as $lc){
                        if(str_starts_with($lc->type, "COC") || str_starts_with($lc->type, "COE")){
                            $regulations = json_decode($lc->regulation);

                            foreach($regs[$rt] as $key => $ref){
                                if(in_array($ref, $regulations)){
                                    if($hl){
                                        if($key >= $hl){
                                            // IF FOR OFFICERS ONLY
                                            if($key >= 2){
                                                if(str_starts_with($lc->type, "COC")){
                                                    $hl = $key;
                                                }
                                            }
                                            else{
                                                $hl = $key;
                                            }
                                        }
                                    }
                                    else{
                                        $hl = $key;
                                    }
                                }
                            }
                        }
                    }
                }

                // FOR MARINA COP
                if($this->applicant->rank){
                    // DECK
                    $rid = $this->applicant->rank->id;

                    // INTERCHANGED COMPARED TO BLADE FILE AROUND LINE 1140
                    // AB OLR OS WPR WITH SENIOR OFFICER LICENSE
                    if(($rid == 10 && $hl == 2) || ($rid == 16 && $hl == 2) || ($rid == 9 && $hl == 2) || ($rid == 15 && $hl == 2) || ($rid == 42 && $hl == 2) || ($rid == 43 && $hl == 2) || ($rid == 11 && $hl == 2) || ($rid == 17 && $hl == 2)){
                        $start = $raoc;
                        $end = $raoc;
                        $start2 = $start+1;
                        $end2 = $end+1;

                        $raoc += 2;
                        $temp += 2;
                    }
                    // AB OLR OR OS WPR WITH JUNIOR OFFICER LICENSE
                    elseif(in_array($rid, [10,16,9,15,42,43]) || ($rid == 11 && $hl == 1) || ($rid == 17 && $hl == 1)){
                        $start = $raoc;
                        $end = $raoc;

                        $raoc += 1;
                        $temp += 1;
                    }
                }

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
                $rapiyc = $raoc + 1 + 9; //Row # AFTER PIYC (5 = rows)

                // EAJL CERTIFICATE ROWS
                $eajlRows = array();
                $temp = 3;
                $raeajl = $rapiyc + 1 + $temp; //Row # AFTER OTHER PIYC

                for($i = 0, $row = $rapiyc + 1; $i < $temp; $i++, $row++){

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
                    'A26', 'A' . ($rae + 1), 'A' . $ral, 'A' . $rac, 'A' . $raoc, 'A' . $rapiyc, 'A' . $raeajl,
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
                    $piyc('A', 7) . ':' . $piyc('D', 7), $piyc('E', 7), $piyc('F', 7), $piyc('G', 7), $piyc('H', 7), $piyc('I', 7),
                    $piyc('A', 8) . ':' . $piyc('D', 8), $piyc('E', 8), $piyc('F', 8), $piyc('G', 8), $piyc('H', 8), $piyc('I', 8),
                    $piyc('A', 9) . ':' . $piyc('D', 9), $piyc('E', 9), $piyc('F', 9), $piyc('G', 9), $piyc('H', 9), $piyc('I', 9),
                );


                for ($i=0; $i <= 11; $i++) { 
                    array_push($piycRows, $tempPiycRows[$i]);
                }

                array_push($cells[11], $tempPiycRows[48]);
                array_push($cells[11], $tempPiycRows[49]);
                array_push($cells[11], $tempPiycRows[50]);
                array_push($cells[11], $tempPiycRows[51]);
                array_push($cells[11], $tempPiycRows[52]);
                array_push($cells[11], $tempPiycRows[53]);

                for ($i=8; $i < 54; $i++) { 
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
                    ('A' . ($ratesms - 2) . ':' . 'A' . ($ratesms - 1)), //A#:A# PIYC ROWS
                    ('A' . ($raaow - 1)), //A#:A# PIYC ROWS
                    'B25'
                ]);

                // HC VC
                $h[5] = [
                    ('A' . ($rapiyc - 9) . ':' . 'I' . ($rapiyc - 9)), 'B25', 'I23', 'A57:D63'
                ];

                // B
                $h[6] = [
                    
                ];

                $h['stf'] = [
                    "A1:I$rash3"
                ];

                $h['wrap'] = [
                    ('E' . ($rapiyc - 7)), 'H23'
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

                $event->sheet->getDelegate()->getStyle("D11")->applyFromArray($fillStyle[1]);
                $event->sheet->getDelegate()->getStyle("H11:I11")->applyFromArray($fillStyle[1]);

                // BORDERS

                // $sh3Rows = array();
                // ALL AROUND
                $cells[0] = array_merge($rows, $ebRows, $lRows, $cRows, $ocRows, $piycRows, $eajlRows, $aowRows, $sh2Rows, $sh3Rows, [
                    'A2:B9', 'H1:I1', 'H2', 'I2', 'H3:H5', 'I3:I5',
                    'A27:B27', 'C27:F27', 'G27:I27'
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
                    'E7:F7', 'H7:I7', 'H9:I9', 'B11', 'D11', 'F11', 'H11:I11', 'B12:G12',
                    'B15:F15', 'H15:I15', 'H16:I16', 'B17', 'D17', 'F17:G17', 'I17',
                    'G17', 'I17', 'B18:C18', 'E18', 'G18', 'B19:C19', 'E19', 'G19', 'I19',
                    'C20:D20', 'F20', 'I20', 'H21', 'D21:E21', 'G22:I22', 'B23:I23', 'I24', 'B25:F25', 'H25:I25'
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

                $rash3 += 1;
                $event->sheet->getDelegate()->getStyle("E1:E100")->getFont()->setSize(8.5);
                $event->sheet->getDelegate()->getStyle("E1:E130")->getFont()->setName('Times New Roman');
                
                $event->sheet->getDelegate()->getStyle("G22")->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle("G22")->getFont()->setSize(8.5);

                // SET PRINT AREA
                $event->sheet->getDelegate()->getPageSetup()->setPrintArea("A1:I$rash3");

                // FORMATTING
                for ($row = 30; $row <= ($raoc - 1); $row++) {
                    $cell = $event->sheet->getCell('G' . $row)->getValue();

                    try {
                        if(now() > now()->parse($cell)){
                            $event->sheet->getDelegate()->getComment('G' . $row)->getText()->createTextRun($cell . ' - EXPIRED');
                        }
                    }
                    catch(\Carbon\Exceptions\InvalidFormatException $e){}
                }

                // FORMATTING FOR PEME
                $cell = $event->sheet->getCell('H' . ($raoc + 3))->getValue();
                try{
                    if(now() > now()->parse($cell)){
                        $event->sheet->getDelegate()->getComment('H' . ($raoc + 3))->getText()->createTextRun($cell . ' - EXPIRED');
                    }
                }
                catch(\Carbon\Exceptions\InvalidFormatException $e){}
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