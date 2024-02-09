<?php

/**
 * 
 */
class manage_faculty_member_studentsController extends Controller
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
		
		$faculty_id = filter_input(INPUT_GET, "faculty_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$subjects = filter_input(INPUT_GET, "subjects", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;

		if(isset($faculty_id) &&  isset($subjects))
		{
			
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
				$new_subjects = empty($new_subjects) ? 'none': $new_subjects;
			}
			$this->controller->view()->render_data4('pages/manage_faculty/manage_faculty_member_students.php', $subject, $subjects, $student, $faculty_id, $new_subjects);
		}
		else
		{
			$object = new sectionModel();
			$section = $object->index();
			$object = new subjectModel();
			$subject = $object->index();
			$object = new userModel();
			$teacher = $object->index_teacher();
			$object = new facultyModel();
			$faculty = $object->index();
			
			$this->controller->view()->render4('pages/manage_faculty/manage_faculty.php', $section, $subject, $teacher, $faculty);
		}
		
	}

	public function store()
	{
		
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$faculty_id = filter_input(INPUT_POST, "faculty_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$student_ids = filter_input(INPUT_POST, "student_ids", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$requirements = filter_input(INPUT_POST, "requirements", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;

		if(empty($student_ids))
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, No student on this subject."
			]);
			return;
		}

		if(isset($faculty_id) && isset($student_ids) && isset($subject) && isset($requirements))
		{
			$object = new facultyMemberStudentsModel();
			$result = $object->store([
				'faculty_id' => $faculty_id,
				'student_ids' => $student_ids,
				'subject' => $subject,
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
			$object = new facultyMemberStudentsModel();
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
			$object = new facultyMemberStudentsModel();
			$result = $object->update([
				'id' => $id,
				'requirements' => $requirements
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

	public function get_student_ids()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$subject_id = filter_input(INPUT_POST, "subject_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($subject_id))
		{
			$object = new facultyMemberStudentsModel();
			$result = $object->get_student_ids();
			$student_ids = array();

			foreach ($result as $student) {
				$arr_student_subjects = explode(",", $student['subjects']);
				if(in_array($subject_id, $arr_student_subjects))
				{
					$student_ids[] = $student['id'];
				}
			}

			echo json_encode([
				'response' => $student_ids
			]);
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
			$object = new facultyMemberStudentsModel();
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
	
	public function chared_all()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}
		$faculty_id = filter_input(INPUT_POST, "faculty_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$subject_filter = filter_input(INPUT_POST, "subject_filter", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($faculty_id) && isset($subject_filter))
		{
			$object = new facultyMemberStudentsModel();
			$result = $object->chared_all([
				'faculty_id' => $faculty_id,
				'subject_filter' => $subject_filter
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