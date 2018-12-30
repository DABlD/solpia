<?php

namespace App\Traits;

trait UserAttribute{

	public function getFullNameAttribute(){
		return ucfirst($this->fname) . ' ' . ucfirst($this->lname);
	}
}