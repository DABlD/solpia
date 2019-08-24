<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\Principal;

class Vessels implements FromView, WithEvents
{
    public function __construct($data){
        $this->data = $data;
    }

    public function view(): View
    {
    	return view('exports.vessels', [
            'datas' => $this->data
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
                    'rgb' => '92d050'
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
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
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
                $event->sheet->getDelegate()->setTitle('FLEET LIST', false);
                $event->sheet->getDelegate()->getStyle('B1')->getFont()->setSize(25);
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(40);

                $size = sizeof($this->data);

                // HC 
        		$h[0] = [
        			'A1:N1'
        		];

                // HC 
                $h[3] = [
                    'B1', 'A2:N' . ($size + 2)
                ];

                $h[4] = [
                    'B1', 'A2:N' . ($size + 2)
                ];

                $h['wrap'] = [
                    'A2:' . 'N' . ($size + 2)
                ];

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

        	    // BORDERS
        	    $cells = [
                    "B1:N1"
                ];

                for($i = 2; $i < ($size + 3) ; $i++){
                    if($i >  2){
                        $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(25);
                    }

                    array_push($cells, 'B' . $i);
                    array_push($cells, 'C' . $i);
                    array_push($cells, 'D' . $i);
                    array_push($cells, 'E' . $i);
                    array_push($cells, 'F' . $i);
                    array_push($cells, 'G' . $i);
                    array_push($cells, 'H' . $i);
                    array_push($cells, 'I' . $i);
                    array_push($cells, 'J' . $i);
                    array_push($cells, 'K' . $i);
                    array_push($cells, 'L' . $i);
                    array_push($cells, 'M' . $i);
                    array_push($cells, 'N' . $i);
                }

        	    foreach($cells as $cell){
        	        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle);
        	    }

                $cells = [
                    'A2:N2'
                ];

                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($fillStyle);
                }

                $event->sheet->getDelegate()->getStyle('G3:G' . ($size + 2))->getFont()->setSize(8);

                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10.8);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(13.8);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(7.8);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(17.8);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(35.3);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(10.8);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(10.8);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(10.8);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(8.8);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(18.3);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(15.3);
            },
        ];
    }
}
