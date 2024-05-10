<?php

/**
 * 
 */
class manage_faculty_cashier_studentsController extends Controller
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
		
		$payable_id = filter_input(INPUT_GET, "payable_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;

		$object = new cashierStudentModel();
		$result = $object->index([
			'payable_id' => $payable_id,
		]);
		
        $this->controller->view()->render('pages/manage_faculty_cashier/manage_faculty_cashier_students.php', $result);
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
			$object = new cashierStudentModel();
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
		$payable = filter_input(INPUT_POST, "payable", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$payment_method = filter_input(INPUT_POST, "payment_method", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$reference_number = filter_input(INPUT_POST, "reference_number", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$amount = filter_input(INPUT_POST, "amount", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		if($payable != $amount)
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Inputted amount is not the same of the payable amount."
			]);
			return;
		}
		elseif($payment_method == "Gcash" && empty($reference_number))
		{
			echo json_encode([
				'response' => '0',
				'message' => "Failed, Please enter reference number."
			]);
			return;
		}

		if(isset($id) && isset($payment_method) && isset($amount))
		{
			$object = new cashierStudentModel();
			$result = $object->update([
				'id' => $id,
				'payment_method' => $payment_method,
				'reference_number' => $reference_number,
				'amount' => $amount,
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
			$object = new cashierStudentModel();
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
	

}
?>