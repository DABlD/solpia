<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class Western implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
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
        $borderStyle = 
        [
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
                ],
            ],
            [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
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
                        'rgb' => 'FFCC99'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'CCFFCC'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'CCCCCC'
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
            [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]
        ];

        $lock = [
            'protection' => [
                'locked' => \PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED
            ]
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle, $lock) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('DOCUMENT CHECKLIST.INTERGES', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                $event->sheet->getDelegate()->getStyle('A1:AJ150')->getFont()->setSize(10);
                $event->sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);
                // FONT SIZES

                // FILLS
                $fills[0] = [
                    'I1:AH11', 'A12:AH20'
                ];

                $fills[1] = [
                    'P9:AA9', 'AA11:AH11', 'E13:H13', 'K13:N13', 'T13:W13', 'AA13:AH13', 'C14:L14', 'N14:W14', 'Y14:AH14', 'D16:Y16', 'AD16:AH16', 'D17:Y17', 'AD17:AH16', 'E18:J18', 'M18:N18', 'S18:Y18', 'AD18:AH18', 'E19:J19', 'N19:P19', 'U19:W19', 'AD19:AH19', 'D20:J20', 'M20:Q20', 'V20:W20', 'AE20:AH20'
                ];

                $fills[2] = [
                    'AA1:AH1'
                ];

                foreach($fills as $key => $value){
                    foreach($value as $fill){
                        $event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle[$key]);  
                    }
                }

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
                $h[3] = array_merge($fills[1], [
                    'A1:AH15'
                ]);

                // HL
                $h[4] = [
                    
                ];

                // HC VC
                $h[5] = [
                    
                ];

                // B
                $h[6] = [
                    'A21'
                ];

                // VC
                $h[7] = [
                    'A1:AJ150'
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

                // UNLOCK CELLS
                foreach($fills[1] as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($lock);
                }

                // BORDERS
                $cells[0] = array_merge([
                    'A1:H11'
                ]);

                $cells[1] = array_merge([
                    'AA1:AH4'
                ]);

                $cells[2] = array_merge(([
                    'P9:AA9', 'AA11:AH11', 'E13:H13', 'K13:N13', 'T13:W13', 'AA13:AH13', 'C14:L14', 'N14:W14', 'Y14:AH14', 'D16:Y16', 'AD16:AH16', 'D17:Y17', 'AD17:AH17', 'E18:J18', 'M18:N18', 'S18:Y18', 'AD18:AH18', 'E19:J19', 'N19:P19', 'U19:W19', 'AD19:AH19', 'D20:J20', 'M20:Q20', 'V20:W20', 'AE20:AH20'
                ]));

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE

                $columns = [
                    'A', 'B', 'D', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                    'AB', 'AD', 'AF', 'AH'
                ];

                foreach($columns as $col){
                    $event->sheet->getDelegate()->getColumnDimension($col)->setWidth(3);
                }

                $columns = ['C', 'E'];

                foreach($columns as $col){
                    $event->sheet->getDelegate()->getColumnDimension($col)->setWidth(4.3);
                }

                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(3.6);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(3.6);
                $event->sheet->getDelegate()->getColumnDimension('AA')->setWidth(4.5);
                $event->sheet->getDelegate()->getColumnDimension('AC')->setWidth(4.3);
                $event->sheet->getDelegate()->getColumnDimension('AE')->setWidth(4.3);
                $event->sheet->getDelegate()->getColumnDimension('AG')->setWidth(3.7);
                // $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(35);
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
        $drawing->setHeight(218);
        $drawing->setWidth(183);
        $drawing->setOffsetX(3);
        $drawing->setOffsetY(3);
        $drawing->setCoordinates('A1');

        return $drawing;
    }
}