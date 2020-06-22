<?php

if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

$uID = ($_SESSION["uID"]);
$createDate = date("Y/m/d H:i:s");
$date = date("Y/m/d");

//exit("employment_housenumber : " . $_POST["employment_housenumber"] . " | employment_village : " . $_POST["employment_village"] . " | employment_lane : " . $_POST["employment_lane"] . " | employment_road : " . $_POST["employment_postal"]);
//exit("employment_housenumber2 : " . $_POST["employment_housenumber_permanent"] . " | employment_village : " . $_POST["employment_village_permanent"] . " | employment_lane : " . $_POST["employment_lane_permanent"] . " | employment_road : " . $_POST["employment_postal_permanent"]);
// Start check email seem
$sql_select_old_identification = "SELECT card_number FROM hr_person_card";
$query_old_identification = mysqli_query($conn, $sql_select_old_identification);
while (list($old_identification) = mysqli_fetch_row($query_old_identification)) {
    if ($_POST['identification'] == $old_identification) {
        ?>
        <script>
            alert("หมายเลขบัตรประชาชนซ้ำกันกับในระบบ!");
            window.history.back();
        </script>
        <?php
        exit();
    }
}
// Finish check email seem

// Start check email seem
$sql_select_old_email = "SELECT person_email FROM hr_person";
$query_old_email = mysqli_query($conn, $sql_select_old_email) or die("Sql error is : " . mysqli_error($conn));

while (list($old_email) = mysqli_fetch_row($query_old_email)) {

    if ($_POST['email'] == $old_email) {
        ?>
        <script>
            alert("อีเมลล์ซ้ำกันกับในระบบ!");
            window.history.back();
        </script>
        <?php
        exit();
    }
}

// Finish check email seem

if (isset($_POST['hidden_add_id'])) {
    $hidden_add_id = $_POST['hidden_add_id'];

    // process reference
    $temp_f_status = 1;
    $temp_m_status = 1;

    if (!isset($_POST['f_status'])) $temp_f_status = 0;
    else $temp_f_status = 1;

    if (!isset($_POST['mother_status'])) $temp_m_status = 0;
    else $temp_m_status = 1;

    //Process skills
    if (isset($_POST['drive_car'])) $drive_car = 1;
    else $drive_car = 0;

    if (isset($_POST['drive_motorcycle'])) $drive_motorcycle = 1;
    else $drive_motorcycle = 0;

    if (isset($_POST['license_car'])) $license_car = 1;
    else $license_car = 0;

    if (isset($_POST['license_motorcycle'])) $license_motorcycle = 1;
    else $license_motorcycle = 0;

    if (isset($_POST['can_computer'])) $can_computer = 1;
    else $can_computer = 0;

    if (isset($_POST['can_calculator'])) $can_calculator = 1;
    else $can_calculator = 0;

    if (isset($_POST['can_typing'])) $can_typing = 1;
    else $can_typing = 0;

    if (empty($_POST['position'])) $position = "";
    else $position = $_POST['position'];

    if (empty($_POST['ability_etc'])) $ability_etc = "";
    else $ability_etc = $_POST['ability_etc'];

    // if (isset($_FILES['personImage']['tmp_name']) && isset($_FILES['personResume']['tmp_name'])) {

        $img = "";
        $resume = "";

        $phpFileUploadErrors = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if (!empty($_FILES["personImage"]["name"])) {
            $check = getimagesize($_FILES["personImage"]["tmp_name"]);
            if ($check !== false) {

                $rds = '';
                for ($i = 0; $i < 5; $i++) {
                    $rds .= $characters[rand(0, strlen($characters) - 1)];
                }

                $target_dir_image = "storages/person/" . date("Ymd");

                if (!file_exists($target_dir_image)) {
                    mkdir($target_dir_image, 0777, true) or die("Cannot Create $target_dir_image");
                }
                $upload_file = $target_dir_image . "/" . basename($_FILES["personImage"]["name"]);
                $ext = pathinfo($upload_file, PATHINFO_EXTENSION);

                $new_name = "person_" . date("His") . "_{$rds}_{$_SESSION["uID"]}." . $ext;
                $target_file = $target_dir_image . "/" . basename($new_name);

                if (move_uploaded_file($_FILES["personImage"]["tmp_name"], $target_file)) {
                    $img = $target_file;
                } else {
                    die("
					Sorry, there was an error uploading your file. Please contact system administrator.<br>
					File Upload Name: {$_FILES["personImage"]["name"]}<br>
					New Upload Name: $newName<br>
					Target File Name: $target_file<br>
					Error #: {$_FILES["personImage"]["error"]} : " . $phpFileUploadErrors[$_FILES["personImage"]["error"]]
                    );
                }
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }

        if (!empty($_FILES["personResume"]["name"])) {
            $resume_name = $_FILES['personResume']['name'];
            $resume_type = $_FILES['personResume']['type'];
            $resume_size = $_FILES['personResume']['size'];

            if ($resume_type != "application/pdf") {
                ?>
                <script>
                    alert("* กรุณาใส่ข้อมูล resume เป็นไฟล์ .PDF เท่านั้น");
                    window.history.back();
                </script>
                <?php
                exit();
            }

            if (!empty($_FILES["personResume"]["name"])) {

                $resume_name = $_FILES['personResume']['name'];
                $resume_type = $_FILES['personResume']['type'];
                $resume_size = $_FILES['personResume']['size'];

                if ($resume_type != "application/pdf") {
                    ?>
                    <script>
                        alert("* กรุณาใส่ข้อมูล resume เป็นไฟล์ .PDF เท่านั้น");
                        window.history.back();
                    </script>
                    <?php
                    exit();
                }

                $check = $_FILES["personResume"]["tmp_name"];
                if ($check !== false) {
                    $rds = '';
                    for ($i = 0; $i < 5; $i++) {
                        $rds .= $characters[rand(0, strlen($characters) - 1)];
                    }

                    $target_dir_resume = "storages/resume_person/" . date("Ymd");

                    if (!file_exists($target_dir_resume)) {
                        mkdir($target_dir_resume, 0777, true);
                    }
                    $upload_file = $target_dir_resume . "/" . basename($_FILES["personResume"]["name"]);
                    $ext = pathinfo($upload_file, PATHINFO_EXTENSION);

                    $new_name = "RESUME_" . date("His") . "_{$rds}_{$_SESSION["uID"]}." . $ext;
                    $target_file = $target_dir_resume . "/" . basename($new_name);

                    if (move_uploaded_file($_FILES["personResume"]["tmp_name"], $target_file)) {
                        $resume = $target_file;
                    } else {
                        die("
					Sorry, there was an error uploading your file. Please contact system administrator.<br>
					File Upload Name: {$_FILES["personResume"]["name"]}<br>
					New Upload Name: $newName<br>
					Target File Name: $target_file<br>
					Error #: {$_FILES["personResume"]["error"]} : " . $phpFileUploadErrors[$_FILES["personResume"]["error"]]
                        );
                    }
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }
        }

        list($year_person, $month_person, $day_person) = explode("-", $_POST['birth_date']);
        list($year, $month, $day) = explode("/", $date);

        
        // Process sql insert person
        $age = ($year - $year_person);
        $sql_insert_person=" INSERT INTO hr_person SET 
            person_prename='{$_POST["prename"]}',
            person_firstname_thai='{$_POST["fname_thai"]}',
            person_lastname_thai='{$_POST["lname_thai"]}',
            person_firstname_eng='{$_POST["fname_eng"]}',
            person_lastname_eng='{$_POST["lname_eng"]}',
            person_nickname='{$_POST["nickname"]}',
            person_sex='{$_POST["sex"]}',
            person_birthday='{$_POST["birth_date"]}',
            person_birthtime='{$_POST["birth_time"]}',
            person_age='$age',
            person_photo='$img',
            person_email='{$_POST["email"]}',
            person_phone='{$_POST["phone"]}',
            person_national='{$_POST["national"]}',
            person_ethnicity='{$_POST["ethnicity"]}',
            person_religion='{$_POST["religion"]}',
            person_soldier_status='{$_POST["soldier"]}',
            person_blood_group='{$_POST["blood"]}',
            person_high='{$_POST["high"]}',
            person_weight='{$_POST["weight"]}',
            person_born='{$_POST["born"]}',
            person_living_status='{$_POST["living_status"]}',
            person_marital_status='{$_POST["marital_status"]}',
            person_married_status='{$_POST["married_status"]}',
            person_resume='$resume',
            person_createDate='$createDate',
            person_createBy='$uID',
            person_updatedBy='0',
            person_updatedDate='$createDate',
            deleted='0' ,
            cre_login = '0'
        ";

//        echo "date time : ".$_POST['birth_time'];
//        echo " $age = ($year - $year_person) ";
//        $age = ($year - $year_person);
//        echo "age : ".$age;
//        echo "sql : ".$sql_insert_person;
//        exit();

        $query_person = mysqli_query($conn, $sql_insert_person) or die("sql error person is : " . mysqli_error($conn));

        // Process sql insert card
        $sql_insert_card = "INSERT INTO hr_person_card(typecard_id, person_id, card_number, card_issued, card_expired) VALUE('{$_POST["type"]}','{$_POST["hidden_add_id"]}','{$_POST["identification"]}','{$_POST["issued_date"]}','{$_POST["expired_date"]}')";
        $query_insert_card = mysqli_query($conn, $sql_insert_card);

        // Process sql insert address
        $sql_insert_present_address = "INSERT INTO hr_present_address(person_id, present_address_housenumber, present_address_village, present_address_lane, present_address_road, present_address_subarea, present_address_area, present_address_province, present_address_postal) VALUES('{$_POST["hidden_add_id"]}','{$_POST["employment_housenumber"]}','{$_POST["employment_village"]}','{$_POST["employment_lane"]}','{$_POST["employment_road"]}','{$_POST["employment_subarea"]}','{$_POST["employment_area"]}','{$_POST["employment_province"]}','{$_POST["employment_postal"]}'  ) ";
        $query_present_address = mysqli_query($conn, $sql_insert_present_address) or die("sql error present_address is : " . mysqli_error($conn));
        $sql_insert_permanent_address = "INSERT INTO hr_permanent_address(person_id, permanent_address_housenumber, permanent_address_village, permanent_address_lane, permanent_address_road, permanent_address_subarea, permanent_address_area, permanent_address_province, permanent_address_postal) VALUES('{$_POST["hidden_add_id"]}','{$_POST["employment_housenumber_permanent"]}','{$_POST["employment_village_permanent"]}','{$_POST["employment_lane_permanent"]}','{$_POST["employment_road_permanent"]}','{$_POST["employment_subarea_permanent"]}','{$_POST["employment_area_permanent"]}','{$_POST["employment_province_permanent"]}','{$_POST["employment_postal_permanent"]}'  ) ";
        $query_permanent_address = mysqli_query($conn, $sql_insert_permanent_address) or die("sql error permanent_address is : " . mysqli_error($conn));

        // Process sql insert reference
        $sql_reference = "INSERT INTO hr_person_reference( person_id, reference_father_fullname, reference_father_age, reference_father_career, reference_father_status, reference_mother_fullname, reference_mother_age, reference_mother_career, reference_mother_status, reference_contact_fullname, reference_contact_relationshop, reference_contact_address, reference_contact_position, reference_contact_phone) VALUES('{$_POST["hidden_add_id"]}','{$_POST["father_name"]}','{$_POST["father_age"]}','{$_POST["father_career"]}','$temp_f_status','{$_POST["mother_name"]}','{$_POST["mother_age"]}','{$_POST["mother_career"]}','$temp_m_status','{$_POST["reference_name"]}','{$_POST["relationship"]}','{$_POST["reference_address"]}','$position','{$_POST["reference_phone"]}') ";
        $query_reference = mysqli_query($conn, $sql_reference) or die("sql error reference is : " . mysqli_error($conn));

        // Process sql insert skill
        $sql_skill = "INSERT INTO hr_person_skills(person_id, skill_english_understand, skill_english_speaking, skill_english_reading, skill_english_writing, skill_driving_car, skill_car_license, skill_driving_motorcycle, skill_motorcycle_license, skill_computer, skill_typing, skill_calculator, skill_ability) VALUES('{$_POST["hidden_add_id"]}','{$_POST["understand"]}','{$_POST["speaking"]}','{$_POST["reading"]}','{$_POST["writing"]}','$drive_car','$license_car','$drive_motorcycle','$license_motorcycle','$can_computer','$can_typing','$can_calculator','$ability_etc')";
        $query_skill = mysqli_query($conn, $sql_skill) or die("Sql error skill : " . mysqli_error($conn));

        if ($query_person && $query_present_address && $query_permanent_address && $query_reference && $query_skill && $query_insert_card) {
            mysqli_close($conn);
            ?>
            <script>
                alert("เพิ่มข้อมูลบุคลากร เรียบร้อยแล้ว!");
                window.location = "index.php?mod=hr/form_add_history&add_id=<?=$hidden_add_id?>";
            </script>
            <?php
        }

    // } 

}
?>

