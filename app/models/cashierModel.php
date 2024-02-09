<?php

class cashierModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index() {
        $data = array();

        $sql = "SELECT payables.id, fees.payable, fees.payment_method, payables.amount, payables.grades FROM payables
        INNER JOIN fees ON fees.id = payables.fee_id";
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
        $added_from_id = '3';
        $cashier_id = $param['cashier_id'];
        $arr_student_ids = $param['student_ids'];
        $grades = implode(",", $param['grade']);
        $created_at = date('Y-m-d H:i:s');
        $data = array();
        $check = false;
        $last_payable_id = '';

        $sql = "SELECT fee_id FROM payables WHERE fee_id = '".$param['payable']."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Payable is already exist."
            );
            return $data;
        }

        $sql = "INSERT INTO payables (fee_id, amount, grades, created_at)
                VALUES ('".$param['payable']."','".$param['amount']."','".$grades."','".$created_at."')";
        if($this->con->query($sql) === TRUE)
        {
            $last_payable_id = $this->con->insert_id;
            for ($i=0; $i < count($arr_student_ids); $i++) {
                $sql = "INSERT INTO requirements (added_from_id, teacher_id, student_id, requirements, created_at) 
                VALUES('".$added_from_id."','".$cashier_id."','".$arr_student_ids[$i]['id']."','".$last_payable_id."','".$created_at."')";

                if($this->con->query($sql) === TRUE)
                {
                    $check = true;
                }

            }
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Adding payable failed."
            );
        }

        switch ($check) {
            case true:
                    $data = array(
                        'response' => '1',
                        'message' => "Success, You have successfully add new payable."
                    );
                break;
            
            default:
                    if(!empty($last_payable_id))
                    {
                        $sql = "DELETE FROM payables WHERE id = '".$last_payable_id."'";
                        $this->con->query($sql);
                    }

                    $data = array(
                        'response' => '0',
                        'message' => "Failed, Adding payable failed."
                    );
                break;
        }

        $this->con->close();
        return $data;
	}

	public function edit($param = array())
	{
        $id = $param['id'];
        $data = array();

        $sql = "SELECT payables.id, fees.id AS fee_id, fees.payable, fees.payment_method, payables.amount, payables.grades FROM payables
        INNER JOIN fees ON fees.id = payables.fee_id
        WHERE payables.id = '".$id."'";
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
        $added_from_id = '3';
        $id = $param['id'];
        $cashier_id = $param['cashier_id'];
        $arr_student_ids = $param['student_ids'];
        $grades = implode(",", $param['grade']);
        $created_at = date('Y-m-d H:i:s');
        $data = array();
        $check = false;

        $sql = "UPDATE payables 
                SET amount = '".$param['amount']."', grades = '".$grades."' 
                WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {

            $sql = "DELETE FROM requirements 
                    WHERE added_from_id = '".$added_from_id."' AND requirements = '".$id."'";
            $this->con->query($sql);
            

            for ($i=0; $i < count($arr_student_ids); $i++) {
                $sql = "INSERT INTO requirements (added_from_id, teacher_id, student_id, requirements, created_at) 
                VALUES('".$added_from_id."','".$cashier_id."','".$arr_student_ids[$i]['id']."','".$id."','".$created_at."')";

                if($this->con->query($sql) === TRUE)
                {
                    $check = true;
                }

            }
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Adding payable failed."
            );
        }

        if($check)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add new payable."
            );
        }
        else
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Adding payable failed."
            );
        }

        $this->con->close();
        return $data;
	}

	public function delete($param = array())
	{
        $id = $param['id'];
        $added_from_id = '3';
        $data = array();

        $sql = "DELETE FROM payables WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $sql = "DELETE FROM requirements 
                    WHERE added_from_id = '".$added_from_id."' AND requirements = '".$id."'";
            if($this->con->query($sql) === TRUE)
            {
                $data = array(
                    'response' => '1',
                    'message' => "Success, You have successfully delete this payable."
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

	public function get_fee_payment_method($param = array())
	{
        $id = $param['id'];
        $data = array();

        $sql = "SELECT * FROM fees WHERE id = '".$id."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = $result->fetch_assoc();
        }

        $this->con->close();
        return $data;
	}
    
    public function get_student_ids($param = array()) {
        $grade = $param['grade'];
        $data = array();

        $i = 0;
        while ($i < count($grade)) {

            $sql = "SELECT users.`id` FROM `users` 
            INNER JOIN sections ON sections.id = users.section_id
            INNER JOIN grades ON grades.id = sections.grade_id
            WHERE users.role_id = '2' AND grades.id = '".$grade[$i]."'";
            $result = $this->con->query($sql);
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            $i++;
        }

        $this->con->close();
        return $data;
    }

}