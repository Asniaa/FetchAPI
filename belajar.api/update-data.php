<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(400);
    echo 'Only PATCH method is allowed.';
    exit();
}

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

if (empty($data) || !isset($data['student_id'])) {
    http_response_code(400);
    echo json_encode(['status' => 'Error', 'msg' => 'No student ID provided or invalid data.']);
    exit();
}

$id = $data['student_id'];
$name = $data['student_name'];
$no = $data['student_no'];
$class = $data['student_class'];

$query = "UPDATE students SET student_name = ?, student_no = ?, student_class = ? WHERE student_id = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("sssi", $name, $no, $class, $id);

if ($stmt->execute()) {
    $affected = $stmt->affected_rows;

    header('Content-Type: application/json');
    if ($affected > 0) {
        echo json_encode([
            'status' => 'OK',
            'msg'    => 'Data has been updated successfully.',
            'student_id' => $id
        ]);
    } else {
        echo json_encode([
            'status' => 'Warning',
            'msg'    => 'No data found to update.',
            'student_id' => $id
        ]);
    }
} else {
    http_response_code(500);
    echo json_encode([
        'status' => 'Error',
        'msg'    => 'Failed to update data.'
    ]);
}

$stmt->close();
?>
