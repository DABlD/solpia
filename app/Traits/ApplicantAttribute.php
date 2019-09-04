<?php

namespace App\Traits;

trait ApplicantAttribute{
	public function getActionsAttribute(){
		// return '<a class="btn btn-success" data-toggle="tooltip" title="View Applicant" data-id="' . $this->id . '">' .
		// 	        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
		// 	   '</a>&nbsp;' . 
		$status = $this->status == "Lined-Up" ? $this->status : 'Line-Up';
		$string = '<a class="btn btn-warning" data-toggle="tooltip" title="Export Application" data-id="' . $this->id . '">' .
			        '<span class="fa fa-download" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;' .
			   '<a class="btn btn-primary" data-toggle="tooltip" title="Edit Application" data-id="' . $this->id . '">' .
			        '<span class="fa fa-pencil" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;';

		if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager'])){
			$string .= '<a class="btn btn-info" data-toggle="tooltip" title="' . $status . '" data-id="' . $this->id . '">' .
					        '<span class="fa fa-arrow-up" data-id="' . $this->id . '"></span>' .
					   '</a>&nbsp;';
		}

		return $string;
	}
}