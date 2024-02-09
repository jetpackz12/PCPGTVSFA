<?php
require 'app/lib/view.php';

class controller{

	private $view;
	
	public function __construct(){
		session_start();
		$this->view = new view();
	}

	public function view(){
		return $this->view;
	}


}

?>