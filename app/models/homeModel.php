<?php

class homeModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index() 
    {
        $data = array();

        $sql = "SELECT * FROM enrollees";
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

    public function total_student() 
    {
        $data = array();

        $sql = "SELECT COUNT(id) AS total_student FROM users WHERE role_id = '2'";
        $result = $this->con->query($sql);
        $data = $result->fetch_assoc();

        $this->con->close();
        return $data;
    }

    public function total_teacher() 
    {
        $data = array();

        $sql = "SELECT COUNT(id) AS total_teacher FROM users WHERE role_id = '3'";
        $result = $this->con->query($sql);
        $data = $result->fetch_assoc();

        $this->con->close();
        return $data;
    }

    public function total_adviser() 
    {
        $data = array();

        $sql = "SELECT COUNT(id) AS total_adviser FROM advisories";
        $result = $this->con->query($sql);
        $data = $result->fetch_assoc();

        $this->con->close();
        return $data;
    }

    public function total_not_cleared() 
    {
        $data = array();
        $counter = 0;

        $sql = "SELECT * FROM users WHERE role_id = '2'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                $sql = "SELECT SUM(status) AS total FROM requirements WHERE student_id = '".$row['id']."'";
                $result_requirement = $this->con->query($sql);
                $requirement = $result_requirement->fetch_assoc();
                if($requirement['total'] > 0 && isset($requirement['total']))
                {
                    $data = array("total" => ++$counter);
                }

            }
        }

        $this->con->close();
        return !empty($data) ? $data : $data = array("total" => $counter);
    }

    public function total_cleared() 
    {
        $data = array();
        $counter = 0;

        $sql = "SELECT * FROM users WHERE role_id = '2'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                $sql = "SELECT SUM(status) AS total FROM requirements WHERE student_id = '".$row['id']."'";
                $result_requirement = $this->con->query($sql);
                $requirement = $result_requirement->fetch_assoc();
                if($requirement['total'] < 1 && isset($requirement['total']))
                {
                    $data = array("total" => ++$counter);
                }
            }
        }

        $this->con->close();
        return !empty($data) ? $data : $data = array("total" => $counter);
    }
}