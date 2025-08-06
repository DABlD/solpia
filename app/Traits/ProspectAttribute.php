<?php

namespace App\Traits;

trait ProspectAttribute{
	public function getActionsAttribute(){

		$actions = "<a class='btn btn-primary btn-sm' data-toggle='tooltip' title='Edit' onclick='view($this->id)'>" .
	        '<span class="fa fa-pencil fa-2xs"></span>' .
	    '</a>' . "&nbsp;" .
		"<a class='btn btn-warning btn-sm' data-toggle='tooltip' title='Application Form' onclick='file($this->id, this)' data-file=$this->file>" .
	        '<span class="fa fa-file fa-2xs"></span>' .
	    '</a>' . "&nbsp;";

	    $actions .=
		"<a class='btn btn-danger btn-sm' data-toggle='tooltip' title='Delete' onclick='del($this->id)'>" .
	        '<span class="fa fa-trash fa-2xs"></span>' .
	    '</a>'
	    ;

	    return $actions;
	}

	public function getActions2Attribute(){
		return $this->id;
	}
}