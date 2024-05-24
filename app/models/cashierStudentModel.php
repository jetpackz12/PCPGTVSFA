<?php

class cashierStudentModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index($param = array()) {
        $added_from_id = '3';
        $payable_id = $param['payable_id'];
        $data = array();

        $sql = "SELECT requirements.id, grades.grade, sections.section, CONCAT(adviser.fname, ' ', adviser.mname, ' ', adviser.lname) AS adviser_fullname,
        student.image_path, CONCAT(student.fname, ' ', student.mname, ' ', student.lname) AS student_fullname, 
        fees.payable, payables.amount, requirements.payment_method, requirements.reference_number, requirements.status 
        FROM requirements
        INNER JOIN users AS student ON student.id = requirements.student_id
        INNER JOIN sections ON sections.id = student.section_id
        INNER JOIN payables ON payables.id = requirements.requirements
        INNER JOIN fees ON fees.id = payables.fee_id
        INNER JOIN grades ON grades.id = sections.grade_id
        INNER JOIN advisories ON advisories.section_id = sections.id
        INNER JOIN users AS adviser ON adviser.id = advisories.user_id
        WHERE requirements.added_from_id = '".$added_from_id."' AND requirements.requirements = '".$payable_id."'
        ORDER BY requirements.id ASC";
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

        $sql = "SELECT requirements.id, payables.amount AS payable_amount, fees.payable, fees.payment_method AS fee_payment_method, requirements.payment_method, requirements.reference_number, requirements.amount FROM requirements 
                INNER JOIN payables ON payables.id = requirements.requirements
                INNER JOIN fees ON fees.id = payables.fee_id
                WHERE requirements.id = '".$id."'";
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
        $payment_method = $param['payment_method'];
        $reference_number = $param['reference_number'];
        $amount = $param['amount'];
        $data = array();

        $sql = "UPDATE requirements 
                SET payment_method = '".$payment_method."', reference_number = '".$reference_number."', amount = '".$amount."'
                WHERE id = '".$id."'";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this student payment."
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
        SET status = '".$status."' WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully cleared this student."
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

}