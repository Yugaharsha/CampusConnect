   
<?php 
include_once '../config/db_connect.php';
include_once '../utils/lookup_helpers.php'; 

if (!isset($_SESSION['login_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student View</title>

    <link rel="stylesheet" href="../css/view.css">
    <link rel="stylesheet" href="../css/student_view.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    
</head>
<body>
    <header>
        <h1><b>Velammal College of Engineering & Technology</b> <img src="../assets/logo.jpeg" alt="College Logo" width="60" height="60"></h1>
        <a href="../auth/logout.php" >Logout</a>

    </header>
    <h2>Submitted Data</h2>

<?php       

    if (isset($_SESSION['update_success'])) {
        echo "<p class='success'>" . $_SESSION['update_success'] . "</p>";
        unset($_SESSION['update_success']);
    }

    if (isset($_GET['value'])) {
        $rollno = $_GET['value'];


        //Personal details
        $stmt = $conn->prepare("SELECT Student_Rollno, Student_Mailid, Student_Name, Student_Mentor_ID, 
            Student_Gender_ID, Student_DOB, Student_FatherName, Student_Father_PH, Student_Father_Occupation_ID, 
            Student_Father_AnnualIncome, Student_PH, Student_Register_Numbe, Student_MotherName, 
            Student_Mother_PH, Student_Mother_Occupation_ID, Student_Mother_Tongue_ID, Student_Languages_Known, 
            Student_Address, Student_Pincode, Student_Native, Student_Date_Of_Join, Student_Mode_ID, 
            Student_Transport_ID, Student_Aadhar, Student_First_Graduate_ID, Student_Community_ID, 
            Student_Caste, Student_Quota_ID, Student_Scholarship_Name, Student_PhysicallyChallenged_ID, 
            Student_Treatment_ID, Student_Vaccinated_ID,Student_Profile_Pic
            FROM student_personal WHERE Student_Rollno = ?");

        $stmt->bind_param("s", $rollno);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    echo "
                    <div class='container' id='content'>
                        <section>
                            <div class='details'><h3>Personal Details</h3></div>
                            <div class='det'>
                                <div class='input-group'>
                                    <label>Profile Picture:</label>";

                                    $profilePicPath = htmlspecialchars($row['Student_Profile_Pic']);
                                            if ($profilePicPath) {
                                                echo "<img src='../uploads/".$profilePicPath . "' alt='Profile Picture' style='max-width: 150px; max-height: 150px;'>";
                                            } else {
                                                echo "<p>No profile picture available.</p>";
                                            }            
                             echo "
                                </div>                
                                <div class='input-group'>
                                    <label>Name:</label>
                                    <span>" . htmlspecialchars($row['Student_Name']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Aadhar:</label>
                                    <span>" . htmlspecialchars($row['Student_Aadhar']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Email:</label>
                                    <span>" . htmlspecialchars($row['Student_Mailid']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Phone number:</label>
                                    <span>" . htmlspecialchars($row['Student_PH']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Date of Birth:</label>
                                    <span>" . htmlspecialchars($row['Student_DOB']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Gender:</label>
                                    <span>" . getLookupValue($conn,htmlspecialchars($row['Student_Gender_ID'])) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Register number:</label>
                                    <span>9131" . htmlspecialchars($row['Student_Register_Numbe']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Mother Name:</label>
                                    <span>" . htmlspecialchars($row['Student_MotherName']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Phone number:</label>
                                    <span>" . htmlspecialchars($row['Student_Mother_PH']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Mother's Occupation:</label>
                                    <span>" . getLookupValue($conn,htmlspecialchars($row['Student_Mother_Occupation_ID'])) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Father Name:</label>
                                    <span>" . htmlspecialchars($row['Student_FatherName']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Phone number:</label>
                                    <span>" . htmlspecialchars($row['Student_Father_PH']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Father's Occupation:</label>
                                    <span>" . getLookupValue($conn,htmlspecialchars($row['Student_Father_Occupation_ID'])) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Annual Income:</label>
                                    <span>" . number_format(htmlspecialchars($row['Student_Father_AnnualIncome'])) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Mother Tongue:</label>
                                    <span>" . getLookupValue($conn,htmlspecialchars($row['Student_Mother_Tongue_ID'])). "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Languages Known:</label>
                                    <span>" . htmlspecialchars($row['Student_Languages_Known']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Address:</label>
                                    <span>" . htmlspecialchars($row['Student_Address']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Native:</label>
                                    <span>" . htmlspecialchars($row['Student_Native']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Pin code:</label>
                                    <span>" . htmlspecialchars($row['Student_Pincode']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Date of Join:</label>
                                    <span>" . htmlspecialchars($row['Student_Date_Of_Join']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Mode of Study:</label>
                                    <span>" . getLookupValue($conn,htmlspecialchars($row['Student_Mode_ID'])). "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Transport:</label>
                                    <span>". getLookupValue($conn,htmlspecialchars($row['Student_Transport_ID'])) ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>First Graduate:</label>
                                    <span>". getLookupValue($conn,htmlspecialchars($row['Student_First_Graduate_ID'])) ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Quota:</label>
                                    <span>". getLookupValue($conn,htmlspecialchars($row['Student_Quota_ID'])) ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Community:</label>
                                    <span>" . getLookupValue($conn,htmlspecialchars($row['Student_Community_ID'])) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Caste:</label>
                                    <span>" . htmlspecialchars($row['Student_Caste']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Scholarship Name:</label>
                                    <span>" . htmlspecialchars($row['Student_Scholarship_Name']) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Physically Challenged:</label>
                                    <span>" . getLookupValue($conn,htmlspecialchars($row['Student_PhysicallyChallenged_ID'])) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Double Vaccinated:</label>
                                    <span>" . getLookupValue($conn,htmlspecialchars($row['Student_Vaccinated_ID'])) . "</span>
                                </div>
                                <div class='input-group'>
                                    <label>Under any Treatment?</label>
                                    <span>" . getLookupValue($conn,htmlspecialchars($row['Student_Treatment_ID'])). "</span>
                                </div>
                            </div>
                        </section>";
                    }
                } else {
                    echo "<span>No personal data found</span>";
                }
            } else {
                echo "Error: " . $stmt->error;
            }
        
            $stmt->close();


        // academic details
        $stmt = $conn->prepare("SELECT Student_Rollno, Academic_Type_ID, Institution_Name, Register_Number, Mode_Of_Study_ID,
         Mode_Of_Medium_ID, Board_ID, Mark, Mark_Total, Mark_Percentage, Cut_Of_Mark
            FROM student_academics WHERE Student_Rollno = ?");

        $stmt->bind_param("s", $rollno);
        ?>
        <section>
        <div class='details'><h3>Academic</h3></div>
        <?php
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                            <div class='det'>
                                <div class='input-group'>
                                    <label>Academic Type:</label>
                                    <span>". getLookupValue($conn,htmlspecialchars($row['Academic_Type_ID']))."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Institution Name:</label>
                                    <span>". htmlspecialchars($row['Institution_Name']) ."</span>
                                </div>
                                 <div class='input-group'>
                                    <label>Register Number:</label>
                                    <span>". htmlspecialchars($row['Register_Number'])."</span>
                                </div>
                                
                                <div class='input-group'>
                                    <label>Mode Of Study:</label>
                                    <span>". getLookupValue($conn,htmlspecialchars($row['Mode_Of_Study_ID']))  ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Mode Of Medium:</label>
                                    <span>".getLookupValue($conn,htmlspecialchars($row['Mode_Of_Medium_ID']))  ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Board:</label>
                                    <span>". getLookupValue($conn,htmlspecialchars($row['Board_ID'])) ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Marks Obtained:</label>
                                    <span>". htmlspecialchars($row['Mark']) ."</span>
                                </div> 
                                 <div class='input-group'>
                                    <label>Marks Total:</label>
                                    <span>". htmlspecialchars($row['Mark_Total']) ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Percentage:</label>
                                    <span>". htmlspecialchars($row['Mark_Percentage']) ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Cut-Off:</label>
                                    <span>". htmlspecialchars($row['Cut_Of_Mark']) ."</span>
                                </div>
                            </div>";
                        
                    }
                    echo "</section>";
                } else {
                    echo "<span>No academic data found</span>";
                }
            } else {
                echo "Error: " . $stmt->error;
            }
        
            $stmt->close();


        // extra-curricular
        $stmt = $conn->prepare("SELECT Student_Rollno, Student_Hobbies, Student_Programming_Language,
         Student_Others, Student_Interest, Student_DreamCompany,
         Student_Ambition FROM student_extracurriculars WHERE Student_Rollno = ?");


        $stmt->bind_param("s", $rollno);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <section>
                            <div class='details'><h3>Extra-Curricular</h3></div>
                            <div class='det'>
                                <div class='input-group'>
                                    <label>Hobbies:</label>
                                    <span>". htmlspecialchars($row['Student_Hobbies'])."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Programming Courses:</label>
                                    <span>". htmlspecialchars($row['Student_Programming_Language'])."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Other Courses:</label>
                                    <span>". htmlspecialchars($row['Student_Others']) ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Interests:</label>
                                    <span>". htmlspecialchars($row['Student_Interest']) ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Dream Company:</label>
                                    <span>". htmlspecialchars($row['Student_DreamCompany']) ."</span>
                                </div>
                                <div class='input-group'>
                                    <label>Ambition:</label>
                                    <span>". htmlspecialchars($row['Student_Ambition']) ."</span>
                                </div>
                            </div>
                        </section>";

                    }
                } else {
                    echo "<span>No extracurricular data found</span>";
                }
            } else {
                echo "Error: " . $stmt->error;
            }
        
             
            echo "<div id='buttons' style='text-align: center; padding: 20px;'>
                            <button id='generate-pdf' onclick='generatePDF()' style='margin-left: 20px;'>Generate PDF</button>
                            <button id='edit' onclick=\"window.location.href='Edit_Student.php?value=".$rollno."'\" style='margin-left: 20px;'>Edit</button>
                        </div>
            </div>";
        $stmt->close();
    } else {
        echo "<span>No roll number provided</span>";
    }

   

    echo "<script>
            var rollno = '" . htmlspecialchars($rollno, ENT_QUOTES, 'UTF-8') . "';
          </script>";
    ?>
 

    <script>
        function generatePDF() {
            const sections = document.querySelectorAll('section');
            
            //  number of sections found
            console.log(`Found ${sections.length} sections.`);

            // Create a new div to hold the sections
            const element = document.createElement('div');

            const heading = document.createElement('h2');
            heading.style.textAlign = 'center';
            heading.style.color = '#000';
            heading.textContent = `${rollno.toUpperCase()} - Profile`;
            element.appendChild(heading);

            // Append each section to the new div
            sections.forEach((section, index) => {
                console.log(`Appending section ${index + 1}`);
                element.appendChild(section.cloneNode(true));
            });

            // HTML of the new div
            console.log('Generated HTML for PDF:', element.innerHTML);
    
            console.log(rollno);
            const opt = {
                margin: 0.30,
                filename: rollno + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf()
                .from(element)
                .set(opt)
                .save()
                .then(() => {
                    console.log('PDF generated successfully.');
                })
                .catch(err => {
                    console.error('Error generating PDF:', err);
                });
    }
        
      $(document).ready(function() {    
        $(".details").click(function() {
            $(this).next(".det").slideToggle("slow");
        });
     });


    </script>
</body>
</html>