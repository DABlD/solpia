<?php

namespace App\Traits;

trait ApplicantAttribute{
	public function getActionsAttribute(){
		// return '<a class="btn btn-success" data-toggle="tooltip" title="View Applicant" data-id="' . $this->id . '">' .
		// 	        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
		// 	   '</a>&nbsp;' . 
		$string = '<a class="btn btn-warning" data-toggle="tooltip" title="Export" data-status="' . $this->status . '" data-id="' . $this->id . '">' .
			        '<span class="fa fa-file-text" data-id="' . $this->id . '" data-status="' . $this->status . '"></span>' .
			   '</a>&nbsp;' .
			   '<a class="btn btn-primary" data-toggle="tooltip" title="Edit Application" data-id="' . $this->id . '">' .
			        '<span class="fa fa-pencil" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;<br>
				
				<a class="btn btn-success" data-toggle="tooltip" title="View Files" data-id="' . $this->id . '">' .
				     '<span class="fa fa-file" data-id="' . $this->id . '"></span>' .
				'</a>
			   ';

		if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager'])){
			$string .= '<a class="btn btn-info" data-toggle="tooltip" title="Line-Up" data-status="' . $this->status . '" data-id="' . $this->id . '">' . '<span data-status="' . $this->status . '" class="fa fa-arrow-up" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';
		}

		if(auth()->user()->status == 2){
			$string .= '<a class="btn btn-info" data-toggle="tooltip" title="Go to Toei" data-id="' . $this->id . '">' . '<span class="fa fa-arrow-right" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';
		}

		return $string;
	}
}