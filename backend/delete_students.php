<?php

header("Content-Type: application/json");

require_once "db.php";

if($_SERVER["REQUEST_METHOD"]!=="DELETE"){
    header("Allow: DELETE");

    http_response_code(405);

    echo json_encode([
        "error"=>"Only DELETE requests are allowed."
    ]);

    exit;
}

$data = json_decode(
    file_get_contents("php://input"),
    true
);

if(!is_array($data)){
    http_response_code(400);

    echo json_encode([
        "error"=>"Invalid JSON data."
    ]);

    exit;
}

$id = filter_var($data["id"] ?? null, FILTER_VALIDATE_INT);

if($id === false || $id === null || $id < 1){
    http_response_code(400);

    echo json_encode([
        "error"=>"Invalid student ID."
    ]);

    exit;
}

try{
    $dbcon = new DbConnector();
    $con = $dbcon->getConnection();

    $sql = "DELETE FROM students WHERE id=:id";

    $pstmt = $con->prepare($sql);
    $pstmt->execute([
        "id"=>$id
    ]);

    if($pstmt->rowCount() === 0){
        http_response_code(404);

        echo json_encode([
            "error"=>"Student not found."
        ]);

        exit;
    }

    http_response_code(200);

    echo json_encode([
        "error"=>"Student deleted successfully."
    ]);

    exit;
}
catch(PDOException $e){
    error_log($e->getMessage());

    http_response_code(500);

        echo json_encode([
            "error"=>"Could not delete student."
        ]);
    
}

?>