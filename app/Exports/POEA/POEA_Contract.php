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

        array_push($sheets, new $class($this->data, $format, $this->req, $this->title));
        array_push($sheets, new InfoSheet($this->data, $format, $this->req));

        return $sheets;
    }
}