<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class HanjooI2 implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
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
                $event->sheet->getDelegate()->setTitle('INTERVIEW CHECKLIST.INTERGES', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                // FONT SIZES
                $event->sheet->getDelegate()->getStyle('A1:Q36')->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle('A1:Q36')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('A5')->getFont()->setSize(16);

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

                // HL
                $h[4] = [
                    
                ];

                // HC VC
                $h[5] = [
                    'A1:O33'
                ];

                // B
                $h[6] = [
                    'A12', 'A17'//, 'D32', 'M32'
                ];

                // VC
                $h[7] = [
                    
                ];

                $h['wrap'] = [
                    'D26:D27', 'E13:E15', 'F7:F9'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                	'D22:D24', 'B15'
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

                // ROTATE TEXT
                $event->sheet->getDelegate()->getStyle('A12')->getAlignment()->setTextRotation(-90);
                $event->sheet->getDelegate()->getStyle('A17')->getAlignment()->setTextRotation(-90);

                // FILLS
                $fills = [
                    
                ];

                foreach($fills as $fill){
                    $event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle);  
                }

                // BORDERS
                $cells[0] = array_merge([
                	'G2:O3'
                ]);

                $cells[1] = array_merge([
                	'A7:O33'
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(13.5);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(7.5);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(8.5);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(3);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(1.5);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(2);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(3);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(8);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(8);

                $event->sheet->getDelegate()->getRowDimension('5')->setRowHeight(33);
                $event->sheet->getDelegate()->getRowDimension('6')->setRowHeight(28.5);

                $event->sheet->getDelegate()->getRowDimension('11')->setRowHeight(22.5);
                $event->sheet->getDelegate()->getRowDimension('12')->setRowHeight(22.5);
                $event->sheet->getDelegate()->getRowDimension('13')->setRowHeight(27.75);
                $event->sheet->getDelegate()->getRowDimension('14')->setRowHeight(26.25);
                $event->sheet->getDelegate()->getRowDimension('15')->setRowHeight(28.5);

                $event->sheet->getDelegate()->getRowDimension('26')->setRowHeight(29.25);
                $event->sheet->getDelegate()->getRowDimension('27')->setRowHeight(27);
                $event->sheet->getDelegate()->getRowDimension('28')->setRowHeight(22.5);
                $event->sheet->getDelegate()->getRowDimension('29')->setRowHeight(21);
                $event->sheet->getDelegate()->getRowDimension('30')->setRowHeight(19.5);
                $event->sheet->getDelegate()->getRowDimension('31')->setRowHeight(21);
                $event->sheet->getDelegate()->getRowDimension('32')->setRowHeight(21);
                $event->sheet->getDelegate()->getRowDimension('33')->setRowHeight(27.5);

                for($i = 7; $i <= 10; $i++){
                	$event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(27);
                }

                for($i = 16; $i <= 25; $i++){
                	$event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(22.5);
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

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setName('YN1');
        $drawing2->setDescription('YN1');
        $drawing2->setPath(public_path('images/yn1.jpg'));
        $drawing2->setCoordinates('D32');
        $drawing2->setOffsetX(7);
        $drawing2->setOffsetY(3);
        $drawing2->setResizeProportional(false);
        $drawing2->setWidth(130);
        $drawing2->setHeight(23);

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setName('YN2');
        $drawing3->setDescription('YN2');
        $drawing3->setPath(public_path('images/yn2.jpg'));
        $drawing3->setCoordinates('M32');
        $drawing3->setOffsetX(7);
        $drawing3->setOffsetY(3);
        $drawing3->setResizeProportional(false);
        $drawing3->setWidth(130);
        $drawing3->setHeight(23);

        return [$drawing, $drawing2, $drawing3];
    }
}