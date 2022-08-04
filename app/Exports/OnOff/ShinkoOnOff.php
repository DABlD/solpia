<?php

namespace App\Exports\OnOff;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ShinkoOnOff implements FromView, WithEvents//, WithDrawings//, ShouldAutoSize
{
    public function __construct($linedUps, $onBoards, $type, $data){
        $this->linedUps 	= $linedUps;
        $this->onBoards 	= $onBoards;
        $this->type 		= $type;
    }

    public function view(): View
    {
        return view('exports.onOff.' . lcfirst($this->type), [
            'linedUps' => $this->linedUps,
            'onBoards'=> $this->onBoards
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
                        'rgb' => 'ced4da'
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
                $event->sheet->getDelegate()->setTitle('Onsigners and Offsigners', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                // FUNCTIONS
                $osSize = sizeof($this->linedUps);
                $ofsSize = sizeof($this->onBoards);
                $osRows = array();
                $ofsRows = array();

                $start = 4;
                foreach($this->linedUps as $row){
                    $next = $start + 1;
                    
                    array_push($osRows, "A$start:A$next");
                    array_push($osRows, "B$start:B$next");
                    array_push($osRows, "C$start:C$next");
                    array_push($osRows, "D$start:D$next");
                    array_push($osRows, "E$start:E$next");
                    array_push($osRows, "F$start:F$next");
                    array_push($osRows, "G$start:G$next");
                    array_push($osRows, "H$start:H$next");

                    $start+=2;
                }

                $start = 8 + ($osSize * 2);
                foreach($this->onBoards as $row){
                    $next = $start + 1;
                    
                    array_push($ofsRows, "A$start:A$next");
                    array_push($ofsRows, "B$start:B$next");
                    array_push($ofsRows, "C$start:C$next");
                    array_push($ofsRows, "D$start:D$next");
                    array_push($ofsRows, "E$start:E$next");
                    array_push($ofsRows, "F$start:F$next");
                    array_push($ofsRows, "G$start:G$next");
                    array_push($ofsRows, "H$start:H$next");

                    $start+=2;
                }

                // GET AFTER ONSIGNERS
                $ar = function($c1, $r1, $c2 = null, $r2 = null, $ofs = false) use($osSize, $ofsSize){
                    $size = $osSize;
                    $temp = $c1 . ($r1 + ($size * 2));
                    if($c2 != null){
                        $temp .= ':' . $c2 . ($r2 + (($size + ($ofs ? $ofsSize : 0)) * 2));
                    }

                    return $temp;
                };

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
                    'A4:' . $ar('H', 3), $ar('A', 8,'H', 7, true)
                ];

                // HL
                $h[4] = [
                    'C4:' . $ar('C', 3), $ar('C', 8, 'C', 7, true)
                ];

                // HC VC
                $h[5] = [
                    'A2:H3', $ar('A', 6, 'H', 7)
                ];

                // B
                $h[6] = [
                    'A1', 'A2:H2', $ar('A', 5), $ar('A', 6, 'H', 6)
                ];

                // VC
                $h[7] = [
                    'A1', 'H4:' . $ar('H', 3), $ar('A', 5), $ar('H', 8, 'H', 7, true),
                    'A1:H30'
                ];

                $h['wrap'] = [
                    'A2:H3', $ar('A', 6, 'H', 7)
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
                    'A1', $ar('A', 5)
                ];

                $fills[1] = [
                    'A2:H3', $ar('A', 6, 'H', 7)
                ];

                foreach($fills as $key => $value){
                	foreach($value as $cell){
                    	$event->sheet->getDelegate()->getStyle($cell)->applyFromArray($fillStyle[$key]);
                	}
                }

                // BORDERS
                $cells[0] = array_merge([
                    'A2:H3', $ar('A', 6, 'H', 7)
                ]);


                $cells[1] = array_merge($osRows, $ofsRows, [

                ]);


                $cells[2] = array_merge([
                    'A2:H3', 'A4:' . $ar('H', 3), $ar('A', 6, 'H', 7), $ar('A', 8,'H', 7, true)
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(8);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(35);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(27);

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(18);
                $event->sheet->getDelegate()->getRowDimension(5 + ($osSize * 2))->setRowHeight(18);
            },
        ];
    }
}
