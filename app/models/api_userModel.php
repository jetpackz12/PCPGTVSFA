<?php

class api_userModel extends model
{
    private $con;

    public function __construct()
    {
        $db = new database();
        $this->con = $db->connection();
    }

    public function index($param = array())
    {

        $username = $param['username'];
        $password = $param['password'];
        $data = array();

        $sql = "SELECT * FROM users WHERE username = '" . $username . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (!password_verify($password, $row['password'])) {
                $data = array(
                    'response' => '0',
                    'message' => "Login failed, Please check your username and password."
                );
                return $data;
            }

            $data = array(
                'response' => '1',
                'message' => "Login success.",
                'data' => $row
            );
        } else {
            $data = array(
                'response' => '0',
                'message' => "Login failed, Please check your username and password."
            );
        }

        $this->con->close();
        return $data;
    }

    public function vision_mission()
    {

        $data = array();

        $sql = "SELECT * FROM settings";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $data[] = $row;

                if ($row['id'] == '2')
                    break;
            }
        }

        $this->con->close();
        return $data;
    }

    public function get_student_profile($param = array())
    {
        $student_id = $param['student_id'];
        $data = array();

        $sql = "SELECT users.id, users.image_path, grades.grade, sections.section, users.subjects, users.fname, users.mname, users.lname, users.gender, users.birthdate, users.phonenumber, users.province, users.municipality, users.village_street, users.username, users.password, users.role_id, users.multi_role, CONCAT(advisory.fname, ' ', advisory.mname, ' ', advisory.lname) AS advisory_fullname
        FROM users
        INNER JOIN sections ON sections.id = users.section_id
        INNER JOIN grades ON grades.id = sections.grade_id
        INNER JOIN advisories ON advisories.section_id = sections.id
        INNER JOIN users AS advisory ON advisory.id = advisories.user_id
        WHERE users.id = '" . $student_id . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data[] = $row;
        }

        // $this->con->close();
        return $data;
    }

    public function get_roles($param = array())
    {
        $data = '';
        $arr_multi_role = array();
        $multi_role = explode(",", $param['multi_role']);

        $i = 0;
        while ($i < count($multi_role)) {
            $sql = "SELECT role FROM roles WHERE id = '" . $multi_role[$i] . "'";
            $result_roles = $this->con->query($sql);
            $row_roles = $result_roles->fetch_assoc();
            array_push($arr_multi_role, $row_roles['role']);
            $i++;
        }
        $data = implode(",", $arr_multi_role);

        $this->con->close();
        return $data;
    }

    public function get_student_clearance($param = array())
    {
        $student_id = $param['student_id'];
        $data = array();

        $sql = "SELECT requirements.id, requirements.added_from_id, added_froms.added_from, requirements.teacher_id, requirements.student_id, requirements.subject_id, requirements.requirements, requirements.status, requirements.payment_method, requirements.reference_number, requirements.amount
        FROM requirements
        INNER JOIN added_froms ON added_froms.id = requirements.added_from_id
        WHERE requirements.student_id = '" . $student_id . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                switch ($row['added_from_id']) {
                    case '1':
                        $sql = "SELECT CONCAT(users.fname, ' ', users.lname) AS advisory_fullname, users.image_path
                                FROM advisories 
                                INNER JOIN users ON users.id = advisories.user_id
                                WHERE advisories.id = '" . $row['teacher_id'] . "'";
                        $result_adviser = $this->con->query($sql);
                        $row_adviser = $result_adviser->fetch_assoc();
                        $row['teacher_id'] = $row_adviser['advisory_fullname'];
                        $row['image_path'] = $row_adviser['image_path'];
                        break;
                    case '2':
                        $sql = "SELECT faculties.id, CONCAT(users.fname, ' ', users.lname) AS faculty_fullname, faculties.subjects, users.image_path
                                FROM faculties 
                                INNER JOIN users ON users.id = faculties.user_id
                                WHERE faculties.id = '" . $row['teacher_id'] . "'";
                        $result_faculty = $this->con->query($sql);
                        $row_faculty = $result_faculty->fetch_assoc();
                        $row['teacher_id'] = $row_faculty['faculty_fullname'];
                        $row['image_path'] = $row_faculty['image_path'];
                        break;
                    case '3':
                        $sql = "SELECT requirements.id, CONCAT(users.fname, ' ', users.lname) AS casher_fullname, fees.payable, payables.amount, users.image_path
                                FROM requirements
                                INNER JOIN users ON users.id = requirements.teacher_id
                                INNER JOIN payables ON payables.id = requirements.requirements
                                INNER JOIN fees ON fees.id = payables.fee_id
                                WHERE requirements.teacher_id = '" . $row['teacher_id'] . "'";
                        $result_cashier = $this->con->query($sql);
                        $row_cashier = $result_cashier->fetch_assoc();
                        $row['teacher_id'] = $row_cashier['casher_fullname'];
                        $row['requirements'] = $row_cashier['payable'] . " (₱" . $row_cashier['amount'] . ")";
                        $row['image_path'] = $row_cashier['image_path'];
                        break;
                    default:
                        $sql = "SELECT CONCAT(users.fname, ' ', users.lname) AS fullname, users.image_path
                            FROM users 
                            WHERE id = '" . $row['teacher_id'] . "'";
                        $result_adviser = $this->con->query($sql);
                        $row_adviser = $result_adviser->fetch_assoc();
                        $row['teacher_id'] = $row_adviser['fullname'];
                        $row['image_path'] = $row_adviser['image_path'];
                        break;
                }
                $row['added_from'] = ucfirst($row['added_from']);
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

    public function get_adviser_profile($param = array())
    {
        $adviser_id = $param['adviser_id'];
        $data = array();

        $sql = "SELECT * FROM users
        WHERE id = '" . $adviser_id . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data[] = $row;
        }

        // $this->con->close();
        return $data;
    }

    public function get_adviser_students($param = array())
    {
        $adviser_id = $param['adviser_id'];
        $data = array();

        $sql = "SELECT student.id, student.image_path, CONCAT(student.fname, ' ', student.lname) AS student_fullname, student.gender, student.birthdate, student.phonenumber, CONCAT(student.village_street, ' ', student.municipality, ', ', student.province) AS address, CONCAT('Gr. ', grades.grade, ' ( ', sections.section, ' )') AS grade_and_section
        FROM advisories
        INNER JOIN sections ON sections.id = advisories.section_id
        INNER JOIN grades ON grades.id = sections.grade_id
        INNER JOIN users AS student ON student.section_id = sections.id
        WHERE advisories.user_id = '" . $adviser_id . "' AND student.role_id = '2'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['gender'] = $row['gender'] < 2 ? "Male" : "Female";
                $date = date_create($row['birthdate']);
                $row['birthdate'] = date_format($date, "M. d, Y");
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

    public function search_student($param = array())
    {
        $adviser_id = $param['adviser_id'];
        $search = $param['search'];
        $data = array();

        $sql = "SELECT student.id, student.image_path, CONCAT(student.fname, ' ', student.lname) AS student_fullname, student.gender, student.birthdate, student.phonenumber, CONCAT(student.village_street, ' ', student.municipality, ', ', student.province) AS address, CONCAT('Gr. ', grades.grade, ' ( ', sections.section, ' )') AS grade_and_section
        FROM advisories
        INNER JOIN sections ON sections.id = advisories.section_id
        INNER JOIN grades ON grades.id = sections.grade_id
        INNER JOIN users AS student ON student.section_id = sections.id
        WHERE advisories.user_id = '" . $adviser_id . "' AND student.role_id = '2' AND student.lname LIKE '%" . $search . "%'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['gender'] = $row['gender'] < 2 ? "Male" : "Female";
                $date = date_create($row['birthdate']);
                $row['birthdate'] = date_format($date, "M. d, Y");
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

    public function get_not_cleared_student($param = array())
    {
        $adviser_id = $param['adviser_id'];
        $data = array();

        $sql = "SELECT requirements.id, requirements.added_from_id, CONCAT(student.fname, ' ', student.lname) AS student_fullname, requirements.student_id, requirements.subject_id, requirements.requirements, requirements.status, requirements.payment_method, requirements.reference_number, requirements.amount, CONCAT('Gr. ', grades.grade, ' ( ', sections.section, ' )') AS grade_and_section
        FROM requirements
        INNER JOIN advisories ON advisories.id = requirements.teacher_id
        INNER JOIN users AS adviser ON adviser.id = advisories.user_id
        INNER JOIN users AS student ON student.id = requirements.student_id
        INNER JOIN sections ON sections.id = advisories.section_id
        INNER JOIN grades ON grades.id = sections.grade_id
        WHERE requirements.added_from_id = '1' AND advisories.user_id = '" . $adviser_id . "'";

        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

    public function chared_student($param = array())
    {
        $id = $param['id'];
        $data = array();

        $sql = "UPDATE requirements 
                SET status = '0', requirements = 'OK' 
                WHERE id = '" . $id . "'";
        if ($this->con->query($sql) == TRUE) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully cleared this student."
            );
        } else {
            $data = array(
                'response' => '0',
                'message' => "Failed, "  . $sql . "<br>" . $this->con->error
            );
        }

        $this->con->close();
        return $data;
    }

    public function chared_All_student($param = array())
    {
        $adviser_id = $param['adviser_id'];
        $data = array();

        $sql = "SELECT id FROM advisories WHERE user_id = '" . $adviser_id . "'";
        $result = $this->con->query($sql);
        $row = $result->fetch_assoc();

        $sql = "UPDATE requirements 
                SET status = '0', requirements = 'OK' 
                WHERE added_from_id = '1' AND teacher_id = '" . $row['id'] . "'";
        if ($this->con->query($sql) == TRUE) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully cleared All student."
            );
        } else {
            $data = array(
                'response' => '0',
                'message' => "Failed, "  . $sql . "<br>" . $this->con->error
            );
        }

        $this->con->close();
        return $data;
    }

    public function search_student_clearance($param = array())
    {
        $adviser_id = $param['adviser_id'];
        $search = $param['search'];
        $data = array();

        $sql = "SELECT requirements.id, requirements.added_from_id, CONCAT(student.fname, ' ', student.lname) AS student_fullname, requirements.student_id, requirements.subject_id, requirements.requirements, requirements.status, requirements.payment_method, requirements.reference_number, requirements.amount, CONCAT('Gr. ', grades.grade, ' ( ', sections.section, ' )') AS grade_and_section
        FROM requirements
        INNER JOIN advisories ON advisories.id = requirements.teacher_id
        INNER JOIN users AS adviser ON adviser.id = advisories.user_id
        INNER JOIN users AS student ON student.id = requirements.student_id
        INNER JOIN sections ON sections.id = advisories.section_id
        INNER JOIN grades ON grades.id = sections.grade_id
        WHERE requirements.added_from_id = '1' AND advisories.user_id = '" . $adviser_id . "' AND student.lname LIKE '%" . $search . "%'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

    public function get_student_sections($param = array())
    {
        $adviser_id = $param['adviser_id'];
        $data = array();

        $sql = "SELECT section_id
                FROM advisories
                WHERE user_id = '" . $adviser_id . "'";
        $result_advisories = $this->con->query($sql);
        $row_advisories = $result_advisories->fetch_assoc();

        $sql = "SELECT id FROM users WHERE section_id = '" . $row_advisories['section_id'] . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        // $this->con->close();
        return $data;
    }

    public function cleared_students($param = array())
    {
        $sections = $param['sections'];
        $data = array();
        $i = 0;
        while ($i < count($sections)) {
            $sql = "SELECT requirements.id, requirements.added_from_id, student.image_path, CONCAT(student.fname, ' ', student.lname) AS student_fullname, student.gender, student.birthdate, student.phonenumber, CONCAT(student.village_street, ' ', student.municipality, ', ', student.province) AS address, SUM(requirements.status) AS total_status, CONCAT('Gr. ', grades.grade, ' ( ', sections.section, ' )') AS grade_and_section, CONCAT(adviser.fname, ' ', adviser.lname) AS adviser_fullname
                    FROM requirements
                    INNER JOIN users AS student ON student.id = requirements.student_id
                    INNER JOIN sections ON sections.id = student.section_id
                    INNER JOIN advisories ON advisories.section_id = sections.id
                    INNER JOIN users AS adviser ON adviser.id = advisories.user_id
                    INNER JOIN grades ON grades.id = sections.grade_id
                    WHERE requirements.student_id = '" . $sections[$i]['id'] . "'";
            $result = $this->con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                switch ($row['total_status']) {
                    case '0':
                        $row['gender'] = $row['gender'] < 2 ? "Male" : "Female";
                        $date = date_create($row['birthdate']);
                        $row['birthdate'] = date_format($date, "M. d, Y");
                        $data[] = $row;
                        break;
                }
            }
            $i++;
        }

        $this->con->close();
        return $data;
    }

    public function search_cleared_student($param = array())
    {
        $sections = $param['sections'];
        $search = $param['search'];
        $data = array();
        $i = 0;
        while ($i < count($sections)) {
            $sql = "SELECT requirements.id, requirements.added_from_id, student.image_path, CONCAT(student.fname, ' ', student.lname) AS student_fullname, student.gender, student.birthdate, student.phonenumber, CONCAT(student.village_street, ' ', student.municipality, ', ', student.province) AS address, SUM(requirements.status) AS total_status, CONCAT('Gr. ', grades.grade, ' ( ', sections.section, ' )') AS grade_and_section, CONCAT(adviser.fname, ' ', adviser.lname) AS adviser_fullname
                    FROM requirements
                    INNER JOIN users AS student ON student.id = requirements.student_id
                    INNER JOIN sections ON sections.id = student.section_id
                    INNER JOIN advisories ON advisories.section_id = sections.id
                    INNER JOIN users AS adviser ON adviser.id = advisories.user_id
                    INNER JOIN grades ON grades.id = sections.grade_id
                    WHERE requirements.student_id = '" . $sections[$i]['id'] . "' AND student.lname LIKE '%" . $search . "%'";
            $result = $this->con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                switch ($row['total_status']) {
                    case '0':
                        $row['gender'] = $row['gender'] < 2 ? "Male" : "Female";
                        $date = date_create($row['birthdate']);
                        $row['birthdate'] = date_format($date, "M. d, Y");
                        $data[] = $row;
                        break;
                }
            }
            $i++;
        }

        $this->con->close();
        return $data;
    }
}
