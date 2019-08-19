<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\AuditTrail;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class Logs implements FromView, ShouldAutoSize, WithEvents
{
    public function __construct($data){
        $this->data = $data;
    }

    public function view(): View
    {
    	return view('exports.logs', [
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
                    'rgb' => 'ffff00'
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
        		// HC 
        		$h[0] = [
        			'A1:H1'
        		];

        	    foreach($h as $key => $value) {
        			foreach($value as $col){
        	    		$event->sheet->getDelegate()->getStyle($col)->applyFromArray($headingStyle[$key]);
        			}
        	    }

        	    // BORDERS
        	    $cells = [
        	        'A1','B1','C1','D1','E1','F1','G1','H1'
        	    ];

        	    foreach($cells as $cell){
        	        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle);
                	$event->sheet->getDelegate()->getStyle($cell)->applyFromArray($fillStyle);	
        	    }

        	    // DELETE EXPORTED DATA
        	    AuditTrail::take(sizeof($this->data))->delete();
            },
        ];
    }
}
