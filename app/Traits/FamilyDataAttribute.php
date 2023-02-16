<?php

namespace App\Traits;

trait FamilyDataAttribute{

	public function getFullNameAttribute(){
		return ucfirst($this->fname) . ' ' . ucfirst($this->lname);
	}

	public function getFullName2Attribute(){
		return ucfirst($this->fname) . ' ' . $this->suffix . ' ' . $this->mname . ' ' .  ucfirst($this->lname);
	}

	public function getNameFullAttribute(){
		return ucfirst($this->lname) . ', ' . ucfirst($this->fname) . ' ' . ucfirst($this->suffix) . ' ' . ucfirst($this->mname);
	}
}