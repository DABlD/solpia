<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\Rank;

class X10_PrincipalOnboardCrew implements FromView, WithEvents
{
    public function __construct($data){
        // dd($data[0]);

        $this->size     = sizeof($data);
        $this->data     = $data;
    }

    public function view(): View
    {
        return view('exports.forms.x10_PrincipalOnboardCrew', [
            'applicants' => $this->data,
            'ranks' => Rank::all()
        ]);
    }

    public function registerEvents(): array
    {
        $borderStyle = 
        [
            [//0
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
                    ],
                ]
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
                        'rgb' => 'FF99FF'
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
                        'rgb' => 'F8CBAD'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => '66FFCC'
                    ]
                ],
            ]
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $headingStyle, $fillStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('DOCUMENTS.MONITORING', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                $event->sheet->getDelegate()->setAutoFilter('A4:AC' . ($size + 4));

                // DEFAULT FONT AND STYLE FOR WHOLE PAGE
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial Narrow');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(8);

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                // $event->sheet->getDelegate()->getStyle('F3')->getFont()->setSize(14);
                // $event->sheet->getDelegate()->getStyle('A1:A2')->getFont()->setName('Arial');

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

                $size = $this->size;
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
                    'A4:AC' . ($size + 4),
                ];

                // HL
                $h[5] = [
                    'C5:C' . ($size + 4),
                    'E5:E' . ($size + 4),
                    'M5:M' . ($size + 4)
                ];

                // B
                $h[6] = [
                ];

                // VC
                $h[7] = [
                ];

                $h['wrap'] = [
                    'A4:AC4'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    ('C5:C' . $size),
                    ('E5:E' . $size),
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
                    'I3:L3'
                ];

                $fills[1] = [
                    'M3:S3'
                ];

                $fills[2] = [
                    'T3:W3'
                ];

                $fills[3] = [
                    'X3:Z3'
                ];

                $fills[4] = [
                    'AA3:AB3'
                ];

                foreach($fills as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($fillStyle[$key]);
                    }
                }
                // BORDERS

                // ALL BORDER DOTTED
                $cells[0] = array_merge([
                    'A4:AC' . ($size + 4)
                ]);
                
                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                $event->sheet->getDelegate()->freezePane('F1');

                // FOR THE CHECK
                $event->sheet->getDelegate()->getStyle('A1:AC' . $size)->getFont()->setName('Arial Narrow');
                $event->sheet->getDelegate()->getStyle('A1:AC' . $size)->getFont()->setSize('8');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(4.5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(24);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(8);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(19);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('S')->setWidth(22);
                $event->sheet->getDelegate()->getColumnDimension('T')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('U')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('V')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('W')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('X')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('Y')->setWidth(14.5);
                $event->sheet->getDelegate()->getColumnDimension('Z')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AA')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AB')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('AC')->setWidth(25);

                // ROW RESIZE
                // $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(90);
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");
            },
        ];
    }
}
