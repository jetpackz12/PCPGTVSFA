<?php

class advisoryModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index() {
        $data = array();

        $sql = "SELECT advisories.id, users.image_path, users.fname, users.mname, users.lname, sections.id AS sections_id, grades.grade, sections.section 
        FROM advisories
        INNER JOIN users on users.id = advisories.user_id
        INNER JOIN sections on sections.id = advisories.section_id
        INNER JOIN grades on grades.id = sections.grade_id";
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
        $section_id = $param['grade'];
        $created_at = date('Y-m-d H:i:s');
        $data = array();

        $sql = "SELECT user_id FROM advisories WHERE user_id = '".$user_id."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Teacher has already assign advisory."
            );

            return $data;
        }

        $sql = "SELECT section_id FROM advisories WHERE section_id = '".$section_id."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Grade has already assign advisory."
            );

            return $data;
        }

        $sql = "INSERT INTO advisories (user_id, section_id, created_at) 
        VALUES('".$user_id."','".$section_id."','".$created_at."')";

        if($this->con->query($sql) === TRUE)
        {
            $sql = "SELECT multi_role FROM users WHERE id = '".$user_id."'";
            $result = $this->con->query($sql);
            $row = $result->fetch_assoc();
            $multi_role = $row['multi_role'];
            $multi_role .= ",4";

            $sql = "UPDATE users SET multi_role = '".$multi_role."'
            WHERE id = '".$user_id."'";
            if($this->con->query($sql) === TRUE)
            {
                $data = array(
                    'response' => '1',
                    'message' => "Success, You have successfully add new advisory."
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

        $sql = "SELECT advisories.id, users.fname, users.mname, users.lname, advisories.user_id, advisories.section_id
        FROM advisories
        INNER JOIN users on users.id = advisories.user_id 
        WHERE advisories.id = '".$id."'";
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
        $user_id = $param['teacher'];
        $section_id = $param['grade'];
        $section_id_old = $param['grade_old'];
        $data = array();

        if($section_id != $section_id_old)
        {
            $sql = "SELECT section_id FROM advisories WHERE section_id = '".$section_id."'";
            $result = $this->con->query($sql);
            if($result->num_rows > 0)
            {
                $data = array(
                    'response' => '0',
                    'message' => "Failed, Grade has already assign advisory."
                );

                return $data;
            }
        }

        $sql = "UPDATE advisories 
                SET user_id = '".$user_id."', section_id = '".$section_id."'
                WHERE id = '".$id."'";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this advisory."
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
        $added_from_id = '1';
        $data = array();

        $sql = "DELETE FROM advisories WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $sql = "DELETE FROM requirements WHERE teacher_id = '".$id."' AND added_from_id = '".$added_from_id."'";
            if($this->con->query($sql) === TRUE)
            {
                $sql = "SELECT multi_role FROM users WHERE id = '".$user_id."'";
                $result = $this->con->query($sql);
                $row = $result->fetch_assoc();
                $arr_multi_role = explode(",", $row['multi_role']);
                $i = 0;
                while ($i < count($arr_multi_role)) {
                    if($arr_multi_role[$i] == "4")
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
                        'message' => "Success, You have successfully delete this advisory."
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