<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;

use App\Models\Vessel;

use Illuminate\Support\Str;

class Kosco1 implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $type){
        $this->data     = $data;
        $this->type     = $type;
    }

    public function view(): View
    {
        $ssTotalM['bulk'] = 0;
        $ssTotalY['bulk'] = 0;

        $ssTotalM['container'] = 0;
        $ssTotalY['container'] = 0;

    	foreach($this->data->sea_service as $ss){
    		if($ss->vessel_name != ""){
    			$ss->year_built = Vessel::where('name', $ss->vessel_name)->first()->year_build ?? null;
    		}
    		else{
    			$ss->year_built = null;
    		}

            if($ss->sign_on != "" && $ss->sign_off != ""){
                if(Str::contains(strtoupper($ss->vessel_type), 'BULK')){
                    $temp = 'bulk';
                }
                elseif(Str::contains(strtoupper($ss->vessel_type), 'CONTAINER')){
                    $temp = 'container';
                }

                if(isset($temp)){
                    $ssTotalM[$temp] += round($ss->sign_on->floatDiffInMonths($ss->sign_off), 1);
                    $ssTotalY[$temp] += round($ss->sign_on->floatDiffInYears($ss->sign_off), 1);
                }
            }
    	}

        return view('exports.' . lcfirst($this->type), [
            'applicant' => $this->data,
            'ssTotalM' => $ssTotalM,
            'ssTotalY' => $ssTotalY
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
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
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
                        'rgb' => 'CCCCCC'
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

                $event->sheet->getDelegate()->getPageSetup()->setFitToPage(false);
                $event->sheet->getDelegate()->getPageSetup()->setScale(60);

                $event->sheet->getDelegate()->setTitle('BIO_DATA', false);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.25);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                // DEFAULT FONT AND STYLE FOR WHOLE PAGE
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('A1:A2')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('E3:E4')->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle('P3')->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle('B11')->getFont()->setSize(7);
                $event->sheet->getDelegate()->getStyle('L14:L25')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('M13')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('R13')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('A26:V26')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('A28:A34')->getFont()->setSize(10);
                // $event->sheet->getDelegate()->getStyle('A1:A2')->getFont()->setName('Arial');

                // CELL COLOR
                $event->sheet->getDelegate()->getStyle('E3:E7')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('P3:P5')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('E14:V25')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('A30')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('A32')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('A34')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('D37')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('E38:E40')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('I37')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('L38:L40')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('N37')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('R37:R40')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('V37')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('J42:l52')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('R42:R52')->getFont()->getColor()->setRGB('0000FF');
                $event->sheet->getDelegate()->getStyle('U42')->getFont()->getColor()->setRGB('0000FF');

                $event->sheet->getDelegate()->getStyle('A35:A36')->getFont()->getColor()->setRGB('FF0000');

                // TEXT ROTATION
                $event->sheet->getDelegate()->getStyle('A3')->getAlignment()->setTextRotation(90);
                $event->sheet->getDelegate()->getStyle('B11')->getAlignment()->setTextRotation(-90);

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

                // HIDE GRID
                $event->sheet->getParent()->getActiveSheet()->setShowGridlines(false);

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

                // HL
                $h[4] = [
                    
                ];

                // HC VC
                $h[5] = [
                    'A1:V41', 'A26:V28', 'A29:A36', 'J42:V52'
                ];

                // B
                $h[6] = [
                    'A3', 'E3:E4', 'P3', 'B13:U13', 'E14:E25', 'I14:I25', 
                    'A26:V28', 'A29:A36', 'A41:U41', 'E42:E52', 'U42'
                ];

                // VC
                $h[7] = [
                    'A42:V52'
                ];

                $h['wrap'] = [
                    'E7', 'B11', 'M13', 'N8', 'U14:U25', 'L14:L25', 'I14:I25', 'F14:F25',
                    'A26:V26', 'A29:A36', 'A41:E52', 'O42:O52', 'J42:J52', 'S14:T25', 'A3'
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
                    'A37:V37'
                ];

                $fills[1] = [
                    
                ];

                foreach($fills as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($fillStyle[$key]);
                    }
                }

                // BORDERS
                $cells[0] = array_merge([
                    'Q1:V2', 'B3:V13', 'E14:E25', 'F14:V25', 'I14:J25', 'K14:K25', 'L14:L25', 'M14:M25', 'N14:O25', 'P14:Q25', 'R14:R25', 'S14:S25', 'T14:T25', 'U14:V25', 'A26:V26', 'A29:V34', 'A37:V52'
                ]);

                $cells[1] = array_merge([
                	'A1:P2'
                ]);

                $cells[2] = array_merge([
                    'A27:V27', 'A28:V28', 'A35:V36'
                ]);

                $cells[3] = array_merge([
                    'A1:V52'
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(3.7);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(5.8);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(11.2);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(9);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(3.5);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(6.4);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(8.5);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(5.2);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(6.5);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(1.8);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(10.5);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(2.9);
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(8.5);
                $event->sheet->getDelegate()->getColumnDimension('S')->setWidth(12.1);
                $event->sheet->getDelegate()->getColumnDimension('T')->setWidth(11.5);
                $event->sheet->getDelegate()->getColumnDimension('U')->setWidth(6.75);
                $event->sheet->getDelegate()->getColumnDimension('V')->setWidth(9);

                // ROW RESIZE
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(24.25);
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(35);
                $event->sheet->getDelegate()->getRowDimension(3)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(4)->setRowHeight(16.75);
                $event->sheet->getDelegate()->getRowDimension(5)->setRowHeight(16.75);
                $event->sheet->getDelegate()->getRowDimension(6)->setRowHeight(15.25);
                $event->sheet->getDelegate()->getRowDimension(7)->setRowHeight(27.25);
                $event->sheet->getDelegate()->getRowDimension(8)->setRowHeight(16.75);
                $event->sheet->getDelegate()->getRowDimension(9)->setRowHeight(16.75);
                $event->sheet->getDelegate()->getRowDimension(10)->setRowHeight(14.50);
                $event->sheet->getDelegate()->getRowDimension(11)->setRowHeight(14);
                $event->sheet->getDelegate()->getRowDimension(12)->setRowHeight(20);
                $event->sheet->getDelegate()->getRowDimension(13)->setRowHeight(22);
                $event->sheet->getDelegate()->getRowDimension(14)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(15)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(16)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(17)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(18)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(19)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(20)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(21)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(22)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(23)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(24)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(25)->setRowHeight(35.75);
                $event->sheet->getDelegate()->getRowDimension(26)->setRowHeight(30.25);
                $event->sheet->getDelegate()->getRowDimension(27)->setRowHeight(32.50);
                $event->sheet->getDelegate()->getRowDimension(28)->setRowHeight(14.50);
                $event->sheet->getDelegate()->getRowDimension(29)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(30)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(31)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(32)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(33)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(34)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(35)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(36)->setRowHeight(16);

                for($i = 38; $i <= 52; $i++){
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(24.75);                    
                }

                // SET PRINT AREA
                $event->sheet->getDelegate()->getPageSetup()->setPrintArea("A1:V52");
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Avatar');
		$drawing->setDescription('Avatar');
        $drawing->setPath(public_path($this->data->user->avatar));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(129);
        $drawing->setWidth(119);
        $drawing->setOffsetX(1);
        $drawing->setOffsetY(1);
		$drawing->setCoordinates('B14');

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing2->setName('Logo');
		$drawing2->setDescription('Logo');
        $drawing2->setPath(public_path('images/logo.png'));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(65);
        $drawing2->setWidth(159);
        $drawing2->setOffsetX(3);
        $drawing2->setOffsetY(3);
		$drawing2->setCoordinates('A1');

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing3->setName('Sir Kit Sig');
		$drawing3->setDescription('Sir Kit Sig');
        $drawing3->setPath(public_path('images/sir_kit_sig.png'));
        $drawing3->setResizeProportional(false);
        $drawing3->setHeight(50);
        $drawing3->setWidth(170);
        $drawing3->setOffsetX(-7);
        $drawing3->setOffsetY(-3);
		$drawing3->setCoordinates('S29');

        $drawing4 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing4->setName('Sir Pres Sig');
		$drawing4->setDescription('Sir Pres Sig');
        $drawing4->setPath(public_path('images/pres_sig.png'));
        $drawing4->setResizeProportional(false);
        $drawing4->setHeight(100);
        $drawing4->setWidth(104);
        $drawing4->setOffsetX(35);
        $drawing4->setOffsetY(-35);
		$drawing4->setCoordinates('S31');

        return [$drawing, $drawing2, $drawing3, $drawing4];
    }
}
