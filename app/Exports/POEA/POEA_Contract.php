<?php

namespace App\Exports\POEA;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class POEA_Contract implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($data, $type, $req, $title = "POEA FORMAT"){
        $this->data = $data;
        $this->type = $type;
        $this->req = $req;
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $format = str_replace(' ', '', $this->req['format']);
        $class = "App\Exports\POEA\\" . $format;
        $sheets = [];

        if($format == "x27_NITTATOEIFormatContract"){
            $title = "NITTA/TOEI Format";
        }
        elseif($format == "x23_TOEIFormatContract"){
            $title = "TOEI Format";
        }
        elseif($format == "x24_CADETFormatContract"){
            $title = "CADET Format";
        }
        elseif($format == "x22_POEAFormatContract"){
            $title = "POEA Format";
        }

        array_push($sheets, new $class($this->data, $format, $this->req, $title));
        array_push($sheets, new InfoSheet($this->data, $format, $this->req));
        array_push($sheets, new RPS($this->data, $format, $this->req));
        array_push($sheets, new COE($this->data, $format, $this->req));

        return $sheets;
    }
}