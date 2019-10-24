<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\{Vessel, Rank};

class WalangLagay implements FromView, WithEvents//, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $type){
        $this->applicant    = $applicant;
        $this->type         = $type;
    }

    public function view(): View
    {
        $this->applicant->load('user');
        $this->applicant->load('pro_app');
        $this->applicant->load('sea_service');
        $this->applicant->load('document_med');

        $this->applicant->vessel = Vessel::find($this->applicant->pro_app->vessel_id)->first()->name;
        $this->applicant->rank = Rank::find($this->applicant->pro_app->rank_id)->first()->abbr;

        $sea_services = $this->applicant->sea_service->sortBy('sign_off');
        $exCrew = "";
        $newHire = "";

        foreach($sea_services as $ss){
            if($exCrew != ""){
                break;
            }
        }

        return view('exports.' . lcfirst($this->type), [
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
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
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
                ],
            ],
            [
                'font' => [
                    'italic' => true
                ],
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->setTitle('TITLE', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                $event->sheet->getDelegate()->getStyle('A1:K21')->getFont()->setName('ARIAL');
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(18);
                $event->sheet->getDelegate()->getStyle('A3:A7')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('C5')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('F7')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('C8')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('G5')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('H3')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('J3:J5')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('H8')->getFont()->setSize(10);

                $event->sheet->getDelegate()->getStyle('A11:A14')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('A21')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('A19')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('E19:E20')->getFont()->setSize(8);

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

                // Hr
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
                    'B3:B8', 'H8', 'A1', 'G5', 'H7:H8', 'E10:H10', 'I3:I5', 'K3:K5', 'D5'
                ];

                // HL
                $h[4] = [
                    
                ];

                // HC VC
                $h[5] = [
                    'E11:E15', 'H11:H15'
                ];

                // B
                $h[6] = [
                    'A1', 'A16:A18'
                ];

                // VC
                $h[7] = [
                    'A10:K18'
                ];

                // HR
                $h[8] = [
                    'A3:A7', 'H3', 'J3', 'F7'
                ];

                // I
                $h[9] = [
                    'A16:E20', 
                ];

                $h['wrap'] = [
                    
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'D5'
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
                $cells[0] = array_merge([
                    'A11:K18'
                ]);


                $cells[1] = array_merge([
                    'A1:K21'
                ]);

                $cells[2] = array_merge([
                    
                ]);

                $cells[3] = array_merge([
                    'B3:E3', 'I3', 'K3', 'B5', 'D5:F5', 'I5', 'K5', 'B7:E7', 'H7:K7', 'A9:K9'
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(9.25);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(9.25);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10.25);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(11.25);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10.5);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(5.5);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(10.5);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(11);

                $event->sheet->getDelegate()->getRowDimension(4)->setRowHeight(8.25);
                $event->sheet->getDelegate()->getRowDimension(6)->setRowHeight(8.25);

                for($i = 11; $i <= 18; $i++){
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(24.75);
                }

                $event->sheet->getDelegate()->getPageSetup()->setPrintArea('A1:K21');
            },
        ];
    }
}
