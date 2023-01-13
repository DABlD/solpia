<?php

namespace App\Traits;

trait UserAttribute{

	public function getFullNameAttribute(){
		return ucfirst($this->fname) . ' ' . ucfirst($this->lname);
	}

	public function getNameFullAttribute(){
		return ucfirst($this->lname) . ', ' . ucfirst($this->fname) . ' ' . ucfirst($this->suffix) . ' ' . ucfirst($this->mname);
	}

	public function getActionsAttribute(){
		$string = '<a class="btn btn-success" data-toggle="tooltip" title="View User" data-id="' . $this->id . '">' .
			        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;' .
			   '<a class="btn btn-warning" data-toggle="tooltip" title="Edit User" data-id="' . $this->id . '">' .
			        '<span class="fa fa-pencil" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;' .
			   '<a class="btn btn-danger" data-toggle="tooltip" title="Delete User" data-id="' . $this->id . '">' .
			        '<span class="fa fa-trash" data-id="' . $this->id . '"></span>' .
			   '</a>';

		if(auth()->user()->role == "Admin"){
			$string .= '&nbsp;<a class="btn btn-primary" data-toggle="tooltip" title="Assign to a Fleet" data-id="' . $this->id . '">' . '
				<span class="fa fa-ship" data-id="' . $this->id . '"></span>' . 
			'</a>';
		}

		return $string;
	}
}