document.addEventListener("DOMContentLoaded", function() {
    console.log("fully loaded and parsed");

    const form = document.getElementById("form");
    const finalSubmitBtn = document.getElementById("FinalSubmit");
    const editSubmitBtn = document.getElementById("EditSubmit");

    // Personal fields
    const profilepic = document.getElementById("profile-pic");
    const name = document.getElementsByName("name")[0];
    const email = document.getElementsByName("email")[0];
    const ph = document.getElementsByName("ph")[0];
    const aadhar = document.getElementsByName("aadhar")[0];
    const dob = document.getElementsByName("dob")[0];
    const reg = document.getElementsByName("reg")[0];
    const m_name = document.getElementsByName("m_name")[0];
    const m_ph = document.getElementsByName("m_ph")[0];
    const m_occ = document.getElementsByName("m_occ")[0];
    const f_name = document.getElementsByName("f_name")[0];
    const f_ph = document.getElementsByName("f_ph")[0];
    const f_occ = document.getElementsByName("f_occ")[0];
    const income = document.getElementsByName("income")[0];
    const tongue = document.getElementsByName("tongue")[0];
    const lang = document.getElementsByName("lang[]");
    const addr = document.getElementsByName("addr")[0];
    const native = document.getElementsByName("native")[0];
    const pin = document.getElementsByName("pin")[0];
    const doj = document.getElementsByName("doj")[0];
    const mode = document.getElementsByName("mode")[0];
    const trans = document.getElementsByName("trans")[0];
    const community = document.getElementsByName("community")[0];
    const caste = document.getElementsByName("caste")[0];

    //  Patterns 
    const patterns = {
        name: /^[A-Za-z]{2,}(?: [A-Za-z ]+)? [A-Za-z]{1}(?:[ .]?[A-Za-z]{1})?$/,
        ph: /^[0-9]{10}$/,
        email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/,
        aadhar: /^[0-9]{4} [0-9]{4} [0-9]{4}$/,
        pin: /^[0-9]{6}$/,
        reg: /^[0-9A-Za-z]{8}$/,
    };

    //  Helpers 
    const isEmpty = (value) => value.trim() === "";

    const validateBasic = (element, condition) => {
        if (!condition) {
            element.style.borderColor = "red";
            flag = false;
        } else {
            element.style.borderColor = "";
        }
    };

    const validatePattern = (element, pattern) => {
        validateBasic(element, pattern.test(element.value.trim()));
    };

    const validateSelect = (element) => {
        validateBasic(element, element.value !== "" && element.value !== "Select any one");
    };

    function validateField(field, pattern = null) {
        const value = field.value.trim();
        const isValid = pattern ? pattern.test(value) : value !== '';
        field.style.borderColor = isValid ? '' : 'red';
        return isValid;
    }


    const checkAadharDuplicate = (field) => {
        fetch("utils/check_aadhar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "aadhar=" + encodeURIComponent(field.value)
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                alert("Aadhaar number already exists!");
                field.style.borderColor = "red";
                field.value = "";
                field.focus();
            }
        })
        .catch(err => console.error("Error checking Aadhaar:", err));
    };

    const checkRegnoDuplicate = (field) => {
        fetch("utils/check_regno.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "regno=" + encodeURIComponent(field.value)
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                alert("Register Number number already exists!");
                field.style.borderColor = "red";
                field.value = "";
                field.focus();
            }
        })
        .catch(err => console.error("Error checking Register Number:", err));
    };


    const setMaxDate = (field, yearDiff = 0) => {
        const today = new Date();
        const year = today.getFullYear() - yearDiff;
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        field.setAttribute("max", `${year}-${month}-${day}`);
    };
    setMaxDate(dob, 15);
    setMaxDate(doj);

    //  Add onchange pattern validation
    const patternFields = { name, email, ph, aadhar, reg, m_name, m_ph, f_name, f_ph, pin };
    for (const key in patternFields) {
        if (patterns[key]) {
            patternFields[key].addEventListener("change", () => {
                validateField(patternFields[key], patterns[key]);
                if (key === "aadhar" && aadhar.value.trim() !== "") {
                    checkAadharDuplicate(aadhar);
                }
                if (key === "reg" && reg.value.trim() !== "") {
                    checkRegnoDuplicate(reg);
                }
            });
        }
    }

    // === Main validation function ===
    function validate_personal() {
        let flag = true;

        validatePattern(name, patterns.name);
        validatePattern(email, patterns.email);
        validatePattern(ph, patterns.ph);
        validatePattern(aadhar, patterns.aadhar);
        validatePattern(reg, patterns.reg);
        validatePattern(m_name, patterns.name);
        validatePattern(m_ph, patterns.ph);
        validatePattern(f_name, patterns.name);
        validatePattern(f_ph, patterns.ph);
        validateBasic(income, !isEmpty(income.value));
        validateBasic(native, !isEmpty(native.value));
        validateBasic(dob, !isEmpty(dob.value));
        validatePattern(pin, patterns.pin);
        validateBasic(doj, !isEmpty(doj.value));
        validateBasic(addr, !isEmpty(addr.value));
        validateBasic(caste, !isEmpty(caste.value));

        validateSelect(m_occ);
        validateSelect(f_occ);
        validateSelect(tongue);
        validateSelect(trans);
        validateSelect(community);

        // Validate radio groups
        const radioNames = ['gender', 'mode', 'first_graduate', 'quota', 'physically_challenged', 'vaccinated', 'under_any_treatment'];
        radioNames.forEach(radioName => {
            const radios = document.getElementsByName(radioName);
            const selected = Array.from(radios).some(r => r.checked);
            if (!selected) {
                alert(`Please select an option for ${radioName}`);
                flag = false;
            }
        });

        // Validate languages
        const langChecked = Array.from(lang).some(cb => cb.checked);
        lang.forEach(cb => {
            cb.addEventListener("change", () => {
                document.getElementById('errr').innerHTML = "";
            });
        });
        if (!langChecked) {
            document.getElementById('errr').innerHTML = "Please select at least one language.";
            flag = false;
        }

        return flag;
    }





    //Academic validation
    const academictype = document.getElementById("acad_type");
    const institution = document.getElementById("inst_name");
    const regno = document.getElementById("acd_reg_no");
    const modeOfStudy = document.getElementById("mode_of_study");
    const modeOfMedium = document.getElementById("mode_of_medium");
    const board = document.getElementById("board");
    const totalMarks = document.getElementById("total_marks");
    const marksObtained = document.getElementById("marks_obtained");
    const percentage = document.getElementById("percentage");
    const cutOff = document.getElementById("cut_off");
    const submitBtn = document.getElementById("submitBtn");
    const storedDataField = document.getElementById("storedData");

    const academicFields = [
        institution,
        regno,
        modeOfStudy,
        modeOfMedium,
        board,
        totalMarks,
        marksObtained,
        percentage,
        cutOff,
    ];

    const academicData = {
        SSLC: {},
        HSC: {}
    };

   academictype.addEventListener("change", function() {
            var selectedValue = academictype.value;
            
            if (selectedValue) {
                institution.disabled = false;
                console.log('You have selected: ' + selectedValue);
            } else {
                institution.disabled = true;
                regno.disabled = true;
                modeOfStudy.disabled = true;
                modeOfMedium.disabled = true;
                board.disabled = true;
                totalMarks.disabled = true;
                marksObtained.disabled = true;
                percentage.disabled = true;
                cutOff.disabled = true;
    
                console.log('No academic type selected');
            }
    });

   function acc_validateField(field, type = "default") {
        const value = field.value.trim();
        let isValid = value !== "";

        if (type === "marks") isValid = isValid && Number(value) > 400;
        if (type === "obtained") isValid = isValid && Number(value) <= Number(totalMarks.value);
        if (type === "percentage") isValid = isValid && Number(value) <= 100;
        if (type === "cutoff") isValid = isValid && Number(value) <= 200;

        field.style.border = isValid ? "1px solid black" : "1px solid red";
        return isValid;
    }
    function storeData() {
        const selectedValue = academictype.value;
        if (!selectedValue) return false;

        let allFilled = true;

        if (!acc_validateField(institution)) allFilled = false;
        if (!acc_validateField(regno)) allFilled = false;
        if (!acc_validateField(modeOfStudy)) allFilled = false;
        if (!acc_validateField(modeOfMedium)) allFilled = false;
        if (!acc_validateField(board)) allFilled = false;
        if (!acc_validateField(totalMarks, "marks")) allFilled = false;
        if (!acc_validateField(marksObtained, "obtained")) allFilled = false;
        if (!acc_validateField(percentage, "percentage")) allFilled = false;
        if (!acc_validateField(cutOff, "cutoff")) allFilled = false;

        if (allFilled) {
            academicData[selectedValue] = {
                institution: institution.value,
                regno: regno.value,
                modeOfStudy: modeOfStudy.value,
                modeOfMedium: modeOfMedium.value,
                board: board.value,
                totalMarks: totalMarks.value,
                marksObtained: marksObtained.value,
                percentage: percentage.value,
                cutOff: cutOff.value
            };
                storedDataField.value = JSON.stringify(academicData);
                console.log("Updated JSON:", storedDataField.value);
                return true; 
            } else {
                console.log("Please fill in all fields correctly.");
                document.getElementById('academic-details').scrollIntoView({ behavior: 'smooth', block: 'start' });
                return false;
            }
    }
    submitBtn.addEventListener("click", function (event) {
        event.preventDefault();
        if (storeData()) {
            disableType();
            // academicFields.forEach(f => {
            //     f.value = "";
            //     f.disabled = true;
            // });
            submitBtn.disabled = true;
        }
    });
    academicFields.forEach(field => {
        field.addEventListener("input", () => {
            let type = "default";
            if (field === totalMarks) type = "marks";
            else if (field === marksObtained) type = "obtained";
            else if (field === percentage) type = "percentage";
            else if (field === cutOff) type = "cutoff";

            acc_validateField(field, type);
        });
    });
    function disableType() {
        const selectedType = academictype.options[academictype.selectedIndex];
        selectedType.disabled = true;
    }
    function validate_acad() {
        let flag = true;

        const f1 = document.getElementById('sslc').innerText;
        const f2 = document.getElementById('hsc').innerText;
        console.log("ssls"+f1);
        console.log("hsc"+f2);

        if (f1 == 'SSLC' && f2 == 'HSC') {
            flag = true;
        } 
        else{
            flag = false;
        }
        return flag;
    }


//extracurriculars

     const MaxDreamCompanyCount = 3;
        const hobbies = document.getElementById('Hobbies');
        const interest = document.getElementById('Interest');
        const ambition = document.getElementById('Ambition');
        

        hobbies.addEventListener("change", function() {
            hobbies.style.borderColor = "";
            console.log("hobbies changed:", hobbies.value);
        });
        interest.addEventListener("change", function() {
            interest.style.borderColor = "";
            console.log("interest changed:", interest.value);
        });
        ambition.addEventListener("change", function() {
            ambition.style.borderColor = "";
            console.log("ambition changed:", ambition.value);
        });
    
        function validate_extracurricular() {
            const Programming_LanguageInputs = document.querySelectorAll('.input-Programming_Language input');
            const otherCoursesInputs = document.querySelectorAll('.input-Other_Courses input');
            const DreamCoursesInputs = document.querySelectorAll('.input-Dream_Company input');


            let flag = true;

            if (hobbies && !validateField(hobbies)) 
                flag = false;
            else if (hobbies) {
                console.log("Hobbies: " + hobbies.value);
            }

            if (interest && !validateField(interest)) 
                flag = false;
            else if (interest) {
                console.log("Interest: " + interest.value);
            }

            if (ambition && !validateField(ambition)) 
                flag = false;
            else if (ambition) {
                console.log("Ambition: " + ambition.value);
            }

            Programming_LanguageInputs.forEach(function(input) {
                    if (!validateField(input)) {
                        flag = false;
                    } else {
                        console.log("Programming Language: " + input.value);
                    }
            });
            

            otherCoursesInputs.forEach(function(input) {
                    if (!validateField(input)) {
                        flag = false;
                    } else {
                        console.log("Other Courses: " + input.value);
                    }
                });
            

            DreamCoursesInputs.forEach(function(input) {
                if (!validateField(input)) flag = false;
                else {
                    console.log("Dream Company: " + input.value);
                }
            });

            return flag;
        }
        form.addEventListener('click', function(event) {
            if (event.target.id === 'addProgrammingLanguage') {
                addDynamicField(event.target.closest('.input-group').querySelector('.input-Programming_Language'));
            } else if (event.target.id === 'addOtherCourses') {
                addDynamicField(event.target.closest('.input-group').querySelector('.input-Other_Courses'));
            } else if (event.target.id === 'addDream_Company') {
                if (document.querySelectorAll('.input-Dream_Company input').length < MaxDreamCompanyCount) {
                    addDynamicField(event.target.closest('.input-group').querySelector('.input-Dream_Company'));
                }
            }            
        });

        function addDynamicField(container) {


            const wrapper = document.createElement('div');
            wrapper.style.display = 'flex';
            wrapper.style.alignItems = 'center';
            wrapper.style.marginBottom = '5px';


            const input = document.createElement('input');
            input.type = 'text';
            input.name = container.classList.contains('input-Programming_Language') ? 'Programming_Language[]' :
                         container.classList.contains('input-Other_Courses') ? 'Other_Courses[]' :
                         'Dream_Company[]';
            input.placeholder = '';
            input.style.width = '200px';
            input.style.marginRight = '5px';

            input.addEventListener('change', function() {
                if (!validateField(input)) {
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = ''; 
                    console.log(" changed:", input.value);
                }
            });
        
                    
            const removeIcon = document.createElement('i');
            removeIcon.className = 'fas fa-minus icon';
            removeIcon.style.cursor = 'pointer';
            removeIcon.style.color = 'red';
            removeIcon.style.marginLeft = '5px';
            removeIcon.addEventListener('click', function() {
                container.removeChild(wrapper);
            });

            wrapper.appendChild(input);
            wrapper.appendChild(removeIcon);
            container.appendChild(wrapper);
        }


  
        // final check -> index.html
                
        finalSubmitBtn.addEventListener("click", function(event) {
            event.preventDefault();
            storeData();
            storedDataField.value = JSON.stringify(academicData);
            
            var f = validate_personal();
            console.log(f);
    
            var acad_f = validate_acad()
            console.log(acad_f);
    
            var isExtraValid = validate_extracurricular();
            console.log(isExtraValid);
    
            if(f == true && acad_f == true && isExtraValid == true)
                form.submit();
            else if(f==false)
                document.getElementById('personal-info').scrollIntoView({ behavior: 'smooth', block: 'start' });
            else if(acad_f==false)
                document.getElementById('academic-details').scrollIntoView({ behavior: 'smooth', block: 'start' });
            else
                document.getElementById('extra-curr').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    

        // final check -> edit
        editSubmitBtn.addEventListener("click", function(event) {
            event.preventDefault();
            const saved = storeData();

            
            if (!saved) {
                alert("Please fill in academic section correctly.");
                document.getElementById('academic-details').scrollIntoView({ behavior: 'smooth', block: 'start' });
                return;
            }

            storedDataField.value = JSON.stringify(academicData);
            console.log("storedDataField.value:", storedDataField.value);
            
            var f = validate_personal();
            console.log(f);
    
            var isExtraValid = validate_extracurricular();
            console.log(isExtraValid);
    
            if(f == true && isExtraValid == true)
                form.submit();
            else if(f==false)
                document.getElementById('personal-info').scrollIntoView({ behavior: 'smooth', block: 'start' });
            else
                document.getElementById('extra-curr').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        
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

});