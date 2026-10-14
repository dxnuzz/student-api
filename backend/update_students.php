<?php

header("Content-Type: application/json");

require_once "db.php";

if($_SERVER["REQUEST_METHOD"]!=="PUT"){
    header("Allow: PUT");

    http_response_code(405);

    echo json_encode([
        "error"=>"Only PUT requests are allowed."
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

$id = filter_var(
    $data["id"] ?? null,
    FILTER_VALIDATE_INT
);

$name = trim($data["name"] ?? "");
$email = trim($data["email"] ?? "");
$course = trim($data["course"] ?? "");

if($id === false || $id === null || $id < 1 || $name === "" || $email === "" || $course === ""){
    http_response_code(400);

    echo json_encode([
        "error"=>"ID, name, email and course fields are required."
    ]);

    exit;
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    http_response_code(400);

    echo json_encode([
        "error"=>"Enter a valid email."
    ]);

    exit;
}

try{
    $dbcon = new DbConnector();
    $con = $dbcon->getConnection();

    $sql = "UPDATE students SET name=:name, email=:email, course=:course WHERE id=:id";

    $pstmt = $con->prepare($sql);

    $pstmt->execute([
        "name"=>$name,
        "email"=>$email,
        "course"=>$course,
        "id"=>$id
    ]);

    if($pstmt->rowCount() === 0){
        $sql2 = "SELECT id FROM students WHERE id=:id";
        $check = $con->prepare($sql2);

        $check->execute([
            "id"=>$id
        ]);
        
        if(!$check->fetch()){
            http_response_code(404);

            echo json_encode([
                "error"=>"Student not found."
            ]);

            exit;
        }

    }

    http_response_code(200);

    echo json_encode([
        "message"=>"Student updated successfully."
    ]);

    exit;
}
catch (PDOException $e) {

    error_log($e->getMessage());

    if ($e->getCode() === "23000") {
        http_response_code(409);

        echo json_encode([
            "error" => "This email address may already exist."
        ]);
    } else {
        http_response_code(500);

        echo json_encode([
            "error" => "Could not update student."
        ]);
    }
}



?>