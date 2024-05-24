<?php

/**
 * 
 */
class manage_faculty_signatory_studentsController extends Controller
{
    private $controller;
    function __construct()
    {
        $this->controller = new Controller();
    }

    public function index()
    {
        if (!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname'])) {
            $this->controller->view()->view_render('pages/login/login.php');
            return;
        }

        $object = new signatoryModel();
        $students = $object->get_students();
        $object = new sectionModel();
        $sections = $object->index();
        $section_is_exist = array();

        foreach ($sections as $section) {
            foreach ($students as $student) {
                if ($section['id'] == $student['section_id'] && $student['requirements_status'] == 1) {
                    $section_is_exist[] = $section;
                    break;
                }
            }
        }

        $this->controller->view()->render3('pages/signatory/signatory.php', $students, $sections, $section_is_exist);
    }

    public function store()
    {
        if (!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname'])) {
            $this->controller->view()->view_render('pages/login/login.php');
            return;
        }

        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
        $requirements = filter_input(INPUT_POST, "requirements", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
        if (isset($id) && isset($requirements)) {
            $object = new signatoryModel();
            $result = $object->student_store([
                'id' => $id,
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
        } else {
            echo json_encode([
                'response' => '0',
                'message' => "Failed, Please check inputted data."
            ]);
        }
    }

    public function edit()
    {

        if (!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname'])) {
            $this->controller->view()->view_render('pages/login/login.php');
            return;
        }

        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
        if (isset($id)) {
            $object = new signatoryModel();
            $result = $object->student_edit(['id' => $id]);

            if (isset($result)) {
                echo json_encode($result);
            }
        } else {
            echo json_encode([
                'response' => '0',
                'message' => "Failed, Please check inputted data."
            ]);
        }
    }

    public function update()
    {

        if (!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname'])) {
            $this->controller->view()->view_render('pages/login/login.php');
            return;
        }

        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
        $requirements = filter_input(INPUT_POST, "e_requirements", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
        if (isset($id) && isset($requirements)) {
            $object = new signatoryModel();
            $result = $object->student_update([
                'id' => $id,
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
        } else {
            echo json_encode([
                'response' => '0',
                'message' => "Failed, Please check inputted data."
            ]);
        }
    }

    public function store_per_grade()
    {
        if (!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname'])) {
            $this->controller->view()->view_render('pages/login/login.php');
            return;
        }

        $section = filter_input(INPUT_POST, "section", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
        $requirements = filter_input(INPUT_POST, "requirements", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
        if (isset($section) && isset($requirements)) {
            $object = new signatoryModel();
            $result = $object->store_per_grade([
                'section' => $section,
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
        } else {
            echo json_encode([
                'response' => '0',
                'message' => "Failed, Please check inputted data."
            ]);
        }
    }

    public function chared_all()
    {
        if (!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname'])) {
            $this->controller->view()->view_render('pages/login/login.php');
            return;
        }
        $section = filter_input(INPUT_POST, "section", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
        if (isset($section)) {
            $object = new signatoryModel();
            $result = $object->student_chared_all([
                'section' => $section
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
        } else {
            echo json_encode([
                'response' => '0',
                'message' => "Failed, Please check inputted data."
            ]);
        }
    }

    public function chared()
    {

        if (!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname'])) {
            $this->controller->view()->view_render('pages/login/login.php');
            return;
        }

        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
        $status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
        if (isset($id) && isset($status)) {
            $object = new signatoryModel();
            $result = $object->student_chared([
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
        } else {
            echo json_encode([
                'response' => '0',
                'message' => "Failed, Please check inputted data."
            ]);
        }
    }
}
