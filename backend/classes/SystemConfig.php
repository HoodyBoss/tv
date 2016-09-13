<?php

class SystemConfig extends SystemVO
{
	private $uploadPath;
	private $recPerPage;

	function getUploadPath() {
		return $this->uploadPath;
	}
	function setUploadPath($uploadPath) {
		$this->uploadPath = $uploadPath;
	}
	function getRecPerPage() {
		return $this->recPerPage;
	}
	function setRecPerPage($recPerPage) {
		$this->recPerPage = $recPerPage;
	}
}
?>