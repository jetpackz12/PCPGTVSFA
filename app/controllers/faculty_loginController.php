<?php

/**
 * 
 */
class faculty_loginController extends Controller
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
            $faculty_id = $_SESSION['faculty_id'] ?? null;
            $subjects = $_SESSION['subjects'] ?? null;

            if(empty($faculty_id) && empty($subjects))
            {
                $this->controller->view()->view_render('pages/error_message/error_message.php');
				return;
            }

            $object = new facultyMemberStudentsModel();
			$student = $object->index(['faculty_id' => $faculty_id]);
			$object = new subjectModel();
			$subject = $object->index();
			$new_subjects = '';

			if(count($student) > 0)
			{
				$arr_student_subjects = explode(",", $subjects);
				$arr_student_subs = array();

				foreach($student as $result) {
					array_push($arr_student_subs, $result['subject_id']);
				}
				$arr_student_subs = array_unique($arr_student_subs);
				
				$new_subjects = implode(",", array_diff($arr_student_subjects, $arr_student_subs));
				$subjects = implode(",", array_intersect($arr_student_subjects, $arr_student_subs));
			}

			$this->controller->view()->render_data4('pages/manage_faculty/manage_faculty_member_students.php', $subject, $subjects, $student, $faculty_id, $new_subjects);
			return;
		}

		$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($username) && isset($password))
		{
			$object = new userModel();
			$result = $object->authentication_for_faculty(array(
				'username' => $username,
				'password' => $password,
			));

			switch ($result['response']) {
				case '1':
						$_SESSION['fname'] = $result['data']['fname'];
						$_SESSION['mname'] = $result['data']['mname'];
						$_SESSION['lname'] = $result['data']['lname'];
						$_SESSION['faculty_id'] = $result['data']['id'];
						$_SESSION['subjects'] = $result['data']['subjects'];
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
			$this->controller->view()->view_render('pages/login/login_for_faculty.php');
		}
	}
}
?>