<?php

if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

include("inc/topnav.php");

if (!isset($_GET['id'])) {
    exit("<script>window.location = './';</script>");
}

$sql_select_person = "SELECT * FROM hr_person WHERE person_id='$_GET[id]' ";
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
                    <i class="fa fa-user-circle"></i> หัวข้อ แก้ไขข้อมูลบุคลาการ.
                    <div class="pull-right">
                        <div class="btn-group">

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="panel-body">
                        <div class="row">

                            <!--index.php?mod=hr/sm_update_person-->
                            <form id="form_edit_person" class="form-horizontal" role="form" method="post"
                                  enctype="multipart/form-data" action="index.php?mod=hr/sm_update_person">

                                <div style="padding-right:10px;">
                                    <button class="btn btn-info" type="button"
                                            id="btn_nextpage"
                                            class="btn btn-info"
                                            onclick="window.location='index.php?mod=hr/form_edit_history&edit_id=<?= $person[0] ?>'"
                                            style="float:right; ">
                                        ขั้นตอนต่อไป <i class="fa fa-long-arrow-right"></i>
                                    </button>
                                </div>

                                <div class="col-sm-12">
                                    <h4 class="page-header">ประวัติส่วนตัว</h4>
                                </div>

                                <input type="hidden" id="hidden_edit_id" name="hidden_edit_id"
                                       value="<?= $person[0] ?>">

                                <div class="col-sm-12">
                                    <div class="form-group col-sm-4"></div>
                                    <?php
                                    if(!empty($person[10])){
                                    ?>
                                    <div class="form-group col-sm-4" style="text-align:center;">
                                        <a href="././<?= $person[10] ?>" data-lightbox="image-1"
                                           data-title="<?= $person[2] . " " . $person[3] ?>">
                                            <img src="././<?= $person[10] ?>"
                                                 style="max-width: 250px; max-height: 200px; border: solid 1px#1b2426;">
                                        </a>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="form-group col-sm-4"></div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-3"></div>
                                        <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">รูปภาพ : </label>
                                        <div class="col-sm-8">
                                            <table style="width:100%;">
                                                <tr>
                                                    <td>
                                                        <div class="form-group col-sm-6">
                                                            <input type="file" id="edit_personImage"
                                                                   name="edit_personImage" accept="image/*"
                                                                   class="form-control"
                                                                   style="width: 100%;">
                                                        </div>
                                                        <div id="alert_warn_image"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img id="preview" class="img-responsive"
                                                                 style="max-width:300px; max-height: 300px;  padding:5px; margin:0 auto; float: left;">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-3"></div>
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
                                        <label class="col-sm-4 control-label">อายุ : </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="edit_age_show"
                                                       name="edit_age_show" value="<?= $person[9] . " ปี" ?>"
                                                       disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label">คำนำหน้าชื่อ : </label>
                                        <div class="col-sm-8">
                                            <select id="edit_prename" name="edit_prename" class="form-control"
                                                    autofocus="autofocus" onchange="check_prename();">
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
                                            </select>
                                            <div id="alert_prename"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">เพศ : </label>
                                        <div class="col-sm-4">
                                            <select id="edit_sex" name="edit_sex" class="form-control"
                                                    onchange="check_edit_sex();">
                                                <option value="0" <?php if ($person[6] == 0) {
                                                    echo " selected";
                                                } ?> >กรุณาเลือกเพศ
                                                </option>
                                                <option value="1" <?php if ($person[6] == 1) {
                                                    echo " selected";
                                                } ?> >ชาย
                                                </option>
                                                <option value="2" <?php if ($person[6] == 2) {
                                                    echo " selected";
                                                } ?> >หญิง
                                                </option>
                                            </select>
                                            <div id="alert_sex"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>
                                    <?php
                                    if ($person[24] != "") {
                                        ?>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label">Resume : </label>
                                            <div class="col-sm-8">
                                                <label class="col-sm-4 control-label " autofocus="autofocus"
                                                       style="text-align:left;">
                                                    <a href="<?= $person[24] ?>">Resume file.</a>
                                                </label>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                <div class="col-sm-12">
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">ชื่อ (ไทย) : </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="fname_thai"
                                                   name="fname_thai"
                                                   placeholder="ชื่อจริง"
                                                   onkeyup="return check_fname_thai();" maxlength="55"
                                                   autofocus="autofocus" value="<?= $person[2] ?>">
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
                                                   maxlength="55" value="<?= $person[4] ?>">
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
                                                   value="<?= $person[3] ?>">
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
                                                   maxlength="55" value="<?= $person[5] ?>">
                                            <div id="alert_lname_eng"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ชื่อเล่น : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="nickname"
                                                       name="nickname"
                                                       placeholder="ชื่อเล่น"
                                                       required maxlength="15" value="<?=$person[30]?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6"></div>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label "> เดือน / วันที่ / ปีเกิด (ค.ศ.) : </label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="birth_date"
                                                   name="birth_date"
                                                   data-errormessage-value-missing="*กรุณากรอกวันเวลาเกิด (ค.ศ.)"
                                                   required value="<?= $person[7] ?>">
                                            <div id="alert_birth_date"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">เวลา : </label>
                                        <div class="col-sm-8">
                                            <input type="TIME" name="birth_time"
                                                   placeholder="กรอกเวลาเกิด" Class="form-control"
                                                   data-errormessage-value-missing="*กรุณากรอกเวลาเกิด" required
                                                   value="<?= $person[8] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">Resume (.PDF File) : </label>
                                        <div class="col-sm-8">
                                            <table style="width:107%;">
                                                <tr>
                                                    <td>
                                                        <div class="form-group col-sm-12">
                                                            <input type="file" id="edit_personResume"
                                                                   name="edit_personResume" accept="pdf/*"
                                                                   class="form-control"
                                                                   style="width: 100%;">
                                                            <div id="alert_resume"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img id="preview1" class="img-responsive"
                                                                 style="max-width:200px; max-height: 100px;  padding:5px; margin:0 auto;">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
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
                                                   maxlength="55" value="<?= $person[11] ?>">
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
                                                   maxlength="10" value="<?= $person[12] ?>">
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
                                                   maxlength="50" value="<?= $person[13] ?>">
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
                                                   maxlength="50" value="<?= $person[14] ?>">
                                            <div id="alert_ethnicity"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 ">
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">ศาสนา : </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="religion"
                                                   name="religion"
                                                   onkeyup="return check_religion();" placeholder="ศาสนา"
                                                   maxlength="50" value="<?= $person[15] ?>">
                                            <div id="alert_religion"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div id="div_edit_soldier">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">สถานภาพทางทหาร : </label>
                                            <div class="col-sm-8">
                                                <select id="edit_soldier" name="edit_soldier"
                                                        class="form-control"
                                                        onchange="check_edit_soldier();">
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
                                                </select>
                                                <div id="alert_edit_soldier"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">หมู่โลหิต : </label>
                                        <div class="col-sm-8">
                                            <table>
                                                <tr>
                                                    <td style="padding:10px;">
                                                        <input type="radio" id="blood" name="blood"
                                                                       value="1" <?php if ($person[17] == 1) {
                                                            echo " checked";
                                                        } ?>> O
                                                    </td>
                                                    <td style="padding:10px;">
                                                        <input type="radio" id="blood" name="blood"
                                                                       value="2" <?php if ($person[17] == 2) {
                                                            echo " checked";
                                                        } ?>> A
                                                    </td>
                                                    <td style="padding:10px;">
                                                        <input type="radio" id="blood" name="blood"
                                                                       value="3" <?php if ($person[17] == 3) {
                                                            echo " checked";
                                                        } ?>> B
                                                    </td>
                                                    <td style="padding:10px;">
                                                        <input type="radio" id="blood" name="blood"
                                                                        value="4" <?php if ($person[17] == 4) {
                                                            echo " checked"; 
                                                        } ?>> AB
                                                    </td>
                                                </tr>
                                            </table>
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
                                                   value="<?= $person[18] ?>">
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
                                                   value="<?= $person[19] ?>">
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
                                                   value="<?= $person[20] ?>">
                                            <div id="alert_born"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">ที่พักอาศัย : </label>
                                        <div class="col-sm-8">
                                            <select id="living_status" name="living_status"
                                                    class="form-control" onchange="check_living_status();">
                                                <option value="0" <?php if ($person[21] == 0) {
                                                    echo " selected";
                                                } ?> >กรุณาเลือกที่พักอาศัย
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
                                            </select>
                                            <div id="alert_living_status"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">สถานภาพสมรส : </label>
                                        <div class="col-sm-8">
                                            <select id="marital_status" name="marital_status"
                                                    class="form-control" onclick="chk_marital_status();">
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
                                                } ?> >หย่า
                                                </option>
                                                <option value="4" <?php if ($person[22] == 4) {
                                                    echo " selected";
                                                } ?> >หม้าย
                                                </option>
                                                <option value="5" <?php if ($person[22] == 5) {
                                                    echo " selected";
                                                } ?> >แยกกันอยู่
                                                </option>
                                            </select>
                                            <div id="alert_marital_status"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>

                                    <div id="div_married_status">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">สถานภาพการแต่งงาน : </label>
                                            <div class="col-sm-8" onchange="check_married_status();">
                                                <select id="married_status" name="married_status"
                                                        class="form-control">
                                                    <option value="0" <?php if ($person[23] == 0) {
                                                        echo " selected";
                                                    } ?> >กรุณาเลือกสถานะการแต่งงาน
                                                    </option>
                                                    <option value="1" <?php if ($person[23] == 1) {
                                                        echo " selected";
                                                    } ?> >จดทะเบียน
                                                    </option>
                                                    <option value="2" <?php if ($person[23] == 2) {
                                                        echo " selected";
                                                    } ?> >ไม่จดทะเบียน
                                                    </option>
                                                </select>
                                                <div id="alert_married_status"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-12">
                                    <br>
                                </div>
                                <div class="col-sm-12">
                                    <h4 class="page-header">ข้อมูลบัตรประชาชน</h4>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">ประเภทบัตร : </label>
                                        <div class="col-sm-8">
                                            <select id="type" name="type" class="form-control"
                                                    onchange="check_type();">
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
                                            </select>
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
                                                   autofocus="autofocus" value="<?= $card[3] ?>">
                                            <div id="alert_identification"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 ">
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">วันออกบัตร (ค.ศ.)
                                            : </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" id="issued_date"
                                                   name="issued_date"
                                                   data-errormessage-value-missing="กรุณาวันออกบัตร (ค.ศ.)"
                                                   required value="<?= $card[4] ?>">
                                            <div id="alert_issued_date"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label ">วันหมดอายุบัตร (ค.ศ.)
                                            : </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" id="expired_date"
                                                   name="expired_date"
                                                   data-errormessage-value-missing="กรุณาวันหมดอายุบัตร (ค.ศ.)"
                                                   required value="<?= $card[5] ?>">
                                            <div id="alert_expired_date"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-12">
                                    <br>
                                </div>


                                <!-- start old address-->
                                <div class="col-sm-12">
                                    <div class="form-group col-sm-5"><h4 class="page-header">ที่อยู่ปัจจุบัน</h4></div>
                                    <div class="form-group col-sm-1"></div>
                                    <div class="form-group col-sm-5"><h4 class="page-header">ที่อยู่ตามบัตรประชาชน</h4>
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
                                                   maxlength="10" value="<?= $present_address[3] ?>">
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
                                                   maxlength="5" value="<?= $present_address[4] ?>">
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
                                                   maxlength="10" value="<?= $permanent_address[3] ?>">
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
                                                   maxlength="5" value="<?= $permanent_address[4] ?>">
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
                                                   maxlength="50" value="<?= $present_address[6] ?>">
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
                                                   maxlength="50" value="<?= $present_address[7] ?>">
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
                                                   maxlength="50" value="<?= $permanent_address[6] ?>">
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
                                                   maxlength="50" value="<?= $permanent_address[7] ?>">
                                            <div id="alert_employment_road_permanent"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group col-sm-3">
                                        <?php

                                        $present_province = "<option value=''>- เลือกข้อมูล-</option>";
                                        $sql_select_present_present = "
                                            SELECT * FROM province
                                            ORDER BY convert(pvName USING tis620)
                                        ";
                                        $query_present_province = mysqli_query($conn, $sql_select_present_present);
                                        if (mysqli_num_rows($query_present_province)) {
                                            while ($data_present_province = mysqli_fetch_assoc($query_present_province)) { 
                                                ($data_present_province["pvID"] == $present_address[10]) ? $selected_present_province = "selected" : $selected_present_province = "";
                                                $present_province .= "<option value='{$data_present_province["pvID"]}' $selected_present_province>{$data_present_province["pvName"]}</option>";
                                            }
                                        }
                                        ?>
                                        <label class="col-sm-4 control-label ">จังหวัด : </label>
                                        <div class="col-sm-8">
                                            <select id="employment_province"
                                                    name="employment_province"
                                                    class="form-control"
                                                    data-errormessage-value-missing="กรุณาเลือก จังหวัด" required>
                                                <?php echo $present_province; ?>
                                            </select>
                                            <div id="alert_employment_province"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3"></div>
                                    <?php
                                    $permanent_province = "<option value=''>- เลือกข้อมูล-</option>";
                                    $sql_select_permanent_province = "
                                            SELECT * FROM province
                                            ORDER BY convert(pvName USING tis620)
                                        ";
                                    $query_permanent_province = mysqli_query($conn, $sql_select_permanent_province);
                                    if (mysqli_num_rows($query_permanent_province)) {
                                        while ($data_permanent_province = mysqli_fetch_assoc($query_permanent_province)) {
                                            ($data_permanent_province["pvID"] == $permanent_address[10]) ? $selected_permanent_province = "selected" : $selected_permanent_province = "";
                                            $permanent_province .= "<option value='{$data_permanent_province["pvID"]}' $selected_permanent_province>{$data_permanent_province["pvName"]}</option>";
                                        }
                                    }
                                    ?>
                                    <div class="form-group col-sm-3">
                                        <label class="col-sm-4 control-label ">จังหวัด : </label>
                                        <div class="col-sm-8">
                                            <select id="employment_province_permanent"
                                                    name="employment_province_permanent"
                                                    class="form-control"
                                                    data-errormessage-value-missing="กรุณาเลือกจังหวัด" required>
                                                <?php echo $permanent_province; ?>
                                            </select>
                                            <div id="alert_employment_province_permanent"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group col-sm-3">
                                        <?php
                                        $present_amphur = "<option value=''>- เลือกข้อมูล -</option>";
                                        $sql_select_present_amphur = "
                                            SELECT * FROM amphur
                                            ORDER BY convert(ampName USING tis620)
                                         ";
                                        $query_present_amphur = mysqli_query($conn, $sql_select_present_amphur);
                                        if (mysqli_num_rows($query_present_amphur)) {
                                            while ($data_present_permanent = mysqli_fetch_assoc($query_present_amphur)) {
                                                ($data_present_permanent["ampID"] == $present_address[9]) ? $selected_present_amphur = "selected" : $selected_present_amphur = "";
                                                $present_amphur .= "<option value='{$data_present_permanent["ampID"]}' $selected_present_amphur>{$data_present_permanent["ampName"]}</option>";
                                            }
                                        }
                                        ?>
                                        <label class="col-sm-4 control-label ">อำเภอ : </label>
                                        <div class="col-sm-8">
                                            <select id="employment_area"
                                                    name="employment_area"
                                                    class="form-control"
                                                    data-errormessage-value-missing="กรุณาเลือก อำเภอ" required>
                                                <?php echo $present_amphur; ?>
                                            </select>
                                            <div id="alert_employment_area"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <?php
                                    $permanent_amphur = "<option value=''>- เลือกข้อมูล -</option>";
                                    $sql_select_permanent_amphur = "
                                        SELECT * FROM amphur
                                        ORDER BY convert(ampName USING tis620)
                                    ";
                                    $query_permanent_amphur = mysqli_query($conn, $sql_select_permanent_amphur);
                                    if (mysqli_num_rows($query_permanent_amphur)) {
                                        while ($data_amphur_permanent = mysqli_fetch_assoc($query_permanent_amphur)) {
                                            ($data_amphur_permanent["ampID"] == $permanent_address[9]) ? $selected_permanent_amphur = "selected" : $selected_permanent_amphur = "";
                                            $permanent_amphur .= "<option value='{$data_amphur_permanent["ampID"]}' $selected_permanent_amphur>{$data_amphur_permanent["ampName"]}</option>";
                                        }
                                    }
                                    ?>
                                    <div class="form-group col-sm-3"></div>
                                    <div class="form-group col-sm-3">
                                        <label class="col-sm-4 control-label ">อำเภอ : </label>
                                        <div class="col-sm-8">
                                            <select id="employment_area_permanent"
                                                    name="employment_area_permanent"
                                                    class="form-control"
                                                    data-errormessage-value-missing="กรุณาเลือก อำเภอ" required>
                                                <?php echo $permanent_amphur; ?>
                                            </select>
                                            <div id="alert_employment_area_permanent"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <?php
                                    $sql_select_district_present = "
                                        SELECT * FROM district
                                        ORDER BY convert(distName USING tis620)
                                    ";
                                    $present_district = "<option value=''>- เลือกข้อมูล -</option>";
                                    $query_present_district = mysqli_query($conn, $sql_select_district_present);
                                    if (mysqli_num_rows($query_present_district))
                                        while ($data_district_present = mysqli_fetch_assoc($query_present_district)) {
                                            ($data_district_present["distID"] == $present_address[8]) ? $selected_present_district = "selected" : $selected_present_district = "";
                                            $present_district .= "<option value='{$data_district_present["distID"]}' $selected_present_district>{$data_district_present["distName"]}</option>";
                                        }
                                    ?>
                                    <div class="form-group col-sm-3">
                                        <label class="col-sm-4 control-label ">ตำบล : </label>
                                        <div class="col-sm-8">
                                            <select id="employment_subarea"
                                                    name="employment_subarea"
                                                    class="form-control" ;
                                                    data-errormessage-value-missing="กรุณาเลือก ตำบล" required>
                                                <?php echo $present_district; ?>
                                            </select>
                                            <div id="alert_employment_subarea"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3"></div>
                                    <?php
                                    $sql_select_district_permanent = "
                                        SELECT * FROM district
                                        ORDER BY convert(distName USING tis620)
                                    ";
                                    $permanent_district = "<option value=''>- เลือกข้อมูล -</option>";
                                    $query_permanent_district = mysqli_query($conn, $sql_select_district_permanent);
                                    if (mysqli_num_rows($query_permanent_district))
                                        while ($data_district_permanent = mysqli_fetch_assoc($query_permanent_district)) {
                                            ($data_district_permanent["distID"] == $permanent_address[8]) ? $selected_permanent_district = "selected" : $selected_permanent_district = "";
                                            $permanent_district .= "<option value='{$data_district_permanent["distID"]}' $selected_permanent_district>{$data_district_permanent["distName"]}</option>";
                                        }
                                    ?>
                                    <div class="form-group col-sm-3">
                                        <label class="col-sm-4 control-label ">ตำบล : </label>
                                        <div class="col-sm-8">
                                            <select id="employment_subarea_permanent"
                                                    name="employment_subarea_permanent"
                                                    class="form-control" ;
                                                    data-errormessage-value-missing="กรุณาเลือก ตำบล" required>
                                                <?php echo $permanent_district; ?>
                                            </select>
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
                                                   maxlength="5" value="<?= $present_address[12] ?>">
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
                                                   maxlength="5" value="<?= $permanent_address[12] ?>">
                                            <div id="alert_employment_postal_permanent"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12"><br></div>

                                <div class="col-sm-12">
                                    <br>
                                </div>
                                <!-- finish old address-->

                                <div class="col-sm-12">
                                    <br>
                                </div>

                                <div class="col-sm-12"><h4 class="page-header">ประวัติครอบครัวและบุคคลอ้างอิง</h4>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group col-sm-8">
                                        <label class="col-sm-4 control-label ">ชื่อ - นามสกุล บิดา (ไทย)
                                            : </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="father_name"
                                                   name="father_name"
                                                   placeholder="ชื่อบิดา"
                                                   onkeyup="return check_father_name();" maxlength="60"
                                                   autofocus="autofocus" value="<?= $reference[2] ?>">
                                            <div id="alert_father_name"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label class="col-sm-4 control-label ">อายุ (ปี) : </label>
                                        <div class="col-sm-5">
                                            <select id="father_age" name="father_age"
                                                    class="form-control">
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
                                                   maxlength="60" value="<?= $reference[4] ?>">
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
                                                   data-on="มีชีวิตอยู่" data-offstyle="danger" data-width="100%"
                                                   data-off="เสียชีวิตแล้ว" <?php if ($reference[5] == 1) echo "checked"; ?>>
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
                                                   value="<?= $reference[6] ?>">
                                            <div id="alert_mother_name"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label class="col-sm-4 control-label ">อายุ (ปี) : </label>
                                        <div class="col-sm-5">
                                            <select id="mother_age" name="mother_age"
                                                    class="form-control">
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
                                                   maxlength="60" value="<?= $reference[8] ?>">
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
                                                   data-on="มีชีวิตอยู่" data-offstyle="danger" data-width="100%"
                                                   data-off="เสียชีวิตแล้ว" <?php if ($reference[9] == 1) echo "checked"; ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <br>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group col-sm-8">
                                        <label class="col-sm-4 control-label ">ชื่อ - นามสกุลบุคคลอ้างอิง (ไทย)
                                            : </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="reference_name"
                                                   name="reference_name" placeholder="ชื่อบุคคลอ้างอิง"
                                                   onkeyup="return check_reference_name();"
                                                   maxlength="50" value="<?= $reference[10] ?>">
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
                                                   maxlength="60" value="<?= $reference[11] ?>">
                                            <div id="alert_relationship"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group col-sm-8">
                                        <label class="col-sm-4 control-label ">ที่อยู่ บุคคลอ้างอิง : </label>
                                        <div class="col-sm-8">
                                                        <textarea id="reference_address" name="reference_address"
                                                                  rows="3" placeholder="ที่อยู่ บุคคลอ้างอิง"
                                                                  style="width:100%;" class="form-control"
                                                                  onkeyup="return check_address_relationship();"><?= $reference[12] ?></textarea>
                                            <div id="alert_address_relationship"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group col-sm-8">
                                        <label class="col-sm-4 control-label ">ตำแหน่ง
                                            : </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control"
                                                   id="position"
                                                   name="position"
                                                   placeholder="ตำแหน่งงาน"
                                                   onkeyup="return check_position();"
                                                   maxlength="50" value="<?= $reference[13] ?>">
                                            <div id="alert_position"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label class="col-sm-4 control-label ">เบอร์โทรศัพท์ : </label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="reference_phone"
                                                   name="reference_phone"
                                                   onkeyup="return check_phone_reference();"
                                                   placeholder="เบอร์โทรติดต่อ"
                                                   maxlength="10" value="<?= $reference[14] ?>">
                                            <div id="alert_phone_reference"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <br>
                                </div>

                                <div class="col-sm-12"><h4 class="page-header">ระดับความรู้ภาษาอังกฤษ</h4></div>
                                <div class="col-sm-12">
                                    <div class="form-group col-sm-8">
                                        <label class="col-sm-4 control-label ">ความเข้าใจ Understanding
                                            : </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="understand" name="understand"
                                                    autofocus="autofocus">
                                                <option value="1" <?php if ($skills[2] == 1) echo "selected" ?> >
                                                    พอใช้ ,Fair
                                                </option>
                                                <option value="2" <?php if ($skills[2] == 2) echo "selected" ?> >
                                                    ดี ,Good
                                                </option>
                                                <option value="3" <?php if ($skills[2] == 3) echo "selected" ?> >
                                                    ดีมาก ,Excellent
                                                </option>
                                            </select>
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
                                            <select class="form-control" id="speaking " name="speaking"
                                                    autofocus="autofocus">
                                                <option value="1" <?php if ($skills[3] == 1) echo "selected" ?>>
                                                    พอใช้ ,Fair
                                                </option>
                                                <option value="2" <?php if ($skills[3] == 2) echo "selected" ?>>
                                                    ดี ,Good
                                                </option>
                                                <option value="3" <?php if ($skills[3] == 3) echo "selected" ?>>
                                                    ดีมาก ,Excellent
                                                </option>
                                            </select>
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
                                            <select class="form-control" id="reading" name="reading"
                                                    autofocus="autofocus">
                                                <option value="1" <?php if ($skills[4] == 1) echo "selected" ?>>
                                                    พอใช้ ,Fair
                                                </option>
                                                <option value="2" <?php if ($skills[4] == 2) echo "selected" ?>>
                                                    ดี ,Good
                                                </option>
                                                <option value="3" <?php if ($skills[4] == 3) echo "selected" ?>>
                                                    ดีมาก ,Excellent
                                                </option>
                                            </select>
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
                                            <select class="form-control" id="writing" name="writing"
                                                    autofocus="autofocus">
                                                <option value="1" <?php if ($skills[5] == 1) echo "selected" ?>>
                                                    พอใช้ ,Fair
                                                </option>
                                                <option value="2" <?php if ($skills[5] == 2) echo "selected" ?>>
                                                    ดี ,Good
                                                </option>
                                                <option value="3" <?php if ($skills[5] == 3) echo "selected" ?>>
                                                    ดีมาก ,Excellent
                                                </option>
                                            </select>
                                            <div id="alert_writing"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12"><h4 class="page-header">ความสามารถพิเศษ</h4></div>
                                <div class="col-sm-12">
                                    <div class="form-group col-sm-8">
                                        <label class="col-sm-4 control-label ">ความสามารถ ขับรถยนต์
                                            : </label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" id="drive_car" name="drive_car"
                                                   data-toggle="toggle" data-onstyle="success"
                                                   data-on="ได้" data-offstyle="danger" data-width="100%"
                                                   data-off="ไม่ได้" <?php if ($skills[6] == 1) echo "checked"; ?>>
                                            <div id="alert_drive_car"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" id="license_car"
                                                       name="license_car" <?php if ($skills[7] == 1) echo "checked"; ?>>มีใบอนุญาติขับขี่รถยนต์
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
                                            <input type="checkbox" id="drive_motorcycle" name="drive_motorcycle"
                                                   data-toggle="toggle" data-onstyle="success"
                                                   data-on="ได้" data-offstyle="danger" data-width="100%"
                                                   data-off="ไม่ได้" <?php if ($skills[8] == 1) echo "checked"; ?>>
                                            <div id="alert_drive_motorcycle"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" id="license_motorcycle"
                                                       name="license_motorcycle" <?php if ($skills[9] == 1) echo "checked"; ?>>มีใบอนุญาติขับขี่รถจักรยานยนต์
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
                                                           value="1" <?php if ($skills[10] == 1) echo "checked"; ?>>คอมพิวเตอร์
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" id="can_calculator"
                                                           name="can_calculator"
                                                           value="1" <?php if ($skills[12] == 1) echo "checked"; ?>>เครื่องคิดเลข
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" id="can_typing" name="can_typing"
                                                           value="1" <?php if ($skills[11] == 1) echo "checked"; ?>>พิมพ์ดีด
                                                </label>
                                            </div>


                                        </div>
                                    </div>
                                </div>

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
                                                   autofocus="autofocus" <?php if ($skills[13] != "") echo "value='$skills[13]'"; ?>>
                                            <div id="alert_ability_etc"
                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <hr>
                                </div>

                                <div class="col-sm-12">
                                    <div style="float:right; padding-bottom:10px;">
                                        <button class="btn btn-primary" type="submit" id="submit">
                                            <i class="fa fa-sm fa-plus-square"></i> | บันทึกข้อมูล
                                        </button>

                                        <button class="btn btn-warning" id="check_value" type="button"
                                                id="button"
                                                onclick="check_value();">
                                            <i class="fa fa-sm fa-plus-square"></i> | chk
                                        </button>

                                        <button class="btn btn-warning" id="check_testt" type="button"
                                                id="button"
                                                onclick="check_testt();">
                                            <i class="fa fa-sm fa-plus-square"></i> | chk
                                        </button>
                                        <button type="reset" class="btn btn-default"
                                                data-dismiss="modal" onclick="back_page();">ยกเลิก
                                        </button>

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

    $(document).ready(function () {

        $("#employment_province").change(function () {
            var pvID = $("option:selected", this).val();
            if (pvID != "") {
                $.post("ajax_getamphur.php", {pvID: pvID}, function (data) {
                    $("#employment_area").html(data);
                });
            }
        });

        $("#employment_area").change(function () {
            var ampID = $("option:selected", this).val();
            if (ampID != "") {
                $.post("ajax_getdistrict.php", {ampID: ampID}, function (data) {
                    $("#employment_subarea").html(data);
                });
            }
        });

        $("#employment_province_permanent").change(function () {
            var pvID = $("option:selected", this).val();
            if (pvID != "") {
                $.post("ajax_getamphur.php", {pvID: pvID}, function (data) {
                    $("#employment_area_permanent").html(data);
                });
            }
        });

        $("#employment_area_permanent").change(function () {
            var ampID = $("option:selected", this).val();
            if (ampID != "") {
                $.post("ajax_getdistrict.php", {ampID: ampID}, function (data) {
                    $("#employment_subarea_permanent").html(data);
                });
            }
        });

    });

    //________________________ Start set attibute ______________________//
    $("#div_edit_soldier").show();
    $("#div_married_status").show();

    $("#alert_identification").hide();

    $("#alert_employment_address").hide();
    $("#alert_employment_housenumber").hide();
    $("#alert_employment_village").hide();
    $("#alert_employment_alley").hide();
    $("#alert_employment_lane").hide();
    $("#alert_employment_road").hide();
    $("#alert_employment_subarea").hide();
    $("#alert_employment_area").hide();
    $("#alert_employment_province").hide();
    $("#alert_employment_country").hide();
    $("#alert_employment_postal").hide();
    $("#alert_marital_status").hide();
    $("#alert_married_status").hide();

    $("#alert_address_permanent").hide();
    $("#alert_employment_housenumber_permanent").hide();
    $("#alert_employment_village_permanent").hide();
    $("#alert_employment_alley_permanent").hide();
    $("#alert_employment_lane_permanent").hide();
    $("#alert_employment_road_permanent").hide();
    $("#alert_employment_subarea_permanent").hide();
    $("#alert_employment_area_permanent").hide();
    $("#alert_employment_province_permanent").hide();
    $("#alert_employment_country_permanent").hide();
    $("#alert_employment_postal_permanent").hide();

    $("#alert_father_name").hide();
    $("#alert_father_career").hide();
    $("#alert_mother_name").hide();
    $("#alert_mother_career").hide();
    $("#alert_reference_name").hide();
    $("#alert_relationship").hide();
    $("#alert_address_relationship").hide();
    $("#alert_position").hide();
    $("#alert_phone_reference").hide();

    $("#alert_ability_etc").hide();

    var alert_identification = false;

    var alert_employment_address = false;
    var alert_employment_housenumber = false;
    var alert_employment_village = false;
    var alert_employment_alley = false;
    var alert_employment_lane = false;
    var alert_employment_road = false;
    var alert_employment_subarea = false;
    var alert_employment_area = false;
    var alert_employment_province = false;
    var alert_employment_country = false;
    var alert_employment_postal = false;
    var alert_marital_status = false;
    var alert_married_status = false;

    var alert_address_permanent = false;
    var alert_employment_housenumber_permanent = false;
    var alert_employment_village_permanent = false;
    var alert_employment_alley_permanent = false;
    var alert_employment_lane_permanent = false;
    var alert_employment_road_permanent = false;
    var alert_employment_subarea_permanent = false;
    var alert_employment_area_permanent = false;
    var alert_employment_province_permanent = false;
    var alert_employment_country_permanent = false;
    var alert_employment_postal_permanent = false;

    var alert_father_name = false;
    var alert_father_career = false;
    var alert_mother_name = false;
    var alert_mother_career = false;
    var alert_reference_name = false;
    var alert_relationship = false;
    var alert_address_relationship = false;
    var alert_position = false;
    var alert_phone_reference = false;

    var alert_ability_etc = false;

    $("#alert_fname_thai").hide();
    $("#alert_lname_thai").hide();
    $("#alert_fname_eng").hide();
    $("#alert_lname_eng").hide();
    $("#alert_email").hide();
    $("#alert_phone").hide();
    $("#alert_national").hide();
    $("#alert_ethnicity").hide();
    $("#alert_religion").hide();
    $("#alert_high").hide();
    $("#alert_weight").hide();
    $("#alert_born").hide();
    $("#alert_warn_image").hide();
    $("#alert_prename").hide();
    $("#alert_sex").hide();
    $("#alert_edit_soldier").hide();
    $("#alert_living_status").hide();
    $("#alert_type").hide();

    var alert_fname_thai = false;
    var alert_lname_thai = false;
    var alert_fname_eng = false;
    var alert_lname_eng = false;
    var alert_email = false;
    var alert_phone = false;
    var alert_national = false;
    var alert_ethnicity = false;
    var alert_religion = false;
    var alert_high = false;
    var alert_weight = false;
    var alert_born = false;
    var alert_prename = false;
    var alert_sex = false;
    var alert_edit_soldier = false;
    var alert_living_status = false;
    var alert_type = false;

    //________________________ Finish set attibute ______________________//

    //________________________ Start check error ______________________//

    function check_fname_thai() {
        var length = $("#fname_thai").val().length;
        var fname_thai = $("#fname_thai").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

//        console.log("fname thai : "+fname_thai);
        if (!fname_thai) {
            alert_fname_thai = true;
            $("#alert_fname_thai").show().html("*กรุณากรอกชื่อจริง ภาษาไทย");
            $("#fname_thai").focus();
        } else if (length > 50) {
            alert_fname_thai = true;
            $("#alert_fname_thai").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            $("#fname_thai").focus();
        } else if (length < 3) {
            alert_fname_thai = true;
            $("#alert_fname_thai").show().html("**กรุณากรอกชื่อผู้ใช้อย่างน้อย 3 ตัวอักษร");
            $("#fname_thai").focus();
        } else if (!pattern.test($("#fname_thai").val())) {
            alert_fname_thai = true;
            $("#alert_fname_thai").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#fname_thai").focus();
        } else {
            $("#alert_fname_thai").hide();
            alert_fname_thai = false;
        }
    }

    function check_lname_thai() {
        var length = $("#lname_thai").val().length;
        var lname_thai = $("#lname_thai").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (!lname_thai) {
            alert_lname_thai = true;
            $("#alert_lname_thai").show().html("*กรุณากรอกนามสกุล ภาษาไทย");
            $("#lname_thai").focus();
        } else if (length > 50) {
            alert_lname_thai = true;
            $("#alert_lname_thai").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            $("#lname_thai").focus();
        } else if (length < 3) {
            alert_lname_thai = true;
            $("#alert_lname_thai").show().html("**กรุณากรอกชื่อผู้ใช้อย่างน้อย 3 ตัวอักษร");
            $("#lname_thai").focus();
        } else if (!pattern.test($("#lname_thai").val())) {
            alert_lname_thai = true;
            $("#alert_lname_thai").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#lname_thai").focus();
        } else {
            $("#alert_lname_thai").hide();
            alert_lname_thai = false;
        }
    }

    function check_fname_eng() {
        var length = $("#fname_eng").val().length;
        var fname_eng = $("#fname_eng").val();
        var pattern = new RegExp(/^[a-zA-Z ]+$/);

        if (!fname_eng) {
            alert_fname_eng = true;
            $("#alert_fname_eng").show().html("*กรุณากรอกชื่อจริง ภาษาอังกฤษ");
            $("#fname_eng").focus();
        } else if (length > 50) {
            alert_fname_eng = true;
            $("#alert_fname_eng").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            $("#fname_eng").focus();
        } else if (length < 3) {
            alert_fname_eng = true;
            $("#alert_fname_eng").show().html("**กรุณากรอกชื่อผู้ใช้อย่างน้อย 3 ตัวอักษร");
            $("#fname_eng").focus();
        } else if (!pattern.test($("#fname_eng").val())) {
            alert_fname_eng = true;
            $("#alert_fname_eng").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z เท่านั้น");
            $("#fname_eng").focus();
        } else {
            $("#alert_fname_eng").hide();
            alert_fname_eng = false;
        }
    }

    function check_lname_eng() {
        var length = $("#lname_eng").val().length;
        var lname_eng = $("#lname_eng").val();
        var pattern = new RegExp(/^[a-zA-Z ]+$/);

        if (!lname_eng) {
            alert_lname_eng = true;
            $("#alert_lname_eng").show().html("*กรุณากรอกชื่อจริง ภาษาอังกฤษ");
            $("#lname_eng").focus();
        } else if (length > 50) {
            alert_lname_eng = true;
            $("#alert_lname_eng").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            $("#lname_eng").focus();
        } else if (length < 3) {
            alert_lname_eng = true;
            $("#alert_lname_eng").show().html("**กรุณากรอกชื่อผู้ใช้อย่างน้อย 3 ตัวอักษร");
            $("#lname_eng").focus();
        } else if (!pattern.test($("#lname_eng").val())) {
            alert_lname_eng = true;
            $("#alert_lname_eng").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z เท่านั้น");
            $("#lname_eng").focus();
        } else {
            $("#alert_lname_eng").hide();
            alert_lname_eng = false;
        }
    }

    function check_email() {
        var email = $("#email").val();
        var length = $("#email").val().length;
        var pattern = new RegExp(/^[a-zA-Z0-9 @_.-]+$/);

        if (!email) {
            $("#alert_email").show().html("*กรุณากรอกอีเมล์");
            alert_email = true;
            $("#email").focus();
        } else if (length > 50) {
            $("#alert_email").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_email = true;
            $("#email").focus();
        } else if (!pattern.test($("#email").val())) {
            alert_email = true;
            $("#email").focus();
            $("#alert_email").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z เท่านั้น");
        } else {
            $("#alert_email").hide();
            alert_email = false;
        }
    }

    function check_phone() {
        var pattern = new RegExp(/^[0-9 ]+$/);
        var str = $("#phone").val().substring(9, 10);

        if (!str) {
            $("#alert_phone").show().html("*กรุณากรอกเบอร์โทร");
            alert_phone = true;
            $("#phone").focus();
        } else if (str == "_") {
            $("#alert_phone").show().html("*กรุณากรอกเบอร์โทร");
            alert_phone = true;
            $("#phone").focus();
        } else if (!pattern.test($("#phone").val())) {
            alert_phone = true;
            $("#alert_phone ").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#phone").focus();
        } else {
            $("#alert_phone").hide();
            alert_phone = false;
        }
    }

    function check_national() {
        var national = $("#national").val();
        var length = $("#national").val().length;
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        if (!length) {
            $("#alert_national").show().html("*กรุณากรอกสัญชาติ");
            alert_national = true;
            $("#national").focus();
        } else if (length > 50) {
            $("#alert_national").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_national = true;
            $("#national").focus();
        } else if (!pattern.test($("#national").val())) {
            alert_national = true;
            $("#alert_national ").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#national").focus();
        } else {
            $("#alert_national").hide();
            alert_national = false;
        }
    }

    function check_ethnicity() {
        var ethnicity = $("#ethnicity").val();
        var length = $("#ethnicity ").val().length;
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        if (!length) {
            $("#alert_ethnicity").show().html("*กรุณากรอกเชื้อชาติ");
            alert_ethnicity = true;
            $("#ethnicity").focus();
        } else if (length > 50) {
            $("#alert_ethnicity").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_ethnicity = true;
            $("#ethnicity").focus();
        } else if (!pattern.test($("#ethnicity").val())) {
            alert_ethnicity = true;
            $("#alert_ethnicity ").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#ethnicity").focus();
        } else {
            $("#alert_ethnicity").hide();
            alert_ethnicity = false;
        }
    }

    function check_religion() {
        var religion = $("#religion").val();
        var length = $("#religion ").val().length;
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        if (!length) {
            $("#alert_religion").show().html("*กรุณากรอกศาสนา");
            alert_religion = true;
            $("#religion").focus();
        } else if (length > 50) {
            $("#alert_religion").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_religion = true;
            $("#religion").focus();
        } else if (!pattern.test($("#religion").val())) {
            alert_religion = true;
            $("#alert_religion").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#religion").focus();
        } else {
            $("#alert_religion").hide();
            alert_religion = false;
        }
    }

    function check_high() {
        var high = $("#high").val();
        var length = $("#high").val().length;
        var pattern = new RegExp(/^[0-9 ]+$/);

        if (!length) {
            $("#alert_high").show().html("*กรุณากรอกส่วนสูง");
            alert_high = true;
            $("#high").focus();
        } else if (length > 3) {
            $("#alert_high").show().html("*กรุณากรอกตัวเลขไม่เกิน 3 หลัก");
            alert_high = true;
            $("#high").focus();
        } else if (!pattern.test($("#high").val())) {
            alert_high = true;
            $("#alert_high").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#high").focus();
        } else {
            $("#alert_high").hide();
            alert_high = false;
        }
    }

    function check_weight() {
        var weight = $("#weight").val();
        var length = $("#weight").val().length;
        var pattern = new RegExp(/^[0-9 ]+$/);

        if (!length) {
            $("#alert_weight").show().html("*กรุณากรอกน้ำหนัก");
            alert_weight = true;
            $("#weight").focus();
        } else if (length > 3) {
            $("#alert_weight").show().html("*กรุณากรอกตัวเลขไม่เกิน 3 หลัก");
            alert_weight = true;
            $("#high").focus();
        } else if (!pattern.test($("#weight").val())) {
            alert_weight = true;
            $("#alert_weight").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#weight").focus();
        } else {
            $("#alert_weight").hide();
            alert_weight = false;
        }
    }

    function check_born() {
        var born = $("#born").val();
        var length = $("#born ").val().length;
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        if (!length) {
            $("#alert_born").show().html("*กรุณากรอกสถานที่เกิด");
            alert_born = true;
            $("#born").focus();
        } else if (length > 50) {
            $("#alert_born").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_born = true;
            $("#born").focus();
        } else if (!pattern.test($("#born").val())) {
            alert_born = true;
            $("#alert_born").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#born").focus();
        } else {
            $("#alert_born").hide();
            alert_born = false;
        }
    }

    function check_identification() {
        var pattern = new RegExp(/^[0-9 ]+$/);
        var identification = $("#identification").val().substring(12, 13);

        if (!identification) {
            $("#alert_identification").show().html("*กรุณากรอกหมายเลขบัตรประจำตัว");
            alert_identification = true;
            $("#identification").focus();
        } else if (identification == "_") {
            $("#alert_identification").show().html("*กรุณากรอกหมายเลขบัตรประจำตัว");
            alert_identification = true;
            $("#identification").focus();
        } else if (!pattern.test($("#identification").val())) {
            alert_identification = true;
            $("#alert_identification ").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#identification").focus();
        } else {
            $("#alert_identification").hide();
            alert_identification = false;
        }
    }

    //________________________ Finish check error ______________________//

    //__________________________________ Start function check address
    function check_employment_address() {
        var length = $("#employment_address").val().length;
        var employment_address_permanent = $("#employment_address").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็0-9.-/, ]+$/);
        if (!length) {
            alert_employment_address = true;
            $("#alert_employment_address").show().html("*กรุณากรอก ที่อยู่");
            $("#employment_address").focus();
        } else if (length > 50) {
            alert_employment_address = true;
            $("#alert_employment_address").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            $("#employment_address").focus();
        } else if (length < 3) {
            alert_employment_address = true;
            $("#alert_employment_address").show().html("**กรุณากรอกข้อมูลอย่างน้อย 5 ตัวอักษร");
            $("#employment_address").focus();
        } else if (!pattern.test($("#employment_address").val())) {
            alert_employment_address = true;
            $("#alert_employment_address").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ,0-9 เท่านั้น");
            $("#employment_address").focus();
        } else {
            $("#alert_employment_address").hide();
            alert_employment_address = false;
        }
    }

    function check_employment_housenumber() {
        var pattern = new RegExp(/^[0-9 /]+$/);
        var length = $("#employment_housenumber").val().length;

        if (!length) {
            $("#employment_housenumber").focus();
            $("#alert_employment_housenumber").show().html("*กรุณากรอกบ้านเลขที่");
            alert_employment_housenumber = true;
        } else if (!pattern.test($("#employment_housenumber").val())) {
            $("#employment_housenumber").focus();
            $("#alert_employment_housenumber").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            alert_employment_housenumber = true;
        } else {
            $("#alert_employment_housenumber").hide();
            alert_employment_housenumber = false;
        }
    }

    function check_employment_village() {
        var pattern = new RegExp(/^[0-9]+$/);
        var length = $("#employment_village").val().length;

        if (!length) {
            $("#employment_village").focus();
            $("#alert_employment_village").show().html("*กรุณากรอกหมู่ที่");
            alert_employment_village = true;
        } else if (!pattern.test($("#employment_village").val())) {
            $("#employment_village").focus();
            $("#alert_employment_village").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            alert_employment_village = true;
        } else {
            $("#alert_employment_village").hide();
            alert_employment_village = false;
        }
    }

    function check_employment_alley() {
        var pattern = new RegExp(/^[0-9 -]+$/);
        var length = $("#employment_alley").val().length;

        if (!length) {
            $("#employment_alley").focus();
            $("#alert_employment_alley").show().html("*กรุณากรอกตรอก");
            alert_employment_alley = true;
        } else if (!pattern.test($("#employment_alley").val())) {
            $("#employment_alley").focus();
            $("#alert_employment_alley").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            alert_employment_alley = true;
        } else {
            $("#alert_employment_alley").hide();
            alert_employment_alley = false;
        }
    }

    function check_employment_lane() {
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็0-9.-/, _-]+$/);
        var length = $("#employment_lane").val().length;

        if (!length) {
            $("#employment_lane").focus();
            $("#alert_employment_lane").show().html("*กรุณากรอกซอย");
            alert_employment_lane = true;
        } else if (!pattern.test($("#employment_lane").val())) {
            $("#employment_lane").focus();
            $("#alert_employment_lane").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ,0-9 เท่านั้น");
            alert_employment_lane = true;
        } else {
            $("#alert_employment_lane").hide();
            alert_employment_lane = false;
        }
    }

    function check_employment_road() {
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็0-9.-/, _-]+$/);
        var length = $("#employment_road").val().length;

        if (!length) {
            $("#employment_road").focus();
            $("#alert_employment_road").show().html("*กรุณากรอกถนน");
            alert_employment_road = true;
        } else if (!pattern.test($("#employment_road").val())) {
            $("#employment_road").focus();
            $("#alert_employment_road").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ,0-9 เท่านั้น");
            alert_employment_road = true;
        } else {
            $("#alert_employment_road").hide();
            alert_employment_road = false;
        }
    }

    function check_employment_subarea() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_-]+$/);
        var length = $("#employment_subarea").val().length;

        if (!length) {
            $("#employment_subarea").focus();
            $("#alert_employment_subarea").show().html("*กรุณากรอกตำบล");
            alert_employment_subarea = true;
        } else if (!pattern.test($("#employment_subarea").val())) {
            $("#employment_subarea").focus();
            $("#alert_employment_subarea").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            alert_employment_subarea = true;
        } else {
            $("#alert_employment_subarea").hide();
            alert_employment_subarea = false;
        }
    }

    function check_employment_area() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_-]+$/);
        var length = $("#employment_area").val().length;

        if (!length) {
            $("#employment_area").focus();
            $("#alert_employment_area").show().html("*กรุณากรอกอำเภอ");
            alert_employment_area = true;
        } else if (!pattern.test($("#employment_area").val())) {
            $("#employment_area").focus();
            $("#alert_employment_area").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            alert_employment_area = true;
        } else {
            $("#alert_employment_area").hide();
            alert_employment_area = false;
        }
    }

    function check_employment_province() {
        var length = $("#employment_province").val().length;
        var employment_province = $("#employment_province").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_ไใ]+$/);

        if (!length) {
            alert_employment_province = true;
            $("#alert_employment_province").show().html("*กรุณากรอก จังหวัด");
            $("#employment_province").focus();
        } else if (length > 50) {
            alert_employment_province = true;
            $("#alert_employment_province").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            $("#employment_province").focus();
        } else if (length < 2) {
            alert_employment_province = true;
            $("#alert_employment_province").show().html("**กรุณากรอกชื่อผู้ใช้อย่างน้อย 2 ตัวอักษร");
            $("#employment_province").focus();
        } else if (!pattern.test($("#employment_province").val())) {
            alert_employment_province = true;
            $("#alert_employment_province").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#employment_province").focus();
        } else {
            $("#alert_employment_province").hide();
            alert_employment_province = false;
        }
    }

    function check_employment_country() {
        var length = $("#employment_country").val().length;
        var employment_country = $("#employment_country").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (!length) {
            alert_employment_country = true;
            $("#alert_employment_country").show().html("*กรุณากรอก ประเทศ");
            $("#employment_country").focus();
        } else if (length > 50) {
            alert_employment_country = true;
            $("#alert_employment_country").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            $("#employment_country").focus();
        } else if (length < 2) {
            alert_employment_country = true;
            $("#alert_employment_country").show().html("**กรุณากรอกชื่อผู้ใช้อย่างน้อย 2 ตัวอักษร");
            $("#employment_country").focus();
        } else if (!pattern.test($("#employment_country").val())) {
            alert_employment_country = true;
            $("#alert_employment_country").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#employment_country").focus();
        } else {
            $("#alert_employment_country").hide();
            alert_employment_country = false;
        }
    }

    function check_employment_postal() {
        var employment_postal = $("#employment_postal").val();
        var length = $("#employment_postal").val().length;
        var pattern = new RegExp(/^[0-9 ]+$/);

        if (!length) {
            $("#alert_employment_postal").show().html("*กรุณากรอกรหัสไปรษณีย์");
            alert_employment_postal = true;
            $("#employment_postal").focus();
        } else if (!pattern.test($("#employment_postal").val())) {
            alert_employment_postal = true;
            $("#alert_employment_postal").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#employment_postal").focus();
        } else {
            $("#alert_employment_postal").hide();
            alert_employment_postal = false;
        }
    }

    //__________________________________ Finish function check address

    //__________________________________ Start function check address permanent
    function check_address_permanent() {
        var length = $("#employment_address_permanent").val().length;
        var employment_address_permanent = $("#employment_address_permanent").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็0-9.-/, ]+$/);
        if (!length) {
            alert_address_permanent = true;
            $("#alert_address_permanent").show().html("*กรุณากรอก ที่อยู่ถาวร");
            $("#employment_address_permanent").focus();
        } else if (length > 50) {
            alert_address_permanent = true;
            $("#alert_address_permanent").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            $("#employment_address_permanent").focus();
        } else if (length < 3) {
            alert_address_permanent = true;
            $("#alert_address_permanent").show().html("**กรุณากรอกข้อมูลอย่างน้อย 5 ตัวอักษร");
            $("#employment_address_permanent").focus();
        } else if (!pattern.test($("#employment_address_permanent").val())) {
            alert_address_permanent = true;
            $("#alert_address_permanent").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ,0-9 เท่านั้น");
            $("#employment_address_permanent").focus();
        } else {
            $("#alert_address_permanent").hide();
            alert_address_permanent = false;
        }
    }

    function check_employment_housenumber_permanent() {
        var pattern = new RegExp(/^[0-9 /]+$/);
        var length = $("#employment_housenumber_permanent").val().length;

        if (!length) {
            $("#employment_housenumber_permanent").focus();
            $("#alert_employment_housenumber_permanent").show().html("*กรุณากรอกบ้านเลขที่");
            alert_employment_housenumber_permanent = true;
        } else if (!pattern.test($("#employment_housenumber_permanent").val())) {
            $("#employment_housenumber_permanent").focus();
            $("#alert_employment_housenumber_permanent").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            alert_employment_housenumber_permanent = true;
        } else {
            $("#alert_employment_housenumber_permanent").hide();
            alert_employment_housenumber_permanent = false;
        }
    }

    function check_employment_village_permanent() {
        var pattern = new RegExp(/^[0-9]+$/);
        var length = $("#employment_village_permanent").val().length;

        if (!length) {
            $("#employment_village_permanent").focus();
            $("#alert_employment_village_permanent").show().html("*กรุณากรอกหมู่ที่");
            alert_employment_village_permanent = true;
        } else if (!pattern.test($("#employment_village_permanent").val())) {
            $("#employment_village_permanent").focus();
            $("#alert_employment_village_permanent").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            alert_employment_village_permanent = true;
        } else {
            $("#alert_employment_village_permanent").hide();
            alert_employment_village_permanent = false;
        }
    }

    function check_employment_alley_permanent() {
        var pattern = new RegExp(/^[0-9 -]+$/);
        var length = $("#employment_alley_permanent").val().length;

        if (!length) {
            $("#employment_alley_permanent").focus();
            $("#alert_employment_alley_permanent").show().html("*กรุณากรอกตรอก");
            alert_employment_alley_permanent = true;
        } else if (!pattern.test($("#employment_alley_permanent").val())) {
            $("#employment_alley_permanent").focus();
            $("#alert_employment_alley_permanent").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            alert_employment_alley_permanent = true;
        } else {
            $("#alert_employment_alley_permanent").hide();
            alert_employment_alley_permanent = false;
        }
    }

    function check_employment_lane_permanent() {
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็0-9.-/, _-]+$/);
        var length = $("#employment_lane_permanent").val().length;

        if (!length) {
            $("#employment_lane_permanent").focus();
            $("#alert_employment_lane_permanent").show().html("*กรุณากรอกซอย");
            alert_employment_lane_permanent = true;
        } else if (!pattern.test($("#employment_lane_permanent").val())) {
            $("#employment_lane_permanent").focus();
            $("#alert_employment_lane_permanent").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ,0-9 เท่านั้น");
            alert_employment_lane_permanent = true;
        } else {
            $("#alert_employment_lane_permanent").hide();
            alert_employment_lane_permanent = false;
        }
    }

    function check_employment_road_permanent() {
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็0-9.-/, _-]+$/);
        var length = $("#employment_road_permanent").val().length;

        if (!length) {
            $("#employment_road_permanent").focus();
            $("#alert_employment_road_permanent").show().html("*กรุณากรอกถนน");
            alert_employment_road_permanent = true;
        } else if (!pattern.test($("#employment_road_permanent").val())) {
            $("#employment_road_permanent").focus();
            $("#alert_employment_road_permanent").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ,0-9 เท่านั้น");
            alert_employment_road_permanent = true;
        } else {
            $("#alert_employment_road_permanent").hide();
            alert_employment_road_permanent = false;
        }
    }

    function check_employment_subarea_permanent() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_-]+$/);
        var length = $("#employment_subarea_permanent").val().length;

        if (!length) {
            $("#employment_subarea_permanent").focus();
            $("#alert_employment_subarea_permanent").show().html("*กรุณากรอกตำบล");
            alert_employment_subarea_permanent = true;
        } else if (!pattern.test($("#employment_subarea_permanent").val())) {
            $("#employment_subarea_permanent").focus();
            $("#alert_employment_subarea_permanent").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            alert_employment_subarea_permanent = true;
        } else {
            $("#alert_employment_subarea_permanent").hide();
            alert_employment_subarea_permanent = false;
        }
    }

    function check_employment_area_permanent() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_-]+$/);
        var length = $("#employment_area_permanent").val().length;

        if (!length) {
            $("#employment_area_permanent").focus();
            $("#alert_employment_area_permanent").show().html("*กรุณากรอกอำเภอ");
            alert_employment_area_permanent = true;
        } else if (!pattern.test($("#employment_area_permanent").val())) {
            $("#employment_area_permanent").focus();
            $("#alert_employment_area_permanent").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            alert_employment_area_permanent = true;
        } else {
            $("#alert_employment_area_permanent").hide();
            alert_employment_area_permanent = false;
        }
    }

    function check_employment_province_permanent() {
        var length = $("#employment_province_permanent").val().length;
        var employment_province = $("#employment_province_permanent").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_ไใ]+$/);

        if (!length) {
            alert_employment_province_permanent = true;
            $("#alert_employment_province_permanent").show().html("*กรุณากรอก จังหวัด");
            $("#employment_province_permanent").focus();
        } else if (length > 50) {
            alert_employment_province_permanent = true;
            $("#alert_employment_province_permanent").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            $("#employment_province_permanent").focus();
        } else if (length < 2) {
            alert_employment_province_permanent = true;
            $("#alert_employment_province_permanent").show().html("**กรุณากรอกชื่อผู้ใช้อย่างน้อย 2 ตัวอักษร");
            $("#employment_province_permanent").focus();
        } else if (!pattern.test($("#employment_province_permanent").val())) {
            alert_employment_province_permanent = true;
            $("#alert_employment_province_permanent").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#employment_province_permanent").focus();
        } else {
            $("#alert_employment_province_permanent").hide();
            alert_employment_province_permanent = false;
        }
    }

    function check_employment_country_permanent() {
        var length = $("#employment_country_permanent").val().length;
        var employment_country = $("#employment_country_permanent").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (!length) {
            alert_employment_country_permanent = true;
            $("#alert_employment_country_permanent").show().html("*กรุณากรอก ประเทศ");
            $("#employment_country_permanent").focus();
        } else if (length > 50) {
            alert_employment_country_permanent = true;
            $("#alert_employment_country_permanent").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            $("#employment_country_permanent").focus();
        } else if (length < 2) {
            alert_employment_country_permanent = true;
            $("#alert_employment_country_permanent").show().html("**กรุณากรอกชื่อผู้ใช้อย่างน้อย 2 ตัวอักษร");
            $("#employment_country_permanent").focus();
        } else if (!pattern.test($("#employment_country_permanent").val())) {
            alert_employment_country_permanent = true;
            $("#alert_employment_country_permanent").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#employment_country_permanent").focus();
        } else {
            $("#alert_employment_country_permanent").hide();
            alert_employment_country_permanent = false;
        }
    }

    function check_employment_postal_permanent() {
        var employment_postal_permanent = $("#employment_postal_permanent").val();
        var length = $("#employment_postal_permanent").val().length;
        var pattern = new RegExp(/^[0-9 ]+$/);

        if (!length) {
            $("#alert_employment_postal_permanent").show().html("*กรุณากรอกรหัสไปรษณีย์");
            alert_employment_postal_permanent = true;
            $("#employment_postal_permanent").focus();
        } else if (!pattern.test($("#employment_postal_permanent").val())) {
            alert_employment_postal_permanent = true;
            $("#alert_employment_postal_permanent").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#employment_postal_permanent").focus();
        } else {
            $("#alert_employment_postal_permanent").hide();
            alert_employment_postal_permanent = false;
        }
    }

    //__________________________________ Finish function check address permanent

    //__________________________________ Start function check reference
    function check_father_name() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        var father_name = $("#father_name").val();
        var length = $("#father_name").val().length;

        if (!length) {
            $("#alert_father_name").show().html("*กรุณากรอก ชื่อ - นามสกุล บิดา");
            alert_father_name = true;
            $("#father_name").focus();
        } else if (father_name == "_") {
            $("#alert_father_name").show().html("*กรุณากรอก ชื่อ - นามสกุล บิดา");
            alert_father_name = true;
            $("#father_name").focus();
        } else if (length > 50) {
            $("#alert_father_name").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_father_name = true;
            $("#father_name").focus();
        } else if (!pattern.test($("#father_name").val())) {
            alert_father_name = true;
            $("#alert_father_name ").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#father_name").focus();
        } else {
            $("#alert_father_name").hide();
            alert_father_name = false;
            chk_father_name = true;
        }
    }

    function check_father_career() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        var father_career = $("#father_career").val();
        var length = $("#father_career").val().length;

        if (!length) {
            $("#alert_father_career").show().html("*กรุณากรอก อาชีพ บิดา");
            alert_father_career = true;
            $("#father_career").focus();
        } else if (father_career == "_") {
            $("#alert_father_career").show().html("*กรุณากรอก อาชีพ บิดา");
            alert_father_career = true;
            $("#father_career").focus();
        } else if (length > 50) {
            $("#alert_father_career").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_father_career = true;
            $("#father_career").focus();
        } else if (!pattern.test($("#father_career").val())) {
            alert_father_career = true;
            $("#alert_father_career ").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#father_career").focus();
        } else {
            $("#alert_father_career").hide();
            alert_father_career = false;
            chk_father_career = true;
        }
    }

    function check_mother_name() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        var mother_name = $("#mother_name").val();
        var length = $("#mother_name").val().length;

        if (!length) {
            $("#alert_mother_name").show().html("*กรุณากรอก ชื่อ - นามสกุล มารดา");
            alert_mother_name = true;
            $("#mother_name").focus();
        } else if (mother_name == "_") {
            $("#alert_mother_name").show().html("*กรุณากรอก ชื่อ - นามสกุล มารดา");
            alert_mother_name = true;
            $("#mother_name").focus();
        } else if (length > 50) {
            $("#alert_mother_name").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_mother_name = true;
            $("#mother_name").focus();
        } else if (!pattern.test($("#mother_name").val())) {
            alert_mother_name = true;
            $("#alert_mother_name ").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#mother_name").focus();
        } else {
            $("#alert_mother_name").hide();
            alert_mother_name = false;
            chk_mother_name = true;
        }
    }

    function check_mother_career() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        var mother_career = $("#mother_career").val();
        var length = $("#mother_career").val().length;

        if (!length) {
            $("#alert_mother_career").show().html("*กรุณากรอก อาชีพ บิดา");
            alert_mother_career = true;
            $("#mother_career").focus();
        } else if (mother_career == "_") {
            $("#alert_mother_career").show().html("*กรุณากรอก อาชีพ บิดา");
            alert_mother_career = true;
            $("#mother_career").focus();
        } else if (length > 50) {
            $("#alert_mother_career").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_mother_career = true;
            $("#mother_career").focus();
        } else if (!pattern.test($("#mother_career").val())) {
            alert_mother_career = true;
            $("#alert_mother_career ").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#mother_career").focus();
        } else {
            $("#alert_mother_career").hide();
            alert_mother_career = false;
            chk_mother_career = true;
        }
    }

    function check_reference_name() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        var reference_name = $("#reference_name").val();
        var length = $("#reference_name").val().length;

        if (!length) {
            $("#alert_reference_name").show().html("*กรุณากรอก ชื่อ - นามสกุล บุคคลอ้างอิง");
            alert_reference_name = true;
            $("#reference_name").focus();
        } else if (reference_name == "_") {
            $("#alert_reference_name").show().html("*กรุณากรอก ชื่อ - นามสกุล บุคคลอ้างอิง");
            alert_reference_name = true;
            $("#reference_name").focus();
        } else if (length > 50) {
            $("#alert_reference_name").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_reference_name = true;
            $("#reference_name").focus();
        } else if (!pattern.test($("#reference_name").val())) {
            alert_reference_name = true;
            $("#alert_reference_name ").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#reference_name").focus();
        } else {
            $("#alert_reference_name").hide();
            alert_reference_name = false;
        }
    }


    function check_relationship() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        var relationship = $("#relationship").val();
        var length = $("#relationship").val().length;

        if (!length) {
            $("#alert_relationship").show().html("*กรุณากรอก ความสัมพันธ์ บุคคลอ้างอิง");
            alert_relationship = true;
            $("#relationship").focus();
        } else if (relationship == "_") {
            $("#alert_relationship").show().html("*กรุณากรอก ความสัมพันธ์ บุคคลอ้างอิง");
            alert_relationship = true;
            $("#relationship").focus();
        } else if (length > 50) {
            $("#alert_relationship").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_relationship = true;
            $("#relationship").focus();
        } else if (!pattern.test($("#relationship").val())) {
            alert_relationship = true;
            $("#alert_relationship ").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#relationship").focus();
        } else {
            $("#alert_relationship").hide();
            alert_relationship = false;
            chk_relationship = true;
        }
    }

    function check_address_relationship() {
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็0-9.-/, ]+$/);
        var address_relationship = $("#reference_address").val();
        var length = $("#reference_address").val().length;

        if (!length) {
            $("#alert_address_relationship").show().html("*กรุณากรอก ที่อยู่ บุคคลอ้างอิง");
            alert_address_relationship = true;
            $("#reference_address").focus();
        } else if (address_relationship == "_") {
            $("#alert_address_relationship").show().html("*กรุณากรอก ที่อยู่ บุคคลอ้างอิง");
            alert_address_relationship = true;
            $("#reference_address").focus();
        } else if (length > 100) {
            $("#alert_address_relationship").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            alert_address_relationship = true;
            $("#reference_address").focus();
        } else if (!pattern.test($("#reference_address").val())) {
            alert_address_relationship = true;
            $("#alert_address_relationship ").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ,0-9 เท่านั้น");
            $("#reference_address").focus();
        } else {
            $("#alert_address_relationship").hide();
            alert_address_relationship = false;
            chk_address_relationship = true;
        }
    }

    function check_position() {
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        var position = $("#position").val();
        var length = $("#position").val().length;

        if (!length) {
            $("#alert_position").hide();
            alert_position = false;
        } else if (position == "_") {
            $("#alert_position").hide();
            alert_position = false;
        } else if (length > 50) {
            $("#alert_position").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            alert_position = true;
            $("#position").focus();
        } else if (!pattern.test($("#position").val())) {
            alert_position = true;
            $("#alert_position ").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#position").focus();
        } else {
            $("#alert_position").hide();
            alert_position = false;
        }
    }

    function check_phone_reference() {
        var pattern = new RegExp(/^[0-9 ]+$/);
        var phone_reference = $("#reference_phone").val().substring(9, 10);

        if (!phone_reference) {
            $("#alert_phone_reference").show().html("*กรุณากรอกเบอร์โทร");
            alert_phone_reference = true;
            $("#reference_phone").focus();
        } else if (phone_reference == "_") {
            $("#alert_phone_reference").show().html("*กรุณากรอกเบอร์โทร");
            alert_phone_reference = true;
            $("#reference_phone").focus();
        } else if (!pattern.test($("#reference_phone").val())) {
            alert_phone_reference = true;
            $("#alert_phone_reference ").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#reference_phone").focus();
        } else {
            $("#alert_phone_reference").hide();
            alert_phone_reference = false;
            chk_phone_reference = true;
        }
    }

    function check_ability_etc() {
        var length = $("#ability_etc").val().length;
        var ability_etc = $("#ability_etc").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_0-9+#]+$/);

        if (!length) {
            alert_ability_etc = false;
            $("#alert_ability_etc").hide();
        } else if (!pattern.test($("#ability_etc").val())) {
            alert_ability_etc = true;
            $("#alert_ability_etc").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#ability_etc").focus();
        } else if (length > 100) {
            alert_ability_etc = true;
            $("#alert_ability_etc").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            $("#ability_etc").focus();
        } else {
            alert_ability_etc = false;
            $("#alert_ability_etc").hide();
        }
    }

    //__________________________________ Finish function check reference


    //________________________ Script for system ______________________//

    function check_prename() {
        var prename = $("#edit_prename").val();
        
        if (prename == 0) {
            document.getElementById("edit_sex").value = 0;
            $("#alert_prename").show().html("*กรุณาเลือกคำนำหน้าชื่อ");
            $("#alert_sex").show().html("*กรุณาเลือกเพศ");
            $("#div_edit_soldier").hide();
            $("#prename").focus();
            alert_sex = true;
            alert_prename = true;
        } else if (prename == 1){
            document.getElementById("edit_sex").value = 1;

            $("#alert_prename").hide();
            $("#alert_sex").hide();
            $("#div_edit_soldier").show();
            alert_sex = false;
            alert_prename = false;
        } else if (prename == 2){
            document.getElementById("edit_sex").value = 2;
            $("#alert_prename").hide();
            $("#alert_sex").hide();
            $("#div_edit_soldier").hide();
            alert_sex = false;
            alert_prename = false;
        } else {
            document.getElementById("edit_sex").value = 2;
            $("#alert_prename").hide();
            $("#alert_sex").hide();
            $("#div_edit_soldier").hide();
            alert_sex = false;
            alert_prename = false;
        }
    }

    function check_edit_sex() {
        var sex = $("#edit_sex").val();

        if (sex == 0) {
            document.getElementById("edit_prename").value = 0;
            $("#alert_prename").show().html("*กรุณาเลือกคำนำหน้าชื่อ");
            $("#alert_sex").show().html("*กรุณาเลือกเพศ");
            $("#div_edit_soldier").hide();
            $("#edit_sex").focus();
            alert_prename = true;
            alert_sex = true;
        } else if (sex == 1) {
            document.getElementById("edit_prename").value = 1;
            $("#div_edit_soldier").show();
            $("#alert_sex").hide();
            $("#alert_prename").hide();
            alert_prename = false;
            alert_sex = false;
        } else if (sex == 2) {
            document.getElementById("edit_prename").value = 2;
            $("#div_edit_soldier").hide();
            $("#alert_sex").hide();
            $("#alert_prename").hide();
            alert_prename = false;
            alert_sex = false;
        } else {
            $("#div_edit_soldier").hide();
            $("#alert_sex").hide();
            alert_sex = false;
        }
    }


    function check_edit_soldier() {
        var edit_soldier = $("#edit_soldier").val();
        var sex = $("#edit_sex").val();
        if (sex == 1) {
            if (edit_soldier == 0) {
                $("#alert_edit_soldier").show().html("*กรุณาเลือกสถานภาพทางทหาร");
                $("#edit_soldier").focus();
                alert_edit_soldier = true;
            } else {
                $("#alert_edit_soldier").hide();
                alert_edit_soldier = false;
            }
        }
    }

    function check_living_status() {
        var living_status = $("#living_status").val();
        if (living_status == 0) {
            $("#alert_living_status").show().html("*กรุณาเลือกที่พักอาศัย");
            $("#living_status").focus();
            alert_living_status = true;
        } else {
            $("#alert_living_status").hide();
            alert_living_status = false;
        }
    }

    function check_type() {
        var type = $("#type").val();
        if (type == 0) {
            $("#alert_type").show().html("*กรุณาเลือกประเภทบัตร");
            $("#type").focus();
            alert_type = true;
        } else {
            $("#alert_type").hide();
            alert_type = false;
        }
    }

    function chk_marital_status() {
        var marital_status = $("#marital_status").val();

        if (marital_status == 0) {
            alert_marital_status = true;
            $("#marital_status").focus();
            $("#div_married_status").hide();
            document.getElementById("married_status").value = 0;
            $("#alert_marital_status").show().html("กรุณาเลือกสถานะครอบครัว");
        } else if (marital_status == 2) {
            alert_marital_status = false;
            $("#div_married_status").show();
            $("#alert_marital_status").hide();
        } else {
            alert_marital_status = false;
            $("#div_married_status").hide();
            $("#alert_marital_status").hide();
            document.getElementById("married_status").value = 0;
        }
    }

    function check_married_status() {
        var marital_status = $("#marital_status").val();
        var married_status = $("#married_status").val();

        if (marital_status == 2) {
            if (married_status == 0) {
                alert_marital_status = true;
                $("#married_status").focus();
                $("#alert_married_status").show().html("*กรุณาเลือกสถานะแต่งงาน");
            } else {
                $("#alert_married_status").hide();
                alert_married_status = false;
            }
        }

    }

    function back_page() {
        window.location = 'index.php?mod=hr/manage_person';
    }

    $("#check_value").hide();
    $("#check_testt").hide();

    function check_testt() {
        console.log("____________________________________________________________________________________");
        console.log("alert_fname_thai : " + alert_fname_thai);
        console.log("alert_lname_thai : " + alert_lname_thai);
        console.log("alert_fname_eng : " + alert_fname_eng);
        console.log("alert_lname_eng : " + alert_lname_eng);
        console.log("alert_email : " + alert_email);
        console.log("alert_phone : " + alert_phone);
        console.log("alert_national : " + alert_national);
        console.log("alert_ethnicity : " + alert_ethnicity);
        console.log("alert_religion : " + alert_religion);
        console.log("alert_high : " + alert_high);
        console.log("alert_weight : " + alert_weight);
        console.log("alert_born : " + alert_born);

        console.log("alert_marital_status : " + alert_marital_status);

        console.log("alert_prename : " + alert_prename);
        console.log("alert_sex : " + alert_sex);
        console.log("alert_edit_soldier : " + alert_edit_soldier);
        console.log("alert_living_status : " + alert_living_status);
        console.log("alert_type : " + alert_type);

        console.log("alert_ability_etc : " + alert_ability_etc);
        console.log("alert_identification : " + alert_identification);

        console.log("alert_employment_postal_permanent : " + alert_employment_postal_permanent);
        console.log("alert_employment_country_permanent : " + alert_employment_country_permanent);
        console.log("alert_employment_province_permanent : " + alert_employment_province_permanent);
        console.log("alert_employment_area_permanent : " + alert_employment_area_permanent);
        console.log("alert_employment_subarea_permanent : " + alert_employment_subarea_permanent);
        console.log("alert_employment_road_permanent : " + alert_employment_road_permanent);
        console.log("alert_employment_lane_permanent : " + alert_employment_lane_permanent);
        console.log("alert_employment_alley_permanent : " + alert_employment_alley_permanent);
        console.log("alert_employment_village_permanent : " + alert_employment_village_permanent);
        console.log("alert_employment_housenumber_permanent : " + alert_employment_housenumber_permanent);
        console.log("alert_address_permanent : " + alert_address_permanent);

        console.log("alert_employment_postal : " + alert_employment_postal);
        console.log("alert_employment_country : " + alert_employment_country);
        console.log("alert_employment_province : " + alert_employment_province);
        console.log("alert_employment_area : " + alert_employment_area);
        console.log("alert_employment_subarea : " + alert_employment_subarea);
        console.log("alert_employment_road : " + alert_employment_road);
        console.log("alert_employment_lane : " + alert_employment_lane);
        console.log("alert_employment_alley : " + alert_employment_alley);
        console.log("alert_employment_village : " + alert_employment_village);
        console.log("alert_employment_housenumber : " + alert_employment_housenumber);
        console.log("alert_employment_address : " + alert_employment_address);

        console.log("alert_phone_reference : " + alert_phone_reference);
        console.log("alert_position : " + alert_position);
        console.log("alert_position : " + alert_position);
        console.log("alert_relationship : " + alert_relationship);
        console.log("alert_relationship : " + alert_relationship);
        console.log("alert_mother_career : " + alert_mother_career);
        console.log("alert_mother_name : " + alert_mother_name);
        console.log("alert_father_career : " + alert_father_career);
        console.log("alert_father_name : " + alert_father_name);
    }

    function check_value() {
        console.log("alert_fname_thai : " + alert_fname_thai);
        console.log("alert_lname_thai : " + alert_lname_thai);
        console.log("alert_fname_eng : " + alert_fname_eng);
        console.log("alert_lname_eng : " + alert_lname_eng);
        console.log("alert_email : " + alert_email);
        console.log("alert_phone : " + alert_phone);
        console.log("alert_national : " + alert_national);
        console.log("alert_ethnicity : " + alert_ethnicity);
        console.log("alert_religion : " + alert_religion);
        console.log("alert_high : " + alert_high);
        console.log("alert_weight : " + alert_weight);
        console.log("alert_born : " + alert_born);

        console.log("alert_marital_status : " + alert_marital_status);

        console.log("alert_prename : " + alert_prename);
        console.log("alert_sex : " + alert_sex);
        console.log("alert_edit_soldier : " + alert_edit_soldier);
        console.log("alert_living_status : " + alert_living_status);
        console.log("alert_type : " + alert_type);

        console.log("alert_ability_etc : " + alert_ability_etc);
        console.log("alert_identification : " + alert_identification);

        console.log("alert_employment_postal_permanent : " + alert_employment_postal_permanent);
        console.log("alert_employment_country_permanent : " + alert_employment_country_permanent);
        console.log("alert_employment_province_permanent : " + alert_employment_province_permanent);
        console.log("alert_employment_area_permanent : " + alert_employment_area_permanent);
        console.log("alert_employment_subarea_permanent : " + alert_employment_subarea_permanent);
        console.log("alert_employment_road_permanent : " + alert_employment_road_permanent);
        console.log("alert_employment_lane_permanent : " + alert_employment_lane_permanent);
        console.log("alert_employment_alley_permanent : " + alert_employment_alley_permanent);
        console.log("alert_employment_village_permanent : " + alert_employment_village_permanent);
        console.log("alert_employment_housenumber_permanent : " + alert_employment_housenumber_permanent);
        console.log("alert_address_permanent : " + alert_address_permanent);

        console.log("alert_employment_postal : " + alert_employment_postal);
        console.log("alert_employment_country : " + alert_employment_country);
        console.log("alert_employment_province : " + alert_employment_province);
        console.log("alert_employment_area : " + alert_employment_area);
        console.log("alert_employment_subarea : " + alert_employment_subarea);
        console.log("alert_employment_road : " + alert_employment_road);
        console.log("alert_employment_lane : " + alert_employment_lane);
        console.log("alert_employment_alley : " + alert_employment_alley);
        console.log("alert_employment_village : " + alert_employment_village);
        console.log("alert_employment_housenumber : " + alert_employment_housenumber);
        console.log("alert_employment_address : " + alert_employment_address);

        console.log("alert_phone_reference : " + alert_phone_reference);
        console.log("alert_position : " + alert_position);
        console.log("alert_position : " + alert_position);
        console.log("alert_relationship : " + alert_relationship);
        console.log("alert_relationship : " + alert_relationship);
        console.log("alert_mother_career : " + alert_mother_career);
        console.log("alert_mother_name : " + alert_mother_name);
        console.log("alert_father_career : " + alert_father_career);
        console.log("alert_father_name : " + alert_father_name);
    }

    $("#form_edit_person").submit(function () {

        var edit_personImage = $("#edit_personImage").val();
        var edit_personResume = $("#edit_personResume").val();

        // start all reference
        alert_father_name = false;
        alert_father_career = false;
        alert_mother_name = false;
        alert_mother_career = false;
        alert_reference_name = false;
        alert_relationship = false;
        alert_address_relationship = false;
        alert_position = false;
        alert_phone_reference = false;
        check_father_name();
        check_father_career();
        check_mother_name();
        check_mother_career();
        check_reference_name();
        check_relationship();
        check_address_relationship();
        check_position();
        check_phone_reference();
        // finish all reference

        // start all address
        alert_employment_address = false;
        alert_employment_housenumber = false;
        alert_employment_village = false;
        alert_employment_alley = false;
        alert_employment_lane = false;
        alert_employment_road = false;
        alert_employment_subarea = false;
        alert_employment_area = false;
        alert_employment_province = false;
        alert_employment_country = false;
        alert_employment_postal = false;

        check_employment_housenumber();
        check_employment_village();
        check_employment_lane();
        check_employment_road();
        // check_employment_subarea();
        // check_employment_area();
        // check_employment_province();
        check_employment_postal();

        alert_address_permanent = false;
        alert_employment_housenumber_permanent = false;
        alert_employment_village_permanent = false;
        alert_employment_alley_permanent = false;
        alert_employment_lane_permanent = false;
        alert_employment_road_permanent = false;
        alert_employment_subarea_permanent = false;
        alert_employment_area_permanent = false;
        alert_employment_province_permanent = false;
        alert_employment_country_permanent = false;
        alert_employment_postal_permanent = false;

        check_employment_housenumber_permanent();
        check_employment_village_permanent();
        check_employment_lane_permanent();
        check_employment_road_permanent();
        // check_employment_subarea_permanent();
        // check_employment_area_permanent();
        // check_employment_province_permanent();
        check_employment_postal_permanent();
        // finish all address

        // new alert not use
        alert_identification = false;
        check_identification();

        alert_ability_etc = false;
        check_ability_etc();

        alert_fname_thai = false;
        check_fname_thai();
        alert_lname_thai = false;
        check_lname_thai();
        alert_fname_eng = false;
        check_fname_eng();
        alert_lname_eng = false;
        check_lname_eng();
        alert_email = false;
        check_email();
        alert_phone = false;
        check_phone();
        alert_national = false;
        check_national();
        alert_ethnicity = false;
        check_ethnicity();
        alert_religion = false;
        check_religion();

        alert_high = false;
        check_high();
        alert_weight = false;
        check_weight();
        alert_born = false;
        check_born();

        // Check select box
        alert_prename = false;
        check_prename();
        alert_sex = false;
        check_edit_sex();
        alert_edit_soldier = false;
        check_edit_soldier();
        alert_living_status = false;
        check_living_status();
        alert_type = false;
        check_type();

        alert_marital_status = false;
        chk_marital_status();
        alert_married_status = false;
        check_married_status();

        if (alert_fname_thai != true && alert_lname_thai == false && alert_fname_eng == false && alert_lname_eng == false && alert_email == false && alert_phone == false && alert_national == false && alert_ethnicity == false && alert_religion == false && alert_high == false && alert_weight == false && alert_born == false && alert_identification == false && alert_ability_etc == false && alert_employment_postal == false && alert_employment_country == false && alert_employment_province == false && alert_employment_area == false && alert_employment_subarea == false && alert_employment_road == false && alert_employment_lane == false && alert_employment_alley == false && alert_employment_village == false && alert_employment_housenumber == false && alert_employment_address == false && alert_employment_postal_permanent == false && alert_employment_country_permanent == false && alert_employment_province_permanent == false && alert_employment_area_permanent == false && alert_employment_subarea_permanent == false && alert_employment_road_permanent == false && alert_employment_lane_permanent == false && alert_employment_alley_permanent == false && alert_employment_village_permanent == false && alert_employment_housenumber_permanent == false && alert_address_permanent == false && alert_phone_reference == false && alert_position == false && alert_address_relationship == false && alert_relationship == false && alert_reference_name == false && alert_mother_career == false && alert_mother_name == false && alert_father_career == false && alert_father_name == false && alert_living_status == false && alert_edit_soldier == false && alert_sex == false && alert_marital_status == false && alert_married_status == false) {
            return true;
        } else
            return false;

    });

</script>




