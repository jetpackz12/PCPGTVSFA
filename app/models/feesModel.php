<?php

class feesModel extends model
{
    private $con;

    public function __construct(){
        $db = new database();
        $this->con = $db->connection();
    }

    public function index() {
        $data = array();

        $sql = "SELECT * FROM fees";
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
        $payable = $param['payable'];
        $payment_method = implode(",", $param['pay_method']);
        $created_at = date('Y-m-d H:i:s');
        $data = array();

        $sql = "SELECT payable FROM fees WHERE payable = '".$payable."'";
        $result = $this->con->query($sql);
        if($result->num_rows > 0)
        {
            $data = array(
                'response' => '0',
                'message' => "Failed, Payable is already exist."
            );

            return $data;
        }

        $sql = "INSERT INTO fees (payable, payment_method, created_at) 
        VALUES('".$payable."','".$payment_method."','".$created_at."')";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully add new fee."
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

        $sql = "SELECT * FROM fees WHERE id = '".$id."'";
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
        $payable = $param['payable'];
        $payment_method = implode(",", $param['pay_method']);
        $data = array();

        $sql = "UPDATE fees 
                SET payable = '".$payable."', payment_method = '".$payment_method."'
                WHERE id = '".$id."'";

        if($this->con->query($sql) === TRUE)
        {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this fee."
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
        $added_from_id = '3';
        $data = array();

        $sql = "SELECT id FROM payables WHERE fee_id = '".$id."'";
        $result = $this->con->query($sql);
        $row = $result->fetch_assoc();

        $sql = "DELETE FROM fees WHERE id = '".$id."'";
        if($this->con->query($sql) === TRUE)
        {
            $sql = "DELETE FROM payables WHERE id = '".$row['id']."'";
            if($this->con->query($sql) === TRUE)
            {
                $sql = "DELETE FROM requirements 
                        WHERE added_from_id = '".$added_from_id."' AND requirements = '".$row['id']."'";
                if($this->con->query($sql) === TRUE)
                {
                    $data = array(
                        'response' => '1',
                        'message' => "Success, You have successfully delete this payable."
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