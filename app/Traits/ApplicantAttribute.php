<?php

namespace App\Traits;

use App\Models\Principal;

trait ApplicantAttribute{
	public function getActionsAttribute(){
		// return '<a class="btn btn-success" data-toggle="tooltip" title="View Applicant" data-id="' . $this->id . '">' .
		// 	        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
		// 	   '</a>&nbsp;' . 
		$string = '<a class="btn btn-warning btn-xs" data-toggle="tooltip" title="Export" data-status2="' . $this->pas . '" data-id="' . $this->id . '">' .
			        '<span class="fa fa-file-text fa-sm" data-id="' . $this->id . '" data-status2="' . $this->pas . '"></span>' .
			   '</a>&nbsp;' .
			   '<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Application" data-id="' . $this->id . '">' .
			        '<span class="fa fa-pencil fa-sm" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;';
			 //   <a class="btn btn-success" data-toggle="tooltip" title="View Files" data-id="' . $this->id . '">' .
				//      '<span class="fa fa-file" data-id="' . $this->id . '"></span>' .
				// '</a>
			   
		//SALUTIN, MARCELLANA, FADRIQUELA, GARCIA, REYES
		$cadets = [33, 34, 461, 462, 506];

		if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager', 'Crewing Officer', 'Encoder'])){
			// LINE UP
			if($this->pas != "Lined-Up" && $this->pas != "On Board"){
				$string .= '<a class="btn btn-info btn-xs" data-toggle="tooltip" title="Line-Up" data-id="' . $this->id . '">' . '<span class="fa fa-arrow-up fa-sm" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';
			}
			if(in_array(auth()->user()->role, ['Admin', 'Encoder'])){
				$string .= '<a class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete Applicant" data-id="' . $this->id . '">' . '<span class="fa fa-trash fa-sm" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';
			}
			if($this->pas == "Lined-Up"){
				$string .= '<a class="btn btn-danger btn-xs rlu" data-toggle="tooltip" title="Remove Lineup" onClick="rlu(' . $this->id . ', ' . $this->pa_vid . ')">
                        <span class="fa fa-times fa-sm"></span>
                    </a>&nbsp;';
			}
		}
			   																//	TOEI CADETS
		if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager', 'Encoder', 'Cadet', 'Crewing Officer']) || in_array(auth()->user()->id, $cadets)){
		// if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager']) || auth()->user()->id = 33){
			// DELETE
			// SEARCH
		}

		$string .= '<a class="btn btn-success btn-search btn-xs" data-toggle="tooltip" title="View Info" data-id="' . $this->id . '">' . '<span class="fa fa-search fa-sm" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';

		if(in_array(auth()->user()->role, ['Admin', 'Crewing Manager'])){
			$string .= '<a class="btn btn-custom1 btn-xs" data-toggle="tooltip" title="Assign to Fleet" onClick="atf(' . $this->id . ')">
                    <span class="fa fa-tasks fa-sm"></span>
                </a>&nbsp;';
		}

		// if(in_array(auth()->user()->role, ['Admin']) || auth()->user()->fleet == "FLEET B"){
		if(auth()->user()->fleet == "FLEET B"){
			$string .= '<a class="btn btn-default btn-xs" data-toggle="tooltip" title="Seniority Level" onClick="as(' . $this->id . ')">
                    <span class="fa fa-address-card fa-sm"></span>
                </a>&nbsp;';
		}

		// STATUS SHOULD BE EQUAL TO PRINCIPAL ID SO I USED THIS
		$status = auth()->user()->pas;

		if(auth()->user()->role == "Recruitment Officer"){
			$string = '<a class="btn btn-success btn-search btn-xs" data-toggle="tooltip" title="View Info" data-id="' . $this->id . '">' . '<span class="fa fa-search fa-sm" data-id="' . $this->id . '"></span>' . '</a>&nbsp;';
			$string .= '<a class="btn btn-warning btn-xs" data-toggle="tooltip" title="Export Biodata" data-status2="' . $this->pas . '" data-id="' . $this->id . '" onClick="exportBiodata(this)">' .
					        '<span class="fa fa-file-text fa-sm" data-id="' . $this->id . '" data-status2="' . $this->pas . '" onClick="exportBiodata(this)"></span>' .
					   '</a>&nbsp;';
		}

		// if($status > 1){
		// 	$string .= '<a class="btn btn-info" data-toggle="tooltip" title="Go to Principal" data-id="' . $this->id  . '" data-principal="' . $status . '">' . '<span class="fa fa-arrow-right" data-id="' . $this->id  . '" data-principal="' . $status . '"></span>' . '</a>&nbsp;';
		// }

		return $string;
	}
}
