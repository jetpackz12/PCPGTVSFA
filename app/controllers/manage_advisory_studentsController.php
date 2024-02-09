<?php

/**
 * 
 */
class manage_advisory_studentsController extends Controller
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
		
		$advisory_id = filter_input(INPUT_GET, "advisory_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$sections_id = filter_input(INPUT_GET, "sections_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($advisory_id) &&  isset($sections_id))
		{
			$object = new advisoryStudentsModel();
			$student_ids = $object->get_student_ids([
				'sections_id' => $sections_id,
			]);
			$status_count = $object->get_total_status_sum([
				'advisory_id' => $advisory_id,
			]);
			$student = $object->index([
				'sections_id' => $sections_id,
			]);
			
			$this->controller->view()->render_data3('pages/manage_advisory/manage_advisory_students.php', $student, $advisory_id, $student_ids, $status_count);
		}
		else
		{
			$object = new userModel();
			$teacher = $object->index_teacher();
			$object = new sectionModel();
			$section = $object->index();
			$object = new advisoryModel();
			$advisory = $object->index();
			
			$this->controller->view()->render3('pages/manage_advisory/manage_advisory.php', $teacher, $section, $advisory);
		}

	}

	public function store()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$advisory_id = filter_input(INPUT_POST, "advisory_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$student_ids = filter_input(INPUT_POST, "student_ids", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$requirements = filter_input(INPUT_POST, "requirements", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($advisory_id) && isset($student_ids) && isset($requirements))
		{
			$object = new advisoryStudentsModel();
			$result = $object->store([
				'advisory_id' => $advisory_id,
				'student_ids' => $student_ids,
				'requirements' => $requirements,
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
			$object = new advisoryStudentsModel();
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
		$requirements = filter_input(INPUT_POST, "e_requirements", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($id) && isset($requirements))
		{
			$object = new advisoryStudentsModel();
			$result = $object->update([
				'id' => $id,
				'requirements' => $requirements,
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

	public function chared_all()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}
		$advisory_id = filter_input(INPUT_POST, "advisory_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($advisory_id))
		{
			$object = new advisoryStudentsModel();
			$result = $object->chared_all([
				'advisory_id' => $advisory_id
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

	public function chared()
	{
		
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($id) && isset($status))
		{
			$object = new advisoryStudentsModel();
			$result = $object->chared([
				'id' => $id,
				'status' => $status
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

	public function update_requirements()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$advisory_id = filter_input(INPUT_POST, "advisory_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$requirements = filter_input(INPUT_POST, "requirements", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($advisory_id) && isset($requirements))
		{
			$object = new advisoryStudentsModel();
			$result = $object->update_requirements([
				'advisory_id' => $advisory_id,
				'requirements' => $requirements,
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