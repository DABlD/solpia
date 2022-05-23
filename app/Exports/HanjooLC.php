<?php

namespace App\Exports;

use App\Models\{Applicant};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class HanjooLC implements FromView, WithEvents//, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant,$type){
        $this->applicant = $applicant;
        $this->type = $type;
    }

    public function view(): View
    {
        return view('exports.' . $this->type, [
            'applicant' => $this->applicant
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
                    'rgb' => 'EEECE1'
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
                $event->sheet->getDelegate()->setTitle('INTERVIEW LIST', false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.5);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.5);

                // FONT SIZES

                $event->sheet->getDelegate()->getStyle('A4:N60')->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(24);
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->setSize(20);
                $event->sheet->getDelegate()->getStyle('C20')->getFont()->setSize(11);
                // $event->sheet->getDelegate()->getStyle('D48:D49')->getFont()->setSize(7);
                // $event->sheet->getDelegate()->getStyle('L48:L49')->getFont()->setSize(7);
                $event->sheet->getDelegate()->getStyle('D48:D49')->getFont()->getColor()->setRGB('2f5596');
                $event->sheet->getDelegate()->getStyle('L48:L49')->getFont()->getColor()->setRGB('2f5596');
                // $event->sheet->getDelegate()->getStyle('D48:D49')->getFont()->setItalic(true);
                // $event->sheet->getDelegate()->getStyle('L48:L49')->getFont()->setItalic(true);

                // SET PAGE BREAK PREVIEW
                $temp = new \PhpOffice\PhpSpreadsheet\Worksheet\SheetView;
                $event->sheet->getParent()->getActiveSheet()->setSheetView($temp->setView('pageBreakPreview'));

                // FAMILY DATA ROWS
                $rows = [

                ];

                // FUNCTIONS
                $cellBorders = function($start, $len){
                    $temp = array();
                    for($i = $start; $i < ($start + $len); $i++){
                        array_push($temp, "A$i:B$i");
                        array_push($temp, "C$i:E$i");
                        array_push($temp, "K$i:N$i");

                        if($i < 17 || $i > 27){
                            array_push($temp, "F$i:J$i");
                        }
                        else{
                            array_push($temp, "F$i");
                            array_push($temp, "G$i");
                            array_push($temp, "H$i");
                            array_push($temp, "I$i");
                            array_push($temp, "J$i");
                        }
                    }

                    return $temp;
                };

                $rows = array_merge($rows, $cellBorders(6, 6));
                $rows = array_merge($rows, $cellBorders(17, 4));
                $rows = array_merge($rows, $cellBorders(22, 6));
                $rows = array_merge($rows, $cellBorders(29, 3));
                $rows = array_merge($rows, $cellBorders(33, 1));
                $rows = array_merge($rows, $cellBorders(35, 2));
                
                // HEADINGS

                // HC B
                $h[0] = [
                    'A1:A2'
                ];

                // VT
                $h[1] = [
                    
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    "K46:M46"
                ];

                // HL
                $h[4] = [
                    'K9'
                ];

                // HC VC
                $h[5] = [
                    'A13:K15', 'A48', 'F48',
                    'F17:J20', 'F22:J27'
                ];

                // B
                $h[6] = [
                    'A3:A4',
                    'F17:J20', 'F22:J27'
                ];

                // VC
                $h[7] = [
                    'A12', 'A38', 'A42'
                ];

                $h['wrap'] = [
                    'F14:J15'
                ];

                // $event->sheet->getDelegate()->getStyle('A1:N60')->getAlignment()->setWrapText(true);
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

                // FILLS
                $fills = [
                    'A6:A11', 'F6:F11', 'A13:N16', 'A17:C28', 'A29:A37', 'F29:F31', 'F33',
                    'F35', 'F36', 'A41', 'A45:A46', 'F46:K46', 'M46', 'A47:C50', 'F48:K50'
                ];

                foreach($fills as $fill){
                    $event->sheet->getDelegate()->getStyle($fill)->applyFromArray($fillStyle);  
                }

                // BORDERS
                $cells = array_merge($rows, [
                      'A13:B15', 'C13:E15', 'F13:J13', 'K13:N15',
                      'F14', 'G14', 'H14', 'I14', 'J14',
                      'F15', 'G15', 'H15', 'I15', 'J15',
                      'A16:N16', 'A21:N21', 'A28:N28', 'A32:N32', 'A34:N34', 'A37:N37',
                      'A38:N40', 'A41:N41', 'A42:N44', 'A45:N45',
                      'A46:B46', 'C46:E46', 'F46:J46', 'K46', 'L46', 'M46', 'N46',
                      'A47:N47', 'A48:B50', 'F48:J50',
                      'C48', 'D48:E48', 'K48', 'L48:N48',
                      'C49', 'D49:E49', 'K49', 'L49:N49',
                      'C50', 'D50:E50', 'K50', 'L50:N50',
                ]);

                foreach($cells as $cell){
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle);
                }

                // FOR THE CHECK
                $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');
                $event->sheet->getDelegate()->getStyle('N46')->getFont()->setName('Marlett');

                // COLUMN RESIZE

                // $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(false);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(14);

                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(5);

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(35);
                $event->sheet->getDelegate()->getRowDimension('12')->setRowHeight(25);

                for($i = 17; $i < 36; $i++){
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(20);
                }
            },
        ];
    }
}