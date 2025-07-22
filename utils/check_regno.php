<?php
include_once '../config/db_connect.php';
header('Content-Type: application/json');

$regno = $_POST['regno'] ?? '';

$stmt = $conn->prepare("SELECT 1 FROM student_personal WHERE Student_Register_Numbe = ?");
$stmt->bind_param("s", $regno);
$stmt->execute();
$stmt->store_result();

$response['exists'] = $stmt->num_rows > 0;

$stmt->close();
$conn->close();

echo json_encode($response);
?>
