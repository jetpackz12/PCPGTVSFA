<?php

/**
 * 
 */
class logoutController extends Controller
{
	private $controller;
	function __construct()
	{
		$this->controller = new Controller();
	}

	public function index()
	{
		unset($_SESSION['fname']);
		unset($_SESSION['mname']);
		unset($_SESSION['lname']);
		unset($_SESSION['multi_role']);
		unset($_SESSION['multi_role_id']);
		unset($_SESSION['advisory_id']);
		unset($_SESSION['section_id']);

		session_destroy();
		header('location: /PCPGTVSFA/');
	}
	

}
?>