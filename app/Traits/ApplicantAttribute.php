<?php

namespace App\Traits;

use App\Models\Principal;

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
			   '</a>
				
				
			   ';
			 //   <a class="btn btn-success" data-toggle="tooltip" title="View Files" data-id="' . $this->id . '">' .
				//      '<span class="fa fa-file" data-id="' . $this->id . '"></span>' .
				// '</a>
			   
		//SALUTIN, MARCELLANA, FADRIQUELA, GARCIA, REYES
		$cadets = [33, 34, 461, 462, 506];
			   																//	TOEI CADETS
		if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager', 'Encoder', 'Cadet', 'Crewing Officer']) || in_array(auth()->user()->id, $cadets)){
		// if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager']) || auth()->user()->id = 33){
			// LINE UP
			$string .= '<a class="btn btn-info" data-toggle="tooltip" title="Line-Up" data-status="' . $this->status . '" data-id="' . $this->id . '">' . '<span data-status="' . $this->status . '" class="fa fa-arrow-up" data-id="' . $this->id . '"></span>' . '</a>';
			// DELETE
			$string .= '<a class="btn btn-danger" data-toggle="tooltip" title="Delete Applicant" data-id="' . $this->id . '">' . '<span class="fa fa-times" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';
			// SEARCH
			$string .= '<a class="btn btn-success" data-toggle="tooltip" title="View Info" data-id="' . $this->id . '">' . '<span class="fa fa-search" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';
		}

		// STATUS SHOULD BE EQUAL TO PRINCIPAL ID SO I USED THIS
		$status = auth()->user()->status;

		// if($status > 1){
		// 	$string .= '<a class="btn btn-info" data-toggle="tooltip" title="Go to Principal" data-id="' . $this->id  . '" data-principal="' . $status . '">' . '<span class="fa fa-arrow-right" data-id="' . $this->id  . '" data-principal="' . $status . '"></span>' . '</a>&nbsp;';
		// }

		return $string;
	}
}
