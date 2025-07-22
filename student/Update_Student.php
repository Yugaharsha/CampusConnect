<?php

include_once '../config/db_connect.php';
include_once '../utils/lookup_helpers.php'; 

if (!isset($_SESSION['login_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      

    // Personal Information
    $roll_no = $_POST['roll_no'];
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
    $languages = implode(", ", $_POST['lang']); 
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

    $img = $_FILES['newImage']['name'];

    $existingImg = null;
    $stmt = $conn->prepare("SELECT Student_Profile_Pic FROM student_personal WHERE Student_Rollno = ?");
    $stmt->bind_param("s", $roll_no);
    $stmt->execute();
    $stmt->bind_result($existingImg);
    $stmt->fetch();
    $stmt->close();

    if (!empty($_FILES['newImage']['name'])) {
         $img = $_FILES['newImage']['name'];
         $targetDir = "../uploads/";
         $targetFile = $targetDir . basename($img);
    
        // Delete the old image if it exists
        if ($existingImg && file_exists($targetDir . $existingImg)) {
            unlink($targetDir . $existingImg);
        }
         move_uploaded_file($_FILES['newImage']['tmp_name'], $targetFile);
    } else {
        // No new image uploaded, keep existing one
        $img = $existingImg;
    }    
    


    
    $mentor = 1;

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

    // Update personal information in the database                                                                   // modified
    $stmt = $conn->prepare("UPDATE student_personal SET 
        Student_Mailid = ?, Student_Name = ?, Student_Mentor_ID = ?, Student_Gender_ID = ?, Student_DOB = ?, 
        Student_FatherName = ?, Student_Father_PH = ?, Student_Father_Occupation_ID = ?, Student_Father_AnnualIncome = ?, 
        Student_PH = ?, Student_Register_Numbe = ?, Student_MotherName = ?, Student_Mother_PH = ?, Student_Mother_Occupation_ID = ?,
        Student_Mother_Tongue_ID = ?, Student_Languages_Known = ?, Student_Address = ?, Student_Pincode = ?, 
        Student_Native = ?, Student_Date_Of_Join = ?, Student_Mode_ID = ?, Student_Transport_ID = ?, Student_Aadhar = ?, Student_First_Graduate_ID = ?, 
        Student_Community_ID = ?, Student_Caste = ?, Student_Quota_ID = ?, Student_Scholarship_Name = ?, Student_PhysicallyChallenged_ID = ?, 
        Student_Treatment_ID = ?, Student_Vaccinated_ID = ?, Student_Modified_By = ? , Student_Profile_Pic = ? WHERE Student_Rollno = ?");

    $stmt->bind_param("ssiissiiiiisiiisssssiisiisisiiisss", 
         $email, $name, $mentor, $gender_id, $dob, 
        $f_name, $f_phone, $f_occupation_id, $income, $phone, 
        $reg_number, $m_name, $m_phone, $m_occupation_id, 
        $mother_tongue_id, $languages, $address, $pin_code, 
        $native, $date_of_join, $mode_of_study_id, $transport_id, 
        $aadhar, $first_graduate_id, $community_id, $caste, $quota_id, 
        $scholarship_name, $physically_challenged_id, $under_treatment_id, 
        $double_vaccinated_id, $roll_no, $img ,$roll_no
    );

    if ($stmt->execute()) {
        move_uploaded_file($_FILES['newImage']['tmp_name'], '../uploads/' . $img);
        echo "<center><p>Personal information updated successfully for $roll_no.</p><br><br></center>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p><br>";
    }

    $stmt->close();

    // Academic Information
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

            // Update academic information in the database
            $stmt = $conn->prepare("UPDATE student_academics SET 
                 Institution_Name = ?, Register_Number = ?, Mode_Of_Study_ID = ?, 
                Mode_Of_Medium_ID = ?, Board_ID = ?, Mark = ?, Mark_Total = ?, Mark_Percentage = ?, Cut_Of_Mark = ?, 
                Academics_Modified_By = ? WHERE Student_Rollno = ? and Academic_Type_ID = ?" );

            $stmt->bind_param("siiiiiiiissi", 
                 $institution, $regno, $modeOfStudy_id, $modeOfMedium_id, 
                $board_id, $marksObtained, $totalMarks, $percentage, $cutOff, $roll_no, $roll_no, $acad_type_id,
            );

            if ($stmt->execute()) {
                echo "<center><p>Academic information updated successfully for $acad_type.</p><br><br></center>";
            } else {
                echo "<p>Error: " . $stmt->error . "</p><br>";
            }

            $stmt->close();
        }
    }

    // Extracurricular Information
    $hobbies = $_POST['hobbies'];
    $Programming_Languages = implode(', ', $_POST['Programming_Language']); // Convert array to string
    $Other_Courses = implode(', ', $_POST['Other_Courses']); // Convert array to string
    $interests = $_POST['interests'];
    $Dream_Companies = implode(', ', $_POST['Dream_Company']); // Convert array to string
    $ambition = $_POST['ambition'];


    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE student_extracurriculars SET 
        Student_Hobbies = ?, Student_Programming_Language = ?, Student_Others = ?, 
        Student_Interest = ?, Student_DreamCompany = ?, Student_Ambition = ?, Extracurriculars_Modified_By = ?
        WHERE Student_Rollno = ?");

    $stmt->bind_param("ssssssss", 
        $hobbies, $Programming_Languages, $Other_Courses, $interests, 
        $Dream_Companies, $ambition,$roll_no, $roll_no
    );

    if ($stmt->execute()) {
        echo "successfully updated";
        $_SESSION['update_success'] = "Details updated successfully!";
        header("Location: Student_View.php?value=" . urlencode($roll_no));
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>