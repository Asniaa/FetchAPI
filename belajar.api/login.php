<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'connection.php';
$method =$_SERVER['REQUEST_METHOD'];
if ($method !== 'POST'){
    http_response_code(response_code:400);
    echo 'ONLY POST method is allowed.';
    exit();
}

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

$username = $data['username'];
$password = sha1($data['password']);

$response = [];
$sql = mysqli_query($connect, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
$numRows = mysqli_num_rows($sql); //mendapatkan jumlah data dari sebuah query

if ($numRows > 0){
    $row = mysqli_fetch_assoc($sql);
    $response = $row;

    echo json_encode(['status' => 'success', 'msg' => 'user found', 'data' => $response]);
} else {
     echo json_encode(['status' => 'fail', 'msg' => 'user not found', 'data' => $response]);
}
?>