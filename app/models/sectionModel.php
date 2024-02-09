<?php

class sectionModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index() {
        $data = array();

        $sql = "SELECT sections.id, grades.id AS grade_id, grades.grade, grades.status as grade_status, sections.status, sections.section 
        FROM sections
        INNER JOIN grades ON grades.id = sections.grade_id
        ORDER BY grades.grade ASC";
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
        $grade_id = $param['grade'];
        $section = $param['section'];
        $created_at = date('Y-m-d H:i:s');
        $data = array();

        $sql = "INSERT INTO sections (grade_id, section, created_at) 
        VALUES('".$grade_id."','".$section."','".$created_at."')";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add new section."
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

        $sql = "SELECT sections.id, grades.id AS grade_id, grades.grade, grades.status as grade_status, sections.status, sections.section 
        FROM sections
        INNER JOIN grades ON grades.id = sections.grade_id
        WHERE sections.id = '".$id."'";
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
        $grade = $param['grade'];
        $section = $param['section'];
        $data = array();

        $sql = "UPDATE sections 
                SET grade_id = '".$grade."', section = '".$section."'
                WHERE id = '".$id."'";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this section."
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
        $status = $param['status'] > 0 ? 0 : 1;
        $status_message = $param['status'] > 0 ? 'inactive' : 'active';
        $data = array();

        $sql = "UPDATE sections 
        SET status = '".$status."' WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully ".$status_message." this section."
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