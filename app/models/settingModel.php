<?php

class settingModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index() {
        $data = array();

        $sql = "SELECT * FROM settings";
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

	public function edit($param = array())
	{
        $id = $param['id'];
        $data = array();

        $sql = "SELECT * FROM settings WHERE id = '".$id."'";
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
        $description = $param['description'];
        $data = array();

        $sql = "UPDATE settings 
                SET description = '".$description."'
                WHERE id = '".$id."'";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this setting."
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

	public function update_school_year($param = array())
	{
        $id = $param['id'];
        $description = $param['description'];
        $school_year = $param['old_description'];
        $data = array();
        $created_at = date('Y-m-d H:i:s');

        $sql = "UPDATE settings 
                SET description = '".$description."'
                WHERE id = '".$id."'";
        $result = $this->con->query($sql);

        $sql = "SELECT COUNT(id) AS students FROM users WHERE role_id = '2'";
        $result = $this->con->query($sql);
        $students = $result->fetch_assoc();
        
        $sql = "INSERT INTO enrollees (school_year, enrollees, created_at)
        VALUES ('".$school_year."', '".$students['students']."', '".$created_at."')";
        if($this->con->query($sql) === TRUE)
        {
            $sql = "DELETE FROM users WHERE role_id = '2'";
            $this->con->query($sql);
            $sql = "DELETE FROM faculties";
            $this->con->query($sql);
            $sql = "DELETE FROM requirements";
            $this->con->query($sql);
            $sql = "DELETE FROM payables";
            $this->con->query($sql);
            $sql = "UPDATE subjects SET is_assign = 0 WHERE is_assign = 1";
            $this->con->query($sql);

            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this setting."
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

    public function get_system_name()
    {
        $data = array();

        $sql = "SELECT * FROM settings WHERE id = '3'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $data = $row['description'];
        }

        $this->con->close();
        return $data;
    }

}