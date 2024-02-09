<?php

class userModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function authentication($param=array())
    {
        $username = $param['username'];
        $password = $param['password'];
        $data = array();

        $sql = "SELECT * FROM users WHERE username = '" .$username. "'";
        $result = $this->con->query($sql);

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $row_role = array();

            if(!password_verify($password, $row['password']))
            {
                $data = array(
                    'response' => '0',
                    'message' => "Login failed, Please check your username and password."
                );
                return $data;
            }

            $arr_multi_role = explode(",",$row['multi_role']);
            $i = 0;
            while ($i < count($arr_multi_role)) {
                if($arr_multi_role[$i] == '1' || $arr_multi_role[$i] > '5')
                {
                    $sql = "SELECT permission FROM roles WHERE id = '".$arr_multi_role[$i]."'";
                    $result_role = $this->con->query($sql);
                    $row_role = $result_role->fetch_assoc();
                }
                $i++;
            }
            $row['multi_role'] = $row_role;
            $data = array(
                'response' => '1',
                'message' => "Login success.",
                'data' => $row
            );
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Login failed, Please check your username and password."
            );
        }

        $this->con->close();
        return $data;
    }

    public function authentication_for_advisory($param=array())
    {
        $username = $param['username'];
        $password = $param['password'];
        $data = array();

        $sql = "SELECT advisories.id, advisories.user_id, advisories.section_id, users.fname, users.mname, users.lname, users.password, users.multi_role FROM advisories 
        INNER JOIN users ON users.id = advisories.user_id 
        WHERE username = '" .$username. "'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            if(!password_verify($password, $row['password']))
            {
                $data = array(
                    'response' => '0',
                    'message' => "Login failed, Please check your username and password."
                );
                return $data;
            }
            $row['multi_role'] = ['permission' => 'Has advisory'];

            $data = array(
                'response' => '1',
                'message' => "Login success.",
                'data' => $row
            );
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Login failed, Please check your username and password."
            );
        }

        $this->con->close();
        return $data;
    }

    public function authentication_for_faculty($param=array())
    {
        $username = $param['username'];
        $password = $param['password'];
        $data = array();

        $sql = "SELECT faculties.id, faculties.user_id, faculties.subjects, users.fname, users.mname, users.lname, users.password, users.multi_role FROM faculties
        INNER JOIN users ON users.id = faculties.user_id
        WHERE username = '" .$username. "'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            if(!password_verify($password, $row['password']))
            {
                $data = array(
                    'response' => '0',
                    'message' => "Login failed, Please check your username and password."
                );
                return $data;
            }
            $row['multi_role'] = ['permission' => 'Has faculty'];

            $data = array(
                'response' => '1',
                'message' => "Login success.",
                'data' => $row
            );
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Login failed, Please check your username and password."
            );
        }

        $this->con->close();
        return $data;
    }

    public function index_student() {
        $data = array();

        $sql = "SELECT users.id, users.image_path, grades.grade, sections.section, users.subjects, users.fname, users.mname, users.lname, users.gender, users.birthdate, users.phonenumber, users.province, users.municipality, users.village_street, users.role_id FROM users
        INNER JOIN sections ON sections.id = users.section_id
        INNER JOIN grades ON grades.id = sections.grade_id
        WHERE users.role_id = '2'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

	public function store_student($param = array())
	{
        $image_path = $param['image_file_name'];
        $check_list = $param['check_list'];
        $grade = $param['grade'];
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
        $role_id = '2';
        $created_at = date('Y-m-d H:i:s');
        $data = array();

        $sql = "SELECT username FROM users 
                WHERE username = '".$username."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Invalid username please change."
            );

            return $data;
        }

        $sql = "SELECT fname, mname, lname FROM users 
                WHERE fname = '".$firstname."' AND mname = '".$middlename."' AND lname = '".$lastname."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Student name is already exist."
            );

            return $data;
        }

        $sql = "INSERT INTO users (image_path, section_id, subjects, fname, mname, lname, gender, birthdate,
                 phonenumber, province, municipality, village_street, username, password, role_id, multi_role, created_at) 
                VALUES('".$image_path."','".$grade."','".$check_list."','".$firstname."','".$middlename."',
                '".$lastname."','".$gender."','".$birthdate."','".$phonenumber."','".$province."',
                '".$municipality."','".$village_street."','".$username."','".$password."','".$role_id."',
                '".$role_id."','".$created_at."')";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add new student."
            );
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, "  . $sql . "<br>" . $this->con->error
            );
        }

        $this->con->close();
        return $data;
	}

	public function edit_student($param = array())
	{
        $id = $param['id'];
        $data = array();

        $sql = "SELECT users.id, users.image_path, users.section_id, grades.id AS grade_id, grades.grade, sections.section, users.subjects, users.fname, users.mname, users.lname, users.gender, users.birthdate, users.phonenumber, users.province, users.municipality, users.village_street, users.username, users.password, users.role_id FROM users
        INNER JOIN sections ON sections.id = users.section_id
        INNER JOIN grades ON grades.id = sections.grade_id
        WHERE users.id = '".$id."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = $result->fetch_assoc();
        }

        $this->con->close();
        return $data;
	}

	public function update_student($param = array())
	{
        $id = $param['id'];
        $image_path = $param['image_file_name'];
        $check_list = $param['check_list'];
        $grade = $param['grade'];
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
        $data = array();

        $sql = "UPDATE users SET image_path='".$image_path."', section_id='".$grade."', subjects='".$check_list."', fname='".$firstname."', 
                mname='".$middlename."', lname='".$lastname."', gender='".$gender."', birthdate='".$birthdate."', phonenumber='".$phonenumber."', 
                province='".$province."', municipality='".$municipality."', village_street='".$village_street."', username='".$username."', password='".$password."'
                WHERE id = '".$id."'";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this student."
            );
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, "  . $sql . "<br>" . $this->con->error
            );
        }

        $this->con->close();
        return $data;
	}

	public function delete_student($param = array())
	{
        $id = $param['id'];
        $data = array();

        $sql = "DELETE FROM users WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully delete this student."
            );
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, "  . $sql . "<br>" . $this->con->error
            );
        }

        $this->con->close();
        return $data;
	}

    public function show_subjects($param = array())
    {
        $section_id = $param['section_id'];
        $sql = "SELECT subjects.id, grades.grade, sections.section, subjects.subject 
        FROM subjects
        INNER JOIN sections ON sections.id = subjects.section_id
        INNER JOIN grades ON grades.id = sections.grade_id
        WHERE subjects.section_id = '".$section_id."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

    public function index_teacher() {
        $data = array();

        $sql = "SELECT * FROM `users` WHERE role_id = '3'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

	public function store_teacher($param = array())
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
        $role_id = '3';
        $status = '1';
        $created_at = date('Y-m-d H:i:s');
        $data = array();

        $sql = "SELECT username FROM users 
                WHERE username = '".$username."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Invalid username please change."
            );

            return $data;
        }

        $sql = "SELECT fname, mname, lname FROM users 
                WHERE fname = '".$firstname."' AND mname = '".$middlename."' AND lname = '".$lastname."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Teacher name is already exist."
            );

            return $data;
        }

        $sql = "INSERT INTO users (image_path, fname, mname, lname, gender, birthdate,
                 phonenumber, province, municipality, village_street, username, password, role_id, multi_role, status, created_at) 
                VALUES('".$image_path."','".$firstname."','".$middlename."','".$lastname."','".$gender."',
                '".$birthdate."','".$phonenumber."','".$province."','".$municipality."','".$village_street."',
                '".$username."','".$password."','".$role_id."','".$role_id."','".$status."','".$created_at."')";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add new teacher."
            );
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, "  . $sql . "<br>" . $this->con->error
            );
        }

        $this->con->close();
        return $data;
	}

	public function edit_teacher($param = array())
	{
        $id = $param['id'];
        $data = array();

        $sql = "SELECT * FROM users WHERE id = '".$id."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = $result->fetch_assoc();
        }

        $this->con->close();
        return $data;
	}

	public function update_teacher($param = array())
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
        $data = array();

        $sql = "UPDATE users SET image_path='".$image_path."', fname='".$firstname."', mname='".$middlename."',
                lname='".$lastname."', gender='".$gender."', birthdate='".$birthdate."', phonenumber='".$phonenumber."',
                province='".$province."', municipality='".$municipality."', village_street='".$village_street."',
                username='".$username."', password='".$password."'
                WHERE id = '".$id."'";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this teacher."
            );
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, "  . $sql . "<br>" . $this->con->error
            );
        }

        $this->con->close();
        return $data;
	}

	public function delete_teacher($param = array())
	{
        $id = $param['id'];
        $status = $param['status'] > 0 ? 0 : 1;
        $status_message = $param['status'] > 0 ? 'inactive' : 'active';
        $data = array();

        $sql = "UPDATE users 
        SET status = '".$status."' WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully ".$status_message." this teacher."
            );
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, "  . $sql . "<br>" . $this->con->error
            );
        }

        $this->con->close();
        return $data;
	}

}