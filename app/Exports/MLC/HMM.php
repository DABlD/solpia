<?php

namespace App\Exports\MLC;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;

class HMM implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $title = "HMM MLC"){
        $array1 = [
            'M/V HMM MIR', 'M/V HMM ALGECIRAS', 'M/V HYUNDAI BRAVE', 'M/V HMM SOUTHAMPTON', 'M/V HMM HAMBURG', 'M/V HYUNDAI FAITH', 'M/V HMM ST. PETERSBURG', 'M/V HMM LE HAVRE', 'M/V HYUNDAI COURAGE', 'M/V HMM RAON', 'M/V HMM COPENHAGEN', 'M/V HMM GARAM', 'M/V HMM NURI', 'M/V HMM GDANSK', 'M/V HMM HANBADA', 'M/V HMM OSLO', 'M/V HYUNDAI FORCE'
        ];

        $array2 = [
            'M/V HYUNDAI ANTWERP', 'M/V HYUNDAI ULSAN'
        ];

        $array3 = [
            'M/V HYUNDAI UNITY', 'M/V HYUNDAI GRACE', 'M/V HYUNDAI COLOMBO'
        ];

        if(in_array($applicant->vessel->name, $array1)){
            $applicant->shipowner = "HMM Company Limited";
            $applicant->sAddress = "1-7 YEONGJI-DONG, JONGNO-GU, SEOUL, KOREA";
            $applicant->crewManager = "HMM Ocean Service Co., Ltd.";
            $applicant->cAddress = "BUSAN POST OFFICE BUILDING, 5TH FLOOR, JUNGANG-DONG 3GA, JUNG-GU, BUSAN, KOREA";
        }
        elseif(in_array($applicant->vessel->name, $array2)){
            $applicant->shipowner = 'HMM Ocean Service Co., Ltd.';
            $applicant->sAddress = '63, Jungangdaero, Jung-Gu, Busan, 600-711, Korea';
        }
        elseif(in_array($applicant->vessel->name, $array3)){
            $applicant->shipowner = "HMM Company Limited";
            $applicant->sAddress = '108, Yeoui-daero, Yeongdeungpo-gu, Seoul, Republic of Korea';
            $applicant->crewManager = 'HMM Ocean Service Co., Ltd.';
            $applicant->cAddress = '63, Jungangdaero, Jung-Gu, Busan, 600-711, Korea';
        }
        else{
            // DEFAULT
            $applicant->shipowner = "HMM Company Limited";
            $applicant->sAddress = "1-7 YEONGJI-DONG, JONGNO-GU, SEOUL, KOREA";
            $applicant->crewManager = "HMM Ocean Service Co., Ltd.";
            $applicant->cAddress = "BUSAN POST OFFICE BUILDING, 5TH FLOOR, JUNGANG-DONG 3GA, JUNG-GU, BUSAN, KOREA";
        }

        $this->applicant    = $applicant;
        $this->title        = $title;
    }

    public function view(): View
    {
        $exportView = str_replace(' ', '_', $this->applicant->vessel->fleet) . '.hmm';
        return view('exports.mlc.' . $exportView, [
            'data' => $this->applicant,
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
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
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
            [
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
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
            [
                'borders' => [
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                ]
            ],
            [
                'borders' => [
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
            ],
            [
                'font' => [
                    'bold' => true,
                    'italic' => true
                ],
            ],
        ];

        $title = $this->title;

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle, $title) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle(str_replace('/', '', $title), false);
                $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter('&R&P/&N');

                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.7);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.7);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.7);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.7);

                $event->sheet->getDelegate()->getStyle('A1:H58')->getFont()->setName('Times New Roman');
                $event->sheet->getDelegate()->getStyle('A4:H58')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('B21')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('A42')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('A45')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('A48')->getFont()->setSize(8);

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

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
                    'B21'
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
                ];

                // B
                $h[6] = [
                ];

                // VC
                $h[7] = [
                    'A1:I20',
                    'A21',
                    'A22:I58'
                ];

                // B I
                $h[8] = [
                ];

                $h['wrap'] = [
                    'A23', 'A32', 'B26', 'C23', 'E23', 
                    'E26', 'B21', 'B29', 'B30', 'A39',
                    'A42', 'A45', 'A48', 'A50', 'A56'
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'F8', 'E54', 'C7', 'H8', 'C12',
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
                    'A7:I16', 'A19:I21', 'A23:I30', 'A32:I35', 'A39:I39', 'A42:I42', 'A45:I45', 'A48:I48', 'A56:I57'
                ]);

                // ALL BORDER MEDIUM
                $cells[1] = array_merge([
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                ]);

                // OUTSIDE BORDER MEDIUM
                $cells[4] = array_merge([
                ]);

                // OUTSIDE BORDER THICK
                $cells[5] = array_merge([
                ]);

                // BOTTOM BORDER THIN
                $cells[7] = array_merge([
                    'A52:C52', 'E52:H52'
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20.5);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(11);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(21);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(6);

                // ROW RESIZE
                for($i = 1; $i <= 59; $i++){
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(21);
                }

                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(17);
                $event->sheet->getDelegate()->getRowDimension(3)->setRowHeight(17);
                $event->sheet->getDelegate()->getRowDimension(5)->setRowHeight(17);
                $event->sheet->getDelegate()->getRowDimension(17)->setRowHeight(17);
                $event->sheet->getDelegate()->getRowDimension(21)->setRowHeight(110);
                $event->sheet->getDelegate()->getRowDimension(23)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(24)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(26)->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension(27)->setRowHeight(25);
                $event->sheet->getDelegate()->getRowDimension(28)->setRowHeight(25);
                $event->sheet->getDelegate()->getRowDimension(29)->setRowHeight(50);
                $event->sheet->getDelegate()->getRowDimension(30)->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension(32)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(33)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(34)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(35)->setRowHeight(35);

                // TO PAGE 2
                $event->sheet->getDelegate()->getRowDimension(36)->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension(37)->setRowHeight(20);
                // END

                $event->sheet->getDelegate()->getRowDimension(39)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(42)->setRowHeight(95);
                $event->sheet->getDelegate()->getRowDimension(45)->setRowHeight(115);
                $event->sheet->getDelegate()->getRowDimension(48)->setRowHeight(80);
                $event->sheet->getDelegate()->getRowDimension(50)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(51)->setRowHeight(120);
                $event->sheet->getDelegate()->getRowDimension(52)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(53)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(54)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(56)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(57)->setRowHeight(16);
                $event->sheet->getDelegate()->getRowDimension(58)->setRowHeight(16);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path('images/MLC_SEAL.png'));
        $drawing->setCoordinates('G51');
        $drawing->setHeight(154);
        $drawing->setWidth(154);
        $drawing->setOffsetX(35);
        $drawing->setOffsetY(3);

        $drawing3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing3->setName('mlc_hmm_sig');
        $drawing3->setDescription('mlc_hmm_sig');
        $drawing3->setPath(public_path('images/mlc_hmm_sig.jpg'));
        $drawing3->setOffsetX(2);
        $drawing3->setOffsetY(2);
        $drawing3->setCoordinates('E51');
        $drawing3->setHeight(140);
        $drawing3->setWidth(140);

        return [$drawing, $drawing3];
    }
}
