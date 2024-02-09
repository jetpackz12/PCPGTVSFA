<?php

/**
 * 
 */
class loginController extends Controller
{
	private $controller;
	function __construct()
	{
		$this->controller = new Controller();
	}

	public function index()
	{
		if(isset($_SESSION['fname']) && isset($_SESSION['mname']) && isset($_SESSION['lname']) && count($_SESSION['multi_role']) > 0)
		{
			$arr_multi_role = explode(",",$_SESSION['multi_role']['permission']);
			switch ($arr_multi_role[0]) {
				case 'Dashboard':
					$object = new homeModel();
					$enrollees = $object->index();
					$object = new homeModel();
					$total_student = $object->total_student();
					$object = new homeModel();
					$total_teacher = $object->total_teacher();
					$object = new homeModel();
					$total_adviser = $object->total_adviser();
					$object = new homeModel();
					$total_not_cleared = $object->total_not_cleared();
					$object = new homeModel();
					$total_cleared = $object->total_cleared();
			
					$this->controller->view()->render6('pages/home/home.php', $enrollees, $total_student, $total_teacher, $total_adviser, $total_not_cleared, $total_cleared);
					break;
				case 'Manage Student':
					$object = new gradeModel();
					$grade = $object->index();
					$object = new sectionModel();
					$section = $object->index();
					$object = new userModel();
					$student = $object->index_student();
					$object = new subjectModel();
					$subject = $object->index();
					
					$this->controller->view()->render4('pages/manage_student/manage_student.php', $grade, $section, $student, $subject);
					break;
				case 'Manage Advisory And Teacher':
					if($arr_multi_role[1] == 'Advisory')
					{
						$object = new userModel();
						$teacher = $object->index_teacher();
						$object = new sectionModel();
						$section = $object->index();
						$object = new advisoryModel();
						$advisory = $object->index();
						
						$this->controller->view()->render3('pages/manage_advisory/manage_advisory.php', $teacher, $section, $advisory);
					}
					elseif($arr_multi_role[1] == 'Teacher')
					{
						$object = new userModel();
						$teacher = $object->index_teacher();
						
						$this->controller->view()->render('pages/manage_teacher/manage_teacher.php', $teacher);
					}
					break;
				case 'Manage Faculty':
					if($arr_multi_role[1] == 'Assign Subjects')
					{
						$object = new sectionModel();
						$section = $object->index();
				
						$object = new subjectModel();
						$subject = $object->index();
				
						$object = new userModel();
						$teacher = $object->index_teacher();
				
						$object = new facultyModel();
						$faculty = $object->index();
				
						$object = new role_and_permissionModel();
						$role = $object->index();
						
						$this->controller->view()->render5('pages/manage_faculty/manage_faculty.php', $section, $subject, $teacher, $faculty, $role);
					}
					elseif($arr_multi_role[1] == 'Cashier')
					{

						$object = new feesModel();
						$fees = $object->index();
				
						$object = new gradeModel();
						$grade = $object->index();
						
						$object = new cashierModel();
						$payable = $object->index();
				
						$this->controller->view()->render3('pages/manage_faculty_cashier/manage_faculty_cashier.php', $fees, $grade, $payable);
					}
					break;
				case 'Grade Section And Subjects':
					if($arr_multi_role[1] == 'Grade')
					{
						$object = new gradeModel();
						$result = $object->index();
						
						$this->controller->view()->render('pages/manage_grade/manage_grade.php', $result);
					}
					elseif($arr_multi_role[1] == 'Section')
					{
						$object = new gradeModel();
						$grade = $object->index();
				
						$object = new sectionModel();
						$section = $object->index();
						
						$this->controller->view()->render2('pages/manage_section/manage_section.php', $grade, $section);
					}
					elseif($arr_multi_role[1] == 'Subjects')
					{
						$object = new sectionModel();
						$section = $object->index();
				
						$object = new subjectModel();
						$subject = $object->index();
						
						$this->controller->view()->render2('pages/manage_subject/manage_subject.php', $section, $subject);
					}
					break;
				case 'Manage User Account':
					$object = new userAccountModel();
					$result = $object->index();
			
					$object = new role_and_permissionModel();
					$role = $object->index();
			
					$this->controller->view()->render2('pages/manage_user_account/manage_user_account.php', $result, $role);
					break;
				case 'Fees Management':
					$object = new feesModel();
					$fees = $object->index();
			
					$this->controller->view()->render('pages/fees_management/fees_management.php', $fees);
					break;
				case 'Role and Permission':
					$object = new role_and_permissionModel();
					$result = $object->index();
					
					$this->controller->view()->render('pages/role_and_permission/role_and_permission.php', $result);
					break;
				case 'System Settings':
					$object = new settingModel();
					$result = $object->index();
					
					$this->controller->view()->render('pages/system_settings/system_settings.php', $result);
					break;
			}

			return;
		}

		$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
		
		if(isset($username) && isset($password))
		{
			$object = new userModel();
			$result = $object->authentication(array(
				'username' => $username,
				'password' => $password,
			));

			switch ($result['response']) {
				case '1':
						$_SESSION['user_id'] = $result['data']['id'];
						$_SESSION['fname'] = $result['data']['fname'];
						$_SESSION['mname'] = $result['data']['mname'];
						$_SESSION['lname'] = $result['data']['lname'];
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
			unset($_SESSION['multi_role']);
			unset($_SESSION['multi_role_id']);
	
			session_destroy();
			$this->controller->view()->view_render('pages/login/login.php');
		}
	}
}
?>