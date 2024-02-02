<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Rank;

class DocumentChecklist implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $type, $req){
        $applicant->load('document_flag');
        $applicant->load('document_id');
        $applicant->load('document_lc');
        $applicant->load('document_med_cert');
        $applicant->load('document_med');

        foreach(['document_id', 'document_flag', 'document_lc', 'document_med', 'document_med_cert' ] as $docuType){
            foreach($applicant->$docuType as $key => $doc){
                $name = $doc->type;
                if(!isset($applicant->$docuType->$name)){
                    $applicant->$docuType->$name = $doc;
                }
                else{
                    $size = 0;
                    if(is_array($applicant->$docuType->$name)){
                        $size = sizeof($applicant->$docuType->$name);
                    }
                    $name .= $size;
                    $applicant->$docuType->$name = $doc;
                }
                $applicant->$docuType->forget($key);
            }
        }

        if(!isset($applicant->rank)){
            $applicant->rank = Rank::find($applicant->data['rank'])->abbr;
        }

        $this->data     = $applicant;
        $this->type     = $applicant->data['type'];
        $this->rows     = null;
        $this->view     = null;
        $this->initNulls($applicant->data['type'], $applicant->data['fleet']);
    }

    public function initNulls($type, $fleet){
        $rows = 0;
        $rank = $this->data->rank;

        // LIST HERE ALL ADDITIONAL

        if($rank == "MSTR" || $rank == "C/O"){
            $this->view    = "MSTR_CO";
        }
        elseif($rank == "2/O" || $rank == "3/O"){
            $this->view    = "2O_3O";
        }
        elseif($rank == "BSN" || $rank == "AB" || $rank == "OS" || $rank == "PMN" || $rank == "DCDT" || $rank == "ABD"){
            $this->view    = "BSN_AB_OS";
        }
        elseif($rank == "C/E" || $rank == "1AE" || $rank == "2E"){
            $this->view    = "CE_1AE";
        }
        elseif($rank == "2AE" || $rank == "3E" || $rank == "3AE" || $rank == "4E"){
            $this->view    = "2AE_3AE";
        }
        elseif($rank == "OLR" || $rank == "OLR1" || $rank == "WPR" || $rank == "ECDT" || $rank == "ABE" || $rank == "FTR"){
            $this->view    = "OLR1_OLR_WPR";
        }
        elseif($rank == "ELECT"){
            $this->view    = "ETO";
        }
        elseif($rank == "ETR"){
            $this->view    = "ETR";
        }
        elseif($rank == "CCK" || $rank == "MSM" || $rank == "MBY" || $rank == "CBY" || $rank == "2CK" || $rank == "UTY"){
            $this->view    = "CCK_2CK_MSM_MBY";
        }

        if($fleet == "FLEET B"){
            $this->data->manager = "ADULF KIT JUMAWAN";
            $this->data->officer = auth()->user()->fullname;
            $this->data->documentation = auth()->user()->fullname;
        }
        elseif($fleet == "FLEET C"){
            $this->data->manager = "MS. JEANETTE SOLIDUM";
            $this->data->officer = auth()->user()->fullname;
            $this->data->documentation = auth()->user()->fullname;
        }
        elseif($fleet == "FLEET D"){
            $this->data->manager = "THEA GUERRA";
            $this->data->officer = auth()->user()->fullname;
            $this->data->documentation = auth()->user()->fullname;
        }
        elseif($fleet == "TOEI"){
        }
        elseif($fleet == "FISHING"){
            $this->data->manager = "RICARDO AMPARO";
            $this->data->officer = auth()->user()->fullname;
            $this->data->documentation = auth()->user()->fullname;
        }
    }

    public function view(): View
    {
        $exportView = str_replace(' ', '_', $this->data->data['fleet'] . '.' . $this->type . '_' . $this->view);
        // $exportView = str_replace(' ', '_', "TEMPLATES" . '.template_' . 'MSTR_CO');

        return view('exports.checklists.' . $exportView, [
            'data' => $this->data,
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
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
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
                        'color' => ['argb' => 'FFFFFF']
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
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
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
            ]
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter("&L&IDOC NO: SMOP-CDFC-11 &C&IEFFECTIVE DATE: 01 SEPT 17 &R&IREVISION NO: 02 (01.NOV.2023)");

                $event->sheet->getDelegate()->setTitle($this->view, false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                // $event->sheet->getDelegate()->getPageSetup()->setScale(80);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.4);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.6);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.1);

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->setSize(16);

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
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                ];

                // HC VC
                $h[4] = [
                    'A2', 'B4:B6', 'G4:G6', 'D8:I75', 'A77:I82', 'E4:E6'
                ];

                // HL
                $h[5] = [
                ];

                // B
                $h[6] = [
                ];

                // VC
                $h[7] = [
                    'A9:A75'
                ];

                $h['wrap'] = [
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
                ]);

                // ALL BORDER DOTTED
                $cells[1] = array_merge([
                    'A8:I75'
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                    'A8:I75'
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

                // BOTTOM BORDER THIN
                $cells[10] = array_merge([
                    'B4:D4', 'G4:I4',
                    'B5:D5', 'G5:I5',
                    'B6:D6', 'G6:I6',
                    'B77:D77', 'G77:I77',
                    'B79:D79', 'G79:I79',
                    'B81:D81', 'G81:I81',
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
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(26);

                // ROW RESIZE
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(50);

                for($i = 4; $i <= 82; $i++){
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(11);
                }
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                $event->sheet->getDelegate()->getStyle('A4:I8')->getFont()->setSize(7);
                $event->sheet->getDelegate()->getStyle('A9:D75')->getFont()->setSize(7);
                $event->sheet->getDelegate()->getStyle('I9:I75')->getFont()->setSize(7);
                $event->sheet->getDelegate()->getStyle('A76:I82')->getFont()->setSize(7);
                $event->sheet->getDelegate()->getStyle('A4:I8')->getFont()->setName('Trebuchet MS');
                $event->sheet->getDelegate()->getStyle('A9:D75')->getFont()->setName('Trebuchet MS');
                $event->sheet->getDelegate()->getStyle('I9:I75')->getFont()->setName('Trebuchet MS');
                $event->sheet->getDelegate()->getStyle('A76:I82')->getFont()->setName('Trebuchet MS');
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
        $drawing->setHeight(50);
        $drawing->setWidth(850);
        $drawing->setOffsetX(4);
        $drawing->setOffsetY(4);
        $drawing->setCoordinates('A1');

        return [$drawing];
    }
}
