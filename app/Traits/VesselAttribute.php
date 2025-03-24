<?php

namespace App\Traits;

trait VesselAttribute{
	public function getActionsAttribute(){
		$string = 
			'<a class="btn btn-warning" data-toggle="tooltip" title="View Vessel Details" data-status="' . $this->status . '"  data-id="' . $this->id . '">' .
		        '<span class="fa fa-search" data-status="' . $this->status . '"  data-id="' . $this->id . '"></span>' .
		    '</a>&nbsp;' . 
			'<a class="btn btn-info" data-toggle="tooltip" title="View Crew List" data-status="' . $this->status . '" data-id="' . $this->id . '">' . '
				<span data-status="' . $this->status . '" class="fa fa-users" data-id="' . $this->id . '"></span>' . 
			'</a>&nbsp;';

		if(auth()->user()->role == "Admin"){
			$string .= '<a class="btn btn-primary" data-toggle="tooltip" title="Assign to a Fleet" data-id="' . $this->id . '">' . '
				<span class="fa fa-ship" data-id="' . $this->id . '"></span>' . 
			'</a>&nbsp;';
		}

		$string .= '<a class="btn btn-success" data-toggle="tooltip" title="Ships Particular" data-id="' . $this->id . '">' . '
			<span class="fa fa-list" data-id="' . $this->id . '"></span>' . 
		'</a>&nbsp;';

		if($this->status == "ACTIVE"){
			if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager'])){
				$string .= '<a class="btn btn-danger" data-toggle="tooltip" title="Remove" data-status="' . $this->status . '" data-id="' . $this->id . '">' . '
					<span data-status="' . $this->status . '" class="fa fa-times" data-id="' . $this->id . '"></span>' . 
				'</a>&nbsp;';
			}

			if(in_array(auth()->user()->role, ['Admin', 'Processing', 'Encoder', 'Cadet', 'Crewing Officer', 'Crewing Manager'])){
				$string .= '<a class="btn btn-default" data-toggle="tooltip" title="Wage Scale" data-id="' . $this->id . '" data-name="' . $this->name . '">' . '
					<span class="fa fa-dollar" data-id="' . $this->id . '" data-name="' . $this->name . '"></span>' . 
				'</a>';
			}
		}
		else{
			$string .= '<a class="btn btn-success" data-toggle="tooltip" title="Activate" data-status="' . $this->status . '" data-id="' . $this->id . '">' . '
				<span data-status="' . $this->status . '" class="fa fa-check" data-id="' . $this->id . '"></span>' . 
			'</a>';
		}

		return $string;
	}
}