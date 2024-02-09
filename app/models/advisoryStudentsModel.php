<?php

class advisoryStudentsModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index($param = array()) {
        $added_from_id = '1';
        // $adviser = $param['adviser'];
        $sections_id = $param['sections_id'];
        $data = array();

        $sql = "SELECT requirements.id, grades.grade, sections.section, CONCAT(adviser.fname, ' ', adviser.mname, ' ', adviser.lname) AS adviser_fullname,
        student.image_path, CONCAT(student.fname, ' ', student.mname, ' ', student.lname) AS student_fullname, requirements.requirements, requirements.status 
        FROM requirements
        INNER JOIN users AS student ON student.id = requirements.student_id
        INNER JOIN sections ON sections.id = student.section_id
        INNER JOIN advisories ON advisories.section_id = sections.id
        INNER JOIN grades ON grades.id = sections.grade_id
        INNER JOIN users AS adviser ON adviser.id = advisories.user_id
        WHERE requirements.added_from_id = '".$added_from_id."' AND student.section_id = '".$sections_id."'";
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
        $added_from_id = '1';
        $teacher_id = $param['advisory_id'];
        $student_ids = $param['student_ids'];
        $arr_student_ids = explode(',', $student_ids);
        $requirements = $param['requirements'];
        $created_at = date('Y-m-d H:i:s');
        $data = array();
        $check = false;

        for ($i=1; $i < count($arr_student_ids); $i++) {
            $sql = "INSERT INTO requirements (added_from_id, teacher_id, student_id, requirements, created_at) 
            VALUES('".$added_from_id."','".$teacher_id."','".$arr_student_ids[$i]."','".$requirements."','".$created_at."')";

            if($this->con->query($sql) === TRUE)
            {
                $check = true;
            }

        }

        if($check)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add student requirements."
            );
        }
        else
        {
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

        $sql = "SELECT * FROM requirements WHERE id = '".$id."'";
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
        $requirements = $param['requirements'];
        $data = array();

        $sql = "UPDATE requirements 
                SET requirements = '".$requirements."'
                WHERE id = '".$id."'";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this requirements."
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

	public function chared_all($param = array())
	{
        $teacher_id = $param['advisory_id'];
        $added_from_id = '1';
        $status = 0;
        $data = array();

        $sql = "UPDATE requirements 
        SET status = '".$status."', requirements = 'OK'
        WHERE added_from_id = '".$added_from_id."' AND teacher_id = '".$teacher_id."' AND status = '1'";
        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully chared all student."
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

	public function chared($param = array())
	{
        $id = $param['id'];
        $status = $param['status'] > 0 ? 0 : 1;
        $data = array();

        $sql = "UPDATE requirements 
        SET status = '".$status."', requirements = 'OK' WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully chared this student."
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

	public function update_requirements($param = array())
	{
        $added_from_id = '1';
        $teacher_id = $param['advisory_id'];
        $requirements = $param['requirements'];
        $data = array();


        $sql = "UPDATE requirements SET requirements = '".$requirements."'
                WHERE added_from_id = '".$added_from_id."' AND teacher_id = '".$teacher_id."' AND status = '1'";
        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update requirements."
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
    
    public function get_student_ids($param = array()) {
        $sections_id = $param['sections_id'];
        $data = array();

        $sql = "SELECT users.id
        FROM users
        INNER JOIN sections ON sections.id = users.section_id
        INNER JOIN grades ON grades.id = sections.grade_id
        WHERE users.section_id = '".$sections_id."' AND users.role_id = '2'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        // $this->con->close();
        return $data;
    }

    public function get_total_status_sum($param = array())
    {
        $added_from_id = '1';
        $teacher_id = $param['advisory_id'];
        $sql = "SELECT SUM(status) AS status_sum FROM requirements 
                WHERE added_from_id = '".$added_from_id."' AND teacher_id = '".$teacher_id."'";
         $result = $this->con->query($sql);
         if($result->num_rows > 0)
         {
            $data = $result->fetch_assoc();
         }
 
         // $this->con->close();
         return $data;
    }

}