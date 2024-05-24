<?php

/**
 * 
 */
class manage_advisoryController extends Controller
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
			if(!in_array("Advisory", $arr_multi_role))
			{
				$this->controller->view()->view_render('pages/error_message/error_message.php');
				return;
			}
		}
		
		$object = new userModel();
		$teacher = $object->index_teacher();
		$object = new sectionModel();
		$section = $object->index();
		$object = new advisoryModel();
		$advisory = $object->index();
		
		unset($_SESSION['filter_subject_id']);
		
        $this->controller->view()->render3('pages/manage_advisory/manage_advisory.php', $teacher, $section, $advisory);
	}

	public function store()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$teacher = filter_input(INPUT_POST, "teacher", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$grade = filter_input(INPUT_POST, "grade", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($teacher) && isset($grade))
		{
			$object = new advisoryModel();
			$result = $object->store([
				'teacher' => $teacher,
				'grade' => $grade,
			]);

			switch ($result['response']) {
				case '1':
						echo json_encode([
							'response' => $result['response'],
							'message' => $result['message']
						]);
					break;
				
				default:
						echo json_encode([
							'response' => $result['response'],
							'message' => $result['message']
						]);
					break;
			}
		}
		else
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Please check inputted data."
			]);
		}
	}

	public function edit()
	{

		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($id))
		{
			$object = new advisoryModel();
			$result = $object->edit(['id' => $id]);
			
			if(isset($result))
			{
				echo json_encode($result);
			}
		}
		else
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Please check inputted data."
			]);
		}
	}

	public function update()
	{
		
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$teacher = filter_input(INPUT_POST, "e_teacher", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$grade = filter_input(INPUT_POST, "e_grade", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$grade_old = filter_input(INPUT_POST, "e_grade_old", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($id) && isset($teacher) && isset($grade))
		{
			$object = new advisoryModel();
			$result = $object->update([
				'id' => $id,
				'teacher' => $teacher,
				'grade' => $grade,
				'grade_old' => $grade_old,
			]);

			switch ($result['response']) {
				case '1':
						echo json_encode([
							'response' => $result['response'],
							'message' => $result['message']
						]);
					break;
				
				default:
						echo json_encode([
							'response' => $result['response'],
							'message' => $result['message']
						]);
					break;
			}
		}
		else
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Please check inputted data."
			]);
		}
	}

	public function delete()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$user_id = filter_input(INPUT_POST, "e_teacher", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($id) && isset($user_id))
		{
			$object = new advisoryModel();
			$result = $object->delete([
				'id' => $id,
				'user_id' => $user_id,
			]);

			switch ($result['response']) {
				case '1':
						echo json_encode([
							'response' => $result['response'],
							'message' => $result['message']
						]);
					break;
				
				default:
						echo json_encode([
							'response' => $result['response'],
							'message' => $result['message']
						]);
					break;
			}
		}
		else
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Please check inputted data."
			]);
		}

	}
	

}
?>