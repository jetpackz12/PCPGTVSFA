<?php

class facultyModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index() {
        $data = array();

        $sql = "SELECT faculties.id, users.image_path, CONCAT(users.fname, ' ', users.mname, ' ', users.lname) AS faculty_fullname, faculties.subjects, users.multi_role FROM faculties
        INNER JOIN users ON users.id = faculties.user_id";
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

	public function store($param = array())
	{
        $user_id = $param['teacher'];
        $subjects = $param['subject'];
        $arr_subjects = implode(",", $subjects);
        $created_at = date('Y-m-d H:i:s');
        $data = array();

        $sql = "SELECT user_id FROM faculties WHERE user_id = '".$user_id."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Teacher has already assign subjects."
            );

            return $data;
        }

        $sql = "INSERT INTO faculties (user_id, subjects, created_at) 
        VALUES('".$user_id."','".$arr_subjects."','".$created_at."')";

        if($this->con->query($sql) === TRUE)
        {
            $sql = "SELECT multi_role FROM users WHERE id = '".$user_id."'";
            $result = $this->con->query($sql);
            $row = $result->fetch_assoc();
            $multi_role = $row['multi_role'];
            $multi_role .= ",5";

            $sql = "UPDATE users SET multi_role = '".$multi_role."'
            WHERE id = '".$user_id."'";
            if($this->con->query($sql) === TRUE)
            {
                $data = array(
                    'response' => '1',
                    'message' => "Success, You have successfully add new faculty member."
                );
            }
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

	public function edit($param = array())
	{
        $id = $param['id'];
        $data = array();

        $sql = "SELECT * FROM faculties
        WHERE id = '".$id."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = $result->fetch_assoc();
        }

        $this->con->close();
        return $data;
	}

	public function update($param = array())
	{
        $id = $param['id'];
        $user_id_old = $param['teacher_old'];
        $user_id = $param['teacher'];
        $subjects = $param['subject'];
        $arr_subjects = implode(",", $subjects);
        $data = array();

        if($user_id != $user_id_old)
        {
            $sql = "SELECT user_id FROM faculties WHERE user_id = '".$user_id."'";
            $result = $this->con->query($sql);
            if($result->num_rows > 0)
            {
                $data = array(
                    'response' => '0',
                    'message' => "Failed, This faculty member has already assign subjects."
                );

                return $data;
            }
        }

        $sql = "UPDATE faculties 
                SET user_id = '".$user_id."', subjects = '".$arr_subjects."'
                WHERE id = '".$id."'";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this faculty member."
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

	public function delete($param = array())
	{
        $id = $param['id'];
        $user_id = $param['user_id'];
        $added_from_id = '2';
        $data = array();

        $sql = "DELETE FROM faculties WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $sql = "DELETE FROM requirements 
            WHERE teacher_id = '".$id."' AND added_from_id = '".$added_from_id."'";
            if($this->con->query($sql) === TRUE)
            {
                $sql = "SELECT multi_role FROM users WHERE id = '".$user_id."'";
                $result = $this->con->query($sql);
                $row = $result->fetch_assoc();
                $arr_multi_role = explode(",", $row['multi_role']);
                $i = 0;
                while ($i < count($arr_multi_role)) {
                    if($arr_multi_role[$i] == "5")
                    {
                        array_splice($arr_multi_role, $i, 1);
                    }
                    $i++;
                }
                $arr_multi_role = implode(",",$arr_multi_role);
    
                $sql = "UPDATE users SET multi_role = '".$arr_multi_role."'
                WHERE id = '".$user_id."'";
                if($this->con->query($sql) === TRUE)
                {
                    $data = array(
                        'response' => '1',
                        'message' => "Success, You have successfully delete this faculty member."
                    );
                }
            }
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