<?php

namespace Config\Conn;

use \PDO;

class Sql extends PDO
{
    private $conn;

    public function __construct()
    {
        $servername = $_ENV['SERVERNAME'];
        $username = $_ENV['USERNAME'];
        $password = $_ENV['PASSWORD'];
        $dbname = $_ENV['DBNAME'];
        $port = $_ENV['PORTA'];

        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        
        try{
            $this->conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname",$username,$password, $options);
            $this->conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e){
            echo "Connection failed: " . $e -> getMessage();
        }

    }

    public function find(string $table, string $params = "", $campos = " * ")
    {
        try {
            $query = "SELECT $campos FROM $table $params;";
            $stmt = $this->conn->query($query); 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            return [
                "error" => true,
                "message" => "Erro de consulta no banco de dados",
                "Throw" => $th
            ];
        }
    }
}

