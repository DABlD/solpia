<?php

namespace App\Traits;

trait RequirementAttribute{
	public function getActionsAttribute(){
		$buttons = "
			<a class='btn btn-info btn-sm' data-toggle='tooltip' title='Candidates' onclick='candidates($this->id)'>" .
			    '<span class="fa fa-black-tie fa-2xs"></span>' .
			'</a>' . '&nbsp';

		if(in_array(auth()->user()->role, ["Admin", "Crewing Officer", "Crewing Manager"])){
			$buttons .= "<a class='btn btn-primary btn-sm' data-toggle='tooltip' title='Edit' onclick='view($this->id)'>" .
		        '<span class="fa fa-pencil fa-2xs"></span>' .
		    '</a>'
		    ;
		}

		if($this->vessel_id){
			$buttons .= "<a class='btn btn-primary btn-sm shipicon' data-toggle='tooltip' title='View Vessel Details' onclick='vesselDetails($this->vessel_id)'>" .
		        '<span class="fa fa-ship fa-2xs"></span>' .
		    '</a>'
		    ;
		}

		return $buttons;
	}
}