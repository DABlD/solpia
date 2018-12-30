<?php

namespace App\Traits;

trait UserAttribute{

	public function getFullNameAttribute(){
		return ucfirst($this->fname) . ' ' . ucfirst($this->lname);
	}

	public function getActionsAttribute(){
		return '<a class="btn btn-success" data-toggle="tooltip" title="View User" data-id="' . $this->id . '">' .
			        '<span class="fa fa-search fa-xs" data-id="' . $this->id . '"></span>' .
			   '</a>';
	}
}