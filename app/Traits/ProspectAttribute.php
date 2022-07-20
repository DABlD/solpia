<?php

namespace App\Traits;

trait ProspectAttribute{
	public function getActionsAttribute(){
		return 

		"<a class='btn btn-primary btn-sm' data-toggle='tooltip' title='Edit' onclick='view($this->id)'>" .
	        '<span class="fa fa-pencil fa-2xs"></span>' .
	    '</a>' . "&nbsp;" .
		"<a class='btn btn-danger btn-sm' data-toggle='tooltip' title='Delete' onclick='del($this->id)'>" .
	        '<span class="fa fa-trash fa-2xs"></span>' .
	    '</a>'
	    ;
	}
}