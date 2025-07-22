<?php
include_once '../config/db_connect.php';

$deletestudent = $_POST['deletestudent'] ?? 'false';
$regno = $_POST['regno'] ?? null;

$success = false;

if ($deletestudent === 'true' && $regno !== null) {
    function deleteFromTable($conn, $table, $column, $regno) {
        $stmt = $conn->prepare("DELETE FROM $table WHERE $column = ?");
        if (!$stmt) return false;

        $stmt->bind_param("s", $regno);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    $success = 
        deleteFromTable($conn, 'student_extracurriculars', 'Student_Rollno', $regno) &&
        deleteFromTable($conn, 'student_academics', 'Student_Rollno', $regno) &&
        deleteFromTable($conn, 'student_personal', 'Student_Rollno', $regno) &&
        deleteFromTable($conn, 'users', 'Login_id', $regno);
}

echo json_encode(["success" => $success]);
?>
