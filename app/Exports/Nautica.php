<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\Rank;

class Nautica implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $type){
        $ranks = Rank::pluck('abbr', 'name');
        
        $this->data     = $data;
        $this->ranks     = $ranks;
        $this->type     = $type;
    }

    public function view(): View
    {
        return view('exports.' . lcfirst($this->type), [
            'data' => $this->data,
            'ranks' => $this->ranks,
        ]);
    }

    public function registerEvents(): array
    {
        $borderStyle = 
        [
            [//0
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ],
            [//1
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ],
            [//2
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ]
            ],
            [//3
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
            [//4
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
            [//5
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
            [//6
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [//7
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [//8
                'borders' => [
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [//9
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [//10
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ]
            ],
            [//11
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ]
            ],
            [//12
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ]
            ],
            [//13
                'borders' => [
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ]
            ],
            [//14
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ]
            ],
        ];

        $fillStyle = [
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'bdb9b9'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'ebf8a4'
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
            ],
            [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ]
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('SEAFARER APPLICATION FORM', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(1);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(1.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                // $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);

                // DEFAULT FONT AND STYLE FOR WHOLE PAGE
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Times New Roman');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(11);

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                // $event->sheet->getDelegate()->getStyle('F3')->getFont()->setSize(14);
                // $event->sheet->getDelegate()->getStyle('A1:A2')->getFont()->setName('Arial');

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

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
                ];

                // HL
                $h[5] = [
                ];

                // B
                $h[6] = [
                ];

                // VC
                $h[7] = [
                    'A1:L62', 'A63:H83', 'A84:L85', 'A87:L108'
                ];

                // VT2
                $h[8] = [
                    'I63', 'A99'
                ];

                $h['wrap'] = [
                    'I63', 'A27', 'H28'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'A39', 'H41', 'F47:F57', 'B47:B57', 'K47:K57', 'E63:E85', 'H63:H85'
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
                ];

                $fills[1] = [
                    
                ];

                foreach($fills as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($fillStyle[$key]);
                    }
                }

                // BORDERS

                // ALL BORDER THIN
                $cells[0] = array_merge([
                    'A44:L57', 'A62:H85'
                ]);

                // ALL BORDER MEDIUM
                $cells[1] = array_merge([
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                    'E6:I7', 'E8:F9', 'G8:I9', 'E10:F11', 'G10:I11', 'K5:L12', 'A14:J15', 'K14:L15',
                    'A16:D17', 'E16:G17', 'H16:J17', 'K16:L17', 'A18:D19', 'E18:J19', 'K18:L19', 'A26:A28',
                    'A20:G21', 'H20:L23','A22:G23', 'H24:J26', 'K24:L26', 'A24:G25', 'H27:L30', 'A29:G30',
                    'A31:D32', 'E31:G32', 'H31:J32', 'K31:L32', 'A33:D34', 'E33:G34', 'H33:J34', 'K33:L34',
                    'A35:D36', 'E35:G36', 'H35:J36', 'K35:L36', 'A37:D38', 'E37:G38', 'H37:J38', 'K37:L38',
                    'A39:D40', 'E39:G40', 'H39:J40', 'K39:L40', 'A41:D42', 'E41:G42', 'H41:J42', 'K41:L42',
                    'I62:L85', 'A87:L88', 'A89:L90'
                ]);

                // OUTSIDE BORDER MEDIUM
                $cells[4] = array_merge([
                ]);

                // OUTSIDE BORDER THICK
                $cells[5] = array_merge([
                ]);

                // TOP REMOVE BORDER
                $cells[6] = array_merge([
                ]);

                // BRB
                $cells[7] = array_merge([
                    'L1', 'A4:J4', 'A5:D5', 'J5', 'A11:D11', 'J11', 'A12:J12', 'E6:I6', 'E8:F8', 'G8:I8', 'E10:F10', 'G10:I10',
                    'A14:L14', 'A16:L16', 'A18:L18', 'A20:G20', 'A22:G22', 'A24:G24', 'A26:G26', 'H20:L20', 'H24:L24', 'H27:L27', 'A29:G29',
                    'A31:L31', 'A33:L33', 'A35:L35', 'A37:L37', 'A39:L39', 'A41:L41',
                    'I62:L62', 'I83:L83', 'I84:L84', 'L58'
                ]);

                // LRB
                $cells[8] = array_merge([
                ]);

                // RRB
                $cells[9] = array_merge([
                    'K1:K2', 'J84:J85', 'K58:K59'
                ]);

                // BBM
                $cells[10] = array_merge([
                    'A2:L2', 'A59:L59'
                ]);

                // TBT - TOP BORDER THIN
                $cells[11] = array_merge([
                ]);

                // BBT
                $cells[12] = array_merge([
                    'A3:L3', 'A60:L60', 'C98:G98', 'I98:J98', 'L98',
                    'C99:L99', 'C100:L100', 'C101:L101', 'C102:L102', 'C103:L103', 'C104:L104', 'C105:L105', 'C106:L106', 'C107:L107', 'C108:L108'
                ]);

                // LBT
                $cells[13] = array_merge([
                ]);

                // RBT
                $cells[14] = array_merge([
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
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(24);

                $skip = [1,2,3,4,13,43,58,59,60,61, 86, 91];
                // ROW RESIZE
                for($i = 0; $i <= 108; $i++){
                    if(!in_array($i, $skip)){
                        $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(20);
                    }
                }
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Nautica');
        $drawing->setDescription('nautica');
        $drawing->setPath(public_path("images/nsm.png"));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(70);
        $drawing->setWidth(130);
        $drawing->setOffsetX(3);
        $drawing->setOffsetY(3);
        $drawing->setCoordinates('A1');

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setName('Nautica');
        $drawing2->setDescription('nautica');
        $drawing2->setPath(public_path("images/nsm.png"));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(70);
        $drawing2->setWidth(130);
        $drawing2->setOffsetX(3);
        $drawing2->setOffsetY(3);
        $drawing2->setCoordinates('A58');

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setName('Avatar');
        $drawing3->setDescription('Crew Avatar');
        $drawing3->setPath(public_path($this->data->user->avatar));
        $drawing3->setResizeProportional(false);
        $drawing3->setHeight(200);
        $drawing3->setWidth(210);
        $drawing3->setOffsetX(3);
        $drawing3->setOffsetY(3);
        $drawing3->setCoordinates('K5');

        return [$drawing, $drawing2, $drawing3];
    }
}
