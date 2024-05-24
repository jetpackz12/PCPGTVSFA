<?php

class signatoryModel extends model
{
    private $con;

    public function __construct()
    {
        $db = new database();
        $this->con = $db->connection();
    }

    public function index()
    {
        $data = array();

        $sql = "SELECT * FROM `users` WHERE role_id > '3'";
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
        $image_path = $param['image_file_name'];
        $firstname = $param['firstname'];
        $middlename = $param['middlename'];
        $lastname = $param['lastname'];
        $gender = $param['gender'];
        $birthdate = $param['birthdate'];
        $phonenumber = $param['phonenumber'];
        $province = $param['province'];
        $municipality = $param['municipality'];
        $village_street = $param['village_street'];
        $username = $param['username'];
        $password = $param['password'];
        $sig_name = $param['sig_name'];
        $status = '1';
        $created_at = date('Y-m-d H:i:s');
        $data = array();

        $sql = "SELECT added_from FROM added_froms 
                WHERE added_from = '" . $sig_name . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $data = array(
                'response' => '0',
                'message' => "Failed, Signatory already exist."
            );

            return $data;
        }

        $sql = "SELECT username FROM users 
                WHERE username = '" . $username . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $data = array(
                'response' => '0',
                'message' => "Failed, Invalid username please change."
            );

            return $data;
        }

        $sql = "SELECT fname, mname, lname FROM users 
                WHERE fname = '" . $firstname . "' AND mname = '" . $middlename . "' AND lname = '" . $lastname . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $data = array(
                'response' => '0',
                'message' => "Failed, Signatory name is already exist."
            );

            return $data;
        }

        $last_id = 0;

        $sql = "INSERT INTO added_froms (added_from, created_at) VALUES ('" . $sig_name . "', '" . $created_at . "')";
        if ($this->con->query($sql) === TRUE) {
            $last_id = $this->con->insert_id;
        } else {
            $data = array(
                'response' => '0',
                'message' => "Failed, "  . $sql . "<br>" . $this->con->error
            );
            return $data;
        }

        $sql = "INSERT INTO users (image_path, fname, mname, lname, gender, birthdate,
                 phonenumber, province, municipality, village_street, username, password, role_id, multi_role, status, created_at) 
                VALUES('" . $image_path . "','" . $firstname . "','" . $middlename . "','" . $lastname . "','" . $gender . "',
                '" . $birthdate . "','" . $phonenumber . "','" . $province . "','" . $municipality . "','" . $village_street . "',
                '" . $username . "','" . $password . "','" . $last_id . "','" . $last_id . "','" . $status . "','" . $created_at . "')";

        if ($this->con->query($sql) === TRUE) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add new signatory."
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

    public function edit($param = array())
    {
        $id = $param['id'];
        $data = array();

        $sql = "SELECT added_froms.added_from, users.*
        FROM users 
        INNER JOIN added_froms ON added_froms.id = users.role_id
        WHERE users.id = '" . $id . "'";
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
        $image_path = $param['image_file_name'];
        $firstname = $param['firstname'];
        $middlename = $param['middlename'];
        $lastname = $param['lastname'];
        $gender = $param['gender'];
        $birthdate = $param['birthdate'];
        $phonenumber = $param['phonenumber'];
        $province = $param['province'];
        $municipality = $param['municipality'];
        $village_street = $param['village_street'];
        $username = $param['username'];
        $password = $param['password'];
        $sig_name = $param['sig_name'];
        $role_id = $param['role_id'];
        $data = array();

        $sql = "UPDATE added_froms SET added_from='" . $sig_name . "' WHERE id = '" . $role_id . "'";
        $this->con->query($sql);

        $sql = "UPDATE users SET image_path='" . $image_path . "', fname='" . $firstname . "', mname='" . $middlename . "',
                lname='" . $lastname . "', gender='" . $gender . "', birthdate='" . $birthdate . "', phonenumber='" . $phonenumber . "',
                province='" . $province . "', municipality='" . $municipality . "', village_street='" . $village_street . "',
                username='" . $username . "', password='" . $password . "'
                WHERE id = '" . $id . "'";

        if ($this->con->query($sql) === TRUE) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this signatory."
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

    public function delete($param = array())
    {
        $id = $param['id'];
        $status = $param['status'] > 0 ? 0 : 1;
        $status_message = $param['status'] > 0 ? 'inactive' : 'active';
        $data = array();

        $sql = "UPDATE users 
        SET status = '" . $status . "' WHERE id = '" . $id . "'";
        if ($this->con->query($sql) === TRUE) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully " . $status_message . " this teacher."
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

    public function get_students($param = array())
    {
        $role_id = $_SESSION['role_id'];
        $data = array();

        $sql = "SELECT users.id AS user_id, requirements.id AS requirements_id, requirements.status AS requirements_status, sections.section, grades.grade, users.*, requirements.* FROM `users` 
        INNER JOIN sections ON sections.id = users.section_id
        INNER JOIN grades ON grades.id = sections.grade_id
        LEFT JOIN requirements ON requirements.student_id = users.id AND requirements.added_from_id = '" . $role_id . "'
        WHERE users.role_id = '2'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }


    public function student_store($param = array())
    {
        $added_from_id = $_SESSION['role_id'];
        $teacher_id = $_SESSION['signatory_id'];
        $student_id = $param['id'];
        $requirements = $param['requirements'];
        $created_at = date('Y-m-d H:i:s');
        $data = array();

        $sql = "INSERT INTO requirements (added_from_id, teacher_id, student_id, requirements, created_at) 
        VALUES('" . $added_from_id . "','" . $teacher_id . "','" . $student_id . "','" . $requirements . "','" . $created_at . "')";
        if ($this->con->query($sql) === TRUE) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add student requirements."
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


    public function student_chared($param = array())
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

    public function student_edit($param = array())
    {
        $id = $param['id'];
        $data = array();

        $sql = "SELECT * FROM requirements WHERE id = '" . $id . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        }

        $this->con->close();
        return $data;
    }

    public function student_update($param = array())
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


    public function store_per_grade($param = array())
    {
        $added_from_id = $_SESSION['role_id'];
        $teacher_id = $_SESSION['signatory_id'];
        $section = $param['section'];
        $requirements = $param['requirements'];
        $created_at = date('Y-m-d H:i:s');
        $added_status = false;
        $data = array();

        $sql = "SELECT users.id, requirements.status
                FROM requirements
                RIGHT JOIN users ON users.id = requirements.student_id
                WHERE users.section_id = '" . $section . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                if ($row['status'] == null) {
                    $sql = "INSERT INTO requirements (added_from_id, teacher_id, student_id, requirements, created_at) 
                    VALUES('" . $added_from_id . "','" . $teacher_id . "','" . $row['id'] . "','" . $requirements . "','" . $created_at . "')";
                    $this->con->query($sql);

                    $added_status = true;
                }
            }

        }

        if ($added_status) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully added requirements on this section."
            );
        } else {
            $data = array(
                'response' => '0',
                'message' => "Failed, All students on this section is already added."
            );
        }

        $this->con->close();
        return $data;
    }

    public function student_chared_all($param = array())
    {
        $section = $param['section'];
        $status = 0;
        $update_status = false;
        $data = array();

        $sql = "SELECT users.id, requirements.status
                FROM requirements
                RIGHT JOIN users ON users.id = requirements.student_id
                WHERE users.section_id = '" . $section . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $sql = "UPDATE requirements 
                SET status = '" . $status . "', requirements = 'OK' WHERE student_id = '" . $row['id'] . "'";
                $this->con->query($sql);

                $update_status = true;
            }

        }

        if ($update_status) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully cleared all student in this section."
            );
        } else {
            $data = array(
                'response' => '0',
                'message' => "Failed, All students on this section is already cleared."
            );
        }

        $this->con->close();
        return $data;
    }
}
