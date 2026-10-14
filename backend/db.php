<?php

class DbConnector{
    private $host = "localhost";
    private $dbuser = "root";
    private $dbpwd = "";
    private $dbname = "student_db";

    public function getConnection(){
        $dsn = "mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8mb4";
        try{
            $con = new PDO($dsn, $this->dbuser, $this->dbpwd);

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $con;
        }
        catch(PDOException $e){
            error_log($e->getMessage());

            http_response_code(500);

            header("Content-Type: application/json");

            echo json_encode([
                "error"=>"Database connection failed."
            ]);

            exit;
        }

    }

}

?>