<?php

/**
 * 
 */
class api_userController extends Controller
{
	private $controller;
	function __construct()
	{
		$this->controller = new Controller();
	}

	public function index()
	{
		$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($username) && isset($password))
		{
			$object = new api_userModel();
			$result = $object->index(array(
				'username' => $username,
				'password' => $password,
			));

			switch ($result['response']) {
				case '1':
						echo json_encode([
							'response' => $result['response'],
							'message' => $result['message'],
							'data' => $result['data']
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
	}

	public function vision_mission()
	{
		$object = new api_userModel();
		$result = $object->vision_mission();
		if(isset($result))
		{
			echo json_encode($result);
		}
	}

	public function get_student_profile()
	{

		$student_id = filter_input(INPUT_POST, "student_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($student_id))
		{
			$object = new api_userModel();
			$result = $object->get_student_profile(array(
				'student_id' => $student_id,
			));

			$object = new api_userModel();
			$roles = $object->get_roles(array(
				'multi_role' => $result[0]['multi_role'],
			));

			$result[0]['multi_role'] = $roles;
			
			if(isset($result))
			{
				echo json_encode($result);
				
			}

		}
	}

	public function get_student_clearance()
	{
		$student_id = filter_input(INPUT_POST, "student_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($student_id))
		{
			$object = new api_userModel();
			$result = $object->get_student_clearance(array(
				'student_id' => $student_id,
			));
			
			if(isset($result))
			{
				echo json_encode($result);
				
			}

		}
	}

	public function get_advisor_dashboard()
	{
		$object = new homeModel();
		$total_student = $object->total_student();
		$object = new homeModel();
		$total_not_cleared = $object->total_not_cleared();
		$object = new homeModel();
		$total_cleared = $object->total_cleared();

		$result[] = array(
			'total_student' => $total_student['total_student'],
			'total_not_cleared' => $total_not_cleared['total'],
			'total_cleared' => $total_cleared['total'],
		);

		echo json_encode($result);
	}

	public function get_adviser_profile()
	{
		$adviser_id = filter_input(INPUT_POST, "adviser_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($adviser_id))
		{
			$object = new api_userModel();
			$result = $object->get_adviser_profile(array(
				'adviser_id' => $adviser_id,
			));

			$object = new api_userModel();
			$roles = $object->get_roles(array(
				'multi_role' => $result[0]['multi_role'],
			));

			$result[0]['multi_role'] = $roles;
			
			if(isset($result))
			{
				echo json_encode($result);
				
			}

		}
	}

	public function get_adviser_students()
	{
		$adviser_id = filter_input(INPUT_POST, "adviser_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($adviser_id))
		{
			$object = new api_userModel();
			$result = $object->get_adviser_students(array(
				'adviser_id' => $adviser_id,
			));
			
			if(isset($result))
			{
				echo json_encode($result);
				
			}

		}
	}

	public function search_student()
	{
		$adviser_id = filter_input(INPUT_POST, "adviser_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$search = filter_input(INPUT_POST, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($adviser_id) && isset($search))
		{
			$object = new api_userModel();
			$result = $object->search_student(array(
				'adviser_id' => $adviser_id,
				'search' => $search,
			));
			
			if(isset($result))
			{
				echo json_encode($result);
				
			}

		}
	}

	public function get_not_cleared_student()
	{
		$adviser_id = filter_input(INPUT_POST, "adviser_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;

		if(isset($adviser_id))
		{
			$object = new api_userModel();
			$result = $object->get_not_cleared_student(array(
				'adviser_id' => $adviser_id,
			));
			
			if(isset($result))
			{
				echo json_encode($result);
				
			}

		}
	}

	public function chared_student()
	{
		$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;

		if(isset($id))
		{
			$object = new api_userModel();
			$result = $object->chared_student(array(
				'id' => $id,
			));

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
	}

	public function chared_All_student()
	{
		$adviser_id = filter_input(INPUT_POST, "adviser_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;

		if(isset($adviser_id))
		{
			$object = new api_userModel();
			$result = $object->chared_All_student(array(
				'adviser_id' => $adviser_id,
			));

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
	}

	public function search_student_clearance()
	{
		$adviser_id = filter_input(INPUT_POST, "adviser_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$search = filter_input(INPUT_POST, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($adviser_id) && isset($search))
		{
			$object = new api_userModel();
			$result = $object->search_student_clearance(array(
				'adviser_id' => $adviser_id,
				'search' => $search,
			));
			
			if(isset($result))
			{
				echo json_encode($result);
				
			}

		}
	}

	public function get_cleared_student()
	{
		$adviser_id = filter_input(INPUT_POST, "adviser_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;

		if(isset($adviser_id))
		{
			$object = new api_userModel();
			$sections = $object->get_student_sections(array(
				'adviser_id' => $adviser_id,
			));
			
			$object = new api_userModel();
			$students = $object->cleared_students(array(
				'sections' => $sections,
			));
			
			if(isset($students))
			{
				echo json_encode($students);
				
			}

		}
	}

	public function search_cleared_student()
	{
		$adviser_id = filter_input(INPUT_POST, "adviser_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$search = filter_input(INPUT_POST, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($adviser_id) && isset($search))
		{
			$object = new api_userModel();
			$sections = $object->get_student_sections(array(
				'adviser_id' => $adviser_id,
			));
			
			$object = new api_userModel();
			$students = $object->search_cleared_student(array(
				'sections' => $sections,
				'search' => $search,
			));
			
			if(isset($students))
			{
				echo json_encode($students);
				
			}

		}
	}
}
?>