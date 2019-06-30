<?php

namespace App\Traits;

trait VesselAttribute{
	public function getActionsAttribute(){
		return '<a class="btn btn-warning" data-toggle="tooltip" title="View Vessel Details" data-id="' . $this->id . '">' .
			        '<span class="fa fa-search" data-id="' . $this->id . '"></span>';
	}
}