<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

$connect = mysqli_connect('localhost', 'root', '', 'db_belajar');

if (!$connect) {
    http_response_code(500);
    echo json_encode(['status' => 'Error', 'msg' => 'Failed to connect to database.']);
    exit();
}
?>
