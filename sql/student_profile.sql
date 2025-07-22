-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 13, 2025 at 12:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_profile`
--

-- --------------------------------------------------------

--
-- Table structure for table `lookup`
--

CREATE TABLE `lookup` (
  `LookUpId` int(11) NOT NULL,
  `LookUpTypeId` tinyint(4) NOT NULL,
  `LookUpTypeName` varchar(50) NOT NULL,
  `LookUpTypeValue` varchar(50) NOT NULL,
  `LookUpTypeValue_ShortName` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lookup`
--

INSERT INTO `lookup` (`LookUpId`, `LookUpTypeId`, `LookUpTypeName`, `LookUpTypeValue`, `LookUpTypeValue_ShortName`) VALUES
(1, 1, 'Gender', 'Male', 'M'),
(2, 2, 'Gender', 'Female', 'F'),
(3, 3, 'Gender', 'Others', 'O'),
(4, 1, 'Community', 'OC', 'OC'),
(5, 2, 'Community', 'BC', 'BC'),
(6, 3, 'Community', 'MBC', 'MBC'),
(7, 4, 'Community', 'SC', 'SC'),
(8, 5, 'Community', 'ST', 'ST'),
(9, 6, 'Community', 'DNC', 'DNC'),
(10, 7, 'Community', 'Others', 'O'),
(11, 1, 'Occupation', 'Government', 'govt'),
(12, 2, 'Occupation', 'Business', 'B'),
(13, 3, 'Occupation', 'Private', 'pvt'),
(14, 4, 'Occupation', 'Self-Employed', 'self'),
(15, 5, 'Occupation', 'Others', 'O'),
(16, 6, 'Occupation', 'NA', 'NA'),
(17, 1, 'Mother Tongue', 'Tamil', 'TA'),
(18, 2, 'Mother Tongue', 'English', 'EN'),
(19, 3, 'Mother Tongue', 'Malayalam', 'M'),
(20, 4, 'Mother Tongue', 'Hindi', 'H'),
(21, 5, 'Mother Tongue', 'Telugu', 'TE'),
(22, 6, 'Mother Tongue', 'Kannadam', 'K'),
(23, 7, 'Mother Tongue', 'others', 'O'),
(24, 1, 'Mode of Study', 'Day Scholar', 'S'),
(25, 2, 'Mode of Study', 'Hostel', 'H'),
(26, 1, 'Transport', 'College Bus', 'C'),
(27, 2, 'Transport', 'Self', 'S'),
(28, 3, 'Transport', 'Others', 'O'),
(29, 4, 'Transport', 'NA', 'NA'),
(30, 1, 'Yes or No', 'Yes', 'Y'),
(31, 2, 'Yes or No', 'No', 'N'),
(32, 1, 'Quota', 'General', 'GQ'),
(33, 2, 'Quota', 'Management Quota', 'MQ'),
(34, 1, 'Academic Type', 'SSLC', 'S'),
(35, 2, 'Academic Type', 'HSC', 'H'),
(36, 1, 'Medium', 'English', 'EN'),
(37, 2, 'Medium', 'Tamil', 'TA'),
(38, 1, 'Board', 'StateBoard', 'SB'),
(39, 2, 'Board', 'Matric', 'M'),
(40, 3, 'Board', 'CBSE', 'CBSE'),
(41, 4, 'Board', 'ICSE', 'ICSE'),
(42, 5, 'Board', 'Others', 'O'),
(43, 1, 'Acad Mode', 'Full-Time', 'FT'),
(44, 2, 'Acad Mode', 'Part-Time', 'PT');

-- --------------------------------------------------------

--
-- Table structure for table `student_academics`
--

CREATE TABLE `student_academics` (
  `Academic_Type_ID` int(11) NOT NULL,
  `Institution_Name` varchar(50) NOT NULL,
  `Register_Number` varchar(20) NOT NULL,
  `Mode_Of_Study_ID` int(11) NOT NULL,
  `Mode_Of_Medium_ID` int(11) NOT NULL,
  `Board_ID` int(11) NOT NULL,
  `Mark_Total` int(11) NOT NULL,
  `Mark` int(11) NOT NULL,
  `Mark_Percentage` float NOT NULL,
  `Cut_Of_Mark` float NOT NULL,
  `Academics_Created_By` varchar(10) NOT NULL,
  `Academics_Created_ON` date NOT NULL DEFAULT current_timestamp(),
  `Academics_Modified_By` varchar(10) NOT NULL,
  `Academics_Modified_ON` date NOT NULL DEFAULT current_timestamp(),
  `Student_Rollno` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_academics`
--

INSERT INTO `student_academics` (`Academic_Type_ID`, `Institution_Name`, `Register_Number`, `Mode_Of_Study_ID`, `Mode_Of_Medium_ID`, `Board_ID`, `Mark_Total`, `Mark`, `Mark_Percentage`, `Cut_Of_Mark`, `Academics_Created_By`, `Academics_Created_ON`, `Academics_Modified_By`, `Academics_Modified_ON`, `Student_Rollno`) VALUES
(34, 'vcet Madurai', '2334545656', 43, 36, 38, 500, 450, 90, 189, '22cseb01', '2025-07-12', '22cseb01', '2025-07-12', '22cseb01'),
(35, 'vcet', '12121212', 44, 36, 38, 600, 450, 89, 190, '22cseb01', '2025-07-12', '22cseb01', '2025-07-12', '22cseb01'),
(34, 'TVS school', '2334545656', 43, 36, 38, 500, 413, 82.6, 186, '22cseb02', '2025-07-12', '22cseb02', '2025-07-12', '22cseb02'),
(35, 'Mahatma ', '1212121222', 43, 36, 38, 600, 567, 91, 189, '22cseb02', '2025-07-12', '22cseb02', '2025-07-12', '22cseb02'),
(34, 'ceoa matric higher secondary school', '12121212', 43, 36, 38, 500, 400, 90, 150, '22csea02', '2025-07-13', '22csea02', '2025-07-13', '22csea02'),
(35, 'ceoa', '2334545656', 43, 36, 38, 600, 500, 94, 180, '22csea02', '2025-07-13', '22csea02', '2025-07-13', '22csea02'),
(34, 'ABC  Secondary school Madurai', '1678234234', 43, 36, 38, 500, 400, 98, 194, '22csea01', '2025-07-13', '22csea01', '2025-07-13', '22csea01'),
(35, 'ABC  Secondary school', '1111234', 43, 36, 38, 600, 450, 70, 160, '22csea01', '2025-07-13', '22csea01', '2025-07-13', '22csea01'),
(34, 'vcet higher secondary madurai ', '12121212', 43, 36, 38, 600, 500, 90, 190, '22cseb03', '2025-07-13', '22cseb03', '2025-07-13', '22cseb03'),
(35, 'ABC  Higher Secondary school', '2334545656', 43, 36, 38, 500, 300, 85, 170, '22cseb03', '2025-07-13', '22cseb03', '2025-07-13', '22cseb03');

-- --------------------------------------------------------

--
-- Table structure for table `student_extracurriculars`
--

CREATE TABLE `student_extracurriculars` (
  `Student_Rollno` varchar(10) NOT NULL,
  `Student_Hobbies` varchar(255) NOT NULL,
  `Student_Programming_Language` varchar(225) NOT NULL,
  `Student_Others` varchar(225) NOT NULL,
  `Student_Interest` varchar(255) NOT NULL,
  `Student_DreamCompany` varchar(255) NOT NULL,
  `Student_Ambition` varchar(100) NOT NULL,
  `Extracurriculars_Created_By` varchar(10) NOT NULL,
  `Extracurriculars_Created_On` date NOT NULL,
  `Extracurriculars_Modified_By` varchar(10) NOT NULL,
  `Extracurriculars_Modified_On` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_extracurriculars`
--

INSERT INTO `student_extracurriculars` (`Student_Rollno`, `Student_Hobbies`, `Student_Programming_Language`, `Student_Others`, `Student_Interest`, `Student_DreamCompany`, `Student_Ambition`, `Extracurriculars_Created_By`, `Extracurriculars_Created_On`, `Extracurriculars_Modified_By`, `Extracurriculars_Modified_On`) VALUES
('22cseb01', 'Dancing', 'Java, C', 'Cloud Computing', 'Web development', 'Amazon', 'successful ', '22cseb01', '2025-07-12', '22cseb01', '2025-07-12'),
('22cseb02', 'Nothing', 'C, Java, python', 'AI/ML', 'dancing , singing', 'TCS, zoho', 'business women', '22cseb02', '2025-07-12', '22cseb02', '2025-07-12'),
('22csea02', 'singing', 'Java', 'Cloud Computing', 'ML ', 'Amazon, TCS', 'actor', '22csea02', '2025-07-13', '22csea02', '2025-07-13'),
('22csea01', 'nil', 'c, java', 'ai', 'nil', 'nil', 'director', '22csea01', '2025-07-13', '22csea01', '2025-07-13'),
('22cseb03', 'dancing , singing', 'Java, C#', 'SQL', 'sql\r\ncybersecurity', 'presidio', 'nil', '22cseb03', '2025-07-13', '22cseb03', '2025-07-13');

-- --------------------------------------------------------

--
-- Table structure for table `student_personal`
--

CREATE TABLE `student_personal` (
  `Student_Rollno` varchar(10) NOT NULL,
  `Student_Mailid` varchar(32) NOT NULL,
  `Student_Name` varchar(28) NOT NULL,
  `Student_Mentor_ID` tinyint(4) NOT NULL,
  `Student_Gender_ID` int(11) NOT NULL,
  `Student_DOB` date NOT NULL,
  `Student_FatherName` varchar(28) NOT NULL,
  `Student_Father_PH` char(10) NOT NULL,
  `Student_Father_Occupation_ID` int(11) NOT NULL,
  `Student_Father_AnnualIncome` float NOT NULL,
  `Student_PH` char(10) NOT NULL,
  `Student_Register_Numbe` char(12) NOT NULL,
  `Student_MotherName` varchar(28) NOT NULL,
  `Student_Mother_PH` char(10) NOT NULL,
  `Student_Mother_Occupation_ID` int(11) NOT NULL,
  `Student_Mother_Tongue_ID` int(11) NOT NULL,
  `Student_Languages_Known` varchar(100) NOT NULL,
  `Student_Address` varchar(100) NOT NULL,
  `Student_Pincode` char(6) NOT NULL,
  `Student_Native` varchar(20) NOT NULL,
  `Student_Date_Of_Join` date NOT NULL,
  `Student_Mode_ID` int(11) NOT NULL,
  `Student_Transport_ID` int(11) NOT NULL,
  `Student_Aadhar` varchar(14) NOT NULL,
  `Student_First_Graduate_ID` int(11) NOT NULL,
  `Student_Community_ID` int(11) NOT NULL,
  `Student_Caste` varchar(30) NOT NULL,
  `Student_Quota_ID` int(11) NOT NULL,
  `Student_Scholarship_Name` varchar(64) NOT NULL,
  `Student_PhysicallyChallenged_ID` int(11) NOT NULL,
  `Student_Treatment_ID` int(11) NOT NULL,
  `Student_Vaccinated_ID` int(11) NOT NULL,
  `Student_Created_By` varchar(10) NOT NULL,
  `Student_Created_ON` date NOT NULL DEFAULT current_timestamp(),
  `Student_Modified_By` varchar(10) NOT NULL,
  `Student_Modified_ON` date NOT NULL DEFAULT current_timestamp(),
  `Student_Profile_Pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_personal`
--

INSERT INTO `student_personal` (`Student_Rollno`, `Student_Mailid`, `Student_Name`, `Student_Mentor_ID`, `Student_Gender_ID`, `Student_DOB`, `Student_FatherName`, `Student_Father_PH`, `Student_Father_Occupation_ID`, `Student_Father_AnnualIncome`, `Student_PH`, `Student_Register_Numbe`, `Student_MotherName`, `Student_Mother_PH`, `Student_Mother_Occupation_ID`, `Student_Mother_Tongue_ID`, `Student_Languages_Known`, `Student_Address`, `Student_Pincode`, `Student_Native`, `Student_Date_Of_Join`, `Student_Mode_ID`, `Student_Transport_ID`, `Student_Aadhar`, `Student_First_Graduate_ID`, `Student_Community_ID`, `Student_Caste`, `Student_Quota_ID`, `Student_Scholarship_Name`, `Student_PhysicallyChallenged_ID`, `Student_Treatment_ID`, `Student_Vaccinated_ID`, `Student_Created_By`, `Student_Created_ON`, `Student_Modified_By`, `Student_Modified_ON`, `Student_Profile_Pic`) VALUES
('22csea01', 'abcd@gmail.com', 'Meghna M', 1, 2, '2010-07-01', 'Father F', '9305065593', 11, 1000000, '9944208908', '22104019', 'Mother M', '7305065593', 11, 17, 'English', '19/3, SEVUGAN CHETTIAR COLONY,RESERVELINE,ATHIKULAM', '625014', 'Madurai', '2010-07-01', 24, 26, '1000 2000 3000', 31, 4, 'CASTE', 32, 'nil', 31, 31, 31, '22csea01', '2025-07-13', '22csea01', '2025-07-13', 'e.jpg'),
('22csea02', 'v@gmail.com', 'Sheela A', 1, 2, '2010-07-01', 'Father F', '9822077627', 11, 3000000, '9944208908', '22106457', 'Mother M', '1234567890', 11, 17, 'Tamil, English', 'plot 5 , apartment sheet , madurai', '625014', 'Madurai', '2010-07-01', 24, 26, '3434 3444 3434', 30, 4, 'CASTE', 32, 'nil', 31, 31, 31, '22csea02', '2025-07-13', '22csea02', '2025-07-13', 'f.jpg'),
('22cseb01', 'akshayasenthilkumar12@gmail.com', 'AKSHAYA KS', 1, 2, '2005-06-15', 'Father F', '822077627', 11, 1200000, '7305065593', '22104014', 'Mother M', '7305065593', 11, 17, 'Tamil, English', '19/3, SEVUGAN CHETTIAR COLONY,RESERVELINE,ATHIKULAM', '625014', 'Madurai', '2005-06-15', 24, 26, '1000 2300 3000', 31, 4, 'CASTE', 33, 'nil', 31, 31, 31, '22cseb01', '2025-07-12', '22cseb01', '2025-07-12', 'a.jpg'),
('22cseb02', 'amirtha@gmail.com', 'Amirtha S', 1, 2, '2006-02-12', 'Father F', '822077627', 11, 2000000, '9944208908', '22332244', 'Mother M', '1234567890', 11, 17, 'Tamil', '20 Avenue plot 4', '625013', 'Madurai', '2006-02-12', 24, 26, '1234 2535 3000', 30, 4, 'CASTE', 32, 'nil', 31, 31, 31, '22cseb02', '2025-07-12', '22cseb02', '2025-07-12', 'a.jpg'),
('22cseb03', 'ks@gmail.com', 'Rajesh K', 1, 1, '2006-06-08', 'Father F', '9822077627', 11, 10000000, '9899880789', '22104010', 'Mother M', '9004567890', 11, 17, 'Tamil, English', '1/3, vilapurm', '625014', 'Madurai', '2006-06-08', 24, 26, '2345 4567 3456', 31, 4, 'CC', 33, 'nil', 31, 31, 31, '22cseb03', '2025-07-13', '22cseb03', '2025-07-13', 'b.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Login_Id` varchar(32) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `role` enum('student','admin') DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Login_Id`, `Password`, `role`) VALUES
('admin', 'admin123', 'admin'),
('22CSEB01', '22CSEB01', 'student'),
('22CSEB02', '22CSEB02', 'student'),
('22CSEB03', '22CSEB03', 'student'),
('22CSEB04', '22CSEB04', 'student'),
('22CSEB05', '22CSEB05', 'student'),
('22CSEB06', '22CSEB06', 'student'),
('22CSEB07', '22CSEB07', 'student'),
('22CSEB08', '22CSEB08', 'student'),
('22CSEB09', '22CSEB09', 'student'),
('22CSEB10', '22CSEB10', 'student'),
('22CSEA02', '22CSEA02', 'student'),
('22CSEA03', '22CSEA03', 'student'),
('22CSEA04', '22CSEA04', 'student'),
('22CSEA05', '22CSEA05', 'student'),
('22CSEA06', '22CSEA06', 'student'),
('22CSEA07', '22CSEA07', 'student'),
('22CSEA08', '22CSEA08', 'student'),
('22CSEA09', '22CSEA09', 'student'),
('22CSEA10', '22CSEA10', 'student'),
('22CSEA01', '22CSEA01', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lookup`
--
ALTER TABLE `lookup`
  ADD PRIMARY KEY (`LookUpId`);

--
-- Indexes for table `student_academics`
--
ALTER TABLE `student_academics`
  ADD KEY `student_academics_rollno` (`Student_Rollno`),
  ADD KEY `academic_fk` (`Academic_Type_ID`),
  ADD KEY `medium_fk` (`Mode_Of_Medium_ID`),
  ADD KEY `board_fk` (`Board_ID`);

--
-- Indexes for table `student_extracurriculars`
--
ALTER TABLE `student_extracurriculars`
  ADD KEY `student_extracurriculars_Rollno` (`Student_Rollno`);

--
-- Indexes for table `student_personal`
--
ALTER TABLE `student_personal`
  ADD PRIMARY KEY (`Student_Rollno`),
  ADD UNIQUE KEY `Student_Aadhar` (`Student_Aadhar`),
  ADD KEY `gender_fk` (`Student_Gender_ID`),
  ADD KEY `father_occ_fk` (`Student_Father_Occupation_ID`),
  ADD KEY `Mother_occ_fk` (`Student_Mother_Occupation_ID`),
  ADD KEY `mother_tongue_fk` (`Student_Mother_Tongue_ID`),
  ADD KEY `student_mode_fk` (`Student_Mode_ID`),
  ADD KEY `Transport_ID_fk` (`Student_Transport_ID`),
  ADD KEY `first_grad_fk` (`Student_First_Graduate_ID`),
  ADD KEY `community_fk` (`Student_Community_ID`),
  ADD KEY `quota_fk` (`Student_Quota_ID`),
  ADD KEY `physically_challenged_fk` (`Student_PhysicallyChallenged_ID`),
  ADD KEY `treatment_fk` (`Student_Treatment_ID`),
  ADD KEY `vaccinated_fk` (`Student_Vaccinated_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_academics`
--
ALTER TABLE `student_academics`
  ADD CONSTRAINT `acad_rollno_fk` FOREIGN KEY (`Student_Rollno`) REFERENCES `student_personal` (`Student_Rollno`),
  ADD CONSTRAINT `academic_fk` FOREIGN KEY (`Academic_Type_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `board_fk` FOREIGN KEY (`Board_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `medium_fk` FOREIGN KEY (`Mode_Of_Medium_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `student_academics_rollno` FOREIGN KEY (`Student_Rollno`) REFERENCES `student_personal` (`Student_Rollno`);

--
-- Constraints for table `student_extracurriculars`
--
ALTER TABLE `student_extracurriculars`
  ADD CONSTRAINT `student_extracurriculars_Rollno` FOREIGN KEY (`Student_Rollno`) REFERENCES `student_personal` (`Student_Rollno`);

--
-- Constraints for table `student_personal`
--
ALTER TABLE `student_personal`
  ADD CONSTRAINT `Mother_occ_fk` FOREIGN KEY (`Student_Mother_Occupation_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `Transport_ID_fk` FOREIGN KEY (`Student_Transport_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `community_fk` FOREIGN KEY (`Student_Community_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `father_occ_fk` FOREIGN KEY (`Student_Father_Occupation_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `first_grad_fk` FOREIGN KEY (`Student_First_Graduate_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `gender_fk` FOREIGN KEY (`Student_Gender_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `mother_tongue_fk` FOREIGN KEY (`Student_Mother_Tongue_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `physically_challenged_fk` FOREIGN KEY (`Student_PhysicallyChallenged_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `quota_fk` FOREIGN KEY (`Student_Quota_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `student_mode_fk` FOREIGN KEY (`Student_Mode_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `treatment_fk` FOREIGN KEY (`Student_Treatment_ID`) REFERENCES `lookup` (`LookUpId`),
  ADD CONSTRAINT `vaccinated_fk` FOREIGN KEY (`Student_Vaccinated_ID`) REFERENCES `lookup` (`LookUpId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
