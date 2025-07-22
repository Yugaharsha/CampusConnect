<?php
include_once '../config/db_connect.php';
include_once '../utils/lookup_helpers.php'; 


if (!isset($_SESSION['login_id'])) {
    header("Location:../auth/login.php");
    exit();
}

    
    if (isset($_GET['value'])) {
        $rollno = $_GET['value'];

        $name = $mailid = $mentorid = $genderid = $dob =$fname =$fph = $foccup = $fannum= $phn = $regno = $mname = $mph = $moccup = $mtongue = $langid = $addr = $pin = $native = $doj = $modeid = $transid = $aadhar = $firstgradid = $commid = $caste = $quotaid = $scholar = $physicid = $treatmentid = $vaccinateid = ''; // Initialize variables
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
            $row = $result->fetch_assoc();
            $name = $row['Student_Name'];
            $img = $row['Student_Profile_Pic'];
            $mailid = $row['Student_Mailid'];
            $mentorid = $row['Student_Mentor_ID'];
            $genderid = $row['Student_Gender_ID'];
            $dob = $row['Student_DOB'];
            $fname = $row['Student_FatherName'];
            $fph = $row['Student_Father_PH'];
            $foccup = $row['Student_Father_Occupation_ID'];
            $fannum = $row['Student_Father_AnnualIncome'];
            $phn = $row['Student_PH'];
            $regno = $row['Student_Register_Numbe'];
            $mname = $row['Student_MotherName'];
            $mph = $row['Student_Mother_PH'];
            $moccup = $row['Student_Mother_Occupation_ID'];
            $mtongue = $row['Student_Mother_Tongue_ID'];
            $languages = explode(", ", $row['Student_Languages_Known']);              
            $addr = $row['Student_Address'];
            $pin = $row['Student_Pincode'];
            $native = $row['Student_Native'];
            $doj = $row['Student_Date_Of_Join'];
            $modeid = $row['Student_Mode_ID'];
            $transid = $row['Student_Transport_ID'];
            $aadhar = $row['Student_Aadhar'];
            $firstgradid = $row['Student_First_Graduate_ID'];
            $commid = $row['Student_Community_ID'];
            $caste = $row['Student_Caste'];
            $quotaid = $row['Student_Quota_ID'];
            $scholar = $row['Student_Scholarship_Name'];
            $physicid = $row['Student_PhysicallyChallenged_ID'];
            $treatid = $row['Student_Treatment_ID'];
            $vaccinateid = $row['Student_Vaccinated_ID'];   
         
        } 
        
        
        else {
            echo "No data found for Rollno: $rollno";
            exit();
        }
    $stmt->close();
}


        $acdtype = $instname = $acd_regno = $modeOfStudy = $modeOfMedium = $board = $marksObtained = $totalMarks = $percentage = $cutOff = ''; // Initialize variables
        $stmt = $conn->prepare("SELECT Student_Rollno, Academic_Type_ID, Institution_Name, Register_Number, Mode_Of_Study_ID,
        Mode_Of_Medium_ID, Board_ID, Mark, Mark_Total, Mark_Percentage, Cut_Of_Mark
           FROM student_academics WHERE Student_Rollno = ?");
        $stmt->bind_param("s", $rollno);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $rows = $result->fetch_all(MYSQLI_ASSOC); 
            foreach ($rows as $row) {
                $acdtype = $row['Academic_Type_ID'];
                $instname = $row['Institution_Name'];
                $acd_regno = $row['Register_Number'];
                $modeOfStudy = $row['Mode_Of_Study_ID'];
                $modeOfMedium = $row['Mode_Of_Medium_ID'];
                $board = $row['Board_ID'];
                $marksObtained = $row['Mark'];
                $totalMarks = $row['Mark_Total'];
                $percentage = $row['Mark_Percentage'];
                $cutOff = $row['Cut_Of_Mark']; 

                $data[] = [
                    'acdtype' => $acdtype,
                    'instname' => $instname,
                    'acd_regno' => $acd_regno,
                    'modeOfStudy' => getLookup($conn,$modeOfStudy),
                    'modeOfMedium' => getLookup($conn,$modeOfMedium),
                    'board' => getLookup($conn,$board),
                    'Mark' => $marksObtained,
                    'totalMarks' => $totalMarks,
                    'percentage' => $percentage,
                    'cutOff' => $cutOff
                ];
            }           
    } 
    else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


    $hobbies = $proglangarray = $othersarray = $interest = $dreamarray = $ambition = ''; 
    $stmt = $conn->prepare("SELECT Student_Rollno, Student_Hobbies, Student_Programming_Language,
    Student_Others, Student_Interest, Student_DreamCompany,
    Student_Ambition FROM student_extracurriculars WHERE Student_Rollno = ?");

    $stmt->bind_param("s", $rollno);

    if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hobbies = $row['Student_Hobbies'];
        $proglangarray =  explode(", ",$row['Student_Programming_Language']);
        $othersarray  = explode(", ", $row['Student_Others']);
        $interest = $row['Student_Interest'];
        $dreamarray  =  explode(", ",$row['Student_DreamCompany']);
        $ambition = $row['Student_Ambition'];                    
    } else {
    echo "Error: " . $stmt->error;
    }

    $stmt->close();
    }

    }
    else {
    echo "No rollno provided.";
    exit();
    }

    
    function isChecked($lang, $languages) {
        return in_array($lang, $languages) ? 'checked' : '';
    }

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Edit</title>

    <link rel="stylesheet" href="../css/Student.css">
    <link rel="stylesheet" href="../css/edit_student.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script type="module" src="../student.js"></script>
    

</head>
<body>
    <header>
        <h1><b>Velammal College of Engineering & Technology</b> <img src="../assets/logo.jpeg" alt="College Logo" width="60" height="60"></h1>
        <a href="../auth/logout.php" >Logout</a>

    </header>
    <h2>Submitted Data</h2>


    <form id="form" action="Update_Student.php" method="post" enctype="multipart/form-data">                                  <!--      // modified -->
    <div class="container">
        <section id="personal-info">
            <div class="details"><h3>Personal Details</h3></div>
            <div class="det">                   
                    <img src="../uploads/<?php echo htmlspecialchars($img); ?>" alt="Profile Picture" width="100" height="100"><br>  
                    <div class="input-group-pic">
                    <h2>Profile Picture</h2>      
                    <label for="newImage">Upload New Image:</label>
                    <input type="file" id="newImage" name="newImage" accept="image/*" onchange="previewImage(event)">
                    <div id="preview-container">
                        <img id="preview" src="../uploads/<?php echo htmlspecialchars($img); ?>" alt="Preview will appear here" style="display: none; max-width: 150px; max-height: 150px; margin-top: 10px;">
                    </div>
                </div>
                <div class="input-group">
                    <label for="name">Name:</label><label for="aadhar" style="margin-left: 300px;">Aadhar:</label>
                    <br> 
                    <input type="text" id="name" name="name" placeholder="initials at last ex. Aaaa S or Aaaa S.B" style="width: 300px;" value="<?php echo htmlspecialchars($name); ?>" required>            
                    <input type="text" name="aadhar" placeholder="ex. 1000 2000 3000" style="width: 250px ; margin-left: 125px;" value="<?php echo htmlspecialchars($aadhar); ?>" required>
                </div>
                <br>

                <div class="input-group">
                    <label for="email">Email:</label> <label for="ph" style="margin-left: 295px;">Phone number:</label>
                    <br>
                    <input type="email" name="email" placeholder="Email" style="width: 250px ;" value="<?php echo htmlspecialchars($mailid); ?>" required>
              
                    <input type="tel" name="ph" placeholder="ex. 9123456789" style="width: 250px ;margin-left: 175px;" value="<?php echo htmlspecialchars($phn); ?>" required>
                </div>
                <br>
                <div class="input-group">
                    <label for="dob">Date of Birth:</label> <label for="gender" style="margin-left: 295px;">Gender:</label><br>
                    <input type="date" name="dob" style="width: 200px;" value="<?php echo htmlspecialchars($dob); ?>" required> 
                
                    <?php $gen_value = getLookup($conn,htmlspecialchars($genderid))?>
                    <input type="radio" name="gender" value="2"  id="gender-female" style="margin-left: 228px;" required <?php echo ($gen_value == '2') ? 'checked' : '';?>>
                    <label class="radio-label" for="gender">Female</label>
                    <input type="radio" name="gender" value="1" id="gender-male" style="margin-left: -30px;" required <?php echo ($gen_value == '1') ? 'checked' : '';?>>
                    <label class="radio-label" for="gender">Male</label>
                </div>
                <br>

                <div class="input-group">
                    <label for="reg">Register number:</label><br>
                    <div class="fixed-input">
                        <span class="fixed-text">9131</span>
                        <input type="text" id="reg" name="reg" placeholder="ex. 22100100" value="<?php echo htmlspecialchars($regno); ?>">
                    </div>
                </div>
                <br>

                <div class="input-group">
                    <label for="m_name">Mother Name:</label>  <label for="m_ph" style="margin-left: 130px;">Phone number:</label><label for="m_occ" style="width: 250px;margin-left: 120px;">Mother's Occupation:</label>
                    <br>
                    <input type="text" name="m_name" placeholder="essx. Aaaa S or Aaaa S.B" style="width:200px;" value="<?php echo htmlspecialchars($mname); ?>" required >
                
                    <input type="tel" name="m_ph" placeholder="ex. 9123456789" style="width: 200px ;margin-left: 60px;" value="<?php echo htmlspecialchars($mph); ?>" required> 
                    <select name="m_occ" style="width: 200px;margin-left: 50px;" required>

                    <!-- <script>
                        console.log("<?php echo getLookup($conn, htmlspecialchars($moccup)); ?>");
                    </script> -->
                        <?php $m_occ_val = getLookup($conn,htmlspecialchars($moccup))?>
                        <option value="1" <?php echo ($m_occ_val == '1') ? 'selected' : ''; ?>>Government</option>
                        <option value="2" <?php echo ($m_occ_val == '2') ? 'selected' : ''; ?>>Business</option>
                        <option value="3" <?php echo ($m_occ_val == '3') ? 'selected' : ''; ?>>Private</option>
                        <option value="4" <?php echo ($m_occ_val== '4') ? 'selected' : ''; ?>>Self-Employed</option>
                        <option value="5" <?php echo ($m_occ_val == '5') ? 'selected' : ''; ?>>Other</option>
                        <option value="6" <?php echo ($m_occ_val == '6') ? 'selected' : ''; ?>>NA</option>
                    </select>

                </div>
                <br>
             
                <br>
                <div class="input-group" required>
                    <label for="f_name">Father Name:</label>  <label for="f_ph" style="margin-left: 130px;">Phone number:</label> <label for="f_occ" style="width: 250px;margin-left: 120px;">Father's Occupation:</label>

                    <br>
                    <input type="text" name="f_name" placeholder="ex. Aaaa S or Aaaa S.B" style="width:200px;" value="<?php echo htmlspecialchars($fname); ?>" required>
                    <input type="tel" name="f_ph" placeholder="ex. 9123456789" style="width: 200px ;margin-left: 60px;" value="<?php echo htmlspecialchars($fph); ?>" required>
              
                    <select name="f_occ" style="width: 200px;margin-left: 50px;" value="<?php echo htmlspecialchars($focc); ?>" required>
                        <?php $f_occ_val = getLookup($conn,htmlspecialchars($foccup))?>
                        <option value="1" <?php echo ($f_occ_val == '1') ? 'selected' : ''; ?>>Government</option>
                        <option value="2" <?php echo ($f_occ_val == '2') ? 'selected' : ''; ?>>Business</option>
                        <option value="3" <?php echo ($f_occ_val == '3') ? 'selected' : ''; ?>>Private</option>
                        <option value="4" <?php echo ($f_occ_val== '4') ? 'selected' : ''; ?>>Self-Employed</option>
                        <option value="5" <?php echo ($f_occ_val == '5') ? 'selected' : ''; ?>>Other</option>
                        <option value="6" <?php echo ($f_occ_val == '6') ? 'selected' : ''; ?>>NA</option>
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <label for="income">Annual Income:</label><label for="tongue"  style="margin-left: 130px;">Mother Tongue:</label><br>

                    <input type="number" name="income" placeholder="" min=0 style="width: 150px ;" value="<?php echo htmlspecialchars($fannum); ?>" required>
               
                    <select name="tongue" style="width: 200px ;margin-left: 110px;" value="<?php echo htmlspecialchars($tongue); ?>">
                        <?php $m_value = getLookup($conn,htmlspecialchars($mtongue))?>
                        <option value="1" <?php echo ($m_value == '1') ? 'selected' : ''; ?>>Tamil</option>
                        <option value="2" <?php echo ($m_value == '2') ? 'selected' : ''; ?>>Hindi</option>
                        <option value="3" <?php echo ($m_value == '3') ? 'selected' : ''; ?>>Malayalam</option>
                        <option value="4" <?php echo ($m_value == '4') ? 'selected' : ''; ?>>Telugu</option>
                        <option value="5" <?php echo ($m_value == '5') ? 'selected' : ''; ?>>Kannadam</option>
                        <option value="6" <?php echo ($m_value == '6') ? 'selected' : ''; ?>>English</option>
                        <option value="7" <?php echo ($m_value == '7') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <br>
                <div class="input-group">  <!--value="<?php echo htmlspecialchars($name); ?>"-->
                    <label for="lang">Languages Known: </label> <span id="errr"></span>
                    <br>
                    <div class="row1" style="display: flex; flex-direction: row" >
                    <label class="bold-label" ><input type="checkbox" name="lang[]" value="Tamil" <?php echo isChecked('Tamil', $languages); ?> >Tamil</label>
                    <label class="bold-label" ><input type="checkbox" name="lang[]" value="English" style="margin-left: -40px;" <?php echo isChecked('English', $languages); ?>>English</label>
                    <label class="bold-label" ><input type="checkbox" name="lang[]" value="Hindi" style="margin-left: -80px;" <?php echo isChecked('Hindi', $languages); ?>>Hindi</label>
                    </div>
                    <div class="row2" style="display: flex; flex-direction: row" >

                    <label class="bold-label" ><input type="checkbox" name="lang[]" value="Malayalam" <?php echo isChecked('Malayalam', $languages); ?>>Malayalam</label>
                    <label class="bold-label" ><input type="checkbox" name="lang[]" value="Telugu" style="margin-left: -40px;" <?php echo isChecked('Telugu', $languages); ?>>Telugu</label>
                    <label class="bold-label" ><input type="checkbox" name="lang[]" value="Kannadam" style="margin-left: -80px;" <?php echo isChecked('Kannadam', $languages); ?>>Kannadam</label>
                    </div>

                </div>
                <br>

                <div class="input-group">
                    <label for="addr">Address:</label>
                    <textarea name="addr" rows="4" cols="50" required><?php echo htmlspecialchars($addr); ?></textarea>
                </div>
                <br>
                <div class="input-group">
                    <label for="native">Native:</label><label for="pin" style="width: 250px ;margin-left: 295px;">Pin code:</label>
                    <br>
                    <input type="text" name="native" style="width: 250px" value="<?php echo htmlspecialchars($native); ?>" required>
                    <input type="text" name="pin" placeholder="ex. 600001" style="width: 150px ;margin-left: 175px;" value="<?php echo htmlspecialchars($pin); ?>" required>
                </div>
                
                <br>
                <div class="input-group">
                    <label for="doj">Date of Join:</label><label for="mode" style="margin-left: 295px;">Mode of Study:</label><br>
                     <input type="date" name="doj" style="width: 150px;" value="<?php echo htmlspecialchars($dob); ?>" required>              <!--        //modified -->
           
                    <?php $mode_value = getLookup($conn,htmlspecialchars($modeid))?>
                    <input type="radio" name="mode" value="1" required style="margin-left: 270px;" <?php echo ($mode_value == '1') ? 'checked' : '';?>>
                    <label class="radio-label" for="mode">Day-Scholar</label>
                    <input type="radio" name="mode" value="2" required style="margin-left: -30px;" <?php echo ($mode_value == '2') ? 'checked' : '';?>>
                    <label class="radio-label" for="mode">Hostelite</label>
                </div>
                <br>

                <div class="input-group">
                    <label for="trans">Transport:</label>
                    <select name="trans" style="width: 250px ;" value="<?php echo htmlspecialchars($trans); ?>" required>
                        <?php $trans_value = getLookup($conn,htmlspecialchars($transid))?>
                        <option value="1" <?php echo ($trans_value == '1') ? 'selected' : '';?>>College Bus</option>
                        <option value="2" <?php echo ($trans_value == '2') ? 'selected' : '';?>>Self</option>
                        <option value="3" <?php echo ($trans_value == '3') ? 'selected' : '';?>>Others</option>
                        <option value="4" <?php echo ($trans_value == '4') ? 'selected' : '';?>>NA (if hostel)</option>
                    </select>
                </div>
                <br>

                <div class="input-group">
                    <label for="first_graduate">First Graduate:</label><label for="quota" style="margin-left: 295px;">Quota:</label><br>

                    <?php $f_grad_value = getLookup($conn,htmlspecialchars($firstgradid))?>
                    <input type="radio" name="first_graduate" value="1" style="margin-left: -1px;" required <?php echo ($f_grad_value == '1') ? 'checked' : '';?>>
                    <label class="radio-label" for="first_graduate">Yes</label>
                    <input type="radio" name="first_graduate" value="2" style="margin-left: -80px;" required <?php echo ($f_grad_value == '2') ? 'checked' : '';?>>
                    <label class="radio-label" for="first_graduate">No</label>
              
                    <?php $quota_value = getLookup($conn,htmlspecialchars($quotaid))?>
                    <input type="radio" name="quota" value="1" style="margin-left: 180px;" required <?php echo ($quota_value == '1') ? 'checked' : '';?>>
                    <label class="radio-label" for="quota">General</label>
                    <input type="radio" name="quota" value="2" style="margin-left: -50px;" required <?php echo ($quota_value == '2') ? 'checked' : '';?>>
                    <label class="radio-label" for="quota">Management</label>
                </div>
                <br>
                <div class="input-group">
                    <label for="community">Community:</label>  <label for="caste"  style="width: 250px ;margin-left: 295px;">Caste:</label>
                     <br>
                    <select name="community" style="width: 250px" value="<?php echo htmlspecialchars($commid); ?>" required>
                        <?php $comm_value = getLookup($conn,htmlspecialchars($commid))?>
                        <option value="1" <?php echo ($comm_value == '1') ? 'selected' : '';?>>OC</option>
                        <option value="2" <?php echo ($comm_value == '2') ? 'selected' : '';?>>BC</option>
                        <option value="3" <?php echo ($comm_value == '3') ? 'selected' : '';?>>MBC</option>
                        <option value="4" <?php echo ($comm_value == '4') ? 'selected' : '';?>>SC</option>
                        <option value="5" <?php echo ($comm_value == '5') ? 'selected' : '';?>>ST</option>
                        <option value="6" <?php echo ($comm_value == '6') ? 'selected' : '';?>>DNC</option>
                        <option value="7" <?php echo ($comm_value == '7') ? 'selected' : '';?>>Others</option>
                    </select>

                    <input type="text" name="caste"  style="width: 200px ;margin-left: 195px;" value="<?php echo htmlspecialchars($caste); ?>" required>
                </div>
                <br>

                <div class="input-group">
                    <label for="schlr">Scholarship Name:</label><br>
                    <input type="text" name="schlr" placeholder="if applied for any external scholarship, mention"  value="<?php echo htmlspecialchars($scholar); ?>"style="width: 500px;">
                </div>
                <br>
                <div class="input-group">
                    <label for="physically_challenged" style="width: 250px;">Physically Challenged:</label>
                    <?php $p_chl_value = getLookup($conn,htmlspecialchars($physicid))?>

                    <input type="radio" name="physically_challenged" value="1" required style="margin-left: -1px" <?php echo ($p_chl_value == '1') ? 'checked' : '';?>>
                    <label class="radio-label" for="physically_challenged">Yes</label>
                    <input type="radio" name="physically_challenged" value="2" required style="margin-left: -50px" <?php echo ($p_chl_value == '2') ? 'checked' : '';?>>
                    <label class="radio-label" for="physically_challenged">No</label>
                </div>
                <br>

                <div class="input-group">
                    <label for="vaccinated" style="width: 250px;">Double Vaccinated:</label>
                    <?php $vacc_value = getLookup($conn,htmlspecialchars($vaccinateid))?>
                    <input type="radio" name="vaccinated" value="1" required style="margin-left: -1px" <?php echo ($vacc_value == '1') ? 'checked' : '';?>>
                    <label class="radio-label" for="vaccinated">Yes</label>
                    <input type="radio" name="vaccinated" value="2" required style="margin-left: -50px" <?php echo ($vacc_value == '2') ? 'checked' : '';?>>
                    <label class="radio-label" for="vaccinated">No</label>
                </div>
                <br>

                <div class="input-group" >
                    <label for="under_any_treatment" style="width: 250px;">Under any Treatment?</label>
                    <?php $t_value = getLookup($conn,htmlspecialchars($treatid))?>
                    <input type="radio" name="under_any_treatment" value="1" required style="margin-left: -1px" <?php echo ($t_value == '1') ? 'checked' : '';?>>
                    <label class="radio-label" for="under_any_treatment">Yes</label>
                    <input type="radio" name="under_any_treatment" value="2" required style="margin-left: -50px" <?php echo ($t_value == '2') ? 'checked' : '';?>>
                    <label class="radio-label" for="under_any_treatment">No</label>
                </div>
                <br>
            </div>
        </section>
        <br>
        <section id="academic-details">
            <div class="details"><h3>Academic</h3></div>
            <div class="det">
                    <div class="input-group">
                        <label for="acad_type">Academic Type:</label>
                        <select id="acad_type" name="acad_type" style="width: 250px" required>
                        <?php                      
                            ?><script>console.log(<?php echo json_encode($data); ?>) </script><?php
                             $i=0;
                            foreach ($data as $index => $item) {                                 
                                $lookupId = getLookup($conn, $item['acdtype']);
                                $lookupValue = getLookupValue($conn, $item['acdtype']);
                            ?>
                            <option value="<?php echo $lookupId; ?>"><?php echo $lookupValue; ?></option>
                        <?php } ?>        
                    </select>
                    </div>
                    <div class="input-group">
                        <label for="inst_name">Institution Name:</label>
                        <input type="text" id="inst_name" name="inst_name" placeholder="Name" value="<?php echo htmlspecialchars($data[0]['instname']); ?>" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="acd_reg_no">Register Number:</label>
                        <input type="text" id="acd_reg_no" name="acd_reg_no" placeholder="" style="width: 180px" value="<?php echo htmlspecialchars($data[$i]['acd_regno']); ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="mode_of_study">Mode Of Study:</label>
                        <select id="mode_of_study" name="mode_of_study" style="width: 180px" value="<?php echo htmlspecialchars($modeOfStudy); ?>" required>
                        <?php $a_mode_value = getLookup($conn,htmlspecialchars($data[$i]['modeOfStudy']))?>
                            <option value="1" <?php echo ($a_mode_value == '1') ? 'selected' : '';?>>Full-Time</option>
                            <option value="2" <?php echo ($a_mode_value == '2') ? 'selected' : '';?>>Part-Time</option>
                        </select>
                        <label for="mode_of_medium" style="margin-left: 60px;">Mode Of Medium:</label>
                        <select id="mode_of_medium" name="mode_of_medium" style="width: 180px" value="<?php echo htmlspecialchars($modeOfMedium); ?>" required>
                        <?php $medium_value = getLookup($conn,htmlspecialchars($data[$i]['modeOfMedium']))?>
                            <option value="1" <?php echo ($medium_value == '1') ? 'selected' : '';?>>English</option>
                            <option value="2" <?php echo ($medium_value == '2') ? 'selected' : '';?>>Tamil</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="board">Board:</label>
                        <select id="board" name="board" style="width: 200px" value="<?php echo htmlspecialchars($board); ?>" required>
                            <?php $board_value = getLookup($conn,htmlspecialchars($data[$i]['board']))?>
                            <option value="1" <?php echo ($board_value == '1') ? 'selected' : '';?>>State Board</option>
                            <option value="2" <?php echo ($board_value == '2') ? 'selected' : '';?>>Matric</option>
                            <option value="3" <?php echo ($board_value == '3') ? 'selected' : '';?>>CBSE</option>
                            <option value="4" <?php echo ($board_value == '4') ? 'selected' : '';?>>ICSE</option>
                            <option value="5" <?php echo ($board_value == '5') ? 'selected' : '';?>>Others</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="marks_obtained">Marks Obtained:</label>
                        <input type="number" id="marks_obtained" name="marks_obtained" placeholder="ex.400" style="width: 90px" min="0" value="<?php echo htmlspecialchars($data[$i]['Mark']); ?>"  required>
                        /
                        <input type="number" id="total_marks" name="total_marks" placeholder="ex.500" style="width: 90px;" min="0" value="<?php echo htmlspecialchars($data[$i]['totalMarks']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="percentage">Percentage:</label>
                        <label for="cut_off" style="margin-left: 250px;">Cut-Off:</label>
                        <br>
                        <input type="number" id="percentage" name="percentage" placeholder="ex.90.05" style="width: 120px" min="0" max="100" step="0.01" value="<?php echo htmlspecialchars($data[$i]['percentage']); ?>"  required>
                        <input type="number" id="cut_off" name="cut_off" placeholder="ex.150.7" style="width: 120px;margin-left: 265px;" min="0" max="200"  value="<?php echo htmlspecialchars($data[$i]['cutOff']); ?>" required>
                    </div>
                    <input type="hidden" id="storedData" name="storedData">
                    <button id="submitBtn" type="button">Done</button>
                    <br><br>
            </div>
        </section>
        <br>    
        
        <section id="extra-curr">
                <div class="details"><h3>Extra - Curricular</h3></div>
                <div class="det">
                    <div class="input-group">
                        <label for="Hobbies">Hobbies:</label><br>
                        <textarea id="Hobbies" name="hobbies" rows="2" cols="30" style="width: 450px"><?php echo htmlspecialchars($hobbies); ?></textarea>
                    </div>
                    <div class="input-group" style="display: -webkit-flex;">
                        <label for="Certification_Courses" style="width: 250px">Certification Courses: </label><br>
                        <div class="input-row">
                            <label for="Programming_Language" style="width: 250px;font-size: 14px;margin-top: 40px;">Programming Language: </label>
                            <div class="input-Programming_Language">                       
                                    <?php
                                    $i = 0;
                                    foreach ($proglangarray as $lang):
                                        echo '<div class="input-group">';
                                        echo '<input type="text" class="inputtype" id="Programming_Language' . $i . '" name="Programming_Language[]" placeholder="" style="width: 200px;" value="' . htmlspecialchars(trim($lang)) . '">';
                                        if ($i == 0) {
                                            echo '<i id="addProgrammingLanguage" class="fas fa-plus icon" style="margin-left: 5px;color: rgb(77, 147, 3)"></i>';
                                        } else {
                                            echo '<i class="fas fa-minus icon removeField" style="margin-left: 5px;color:red"></i>';
                                        }
                                        echo '</div>';
                                        $i++;
                                    endforeach;
                                    ?>
                            </div>
                    </div>
                    <div class="input-row">
                        <label for="Other_Courses" style="width: 250px;font-size: 14px;margin-left: 20px;margin-top: 40px;">Other Courses: </label>
                        <div class="input-Other_Courses">
                        <?php
                        $i = 0;
                        foreach ($othersarray as $lang):
                            echo '<div class="input-group">';
                            echo '<input type="text" class="inputtype" id="Other_Courses' . $i . '" name="Other_Courses[]" placeholder="" style="width: 200px;" value="' . htmlspecialchars(trim($lang)) . '">';
                            if ($i == 0) {
                                echo '<i class="fas fa-plus icon addOtherCourses" style="margin-left: 5px;color: rgb(77, 147, 3)"></i>';
                            } else {
                                echo '<i class="fas fa-minus icon removeField" style="margin-left: 5px;color:red"></i>';
                            }
                            echo '</div>';
                            $i++;
                        endforeach;
                        ?>
                        </div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="Interest">Interests:</label><br>
                        <textarea id="Interest" name="interests" rows="4" cols="30" style="width: 450px" required><?php echo htmlspecialchars($interest); ?></textarea>
                    </div>
                    <div class="input-group">
                    <label for="Dream_Company" style="width: 200px">Dream Company:</label><br>
                    
              
                    <div class="input-Dream_Company" style="display: flex; flex-direction: column;">
                        <?php
                        $i = 0;
                        foreach ($dreamarray as $lang):
                            echo '<div class="input-group dream-group">';
                            
                            echo '<input type="text" class="inputtype" id="Dream_Company' . $i . '" name="Dream_Company[]" placeholder="" style="width: 200px;" value="' . htmlspecialchars(trim($lang)) . '">';
                            if ($i == 0) {
                                echo '<i id="addDream_Company" class="fas fa-plus icon" style="margin-left: 5px;color: rgb(77, 147, 3)"></i>';
                            } else {
                                echo '<i class="fas fa-minus icon removeField" style="margin-left: 5px;color:red"></i>';
                            }
                            echo '</div>';
                            $i++;
                        endforeach;
                        ?>
                    </div>

                    </div>
                    <div class="input-group">
                        <label for="Ambition">Ambition:</label><br>
                        <textarea id="Ambition" name="ambition" rows="4" cols="30" style="width: 450px" required><?php echo htmlspecialchars($ambition); ?></textarea>
                    </div>
                </div>
            </section><br>
        </section><br>

        <center><input type="submit" value="Update" id="EditSubmit" class="submit-button"></center>                
         <input type="hidden" id="roll_no" name="roll_no" value="<?php echo htmlspecialchars($rollno);?>">          
    </div>
    </form>
    
    <div id="sslc"></div>
    <div id="hsc"></div>
    <div id="FinalSubmit"></div>

    <script>

        function previewImage(event) {
            const previewContainer = document.getElementById("preview-container");
            const previewImage = document.getElementById("preview");

            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImage.src = e.target.result;  
                    previewImage.style.display = "block"; 
                }
                reader.readAsDataURL(file);  
            } else {
                previewImage.style.display = "none"; 
            }
    }

        let academicData = {};

        let phpData = <?php echo json_encode($data); ?>;
        console.log("Fetched from PHP:", phpData);

        phpData.forEach(item => {
            let type = item.acdtype;
            academicData[type] = {
                institution: item.instname,
                regno: item.acd_regno,
                modeOfStudy: item.modeOfStudy,
                modeOfMedium: item.modeOfMedium,
                board: item.board,
                marksObtained: item.Mark,
                totalMarks: item.totalMarks,
                percentage: item.percentage,
                cutOff: item.cutOff
            };
        });
        document.getElementById("submitBtn").addEventListener("click", function () {
            const selectedType = document.getElementById("acad_type").value;

            academicData[selectedType] = {
                institution: document.getElementById('inst_name').value,
                regno: document.getElementById('acd_reg_no').value,
                modeOfStudy: document.getElementById('mode_of_study').value,
                modeOfMedium: document.getElementById('mode_of_medium').value,
                board: document.getElementById('board').value,
                marksObtained: document.getElementById('marks_obtained').value,
                totalMarks: document.getElementById('total_marks').value,
                percentage: document.getElementById('percentage').value,
                cutOff: document.getElementById('cut_off').value
            };

            document.getElementById("storedData").value = JSON.stringify(academicData);
            console.log("Updated storedData:", academicData);
        });



        document.addEventListener('DOMContentLoaded', function() {
            var acadTypeSelect = document.getElementById('acad_type');

            acadTypeSelect.addEventListener('change', function() {
                var selectedIndex = acadTypeSelect.selectedIndex;
                console.log("Selected index:", selectedIndex); 
                updateFormFields(selectedIndex); 
            });

            $(document).on('click', '.removeField', function() {
                $(this).closest('.input-group').remove();
            });

            $('#addProgrammingLanguage').click(function() {
                $('.input-Programming_Language').append('<div class="input-group"><input type="text" class="inputtype" name="Programming_Language[]" placeholder="" style="width: 200px;"><i class="fas fa-minus icon removeField" style="margin-left: 5px;color:red"></i></div>');
            });

            $('.addOtherCourses').click(function() {
                $('.input-Other_Courses').append('<div class="input-group"><input type="text" class="inputtype" name="Other_Courses[]" placeholder="" style="width: 200px;"><i class="fas fa-minus icon removeField" style="margin-left: 5px;color:red"></i></div>');
            });
            $('#addDream_Company').click(function() {
                if ($('.dream-group').length < 3) {
                    $('.input-Dream_Company').append('<div class="input-group dream-group"><input type="text" class="inputtype" name="Dream_Company[]" placeholder="" style="width: 200px;"><i class="fas fa-minus icon removeField" style="margin-left: 5px;color:red"></i></div>');
                } else {
                    console.log('You can only add up to 3 Dream Company fields.');
                }
            });


            // JavaScript for handling dynamic form field update
            var acadTypeSelect = document.getElementById('acad_type');

            acadTypeSelect.addEventListener('change', function() {
                var selectedIndex = acadTypeSelect.selectedIndex;
                console.log("Selected index:", selectedIndex); 
                updateFormFields(selectedIndex);
            });

            function updateFormFields(index) {
                var data = <?php echo json_encode($data); ?>;
                var selectedData = data[index]; 

                document.getElementById('inst_name').value = selectedData['instname'];
                document.getElementById('acd_reg_no').value = selectedData['acd_regno'];
                var modeOfStudySelect = document.getElementById('mode_of_study');
                setSelectedIndexByValue(modeOfStudySelect, selectedData['modeOfStudy']);

                var modeOfMediumSelect = document.getElementById('mode_of_medium');  
                setSelectedIndexByValue(modeOfMediumSelect, selectedData['modeOfMedium']);

                var boardSelect = document.getElementById('board');
                setSelectedIndexByValue(boardSelect, selectedData['board']);

                document.getElementById('marks_obtained').value = selectedData['Mark'];
                document.getElementById('total_marks').value = selectedData['totalMarks'];

                document.getElementById('percentage').value = selectedData['percentage'];
                document.getElementById('cut_off').value = selectedData['cutOff'];
            }

            function setSelectedIndexByValue(selectElement, value) {
                for (var i = 0; i < selectElement.options.length; i++) {
                    if (selectElement.options[i].value === value.toString()) { 
                        selectElement.selectedIndex = i;
                        break;
                    }
                }
            }    
             
        });
        document.getElementById("form").addEventListener("submit", function () {
            document.getElementById("storedData").value = JSON.stringify(academicData);
        });
         $(document).ready(function() {    
            $(".details").click(function() {
                $(this).next(".det").slideToggle("slow");
            });
        });

        

    </script>
</body>
</html>