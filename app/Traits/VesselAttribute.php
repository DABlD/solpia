<?php

namespace App\Traits;

trait VesselAttribute{
	public function getActionsAttribute(){
		$string = 
			'<a class="btn btn-warning" data-toggle="tooltip" title="View Vessel Details" data-id="' . $this->id . '">' .
		        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
		    '</a>&nbsp;' . 
			'<a class="btn btn-info" data-toggle="tooltip" title="View Crew List" data-status="' . $this->status . '" data-id="' . $this->id . '">' . '
				<span data-status="' . $this->status . '" class="fa fa-arrow-up" data-id="' . $this->id . '"></span>' . 
			'</a>&nbsp;';

		if($this->status == "ACTIVE"){
			$string .= '<a class="btn btn-danger" data-toggle="tooltip" title="Remove" data-status="' . $this->status . '" data-id="' . $this->id . '">' . '
				<span data-status="' . $this->status . '" class="fa fa-times" data-id="' . $this->id . '"></span>' . 
			'</a>';
		}
		else{
			$string .= '<a class="btn btn-success" data-toggle="tooltip" title="Activate" data-status="' . $this->status . '" data-id="' . $this->id . '">' . '
				<span data-status="' . $this->status . '" class="fa fa-check" data-id="' . $this->id . '"></span>' . 
			'</a>';
		}

		return $string;
	}
}