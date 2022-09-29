<?php

namespace App\Traits;

use App\Models\Principal;

trait ApplicantAttribute{
	public function getActionsAttribute(){
		// return '<a class="btn btn-success" data-toggle="tooltip" title="View Applicant" data-id="' . $this->id . '">' .
		// 	        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
		// 	   '</a>&nbsp;' . 
		$string = '<a class="btn btn-warning" data-toggle="tooltip" title="Export" data-status2="' . $this->pa_s . '" data-id="' . $this->id . '">' .
			        '<span class="fa fa-file-text" data-id="' . $this->id . '" data-status2="' . $this->pa_s . '"></span>' .
			   '</a>&nbsp;' .
			   '<a class="btn btn-primary" data-toggle="tooltip" title="Edit Application" data-id="' . $this->id . '">' .
			        '<span class="fa fa-pencil" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;';
			 //   <a class="btn btn-success" data-toggle="tooltip" title="View Files" data-id="' . $this->id . '">' .
				//      '<span class="fa fa-file" data-id="' . $this->id . '"></span>' .
				// '</a>
			   
		//SALUTIN, MARCELLANA, FADRIQUELA, GARCIA, REYES
		$cadets = [33, 34, 461, 462, 506];

		if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager', 'Crewing Officer'])){
			// LINE UP
			if($this->pa_s != "Lined-Up" && $this->pa_s != "On Board"){
				$string .= '<a class="btn btn-info" data-toggle="tooltip" title="Line-Up" data-id="' . $this->id . '">' . '<span class="fa fa-arrow-up" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';
			}
			if(in_array(auth()->user()->role, ['Admin', 'Encoder'])){
				$string .= '<a class="btn btn-danger" data-toggle="tooltip" title="Delete Applicant" data-id="' . $this->id . '">' . '<span class="fa fa-trash" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';
			}
			if($this->pa_s == "Lined-Up"){
				$string .= '<a class="btn btn-danger rlu" data-toggle="tooltip" title="Remove Lineup" onClick="rlu(' . $this->id . ', ' . $this->pa_vid . ')">
                        <span class="fa fa-times"></span>
                    </a>&nbsp;';
			}
		}
			   																//	TOEI CADETS
		if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager', 'Encoder', 'Cadet', 'Crewing Officer']) || in_array(auth()->user()->id, $cadets)){
		// if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager']) || auth()->user()->id = 33){
			// DELETE
			// SEARCH
		}

		$string .= '<a class="btn btn-success btn-search" data-toggle="tooltip" title="View Info" data-id="' . $this->id . '">' . '<span class="fa fa-search" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';

		if(in_array(auth()->user()->role, ['Admin', 'Encoder', 'Cadet', 'Crewing Manager'])){
			$string .= '<a class="btn btn-secondary" data-toggle="tooltip" title="Assign to Fleet" onClick="atf(' . $this->id . ')">
                    <span class="fa fa-tasks"></span>
                </a>&nbsp;';
		}

		if(in_array(auth()->user()->role, ['Admin', 'Encoder', 'Cadet']) || auth()->user()->fleet == "FLEET B"){
			$string .= '<a class="btn btn-secondary" data-toggle="tooltip" title="Seniority Level" onClick="as(' . $this->id . ')">
                    <span class="fa fa-address-card"></span>
                </a>&nbsp;';
		}

		// STATUS SHOULD BE EQUAL TO PRINCIPAL ID SO I USED THIS
		$status = auth()->user()->status;

		// if($status > 1){
		// 	$string .= '<a class="btn btn-info" data-toggle="tooltip" title="Go to Principal" data-id="' . $this->id  . '" data-principal="' . $status . '">' . '<span class="fa fa-arrow-right" data-id="' . $this->id  . '" data-principal="' . $status . '"></span>' . '</a>&nbsp;';
		// }

		return $string;
	}
}
