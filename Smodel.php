<?php

class Model
{
    private $server = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "wordlabdatabase";
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new mysqli($this->server, $this->username, $this->password, $this->db);
        } catch (\Throwable $th) {
         
            echo "Connection error " . $th->getMessage();
        }
    }

   
   

    public function fetch_Syrs()
    {
        $data = [];

        $query = "SELECT DISTINCT `year` FROM `student_crud` ORDER BY `year` ASC";
        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
        }

        return $data;
    }

   

    public function fetch()
    {
        $data = [];

        $query = "SELECT * FROM student_crud";
        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
        }

        return $data;
    }

  

    public function fetch_filter($Syrs)
    {
        $data = [];

        $query = "SELECT * FROM student_crud WHERE year = '$Syrs' ";
        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
        }

        return $data;
    }


   

    public function fetch_Syrs_filter($Syrs)
    {
        $data = [];

        $query = "SELECT * FROM student_crud WHERE year = '$Syrs'";
        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
        }

        return $data;
    }
}