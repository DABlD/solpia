<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;

use App\Models\{Rank, Vessel, Wage};

class MLCContract implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $type, $req){
        $this->applicant    = $applicant;
        $this->type         = $type;
        $this->req          = $req;
    }

    public function view(): View
    {
        $this->applicant->load('pro_app');
        $this->applicant->load('document_id');
        $this->applicant->vessel = Vessel::find($this->applicant->pro_app->vessel_id);

        $this->applicant->position = Rank::find($this->applicant->pro_app->rank_id)->name;
        $this->applicant->wage = Wage::where('rank_id', $this->applicant->pro_app->rank_id)
                                    ->where('vessel_id', $this->applicant->pro_app->vessel_id)
                                    ->first();

        foreach($this->applicant->document_id as $docu){
            $this->applicant->{$docu->type} = $docu->number;
        }

        $this->applicant->date_processed    = $this->req['date_processed'];
        $this->applicant->effective_date    = $this->req['effective_date'];
        $this->applicant->valid_till        = $this->req['valid_till'];
        $this->applicant->med_date          = $this->req['med_date'];
        $this->applicant->employment_months = $this->req['employment_months'];

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
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ]
            ],
            [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
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

                $event->sheet->getDelegate()->getStyle('A1:O60')->getFont()->setName('ARIAL');
                $event->sheet->getDelegate()->getStyle('A1:O60')->getFont()->setSize(9);
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A9')->getFont()->setSize(10);

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
                    'A3:O4',
                    'A11', 'F11', 'A13', 'A15', 'A17', 'A19', 'F15', 'F17', 'F19',
                    'A29', 'A31',
                    'A35:I35', 'A37:E37', 'E39',
                    'A49:F49'
                ];

                // HL
                $h[4] = [
                    'J29'
                ];

                // HC VC
                $h[5] = [
                    'A1'
                ];

                // B
                $h[6] = [
                    'A1', 'A9',
                    'A11', 'F11', 'A13', 'A15', 'A17', 'A19', 'F15', 'F17', 'F19',
                    'A21', 'A27', 'A33', 'A46'
                ];

                // VC
                $h[7] = [
                    
                ];

                // B I
                $h[8] = [
                    'C3', 'H3:H4', 'M3',
                    'A11', 'F11', 'A13', 'A15', 'A17', 'A19', 'F15', 'F17', 'F19',
                    'C23', 'C25', 'A29', 'A31', 'J29', 'J31',
                    'A35:I35', 'A37:M37', 'A39:O39',
                    'A49:F49'
                ];

                $h['wrap'] = [
                    
                ];

                // SHRINK TO FIT
                $h['stf'] = [
                    'A19'
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
                    'A6:O7', 'A10:E11', 'F10:O11', 'A12:O13', 'A14:E15', 'F14:O15', 'A16:E17', 'F16:O17', 'A18:E19', 'F18:O19',
                    'A22:O23', 'A24:O25', 
                    'A28:H29', 'I28:O29', 'A30:E31', 'F30:O31',
                    'A34:D35', 'E34:H35', 'I34:O35',
                    'A36:D37', 'E36:H37', 'I36:O37',
                    'A38:D39', 'E38:H39', 'I38:O39',
                    'A40:O40', 'A41:O42', 'A43:O43', 'A44:O44',
                    'A47:E49', 'F47:O49'
                ]);

                $cells[2] = array_merge([
                    
                ]);

                $cells[3] = array_merge([
                    'C3', 'H3:K3', 'M3:O3', 'H4:K4',
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                $fonts = [
                    'A3', 'D3', 'L3', 'G3', 'A6:A7', 'A10:F10', 'A12', 'A14:F14', 'A16:F16', 'A18:F18',
                    'A22', 'A24',
                    'A28', 'I28', 'A30', 'F30',
                    'A34:I34', 'A36:I36', 'A38:O38',
                    'A40:O44', 'A47:F47'
                ];

                foreach($fonts as $font){
                    $event->sheet->getDelegate()->getStyle($font)->getFont()->setSize(7);
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(3);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(2.5);

                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(6.5);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(6.5);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(6.5);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(6.5);

                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(4.5);

                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(6.5);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(6.5);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(10.7);

                // ROW RESIZE
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(27);
                $event->sheet->getDelegate()->getRowDimension(5)->setRowHeight(4);
                $event->sheet->getDelegate()->getRowDimension(8)->setRowHeight(4);
                $event->sheet->getDelegate()->getRowDimension(20)->setRowHeight(4);
                $event->sheet->getDelegate()->getRowDimension(26)->setRowHeight(4);
                $event->sheet->getDelegate()->getRowDimension(32)->setRowHeight(4);
                $event->sheet->getDelegate()->getRowDimension(32)->setRowHeight(4);
                $event->sheet->getDelegate()->getRowDimension(32)->setRowHeight(4);
                $event->sheet->getDelegate()->getRowDimension(45)->setRowHeight(4);
                $event->sheet->getDelegate()->getRowDimension(48)->setRowHeight(30);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath(public_path('images/MLC_SEAL.png'));
        $drawing->setCoordinates('F49');
        $drawing->setHeight(154);
        $drawing->setWidth(154);
        $drawing->setOffsetX(-55);
        $drawing->setOffsetY(-20);

        return $drawing;
    }
}
