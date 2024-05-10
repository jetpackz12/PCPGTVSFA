<?php

/**
 * 
 */
class manage_assigneeController extends Controller
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
			if(!in_array("Subject Assignee", $arr_multi_role))
			{
				$this->controller->view()->view_render('pages/error_message/error_message.php');
				return;
			}
		}


		$object = new sectionModel();
		$section = $object->index();

		$object = new subjectModel();
		$subject = $object->index();

		$object = new userModel();
		$teacher = $object->index_teacher();

		$object = new assigneeModel();
		$faculty = $object->index();

		$object = new role_and_permissionModel();
		$role = $object->index();
		
        $this->controller->view()->render5('pages/manage_faculty/manage_assignee.php', $section, $subject, $teacher, $faculty, $role);
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