<?php
class database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "root";
    private $dbname = "blogostrefa";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function runPreparedQuery($query, $types = "", $params = [])
    {
        $stmt = $this->conn->prepare($query);

        if ($types !== "") {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    public function getConnection()
    {
        return $this->conn;
    }

}
?>
