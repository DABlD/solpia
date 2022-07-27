<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;

use App\Models\{Applicant, Rank, Vessel, LineUpContract};

class RequestToProcess implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($data, $type, $req){
        $this->data     = $data;
        $this->type     = $type;
        $this->req      = $req;
    }

    public function view(): View
    {
        $crews = array();
        $tempCrews = $this->req['crews'];
        $vessel = "";
        $port = null;
        $ports = null;

        if($this->req['port']){
            $port = $this->req['port'];
        }
        else{
            $ports = LineUpContract::whereIn('applicant_id', $tempCrews)->whereNull('disembarkation_date')->pluck('joining_port', 'applicant_id');
        }

        $this->data->port       = $port;
        $this->data->department = $this->req['department'];
        $this->data->departure  = $this->req['departure'];
        $this->data->docus      = $this->req['docus'];

        foreach($tempCrews as $id){
            $crew = Applicant::find($id);

            $crew->load('user');
            $crew->load('pro_app');
            $crew->rank = Rank::find($crew->pro_app->rank_id)->abbr;
            $crew->vessel = $vessel == "" ? Vessel::find($crew->pro_app->vessel_id)->name : $vessel;
            $crew->port = $ports[$id];

            array_push($crews, $crew);
        }

        for($i = sizeof($crews); $i < 20; $i++){
            array_push($crews, (object)[
                'user'      => (object)['lname' => '', 'fname' => '', 'mname' => '', 'suffix' => ''],
                'rank'      => "",
                'vessel'    => "",
            ]);
        }

        return view('exports.' . lcfirst($this->type), [
            'data' => $this->data,
            'crews' => $crews
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
                        'rgb' => 'a6a6a6'
                    ]
                ],
            ],
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'a6a6a6'
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
                $event->sheet->getDelegate()->setTitle('Request To Process', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(1);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.2);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.2);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);

                $event->sheet->setShowGridlines(false);

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
                // HEADINGS
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

                // HC B
                $h[0] = [
                    
                ];

                // VT
                $h[1] = [
                    'A33:O33',
                    'A68:O68'
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
                    'A12:O31',
                    'A47:O64',
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
                    'A2:O2',
                    'A37:O37'
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
                    'A10:O11', 'A33:A34', 'A32:O34',
                    'A45:O46', 'A68:A69', 'A67:O69'
                ]);


                $cells[1] = array_merge([
                    'A2:O8', 'A11:O31',
                    'A37:O43', 'A46:O66'
                ]);


                $cells[2] = array_merge([
                    
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                $event->sheet->getDelegate()->getStyle('B4')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('F4')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('J4')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('B6')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('F6')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('J6')->getFont()->setName('Marlett');

                $event->sheet->getDelegate()->getStyle('B39')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('F39')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('J39')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('B41')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('F41')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('J41')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(11.5);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(8);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(3);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(4);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(14);

                // ROW RESIZE
                $skip = [1,2,3,5,9,10,32,33,36,37,38,40,44,45,67,68];
                for($i = 0; $i < 34; $i++){
                    if(!in_array($i, $skip) && $i < 12 && $i > 31){
                        $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(17);
                    }
                }
                
                // SET PRINT AREA
                $event->sheet->getDelegate()->getPageSetup()->setPrintArea("A1:O69");
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path('images/letter_head.jpg'));
        $drawing->setResizeProportional(false);
        $drawing->setCoordinates('A1');
        $drawing->setHeight(59);
        $drawing->setWidth(685);

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setPath(public_path('images/letter_head.jpg'));
        $drawing2->setResizeProportional(false);
        $drawing2->setCoordinates('A36');
        $drawing2->setHeight(59);
        $drawing2->setWidth(685);

        return [$drawing, $drawing2];
    }
}
