<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SINOCREW3 implements FromView, WithEvents//, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $type){
        $data->load('document_med_cert');

        if($data->pro_app->rank->abbr == "1AE"){
            $data->pro_app->rank->abbr = "2E";
        }
        elseif($data->pro_app->rank->abbr == "2AE"){
            $data->pro_app->rank->abbr = "3E";
        }
        elseif($data->pro_app->rank->abbr == "3AE"){
            $data->pro_app->rank->abbr = "4E";
        }

        $this->data     = $data;
        $this->type     = $type;
    }

    public function view(): View
    {
        $exportView = str_replace(' ', '_', $this->data->vessel->fleet) . '.sinocrew3';
        return view('exports.mlc.' . $exportView, [
            'data' => $this->data,
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
            ]
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('MLC', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

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
                    'A43:A46', 'A28'
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    
                ];

                // HC VC
                $h[4] = [
                    'A2'
                ];

                // HL
                $h[5] = [
                    'A14'
                ];

                // B
                $h[6] = [
                ];

                // VC
                $h[7] = [
                ];

                $h['wrap'] = [
                    'A5', 'A23', 'A28', 'A45', 'A46'
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
                    'A44:F47',
                    'A43:F43',
                ]);

                // ALL BORDER MEDIUM
                $cells[1] = array_merge([
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                    'A5:F5',
                    'A7:D8', 'E7:F8',
                    'A9:F10',
                    'A11:D12', 'E11:F12',
                    'A13:D14', 'E13:F14',
                    'A15:D16', 'E15:F16',
                    'A17:D18', 'E17:F18',
                    'A20:F21',
                    'A22:F23',
                    'A25:F26',
                    'A27:F28',
                    'A30:E31', 'F30:F31',
                    'A32:D33', 'E32:F33',
                    'A35:C36', 'D35:E36', 'F35:F36',
                    'A37:C38', 'D37:E38', 'F37:F38',
                    'A39:C40', 'D39:E40', 'F39:F40',
                    'A41:C42', 'D41:E42', 'F41:F42',
                    'A48:D49', 'E48:F49'
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
                    'B3', 'D3'
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(27);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(22);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(35);

                // ROW RESIZE
                // $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(90);
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('A3:D3')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('A44:A46')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('D37')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('F37')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('F39')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('A48')->getFont()->setSize(9);
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
