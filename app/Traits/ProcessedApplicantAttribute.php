<?php

namespace App\Traits;

trait ProcessedApplicantAttribute{
	public function getActionsAttribute(){
		// return '<a class="btn btn-success" data-toggle="tooltip" title="View Applicant" data-id="' . $this->id . '">' .
		// 	        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
		// 	   '</a>&nbsp;' . 
		return '<a class="btn btn-warning" data-toggle="tooltip" title="Export Application" data-id="' . $this->id . '">' .
			        '<span class="fa fa-download" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;' .
			   '<a class="btn btn-info" data-toggle="tooltip" title="Line-Up" data-id="' . $this->id . '">' .
			        '<span class="fa fa-arrow-up" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;';
	}
}