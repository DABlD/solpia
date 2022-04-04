<?php

namespace App\Traits;

trait WageAttribute{
	public function getActionsAttribute(){
		$id = $this->id;
		$vid = $this->vessel_id;

		return 
		"<a class='btn btn-danger' data-toggle='tooltip' title='Delete' onClick='deleteWage($id, $vid)'>" .
	        "<span class='fa fa-trash'></span>" .
	    "</a>&nbsp;" . 
	    "<a class='btn btn-warning' data-toggle='tooltip' title='Edit' onClick='editEntry($id)'>" . 
	        "<span class='fa fa-pencil'</span>" . 
	    "</a>";
	}
}