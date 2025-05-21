<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'connection.php';

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

$name = $data['student_name'] ?? '';
$no = $data['student_no'] ?? '';
$class = $data['student_class'] ?? '';

if (empty($name) || empty($no) || empty($class)) {
    http_response_code(400);
    echo json_encode(['status' => 'Error', 'msg' => 'Data tidak lengkap']);
    exit();
}

$stmt = $connect->prepare("INSERT INTO students (student_no, student_name, student_class) VALUES (?, ?, ?)");
if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['status' => 'Error', 'msg' => 'Failed to prepare SQL statement']);
    exit();
}

$stmt->bind_param("sss", $no, $name, $class);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['status' => 'Error', 'msg' => 'Failed to insert data']);
    exit();
}

$insertedId = $stmt->insert_id;

header('Content-Type: application/json');
echo json_encode([
    'status' => 'OK',
    'msg'    => 'Data has been created successfully.',
    'inserted_id' => $insertedId
]);

$stmt->close();
?>
