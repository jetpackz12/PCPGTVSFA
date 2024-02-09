<?php

class database{

	private $hostname = "localhost";
	private $username = "root";
	private $password = "";
	private $database_name = "clearance_db"; // palihug ko change ani....

	private $conn;

	
	public function connection() {
		date_default_timezone_set("Asia/Manila");
		$this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database_name);

		if ($this->conn->connect_error){
			echo 'Failed to connect to MySQL '. mysqli_connect_error();
		}
		else{
			mysqli_select_db($this->conn, $this->database_name);
			$this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database_name);
			return $this->conn;
		}
	}

}
	
?>