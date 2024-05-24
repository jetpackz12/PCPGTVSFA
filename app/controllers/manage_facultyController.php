<?php

/**
 * 
 */
class manage_facultyController extends Controller
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
			if(!in_array("Assign Subjects", $arr_multi_role))
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

		$object = new facultyModel();
		$faculty = $object->index();

		$object = new role_and_permissionModel();
		$role = $object->index();
		
		unset($_SESSION['filter_subject_id']);
		
        $this->controller->view()->render5('pages/manage_faculty/manage_faculty.php', $section, $subject, $teacher, $faculty, $role);
	}

	public function store()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$check_all = filter_input(INPUT_POST, "check_all", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 0;
		$teacher = filter_input(INPUT_POST, "teacher", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$subject = $_POST['subject'] ?? null;

		if(isset($check_all) && isset($teacher) && isset($subject))
		{
			$object = new facultyModel();
			$result = $object->store([
				'check_all' => $check_all,
				'teacher' => $teacher,
				'subject' => $subject,
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
			$object = new facultyModel();
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
		$check_all = filter_input(INPUT_POST, "check_all", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 0;
		$old_subjects = filter_input(INPUT_POST, "d_subjects", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$teacher_old = filter_input(INPUT_POST, "e_teacher_old", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$teacher = filter_input(INPUT_POST, "e_teacher", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$subject = $_POST['e_subject'] ?? null;
		
		if(isset($id) && isset($teacher_old) && isset($teacher) && isset($subject))
		{

			$object = new facultyModel();
			$result = $object->update([
				'id' => $id,
				'check_all' => $check_all,
				'old_subjects' => $old_subjects,
				'teacher_old' => $teacher_old,
				'teacher' => $teacher,
				'subject' => $subject,
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
		$subjects = filter_input(INPUT_POST, "d_subjects", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$user_id = filter_input(INPUT_POST, "e_teacher", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($id) && isset($subjects) && isset($user_id))
		{
			$object = new facultyModel();
			$result = $object->delete([
				'id' => $id,
				'subjects' => $subjects,
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