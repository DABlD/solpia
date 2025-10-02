<?php

namespace App\Traits;

trait AppointmentAttribute{
	public function getActionsAttribute(){ 
		$string = "";

		$string .= "<a class='btn btn-warning btn-sm' data-toggle='tooltip' title='View' onclick='view($this->id)'>" .
	        '<span class="fa fa-search fa-2xs"></span>' .
	    '</a>' . "&nbsp;";

	    if($this->status == "Waiting"){
			$string .= "<a class='btn btn-success btn-sm' data-toggle='tooltip' title='Attend' onclick='attend($this->id)'>" .
		        '<span class="fa fa-check fa-2xs"></span>' .
		    '</a>' . "&nbsp;";
	    }

	    if($this->status == "Waiting"){
			$string .= "<a class='btn btn-danger btn-sm' data-toggle='tooltip' title='Reject' onclick='reject($this->id)'>" .
		        '<span class="fa fa-times fa-2xs"></span>' .
		    '</a>';
	    }

	    return $string;
	}
}