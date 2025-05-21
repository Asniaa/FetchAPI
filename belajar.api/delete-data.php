<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['status' => 'Error', 'msg' => 'Only DELETE method is allowed']);
    exit();
}

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

if (empty($data) || !isset($data['student_id'])) {
    http_response_code(400);
    echo json_encode(['status' => 'Error', 'msg' => 'No student ID provided']);
    exit();
}

$id = intval($data['student_id']);

$query = "DELETE FROM students WHERE student_id = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $affected = $stmt->affected_rows;

    if ($affected > 0) {
        echo json_encode([
            'status' => 'OK',
            'msg' => 'Data has been deleted',
            'deleted_id' => $id
        ]);
    } else {
        echo json_encode([
            'status' => 'Warning',
            'msg' => 'No matching data found',
            'deleted_id' => $id
        ]);
    }
} else {
    http_response_code(500);
    echo json_encode(['status' => 'Error', 'msg' => 'Failed to delete']);
}

$stmt->close();
?>
