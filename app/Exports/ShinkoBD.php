<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ShinkoBD implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
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
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('BIO DATA', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                // FONT SIZES

                $event->sheet->getDelegate()->getStyle('A4:N60')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(18);
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->setSize(12);

                // FAMILY DATA ROWS
                $fdRows = array();
                $temp = $this->applicant->family_data->count() / 2;
                $raf = 22 + $temp; //Row # After Family Data

                for($i = 0, $row = 23; $i < $temp; $i++, $row++){
                	array_push($fdRows, 'A' . $row);
                	array_push($fdRows, 'B' . $row . ':C' . $row);
                	array_push($fdRows, 'D' . $row . ':E' . $row);
                	array_push($fdRows, 'F' . $row);
                	array_push($fdRows, 'G' . $row);
                	array_push($fdRows, 'H' . $row . ':J' . $row);
                	array_push($fdRows, 'K' . $row . ':L' . $row);
                	array_push($fdRows, 'M' . $row . ':N' . $row);
                }

                // SS DATA ROWS
                $ssRows = array();
                $temp = $this->applicant->sea_service->count();
                $ras = $raf + 2 + ($temp*2); //Row # after Sea Service

                for($i = 0, $row = $raf + 4; $i < $temp; $i++, $row+=2){
                    $next = $row + 1;
                    array_push($ssRows, 'A' . $row . ':A' . $next);
                    array_push($ssRows, 'B' . $row . ':D' . $next);
                    array_push($ssRows, 'E' . $row . ':E' . $next);
                    array_push($ssRows, 'F' . $row);
                    array_push($ssRows, 'F' . $next);
                    array_push($ssRows, 'G' . $row . ':G' . $next);
                    array_push($ssRows, 'H' . $row . ':H' . $next);
                    array_push($ssRows, 'I' . $row);
                    array_push($ssRows, 'I' . $next);
                    array_push($ssRows, 'J' . $row);
                    array_push($ssRows, 'J' . $next);
                    array_push($ssRows, 'K' . $row . ':L' . $row);
                    array_push($ssRows, 'K' . $next . ':L' . $next);
                    array_push($ssRows, 'M' . $row . ':N' . $next);

                    $event->sheet->getDelegate()->getRowDimension($row)->setRowHeight(35);
                    $event->sheet->getDelegate()->getRowDimension($row+1)->setRowHeight(35);
                }

                // FUNCTIONS
                $x = function($let1, $inc1, $let2 = null, $inc2 = null, $temp = null) use ($raf, $ras){
                    $temp = $temp==null? $raf : $ras;

                	if($let2 == null){
                		return $let1 . ($temp + $inc1);
                	}
                	else{
                		$inc2 = $inc2 == null? $inc1 : $inc2;
                		return $let1 . ($temp + $inc1) . ':' . $let2 . ($temp + $inc2);
                	}
                };

                // HEADINGS

                // HC B
                $h[0] = [
                	'A1:A2', 'A11:H11', 'G17', 'A21', $x('A', 1),
                ];

                // VT
                $h[1] = array_merge($fdRows, $ssRows, [
                	'H3', 'G12:I12', 'A13:A17',
                ]);

                // HL B
                $h[2] = [
                	'C7:C10', 'I7:I10',
                ];

                // HC
                $h[3] = [
                	'A22:N22', $x('A', 2, 'N', 2), $x('H', 11, 'M', 11, true),
                ];

                // HL
                $h[4] = [
                    'C13:E20'
                ];

                $h['wrap'] = array_merge($fdRows, $ssRows, [
                	'I12', 'A13', $x('A', 2, 'N'), $x('A', 7, 'N', 7, true),
                ]);

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
                	'H3:I6',
                	'A7:B7', 'G7:H7',
                	'A8:B8', 'G8:H8',
                	'A9:B9', 'G9:H9',
                	'A10:B10', 'G10:H10',
                	'A11', 'H11',
                	'A12', 'C12', 'E12', 'G12',
                	'A13:A21', 'B13:B18', 'G14:G20',
                	'A22:N22',
                	$x('A', 1, 'N', 2)
                ];

                foreach($fills as $fill){
                	$event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle);	
                }

                // BORDERS
                $cells = array_merge($fdRows, $ssRows, [
                    'H3:I6','J3:K6','L3:N10',
                	'A7:B7', 'G7:H7', 'C7:F7', 'I7:K7',
                	'A8:B8', 'G8:H8', 'C8:F8', 'I8:K8',
                	'A9:B9', 'G9:H9', 'C9:F9', 'I9:K9', 'K9',
                	'A10:B10', 'G10:H10', 'C10:F10', 'I10:K10', 'K10',
                	'A11:G11', 'H11:N11',
                	'A12:B12', 'C12:D12', 'E12:F12', 'G12:H13', 'I12:N13',
                	'A13:A14', 'B13', 'C13:D13', 'E13:F14',
                	'B14', 'C14:D14', 'E14:F14', 'G14:H14', 'I14:N14',
                	'A15:A16', 'B15', 'B16', 'C15:D15', 'E15:F15', 'G15:H15', 'I15:N15',
                	'C16:D16', 'E16:F16', 'G16:H16', 'I16:N16',
                	'A17:A18', 'B17', 'B18', 'C17:D17', 'E17:F17', 'G17:H17', 'I17:N17',
                	'C18:D18', 'E18:F18', 'G18:H18', 'I18:N18',
                	'A19:B19', 'C19:D19', 'E19:F19', 'G19:H19', 'I19:N19',
                	'A20:B20', 'C20:D20', 'E20:F20', 'G20:H20', 'I20:N20',
                	'A21', 'A22', 'B22:C22', 'D22:E22', 'F22', 'G22', 'H22:J22', 'K22:L22', 'M22:N22',
                	$x('A', 1, 'N'),

                	$x('A', 2, 'A', 3), $x('B', 2, 'D', 3), $x('E', 2, 'E', 3), $x('F', 2, 'F', 3),
                	$x('G', 2, 'G', 3), $x('H', 2, 'H', 3), $x('I', 2, 'I', 3), $x('J', 2, 'J', 3),
                	$x('K', 2, 'L', 3), $x('M', 2, 'N', 3),

                    $x('K', 2, 'K', 2, true), $x('M', 2, 'M', 2, true),
                    $x('H', 4, 'N', 4, true),
                    $x('H', 5, 'N', 5, true),
                    $x('H', 10, 'M', 10, true),
                ]);

                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle);
                }

                // COLUMN RESIZE

                // $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(4);
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
