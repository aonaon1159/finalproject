<?php
if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

include("inc/topnav.php");

if (!isset($_GET['id'])) {
    exit("<script>window.location = './';</script>");
}

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
                    <i class="fa fa-user-circle"></i> ข้อมูลเงินเดือน
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

                                    <h4 class="page-header">ประวัติบุคลากร</h4>

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
                                        <div class="form-group col-sm-4"></div>
                                    </div>
                                    <div class="col-sm-12"><br></div>
                                    <div class="col-sm-12"><br></div>

                                    <?php
                                    if ($employment[7] == 1) {
                                        ?>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">สถานะพนักงาน
                                                    : </label>
                                                <div class="col-sm-4">
                                                    <input type="checkbox" id="drive_motorcycle"
                                                           name="drive_motorcycle"
                                                           data-toggle="toggle" data-onstyle="success"
                                                           data-on="พนักงาน" data-offstyle="default"
                                                           data-off="ผู้สมัคร" <?php if ($employment[7] == 1) echo "checked"; ?>
                                                           data-width="100%">
                                                    <div id="alert_drive_motorcycle" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">สถานะการทำงาน
                                                    : </label>
                                                <div class="col-sm-4">
                                                    <input type="checkbox" id="drive_motorcycle"
                                                           name="drive_motorcycle"
                                                           data-toggle="toggle" data-onstyle="primary"
                                                           data-on="ทำงานปกติ" data-offstyle="danger"
                                                           data-off="ลาออกแล้ว" <?php if ($employment[8] == 1) echo "checked"; ?>
                                                           data-width="100%">
                                                    <div id="alert_drive_motorcycle" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <?php
                                            if ($employment[8] != 2) {
                                                ?>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">สถานะการพักงาน
                                                        : </label>
                                                    <div class="col-sm-4">
                                                        <input type="checkbox" id="drive_motorcycle"
                                                               name="drive_motorcycle"
                                                               data-toggle="toggle" data-onstyle="danger"
                                                               data-on="พักงาน" data-offstyle="primary"
                                                               data-off="ทำงานปกติ" <?php if ($employment[10] == 2) echo "checked"; ?>
                                                               data-width="100%">
                                                        <div id="alert_drive_motorcycle" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="col-sm-12"><br></div>
                                        </div>


                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label">คำนำหน้าชื่อ : </label>
                                                <div class="col-sm-8">
                                                    <select id="edit_prename" name="edit_prename"
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
                                                    </select>
                                                    <div id="alert_prename" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">ชื่อ (ไทย) : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="fname_thai"
                                                           name="fname_thai"
                                                           placeholder="ชื่อจริง"
                                                           onkeyup="return check_fname_thai();" maxlength="55"
                                                           autofocus="autofocus" value="<?= $person[2] ?>" disabled>
                                                    <div id="alert_fname_thai" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">นามสกุล (ไทย) : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="lname_thai"
                                                           name="lname_thai"
                                                           placeholder="นามสกุล"
                                                           onkeyup="return check_lname_thai();" maxlength="55"
                                                           value="<?= $person[3] ?>" disabled>
                                                    <div id="alert_lname_thai" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">บริษัท : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                           id="employment_company"
                                                           name="employment_company"
                                                           onkeyup="return check_employment_company();"
                                                           placeholder="บริษัท"
                                                           maxlength="50" autofocus="autofocus"
                                                           value="<?= $employment[2] ?>" disabled>
                                                    <div id="alert_employment_position"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">สาขา : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                           id="employment_branch"
                                                           name="employment_branch"
                                                           onkeyup="return check_employment_branch();"
                                                           placeholder="สังกัดสาขา"
                                                           maxlength="50" value="<?= $employment[3] ?>"
                                                           disabled>
                                                    <div id="alert_employment_branch"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">แผนก : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                           id="employment_department"
                                                           name="employment_department"
                                                           onkeyup="return check_employment_department();"
                                                           placeholder="แผนกงาน"
                                                           maxlength="50" value="<?= $employment[4] ?>"
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
                                                    <input type="text" class="form-control"
                                                           id="employment_position"
                                                           name="employment_position"
                                                           onkeyup="return check_employment_position();"
                                                           placeholder="ตำแหน่งงาน"
                                                           maxlength="50" autofocus="autofocus"
                                                           value="<?= $employment[5] ?>" disabled>
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
                                                    <input type="date" class="form-control"
                                                           id="employment_start_date"
                                                           name="employment_start_date"
                                                           data-errormessage-value-missing="*กรุณากรอกวันที่เริ่มงาน"
                                                           required autofocus="autofocus"
                                                           value="<?= $employment[14] ?>" disabled>
                                                    <div id="alert_start_date" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <br>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">สถานะพนักงาน
                                                    : </label>
                                                <div class="col-sm-8">
                                                    <select id="employment_status" name="employment_status"
                                                            class="form-control"
                                                            onchange="chk_employment_status();" disabled>
                                                        <option value="0" <?php if ($employment[7] == 0) echo "selected"; ?>>
                                                            กรุณาเลือกสถานะ พนักงาน
                                                        </option>
                                                        <option value="1" <?php if ($employment[7] == 1) echo "selected"; ?>>
                                                            พนักงานบริษัท
                                                        </option>
                                                        <option value="2" <?php if ($employment[7] == 2) echo "selected"; ?>>
                                                            ผู้สมัคร
                                                        </option>
                                                    </select>
                                                    <div id="alert_employment_status" style="color: red; font-weight: bold; margin-top: 5px;"></div>
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
                                                               value="<?php if ($employment[16] > 0) echo "$employment[16] ปี"; else echo "น้อยกว่า 1 ปี"; ?> "
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
                                                    <label class="col-sm-4 control-label ">สถานะการทำงาน
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <select id="working_status" name="working_status"
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
                                                        </select>
                                                        <div id="alert_working_status" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($employment[15] != NULL) {
                                                    ?>
                                                    <div class="form-group col-sm-4">
                                                        <div id="div_finish_date">
                                                            <label class="col-sm-4 control-label ">วันที่ลาออก
                                                                : </label>
                                                            <div class="col-sm-8">
                                                                <input type="date" class="form-control"
                                                                       id="employment_end_date"
                                                                       name="employment_end_date"
                                                                       data-errormessage-value-missing="*กรุณากรอกวันที่ลาออก (ค.ศ.)"
                                                                       onchange="check_finish_work();"
                                                                       value="<?= $employment[15] ?>" disabled>
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
                                                            <div id="alert_end_reason" style="color: red; font-weight: bold; margin-top: 5px;"></div>
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
                                                        <label class="col-sm-4 control-label ">สถานะการพักงาน
                                                            : </label>
                                                        <div class="col-sm-8">
                                                            <select id="break_status" name="break_status"
                                                                    class="form-control"
                                                                    onchange="check_break_status();" disabled>
                                                                <option value="0" <?php if ($employment[10] == 0) echo "selected"; ?>>
                                                                    กรุณาเลือกสถานะ การพักงาน
                                                                </option>
                                                                <option value="1" <?php if ($employment[10] == 1) echo "selected"; ?>>
                                                                    ทำงาน ปกติ
                                                                </option>
                                                                <option value="2" <?php if ($employment[10] == 2) echo "selected"; ?>>
                                                                    พักงาน
                                                                </option>
                                                            </select>
                                                            <div id="alert_break_status" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                                if ($employment[11] != NULL) {
                                                    ?>
                                                    <div class="form-group col-sm-4">
                                                        <div id="div_start_break_date">
                                                            <label class="col-sm-4 control-label ">วันเริ่มการพักงาน
                                                                : </label>
                                                            <div class="col-sm-8">
                                                                <input type="date" class="form-control"
                                                                       id="employment_break_start"
                                                                       name="employment_break_start"
                                                                       data-errormessage-value-missing="*กรุณากรอกวันเริ่มการพักงาน (ค.ศ.)"
                                                                       onchange="check_start_break();"
                                                                       value="<?= $employment[11] ?>" disabled>
                                                                <div id="alert_startdate_break"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
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
                                                        <div id="div_finish_break_date">
                                                            <label class="col-sm-4 control-label ">วันสิ้นสุดการพักงาน
                                                                : </label>
                                                            <div class="col-sm-8">
                                                                <input type="date" class="form-control"
                                                                       id="employment_break_finish"
                                                                       name="employment_break_finish"
                                                                       data-errormessage-value-missing="*กรุณากรอกวันสิ้นสุดการพักงาน (ค.ศ.)"
                                                                       onchange="check_finish_break();"
                                                                       value="<?= $employment[12] ?>" disabled>
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
                                        if ($employment[13] != "") {
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
                                                                   value="<?= $employment[13] ?>" disabled>
                                                            <div id="alert_break_reason"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div id="div_social">
                                            <div class="col-sm-12">
                                                <?php
                                                if ($employment[17] != NULL) {
                                                    ?>
                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">วันเริ่มต้น
                                                            : </label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control"
                                                                   id="start_social_insurance_date"
                                                                   name="start_social_insurance_date"
                                                                   data-errormessage-value-missing="*กรุณากรอกวันเริ่มต้นประกันสังคม (ค.ศ.)"
                                                                   onchange="check_start_social();"
                                                                   value="<?= $employment[17] ?>" disabled>
                                                            <div id="alert_start_social"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if ($employment[18] != NULL) {
                                                    ?>
                                                    <div class="form-group col-sm-4">
                                                        <div id="div_finish_social">
                                                            <label class="col-sm-4 control-label ">วันสิ้นสุด
                                                                : </label>
                                                            <div class="col-sm-6">

                                                                <input type="date" class="form-control"
                                                                       id="out_social_insurance_date"
                                                                       name="out_social_insurance_date"
                                                                       data-errormessage-value-missing="*กรุณากรอกวันสิ้นสุดประกันสังคม (ค.ศ.)"
                                                                       onchange="check_out_social();"
                                                                       value="<?= $employment[18] ?>" disabled>
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
                                    ?>
                                    <div class="col-sm-12"><br></div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h4>รายได้หลัก</h4>

                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="bg-primary">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">รายการ</th>
                                                        <th class="text-center">จำนวนเงิน</th>
                                                    </thead>

                                                    <tbody>
                                                    <tr>
                                                        <td>1
                                                        <td>xxxxxxxxx
                                                        <td>00,000 <a href="./?mod=hr/expenses"><i
                                                                        class="fa fa-arrow-circle-down pull-right"></i></a>
                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="col-lg-6">
                                                <h4>รายได้รอง</h4>

                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="bg-primary">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">รายการ</th>
                                                        <th class="text-center">จำนวนเงิน</th>
                                                    </thead>

                                                    <tbody>
                                                    <tr>
                                                        <td>1
                                                        <td>xxxxxxxxx <a href="./?mod=hr/expenses"><i
                                                                        class="fa fa-arrow-circle-down pull-right"></i></a>
                                                        <td>00,000
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h4>รายการหักหลัก</h4>

                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="bg-danger">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">รายการ</th>
                                                        <th class="text-center">จำนวนเงิน</th>
                                                        <th class="text-center">จำนวนครั้งที่ชำระ</th>
                                                    </thead>

                                                    <tbody>
                                                    <tr>
                                                        <td>1
                                                        <td>ประกันสังคม
                                                        <td>000
                                                        <td>12 <a href="./?mod=hr/expenses"><i
                                                                        class="fa fa-arrow-circle-down pull-right"></i></a>
                                                    </tbody>

                                                    <tbody>
                                                    <tr>
                                                        <td>2
                                                        <td>เงินค้ำประกัน
                                                        <td>000
                                                        <td>15 <a href="./?mod=hr/expenses"><i
                                                                        class="fa fa-arrow-circle-down pull-right"></i></a>
                                                    </tbody>

                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                        <td>รวมยอดหักรายการหลัก
                                                        <td>000
                                                        <td>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-lg-6">
                                                <h4>รายการหักรอง</h4>

                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="bg-danger">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">รายการ</th>
                                                        <th class="text-center">จำนวนวัน</th>
                                                        <th class="text-center">จำนวนเงิน</th>
                                                    </thead>

                                                    <tbody>
                                                    <tr>
                                                        <td>1
                                                        <td>ลากิจ / ขาดงาน
                                                        <td>0
                                                        <td>000
                                                    </tbody>

                                                    <tbody>
                                                    <tr>
                                                        <td>2
                                                        <td>ลาป่วยมีใบรับรองแพทย์ <a href="./?mod=hr/expenses"><i
                                                                        class="fa fa-arrow-circle-down pull-right"></i></a>
                                                        <td>2
                                                        <td>000
                                                    </tbody>

                                                    <tbody>
                                                    <tr>
                                                        <td>3
                                                        <td>ลาป่วยไม่มีใบรับรองแพทย์
                                                        <td>0
                                                        <td>000
                                                    </tbody>

                                                    <tbody>
                                                    <tr>
                                                        <td>4
                                                        <td>เงินกู้ <a href="./?mod=hr/expenses"><i
                                                                        class="fa fa-arrow-circle-down pull-right"></i></a>
                                                        <td>0
                                                        <td>000
                                                    </tbody>

                                                    <tbody>
                                                    <tr>
                                                        <td>5
                                                        <td>เบิกเงินล่วงหน้า
                                                        <td>0
                                                        <td>000
                                                    </tbody>

                                                    <tbody>
                                                    <tr>
                                                        <td>6
                                                        <td>ค่าเปอร์เซ็นต์หน้าตู้จ่ายแล้ว
                                                        <td>0
                                                        <td>000
                                                    </tbody>

                                                    <tbody>
                                                    <tr>
                                                        <td>7
                                                        <td>รายการหักอื่นๆ
                                                        <td>0
                                                        <td>000
                                                    </tbody>

                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                        <td>รวมยอดหักรายการรอง
                                                        <td>
                                                        <td>000
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h4>รายได้หลัก</h4>

                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="bg-success">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">รายการ</th>
                                                        <th class="text-center">จำนวนเงิน</th>
                                                    </thead>

                                                    <tbody>
                                                    <tr>
                                                        <td>1
                                                        <td>xxxxxxxxx
                                                        <td>00,000 <a href="./?mod=hr/expenses"><i
                                                                        class="fa fa-arrow-circle-down pull-right"></i></a>
                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="col-lg-6">
                                                <h4>รายได้รอง</h4>

                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="bg-success">
                                                        <th class="text-center">ลำดับ</th>
                                                        <th class="text-center">รายการ</th>
                                                        <th class="text-center">จำนวนเงิน</th>
                                                    </thead>

                                                    <tbody>
                                                    <tr>
                                                        <td>1
                                                        <td>xxxxxxxxx <a href="./?mod=hr/expenses"><i
                                                                        class="fa fa-arrow-circle-down pull-right"></i></a>
                                                        <td>00,000
                                                    </tbody>
                                                </table>

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
                                        <div style="float:right;">
                                            <button type="button" class="btn btn-default"
                                                    onclick="window.location='index.php?mod=hr/manage_person'">
                                                ปิด
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



