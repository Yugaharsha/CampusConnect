<?php
include_once '../config/db_connect.php';

if (!isset($_SESSION['login_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
$department = $_POST['department'] ?? 'all';
$section = $_POST['section'] ?? 'all';
$year = $_POST['year'] ?? 'all';

$whereClauses = [];

if ($department !== 'all') {
    $whereClauses[] = "UPPER(SUBSTRING(users.Login_id, 3, 3)) = '" . strtoupper($department) . "'";
}
if ($section !== 'all') {
    $whereClauses[] = "SUBSTRING(users.Login_id, 6, 1) = '" . strtoupper($section) . "'";
}
if ($year !== 'all') {
    // Convert academic year back to batch year (assuming 1st year = current year - 0)
    $yearMapping = ['I' => 0, 'II' => 1, 'III' => 2, 'IV' => 3];
    $batchYear = date("Y") - $yearMapping[$year];
    $loginPrefix = substr($batchYear, 2); // Last 2 digits
    $whereClauses[] = "SUBSTRING(users.Login_id, 1, 2) = '" . $loginPrefix . "'";
}

$whereSQL = '';
if (!empty($whereClauses)) {
    $whereSQL = 'WHERE ' . implode(' AND ', $whereClauses);
}

$query = "
    SELECT 
        users.Login_id AS RegNo,
        student_personal.Student_Name AS Name,
        student_personal.Student_Profile_Pic AS Photo,
        UPPER(SUBSTRING(users.Login_id, 3, 3)) AS Department,
        SUBSTRING(users.Login_id, 6 , 1) AS Section,
        SUBSTRING(users.Login_id, 1, 2) AS Year
    FROM users
    JOIN student_personal ON users.Login_id = student_personal.Student_Rollno
    $whereSQL
";

$result = mysqli_query($conn, $query);

$students = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['Year'] = getAcademicYear($row['Year']);
    $students[] = $row;
}

function getAcademicYear($year) {
    $admissionYear = intval("20" . $year);
    $currentYear = date("Y");
    $diff = $currentYear - $admissionYear + 1;

    switch ($diff) {
        case 1: return "I";
        case 2: return "II";
        case 3: return "III";
        case 4: return "IV";
        default: return "-";
    }
}


header('Content-Type: application/json');
echo json_encode($students);
?>
