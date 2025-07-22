<?php

include_once '../config/db_connect.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_id = $_POST['login_id'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE Login_id = ? AND Password = ?");
    $stmt->bind_param("ss", $login_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $_SESSION['login_id'] = $login_id;
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: ../admin/admin_dashboard.php");
            
        } else if($user['role'] === 'student') {
            header("Location: ../utils/redirect.php?value=" . urlencode($login_id));
        }
        exit();
    } else {
        $error = "Invalid login credentials.";
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" href="../css/Login.css">
    </head>
    <body>
        <header>
            <h1>Velammal College of Engineering and Technology</h1>
            <h3>(Autonomous) Viraganoor, Madurai</h3>
        </header>
        <div class="outer">
            <form action="login.php" method="post" class="one">
                <div class="input-field">
                    <label for="login_id">Login Id:</label>
                    <input type="text" id="login_id" name="login_id" required>
                </div>
                <div class="input-field">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="buttons">
                    <input type="reset" value="Reset">
                    <input type="submit" value="Login">
                </div>
                <?php if (!empty($error)) echo "<p style='color: red; text-align: center;'>$error</p>"; ?>

            </form>
        </div>
    </body>

</html>