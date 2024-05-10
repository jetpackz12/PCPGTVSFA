<?php

class facultyMemberStudentsModel extends model
{
    private $con;

    public function __construct()
    {
        $db = new database();
        $this->con = $db->connection();
    }

    public function index($param = array())
    {
        $teacher_id = $param['faculty_id'];
        $added_from_id = '2';
        $data = array();

        $sql = "SELECT requirements.id, requirements.subject_id, subjects.subject, grades.grade, sections.section, CONCAT(teacher.fname, ' ', teacher.mname, ' ', teacher.lname) AS teacher_fullname,
        student.image_path, CONCAT(student.fname, ' ', student.mname, ' ', student.lname) AS student_fullname, requirements.requirements, requirements.status 
        FROM requirements
        INNER JOIN users AS student ON student.id = requirements.student_id
        INNER JOIN subjects ON subjects.id = requirements.subject_id
        INNER JOIN sections ON sections.id = student.section_id
        INNER JOIN faculties ON faculties.id = requirements.teacher_id
        INNER JOIN grades ON grades.id = sections.grade_id
        INNER JOIN users AS teacher ON teacher.id = faculties.user_id
        WHERE requirements.added_from_id = '" . $added_from_id . "' AND requirements.teacher_id = '" . $teacher_id . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

    public function store($param = array())
    {
        $added_from_id = '2';
        $teacher_id = $param['faculty_id'];
        $student_ids = $param['student_ids'];
        $arr_student_ids = explode(',', $student_ids);
        $subject_id = $param['subject'];
        $requirements = $param['requirements'];
        $created_at = date('Y-m-d H:i:s');
        $data = array();
        $check = false;

        for ($i = 0; $i < count($arr_student_ids); $i++) {
            $sql = "INSERT INTO requirements (added_from_id, teacher_id, student_id, subject_id, requirements, created_at) 
            VALUES('" . $added_from_id . "','" . $teacher_id . "','" . $arr_student_ids[$i] . "', '" . $subject_id . "','" . $requirements . "','" . $created_at . "')";

            if ($this->con->query($sql) === TRUE) {
                $check = true;
            }
        }

        if ($check) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add student requirements."
            );
        } else {
            $data = array(
                'response' => '0',
                'message' => "Failed, Adding student requirements failed."
            );
        }

        $this->con->close();
        return $data;
    }

    public function edit($param = array())
    {
        $id = $param['id'];
        $data = array();

        $sql = "SELECT requirements.id, requirements.subject_id, subjects.subject, grades.grade, sections.section, CONCAT(teacher.fname, ' ', teacher.mname, ' ', teacher.lname) AS teacher_fullname,
        student.image_path, CONCAT(student.fname, ' ', student.mname, ' ', student.lname) AS student_fullname, requirements.requirements, requirements.status 
        FROM requirements
        INNER JOIN users AS student ON student.id = requirements.student_id
        INNER JOIN subjects ON subjects.id = requirements.subject_id
        INNER JOIN sections ON sections.id = student.section_id
        INNER JOIN faculties ON faculties.id = requirements.teacher_id
        INNER JOIN grades ON grades.id = sections.grade_id
        INNER JOIN users AS teacher ON teacher.id = faculties.user_id
        WHERE requirements.id = '" . $id . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        }

        $this->con->close();
        return $data;
    }

    public function update($param = array())
    {
        $id = $param['id'];
        $requirements = $param['requirements'];
        $data = array();

        $sql = "UPDATE requirements 
                SET requirements = '" . $requirements . "'
                WHERE id = '" . $id . "'";

        if ($this->con->query($sql) === TRUE) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this requirements."
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

    public function chared_all($param = array())
    {
        $teacher_id = $param['faculty_id'];
        $subject_filter = $param['subject_filter'];
        $added_from_id = '2';
        $status = 0;
        $data = array();

        switch ($subject_filter) {
            case 'All':
                $sql = "UPDATE requirements 
                    SET status = '" . $status . "', requirements = 'OK'
                    WHERE added_from_id = '" . $added_from_id . "' AND teacher_id = '" . $teacher_id . "' AND status = '1'";
                break;

            default:
                $sql = "UPDATE requirements 
                    SET status = '" . $status . "', requirements = 'OK'
                    WHERE added_from_id = '" . $added_from_id . "' AND teacher_id = '" . $teacher_id . "' AND status = '1' AND subject_id = '$subject_filter'";
                break;
        }

        if ($this->con->query($sql) === TRUE) {
            $data = array(
                'response' => '1',
                'message' => "Success, Charing successfully."
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

    public function chared($param = array())
    {
        $id = $param['id'];
        $status = $param['status'] > 0 ? 0 : 1;
        $data = array();

        $sql = "UPDATE requirements 
        SET status = '" . $status . "', requirements = 'OK' WHERE id = '" . $id . "'";
        if ($this->con->query($sql) === TRUE) {
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

    public function update_requirements($param = array())
    {
        $added_from_id = '1';
        $teacher_id = $param['advisory_id'];
        $requirements = $param['requirements'];
        $data = array();


        $sql = "UPDATE requirements SET requirements = '" . $requirements . "'
                WHERE added_from_id = '" . $added_from_id . "' AND teacher_id = '" . $teacher_id . "' AND status = '1'";
        if ($this->con->query($sql) === TRUE) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update requirements."
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

    public function get_student_ids()
    {
        $data = array();

        $sql = "SELECT * FROM users WHERE role_id = '2'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

    public function get_total_status_sum($param = array())
    {
        $added_from_id = '1';
        $teacher_id = $param['advisory_id'];
        $sql = "SELECT SUM(status) AS status_sum FROM requirements 
                WHERE added_from_id = '" . $added_from_id . "' AND teacher_id = '" . $teacher_id . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        }

        // $this->con->close();
        return $data;
    }

    public function get_student_by_subjects($param = array())
    {
        $subjects = explode(',', $param['subjects']);
        $role_id = 2;
        $data = array();

        foreach ($subjects as $subject) {
            $sql = "SELECT users.id, users.image_path, users.subjects, grades.grade, sections.section, CONCAT(users.fname, ' ', users.mname, ' ', users.lname) AS student_fullname
                FROM users
                INNER JOIN sections ON sections.id = users.section_id
                INNER JOIN grades ON grades.id = sections.grade_id
                WHERE FIND_IN_SET('$subject', users.subjects) > 0 AND users.role_id = $role_id";

            $result = $this->con->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $row['subjects'] = $subject;
                    $data[] = $row;
                }
            }
        }

        $this->con->close();
        return $data;
    }

    public function get_teacher_by_faculty_id($param = array())
    {
        $faculty_id = $param['faculty_id'];
        $data = array();

        $sql = "SELECT CONCAT(users.fname, ' ', users.mname, ' ', users.lname) AS teacher_fullname, users.subjects
        FROM faculties
        INNER JOIN users ON users.id = faculties.user_id 
        WHERE faculties.id = $faculty_id";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        }

        $this->con->close();
        return $data;
    }
}
