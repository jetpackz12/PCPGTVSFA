<?php

/**
 * 
 */
class homeController extends Controller
{
	private $controller;
	function __construct()
	{
		$this->controller = new Controller();
	}

	public function index()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		if(isset($_SESSION['multi_role']))
		{
			$arr_multi_role = explode(",",$_SESSION['multi_role']['permission']);
			if(!in_array("Dashboard", $arr_multi_role))
			{
				$this->controller->view()->view_render('pages/error_message/error_message.php');
				return;
			}
		}

		$object = new homeModel();
		$enrollees = $object->index();
		$object = new homeModel();
		$total_student = $object->total_student();
		$object = new homeModel();
		$total_teacher = $object->total_teacher();
		$object = new homeModel();
		$total_adviser = $object->total_adviser();
		$object = new homeModel();
		$total_not_cleared = $object->total_not_cleared();
		$object = new homeModel();
		$total_cleared = $object->total_cleared();
		
		unset($_SESSION['filter_subject_id']);

        $this->controller->view()->render6('pages/home/home.php', $enrollees, $total_student, $total_teacher, $total_adviser, $total_not_cleared, $total_cleared);
	}

	public function store()
	{
		
	}

	public function edit()
	{

	}

	public function update()
	{

	}

	public function delete()
	{

	}
	

}
?>