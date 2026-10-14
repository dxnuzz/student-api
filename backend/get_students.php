<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

try{
    $dbcon = new DbConnector();
    $con = $dbcon->getConnection();

    $q = "SELECT * FROM students ORDER BY id DESC";

    $pstmt = $con->prepare($q);
    $pstmt->execute();

    $students = $pstmt->fetchAll();
    
    echo json_encode([
        "success"=>true,
        "data"=>$students
    ]);

}
catch(PDOException $e){
    error_log($e->getMessage());

    http_response_code(500);

    echo json_encode([
        "success"=>false,
        "data"=>"Failed to load the students"
    ]);

}


?>