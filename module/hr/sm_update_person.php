<?php
/**
 * Created by PhpStorm.
 * User: Avaibooking
 * Date: 1/19/2018
 * Time: 1:32 PM
 */
if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

if (!isset($_POST['hidden_edit_id'])) {
    exit("<script>window.location = './';</script>");
}

$uID = ($_SESSION["uID"]);
$updateDate = date("Y/m/d H:i:s");
$date = date("Y/m/d");

// check status
if (!isset($_POST['f_status'])) $temp_f_status = 0;
else $temp_f_status = 1;

if (!isset($_POST['mother_status'])) $temp_m_status = 0;
else $temp_m_status = 1;

if (isset($_POST['married_status'])) $married_status = 1;
else $married_status = 0;

if (isset($_POST['marital_status'])) $marital_status = 1;
else $marital_status = 0;

// Set variable for skills
if (isset($_POST['drive_car'])) $drive_car = 1;
else $drive_car = 0;

if (isset($_POST['drive_motorcycle'])) $drive_motorcycle = 1;
else $drive_motorcycle = 0;

if (empty($_POST['license_car'])) $license_car = 0;
if (isset($_POST['license_car'])) $license_car = 1;

if (empty($_POST['license_motorcycle'])) $license_motorcycle = 0;
if (isset($_POST['license_motorcycle'])) $license_motorcycle = 1;

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


//    echo "drive_car : ".$drive_car;
//    echo "drive_motorcycle : ".$drive_motorcycle;
//    echo "license_car : ".$license_car;
//    echo "license_motorcycle : ".$license_motorcycle;
//    echo "can_computer : ".$can_computer;
//    echo "can_calculator : ".$can_calculator;
//    echo "can_typing : ".$can_typing;
//    echo "position : ".$position;
//    echo "ability_etc : ".$ability_etc;


//                echo "identification : ".$_POST['identification'];
//                echo "issued_date : ".$_POST['issued_date'];
//                echo "expired_date : ".$_POST['expired_date'];
//
//            exit();

// _______________________ Check old email
$chk_email = 1;
$sql_old_email_chk = "SELECT person_email FROM hr_person WHERE person_id='$_POST[hidden_edit_id]' ";
$query_old_email = mysqli_query($conn, $sql_old_email_chk);
list($old_email) = mysqli_fetch_row($query_old_email);

$sql_chk_email = "SELECT * FROM hr_person WHERE person_email='$_POST[email]' AND person_email!='$old_email' ";
$query_chk_email = mysqli_query($conn, $sql_chk_email);
$num_email_chk = mysqli_num_rows($query_chk_email);

if ($_POST['email'] == $old_email && $num_email_chk == 0) $chk_email = 1;
else if ($_POST['email'] != $old_email && $num_email_chk == 0) $chk_email = 1;
else $chk_email = 0;

if ($chk_email == 0) {
    ?>
    <script>
        alert("*ข้อมูลอีเมลล์ซ้ำกับ ข้อมูลภายในระบบ");
        window.history.back();
    </script>
    <?php
    exit();
}

// _______________________ Check old card_number
$chk = 1;
$sql_select_old = "SELECT card_number FROM hr_person_card WHERE person_id='{$_POST["hidden_edit_id"]}' ";
$query_chk_oldid = mysqli_query($conn, $sql_select_old);
list($old_id) = mysqli_fetch_row($query_chk_oldid);

$sql_select_chk = "SELECT * FROM hr_person_card WHERE card_number='{$_POST["identification"]}' AND card_number!='$old_id' ";
$query_chk_id = mysqli_query($conn, $sql_select_chk);
$num_id = mysqli_num_rows($query_chk_id);
list($id) = mysqli_fetch_row($query_chk_id);

if ($old_id == $_POST['identification'] && $num_id == 0) $chk = 1;
else if ($_POST['identification'] != $old_id && $num_id == 0) $chk = 1;
else $chk = 0;

if ($chk == 0) {
    ?>
    <script>
        alert("*ข้อมูลรหัสบัตรประจำตัวซ้ำกับ ข้อมูลภายในระบบ");
        window.history.back();
    </script>
    <?php
    exit();
}

if (isset($_FILES['edit_personImage']['tmp_name']) || isset($_FILES['edit_personResume']['tmp_name'])) {

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

    // Process check old file and resume
    $sql_select_old_file = "SELECT person_photo FROM hr_person WHERE person_id='$_POST[hidden_edit_id]'";
    $sql_select_old_resume = "SELECT person_resume FROM hr_person WHERE person_id='$_POST[hidden_edit_id]'";
    $query_old_file = mysqli_query($conn, $sql_select_old_file) or die("Mysql error is : " . mysqli_error($conn));
    $query_old_resume = mysqli_query($conn, $sql_select_old_resume) or die("Mysql error is : " . mysqli_error($conn));
    list($old_file) = mysqli_fetch_row($query_old_file);
    list($old_resume) = mysqli_fetch_row($query_old_resume);
    $num_file = mysqli_num_rows($query_old_file);
    $num_resume = mysqli_num_rows($query_old_resume);


    if ($_FILES["edit_personImage"]["name"] != "") {
        if ($num_file > 0) unlink("././" . $old_file);

        $img = "";
        $check = getimagesize($_FILES["edit_personImage"]["tmp_name"]);
        if ($check !== false) {

            $rds = '';
            for ($i = 0; $i < 5; $i++) {
                $rds .= $characters[rand(0, strlen($characters) - 1)];
            }

            $target_dir_image = "storages/person/" . date("Ymd");

            if (!file_exists($target_dir_image)) {
                mkdir($target_dir_image, 0777, true);
            }
            $upload_file = $target_dir_image . "/" . basename($_FILES["edit_personImage"]["name"]);
            $ext = pathinfo($upload_file, PATHINFO_EXTENSION);

            $new_name = "person_" . date("His") . "_{$rds}_{$_SESSION["uID"]}." . $ext;
            $target_file = $target_dir_image . "/" . basename($new_name);
            if (move_uploaded_file($_FILES["edit_personImage"]["tmp_name"], $target_file)) {
                $img = $target_file;
            } else {
                die("
					Sorry, there was an error uploading your file. Please contact system administrator.<br>
					File Upload Name: {$_FILES["edit_personImage"]["name"]}<br>
					New Upload Name: $newName<br>
					Target File Name: $target_file<br>
					Error #: {$_FILES["edit_personImage"]["error"]} : " . $phpFileUploadErrors[$_FILES["edit_personImage"]["error"]]
                );
            }
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    } else
        $img = "";

    if ($_FILES["edit_personResume"]["name"] != "") {
        $resume = "";
        $resume_name = $_FILES['edit_personResume']['name'];
        $resume_type = $_FILES['edit_personResume']['type'];
        $resume_size = $_FILES['edit_personResume']['size'];

        if ($resume_type != "application/pdf") {
            ?>
            <script>
                alert("* กรุณาใส่ข้อมูล resume เป็นไฟล์ .PDF เท่านั้น");
                window.history.back();
            </script>
            <?php
            exit();
        }

        if ($num_resume > 0) unlink("././" . $old_resume);
        $check = $_FILES["edit_personResume"]["tmp_name"];

        if ($check !== false) {

            $rds = '';
            for ($i = 0; $i < 5; $i++) {
                $rds .= $characters[rand(0, strlen($characters) - 1)];
            }

            $target_dir_resume = "storages/resume_person/" . date("Ymd");

            if (!file_exists($target_dir_resume)) {
                mkdir($target_dir_resume, 0777, true);
            }
            $upload_file = $target_dir_resume . "/" . basename($_FILES["edit_personResume"]["name"]);
            $ext = pathinfo($upload_file, PATHINFO_EXTENSION);

            $new_name = "RESUME_" . date("His") . "_{$rds}_{$_SESSION["uID"]}." . $ext;
            $target_file = $target_dir_resume . "/" . basename($new_name);

            if (move_uploaded_file($_FILES["edit_personResume"]["tmp_name"], $target_file)) {
                $resume = $target_file;
            } else {
                die("
					Sorry, there was an error uploading your file. Please contact system administrator.<br>
					File Upload Name: {$_FILES["edit_personResume"]["name"]}<br>
					New Upload Name: $newName<br>
					Target File Name: $target_file<br>
					Error #: {$_FILES["edit_personResume"]["error"]} : " . $phpFileUploadErrors[$_FILES["edit_personResume"]["error"]]
                );
            }
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    } else
        $resume = "";
}

list($year_person, $month_person, $day_person) = explode("-", $_POST['birth_date']);
list($year, $month, $day) = explode("/", $date);

$age = ($year - $year_person);
//echo "age : ".$age;
//exit();

if ($img != "") {
    $sql_update_photo = "UPDATE hr_person SET person_photo='$img' WHERE person_id='{$_POST["hidden_edit_id"]}'";
    $query_photo = mysqli_query($conn, $sql_update_photo) or die("sql error is : " . mysqli_error($conn));
}
if ($resume != "") {
    $sql_update_resume = "UPDATE hr_person SET person_resume='$resume' WHERE person_id='{$_POST["hidden_edit_id"]}'";
    $query_resume = mysqli_query($conn, $sql_update_resume) or die("sql error is : " . mysqli_error($conn));
}

// Process sql update person
$sql_update_person = "UPDATE hr_person SET person_prename='{$_POST["edit_prename"]}', person_firstname_thai='{$_POST["fname_thai"]}', person_lastname_thai='{$_POST["lname_thai"]}', person_firstname_eng='{$_POST["fname_eng"]}', person_lastname_eng='{$_POST["lname_eng"]}',person_nickname='{$_POST["nickname"]}', person_sex='{$_POST["edit_sex"]}', person_birthday='{$_POST["birth_date"]}',person_birthtime='{$_POST["birth_time"]}', person_age='$age', person_email='{$_POST["email"]}', person_phone='{$_POST["phone"]}', person_national='{$_POST["national"]}', person_ethnicity='{$_POST["ethnicity"]}', person_religion='{$_POST["religion"]}', person_soldier_status='{$_POST["edit_soldier"]}', person_blood_group='{$_POST["blood"]}', person_high='{$_POST["high"]}', person_weight='{$_POST["weight"]}', person_born='{$_POST["born"]}', person_living_status='{$_POST["living_status"]}', person_marital_status='{$_POST["marital_status"]}', person_married_status='$married_status', person_updatedBy='$uID',person_updatedDate='$updateDate' WHERE person_id='{$_POST["hidden_edit_id"]}'";
$query_person = mysqli_query($conn, $sql_update_person) or die("sql error is : " . mysqli_error($conn));

// Process sql update care
$sql_update_care = "UPDATE hr_person_card SET typecard_id='{$_POST["type"]}',person_id='{$_POST["hidden_edit_id"]}',card_number='{$_POST["identification"]}',card_issued='{$_POST["issued_date"]}',card_expired='{$_POST["expired_date"]}' WHERE person_id='{$_POST["hidden_edit_id"]}' ";
$query_update_care = mysqli_query($conn, $sql_update_care) or die("sql error is : " . mysqli_error($conn));

// Process sql update reference
$sql_update_reference = "UPDATE hr_person_reference SET reference_father_fullname='{$_POST["father_name"]}', reference_father_age='{$_POST["father_age"]}', reference_father_career='{$_POST["father_career"]}', reference_father_status='$temp_f_status', reference_mother_fullname='{$_POST["mother_name"]}', reference_mother_age='{$_POST["mother_age"]}', reference_mother_career='{$_POST["mother_career"]}', reference_mother_status='$temp_m_status', reference_contact_fullname='{$_POST["reference_name"]}', reference_contact_relationshop='{$_POST["relationship"]}', reference_contact_address='{$_POST["reference_address"]}', reference_contact_position='{$_POST["position"]}', reference_contact_phone='{$_POST["reference_phone"]}' WHERE person_id='{$_POST["hidden_edit_id"]}'";
$query_update_reference = mysqli_query($conn, $sql_update_reference) or die("sql error is : " . mysqli_error($conn));

// Process sql update skills
$sql_update_skills = "UPDATE hr_person_skills SET skill_english_understand='{$_POST["understand"]}', skill_english_speaking='{$_POST["speaking"]}', skill_english_reading='{$_POST["reading"]}', skill_english_writing='{$_POST["writing"]}', skill_driving_car='$drive_car', skill_car_license='$license_car', skill_driving_motorcycle='$drive_motorcycle', skill_motorcycle_license='$license_motorcycle', skill_computer='$can_computer', skill_typing='$can_typing', skill_calculator='$can_calculator', skill_ability='{$_POST["ability_etc"]}' WHERE person_id='{$_POST["hidden_edit_id"]}' ";
$query_update_skills = mysqli_query($conn, $sql_update_skills) or die("Sql error : " . mysqli_error($conn));

//Process sql update present address
$sql_update_present_address = "UPDATE hr_present_address SET person_id='{$_POST["hidden_edit_id"]}', present_address_housenumber='{$_POST["employment_housenumber"]}', present_address_village='{$_POST["employment_village"]}',present_address_lane='{$_POST["employment_lane"]}',present_address_road='{$_POST["employment_road"]}', present_address_subarea='{$_POST["employment_subarea"]}', present_address_area='{$_POST["employment_area"]}', present_address_province='{$_POST["employment_province"]}',present_address_postal='{$_POST["employment_postal"]}' WHERE person_id='{$_POST["hidden_edit_id"]}' ";
$sql_update_permanent_address = "UPDATE hr_permanent_address SET person_id='{$_POST["hidden_edit_id"]}', permanent_address_housenumber='{$_POST["employment_housenumber_permanent"]}', permanent_address_village='{$_POST["employment_village_permanent"]}',permanent_address_lane='{$_POST["employment_lane_permanent"]}',permanent_address_road='{$_POST["employment_road_permanent"]}', permanent_address_subarea='{$_POST["employment_subarea_permanent"]}', permanent_address_area='{$_POST["employment_area_permanent"]}', permanent_address_province='{$_POST["employment_province_permanent"]}',permanent_address_postal='{$_POST["employment_postal_permanent"]}' WHERE person_id='{$_POST["hidden_edit_id"]}' ";
$query_present_address = mysqli_query($conn, $sql_update_present_address);
$query_permanent_address = mysqli_query($conn, $sql_update_permanent_address);

if ($query_update_care && $query_update_reference && $query_update_skills && $query_person && $query_present_address && $query_permanent_address) {
    mysqli_close($conn);
    ?>
    <script>
        alert("แก้ไขขข้อมูล เรียบร้อยแล้ว!");
        window.location = "index.php?mod=hr/form_edit_history&edit_id=<?=$_POST['hidden_edit_id']?>";
    </script>
    <?php
}
?>

