<?php

namespace App\Traits;

trait VesselAttribute{
	public function getActionsAttribute(){
		return 

		'<a class="btn btn-warning" data-toggle="tooltip" title="View Vessel Details" data-id="' . $this->id . '">' .
	        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
	    '</a>&nbsp;' . 
		'<a class="btn btn-info" data-toggle="tooltip" title="View Line-Up" data-status="' . $this->status . '" data-id="' . $this->id . '">' . '
			<span data-status="' . $this->status . '" class="fa fa-arrow-up" data-id="' . $this->id . '"></span>' . 
		'</a>';
	}
}