<?php

/**
 * 
 */
class signator_loginController extends Controller
{
	private $controller;
	function __construct()
	{
		$this->controller = new Controller();
	}

	public function index()
	{
		if (isset($_SESSION['fname']) && isset($_SESSION['mname']) && isset($_SESSION['lname']) && isset($_SESSION['role_id'])) {

			$object = new signatoryModel();
			$students = $object->get_students();

			// die(json_encode($students));

			$this->controller->view()->render('pages/signatory/signatory.php', $students);
			return;
		}

		$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;

		if (isset($username) && isset($password)) {
			$object = new userModel();
			$result = $object->authentication_for_signatory(array(
				'username' => $username,
				'password' => $password,
			));

			switch ($result['response']) {
				case '1':
					$_SESSION['fname'] = $result['data']['fname'];
					$_SESSION['mname'] = $result['data']['mname'];
					$_SESSION['lname'] = $result['data']['lname'];
					$_SESSION['role_id'] = $result['data']['role_id'];
					$_SESSION['signatory_id'] = $result['data']['id'];

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
		} else {
			unset($_SESSION['fname']);
			unset($_SESSION['mname']);
			unset($_SESSION['lname']);
			unset($_SESSION['role_id']);
			unset($_SESSION['signatory_id']);

			session_destroy();
			$this->controller->view()->view_render('pages/login/login_for_signator.php');
		}
	}
}
