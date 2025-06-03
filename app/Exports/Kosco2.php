<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;

class Kosco2 implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $type){
        $this->data     = $data;
        $this->type     = $type;
    }

    public function view(): View
    {
        return view('exports.kosco2', [
            'applicant' => $this->data,
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
                        'rgb' => '26b36c'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'cccccc'
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
                $event->sheet->getDelegate()->setTitle('CIR', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.25);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.25);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.25);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.25);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.25);

                // DEFAULT FONT AND STYLE FOR WHOLE PAGE
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('B2')->getFont()->setSize(20);
                $event->sheet->getDelegate()->getStyle('B5')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('E7:E13')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('M7:M11')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('E15:N15')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('E17:N17')->getFont()->setSize(8);
                // $event->sheet->getDelegate()->getStyle('A1:A2')->getFont()->setName('Arial');

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

                // CELL COLOR
                $event->sheet->getDelegate()->getStyle('E7:E13')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('M7:M11')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('E15:N15')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('E17:N17')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('K21:K40')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('K53')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('K64')->getFont()->getColor()->setRGB('0000FF');

                // CELL FONT COLOR
                $event->sheet->getDelegate()->getStyle('E42')->getFont()->getColor()->setRGB('FF0000');
                $event->sheet->getDelegate()->getStyle('J41')->getFont()->getColor()->setRGB('FF0000');
                $event->sheet->getDelegate()->getStyle('E44')->getFont()->getColor()->setRGB('FF0000');
                $event->sheet->getDelegate()->getStyle('J43')->getFont()->getColor()->setRGB('FF0000');

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
                    'B2:P73'
                ];

                // HL
                $h[5] = [
                    'E7:E13', 'M7:M11', 'B46', 'B55:B56', 'B66:B67'
                ];

                // B
                $h[6] = [
                    'B2', 'B5', 'B19', 'K41', 'E42', 'E44', 'B46', 'B55:B56', 'B66:B67'
                ];

                // VC
                $h[7] = [
                    
                ];

                $h['wrap'] = [
                    'B7:N17', 'B21:B44', 'K21:K41'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'E21:E44', 'F20:J20', 'M10'
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
                    
                ];

                $fills[1] = [
                    'B19', 'B46', 'B55:B56', 'B66:B67'
                ];

                foreach($fills as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($fillStyle[$key]);
                    }
                }

                // BORDERS
                $cells[0] = array_merge([
                    'B2:P17', 'B19:P44', 'B46:P46'
                ]);


                $cells[1] = array_merge([
                    'B55:P56', 'B66:P67'
                ]);

                $cells[2] = array_merge([
                    // 'A2:H3', 'A4:' . $ar('H', 3), $ar('A', 6, 'H', 7), $ar('A', 8,'H', 7, true)
                ]);


                $cells[3] = array_merge([
                    'K53:O53', 'K64:O64', 'B71:P71'
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(1);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(9);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(9);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(9);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(9);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(3);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(3);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(5);

                // ROW RESIZE
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(5.25);
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(15);
                $event->sheet->getDelegate()->getRowDimension(3)->setRowHeight(15);
                $event->sheet->getDelegate()->getRowDimension(4)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(5)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(6)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(7)->setRowHeight(21);
                $event->sheet->getDelegate()->getRowDimension(8)->setRowHeight(21);
                $event->sheet->getDelegate()->getRowDimension(9)->setRowHeight(21);
                $event->sheet->getDelegate()->getRowDimension(10)->setRowHeight(27);
                $event->sheet->getDelegate()->getRowDimension(11)->setRowHeight(27);
                $event->sheet->getDelegate()->getRowDimension(12)->setRowHeight(27);
                $event->sheet->getDelegate()->getRowDimension(13)->setRowHeight(27);
                $event->sheet->getDelegate()->getRowDimension(14)->setRowHeight(24);
                $event->sheet->getDelegate()->getRowDimension(15)->setRowHeight(18);
                $event->sheet->getDelegate()->getRowDimension(16)->setRowHeight(38.25);
                $event->sheet->getDelegate()->getRowDimension(17)->setRowHeight(18);
                $event->sheet->getDelegate()->getRowDimension(18)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(19)->setRowHeight(15);
                $event->sheet->getDelegate()->getRowDimension(20)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(21)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(22)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(23)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(24)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(25)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(26)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(27)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(28)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(29)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(30)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(31)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(32)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(33)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(34)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(35)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(36)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(37)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(38)->setRowHeight(24.75);

                $event->sheet->getDelegate()->getRowDimension(39)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(40)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(41)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(42)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(43)->setRowHeight(24.75);
                $event->sheet->getDelegate()->getRowDimension(44)->setRowHeight(24.75);

                $event->sheet->getDelegate()->getRowDimension(46)->setRowHeight(15);

                $event->sheet->getDelegate()->getRowDimension(52)->setRowHeight(6);
                $event->sheet->getDelegate()->getRowDimension(53)->setRowHeight(15);
                $event->sheet->getDelegate()->getRowDimension(54)->setRowHeight(6);

                $event->sheet->getDelegate()->getRowDimension(57)->setRowHeight(6);

                $event->sheet->getDelegate()->getRowDimension(63)->setRowHeight(6);
                $event->sheet->getDelegate()->getRowDimension(64)->setRowHeight(15);
                $event->sheet->getDelegate()->getRowDimension(65)->setRowHeight(6);

                $event->sheet->getDelegate()->getRowDimension(68)->setRowHeight(105);
                $event->sheet->getDelegate()->getRowDimension(69)->setRowHeight(6);
                $event->sheet->getDelegate()->getRowDimension(70)->setRowHeight(15);
                $event->sheet->getDelegate()->getRowDimension(71)->setRowHeight(6);
                $event->sheet->getDelegate()->getRowDimension(72)->setRowHeight(105);
                
                // SET PRINT AREA
                $event->sheet->getDelegate()->getPageSetup()->setPrintArea("B2:P72");
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('checked');
        $drawing->setDescription('checked');
        $drawing->setPath(public_path('images/kosco_check.png'));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(50);
        $drawing->setWidth(35);
        $drawing->setOffsetX(37);
        $drawing->setOffsetY(-19);
        $drawing->setCoordinates('B53');
    
        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setName('checked');
        $drawing2->setDescription('checked');
        $drawing2->setPath(public_path('images/kosco_check.png'));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(50);
        $drawing2->setWidth(35);
        $drawing2->setOffsetX(37);
        $drawing2->setOffsetY(-19);
        $drawing2->setCoordinates('B64');

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setName('unchecked');
        $drawing3->setDescription('unchecked');
        $drawing3->setPath(public_path('images/kosco_no_check.png'));
        $drawing3->setResizeProportional(false);
        $drawing3->setHeight(50);
        $drawing3->setWidth(35);
        $drawing3->setOffsetX(37);
        $drawing3->setOffsetY(-19);
        $drawing3->setCoordinates('D53');
    
        $drawing4 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing4->setName('unchecked');
        $drawing4->setDescription('unchecked');
        $drawing4->setPath(public_path('images/kosco_no_check.png'));
        $drawing4->setResizeProportional(false);
        $drawing4->setHeight(50);
        $drawing4->setWidth(35);
        $drawing4->setOffsetX(37);
        $drawing4->setOffsetY(-19);
        $drawing4->setCoordinates('D64');

        $drawing5 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing5->setName('unchecked');
        $drawing5->setDescription('unchecked');
        $drawing5->setPath(public_path('images/kosco_no_check.png'));
        $drawing5->setResizeProportional(false);
        $drawing5->setHeight(50);
        $drawing5->setWidth(35);
        $drawing5->setOffsetX(37);
        $drawing5->setOffsetY(-19);
        $drawing5->setCoordinates('B70');
    
        $drawing6 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing6->setName('unchecked');
        $drawing6->setDescription('unchecked');
        $drawing6->setPath(public_path('images/kosco_no_check.png'));
        $drawing6->setResizeProportional(false);
        $drawing6->setHeight(50);
        $drawing6->setWidth(35);
        $drawing6->setOffsetX(37);
        $drawing6->setOffsetY(-19);
        $drawing6->setCoordinates('D70');

        $drawing7 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing7->setName('unchecked');
        $drawing7->setDescription('unchecked');
        $drawing7->setPath(public_path('images/shirley_sig.png'));
        $drawing7->setResizeProportional(false);
        $drawing7->setHeight(70);
        $drawing7->setWidth(165);
        // $drawing7->setOffsetX(37);
        $drawing7->setOffsetY(-35);
        $drawing7->setRotation(10);
        $drawing7->setCoordinates('K52');
    
        $drawing8 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing8->setName('unchecked');
        $drawing8->setDescription('unchecked');
        $drawing8->setPath(public_path('images/capt_castillo_sig.png'));
        $drawing8->setResizeProportional(false);
        $drawing8->setHeight(70);
        $drawing8->setWidth(115);
        $drawing8->setOffsetX(3);
        $drawing8->setOffsetY(-60);
        $drawing8->setCoordinates('K63');

        return [
            $drawing, $drawing2, 
            $drawing3, $drawing4, 
            $drawing5, $drawing6,
            $drawing7, $drawing8
        ];
    }
}
