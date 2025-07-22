<?php

include_once 'config/db_connect.php';
include_once 'utils/lookup_helpers.php'; 


if (!isset($_SESSION['login_id'])) {
    header("Location: auth/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {   

    // personal
    $roll_no =  $_POST['roll_no'];
    $name = $_POST['name'];
    $aadhar = $_POST['aadhar'];
    $email = $_POST['email'];
    $phone = $_POST['ph'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $reg_number = $_POST['reg'];
    $m_name = $_POST['m_name'];
    $m_phone = $_POST['m_ph'];
    $m_occupation = $_POST['m_occ'];
    $f_name = $_POST['f_name'];
    $f_phone = $_POST['f_ph'];
    $f_occupation = $_POST['f_occ'];
    $income = $_POST['income'];
    $mother_tongue = $_POST['tongue'];
    $languages = implode(", ", $_POST['lang']); // Assuming languages are submitted as an array
    $address = $_POST['addr'];
    $native = $_POST['native'];
    $pin_code = $_POST['pin'];
    $date_of_join = $_POST['doj'];
    $mode_of_study = $_POST['mode'];
    $transport = $_POST['trans'];
    $first_graduate = $_POST['first_graduate'];
    $quota = $_POST['quota'];
    $community = $_POST['community'];
    $caste = $_POST['caste'];
    $scholarship_name = $_POST['schlr'];
    $physically_challenged = $_POST['physically_challenged'];
    $double_vaccinated = $_POST['vaccinated'];
    $under_treatment = $_POST['under_any_treatment'];

    $currentDate = date('Y-m-d');
    //echo $currentDate;

     
    $mentor=1;

    // Get lookupids
    $first_graduate_id = getLookupId($conn, 'Yes or No', $first_graduate);
    $physically_challenged_id = getLookupId($conn, 'Yes or No', $physically_challenged);
    $double_vaccinated_id = getLookupId($conn, 'Yes or No', $double_vaccinated);
    $under_treatment_id = getLookupId($conn, 'Yes or No', $under_treatment);
    $community_id = getLookupId($conn, 'Community', $community);
    $gender_id = getLookupId($conn, 'Gender', $gender);
    $m_occupation_id = getLookupId($conn, 'Occupation', $m_occupation);
    $f_occupation_id = getLookupId($conn, 'Occupation', $f_occupation);
    $mother_tongue_id = getLookupId($conn, 'Mother Tongue', $mother_tongue);
    $mode_of_study_id = getLookupId($conn, 'Mode of Study', $mode_of_study);
    $transport_id = getLookupId($conn, 'Transport', $transport);
    $quota_id = getLookupId($conn, 'Quota', $quota);

    
    $img = $_FILES['profile-pic']['name'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO student_personal (Student_Rollno, Student_Mailid, Student_Name, Student_Mentor_ID, 
    Student_Gender_ID,Student_DOB, Student_FatherName, Student_Father_PH, Student_Father_Occupation_ID, Student_Father_AnnualIncome, 
    Student_PH, Student_Register_Numbe, Student_MotherName, Student_Mother_PH, Student_Mother_Occupation_ID, Student_Mother_Tongue_ID, 
    Student_Languages_Known, Student_Address, Student_Pincode, Student_Native, Student_Date_Of_Join, Student_Mode_ID, Student_Transport_ID,
    Student_Aadhar, Student_First_Graduate_ID, Student_Community_ID, Student_Caste, Student_Quota_ID, Student_Scholarship_Name, 
    Student_PhysicallyChallenged_ID, Student_Treatment_ID, Student_Vaccinated_ID, Student_Created_By, Student_Modified_By,Student_Profile_Pic)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sssiisssiissssiisssssiisiisisiiisss", $roll_no, $email, $name, $mentor, $gender_id, $dob, $f_name, $f_phone, $f_occupation_id,
    $income, $phone, $reg_number, $m_name, $m_phone, $m_occupation_id, $mother_tongue_id, $languages, $address,  $pin_code,  $native, $date_of_join,
    $mode_of_study_id, $transport_id, $aadhar, $first_graduate_id, $community_id, $caste, $quota_id, $scholarship_name, $physically_challenged_id,
    $under_treatment_id, $double_vaccinated_id, $roll_no, $roll_no,$img);
  
    if ($stmt->execute()) {
        move_uploaded_file($_FILES['profile-pic']['tmp_name'], 'uploads/' . $img);
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }


    // academic

    // Get JSON data
    $storedData = $_POST['storedData'];
    $academicData = json_decode($storedData, true);

    foreach ($academicData as $acad_type => $data) {
        if (!empty($data)) {
            $institution = $data['institution'];
            $regno = $data['regno'];
            $modeOfStudy = $data['modeOfStudy'];
            $modeOfMedium = $data['modeOfMedium'];
            $board = $data['board'];
            $marksObtained = $data['marksObtained'];
            $totalMarks = $data['totalMarks'];
            $percentage = $data['percentage'];
            $cutOff = $data['cutOff'];
    
            $acad_type_id = getLookupId($conn, 'Academic Type', $acad_type);
            $modeOfStudy_id = getLookupId($conn, 'Acad Mode', $modeOfStudy);
            $modeOfMedium_id = getLookupId($conn, 'Medium', $modeOfMedium);
            $board_id = getLookupId($conn, 'Board', $board);


            // Insert data into database
            $sql = "INSERT INTO student_academics (Student_Rollno, Academic_Type_ID, Institution_Name, Register_Number, Mode_Of_Study_ID, Mode_Of_Medium_ID, Board_ID, Mark, Mark_Total, Mark_Percentage, Cut_Of_Mark,
            Academics_Created_By, Academics_Modified_By)
                    VALUES ('$roll_no',$acad_type_id, '$institution', '$regno', $modeOfStudy_id, $modeOfMedium_id, $board_id, $marksObtained, $totalMarks, $percentage, $cutOff, '$roll_no', '$roll_no')";
    
            if ($conn->query($sql) === TRUE) {
                echo "<center><p>Data inserted successfully for $acad_type.</p><br><br></center>";
            } else {
                echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p><br>";
            }
        }
    }

    //extracurriculars
        $hobbies = $_POST['hobbies'];
        $Programming_Languages = implode(', ', $_POST['Programming_Language']); 
        $Other_Courses = implode(', ', $_POST['Other_Courses']); 
        $interests = $_POST['interests'];
        $Dream_Companies = implode(', ', $_POST['Dream_Company']);
        $ambition = $_POST['ambition'];
        $created_by = $roll_no;
        $created_on = date('Y-m-d H:i:s');
        $modified_by = $roll_no;
        $modified_on = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO student_extracurriculars (Student_Rollno, Student_Hobbies, Student_Programming_Language, Student_Others, Student_Interest, Student_DreamCompany, Student_Ambition, Extracurriculars_Created_By, Extracurriculars_Created_On, Extracurriculars_Modified_By, Extracurriculars_Modified_On) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            die("Error preparing the SQL statement: " . $conn->error);
        }

        $stmt->bind_param("sssssssssss", $roll_no, $hobbies, $Programming_Languages, $Other_Courses, $interests, $Dream_Companies, $ambition, $created_by, $created_on, $modified_by, $modified_on);

        if ($stmt->execute()) {
            header("Location: student/Student_View.php?value=" . urlencode($roll_no)); 
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }


    $stmt->close();
    $conn->close();

}
?>