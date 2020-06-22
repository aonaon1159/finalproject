<?php
if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");

include("inc/topnav.php");

if (!isset($_GET['id'])) exit("<script>window.location = './';</script>");

$sql_select_person = "SELECT * FROM hr_person WHERE person_id='{$_GET["id"]}' ";
$query_person = mysqli_query($conn, $sql_select_person);
$person = mysqli_fetch_array($query_person);

$sql_select_card = "SELECT * FROM hr_person_card WHERE person_id='$person[0]' ";
$query_card = mysqli_query($conn, $sql_select_card);
$card = mysqli_fetch_array($query_card);

$sql_select_present_address = "SELECT * FROM hr_present_address WHERE person_id='$person[0]' ";
$query_present_address = mysqli_query($conn, $sql_select_present_address);
$present_address = mysqli_fetch_array($query_present_address);

$sql_select_permanent_address = "SELECT * FROM hr_permanent_address WHERE person_id='$person[0]' ";
$query_permanent_address = mysqli_query($conn, $sql_select_permanent_address);
$permanent_address = mysqli_fetch_array($query_permanent_address);

$sql_select_reference = "SELECT * FROM hr_person_reference WHERE person_id='$person[0]' ";
$query_reference = mysqli_query($conn, $sql_select_reference);
$reference = mysqli_fetch_array($query_reference);

$sql_select_skills = "SELECT * FROM hr_person_skills WHERE person_id='$person[0]' ";
$query_skills = mysqli_query($conn, $sql_select_skills);
$skills = mysqli_fetch_array($query_skills);

$sql_education = "SELECT * FROM hr_person_education WHERE person_id='{$_GET["id"]}' ORDER BY degree_id DESC ";
$sql_history = "SELECT * FROM hr_person_history WHERE person_id='{$_GET["id"]}' ORDER BY history_finish DESC ";

$sql_select_employment = "SELECT * FROM hr_person_employment WHERE person_id='{$_GET["id"]}'";
$query_employment = mysqli_query($conn, $sql_select_employment);
$employment = mysqli_fetch_row($query_employment);

?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">Human Resources.</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-user-circle"></i> ข้อมูลบุคลาการ
                    <div class="pull-right">
                        <div class="btn-group">

                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <form id="form_edit_person" class="form-horizontal" role="form" method="post"
                                      enctype="multipart/form-data" action="index.php?mod=hr/sm_update_person">

                                    <h4 class="page-header">ประวัติส่วนตัว</h4>

                                    <input type="hidden" id="hidden_edit_id" name="hidden_edit_id"
                                           value="<?= $person[0] ?>">

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-4"></div>
                                        <div class="form-group col-sm-4" style="text-align:center;">
                                            <a href="././<?= $person[10] ?>" data-lightbox="image-1"
                                               data-title="<?= $person[2] . " " . $person[3] ?>">
                                                <img src="././<?= $person[10] ?>"
                                                     style="max-width: 250px; max-height: 200px; border: solid 1px#1b2426;">
                                            </a>
                                        </div>
                                        <div class="form-group col-sm-4">

                                        </div>
                                    </div>
                                    <div class="col-sm-12"><br></div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label">รหัสผู้สมัคร : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="edit_id_show"
                                                       name="edit_id_show" value="<?= $person[0] ?>"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label">ชื่อเล่น :</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="edit_nickname_show" 
                                                name="edit_nickname_show" value="<?= $person[30] ?>" disabled>
                                            </div>
                                        </div>
                                        <?php
                                        if ($person[24] != "") {
                                            ?>
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label">Resume : </label>
                                                <div class="col-sm-8">
                                                    <label class="col-sm-4 control-label "
                                                           autofocus="autofocus" style="text-align:left;">
                                                        <a href="<?= $person[24] ?>">Resume file.</a>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label">คำนำหน้าชื่อ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" id="edit_prename" name="edit_prename"  class="form-control" value="<?php 
                                                if ($person[6] == 1) echo "นาย ,Mr.";
                                                if ($person[6] == 2) echo "นางสาว ,Mis.";
                                                if ($person[6] == 3) echo "นาง ,Mrs."; ?>" disabled>

                                                
                                                <!-- <select id="edit_prename" name="edit_prename"
                                                        class="form-control"
                                                        autofocus="autofocus" onchange="check_prename();"
                                                        disabled>
                                                    <option value="0">กรุณาเลือกคำนำหน้าชื่อ</option>
                                                    <option value="1" <?php if ($person[1] == 1) echo " selected"; ?> >
                                                        นาย ,Mr.
                                                    </option>
                                                    <option value="2" <?php if ($person[1] == 2) echo " selected"; ?> >
                                                        นางสาว ,Mis.
                                                    </option>
                                                    <option value="3" <?php if ($person[1] == 3) echo " selected"; ?> >
                                                        นาง ,Mrs.
                                                    </option>
                                                </select> -->
                                                <div id="alert_prename"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">เพศ : </label>
                                            <div class="col-sm-3">
                                                <input type="text" id="edit_sex" name="edit_sex" class="form-control" value="<?php 
                                                if ($person[6] == 1) echo "ชาย";
                                                else echo "หญิง";  ?>" disabled>
                                               <!--  <select id="edit_sex" name="edit_sex" class="form-control"
                                                        onchange="check_edit_sex();" disabled>
                                                    <option value="0" <?php if ($person[6] == 0) {
                                                        echo " selected";
                                                    } ?> >กรุณาเลือก เพศ
                                                    </option>
                                                    <option value="1" <?php if ($person[6] == 1) {
                                                        echo " selected";
                                                    } ?> >ชาย
                                                    </option>
                                                    <option value="2" <?php if ($person[6] == 2) {
                                                        echo " selected";
                                                    } ?> >หญิง
                                                    </option>
                                                </select> -->
                                                <div id="alert_sex"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                            <label class="col-sm-2 control-label">อายุ : </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="edit_id_show"
                                                       name="edit_id_show" value="<?= $person[9] . " ปี" ?>"
                                                       disabled>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ชื่อ (ไทย) : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="fname_thai"
                                                       name="fname_thai"
                                                       placeholder="ชื่อจริง"
                                                       onkeyup="return check_fname_thai();" maxlength="55"
                                                       autofocus="autofocus" value="<?= $person[2] ?>" disabled>
                                                <div id="alert_fname_thai"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">Firstname (English)
                                                : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="fname_eng"
                                                       name="fname_eng"
                                                       placeholder="Firstname"
                                                       onkeyup="return check_fname_eng();"
                                                       maxlength="55" value="<?= $person[4] ?>" disabled>
                                                <div id="alert_fname_eng"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">นามสกุล (ไทย) : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="lname_thai"
                                                       name="lname_thai"
                                                       placeholder="นามสกุล"
                                                       onkeyup="return check_lname_thai();" maxlength="55"
                                                       value="<?= $person[3] ?>" disabled>
                                                <div id="alert_lname_thai"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">Lastname (English) : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="lname_eng"
                                                       name="lname_eng"
                                                       placeholder="Lastname"
                                                       onkeyup="return check_lname_eng();"
                                                       maxlength="55" value="<?= $person[5] ?>" disabled>
                                                <div id="alert_lname_eng"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">วันที่ / เดือน / ปีเกิด : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="birth_date"
                                                       name="birth_date"
                                                       data-errormessage-value-missing="กรุณากรอกวันเกิด (ค.ศ.)"
                                                       required value="<?= fullThaiDate($person[7], 0); ?>" readonly>
                                                <div id="alert_birth_date"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                              <label class="col-sm-4 control-label " style="text-align:right;">เวลา : </label>
                                            <div class="col-sm-8">
                                                <input type="TIME" name="birth_time" step="2"
                                                       placeholder="กรอกเวลาเกิด" Class="form-control"
                                                       data-errormessage-value-missing="*กรุณากรอกเวลาเกิด"
                                                       value="<?= $person[8] ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">อีเมล : </label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" id="email" name="email"
                                                       onkeyup="return check_email();"
                                                       placeholder="test@gmail.com"
                                                       maxlength="55" value="<?= $person[11] ?>" disabled>
                                                <div id="alert_email"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">เบอร์โทรศัพท์ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                       onkeyup="return check_phone();"
                                                       placeholder="เบอร์โทรติดต่อ"
                                                       maxlength="10" value="<?= $person[12] ?>" disabled>
                                                <div id="alert_phone"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">สัญชาติ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="national"
                                                       name="national"
                                                       onkeyup="return check_national();" placeholder="สัญชาติ"
                                                       maxlength="50" value="<?= $person[13] ?>" disabled>
                                                <div id="alert_national"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">เชื้อชาติ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="ethnicity"
                                                       name="ethnicity"
                                                       onkeyup="return check_ethnicity();"
                                                       placeholder="เชื้อชาติ"
                                                       maxlength="50" value="<?= $person[14] ?>" disabled>
                                                <div id="alert_ethnicity"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ศาสนา : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="religion"
                                                       name="religion"
                                                       onkeyup="return check_religion();" placeholder="ศาสนา"
                                                       maxlength="50" value="<?= $person[15] ?>" disabled>
                                                <div id="alert_religion"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        

                                        <?php
                                        if ($person[6] != 2){
                                        ?>

                                            <div id="div_edit_soldier">
                                                <div class="form-group col-sm-6">
                                                    <label class="col-sm-4 control-label ">สถานภาพทางทหาร : </label>
                                                    <div class="col-sm-8">
                                                        <input type=text id="edit_soldier" name="edit_soldier" class="form-control" value="<?php 
                                                        if ($person[16] == 0) echo "กรุณาเลือกสถานภาพทางทหาร";
                                                        if ($person[16] == 1) echo "อยู่ในระหว่างรับราชการทหาร";
                                                        if ($person[16] == 2) echo "ผ่านการเกณฑ์ทหาร";
                                                        if ($person[16] == 3) echo "ได้รับการยกเว้น"; ?>" disabled> 
                                                        <!-- <select id="edit_soldier" name="edit_soldier"
                                                                class="form-control"
                                                                onchange="check_edit_soldier();" disabled>
                                                            <option value="0" <?php if ($person[16] == 0) {
                                                                echo " selected";
                                                            } ?>> กรุณาเลือกสถานภาพทางทหาร
                                                            </option>
                                                            <option value="1" <?php if ($person[16] == 1) {
                                                                echo " selected";
                                                            } ?>>อยู่ในระหว่างรับราชการทหาร
                                                            </option>
                                                            <option value="2" <?php if ($person[16] == 2) {
                                                                echo " selected";
                                                            } ?>>ผ่านการเกณฑ์ทหาร
                                                            </option>
                                                            <option value="3" <?php if ($person[16] == 3) {
                                                                echo " selected";
                                                            } ?>>ได้รับการยกเว้น
                                                            </option>
                                                        </select> -->
                                                        <div id="alert_edit_soldier"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        


                                        <?php
                                        }
                                        ?>
                                </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">หมู่โลหิต : </label>
                                            <div class="col-sm-8">
                                                <?php
                                                $blood = "";
                                                if ($person[17] == 1) $blood = "O";
                                                else if ($person[17] == 2) $blood = "A";
                                                else if ($person[17] == 3) $blood = "B";
                                                else $blood = "AB";
                                                ?>
                                                <input type="text" class="form-control" id="blood"
                                                       name="blood" value="<?= $blood ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ส่วนสูง : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="high" name="high"
                                                       onkeyup="return check_high();"
                                                       placeholder="ส่วนสูง (เซนติเมตร)" maxlength="3"
                                                       value="<?= $person[18] ?>" disabled>
                                                <div id="alert_high"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">น้ำหนัก : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="weight"
                                                       name="weight"
                                                       onkeyup="return check_weight();"
                                                       placeholder="น้ำหนัก (กิโลกรัม)" maxlength="3"
                                                       value="<?= $person[19] ?>" disabled>
                                                <div id="alert_weight"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">สถานที่เกิด : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="born" name="born"
                                                       onkeyup="return check_born();"
                                                       placeholder="สถานที่เกิด ,โรงพยาบาล"
                                                       value="<?= $person[20] ?>" disabled>
                                                <div id="alert_born"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ที่พัก : </label>
                                            <div class="col-sm-8">
                                                <input type="text" id="living_status" name="living_status" class="form-control" value="<?php 
                                                if ($person[21] == 0) echo "กรุณาเลือกที่พัก";
                                                if ($person[21] == 1) echo "บ้านส่วนตัว";
                                                if ($person[21] == 2) echo "บ้านเช่า";
                                                if ($person[21] == 3) echo "หอพัก";
                                                if ($person[21] == 4) echo "อาศัยบิดามารดา";
                                                if ($person[21] == 5) echo "อาศัยอยู่กับผู้อื่น"; ?>" disabled>
                                                <!-- <select id="living_status" name="living_status"
                                                        class="form-control" onchange="check_living_status();"
                                                        disabled>
                                                    <option value="0" <?php if ($person[21] == 0) {
                                                        echo " selected";
                                                    } ?> >กรุณาเลือกที่พัก
                                                    </option>
                                                    <option value="1" <?php if ($person[21] == 1) {
                                                        echo " selected";
                                                    } ?> >บ้านส่วนตัว
                                                    </option>
                                                    <option value="2" <?php if ($person[21] == 2) {
                                                        echo " selected";
                                                    } ?> >บ้านเช่า
                                                    </option>
                                                    <option value="3" <?php if ($person[21] == 3) {
                                                        echo " selected";
                                                    } ?> >หอพัก
                                                    </option>
                                                    <option value="4" <?php if ($person[21] == 4) {
                                                        echo " selected";
                                                    } ?> >อาศัยบิดามารดา
                                                    </option>
                                                    <option value="5" <?php if ($person[21] == 5) {
                                                        echo " selected";
                                                    } ?> >อาศัยอยู่กับผู้อื่น
                                                    </option>
                                                </select> -->
                                                <div id="alert_living_status"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">สถานภาพสมรส : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="marital_status" name="marital_status" value="<?php 
                                                if ($person[22] == 0)  echo "กรุณาเลือกสถานภาพสมรส";
                                                if ($person[22] == 1)  echo "โสด";
                                                if ($person[22] == 2)  echo "แต่งงาน";
                                                if ($person[22] == 3)  echo "หย่าร้าง";
                                                if ($person[22] == 4)  echo "หม้าย";
                                                if ($person[22] == 5)  echo "แยกกันอยู่"; ?>" disabled>
                                                 <!-- <select id="marital_status" name="marital_status"
                                                        class="form-control" onclick="chk_marital_status();"
                                                        disabled>
                                                    <option value="0" <?php if ($person[22] == 0) {
                                                        echo " selected";
                                                    } ?> >กรุณาเลือกสถานภาพสมรส
                                                    </option>
                                                    <option value="1" <?php if ($person[22] == 1) {
                                                        echo " selected";
                                                    } ?> >โสด
                                                    </option>
                                                    <option value="2" <?php if ($person[22] == 2) {
                                                        echo " selected";
                                                    } ?> >แต่งงาน
                                                    </option>
                                                    <option value="3" <?php if ($person[22] == 3) {
                                                        echo " selected";
                                                    } ?> >หย่าร้าง
                                                    </option>
                                                    <option value="4" <?php if ($person[22] == 4) {
                                                        echo " selected";
                                                    } ?> >หม้าย
                                                    </option>
                                                    <option value="5" <?php if ($person[22] == 5) {
                                                        echo " selected";
                                                    } ?> >แยกกันอยู่
                                                    </option>
                                                </select> -->
                                                <div id="alert_marital_status"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <?php
                                        if ($person[23] != 0) {
                                            ?>
                                            <div id="div_married_status">
                                                <div class="form-group col-sm-6">
                                                    <label class="col-sm-4 control-label ">สถานะแต่งงาน : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="married_status" name="marital_status" class="form-control" value="<?php 
                                                        if ($person[23] == 0) echo "กรุณาเลือกสถานะแต่งงาน";
                                                        if ($person[23] == 1) echo "จดทะเบียน";
                                                        if ($person[23] == 2) echo "ไม่จดทะเบียน"; ?>" disabled>
                                                       <!--  <select id="married_status" name="married_status"
                                                                class="form-control" disabled>
                                                            <option value="0" <?php if ($person[23] == 0) {
                                                                echo " selected";
                                                            } ?> >กรุณาเลือกสถานะแต่งงาน
                                                            </option>
                                                            <option value="1" <?php if ($person[23] == 1) {
                                                                echo " selected";
                                                            } ?> >จดทะเบียน
                                                            </option>
                                                            <option value="2" <?php if ($person[23] == 2) {
                                                                echo " selected";
                                                            } ?> >ไม่จดทะเบียน
                                                            </option>
                                                        </select> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>


                                    </div>

                                    <div class="col-sm-12">
                                        <br>
                                    <h4 class="page-header">ข้อมูลบัตรประชาชน</h4>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ประเภทบัตร : </label>
                                            <div class="col-sm-8">
                                                <?php 
                                                $sql_select_type = "SELECT * FROM hr_person_card WHERE person_id ='$person[0]' ";
                                                $typecard_query = mysqli_query($conn, $sql_select_type);
                                                $array = mysqli_fetch_array($typecard_query);
                                                ?>
                                                <input type="text" id="type" name="type" class="form-control" value="<?php 
                                                if ($array[1] == 1) { echo "บัตรประชาชน"; }
                                                if ($array[1] == 2) { echo "ใบขับขี่"; }
                                                if ($array[1] == 3) { echo "บัตรต่างด้าว"; } 
                                                ?>" disabled>
                                               
                                                <!-- <select id="type" name="type" class="form-control"
                                                        onchange="check_type();" disabled>
                                                    <?php
                                                    $sql_select_type = "SELECT * FROM hr_person_typecard";
                                                    $query_type = mysqli_query($conn, $sql_select_type);
                                                    $i = 0;
                                                    while (list($id, $name) = mysqli_fetch_row($query_type)) {
                                                        ?>
                                                        <option value="<?= $id ?>" <?php if ($card[1] == $id) echo "selected"; ?>><?= $name ?></option>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                                </select> -->
                                                <div id="alert_type"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">หมายเลขบัตร
                                                : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="identification"
                                                       name="identification"
                                                       onkeyup="return check_identification();"
                                                       placeholder="หมายเลขบัตร" maxlength="13"
                                                       autofocus="autofocus" value="<?= $card[3] ?>" disabled>
                                                <div id="alert_identification"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 ">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">วันออกบัตร (ค.ศ.)
                                                : </label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="issued_date"
                                                       name="issued_date"
                                                       data-errormessage-value-missing="กรุณาวันออกบัตร (ค.ศ.)"
                                                       required value="<?= fullThaiDate($card[4], false); ?>" disabled>
                                                <div id="alert_issued_date"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">วันหมดอายุบัตร (ค.ศ.)
                                                : </label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="expired_date"
                                                       name="expired_date"
                                                       data-errormessage-value-missing="กรุณาวันหมดอายุบัตร (ค.ศ.)"
                                                       required value="<?= fullThaiDate($card[5], false); ?>" disabled>
                                                <div id="alert_expired_date"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-12">
                                        <br>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-5">
                                            <h4 class="page-header">ที่อยู่ปัจจุบัน</h4>
                                        </div>
                                        <div class="form-group col-sm-1"></div>
                                        <div class="form-group col-sm-5">
                                            <h4 class="page-header">ที่อยู่ตามบัตรประชาชน</h4>
                                        </div>
                                        <div class="form-group col-sm-1"></div>
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">บ้านเลขที่ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_housenumber"
                                                       name="employment_housenumber"
                                                       onkeyup="return check_employment_housenumber();"
                                                       placeholder="บ้านเลขที่"
                                                       maxlength="10"
                                                       value="<?php if ($present_address[3] != NULL) echo $present_address[3]; else echo " - "; ?>"
                                                       disabled>
                                                <div id="alert_employment_housenumber"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">หมู่ที่ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_village"
                                                       name="employment_village"
                                                       onkeyup="return check_employment_village();"
                                                       placeholder="หมู่ที่"
                                                       maxlength="5"
                                                       value="<?php if ($present_address[4] != 0) echo $present_address[4]; else echo " - "; ?>"
                                                       disabled>
                                                <div id="alert_employment_village"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">บ้านเลขที่ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_housenumber_permanent"
                                                       name="employment_housenumber_permanent"
                                                       onkeyup="return check_employment_housenumber_permanent();"
                                                       placeholder="บ้านเลขที่"
                                                       maxlength="10"
                                                       value="<?php if ($permanent_address[3] != NULL) echo $permanent_address[3]; else echo " - "; ?>"
                                                       disabled>
                                                <div id="alert_employment_housenumber_permanent"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">หมู่ที่ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_village_permanent"
                                                       name="employment_village_permanent"
                                                       onkeyup="return check_employment_village_permanent();"
                                                       placeholder="หมู่ที่"
                                                       maxlength="5"
                                                       value="<?php if ($permanent_address[4] != 0) echo $permanent_address[4]; else echo " - "; ?>"
                                                       disabled>
                                                <div id="alert_employment_village_permanent"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">ซอย : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_lane"
                                                       name="employment_lane"
                                                       onkeyup="return check_employment_lane();"
                                                       placeholder="ซอย"
                                                       maxlength="50"
                                                       value="<?php if ($present_address[6] != NULL) echo $present_address[6]; else echo " - "; ?>"
                                                       disabled>
                                                <div id="alert_employment_lane"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">ถนน : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_road"
                                                       name="employment_road"
                                                       onkeyup="return check_employment_road();"
                                                       placeholder="ถนน"
                                                       maxlength="50"
                                                       value="<?php if ($present_address[7] != NULL) echo $present_address[7]; else echo " - "; ?>"
                                                       disabled>
                                                <div id="alert_employment_road"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">ซอย : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_lane_permanent"
                                                       name="employment_lane_permanent"
                                                       onkeyup="return check_employment_lane_permanent();"
                                                       placeholder="ซอย"
                                                       maxlength="50"
                                                       value="<?php if ($permanent_address[6] != NULL) echo $permanent_address[6]; else echo " - "; ?>"
                                                       disabled>
                                                <div id="alert_employment_lane_permanent"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">ถนน : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_road_permanent"
                                                       name="employment_road_permanent"
                                                       onkeyup="return check_employment_road_permanent();"
                                                       placeholder="ถนน"
                                                       maxlength="50"
                                                       value="<?php if ($permanent_address[7] != NULL) echo $permanent_address[7]; else echo " - "; ?>"
                                                       disabled>
                                                <div id="alert_employment_road_permanent"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $sql_select_province1 = "
                                            SELECT pvName FROM province
                                            WHERE pvID=$present_address[10]   
                                        ";
                                    $sql_select_province2 = "
                                            SELECT pvName FROM province
                                            WHERE pvID=$permanent_address[10]   
                                        ";
                                    $query_province1 = mysqli_query($conn, $sql_select_province1);
                                    $query_province2 = mysqli_query($conn, $sql_select_province2);
                                    list($province1) = mysqli_fetch_row($query_province1);
                                    list($province2) = mysqli_fetch_row($query_province2);
                                    ?>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">จังหวัด : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_province"
                                                       name="employment_province"
                                                       onkeyup="return check_employment_province();"
                                                       placeholder="จังหวัด"
                                                       maxlength="50" value="<?= $province1 ?>"
                                                       disabled>
                                                <div id="alert_employment_province"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3"></div>
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">จังหวัด : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_province_permanent"
                                                       name="employment_province_permanent"
                                                       onkeyup="return check_employment_province_permanent();"
                                                       placeholder="จังหวัด"
                                                       maxlength="50" value="<?= $province2 ?>"
                                                       disabled>
                                                <div id="alert_employment_province_permanent"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $sql_select_amphur1 = "
                                            SELECT ampName FROM amphur
                                            WHERE ampID=$present_address[9]
                                        ";
                                    $sql_select_amphur2 = "
                                            SELECT ampName FROM amphur
                                            WHERE ampID=$permanent_address[9]
                                        ";
                                    $query_amphur1 = mysqli_query($conn, $sql_select_amphur1);
                                    $query_amphur2 = mysqli_query($conn, $sql_select_amphur2);
                                    list($amphur1) = mysqli_fetch_row($query_amphur1);
                                    list($amphur2) = mysqli_fetch_row($query_amphur2);
                                    ?>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">อำเภอ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_area"
                                                       name="employment_area"
                                                       onkeyup="return check_employment_area();"
                                                       placeholder="อำเภอ"
                                                       maxlength="50" value="<?= $amphur1 ?>"
                                                       disabled>
                                                <div id="alert_employment_area"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3"></div>
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">อำเภอ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_area_permanent"
                                                       name="employment_area_permanent"
                                                       onkeyup="return check_employment_area_permanent();"
                                                       placeholder="อำเภอ"
                                                       maxlength="50" value="<?= $amphur2 ?>"
                                                       disabled>
                                                <div id="alert_employment_area_permanent"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                   <?php
                                    $sql_select_district1 = "
                                            SELECT distName FROM district
                                            WHERE distID=$present_address[8];
                                        ";
                                    $sql_select_district2 = "
                                            SELECT distName FROM district
                                            WHERE distID=$permanent_address[8];
                                        ";
                                    $query_district1 = mysqli_query($conn, $sql_select_district1);
                                    $query_district2 = mysqli_query($conn, $sql_select_district2);
                                    list($district1) = mysqli_fetch_row($query_district1);
                                    list($district2) = mysqli_fetch_row($query_district2);
                                    ?>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">ตำบล : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_subarea"
                                                       name="employment_subarea"
                                                       onkeyup="return check_employment_subarea();"
                                                       placeholder="ตำบล"
                                                       maxlength="50" value="<?= $district1?>"
                                                       disabled>
                                                <div id="alert_employment_subarea"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3"></div>
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">ตำบล : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_subarea_permanent"
                                                       name="employment_subarea_permanent"
                                                       onkeyup="return check_employment_subarea_permanent();"
                                                       placeholder="ตำบล"
                                                       maxlength="50" value="<?= $district2 ?>"
                                                       disabled>
                                                <div id="alert_employment_subarea_permanent"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">รหัสไปรษณีย์ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_postal"
                                                       name="employment_postal"
                                                       onkeyup="return check_employment_postal();"
                                                       placeholder="รหัสไปรษณีย์"
                                                       maxlength="5"
                                                       value="<?php if ($present_address[12] != 0) echo $present_address[12]; else echo " - "; ?>"
                                                       disabled>
                                                <div id="alert_employment_postal"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3"></div>
                                        <div class="form-group col-sm-3">
                                            <label class="col-sm-4 control-label ">รหัสไปรษณีย์ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="employment_postal_permanent"
                                                       name="employment_postal_permanent"
                                                       onkeyup="return check_employment_postal_permanent();"
                                                       placeholder="รหัสไปรษณีย์"
                                                       maxlength="5"
                                                       value="<?php if ($permanent_address[12] != 0) echo $permanent_address[12]; else echo " - "; ?>"
                                                       disabled>
                                                <div id="alert_employment_postal_permanent"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12"><br></div>

                                    <div class="col-sm-12">
                                        <br>
                                    </div>

                                    <h4 class="page-header">ประวัติครอบครัวและบุคคลอ้างอิง</h4>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">ชื่อ - นามสกุล บิดา (ไทย)
                                                : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="father_name"
                                                       name="father_name"
                                                       placeholder="ชื่อบิดา"
                                                       onkeyup="return check_father_name();" maxlength="60"
                                                       autofocus="autofocus" value="<?= $reference[2] ?>"
                                                       disabled>
                                                <div id="alert_father_name"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label class="col-sm-4 control-label ">อายุ (ปี) : </label>
                                            <div class="col-sm-5">
                                                <select id="father_age" name="father_age"
                                                        class="form-control" disabled>
                                                    <?php
                                                    for ($i = 1; $i <= 100; $i++) {
                                                        ?>
                                                        <option value="<?= $i ?>" <?php if ($reference[3] == $i) {
                                                            echo "selected";
                                                        } ?>><?= $i ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">อาชีพ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="father_career"
                                                       name="father_career" placeholder="อาชีพ บิดา"
                                                       onkeyup="return check_father_career();"
                                                       maxlength="60" value="<?= $reference[4] ?>" disabled>
                                                <div id="alert_father_career"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label class="col-sm-4 control-label ">สถานะ
                                                : </label>
                                            <div class="col-sm-5">
                                                <input type="checkbox" id="f_status" name="f_status"
                                                       data-toggle="toggle" data-onstyle="success"
                                                       data-on="มีชีวิตอยู่" data-offstyle="danger"
                                                       data-off="เสียชีวิตแล้ว" <?php if ($reference[5] == 1) echo "checked"; ?>
                                                       data-width="100%" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">ชื่อ - นามสกุล มารดา
                                                (ไทย)
                                                : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mother_name"
                                                       name="mother_name"
                                                       placeholder="ชื่อมารดา"
                                                       onkeyup="return check_mother_name();" maxlength="60"
                                                       value="<?= $reference[6] ?>" disabled>
                                                <div id="alert_mother_name"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label class="col-sm-4 control-label ">อายุ (ปี) : </label>
                                            <div class="col-sm-5">
                                                <select id="mother_age" name="mother_age"
                                                        class="form-control" disabled>
                                                    <?php
                                                    for ($i = 1; $i <= 100; $i++) {
                                                        ?>
                                                        <option value="<?= $i ?>" <?php if ($reference[7] == $i) {
                                                            echo "selected";
                                                        } ?>><?= $i ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">อาชีพ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mother_career"
                                                       name="mother_career" placeholder="อาชีพ มารดา"
                                                       onkeyup="return check_mother_career();"
                                                       maxlength="60" value="<?= $reference[8] ?>" disabled>
                                                <div id="alert_mother_career"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label class="col-sm-4 control-label ">สถานะ
                                                : </label>
                                            <div class="col-sm-5">
                                                <input type="checkbox" id="mother_status" name="mother_status"
                                                       data-toggle="toggle" data-onstyle="success"
                                                       data-on="มีชีวิตอยู่" data-offstyle="danger"
                                                       data-off="เสียชีวิตแล้ว" <?php if ($reference[9] == 1) echo "checked"; ?>
                                                       data-width="100%" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <br>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">ชื่อ - นามสกุลบุคคลอ้างอิง
                                                (ไทย) : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="reference_name"
                                                       name="reference_name" placeholder="ชื่อบุคคลอ้างอิง"
                                                       onkeyup="return check_reference_name();"
                                                       maxlength="60" value="<?= $reference[10] ?>" disabled>
                                                <div id="alert_reference_name"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label class="col-sm-4 control-label ">ความสัมพันธ์ : </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="relationship"
                                                       name="relationship" placeholder="สถานะความสัมพันธ์"
                                                       onkeyup="return check_relationship();"
                                                       maxlength="60" value="<?= $reference[11] ?>" disabled>
                                                <div id="alert_relationship"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">ที่อยู่ บุคคลอ้างอิง
                                                : </label>
                                            <div class="col-sm-8">
                                                        <textarea id="reference_address" name="reference_address"
                                                                  rows="3" placeholder="ที่อยู่ บุคคลอ้างอิง"
                                                                  style="width:100%;" class="form-control"
                                                                  onkeyup="return check_address_relationship();"
                                                                  disabled><?= $reference[12] ?></textarea>
                                                <div id="alert_address_relationship"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <?php
                                            if (!empty($reference[13])) {
                                                ?>
                                                <label class="col-sm-4 control-label ">ตำแหน่ง
                                                    : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                           id="position"
                                                           name="position"
                                                           onkeyup="return check_position();"
                                                           maxlength="50" value="<?= $reference[13] ?>"
                                                           disabled>
                                                    <div id="alert_position"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label class="col-sm-4 control-label ">เบอร์โทรศัพท์ : </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="reference_phone"
                                                       name="reference_phone"
                                                       onkeyup="return check_phone_reference();"
                                                       placeholder="เบอร์โทรติดต่อ"
                                                       maxlength="10" value="<?= $reference[14] ?>" disabled>
                                                <div id="alert_phone_reference"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <br>
                                    </div>

                                    <h4 class="page-header">ระดับความรู้ภาษาอังกฤษ</h4>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">ความเข้าใจ Understanding
                                                : </label>
                                            <div class="col-sm-8">
                                                <input type="text" id="understand" name="understand" class="form-control" value="<?php 
                                                if ($skills[2] == 1) echo "พอใช้ ,Fair";
                                                if ($skills[2] == 2) echo "ดี ,Good";
                                                if ($skills[2] == 3) echo "ดีมาก ,Excellent"; ?>" disabled>
                                                <!-- <select class="form-control" id="understand" name="understand"
                                                        autofocus="autofocus" disabled>
                                                    <option value="1" <?php if ($skills[2] == 1) echo "selected" ?> >
                                                        พอใช้ ,Fair
                                                    </option>
                                                    <option value="2" <?php if ($skills[2] == 2) echo "selected" ?> >
                                                        ดี ,Good
                                                    </option>
                                                    <option value="3" <?php if ($skills[2] == 3) echo "selected" ?> >
                                                        ดีมาก ,Excellent
                                                    </option>
                                                </select> -->
                                                <div id="alert_understand"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">การพูด Speaking
                                                : </label>
                                            <div class="col-sm-8">
                                                <input type="text" id="understand" name="understand" class="form-control" value="<?php 
                                                if ($skills[3] == 1) echo "พอใช้ ,Fair";
                                                if ($skills[3] == 2) echo "ดี ,Good";
                                                if ($skills[3] == 3) echo "ดีมาก ,Excellent"; ?>" disabled>
                                                <!-- <select class="form-control" id="speaking " name="speaking"
                                                        autofocus="autofocus" disabled>
                                                    <option value="1" <?php if ($skills[3] == 1) echo "selected" ?>>
                                                        พอใช้ ,Fair
                                                    </option>
                                                    <option value="2" <?php if ($skills[3] == 2) echo "selected" ?>>
                                                        ดี ,Good
                                                    </option>
                                                    <option value="3" <?php if ($skills[3] == 3) echo "selected" ?>>
                                                        ดีมาก ,Excellent
                                                    </option>
                                                </select> -->
                                                <div id="alert_specking"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">การอ่าน Reading
                                                : </label>
                                            <div class="col-sm-8">
                                                <input type="text" id="understand" name="understand" class="form-control" value="<?php 
                                                if ($skills[4] == 1) echo "พอใช้ ,Fair";
                                                if ($skills[4] == 2) echo "ดี ,Good";
                                                if ($skills[4] == 3) echo "ดีมาก ,Excellent"; ?>" disabled>
                                               <!--  <select class="form-control" id="reading" name="reading"
                                                        autofocus="autofocus" disabled>
                                                    <option value="1" <?php if ($skills[4] == 1) echo "selected" ?>>
                                                        พอใช้ ,Fair
                                                    </option>
                                                    <option value="2" <?php if ($skills[4] == 2) echo "selected" ?>>
                                                        ดี ,Good
                                                    </option>
                                                    <option value="3" <?php if ($skills[4] == 3) echo "selected" ?>>
                                                        ดีมาก ,Excellent
                                                    </option>
                                                </select> -->
                                                <div id="alert_reading"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">การเขียน Writing
                                                : </label>
                                            <div class="col-sm-8">
                                                <input type="text" id="understand" name="understand" class="form-control" value="<?php 
                                                if ($skills[5] == 1) echo "พอใช้ ,Fair";
                                                if ($skills[5] == 2) echo "ดี ,Good";
                                                if ($skills[5] == 3) echo "ดีมาก ,Excellent"; ?>" disabled>
                                                <!-- <select class="form-control" id="writing" name="writing"
                                                        autofocus="autofocus" disabled>
                                                    <option value="1" <?php if ($skills[5] == 1) echo "selected" ?>>
                                                        พอใช้ ,Fair
                                                    </option>
                                                    <option value="2" <?php if ($skills[5] == 2) echo "selected" ?>>
                                                        ดี ,Good
                                                    </option>
                                                    <option value="3" <?php if ($skills[5] == 3) echo "selected" ?>>
                                                        ดีมาก ,Excellent
                                                    </option>
                                                </select> -->
                                                <div id="alert_writing"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="page-header">ข้อมูลการศึกษา</h4>
                                    <?php
                                    $query_education = mysqli_query($conn, $sql_education);
                                    while ($education = mysqli_fetch_array($query_education)) {
                                        $sql_type_education = "SELECT degree_descript FROM hr_person_degree WHERE degree_id='$education[2]'";
                                        $query_select_type_education = mysqli_query($conn, $sql_type_education);
                                        list($degree) = mysqli_fetch_array($query_select_type_education);
                                        ?>
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">ประเภทวุฒิการศึกษา
                                                    : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born"
                                                           value="<?= $degree ?>" readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">ชื่อสถาบันการศึกษา
                                                    : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born"
                                                           value="<?= $education[3] ?>" readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">วุฒิการศึกษา
                                                    : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born" value="<?= $education[4] ?>"
                                                           readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">สาขาวิชา : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born"
                                                           value="<?= $education[5] ?>" readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">เกรดเฉลี่ย : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born" value="<?= $education[6] ?>"
                                                           readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">วันเริ่ม : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born"
                                                           value="<?= fullThaiDate($education[7], false); ?>" readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">วันจบ : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born"
                                                           value="<?= fullThaiDate($education[8], false); ?>"
                                                           readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <?php
                                    }
                                    ?>

                                    <h4 class="page-header">ข้อมูลประวัติการทำงาน</h4>
                                    <?php
                                    $query_history = mysqli_query($conn, $sql_history);
                                    while ($history = mysqli_fetch_array($query_history)) {
                                        ?>
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">ชื่อบริษัท : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born"
                                                           value="<?= $history[2] ?>" readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">ตำแหน่ง : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born" value="<?= $history[3] ?>" readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <?php $old_salary = number_format($history[6], 2, ".", ","); ?>
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">เงินเดือน : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born"
                                                           value="<?= $old_salary . " บาท" ?>" readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">วันเริ่ม : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born"
                                                           value="<?= fullThaiDate($history[4], false); ?>" readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">วันสิ้นสุด : </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born" value="<?= fullThaiDate($history[5], false); ?>"
                                                           readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">

                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">เหตุผลที่ออกจากงานเดิม
                                                    : </label   >
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="born"
                                                           name="born" value="<?= $history[7] ?>" readonly>
                                                    <div id="alert_born"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-sm-12"><br></div>

                                    <h4 class="page-header">ความสามารถพิเศษ</h4>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">ความสามารถ ขับรถยนต์
                                                : </label>
                                            <div class="col-sm-2">
                                                <input type="checkbox" id="drive_car" name="drive_car"
                                                       data-toggle="toggle" data-onstyle="success"
                                                       data-on="ได้" data-offstyle="danger"
                                                       data-off="ไม่ได้" <?php if ($skills[6] == 1) echo "checked"; ?>
                                                       data-width="100%" data-width="100%" disabled>
                                                <div id="alert_drive_car"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" id="license_car"
                                                           name="license_car" <?php if ($skills[7] == 1) echo "checked"; ?>
                                                           disabled>มีใบอนุญาติขับขี่รถยนต์
                                                    หรือไม่
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">ความสามารถ ขับรถจักรยานยนต์
                                                : </label>
                                            <div class="col-sm-2">
                                                <input type="checkbox" id="drive_motorcycle"
                                                       name="drive_motorcycle"
                                                       data-toggle="toggle" data-onstyle="success"
                                                       data-on="ได้" data-offstyle="danger"
                                                       data-off="ไม่ได้" <?php if ($skills[8] == 1) echo "checked"; ?>
                                                       data-width="100%" disabled>
                                                <div id="alert_drive_motorcycle"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" id="license_motorcycle"
                                                           name="license_motorcycle" <?php if ($skills[9] == 1) echo "checked"; ?>
                                                           disabled>มีใบอนุญาติขับขี่รถจักรยานยนต์
                                                    หรือไม่
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-4 control-label ">ความสามารถพิเศษ
                                                : </label>
                                            <div class="col-sm-8">
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id="can_computer" name="can_computer"
                                                               value="1" <?php if ($skills[10] == 1) echo "checked"; ?>
                                                               disabled>คอมพิวเตอร์
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id="can_calculator"
                                                               name="can_calculator"
                                                               value="1" <?php if ($skills[12] == 1) echo "checked"; ?>
                                                               disabled>เครื่องคิดเลข
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id="can_typing" name="can_typing"
                                                               value="1" <?php if ($skills[11] == 1) echo "checked"; ?>
                                                               disabled>พิมพ์ดีด
                                                    </label>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($skills[13])) {
                                        ?>
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-8">
                                                <label class="col-sm-4 control-label ">ความสามารถพิเศษ อื่นๆ
                                                    : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="ability_etc"
                                                           name="ability_etc"
                                                           placeholder="ความสามารถพิเศษ อื่นๆ"
                                                           onkeyup="return check_ability_etc();"
                                                           maxlength="100"
                                                           autofocus="autofocus" <?php if ($skills[13] != "") echo "value='$skills[13]'"; ?>
                                                           disabled>
                                                    <div id="alert_ability_etc"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                    <div class="col-sm-12">
                                        <br>
                                    </div>

                                    <?php
                                    if ($employment[7] == 1) {
                                        ?>
                                        <h4 class="page-header">ข้อมูลการจ้างงาน</h4>
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">รหัสพนักงาน : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                           id="employment_person_id"
                                                           name="employment_person_id" value="<?= $person[0] ?>"
                                                           disabled>
                                                </div>
                                            </div>
                                            <?php
                                            if ($person[1] == 1) $prename = "นาย";
                                            else if ($person[1] == 2) $prename = "นางสาว";
                                            else $prename = "นาง";
                                            ?>
                                            <div class="form-group col-sm-8">
                                                <label class="col-sm-2 control-label ">ชื่อ-สกุล : </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                           id="employment_fullname"
                                                           name="employment_fullname"
                                                           value="<?= $prename . " " . $person[2] . " " . $person[3] ?>"
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12"><br></div>
                                        <div class="col-sm-12">
                                           

                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">แผนก : </label>
                                                <div class="col-sm-8">
                                                    <?php
                                                    $sql_select_department = "SELECT department_name FROM hr_person_department WHERE department_id='$employment[4]' ";
                                                    $query_select_department = mysqli_query($conn, $sql_select_department);
                                                    list($department_name) = mysqli_fetch_row($query_select_department);
                                                    ?>
                                                    <input type="text" class="form-control"
                                                           id="employment_department"
                                                           name="employment_department"
                                                           onkeyup="return check_employment_department();"
                                                           placeholder="แผนกงาน"
                                                           maxlength="50"
                                                           value="<?php if ($department_name != "") echo $department_name; else echo "*ยังไม่ได้เลือกแผนก"; ?>"
                                                           disabled>
                                                    <div id="alert_employment_department"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">ตำแหน่ง : </label>
                                                <div class="col-sm-8">
                                                    <?php
                                                    $sql_select_position = "SELECT position_name FROM hr_person_position WHERE position_id='$employment[5]' ";
                                                    $query_select_position = mysqli_query($conn, $sql_select_position);
                                                    list($position_name) = mysqli_fetch_row($query_select_position);
                                                    ?>
                                                    <input type="text" class="form-control"
                                                           id="employment_position"
                                                           name="employment_position"
                                                           onkeyup="return check_employment_position();"
                                                           placeholder="ตำแหน่งงาน"
                                                           maxlength="50" autofocus="autofocus"
                                                           value="<?= $position_name ?>" disabled>
                                                    <div id="alert_employment_position"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>

                                            <?php $money = explode(".", $employment[6]); ?>
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">อัตราเงินเดือน : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                           id="employment_money"
                                                           name="employment_money"
                                                           onkeyup="return check_employment_salary();"
                                                           placeholder="อัตราเงินเดือนพนักงาน"
                                                           maxlength="13" value="<?= $money[0] ?>" disabled>
                                                    <div id="alert_employment_money"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">วันเริ่มงาน : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                           id="employment_start_date"
                                                           name="employment_start_date"
                                                           data-errormessage-value-missing="*กรุณากรอกวันที่เริ่มงาน"
                                                           required autofocus="autofocus"
                                                           value="<?= fullThaiDate($employment[15], false); ?>"
                                                           disabled>
                                                    <div id="alert_start_date"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <br>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-8">
                                                <h4 class="page-header">ข้อมูลสถานะพนักงาน</h4>
                                            </div>
                                        </div>


                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-6   control-label ">สถานะพนักงาน
                                                    : </label>
                                                <div class="col-sm-5">
                                                    <input type="checkbox" id="drive_motorcycle"
                                                           name="drive_motorcycle"
                                                           data-toggle="toggle" data-onstyle="success"
                                                           data-on="พนักงาน" data-offstyle="default"
                                                           data-off="ทดลองงาน" <?php if ($employment[7] == 1) echo "checked"; ?>
                                                           data-width="100%" disabled>
                                                    <div id="alert_drive_motorcycle"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-6 control-label ">สถานะการทำงาน
                                                    : </label>
                                                <div class="col-sm-5">
                                                    <input type="checkbox" id="drive_motorcycle"
                                                           name="drive_motorcycle"
                                                           data-toggle="toggle" data-onstyle="primary"
                                                           data-on="ทำงานปกติ" data-offstyle="danger"
                                                           data-off="ลาออกแล้ว" <?php if ($employment[8] == 1) echo "checked"; ?>
                                                           data-width="100%" disabled>
                                                    <div id="alert_drive_motorcycle"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <?php
                                            if ($employment[8] != 2) {
                                                ?>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-6 control-label ">สถานะการพักงาน : </label>
                                                    <div class="col-sm-5">
                                                        <input type="checkbox" id="drive_motorcycle"
                                                               name="drive_motorcycle"
                                                               data-toggle="toggle" data-onstyle="primary"
                                                               data-off="พักงาน" data-offstyle="danger"
                                                               data-on="ทำงานปกติ" <?php if ($employment[11] == 1) echo "checked"; ?>
                                                               data-width="100%" disabled>
                                                        <div id="alert_drive_motorcycle"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-8">
                                                    <hr>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-6 control-label ">สถานะพนักงาน
                                                    : </label>
                                                <div class="col-sm-6">
                                                    <input type="text" id="employment_status" name="employment_status" class="form-control" value="<?php 
                                                        if ($employment[7] == 0) { echo "กรุณาเลือกสถานะพนักงาน";}
                                                        if ($employment[7] == 1) { echo "พนักงานบริษัท";} 
                                                        if ($employment[7] == 2) { echo "พนักงานทดลองงาน";} ?>" disabled>
                                                    <!-- <select id="employment_status" name="employment_status"
                                                            class="form-control"
                                                            onchange="chk_employment_status();" disabled>
                                                        <option value="0" <?php if ($employment[7] == 0) echo "selected"; ?>>
                                                            กรุณาเลือกสถานะ พนักงาน
                                                        </option>
                                                        <option value="1" <?php if ($employment[7] == 1) echo "selected"; ?>>
                                                            พนักงานบริษัท
                                                        </option>
                                                        <option value="2" <?php if ($employment[7] == 2) echo "selected"; ?>>
                                                            พนักงานทดลองงาน
                                                        </option>
                                                    </select> -->
                                                    <div id="alert_employment_status"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <?php
                                            if ($employment[16] != NULL) {
                                                ?>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">อายุการทำงาน
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control"
                                                               id="view_age"
                                                               name="view_age"
                                                               value="<?php if ($employment[17] > 0) echo "$employment[17] ปี"; else echo "น้อยกว่า 1 ปี"; ?> "
                                                               disabled>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>


                                        <div id="div_working_status">
                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-6 control-label ">สถานะการทำงาน
                                                        : </label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="working_status" name="working_status" class="form-control" value="<?php 
                                                        if ($employment[8] == 0) { echo "กรุณาเลือกสถานะการทำงาน";}
                                                        if ($employment[8] == 1) { echo "ทำงานปกติ";} 
                                                        if ($employment[8] == 2) { echo "ลาออก";} ?>" disabled>
                                                       <!--  <select id="working_status" name="working_status"
                                                                class="form-control"
                                                                onchange="check_working_status();" disabled>
                                                            <option value="0" <?php if ($employment[8] == 0) echo "selected"; ?>>
                                                                กรุณาเลือกสถานะ การทำงาน
                                                            </option>
                                                            <option value="1" <?php if ($employment[8] == 1) echo "selected"; ?>>
                                                                ทำงาน ปกติ
                                                            </option>
                                                            <option value="2" <?php if ($employment[8] == 2) echo "selected"; ?>>
                                                                ลาออก
                                                            </option>
                                                        </select> -->
                                                        <div id="alert_working_status"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($employment[16] != NULL) {
                                                    ?>
                                                    <div class="form-group col-sm-4">
                                                        <div id="div_finish_date">
                                                            <label class="col-sm-4 control-label ">วันที่ลาออก
                                                                : </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                       id="employment_end_date"
                                                                       name="employment_end_date"
                                                                       data-errormessage-value-missing="*กรุณากรอกวันที่ลาออก (ค.ศ.)"
                                                                       onchange="check_finish_work();"
                                                                       value="<?= fullThaiDate($employment[16], false); ?>"
                                                                       disabled>
                                                                <div id="alert_employment_end_date"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                               

                                            </div>
                                        </div>
                                        <?php
                                        if ($employment[9] != "") {
                                            ?>
                                            <div id="div_end_reason">
                                                <div class="col-sm-12">
                                                    <div class="form-group col-sm-8">
                                                        <label class="col-sm-2 control-label ">เหตุผลที่ลาออก
                                                            : </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                   id="employment_end_reason"
                                                                   name="employment_end_reason"
                                                                   placeholder="กรอกเหตุผลที่ลาออก"
                                                                   onchange="check_end_reason();"
                                                                   value="<?= $employment[9] ?>" disabled>
                                                            <div id="alert_end_reason"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div id="div_break_status">
                                            <div class="col-sm-12">
                                                <?php
                                                if ($employment[8] != 2) {
                                                    ?>
                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-6 control-label ">สถานะการพักงาน
                                                            : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="break_status" name="break_status" class="form-control" value="<?php 
                                                                if ($employment[11] == 0) { echo "กรุณาเลือกสถานะการพักงาน";}
                                                                if ($employment[11] == 1) { echo "ทำงานปกติ";} 
                                                                if ($employment[11] == 2) { echo "พักงาน";} ?>" disabled>
                                                            <!-- <select id="break_status" name="break_status"
                                                                    class="form-control"
                                                                    onchange="check_break_status();" disabled>
                                                                <option value="0" <?php if ($employment[11] == 0) echo "selected"; ?>>
                                                                    กรุณาเลือกสถานะ การพักงาน
                                                                </option>
                                                                <option value="1" <?php if ($employment[11] == 1) echo "selected"; ?>>
                                                                    ทำงาน ปกติ
                                                                </option>
                                                                <option value="2" <?php if ($employment[11] == 2) echo "selected"; ?>>
                                                                    พักงาน
                                                                </option>
                                                            </select> -->
                                                            <div id="alert_break_status"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                 <?php
                                                if ($employment[10]!="") {
                                                    ?>
                                                    <div class="form-group col-sm-4">
                                                        <div id="div_finish_date">
                                                            <label class="col-sm-6 control-label ">สถานะลาออก แบบไม่คืนเงินประกัน
                                                                : </label>
                                                            <div class="col-sm-6">
                                                                <input type="checkbox" id="drive_motorcycle"
                                                                       name="drive_motorcycle"
                                                                       data-toggle="toggle" data-onstyle="success"
                                                                       data-off="ไม่คืน" data-offstyle="danger"
                                                                       data-on="คืน" <?php if ($employment[10] == 1) echo "checked"; ?>
                                                                       data-width="100%" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($employment[12] != NULL) {
                                                    ?>
                                                    <div class="form-group col-sm-4">
                                                        <div id="div_start_break_date">
                                                            <label class="col-sm-4 control-label ">วันเริ่มการพักงาน
                                                                : </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                       id="employment_break_start"
                                                                       name="employment_break_start"
                                                                       data-errormessage-value-missing="*กรุณากรอกวันเริ่มการพักงาน (ค.ศ.)"
                                                                       onchange="check_start_break();"
                                                                       value="<?= fullThaiDate($employment[12], false); ?>"
                                                                       disabled>
                                                                <div id="alert_startdate_break"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($employment[13] != NULL) {
                                                    ?>
                                                    <div class="form-group col-sm-4">
                                                        <div id="div_finish_break_date">
                                                            <label class="col-sm-4 control-label ">วันสิ้นสุดการพักงาน
                                                                : </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                       id="employment_break_finish"
                                                                       name="employment_break_finish"
                                                                       data-errormessage-value-missing="*กรุณากรอกวันสิ้นสุดการพักงาน (ค.ศ.)"
                                                                       onchange="check_finish_break();"
                                                                       value="<?= fullThaiDate($employment[13], false); ?>"
                                                                       disabled>
                                                                <div id="alert_finishdate_break"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <?php
                                        if ($employment[14] != "") {
                                            ?>
                                            <div id="div_break_reason">
                                                <div class="col-sm-12">
                                                    <div class="form-group col-sm-8">
                                                        <label class="col-sm-2 control-label ">เหตุผลที่พักงาน
                                                            : </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                   id="employment_break_reason"
                                                                   name="employment_break_reason"
                                                                   placeholder="กรอกเหตุผลที่พักงาน"
                                                                   onchange="check_break_reason();"
                                                                   value="<?= $employment[14] ?>" disabled>
                                                            <div id="alert_break_reason"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="col-sm-12">
                                            <br>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-8">
                                                <h4 class="page-header">ข้อมูลสถานะประกันสังคม</h4>
                                            </div>
                                        </div>

                                        <div id="div_social">

                                            <div class="col-sm-12">
                                                <?php
                                                if ($employment[18] != NULL) {
                                                    ?>
                                                    <div class="form-group col-sm-6">
                                                        <label class="col-sm-4 control-label ">วันเริ่มต้น
                                                            : </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control"
                                                                   id="start_social_insurance_date"
                                                                   name="start_social_insurance_date"
                                                                   data-errormessage-value-missing="*กรุณากรอกวันเริ่มต้นประกันสังคม (ค.ศ.)"
                                                                   onchange="check_start_social();"
                                                                   value="<?= fullThaiDate($employment[18], false); ?>"
                                                                   disabled>
                                                            <div id="alert_start_social"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if ($employment[19] != NULL) {
                                                    ?>
                                                    <div class="form-group col-sm-6">
                                                        <div id="div_finish_social">
                                                            <label class="col-sm-4 control-label ">วันสิ้นสุด
                                                                : </label>
                                                            <div class="col-sm-6">

                                                                <input type="text" class="form-control"
                                                                       id="out_social_insurance_date"
                                                                       name="out_social_insurance_date"
                                                                       data-errormessage-value-missing="*กรุณากรอกวันสิ้นสุดประกันสังคม (ค.ศ.)"
                                                                       onchange="check_out_social();"
                                                                       value="<?= fullThaiDate($employment[19], false); ?>"
                                                                       disabled>
                                                                <div id="alert_out_social"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <?php
                                    }

                                    $sql_select_person_holiday = "
                                        SELECT * FROM hr_person_holiday
                                        WHERE person_id='{$_GET["id"]}'
                                    ";
                                    $query_person_holiday = mysqli_query($conn, $sql_select_person_holiday);
                                    if (mysqli_num_rows($query_person_holiday)) {
                                    $assoc_person_holiday = mysqli_fetch_assoc($query_person_holiday);
                                    ?>
                                    <div class="col-sm-12">
                                        <h4 class="page-header">ข้อมูลวันหยุดพนักงาน</h4>
                                        <div class="form-group col-sm-8">
                                            <label class="col-sm-2 control-label ">วันหยุดของพนักงาน
                                                : </label>
                                            <div class="col-sm-8"><br>
                                                <?php
                                                if (explode(",", $assoc_person_holiday["holiday_value"]) == true) {
                                                    $exp_holiday = explode(",", $assoc_person_holiday["holiday_value"]);
                                                    ?>
                                                    <input type="checkbox" id="holiday1" name="holiday[]"
                                                           onclick="check_checkbox();" value="1"
                                                        <?php
                                                        foreach ($exp_holiday as $temp) {
                                                            if ($temp == 1) echo "checked";
                                                        }
                                                        ?>
                                                           disabled> วันจันทร์ <br>
                                                    <input type="checkbox" id="holiday2" name="holiday[]"
                                                           onclick="check_checkbox();" value="2"
                                                        <?php
                                                        foreach ($exp_holiday as $temp) {
                                                            if ($temp == 2) echo "checked";
                                                        }
                                                        ?>
                                                           disabled> วันอังคาร <br>
                                                    <input type="checkbox" id="holiday3" name="holiday[]"
                                                           onclick="check_checkbox();" value="3"
                                                        <?php
                                                        foreach ($exp_holiday as $temp) {
                                                            if ($temp == 3) echo "checked";
                                                        }
                                                        ?>
                                                           disabled> วันพุธ <br>
                                                    <input type="checkbox" id="holiday4" name="holiday[]"
                                                           onclick="check_checkbox();" value="4"
                                                        <?php
                                                        foreach ($exp_holiday as $temp) {
                                                            if ($temp == 4) echo "checked";
                                                        }
                                                        ?>
                                                           disabled> วันพฤหัสบดี <br>
                                                    <input type="checkbox" id="holiday5" name="holiday[]"
                                                           onclick="check_checkbox();" value="5"
                                                        <?php
                                                        foreach ($exp_holiday as $temp) {
                                                            if ($temp == 5) echo "checked";
                                                        }
                                                        ?>
                                                           disabled> วันศุกร์ <br>
                                                    <input type="checkbox" id="holiday6" name="holiday[]"
                                                           onclick="check_checkbox();" value="6"
                                                        <?php
                                                        foreach ($exp_holiday as $temp) {
                                                            if ($temp == 6) echo "checked";
                                                        }
                                                        ?>
                                                           disabled> วันเสาร์ <br>
                                                    <input type="checkbox" id="holiday7" name="holiday[]"
                                                           onclick="check_checkbox();" value="7"
                                                        <?php
                                                        foreach ($exp_holiday as $temp) {
                                                            if ($temp == 7) echo "checked";
                                                        }
                                                        ?>
                                                           disabled> วันอาทิตย์ <br>
                                                    <input type="checkbox" id="holiday8" name="holiday[]"
                                                           onclick="check_checkbox();" value="8"
                                                        <?php
                                                        foreach ($exp_holiday as $temp) {
                                                            if ($temp == 8) echo "checked";
                                                        }
                                                        ?>
                                                           disabled> ไม่มีวันหยุด <br>
                                                    <?php
                                                }
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <hr>
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="pager">
                                            <li><a href="./?mod=main" class="btn btn-default">
                                                ย้อนกลับ
                                            </a></li>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#edit_personImage").change(function () {
        readURL(this);
    });

</script>



