<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\{LineUpContract, Applicant, Vessel};

class X15_Ext_Form_Batch implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($id, $type, $data){
        $this->cid = LineUpContract::where('vessel_id', $data['data']['vid'])->where('status', 'On Board')->pluck('applicant_id');
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $crews = Applicant::whereIn('id', $this->cid)->get();
        // $crews = Applicant::whereIn('id', [857])->get();
        $vessel = Vessel::find($this->data['data']['vid']);

        foreach($crews as $crew){
            $temp = $this->data;
            $temp['data']['type2'] = $crew->current_lineup->rank->abbr;
            $crew->data = $temp['data'];
            $crew->vessel = $vessel;

            array_push($sheets, new X15_Ext_Form($crew, $this->type));
        }

        return $sheets;
    }
}
