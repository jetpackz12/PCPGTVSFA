<?php

class assigneeModel extends model
{
    private $con;

    public function __construct()
    {
        $db = new database();
        $this->con = $db->connection();
    }

    public function index()
    {
        $data = array();

        $sql = "SELECT faculties.id, users.image_path, CONCAT(users.fname, ' ', users.mname, ' ', users.lname) AS faculty_fullname, faculties.subjects, users.multi_role FROM faculties
        INNER JOIN users ON users.id = faculties.user_id";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->con->close();
        return $data;
    }

    public function store($param = array())
    {
    }

    public function edit($param = array())
    {
    }

    public function update($param = array())
    {
    }

    public function delete($param = array())
    {
    }
}
