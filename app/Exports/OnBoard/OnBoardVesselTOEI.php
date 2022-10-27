<?php

namespace App\Exports\OnBoard;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\{LineUpContract, Rank, DocumentId, Applicant};
use DB;

class OnBoardVesselTOEI implements FromView, WithEvents//, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $type, $req){
        $this->data     = $data;
        $this->type     = $type;
        $this->req      = $req;
        $this->size     = 0;
    }

    public function view(): View
    {
        $onBoards = $this->data;
        $onBoards->load('vessel');

        $this->size = sizeof($onBoards);

        $temp = collect();
        $ranks = Rank::select('abbr', 'type')->get();

        // SORT BY RANK
        foreach($ranks as $rank){
            foreach($onBoards as $key => $linedUp){
                if($linedUp->abbr == $rank->abbr){
                    $linedUp->rType = $rank->type;
                    $temp->push($linedUp);
                    $onBoards->pull($key);
                }
            }
        }


        $onBoards = $temp;
        $view = lcfirst($this->type);

        foreach($onBoards as $obc){
            $obc->applicant_id = $obc->id;
            $obc->load('document_id');
            $obc->load('document_lc');
            $obc->load('document_flag');
            $obc->load('document_med_cert');
            
            foreach(['document_id', 'document_flag', 'document_lc', 'document_med_cert' ] as $docuType){
                foreach($obc->$docuType as $key => $doc){
                    $name = $doc->type;
                    if(!isset($obc->$docuType->$name)){
                        $obc->$docuType->$name = $doc;
                    }
                    else{
                        $size = 0;
                        if(is_array($obc->$docuType->$name)){
                            $size = sizeof($obc->$docuType->$name);
                        }
                        $name .= $size;
                        $obc->$docuType->$name = $doc;
                    }
                    $obc->$docuType->forget($key);
                }
            }
        }

        return view('exports.OnBoard.' . $view, [
            'data'      => $onBoards,
            'filename'  => $this->req['filename'],
            'ranks' => Rank::all()
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
                        'rgb' => '26b36c'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'ffddcc'
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
                $event->sheet->getDelegate()->setTitle($this->req['filename'], false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

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
                $event->sheet->getDelegate()->getStyle('B3:O3')->getFont()->setSize(10);

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
                ];

                // B
                $h[6] = [
                    
                ];

                // VC
                $h[7] = [
                    
                ];

                $h['wrap'] = [
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
                ]);


                $cells[1] = array_merge([
                ]);


                $cells[2] = array_merge([
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                // $event->sheet->getDelegate()->getColumnDimension('A')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('B')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('C')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('D')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('E')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('F')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('G')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('H')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('I')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('J')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('K')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('L')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('M')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('N')->setWidth();
                // $event->sheet->getDelegate()->getColumnDimension('O')->setWidth();

                // ROW RESIZE
                // $event->sheet->getDelegate()->getRowDimension(4)->setRowHeight(8.25);

                $event->sheet->getDelegate()->getStyle('K6:K' . ($this->size + 5))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
            },
        ];
    }
}
