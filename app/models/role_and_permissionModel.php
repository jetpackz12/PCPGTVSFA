<?php

class role_and_permissionModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index() {
        $data = array();

        $sql = "SELECT * FROM roles";
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
        $role = $param['role'];
        $permission = $param['check_permission'];
        $arr_check_permission = implode(",", $permission);
        $created_at = date('Y-m-d H:i:s');
        $data = array();

        $sql = "SELECT role FROM roles WHERE role = '".$role."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, This role has already exist."
            );

            return $data;
        }

        $sql = "INSERT INTO roles (role, permission, created_at) 
        VALUES('".$role."','".$arr_check_permission."','".$created_at."')";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add new role."
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

	public function edit($param = array())
	{
        $id = $param['id'];
        $data = array();

        $sql = "SELECT * FROM roles WHERE id = '".$id."'";
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
        $role_old = $param['role_old'];
        $permission = $param['check_permission'];
        $arr_check_permission = implode(",", $permission);
        $data = array();

        if($role != $role_old)
        {
            $sql = "SELECT role FROM roles WHERE role = '".$role."'";
            $result = $this->con->query($sql);
            if($result->num_rows > 0)
            {
                $data = array(
                    'response' => '0',
                    'message' => "Failed, This role has already exist."
                );

                return $data;
            }
        }

        $sql = "UPDATE roles 
                SET role = '".$role."', permission = '".$arr_check_permission."'
                WHERE id = '".$id."'";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this role."
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
        $data = array();

        $sql = "DELETE FROM roles WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $sql = "SELECT id, multi_role FROM users";
            $result = $this->con->query($sql);
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()) {

                    $arr_multi_role = explode(",", $row['multi_role']);
                    $i = 0;
                    while ($i < count($arr_multi_role)) {
                        if($arr_multi_role[$i] == $id)
                        {
                            array_splice($arr_multi_role, $i, 1);
                        }
                        $i++;
                    }
                    $arr_multi_role = implode(",",$arr_multi_role);
        
                    $sql = "UPDATE users SET multi_role = '".$arr_multi_role."'
                    WHERE id = '".$row['id']."'";
                    if($this->con->query($sql) === TRUE)
                    {
                        $data = array(
                            'response' => '1',
                            'message' => "Success, You have successfully delete this role."
                        );
                    }

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