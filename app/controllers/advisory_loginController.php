<?php

/**
 * 
 */
class advisory_loginController extends Controller
{
	private $controller;
	function __construct()
	{
		$this->controller = new Controller();
	}

	public function index()
	{
		if(isset($_SESSION['fname']) && isset($_SESSION['mname']) && isset($_SESSION['lname']))
		{
            $advisory_id = $_SESSION['advisory_id'] ?? null;
            $sections_id = $_SESSION['section_id'] ?? null;

            if(empty($advisory_id) && empty($sections_id))
            {
                $this->controller->view()->view_render('pages/error_message/error_message.php');
				return;
            }

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
			return;
		}

		$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($username) && isset($password))
		{
			$object = new userModel();
			$result = $object->authentication_for_advisory(array(
				'username' => $username,
				'password' => $password,
			));

			switch ($result['response']) {
				case '1':
						$_SESSION['fname'] = $result['data']['fname'];
						$_SESSION['mname'] = $result['data']['mname'];
						$_SESSION['lname'] = $result['data']['lname'];
						$_SESSION['advisory_id'] = $result['data']['id'];
						$_SESSION['section_id'] = $result['data']['section_id'];
						$_SESSION['multi_role'] = $result['data']['multi_role'];
						
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
			unset($_SESSION['fname']);
			unset($_SESSION['mname']);
			unset($_SESSION['lname']);
			unset($_SESSION['advisory_id']);
			unset($_SESSION['section_id']);
	
			session_destroy();
			$this->controller->view()->view_render('pages/login/login_for_advisory.php');
		}
	}
}
?>