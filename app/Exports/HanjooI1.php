<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class HanjooI1 implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
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
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
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
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'EEECE1'
                ]
            ],
        ];

        $headingStyle = [
            [
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
            ],
            [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                ]
            ],
            [
                'font' => [
                    'underline' => true
                ],
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
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

                $event->sheet->getDelegate()->getStyle('A1:K37')->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle('A1:K37')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('A5')->getFont()->setSize(16);

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

                // FONT SIZES

                // HEADINGS

                // HC B
                $h[0] = [
                    
                ];

                // VT
                $h[1] = [
                    'A6'
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    
                ];

                // HL
                $h[4] = [
                    'A17'
                ];

                // HC VC
                $h[5] = [
                    'F2', 'A5', 'A7', 'D7', 'G7', 'A8:I8',
                    'A8', 'C8', 'D8', 'F8', 'I8', 'A7:I30',
                    'F31:F34'
                ];

                // B
                $h[6] = [
                    'A5', 'A7', 'D7', 'G7', 'A8:I8',
                    'A8', 'C8', 'D8', 'F8', 'I8', 'A7:I7'
                ];

                // VC
                $h[7] = [
                    'A9:A30', 'A32', 'C32', 'I9:I30', 'B7', 'E7', 'H7'
                ];

                //HR
                $h[8] = [
                    'A34'
                ];

                //underline
                $h[9] = [
                    'C34'
                ];

                $h['wrap'] = [
                    'A17'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'C9:H30'
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
                $fills = [
                    
                ];

                foreach($fills as $fill){
                    $event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle);  
                }

                $rows = array();
                for($i = 9; $i <= 28; $i++){
                    array_push($rows, "A$i:B$i");
                    array_push($rows, "C$i");
                    array_push($rows, "D$i:E$i");
                    array_push($rows, "F$i:H$i");
                    array_push($rows, "I$i");
                }

                // BORDERS
                $cells[0] = array_merge($rows, [
                    'F2:I3', 'A5:I34'
                ]);

                $cells[1] = array_merge([
                    // 'A5:I5', 'A6:I6',
                    // 'A7', 'B7:C7', 'D7', 'E7:F7', 'G7', 'H7:I7',
                    // 'A8:B8', 'C8', 'D8:E8', 'F8:H8', 'I8',
                ]);

                $cells[2] = array_merge([
                    // 'A9:B28', 'C9:C28', 'D9:E28', 'F9:H28', 'I9:I28',
                    // 'A9:B16', 'C9:C16', 'D9:E16', 'F9:H16', 'I9:I16',
                    // 'A17:B25', 'C17:C25', 'D17:E25', 'F17:H25', 'I17:I25',
                    // 'A26:B26', 'C26', 'D26:E26', 'F26:H26', 'I26',
                    // 'A27:B28', 'C27:C28', 'D27:D28', 'F27:F28', 'I27:I28',
                    // 'A29:E30', 'F29:I30', 'A31:E32', 'F31:I32'
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('F31:F34')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(6.2);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(9);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(3.6);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(6.5);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(3.7);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(26);

                $event->sheet->getDelegate()->getRowDimension('5')->setRowHeight(33);
                $event->sheet->getDelegate()->getRowDimension('6')->setRowHeight(28.50);
                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(28.50);

                for($i = 8; $i <= 34; $i++){
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(22.50);
                }
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('INTERGIS');
        $drawing->setDescription('INTERGIS');
        $drawing->setPath(public_path('images/integris.png'));
        $drawing->setHeight(40);
        // $drawing->setWidth(165);
        $drawing->setOffsetX(1);
        $drawing->setOffsetY(3);
        $drawing->setCoordinates('A2');

        return $drawing;
    }
}