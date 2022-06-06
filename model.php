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

   



    public function fetch_tpn()
    {
        $data = [];

        $query =  "SELECT DISTINCT TABLE_NAME
        FROM INFORMATION_SCHEMA.TABLES
        WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='wordlabdatabase' ORDER BY TABLE_NAME";
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

        $query = "SELECT * FROM INFORMATION_SCHEMA.TABLES";
        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
        }

        return $data;
    }

  

  

    public function fetch_filter($tpn)
    {
      
        $data = [];

        $query = "SELECT month, COUNT(CASE WHEN STATUS = 'Fail' THEN 1 END) / COUNT(id) * 100 AS 'FAIL',
        COUNT(CASE WHEN STATUS = 'Pass' THEN 1 END) / COUNT(id) * 100 AS 'PASS' FROM $tpn GROUP BY month";
        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
        }

        return $data;
    }


   

  
}