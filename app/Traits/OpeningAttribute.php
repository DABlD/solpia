<?php

namespace App\Traits;

trait OpeningAttribute{
	public function getActionsAttribute(){
		return 

		'<a class="btn btn-danger" data-toggle="tooltip" title="Delete" data-id="' . $this->id . '">' .
	        '<span class="fa fa-trash" data-id="' . $this->id . '"></span>' .
	    '</a>';
	}
}