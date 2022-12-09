<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Rank;

class DocumentChecklist implements FromView, WithEvents, WithDrawings//, ShouldAutoSize
{
    public function __construct($applicant, $type, $req){
        $applicant->load('document_flag');
        $applicant->load('document_id');
        $applicant->load('document_lc');
        $applicant->load('document_med_cert');
        $applicant->load('document_med');

        foreach(['document_id', 'document_flag', 'document_lc', 'document_med', 'document_med_cert' ] as $docuType){
            foreach($applicant->$docuType as $key => $doc){
                $name = $doc->type;
                if(!isset($applicant->$docuType->$name)){
                    $applicant->$docuType->$name = $doc;
                }
                else{
                    $size = 0;
                    if(is_array($applicant->$docuType->$name)){
                        $size = sizeof($applicant->$docuType->$name);
                    }
                    $name .= $size;
                    $applicant->$docuType->$name = $doc;
                }
                $applicant->$docuType->forget($key);
            }
        }

        if(!isset($applicant->rank)){
            $applicant->rank = Rank::find($applicant->data['rank'])->abbr;
        }

        $this->data     = $applicant;
        $this->type     = $applicant->data['type'];
        $this->rows     = null;
        $this->view     = null;
        $this->initNulls($applicant->data['type'], $applicant->data['fleet']);
    }

    public function initNulls($type, $fleet){
        $rows = 0;
        $rank = $this->data->rank;

        if($fleet == "FLEET A"){
            $this->data->manager = "PRECIAN MARIE CERVANTES";
            $this->data->documentation = auth()->user()->fullname;
            $this->data->officer = "CARL PALMEJAR";

            if($type == "default"){
                if($rank == "MSTR" || $rank == "C/O"){
                    $this->rows    = 54;
                    $this->view    = "MSTR_CO";
                }
                elseif($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 54;
                    $this->view    = "2O_3O";
                }
            }
        }
        elseif($fleet == "FLEET B"){
            $this->data->manager = "ADULF KIT JUMAWAN";
            $this->data->officer = auth()->user()->fullname;

            if($type == "hmm_con_kor"){
                if($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 53;
                    $this->view    = "2O_3O";
                }
                elseif($rank == "BSN" || $rank == "AB"){
                    $this->rows    = 42;
                    $this->view    = "BSN_AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 40;
                    $this->view    = "OS";
                }
                elseif($rank == "OLR1"){
                    $this->rows    = 43;
                    $this->view    = "OLR1";
                }
                elseif($rank == "OLR"){
                    $this->rows    = 41;
                    $this->view    = "OLR";
                }
                elseif($rank == "CCK" || $rank == "2CK"){
                    $this->rows    = 39;
                    $this->view    = "CCK_2CK";
                }
                elseif($rank == "A/E"){
                    $this->rows    = 44;
                    $this->view    = "AE";
                }
                elseif($rank == "ECDT"){
                    $this->rows    = 38;
                    $this->view    = "ECDT";
                }
            }
            elseif($type == "hmm_con_mal"){
                if($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 52;
                    $this->view    = "2O_3O";
                }
                elseif($rank == "BSN" || $rank == "AB"){
                    $this->rows    = 43;
                    $this->view    = "BSN_AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 41;
                    $this->view    = "OS";
                }
                elseif($rank == "OLR1"){
                    $this->rows    = 44;
                    $this->view    = "OLR1";
                }
                elseif($rank == "OLR"){
                    $this->rows    = 44;
                    $this->view    = "OLR";
                }
                elseif($rank == "CCK" || $rank == "2CK"){
                    $this->rows    = 39;
                    $this->view    = "CCK_2CK";
                }
            }
            elseif($type == "hmm_con_mar"){
                if($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 62;
                    $this->view    = "2O_3O";
                }
                elseif($rank == "A/O"){
                    $this->rows    = 54;
                    $this->view    = "AO";
                }
                elseif($rank == "BSN" || $rank == "AB"){
                    $this->rows    = 48;
                    $this->view    = "BSN_AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 45;
                    $this->view    = "OS";
                }
                elseif($rank == "DCDT"){
                    $this->rows    = 44;
                    $this->view    = "DCDT";
                }
                elseif($rank == "1AE"){
                    $this->rows    = 56;
                    $this->view    = "1AE";
                }
                elseif($rank == "2AE" || $rank == "3AE"){
                    $this->rows    = 56;
                    $this->view    = "2AE_3AE";
                }
                elseif($rank == "A/E"){
                    $this->rows    = 48;
                    $this->view    = "AE";
                }
                elseif($rank == "OLR1"){
                    $this->rows    = 48;
                    $this->view    = "OLR1";
                }
                elseif($rank == "OLR"){
                    $this->rows    = 47;
                    $this->view    = "OLR";
                }
                elseif($rank == "ECDT"){
                    $this->rows    = 44;
                    $this->view    = "ECDT";
                }
                elseif($rank == "CCK" || $rank == "2CK"){
                    $this->rows    = 43;
                    $this->view    = "CCK_2CK";
                }
            }
            elseif($type == "hmm_con_pan"){
                if($rank == "BSN" || $rank == "AB"){
                    $this->rows    = 45;
                    $this->view    = "BSN_AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 43;
                    $this->view    = "OS";
                }
                elseif($rank == "OLR1"){
                    $this->rows    = 46;
                    $this->view    = "OLR1";
                }
                elseif($rank == "OLR"){
                    $this->rows    = 45;
                    $this->view    = "OLR";
                }
                elseif($rank == "CCK" || $rank == "2CK"){
                    $this->rows    = 43;
                    $this->view    = "CCK_2CK";
                }
            }
            elseif($type == "kos_bul_mar"){
                if($rank == "C/O"){
                    $this->rows    = 64;
                    $this->view    = "CO";
                }
                elseif($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 63;
                    $this->view    = "2O_3O";
                }
                elseif($rank == "BSN" || $rank == "AB"){
                    $this->rows    = 48;
                    $this->view    = "BSN_AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 45;
                    $this->view    = "OS";
                }
                elseif($rank == "1AE" || $rank == "2AE" || $rank == "3AE"){
                    $this->rows    = 56;
                    $this->view    = "2AE_3AE";
                }
                elseif($rank == "OLR1"){
                    $this->rows    = 48;
                    $this->view    = "OLR1";
                }
                elseif($rank == "OLR"){
                    $this->rows    = 46;
                    $this->view    = "OLR";
                }
                elseif($rank == "WPR"){
                    $this->rows    = 44;
                    $this->view    = "WPR";
                }
                elseif($rank == "ECDT"){
                    $this->rows    = 43;
                    $this->view    = "ECDT";
                }
                elseif($rank == "CCK"){
                    $this->rows    = 44;
                    $this->view    = "CCK";
                }
                elseif($rank == "MSM" || $rank == "UTY"){
                    $this->rows    = 43;
                    $this->view    = "MSM_UTY";
                }
            }
            elseif($type == "kos_bul_lib"){
                if($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 63;
                    $this->view    = "2O_3O";
                }
                elseif($rank == "BSN" || $rank == "AB"){
                    $this->rows    = 48;
                    $this->view    = "BSN_AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 45;
                    $this->view    = "OS";
                }
                elseif($rank == "DCDT" || $rank == "DBOY"){
                    $this->rows    = 44;
                    $this->view    = "DCDT";
                }
                elseif($rank == "1AE" || $rank == "2AE" || $rank == "3AE"){
                    $this->rows    = 56;
                    $this->view    = "2AE_3AE";
                }
                elseif($rank == "OLR1"){
                    $this->rows    = 46;
                    $this->view    = "OLR1";
                }
                elseif($rank == "OLR"){
                    $this->rows    = 46;
                    $this->view    = "OLR";
                }
                elseif($rank == "WPR"){
                    $this->rows    = 43;
                    $this->view    = "WPR";
                }
                elseif($rank == "ECDT" || $rank == "EBOY"){
                    $this->rows    = 43;
                    $this->view    = "ECDT";
                }
                elseif($rank == "CCK"){
                    $this->rows    = 43;
                    $this->view    = "CCK";
                }
                elseif($rank == "MSM" || $rank == "UTY"){
                    $this->rows    = 43;
                    $this->view    = "MSM_UTY";
                }
            }
            elseif($type == "kos_cb_lib"){
                if($rank == "C/O"){
                    $this->rows    = 57;
                    $this->view    = "CO";
                }
                elseif($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 58;
                    $this->view    = "2O_3O";
                }
                elseif($rank == "BSN" || $rank == "AB"){
                    $this->rows    = 46;
                    $this->view    = "BSN_AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 44;
                    $this->view    = "OS";
                }
                elseif($rank == "DCDT" || $rank == "DBOY"){
                    $this->rows    = 42;
                    $this->view    = "DCDT";
                }
                elseif($rank == "1AE"){
                    $this->rows    = 53;
                    $this->view    = "1AE";
                }
                elseif($rank == "2AE" || $rank == "3AE"){
                    $this->rows    = 51;
                    $this->view    = "2AE_3AE";
                }
                elseif($rank == "OLR1"){
                    $this->rows    = 46;
                    $this->view    = "OLR1_OLR";
                }
                elseif($rank == "OLR"){
                    $this->rows    = 45;
                    $this->view    = "OLR";
                }
                elseif($rank == "WPR"){
                    $this->rows    = 43;
                    $this->view    = "WPR";
                }
                elseif($rank == "ECDT"){
                    $this->rows    = 42;
                    $this->view    = "ECDT";
                }
                elseif($rank == "CCK"){
                    $this->rows    = 43;
                    $this->view    = "CCK";
                }
                elseif($rank == "MSM" || $rank == "UTY"){
                    $this->rows    = 42;
                    $this->view    = "MSM_UTY";
                }
            }
            elseif($type == "possm"){
                $this->data->manager = "DENNIS QUIÑO";
                $this->data->officer = "CZARINA KRIZZLE";

                if($rank == "MSTR" || $rank == "C/O"){
                    $this->rows    = 55;
                    $this->view    = "MSTR_CO";
                }
                elseif($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 54;
                    $this->view    = "2O_3O";
                }
                elseif($rank == "C/E" || $rank == "1AE"){
                    $this->rows    = 52;
                    $this->view    = "CE_1AE";
                }
                elseif($rank == "2AE" || $rank == "3AE"){
                    $this->rows    = 48;
                    $this->view    = "2AE_3AE";
                }
                elseif($rank == "BSN" || $rank == "AB"){
                    $this->rows    = 43;
                    $this->view    = "BSN_AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 40;
                    $this->view    = "OS";
                }
                elseif($rank == "DCDT"){
                    $this->rows    = 39;
                    $this->view    = "DCDT";
                }
                elseif($rank == "OLR1" || $rank == "OLR"){
                    $this->rows    = 42;
                    $this->view    = "OLR1_OLR";
                }
                elseif($rank == "WPR"){
                    $this->rows    = 40;
                    $this->view    = "WPR";
                }
                elseif($rank == "ECDT"){
                    $this->rows    = 39;
                    $this->view    = "ECDT";
                }
                elseif($rank == "CCK" || $rank == "2CK"){
                    $this->rows    = 39;
                    $this->view    = "CCK_2CK";
                }
                elseif($rank == "MSM" || $rank == "MBY"){
                    $this->rows    = 38;
                    $this->view    = "MSM_MBY";
                }
            }
        }
        elseif($fleet == "FLEET C"){
            
        }
        elseif($fleet == "FLEET D"){
            $this->data->manager = "THEA GUERRA";
            $this->data->officer = "JANICE AGUACITO";

            if($type == "nsm_default"){
                if($rank == "MSTR"){
                    $this->rows    = 57;
                    $this->view    = "MSTR";
                }
                elseif($rank == "C/O"){
                    $this->rows    = 58;
                    $this->view    = "CO";
                }
                elseif($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 55;
                    $this->view    = "2O_3O";
                }
                elseif($rank == "AB"){
                    $this->rows    = 46;
                    $this->view    = "AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 45;
                    $this->view    = "OS";
                }
                elseif($rank == "C/E"){
                    $this->rows    = 52;
                    $this->view    = "CE";
                }
                elseif($rank == "2AE"){
                    $this->rows    = 53;
                    $this->view    = "2AE";
                }
                elseif($rank == "ETO"){
                    $this->rows    = 48;
                    $this->view    = "ETO";
                }
                elseif($rank == "ETR"){
                    $this->rows    = 46;
                    $this->view    = "ETR";
                }
                elseif($rank == "OLR"){
                    $this->rows    = 47;
                    $this->view    = "OLR";
                }
                elseif($rank == "WPR"){
                    $this->rows    = 38;
                    $this->view    = "WPR";
                }
                elseif($rank == "CCK"){
                    $this->rows    = 46;
                    $this->view    = "CCK";
                }
                elseif($rank == "MBY"){
                    $this->rows    = 45;
                    $this->view    = "MBY";
                }
            }
            elseif($type == "dlsm_sola_gratia"){
                if($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 50;
                    $this->view    = "2O_3O";
                }
            }
            elseif($type == "dlsm_kc_hadong_lib"){
                if($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 56;
                    $this->view    = "2O_3O";
                }
                elseif($rank == "AB"){
                    $this->rows    = 45;
                    $this->view    = "AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 42;
                    $this->view    = "OS";
                }
                elseif($rank == "2AE" || $rank == "3AE"){
                    $this->rows    = 51;
                    $this->view    = "2AE_3AE";
                }
                elseif($rank == "OLR1"){
                    $this->rows    = 43;
                    $this->view    = "OLR1";
                }
                elseif($rank == "OLR"){
                    $this->rows    = 43;
                    $this->view    = "OLR";
                }
                elseif($rank == "WPR"){
                    $this->rows    = 43;
                    $this->view    = "WPR";
                }
                elseif($rank == "CCK"){
                    $this->rows    = 42;
                    $this->view    = "CCK";
                }
                elseif($rank == "UTY"){
                    $this->rows    = 41;
                    $this->view    = "UTY";
                }
            }
            elseif($type == "dlsm_kc_hadong_mar"){
                if($rank == "BSN"){
                    $this->rows    = 45;
                    $this->view    = "BSN";
                }
                elseif($rank == "OS"){
                    $this->rows    = 41;
                    $this->view    = "OS";
                }
                elseif($rank == "DCDT"){
                    $this->rows    = 41;
                    $this->view    = "DCDT";
                }
                elseif($rank == "OLR1"){
                    $this->rows    = 44;
                    $this->view    = "OLR1";
                }
                elseif($rank == "WPR"){
                    $this->rows    = 43;
                    $this->view    = "WPR";
                }
                elseif($rank == "ECDT"){
                    $this->rows    = 40;
                    $this->view    = "ECDT";
                }
                elseif($rank == "UTY"){
                    $this->rows    = 42;
                    $this->view    = "UTY";
                }
            }
            elseif($type == "hanj_dk_initio"){
            }
            elseif($type == "hanj_dk_ione"){
            }
            elseif($type == "scm_gns_harmony"){
            }
            elseif($type == "scm_gns_harvest"){
            }
            elseif($type == "scm_gns_hope"){
            }
        }
        elseif($fleet == "FLEET E"){
            if($type == "default"){
                $this->data->manager = "DENNIS QUIÑO";
                $this->data->officer = "CZARINA KRIZZLE";

                if($rank == "MSTR" || $rank == "C/O"){
                    $this->rows    = 55;
                    $this->view    = "MSTR_CO";
                }
                elseif($rank == "2/O" || $rank == "3/O"){
                    $this->rows    = 54;
                    $this->view    = "2O_3O";
                }
                elseif($rank == "C/E" || $rank == "1AE"){
                    $this->rows    = 52;
                    $this->view    = "CE_1AE";
                }
                elseif($rank == "2AE" || $rank == "3AE"){
                    $this->rows    = 48;
                    $this->view    = "2AE_3AE";
                }
                elseif($rank == "BSN" || $rank == "AB"){
                    $this->rows    = 43;
                    $this->view    = "BSN_AB";
                }
                elseif($rank == "OS"){
                    $this->rows    = 40;
                    $this->view    = "OS";
                }
                elseif($rank == "DCDT"){
                    $this->rows    = 39;
                    $this->view    = "DCDT";
                }
                elseif($rank == "OLR1" || $rank == "OLR"){
                    $this->rows    = 42;
                    $this->view    = "OLR1_OLR";
                }
                elseif($rank == "WPR"){
                    $this->rows    = 40;
                    $this->view    = "WPR";
                }
                elseif($rank == "ECDT"){
                    $this->rows    = 39;
                    $this->view    = "ECDT";
                }
                elseif($rank == "CCK" || $rank == "2CK"){
                    $this->rows    = 39;
                    $this->view    = "CCK_2CK";
                }
                elseif($rank == "MSM" || $rank == "MBY"){
                    $this->rows    = 38;
                    $this->view    = "MSM_MBY";
                }
            }
        }
        elseif($fleet == "TOEI"){
            
        }
        elseif($fleet == "FISHING"){
            
        }
    }

    public function view(): View
    {
        $exportView = str_replace(' ', '_', $this->data->data['fleet'] . '.' . $this->type . '_' . $this->view);
        return view('exports.checklists.' . $exportView, [
            'data' => $this->data,
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
                        'color' => ['argb' => 'FFFFFF']
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
            ]
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($borderStyle, $fillStyle, $headingStyle) {
                // SHEET SETTINGS
                $size = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
                $event->sheet->getDelegate()->getPageSetup()->setPaperSize($size);
                $event->sheet->getDelegate()->getHeaderFooter()->setOddFooter('&L&IDOC NO: SMOP-CDFC-11 &C&IEFFECTIVE DATE: 01 SEPT 17 &R&IREVISION NO: 0.0');

                $event->sheet->getDelegate()->setTitle($this->view, false);
                $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                $event->sheet->getDelegate()->getPageSetup()->setScale(80);
                $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                $event->sheet->getDelegate()->getPageSetup()->setVerticalCentered(true);
                $event->sheet->getDelegate()->getPageMargins()->setTop(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setLeft(0.3);
                $event->sheet->getDelegate()->getPageMargins()->setBottom(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setRight(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setHeader(0.1);
                $event->sheet->getDelegate()->getPageMargins()->setFooter(0.1);

                // DEFAULT FONT AND STYLE FOR WHOLE PAGE
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Calibri');
                $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(9);

                // CUSTOM FONT AND STYLE TO DEFINED CELL
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A4:H80')->getFont()->setSize(9);

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
                    'B' . ($this->rows + 6), 
                    'B' . ($this->rows + 8), 'F' . ($this->rows + 8),
                    'B' . ($this->rows + 10), 'F' . ($this->rows + 10),
                ];

                // HL B
                $h[2] = [
                    
                ];

                // HC
                $h[3] = [
                    'B' . ($this->rows + 5) . ':H' . ($this->rows + 10)
                ];

                // HC VC
                $h[4] = [
                    'A1:H' . ($this->rows + 1), 
                    'A' . ($this->rows + 5) . ':A' . ($this->rows + 10)
                ];

                // HL
                $h[5] = [
                    'A4:A' . $this->rows, 'E5:E6'
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
                    'A4:A' . $this->rows, 'E5:E6', 'F5:F6'
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
                ]);

                // ALL BORDER MEDIUM
                $cells[1] = array_merge([
                ]);

                // ALL BORDER THICK
                $cells[2] = array_merge([
                ]);

                // OUTSIDE BORDER THIN
                $cells[3] = array_merge([
                    'A7:H7', 
                    'A' . $this->rows . ':H' . ($this->rows + 4),

                    // SIGNATORIES
                    'B' . ($this->rows + 6) . ':D' . ($this->rows + 6),
                    'B' . ($this->rows + 8) . ':D' . ($this->rows + 8), 
                    'B' . ($this->rows + 10) . ':D' . ($this->rows + 10), 
                    'F' . ($this->rows + 8) . ':H' . ($this->rows + 8), 
                    'F' . ($this->rows + 10) . ':H' . ($this->rows + 10), 
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
                    'B' . ($this->rows + 6) . ':D' . ($this->rows + 6),
                    'B' . ($this->rows + 8) . ':D' . ($this->rows + 8), 
                    'B' . ($this->rows + 10) . ':D' . ($this->rows + 10), 
                    'F' . ($this->rows + 8) . ':H' . ($this->rows + 8), 
                    'F' . ($this->rows + 10) . ':H' . ($this->rows + 10), 
                ]);

                // LRB
                $cells[8] = array_merge([
                    'B' . ($this->rows + 6), 
                    'B' . ($this->rows + 8), 'F' . ($this->rows + 8),
                    'B' . ($this->rows + 10), 'F' . ($this->rows + 10),
                ]);

                // RRB
                $cells[9] = array_merge([
                    'D' . ($this->rows + 6), 
                    'D' . ($this->rows + 8), 'H' . ($this->rows + 8),
                    'D' . ($this->rows + 10), 'H' . ($this->rows + 10),
                ]);

                // TRB
                $cells[10] = array_merge([
                ]);

                foreach($cells as $key => $value){
                    foreach($value as $cell){
                        $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($borderStyle[$key]);
                    }
                }

                // FOR THE CHECK
                // $event->sheet->getDelegate()->getStyle('L46')->getFont()->setName('Marlett');

                // COLUMN RESIZE
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(24);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(19);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(26);

                // ROW RESIZE
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(50);
                
                // SET PRINT AREA
                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea("C1:Y42");
            },
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Letter Head');
        $drawing->setDescription('Letter Head');
        $drawing->setPath(public_path("images/letter_head.jpg"));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(50);
        $drawing->setWidth(710);
        $drawing->setOffsetX(4);
        $drawing->setOffsetY(4);
        $drawing->setCoordinates('A1');

        return [$drawing];
    }
}
