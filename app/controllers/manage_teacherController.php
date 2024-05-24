<?php

/**
 * 
 */
class manage_teacherController extends Controller
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
			if(!in_array("Teacher", $arr_multi_role))
			{
				$this->controller->view()->view_render('pages/error_message/error_message.php');
				return;
			}
		}
		
		$object = new userModel();
		$teacher = $object->index_teacher();
		
		unset($_SESSION['filter_subject_id']);
		
        $this->controller->view()->render('pages/manage_teacher/manage_teacher.php', $teacher);
	}

	public function store()
	{
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$image_file_name = filter_input(INPUT_POST, "image_file_name", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
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

		if(isset($image_file_name) && isset($firstname) && isset($middlename) 
		&& isset($lastname) && isset($gender) && isset($birthdate) && isset($phonenumber) 
		&& isset($province) && isset($municipality) && isset($village_street) && isset($username) 
		&& isset($password))
		{
			$object = new userModel();
			$result = $object->store_teacher([
				'image_file_name' => $image_file_name,
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
			$result = $object->edit_teacher(['id' => $id]);
			
			if(isset($result))
			{
				$date=date_create($result['birthdate']);
				$arr_image_path = explode('/',$result['image_path']);
				$image_name = $arr_image_path[2];
				$result['birthdate_format'] = date_format($date,"M. d, Y");
				$result['image_name'] = $image_name;
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

		if(isset($id) && isset($image_file_name) && isset($firstname) && isset($middlename) 
		&& isset($lastname) && isset($gender) && isset($birthdate) && isset($phonenumber) 
		&& isset($province) && isset($municipality) && isset($village_street) && isset($username) 
		&& isset($password))
		{
			$hash_password = $password_old;
			if(!password_verify($password, $password_old))
            {
				$hash_password = password_hash($password, PASSWORD_BCRYPT);
            }

			$object = new userModel();
			$result = $object->update_teacher([
				'id' => $id,
				'image_file_name' => $image_file_name,
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
		$status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($id) && isset($status))
		{
			$object = new userModel();
			$result = $object->delete_teacher([
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
	

}
?>