<?php

namespace App\Traits;

trait UserAttribute{

	public function getFullNameAttribute(){
		return ucfirst($this->fname) . ' ' . ucfirst($this->lname);
	}

	public function getActionsAttribute(){
		return '<a class="btn btn-success" data-toggle="tooltip" title="View User">' .
			        '<span class="fa fa-search"></span>' .
			   '</a>';
	}
}