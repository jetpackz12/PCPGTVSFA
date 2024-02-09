<?php

class userAccountModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index() {
        $data = array();

        $sql = "SELECT users.id, users.image_path, users.section_id, users.subjects, users.fname, users.mname, users.lname, users.gender, users.birthdate, users.phonenumber, users.province, users.municipality, users.village_street, users.username, users.password, users.role_id, roles.role, users.multi_role, users.status 
        FROM users
        INNER JOIN roles on roles.id = users.role_id
        WHERE users.role_id > '1'
        ORDER BY roles.role ASC";
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

        $sql = "SELECT * FROM users WHERE id = '".$id."'";
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
        $role = $param['role'];
        $data = array();
        $sql = "SELECT multi_role FROM users WHERE id = '".$id."'";
        $result = $this->con->query($sql);
        $row = $result->fetch_assoc();

        $arr_multi_role = explode(",", $row['multi_role']);
        $i = 0;
        while ($i < count($arr_multi_role)) {
            if($arr_multi_role[$i] == '1' || $arr_multi_role[$i] > "5")
            {
                array_splice($arr_multi_role, $i, 1);
            }
            $i++;
        }

        $multi_role = implode(",",$arr_multi_role);
        if($role != 'remove')
        {
            $multi_role .= "," . $role;
        }

        $sql = "UPDATE users SET multi_role = '".$multi_role."'
        WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add update user role."
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