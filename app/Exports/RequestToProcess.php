<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;

use App\Models\{Applicant, Rank, Vessel};

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

        $this->data->department = $this->req['department'];
        $this->data->port       = $this->req['port'];
        $this->data->departure  = $this->req['departure'];
        $this->data->docus      = $this->req['docus'];

        $tempCrews = $this->req['crews'];
        $vessel = "";

        foreach($tempCrews as $id){
            $crew = Applicant::find($id);

            $crew->load('user');
            $crew->load('pro_app');
            $crew->rank = Rank::find($crew->pro_app->rank_id)->abbr;
            $crew->vessel = $vessel == "" ? Vessel::find($crew->pro_app->vessel_id)->name : $vessel;

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
                $event->sheet->getDelegate()->setTitle('TITLE', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

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
                $crewzxc = [];
                $stfzxc = [];
                for($i = 17; $i < 37; $i++){
                    array_push($crewzxc, "A$i:P$i");
                    array_push($crewzxc, "Q$i:Y$i");
                    array_push($crewzxc, "Z$i:AL$i");
                    array_push($crewzxc, "AM$i:AN$i");
                    array_push($crewzxc, "AO$i");

                    array_push($stfzxc, "A$i:P$i");
                    array_push($stfzxc, "Z$i:AL$i");
                }

                // FONT SIZES
                $event->sheet->getDelegate()->getStyle('A1:AO50')->getFont()->setName('ARIAL');
                $event->sheet->getDelegate()->getStyle('A6')->getFont()->setSize(14);

                $event->sheet->getDelegate()->getStyle('E8')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('E10')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('T8')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('T10')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('AE8')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('AE10')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('AN11')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('AN13')->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('A13')->getFont()->setSize(10);

                $event->sheet->getDelegate()->getStyle('A16:AO16')->getFont()->setSize(9);
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
                $h[3] = array_merge($crewzxc, [
                    'A6', 'A16:AO16', 'AO11', 'L13', 'AO13'
                ]);

                // HL
                $h[4] = [
                    
                ];

                // HC VC
                $h[5] = [
                    
                ];

                // B
                $h[6] = [
                    'A6', 'A16:AO16', 'E8', 'E10', 'T8', 'T10', 'AE8', 'AE10', 'AN11', 'AN13', 'A13',
                    'A38:AO38'
                ];

                // VC
                $h[7] = [
                    'A6', 'A16:AO16'
                ];

                $h['wrap'] = [
                    
                ];

                // SHRINK TO FIT
                $h['stf'] = array_merge($stfzxc, [

                ]);

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
                    'A6:AO6'
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
                    'C8:D8', 'S8', 'AC8:AD8', 'C10:D10', 'S10', 'AC10:AD10', 'A15:AO15', 
                    'A16:P16', 'Q16:Y16', 'Z16:AL16', 'AM16:AN16', 'AO16', 'A17:AO36',
                    'A37:AO37', 'A38:K41', 'L38:V41', 'W38:AH41', 'AI38:AO41', 'A42:AO42',
                    'A6:AO13'
                ]);


                $cells[2] = array_merge([
                    'L10:R10', 'AO11', 'L13:AM13', 'AO13'
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                $event->sheet->getDelegate()->getStyle('C8')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('C10')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('S8')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('S10')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('AC8')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('AC10')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $colRes = [
                    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
                    'O', 'P', 'Q', 'R', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB',
                    'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL'
                ];

                foreach($colRes as $col){
                    $event->sheet->getDelegate()->getColumnDimension($col)->setWidth(1.7);
                }

                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(2.6);
                $event->sheet->getDelegate()->getColumnDimension('S')->setWidth(3.2);
                $event->sheet->getDelegate()->getColumnDimension('AM')->setWidth(10.9);
                $event->sheet->getDelegate()->getColumnDimension('AN')->setWidth(6);
                $event->sheet->getDelegate()->getColumnDimension('AO')->setWidth(16.1);

                // ROW RESIZE
                $event->sheet->getDelegate()->getRowDimension(4)->setRowHeight(7.5);
                $event->sheet->getDelegate()->getRowDimension(5)->setRowHeight(7.5);
                $event->sheet->getDelegate()->getRowDimension(6)->setRowHeight(18);
                $event->sheet->getDelegate()->getRowDimension(9)->setRowHeight(3);
                $event->sheet->getDelegate()->getRowDimension(12)->setRowHeight(7);
                $event->sheet->getDelegate()->getRowDimension(14)->setRowHeight(7);
                $event->sheet->getDelegate()->getRowDimension(15)->setRowHeight(3);
                $event->sheet->getDelegate()->getRowDimension(37)->setRowHeight(3);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path('images/letter_head.jpg'));
        $drawing->setCoordinates('A1');
        $drawing->setHeight(90);
        $drawing->setWidth(692);

        return $drawing;
    }
}
