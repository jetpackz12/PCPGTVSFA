<?php

/**
 * 
 */
class manage_studentController extends Controller
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
			if(!in_array("Manage Student", $arr_multi_role))
			{
				$this->controller->view()->view_render('pages/error_message/error_message.php');
				return;
			}
		}
		
		$object = new gradeModel();
		$grade = $object->index();
		$object = new sectionModel();
		$section = $object->index();
		$object = new userModel();
		$student = $object->index_student();
		$object = new subjectModel();
		$subject = $object->index();
		
		unset($_SESSION['filter_subject_id']);
		
        $this->controller->view()->render4('pages/manage_student/manage_student.php', $grade, $section, $student, $subject);
	}

	public function store()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$image_file_name = filter_input(INPUT_POST, "image_file_name", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$grade = filter_input(INPUT_POST, "grade", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$check_list = $_POST['check_list'] ?? null;
		$firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$middlename = filter_input(INPUT_POST, "middlename", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$birthdate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$phonenumber = filter_input(INPUT_POST, "phonenumber", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$province = filter_input(INPUT_POST, "province", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$municipality = filter_input(INPUT_POST, "municipality", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$village_street = filter_input(INPUT_POST, "village_street", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$confirm_password = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;

		if($check_list == null)
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Please select student subjects."
			]);
			return;
		}

		if(strlen($phonenumber) != 11 || substr($phonenumber, 0, 1) != 0)
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Please check inputted phonenumber."
			]);
			return;
		}

		if($password != $confirm_password)
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Your password and confirm password is not the same."
			]);
			return;
		}

		if(isset($image_file_name) && isset($grade) && isset($firstname) && isset($middlename) && isset($lastname)
			&& isset($gender) && isset($birthdate) && isset($phonenumber) && isset($province) && isset($municipality)
			&& isset($village_street) && isset($username) && isset($password))
		{
			$object = new userModel();
			$result = $object->store_student([
				'image_file_name' => $image_file_name,
				'check_list'=>implode(",",$check_list),
				'grade' => $grade,
				'firstname' => $firstname,
				'middlename' => $middlename,
				'lastname' => $lastname,
				'gender' => $gender,
				'birthdate' => $birthdate,
				'phonenumber' => $phonenumber,
				'province' => $province,
				'municipality' => $municipality,
				'village_street' => $village_street,
				'username' => $username,
				'password' => password_hash($password, PASSWORD_BCRYPT),
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
			$object = new userModel();
			$result = $object->edit_student(['id' => $id]);
			
			if(isset($result))
			{
				$date=date_create($result['birthdate']);
				$result['birthdate_format'] = date_format($date,"M. d, Y");
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
		$image_file_name = filter_input(INPUT_POST, "e_image_file_name", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$grade = filter_input(INPUT_POST, "e_grade", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$check_list = $_POST['e_check_list'] ?? null;
		$firstname = filter_input(INPUT_POST, "e_firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$middlename = filter_input(INPUT_POST, "e_middlename", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$lastname = filter_input(INPUT_POST, "e_lastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$gender = filter_input(INPUT_POST, "e_gender", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$birthdate = filter_input(INPUT_POST, "e_birthdate", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$phonenumber = filter_input(INPUT_POST, "e_phonenumber", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$province = filter_input(INPUT_POST, "e_province", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$municipality = filter_input(INPUT_POST, "e_municipality", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$village_street = filter_input(INPUT_POST, "e_village_street", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$username = filter_input(INPUT_POST, "e_username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$password_old = filter_input(INPUT_POST, "e_password_old", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$password = filter_input(INPUT_POST, "e_password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$confirm_password = filter_input(INPUT_POST, "e_confirm_password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;

		if($check_list == null)
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Please select student subjects."
			]);
			return;
		}

		if(strlen($phonenumber) != 11 || substr($phonenumber, 0, 1) != 0)
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Please check inputted phonenumber."
			]);
			return;
		}

		if($password != $confirm_password)
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Your password and confirm password is not the same."
			]);
			return;
		}

		if(isset($id) && isset($image_file_name) && isset($grade) && isset($firstname) && isset($middlename) 
			&& isset($lastname) && isset($gender) && isset($birthdate) && isset($phonenumber) && isset($province)
			&& isset($municipality) && isset($village_street) && isset($username) && isset($password))
		{
			$hash_password = $password_old;
			if(!password_verify($password, $password_old))
            {
				$hash_password = password_hash($password, PASSWORD_BCRYPT);
            }

			$object = new userModel();
			$result = $object->update_student([
				'id' => $id,
				'image_file_name' => $image_file_name,
				'check_list'=>implode(",",$check_list),
				'grade' => $grade,
				'firstname' => $firstname,
				'middlename' => $middlename,
				'lastname' => $lastname,
				'gender' => $gender,
				'birthdate' => $birthdate,
				'phonenumber' => $phonenumber,
				'province' => $province,
				'municipality' => $municipality,
				'village_street' => $village_street,
				'username' => $username,
				'password' => $hash_password,
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
		if(isset($id))
		{
			$object = new userModel();
			$result = $object->delete_student([
				'id' => $id,
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

	public function show_subjects()
	{
		$section_id = filter_input(INPUT_POST, "section_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($section_id))
		{
			$object = new userModel();
			$result = $object->show_subjects([
				'section_id' => $section_id
			]);

			if(isset($result))
			{
				echo json_encode([
					'response' => '1',
					'message' => $result
				]);
			}
			else
			{
				echo json_encode([
					'response' => '0',
					'message' => "Failed, Can't Retrieve Subjects Data."
				]);
			}
		}
		else
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Can't Retrieve Subjects Data."
			]);
		}
	}
	

}
?>