<?php

namespace Config;

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
            $this->conn -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(\PDOException $e){
            echo "Connection failed: " . $e -> getMessage();
        }

    }

    public function find(string $tabela, array $values = [], string $params = "", string $campos = " * ")
    {
        try {
            $query = "SELECT $campos FROM $tabela $params";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($values);
            return $stmt->fetchAll();
        } catch (\Throwable $th) {
            return [
                "error" => true,
                "message" => "Erro de consulta no banco de dados",
                "Throw" => $th
            ];
        }
    }

    public function store(string $tabela, array $valores, string $campos, string $indexCampos)
    {
        try {
            $query = "INSERT INTO $tabela ($campos) VALUES ($indexCampos)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($valores);
            return [
                "error" => false,
                "message" => "Dados Inseridos com sucesso",
            ];
        } catch (\Throwable $th) {
            return [
                "error" => true,
                "message" => "Erro de consulta no banco de dados",
                "Throw" => $th
            ];
        }
    }

    public function updateItem(string $tabela, array $valores, array $campos, string $params = "", array $indexCampos)
    {
        $strCampos = '';
        foreach($campos as $key => $campo){
            $strCampos .= $campo."=$indexCampos[$key], ";
        }

        $strCampos = rtrim($strCampos, ", ");

        try {
            $query = "UPDATE $tabela SET $strCampos $params";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($valores);
        } catch (\Throwable $th) {
            return [
                "error" => true,
                "message" => "Erro de consulta no banco de dados",
                "Throw" => $th
            ];
        }
    }

    public function delItem(string $tabela, array $data, string $params)
    {
        try {
            $query = "DELETE FROM $tabela WHERE $params";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($data);
            return $stmt->rowCount();
            
        } catch (\Throwable $th) {
            return [
                "error" => true,
                "message" => "Erro de consulta no banco de dados",
                "Throw" => $th
            ];
        }
    }
}