<?php

/**
 * 
 */
class manage_faculty_cashierController extends Controller
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
			if(!in_array("School Treasurer", $arr_multi_role))
			{
				$this->controller->view()->view_render('pages/error_message/error_message.php');
				return;
			}
		}

		$object = new feesModel();
		$fees = $object->index();

		$object = new gradeModel();
		$grade = $object->index();
		
		$object = new cashierModel();
		$payable = $object->index();
		
		unset($_SESSION['filter_subject_id']);

        $this->controller->view()->render3('pages/manage_faculty_cashier/manage_faculty_cashier.php', $fees, $grade, $payable);
	}

	public function store()
	{
		
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$payable = filter_input(INPUT_POST, "payable", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$amount = filter_input(INPUT_POST, "amount", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$grade = $_POST['grade'] ?? null;
        $cashier_id = $_SESSION['user_id'] ?? null;

		if(isset($payable) && isset($amount) && isset($grade) && isset($cashier_id))
		{
			$object = new cashierModel();
			$student_ids = $object->get_student_ids(['grade'=>$grade]);

			$object = new cashierModel();
			$result = $object->store([
				'cashier_id' => $cashier_id,
				'payable' => $payable,
				'amount' => $amount,
				'student_ids' => $student_ids,
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
			$object = new cashierModel();
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
		$payable = filter_input(INPUT_POST, "e_payable_value", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$amount = filter_input(INPUT_POST, "e_amount", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$grade = $_POST['e_grade'] ?? null;
        $cashier_id = $_SESSION['user_id'] ?? null;

		if(isset($id) && isset($amount) && isset($grade) && isset($cashier_id))
		{
			$object = new cashierModel();
			$student_ids = $object->get_student_ids(['grade'=>$grade]);

			$object = new cashierModel();
			$result = $object->update([
				'id' => $id,
				'cashier_id' => $cashier_id,
				'payable' => $payable,
				'amount' => $amount,
				'student_ids' => $student_ids,
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
			$object = new cashierModel();
			$result = $object->delete([
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

	public function get_fee_payment_method()
	{
		
		if(!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname']))
		{
			$this->controller->view()->view_render('pages/login/login.php');
			return;
		}

		$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if(isset($id))
		{
			$object = new cashierModel();
			$result = $object->get_fee_payment_method(['id' => $id]);
			
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
	

}
?>