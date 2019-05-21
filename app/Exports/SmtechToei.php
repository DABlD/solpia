<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SmtechToei implements FromView, WithEvents//, WithDrawings//, ShouldAutoSize
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
	        ]
        ];

        $fillStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'ced4da'
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
            ]
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('BIODATA', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                $event->sheet->getParent()->getActiveSheet()->getDefaultColumnDimension()->setWidth(11);
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);
                // $event->sheet->getDelegate()->getDefaultStyle()->getFont()->setName('Arial');
                // $event->sheet->getDelegate()->getDefaultStyle()->getFont()->setSize(10);

                // FONT SIZES

                // ROWS
                $rows = [

                ];

                // EDUCATION BACKGROUND ROWS
                $ebRows = array();
                $temp = $this->applicant->educational_background->count();
                $raf = 28 + $temp; //Row # BEFORE EDUC BACKGROUND

                for($i = 0, $row = 29; $i < $temp; $i++, $row++){
                	array_push($ebRows, "A$row");
                	array_push($ebRows, "B$row");
                	array_push($ebRows, "C$row:F$row");
                	array_push($ebRows, "G$row:I$row");
                }

                // FUNCTIONS
                
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
                    'A1:I150'
                ];

                // HL
                $h[4] = [
                    
                ];

                // HC VC
                $h[5] = [
                    
                ];

                // B
                $h[6] = [
                    
                ];

                $h['wrap'] = [
                    
                ];

                // $event->sheet->getDelegate()->getStyle('A1:N60')->getAlignment()->setWrapText(true);
                foreach($h as $key => $value) {
                    foreach($value as $col){
                        if($key === 'wrap'){
                            $event->sheet->getDelegate()->getStyle($col)->getAlignment()->setWrapText(true);
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

                // BORDERS

                // ALL AROUND
                $cells[0] = array_merge($rows, $ebRows, [
                    'A2:B9', 'H1:I1', 'H2:I2', 'H3:H5', 'I3:I5',
                	'A28:B28', 'C28:F28', 'G28:I28',
                ]);

                // BOTTOM ONLY
                $cells[1] = [
                	'E7:F7', 'H7:I7', 'H9:I9', 'B11', 'D11', 'F11', 'H11:I11', 'B12:I12',
                	'B14:F14', 'H15:I15', 'B16', 'D16', 'F16:G16', 'I16', 'B16:C16', 'E16',
                	'G16', 'I16', 'B17:C17', 'E17', 'G17', 'I17', 'B18:C18', 'E18', 'G18', 'I18',
                	'F19', 'I19', 'D20:E20', 'G21:I21', 'B22:I22', 'B24:F24', 'G26:I26',
                ];


                foreach($cells as $key => $value) {
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // COLUMN RESIZE

                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(13);
                // $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                // $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(4);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
        $drawing->setPath(public_path($this->applicant->user->avatar));
        $drawing->setHeight(154);
        $drawing->setOffsetX(22);
		$drawing->setCoordinates('L3');

        return $drawing;
    }
}