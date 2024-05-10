<?php

class facultyModel extends model
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
        $user_id = $param['teacher'];
        $check_all = $param['check_all'];
        $subjects = $param['subject'];
        $arr_subjects = implode(",", $subjects);
        $created_at = date('Y-m-d H:i:s');
        $data = array();

        $sql = "SELECT user_id FROM faculties WHERE user_id = '" . $user_id . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $data = array(
                'response' => '0',
                'message' => "Failed, Teacher has already assign subjects."
            );

            return $data;
        }

        if ($check_all == 1) {

            $find_in_set_clauses = array_map(function ($id) {
                return "FIND_IN_SET('$id', subjects) > 0";
            }, $subjects);

            $findInSetSql = implode(' OR ', $find_in_set_clauses);
            $sql = "SELECT * FROM faculties WHERE $findInSetSql";
            $result = $this->con->query($sql);
            if ($result->num_rows > 0) {
                $data = array(
                    'response' => '0',
                    'message' => "Failed, Can't be assign all subjects to current teacher please check subject assignee."
                );

                return $data;
            }

            $arr_subjects = implode(',', array_map(function ($id) {
                return (int) $id;
            }, $subjects));

            $sql = "SELECT user_id FROM faculties WHERE subjects IN ($arr_subjects)";
            $result = $this->con->query($sql);
            if ($result->num_rows > 0) {
                $data = array(
                    'response' => '0',
                    'message' => "Failed, Teacher has already assign subjects."
                );

                return $data;
            }

            $sql = "UPDATE subjects SET is_assign = 1 WHERE id IN ($arr_subjects)";
            $this->con->query($sql);
        }

        $sql = "INSERT INTO faculties (user_id, subjects, created_at) 
        VALUES('" . $user_id . "','" . $arr_subjects . "','" . $created_at . "')";

        if ($this->con->query($sql) === TRUE) {
            $sql = "SELECT multi_role FROM users WHERE id = '" . $user_id . "'";
            $result = $this->con->query($sql);
            $row = $result->fetch_assoc();
            $multi_role = $row['multi_role'];
            $multi_role .= ",5";

            $sql = "UPDATE users SET multi_role = '" . $multi_role . "'
            WHERE id = '" . $user_id . "'";
            if ($this->con->query($sql) === TRUE) {
                $data = array(
                    'response' => '1',
                    'message' => "Success, You have successfully add new faculty member."
                );
            }
        } else {
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

        $sql = "SELECT * FROM faculties
        WHERE id = '" . $id . "'";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        }

        $this->con->close();
        return $data;
    }

    public function update($param = array())
    {
        $id = $param['id'];
        $check_all = $param['check_all'];
        $old_subjects = explode(',', $param['old_subjects']);
        $user_id_old = $param['teacher_old'];
        $user_id = $param['teacher'];
        $subjects = $param['subject'];
        $arr_subjects = implode(",", $subjects);
        $data = array();

        if ($user_id != $user_id_old) {
            $sql = "SELECT user_id FROM faculties WHERE user_id = '" . $user_id . "'";
            $result = $this->con->query($sql);
            if ($result->num_rows > 0) {
                $data = array(
                    'response' => '0',
                    'message' => "Failed, This faculty member has already assign subjects."
                );

                return $data;
            }
        }

        $arr_old_subjects = implode(',', array_map(function ($id) {
            return (int) $id;
        }, $old_subjects));

        $sql = "UPDATE subjects SET is_assign = 0 WHERE id IN ($arr_old_subjects)";
        $this->con->query($sql);


        if ($check_all == 1) {

            $find_in_set_clauses = array_map(function ($ids) use ($id) {
                return "FIND_IN_SET('$ids', subjects) > 0 AND id != $id";
            }, $subjects);

            $findInSetSql = implode(' OR ', $find_in_set_clauses);
            $sql = "SELECT * FROM faculties WHERE $findInSetSql";
            $result = $this->con->query($sql);
            if ($result->num_rows > 0) {
                $data = array(
                    'response' => '0',
                    'message' => "Failed, Can't be assign all subjects to current teacher please check subject assignee."
                );

                return $data;
            }

            $arr_new_subjects = implode(',', array_map(function ($id) {
                return (int) $id;
            }, $subjects));

            $sql = "UPDATE subjects SET is_assign = 1 WHERE id IN ($arr_new_subjects)";
            $this->con->query($sql);
        } else {

            $sql = "SELECT * FROM subjects WHERE id IN ($arr_subjects) AND is_assign = 1";
            $result = $this->con->query($sql);
            if ($result->num_rows > 0) {
                $data = array(
                    'response' => '0',
                    'message' => "Failed, Subjects cannot be assign to current teacher please check subject assignee."
                );

                return $data;
            }

            $sql = "UPDATE subjects SET is_assign = 0 WHERE id IN ($arr_old_subjects)";
            $this->con->query($sql);
        }

        $sql = "UPDATE faculties 
                SET user_id = '" . $user_id . "', subjects = '" . $arr_subjects . "'
                WHERE id = '" . $id . "'";

        if ($this->con->query($sql) === TRUE) {
            $data = array(
                'response' => '1',
                'message' => "Success, You have successfully update this faculty member."
            );
        } else {
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
        $subjects = explode(',', $param['subjects']);
        $user_id = $param['user_id'];
        $added_from_id = '2';
        $data = array();

        $sql = "DELETE FROM faculties WHERE id = '" . $id . "'";
        if ($this->con->query($sql) === TRUE) {
            $sql = "DELETE FROM requirements 
            WHERE teacher_id = '" . $id . "' AND added_from_id = '" . $added_from_id . "'";
            if ($this->con->query($sql) === TRUE) {
                $sql = "SELECT multi_role FROM users WHERE id = '" . $user_id . "'";
                $result = $this->con->query($sql);
                $row = $result->fetch_assoc();
                $arr_multi_role = explode(",", $row['multi_role']);
                $i = 0;
                while ($i < count($arr_multi_role)) {
                    if ($arr_multi_role[$i] == "5") {
                        array_splice($arr_multi_role, $i, 1);
                    }
                    $i++;
                }
                $arr_multi_role = implode(",", $arr_multi_role);

                $sql = "UPDATE users SET multi_role = '" . $arr_multi_role . "'
                WHERE id = '" . $user_id . "'";
                $this->con->query($sql);

                $arr_subjects = implode(',', array_map(function ($id) {
                    return (int) $id;
                }, $subjects));

                $sql = "UPDATE subjects SET is_assign = 0 WHERE id IN ($arr_subjects)";
                if ($this->con->query($sql) === TRUE) {
                    $data = array(
                        'response' => '1',
                        'message' => "Success, You have successfully delete this faculty member."
                    );
                }
            }
        } else {
            $data = array(
                'response' => '0',
                'message' => "Failed, "  . $sql . "<br>" . $this->con->error
            );
        }

        $this->con->close();
        return $data;
    }
}
