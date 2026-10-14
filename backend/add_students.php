<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Allow: POST");

    http_response_code(405);

    echo json_encode([
        "success"=>false,
        "data"=>"Only POST requests are allowed."
    ]);

    exit;
}

$input = json_decode(
    file_get_contents("php://input"),
    true
);

if(!is_array($input)){
    http_response_code(400);

    echo json_encode([
        "success"=>false,
        "data"=>"Invalid JSON body."
    ]);

    exit;
}

$name = trim($input["name"] ?? "");
$email = trim($input["email"] ?? "");
$course = trim($input["course"] ?? "");

if(empty($name) || empty($email) || empty($course)){
    http_response_code(422);

    echo json_encode([
        "success"=>false,
        "data"=>"Name, email and course are required."
    ]);

    exit;
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    http_response_code(422);

    echo json_encode([
        "success"=>false,
        "data"=>"Enter a valid email."
    ]);

    exit;
}



try{
    $dbcon = new DbConnector();
    $con = $dbcon->getConnection();

    $sql = "INSERT INTO students (name, email, course) VALUES (?,?,?)";

    $pstmt = $con->prepare($sql);
    $check = $pstmt->execute([
                $name,
                $email,
                $course
            ]);

    if($check){
        http_response_code(201);

        echo json_encode([
            "success"=>true,
            "data"=>"Student added successfully.",
            "id"=>(int) $con->lastInsertId()
        ]);

        exit;
    }
}
catch(PDOException $e){
    error_log($e->getMessage());

    if($e->getCode() == "23000"){
        http_response_code(409);

        echo json_encode([
            "success"=>false,
            "data"=>"Email already exists."
        ]);

        exit;
    }

    http_response_code(500);

        echo json_encode([
            "success"=>false,
            "data"=>"Unable to add student."
        ]);

}

?>