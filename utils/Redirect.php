<?php    
   include_once '../config/db_connect.php';

    if (!isset($_SESSION['login_id'])) {
        header("Location: ../auth/login.php");
        exit();
    }
    
    if (isset($_GET['value'])) {
        $roll_no = $_GET['value'];
        echo "Received value: " . htmlspecialchars($value);    
    } 

        echo "<p>Session Login ID: " . $_SESSION['login_id'] . "</p>";
        echo "<p>Roll No Received: " . htmlspecialchars($roll_no) . "</p>";


        $stmt = $conn->prepare("SELECT * FROM student_personal WHERE Student_Rollno = ?");
        $stmt->bind_param("s", $roll_no);
        $stmt->execute();
        $result = $stmt->get_result();
       
        if ($result->num_rows > 0) {
            $stmt->close();
            $conn->close();
            header("Location: ../student/Student_view.php?value=" . urlencode($roll_no)); 
            exit();
        } else {
            $stmt->close();
            $conn->close();
            header("Location: ../index.html?value=" . urlencode($roll_no)); 
            exit();
        }
    
?>