<?php
include_once '../config/db_connect.php';

if (!isset($_SESSION['login_id'])) {
    header("Location:../auth/login.php");
    exit();
}
function userExists($conn, $loginId) {
    $stmt = $conn->prepare("SELECT 1 FROM users WHERE Login_Id = ?");
    $stmt->bind_param("s", $loginId);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //  Manual Entry
    if (isset($_POST['login_id'], $_POST['password'], $_POST['role'])) {
        $loginId = strtoupper(trim($_POST['login_id']));
        $password = strtoupper(trim($_POST['password']));
        $role = strtolower(trim($_POST['role']));

        if (userExists($conn, $loginId)) {
            echo "<p style='color:red;'>User '$loginId' already exists.</p>";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (Login_Id, Password, Role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $loginId, $password, $role);

            if ($stmt->execute()) {
                // echo "<p style='color:green;'>User '$loginId' added successfully.</p>";
                //refresh the page
                header("Refresh:0");
            
            } else {
                // echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
                 header("Refresh:0");
            }

            $stmt->close();
        }
    }

    // Upload via Excel/CSV
    if (isset($_FILES['user_file']['name'])) {
        require '../vendor/autoload.php';
        $fileTmp = $_FILES['user_file']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['user_file']['name'], PATHINFO_EXTENSION));
        $users = [];

        if ($ext === 'csv') {
            if (($handle = fopen($fileTmp, 'r')) !== false) {
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    $users[] = $data;
                }
                fclose($handle);
            }
        } elseif ($ext === 'xls' || $ext === 'xlsx') {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileTmp);
            $sheet = $spreadsheet->getActiveSheet();
            $users = $sheet->toArray();
        }

        $added = 0;
        $skipped = 0;

        foreach ($users as $index => $user) {
            // Skip header row if present
            if ($index === 0 && strtolower($user[0]) === 'login_id') continue;

            $loginId = strtoupper(trim($user[0] ?? ''));
            $password = strtoupper(trim($user[1] ?? ''));
            $role = strtolower(trim($user[2] ?? 'student'));

            if ($loginId === '' || $password === '' || $role === '') {
                continue; // skip incomplete rows
            }

            if (!userExists($conn, $loginId)) {
                $stmt = $conn->prepare("INSERT INTO users (Login_Id, Password, Role) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $loginId, $password, $role);
                $stmt->execute();
                $stmt->close();
                $added++;
            } else {
                $skipped++;
            }
        }

        // echo "<p style='color:green;'>$added users added successfully.</p>";
         header("Refresh:0");
        
        if ($skipped > 0) {
            // echo "<p style='color:blue;'>$skipped users skipped (already exists).</p>";
         header("Refresh:0");
        }
    }
}
?>


<style>
    body {
        font-family: sans-serif;
        padding: 20px;
        background-color: #f9f9f9;
    }

    h2 {
        color: #333;
        margin-top: 30px;
    }

    form {
        background-color: #fff;
        padding: 15px;
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        max-width: 400px;
    }

    label {
        display: block;
        margin-top: 10px;
    }

    input[type="text"],
    select,
    input[type="file"] {
        width: 100%;
        padding: 6px;
        margin-top: 5px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        margin-top: 15px;
        padding: 8px 16px;
        background-color: rgb(95, 158, 164);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: rgb(95, 158, 164);
    }

    p {
        margin-top: 10px;
        font-weight: bold;
    }
</style>
<center>
<h2>Add Users (Manual Entry)</h2>
<form action="store_users.php" method="POST">
    <label>Login ID:</label>
    <input type="text" name="login_id" required><br><br>
    
    <label>Password:</label>
    <input type="text" name="password" required><br><br>

    <label>Role:</label>
    <select name="role" required>
        <option value="student">Student</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <input type="submit" value="Add User">
</form>

<h2>Upload Users via Excel/CSV</h2>
<form action="store_users.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="user_file" accept=".csv, .xls, .xlsx" required><br><br>
    <input type="submit" name="upload_users" value="Upload Users">
</form>
</center>