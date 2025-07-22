<?php
include_once '../config/db_connect.php';

$deletesheet = $_POST['deletesheet'] ?? 'false';
$department = $_POST['department'] ?? 'all';
$section = $_POST['section'] ?? 'all';
$year = $_POST['year'] ?? 'all';

$success = false; 

$whereClauses = [];

if ($deletesheet === 'true') {

    if ($department !== 'all') {
        $whereClauses[] = "UPPER(SUBSTRING(Login_id, 3, 3)) = '" . strtoupper($department) . "'";
    }
    if ($section !== 'all') {
        $whereClauses[] = "SUBSTRING(Login_id, 6, 1) = '" . strtoupper($section) . "'";
    }
    if ($year !== 'all') {
        $yearMapping = ['I' => 0, 'II' => 1, 'III' => 2, 'IV' => 3];
        $batchYear = date("Y") - $yearMapping[$year];
        $loginPrefix = substr($batchYear, 2);
        $whereClauses[] = "SUBSTRING(Login_id, 1, 2) = '" . $loginPrefix . "'";
    }

    $whereSQL = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

    // First get list of regnos to delete
    $regnos = [];
    $fetch = "SELECT Login_id FROM users $whereSQL";
    $res = mysqli_query($conn, $fetch);
    while ($row = mysqli_fetch_assoc($res)) {
        $regnos[] = $row['Login_id'];
    }

    if (empty($regnos)) {
        echo json_encode(["success" => false, "message" => "No matching records found."]);
        exit;
    }

    // Delete from all tables
    $tables = ['student_personal', 'student_academics', 'student_extracurriculars', 'users'];

    foreach ($tables as $table) {
        $col = ($table === 'users') ? 'Login_id' : 'Student_Rollno';

        foreach ($regnos as $regno) {
            $stmt = $conn->prepare("DELETE FROM $table WHERE $col = ?");
            $stmt->bind_param("s", $regno);
            if (!$stmt->execute()) {
                $success = false;
                break 2;
            }
        }
    }
}

echo json_encode(["success" => $success]);
?>
