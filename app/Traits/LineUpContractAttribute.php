<?php

namespace App\Traits;

trait LineUpContractAttribute{
	public function getDisembarkationDateAttribute(){
        $date = now()->parse($this->joining_date)
            ->addMonths($this->months);

        if (!empty($this->extensions)) {
            $date->addMonths(array_sum(json_decode($this->extensions)));
        }

        return $date->format('Y-m-d');
	}
}