<?php

include_once '../config/db_connect.php';


if (!isset($_SESSION['login_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$query = "SELECT 
            users.Login_id AS RegNo,
            student_personal.Student_Name AS Name,
            student_personal.Student_Profile_Pic AS Photo,
            UPPER(SUBSTRING(users.Login_id, 3, 3)) AS Department,
            SUBSTRING(users.Login_id, 6 , 1) AS Section,
            SUBSTRING(users.Login_id, 1, 2) AS Year
        FROM  
            users
        JOIN 
            student_personal ON users.Login_id = student_personal.Student_Rollno;
        ";

$result = mysqli_query($conn, $query);

function getAcademicYear($year) {
    //22CSEB03  - IV

    $admissionYear = intval("20" . substr($year, 0, 2));
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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Management</title>
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <style>

        body {
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            background-color:  rgb(95, 158, 164);
            color: white;
            padding: 20px;
            position: fixed;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar h3, .sidebar h2 {
            margin-bottom: 15px;
        }
        .sidebar a {
            display: block;
            color: black;
            padding: 10px;
            background:  rgba(255, 255, 255, 1);
            margin-bottom: 10px;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar select,
        .sidebar button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
        }

        .sidebar select {
            background: white;
            color: #333;
            font-weight: bold;
        }

        button {
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #d1d5db;
        }

        .content {
            margin-left: 270px;
            padding: 30px;
        }


        input[type="text"] {
            padding: 8px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            width: 100%;
        }

        .logout a {
            background: #dc2626;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .logout a:hover {
            background: #b91c1c;
        }

        .edit-btn,
        .delete-btn{
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 13px;
            transition: 0.2s;
        }

        .edit-btn:hover,
        .delete-btn:hover {
            opacity: 0.9;
        }

        img {
            max-width: 60px;
            max-height: 60px;
        }

        .content {
            margin-left: 300px;
            padding-top: 120px;
            
        }

        .table {
            width: 100%;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color:rgb(95, 158, 164);
            color: white;
            padding: 12px;
        }

        .table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }            
       
        .table tr{
            cursor: pointer;
        }
        .top-bar {
            position: fixed;
            background-color: white;
            padding: 20px 30px;
            margin-left : 290px;
            width: 81%;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .fulledit{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }
        .delete-student{
            background-color:rgb(95, 158, 164);
            color: white;
            padding: 12px;
            border : none;
        }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <h3>Student Actions</h3>
        <a class="add-student" href="../utils/store_users.php">➕ Add Student</a>

        <div class="filter">
            <h2>Filters</h2>
            <div class="category-label">Department</div>
            <select id="department">
                <option value="all" selected>All Departments</option>
                <option value="CSE">CSE</option>
                <option value="IT">IT</option>
                <option value="ECE">ECE</option>
                <option value="EEE">EEE</option>
                <option value="MECH">MECH</option>
                <option value="CIV">CIV</option>
            </select>

            <div class="category-label">Section</div>
            <select id="section">
                <option value="all" selected>All Sections</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>

            <div class="category-label">Year</div>
            <select id="year">
                <option value="all" selected>All Years</option>
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
                <option value="IV">IV</option>
            </select>
        </div>
        <br>        
        <div class="bulkdel">
            <button id="deletesheet">Delete All</button>            
        </div>  
        <div class="logout">
            <button onclick="window.location.href='../auth/logout.php'">Logout</button>
        </div>
    </div>
        <div class="top-bar">
            <input type="text" id="searchInput" placeholder="Search students..." onkeyup="searchStudents()" style="width: 500px;height: 30px">           
     </div>
    <div class="content">
        <table class="table">
            <thead class="tabledark">
                <tr>
                    <th>Photo</th>
                    <th>RollNo</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Section</th>
                    <th>Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="studentTable">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr data-regno="<?= $row['RegNo']; ?>" onclick = "window.location='../student/Student_View.php?value=<?= $row['RegNo']; ?>'">
                    <td><img src = "../uploads/<?= $row['Photo']; ?>" alt="Profile Picture" style="max-width: 150px; max-height: 150px;"></td>
                    <td class="editable regNo"><?= $row['RegNo']; ?></td>
                    <td class="editable name"><?= $row['Name']; ?></td>
                    <td class="editable department"><?= $row['Department']; ?></td>
                    <td class="editable section"><?= $row['Section']; ?></td>
                    <?php $academicYear = getAcademicYear($row['Year']); ?>                          
                    <td class="editable year"><?= $academicYear ?></td>                  
                    <td><button class="delete-student" onclick="event.stopPropagation(); deleteStudent(this);">Delete</button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<script>
    
    const table = document.getElementById("studentTable");

     function searchStudents() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = table.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                let row = rows[i];
                const cells = row.getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                    if (cell) {
                        if (cell.textContent.toLowerCase().indexOf(input) > -1) {
                        found = true;
                        break;
                        }
                    }
                }
                if (found) {
                row.style.display = "";
                } else {
                row.style.display = "none";
                }
            }
        }

document.addEventListener("DOMContentLoaded", function () {
    
        const departmentFilter = document.getElementById("department");
        const sectionFilter = document.getElementById("section");
        const yearFilter = document.getElementById("year");

        // Function to fetch and update the table
        function fetchFilteredData() {
            const department = departmentFilter.value;
            const section = sectionFilter.value;
            const year = yearFilter.value;

            fetch("../utils/Fetch_Students.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `department=${department}&section=${section}&year=${year}`
            })
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById("studentTable");
                tableBody.innerHTML = ""; 

                if (data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="6">No students found</td></tr>`;
                    return;
                }

                data.forEach(student => {
                    const row = document.createElement("tr");
                    row.setAttribute("data-regno", student.RegNo);
                    row.setAttribute("onclick", `window.location='../student/Student_View.php?value=${student.RegNo}'`);

                    row.innerHTML = `
                        <td><img src="../uploads/${student.Photo}" alt="Profile Picture" style="max-width: 150px; max-height: 150px;"></td>
                        <td class="editable regNo">${student.RegNo}</td>
                        <td class="editable name">${student.Name}</td>
                        <td class="editable department">${student.Department}</td>
                        <td class="editable section">${student.Section}</td>
                        <td class="editable year">${student.Year}</td>
                        <td><button class="delete-student" onclick="event.stopPropagation(); deleteStudent(this);">Delete</button></td>

                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error("Error fetching filtered students:", error);
            });
        }


        //delete the current sheet of students
        const deletesheet = document.getElementById("deletesheet");
        deletesheet.addEventListener("click" , function(){

            if (!confirm("Are you sure you want to delete all the filtered students? This cannot be undone.")) return;

            const department = departmentFilter.value;
            const section = sectionFilter.value;
            const year = yearFilter.value;


            fetch("../utils/Delete_Sheet.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `deletesheet=true&department=${department}&section=${section}&year=${year}`
            })
            .then(response => response.json())
            .then(data => {
                 if (data.success) {
                    alert("Filtered students deleted successfully.");
                    fetchFilteredData();
                 }else{
                    alert("Failed to delete filtered students.");
                 }
            })
            .catch(error => {
                console.error("Error deleting sheet:", error);
            });
        });

        
        departmentFilter.addEventListener("change", fetchFilteredData);
        sectionFilter.addEventListener("change", fetchFilteredData);
        yearFilter.addEventListener("change", fetchFilteredData);
 
});

        
        //delete one student
       function deleteStudent(button) {
            if (!confirm("Are you sure you want to delete this student?")) return;

            const row = button.closest("tr");
            const regno = row.getAttribute("data-regno");

            fetch("../utils/Delete_Student.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `deletestudent=true&regno=${regno}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Student deleted successfully.");
                    row.remove(); 
                } else {
                    alert("Failed to delete student.");
                }
            })
            .catch(error => {
                console.error("Error deleting student:", error);
            });
        }

</script>

</body>
</html>
