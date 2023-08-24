<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Hmm1 implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $type, $is = false){
        $this->is      = $is;
        $this->data     = $data;
        $this->type     = $type;
    }

    public function view(): View
    {
        return view('exports.' . 'hmm1', [
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
                $event->sheet->getDelegate()->getPageSetup()->setOrientation("landscape");
                $event->sheet->getDelegate()->setTitle('BIODATA', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                // DEFAULT FONT AND STYLE FOR WHOLE PAGE
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(12);

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('E14:E19')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('F3')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle('K3')->getFont()->setSize(18);
                $event->sheet->getDelegate()->getStyle('K8')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle('R19:R30')->getFont()->setSize(10);
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
                    
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    
                ];

                // HC VC
                $h[4] = [
                    'C1:Y42'
                ];

                // HL
                $h[5] = [
                    'F5:F9', 'W7', 'K32:K36'
                ];

                // B
                $h[6] = [
                    'F3', 'K3', 'X2:Y2', 'K8:K16', 'C10:C39', 'L37:W42', 'K42'
                ];

                // VC
                $h[7] = [
                    'F5:F9'
                ];

                $h['wrap'] = [
                    'K8','E10:Y39', 'C20'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'E14:J22', 'L10:Y15', 'K19:Y28', 'D25:J38', 'E40:J42', 'K36', 'L6', 'O7'
                ];

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
                    'K3', 'F5:F9', 'K3:K8', 'Q3:Q6', 'R3:R4', 'T5:T6', 'U6', 'W5:W6', 'V7', 'C10:C42', 'E10:E13', 'E20:E21', 'L8:Y9', 'K16:Y18', 'K32:K37'
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
                    'C3:Y23', 'D24:Y30', 'D31:K39', 'L32:Y39', 'C39:J42'
                ]);

                // OUTSIDE BORDER THIN
                $cells[1] = array_merge([
                    'C24:C38', 'K40:T42', 'U40:V42', 'V40:Y42', 'W40:Y41'
                ]);

                // OUTSIDE THICK BORDER
                $cells[2] = array_merge([
                    // 'A2:H3', 'A4:' . $ar('H', 3), $ar('A', 6, 'H', 7), $ar('A', 8,'H', 7, true)
                    'C1:Y1', 'C3:E9', 
                ]);

                // TOP REMOVE BORDER
                $cells[3] = array_merge([
                    'F4', 'G4', 'H4:J4'
                ]);

                // BRB
                $cells[4] = array_merge([

                ]);

                // LRB
                $cells[5] = array_merge([

                ]);

                // RRB
                $cells[6] = array_merge([
                    'F4', 'G4', 'X7'
                ]);

                // TRB
                $cells[7] = array_merge([
                    'J3:J42'
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(2);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(23);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(31);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(23);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(29);
                $event->sheet->getDelegate()->getColumnDimension('S')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('T')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('V')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('W')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('X')->setWidth(23);
                $event->sheet->getDelegate()->getColumnDimension('Y')->setWidth(15);

                // ROW RESIZE
                for($i = 0; $i < 50; $i++){
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(25);                    
                }

                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(90);
                $event->sheet->getDelegate()->getRowDimension(3)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(19)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(20)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(21)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(22)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(23)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(24)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(25)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(26)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(27)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(28)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(29)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(30)->setRowHeight(30);
                
                // SET PRINT AREA
                $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");
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
        $drawing->setWidth(2200 + ($this->is ? 80 : 1200));
        $drawing->setOffsetX(4);
        $drawing->setOffsetY(4);
        $drawing->setCoordinates('C1');

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setName('Avatar');
        $drawing2->setDescription('Avatar');
        $drawing2->setPath(public_path($this->data->user->avatar));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(230);
        $drawing2->setWidth(240);
        $drawing2->setOffsetX(4);
        $drawing2->setOffsetY(4);
        $drawing2->setCoordinates('C3');

        if(auth()->user()->fleet){
            if(auth()->user()->fleet == "FLEET B"){
                $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing3->setName('sir_kit_sig');
                $drawing3->setDescription('sir_kit_sig');
                $drawing3->setPath(public_path('images/sir_kit_sig.png'));
                $drawing3->setResizeProportional(false);
                // $drawing3->setHeight(230);
                // $drawing3->setWidth(230);
                $drawing3->setOffsetX(2);
                $drawing3->setOffsetY(-45);
                $drawing3->setRotation(8);
                $drawing3->setCoordinates('W41');
            }
            if(auth()->user()->fleet == "FLEET D"){
                $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing3->setName('maam_thea_sig');
                $drawing3->setDescription('maam_thea_sig');
                $drawing3->setPath(public_path('images/maam_thea_sig.png'));
                $drawing3->setResizeProportional(false);
                $drawing3->setHeight(132);
                $drawing3->setWidth(236);
                $drawing3->setOffsetX(30 + ($this->is ? 0 : 30));
                $drawing3->setOffsetY(-80);
                $drawing3->setCoordinates('W41');
            }
            if(auth()->user()->fleet == "FLEET C"){
                $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing3->setName('maam_jen_sig');
                $drawing3->setDescription('maam_jen_sig');
                $drawing3->setPath(public_path('images/maam_jen_sig.jpg'));
                $drawing3->setResizeProportional(false);
                $drawing3->setHeight(60);
                $drawing3->setWidth(236);
                $drawing3->setOffsetX(30 + ($this->is ? 0 : 30));
                $drawing3->setOffsetY(-60);
                $drawing3->setCoordinates('W41');
            }

            return [$drawing, $drawing2, $drawing3];
        }
        else{
            return [$drawing, $drawing2];
        }

    }
}
