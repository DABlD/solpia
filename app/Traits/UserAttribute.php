<?php

namespace App\Traits;

trait UserAttribute{

	public function getFullNameAttribute(){
		return ucfirst($this->fname) . ' ' . ucfirst($this->lname);
	}

	public function getActionsAttribute(){
		return '<a class="btn btn-success" data-toggle="tooltip" title="View User" data-id="' . $this->id . '">' .
			        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;' .
			   '<a class="btn btn-warning" data-toggle="tooltip" title="Edit User" data-id="' . $this->id . '">' .
			        '<span class="fa fa-pencil" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;' .
			   '<a class="btn btn-danger" data-toggle="tooltip" title="Delete User" data-id="' . $this->id . '">' .
			        '<span class="fa fa-trash" data-id="' . $this->id . '"></span>' .
			   '</a>';
	}
}