<?php
// models/Database.php
require_once 'vendor/autoload.php';
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        // Load environment variables inside the constructor
        $this->host = "localhost";
        $this->db_name = "galaxify";
        $this->username = "root";
        $this->password = "root";
    }

    public function getConnection(): mysqli {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $this->conn;
    }
}