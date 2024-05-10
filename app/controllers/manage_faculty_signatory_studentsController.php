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

        $this->controller->view()->render('pages/signatory/signatory.php', $students);
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

    // public function chared_all()
    // {
    //     if (!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname'])) {
    //         $this->controller->view()->view_render('pages/login/login.php');
    //         return;
    //     }
    //     $advisory_id = filter_input(INPUT_POST, "advisory_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
    //     if (isset($advisory_id)) {
    //         $object = new advisoryStudentsModel();
    //         $result = $object->chared_all([
    //             'advisory_id' => $advisory_id
    //         ]);

    //         switch ($result['response']) {
    //             case '1':
    //                 echo json_encode([
    //                     'response' => $result['response'],
    //                     'message' => $result['message']
    //                 ]);
    //                 break;

    //             default:
    //                 echo json_encode([
    //                     'response' => $result['response'],
    //                     'message' => $result['message']
    //                 ]);
    //                 break;
    //         }
    //     } else {
    //         echo json_encode([
    //             'response' => '0',
    //             'message' => "Failed, Please check inputted data."
    //         ]);
    //     }
    // }

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

    // public function update_requirements()
    // {
    //     if (!isset($_SESSION['fname']) && !isset($_SESSION['mname']) && !isset($_SESSION['lname'])) {
    //         $this->controller->view()->view_render('pages/login/login.php');
    //         return;
    //     }

    //     $advisory_id = filter_input(INPUT_POST, "advisory_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
    //     $requirements = filter_input(INPUT_POST, "requirements", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
    //     if (isset($advisory_id) && isset($requirements)) {
    //         $object = new advisoryStudentsModel();
    //         $result = $object->update_requirements([
    //             'advisory_id' => $advisory_id,
    //             'requirements' => $requirements,
    //         ]);

    //         switch ($result['response']) {
    //             case '1':
    //                 echo json_encode([
    //                     'response' => $result['response'],
    //                     'message' => $result['message']
    //                 ]);
    //                 break;

    //             default:
    //                 echo json_encode([
    //                     'response' => $result['response'],
    //                     'message' => $result['message']
    //                 ]);
    //                 break;
    //         }
    //     } else {
    //         echo json_encode([
    //             'response' => '0',
    //             'message' => "Failed, Please check inputted data."
    //         ]);
    //     }
    // }
}
