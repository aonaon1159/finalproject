<?php
include("inc/check_page.php");
include("inc/topnav.php");

if (isset($_GET['add_id'])) {

    $sql_select_person = "SELECT person_id,person_prename,person_firstname_thai,person_lastname_thai FROM hr_person WHERE person_id='{$_GET["add_id"]}' ";
    $query_select_person = mysqli_query($conn, $sql_select_person);
    $person = mysqli_fetch_array($query_select_person);
    $prename = "";
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
                        <i class="fa fa-user-circle"></i> เพิ่มหัวข้อ ข้อมูลการจ้างงาน.
                    </div>
                    <div class="table-responsive">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12" style="padding-bottom:5px;">
                                    <button class="btn btn-info" type="button"
                                            id="btn_nextpage"
                                            class="btn btn-default"
                                            onclick="window.location='index.php?mod=hr/form_add_history&add_id=<?= $_GET['add_id'] ?>'">
                                        <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                                    </button>
                                </div>
                                <div class="col-sm-12">
                                    <form id="form_add_employment" class="form-horizontal" role="form" method="post"
                                          enctype="multipart/form-data"
                                          action="index.php?mod=hr/sm_insert_employment" style="padding-top:20px;">
                                          <div class="panel-heading">
                                                <a href="index.php?mod=hr/manage_add_position&id=<?= $person[0] ?>" class="btn btn-warning" style="float:right; padding-left:5px; margin-left:5px;">
                                                    <i class="fa fa-plus-circle "></i> | แก้ไขตำแหน่ง
                                                </a>
                                                <a href="index.php?mod=hr/manage_add_department&id=<?= $person[0] ?>" class="btn btn-warning" style="float:right; padding-left:5px; margin-left:5px;">
                                                    <i class="fa fa-plus-circle "></i> | แก้ไขแผนกงาน
                                                </a>
                                            </div>
                                        <h4 class="page-header">ข้อมูลการทำงาน</h4>

                                        <input type="hidden" id="hidden_add_id" name="hidden_add_id"
                                               value="<?= $_GET['add_id'] ?>">

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
                                            <?php
                                            $sql_position = mysqli_query($conn, "SELECT position_id ,position_name FROM hr_person_position ORDER BY position_name ASC");
                                            ?>

                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">ตำแหน่ง : </label>
                                                <div class="col-sm-8">
                                                    <select name="employment_position" class="form-control">
                                                                    <option value="0">-- กรุณาเลือกตำแหน่ง --</option>
                                                                    <?php
                                                                    while (list($position_id, $position_name) = mysqli_fetch_row($sql_position)) {
                                                                        ?>
                                                                        <option value="<?= $position_id ?>"><?= $position_name ?></option>
                                                                        <?php
                                                                    }
                                                                    mysqli_free_result($sql_position);
                                                                    ?>
                                                                </select>
                                                </div>
                                            </div>

                                                                                        <?php
                                            $sql_department = mysqli_query($conn, "SELECT department_id ,department_name FROM hr_person_department ORDER BY department_name ASC");
                                            ?>

                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">แผนก : </label>
                                                <div class="col-sm-8">
                                                    <select name="employment_department"
                                                                        class="form-control">
                                                                    <option value="0">-- กรุณาเลือกสาขา --</option>
                                                                    <?php
                                                                    while (list($department_id, $department_name) = mysqli_fetch_row($sql_department)) {
                                                                        ?>
                                                                        <option value="<?= $department_id ?>"><?= $department_name ?></option>
                                                                        <?php
                                                                    }
                                                                    mysqli_free_result($sql_department);
                                                                    ?>
                                                                </select>
                                                </div>
                                            </div>

                                            <?php
                                            $sql_department = mysqli_query($conn, "SELECT department_id ,department_name FROM hr_person_department ORDER BY department_name ASC");
                                            ?>

                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">วันเริ่มงาน : </label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control"
                                                           id="employment_start_date"
                                                           name="employment_start_date"
                                                           data-errormessage-value-missing="*กรุณากรอกวันที่เริ่มงาน"
                                                           required autofocus="autofocus">
                                                    <div id="alert_start_date"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-12">

                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">อัตราเงินเดือน : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                           id="employment_money"
                                                           name="employment_money"
                                                           onkeyup="return check_employment_salary();"
                                                           placeholder="อัตราเงินเดือนพนักงาน"
                                                           maxlength="13">
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
                                                           required autofocus="autofocus">
                                                    <div id="alert_start_date"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-sm-12">
                                            <br>
                                        </div>
                                        <h4 class="page-header">ข้อมูลสถานะพนักงาน</h4>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-6">
                                                <label class="col-sm-4 control-label ">สถานะพนักงาน : </label>
                                                <div class="col-sm-7">
                                                    <select id="employment_status" name="employment_status"
                                                            class="form-control"
                                                            onchange="chk_employment_status();">
                                                        <option value="0">กรุณาเลือกสถานะพนักงาน</option>
                                                        <option value="1">พนักงานบริษัท</option>
                                                        <option value="2">พนักงานทดลองงาน</option>
                                                    </select>
                                                    <div id="alert_employment_status"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="div_working_status">
                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-6">
                                                    <label class="col-sm-4 control-label ">สถานะการทำงาน
                                                        : </label>
                                                    <div class="col-sm-7">
                                                        <select id="working_status" name="working_status"
                                                                class="form-control"
                                                                onchange="check_working_status();">
                                                            <option value="0">กรุณาเลือกสถานะการทำงาน</option>
                                                            <option value="1">ทำงานปกติ</option>
                                                            <option value="2">ลาออก</option>
                                                        </select>
                                                        <div id="alert_working_status"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                <!-- <div class="form-group col-sm-6"></div> -->
                                            </div>
                                            <div class="col-sm-12">
                                                    <div class="form-group col-sm-7">
                                                        <div id="div_finish_date">
                                                            <label class="col-sm-4 control-label ">วันที่ลาออก
                                                                : </label>
                                                            <div class="col-sm-5">
                                                                <input type="date" class="form-control"
                                                                       id="employment_end_date"
                                                                       name="employment_end_date"
                                                                       data-errormessage-value-missing="*กรุณากรอกวันที่ลาออก (ค.ศ.)"
                                                                       onchange="check_finish_work();">
                                                                <div id="alert_employment_end_date"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <div class="form-group col-sm-5">
                                                    <div id="div_status_resign_bail">
                                                        <label class="col-sm-7 control-label ">สถานะการลาออกแบบไม่คืนเงินประกัน
                                                            : </label>
                                                        <label class="col-sm-3 control-label ">
                                                            <!-- <input type="checkbox" id="status_resign_bail" name="status_resign_bail" 
                                                       data-toggle="toggle"  data-off="ไม่คืนเงิน" data-offstyle="danger" data-on="คืนเงิน"
                                                       data-onstyle="success" data-width="100%"> -->
                                                            <input type="checkbox" id="status_resign_bail"
                                                                   name="status_resign_bail" value="1"
                                                                   style="float:left;">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="div_end_reason">
                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-7">
                                                    <label class="col-sm-4 control-label ">เหตุผลที่ลาออก
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control"
                                                               id="employment_end_reason"
                                                               name="employment_end_reason"
                                                               placeholder="กรอกเหตุผลที่ลาออก"
                                                               onchange="check_end_reason();">
                                                        <div id="alert_end_reason"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="div_break_status">
                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-6">
                                                    <label class="col-sm-4 control-label ">สถานะการพักงาน
                                                        : </label>
                                                    <div class="col-sm-7">
                                                        <select id="break_status" name="break_status"
                                                                class="form-control"
                                                                onchange="check_break_status();">
                                                            <option value="0">กรุณาเลือกสถานะการพักงาน</option>
                                                            <option value="1">ทำงานปกติ</option>
                                                            <option value="2">พักงาน</option>
                                                        </select>
                                                        <div id="alert_break_status"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-7">
                                                    <div id="div_start_break_date">
                                                        <label class="col-sm-4 control-label ">วันเริ่มการพักงาน
                                                            : </label>
                                                        <div class="col-sm-5">
                                                            <input type="date" class="form-control"
                                                                   id="employment_break_start"
                                                                   name="employment_break_start"
                                                                   data-errormessage-value-missing="*กรุณากรอกวันเริ่มการพักงาน (ค.ศ.)"
                                                                   onchange="check_start_break();">
                                                            <div id="alert_startdate_break"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-5">
                                                    <div id="div_finish_break_date">
                                                        <label class="col-sm-4 control-label ">วันสิ้นสุดการพักงาน
                                                            : </label>
                                                        <div class="col-sm-7">
                                                            <input type="date" class="form-control"
                                                                   id="employment_break_finish"
                                                                   name="employment_break_finish"
                                                                   data-errormessage-value-missing="*กรุณากรอกวันสิ้นสุดการพักงาน (ค.ศ.)"
                                                                   onchange="check_finish_break();">
                                                            <div id="alert_finishdate_break"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="div_break_reason">
                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-7">
                                                    <label class="col-sm-4 control-label ">เหตุผลที่พักงาน
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control"
                                                               id="employment_break_reason"
                                                               name="employment_break_reason"
                                                               placeholder="กรอกเหตุผลที่พักงาน"
                                                               onchange="check_break_reason();">
                                                        <div id="alert_break_reason"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <br>
                                        </div>

                                        <div id="div_social">
                                            <h4 class="page-header">ข้อมูลสถานะประกันสังคม</h4>
                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">วันเริ่มต้น
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control"
                                                               id="start_social_insurance_date"
                                                               name="start_social_insurance_date"
                                                               data-errormessage-value-missing="*กรุณากรอกวันเริ่มต้นประกันสังคม (ค.ศ.)"
                                                               onchange="check_start_social();">
                                                        <div id="alert_start_social"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <div id="div_finish_social">
                                                        <label class="col-sm-4 control-label ">วันสิ้นสุด
                                                            : </label>
                                                        <div class="col-sm-8">

                                                            <input type="date" class="form-control"
                                                                   id="out_social_insurance_date"
                                                                   name="out_social_insurance_date"
                                                                   data-errormessage-value-missing="*กรุณากรอกวันสิ้นสุดประกันสังคม (ค.ศ.)"
                                                                   onchange="check_out_social();">
                                                            <div id="alert_out_social"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="div_time_work">
                                            <div class="col-sm-12"><h4 class="page-header">เวลาทำงาน</h4></div>
                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">เวลาเข้างาน (ปกติ) : </label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control"
                                                               id="time_start" name="time_start" step="2"
                                                               data-errormessage-value-missing="*กรุณากรอกเวลาเข้าทำงาน"
                                                               onchange="check_start_date();">
                                                        <div id="alert_time_start"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">เวลาออกงาน (ปกติ) : </label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control"
                                                               id="time_end" name="time_end" step="2"
                                                               data-errormessage-value-missing="*กรุณากรอกเวลาออกทำงาน"
                                                               onchange="check_end_date();">
                                                        <div id="alert_time_end"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="div_person_holiday">
                                            <div class="col-sm-12">
                                                <h4 class="page-header">ข้อมูลวันหยุดพนักงาน</h4>
                                                <div class="form-group col-sm-8">
                                                    <label class="col-sm-2 control-label ">วันหยุดของพนักงาน
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <br>
                                                        <div id="div_holiday">
                                                        <input type="checkbox" id="holiday1" name="holiday[]"
                                                               onclick="check_checkbox();" value="1"> วันจันทร์ <br>
                                                        <input type="checkbox" id="holiday2" name="holiday[]"
                                                               onclick="check_checkbox();" value="2"> วันอังคาร <br>
                                                        <input type="checkbox" id="holiday3" name="holiday[]"
                                                               onclick="check_checkbox();" value="3"> วันพุธ <br>
                                                        <input type="checkbox" id="holiday4" name="holiday[]"
                                                               onclick="check_checkbox();" value="4"> วันพฤหัสบดี <br>
                                                        <input type="checkbox" id="holiday5" name="holiday[]"
                                                               onclick="check_checkbox();" value="5"> วันศุกร์ <br>
                                                        <input type="checkbox" id="holiday6" name="holiday[]"
                                                               onclick="check_checkbox();" value="6"> วันเสาร์ <br>
                                                        <input type="checkbox" id="holiday7" name="holiday[]"
                                                               onclick="check_checkbox();" value="7"> วันอาทิตย์ <br>
                                                        </div>
                                                        <div id="div_no_holiday">       
                                                            <input type="checkbox" id="holiday8" name="holiday[]"
                                                                 onclick="check_checkbox();" value="8"> ไม่มีวันหยุด <br>
                                                        </div>
                                                        <div id="alert_holiday"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                             <div id="div_no_holiday_caution" style="color:red;">
                                                            <br>
                                                            **หากไม่มีวันหยุด กรุณา uncheck เครื่องหมายถูกในช่องวันอื่นๆก่อน**
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-sm-12">
                                            <hr>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-6">
                                                <button id="chk_con" type="button" class="btn btn-default"
                                                        onclick="check_con();">Check console
                                                </button>
                                            </div>
                                            <div style="float:right;">
                                                <button class="btn btn-primary" type="submit"
                                                        id="submit"
                                                        class="btn btn-default" style="text-align:right;">
                                                    <i class="fa fa-sm fa-plus-square"></i> |
                                                    บันทึกข้อมูล
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

    <?php
}
?>
<script>

    $("#div_finish_date").hide();
    $("#div_start_break_date").hide();
    $("#div_finish_break_date").hide();
    $("#div_working_status").hide();
    $("#div_finish_social").hide();
    $("#div_social").hide();
    $("#div_break_status").hide();
    $("#div_end_reason").hide();
    $("#div_break_reason").hide();
    $("#div_person_holiday").hide();
    $("#div_time_work").hide();
    $("#div_status_resign_bail").hide();

    $("#alert_break_status").hide();
    var alert_break_status = false;
    $("#alert_working_status").hide();
    var alert_working_status = false;
    $("#alert_employment_status").hide();
    var alert_employment_status = false;
    $("#alert_employment_position").hide();
    $("#alert_employment_money").hide();
    var alert_employment_position = false;
    var alert_employment_money = false;
    $("#alert_employment_department").hide();
    var alert_employment_department = false;
    $("#alert_employment_branch").hide();
    var alert_employment_branch = false;

    $("#alert_employment_end_date").hide();
    var alert_employment_end_date = false;
    $("#alert_start_social").hide();
    var alert_start_social = false;
    $("#alert_out_social").hide();
    var alert_out_social = false;
    $("#alert_startdate_break").hide();
    var alert_startdate_break = false;
    $("#alert_finishdate_break").hide();
    var alert_finishdate_break = false;

    $("#alert_end_reason").hide();
    var alert_end_reason = false;
    $("#alert_break_reason").hide();
    var alert_break_reason = false;

    $("#alert_employment_company").hide();
    var alert_employment_company = false;

    $("#alert_holiday").hide();
    var alert_holiday = false;

    var alert_time_start = false;
    $("#alert_time_start").hide();
    var alert_time_end = false;
    $("#alert_time_end").hide();

    // Process check working status
    function check_working_status() {
        var working_status = $("#working_status").val();
        var employment_status = $("#employment_status").val();

        if (employment_status == 1) {
            if (working_status == 0) {
                $("#div_finish_date").hide();
                $("#div_finish_social").hide();
                $("#div_end_reason").hide();
                $("#alert_working_status").show().html("*กรุณาเลือก สถานะการทำงาน");
                $("#working_status").focus();
                $("#out_social_insurance_date").val("yyyy-MM-dd");
                $("#employment_end_date").val("yyyy-MM-dd");
                document.getElementById("employment_end_reason").value = "";
                alert_working_status = true;
                $("#div_status_resign_bail").hide();
                document.getElementById("status_resign_bail").checked = false;
            } else if (working_status == 2) {
                $("#div_finish_date").show();
                $("#div_finish_social").show();
                $("#div_end_reason").show();
                $("#alert_working_status").hide();
                alert_working_status = false;
                $("#div_status_resign_bail").show();
            } else if (working_status == 1) {
                $("#div_finish_date").hide();
                $("#div_finish_social").hide();
                $("#div_end_reason").hide();
                $("#alert_working_status").hide();
                $("#out_social_insurance_date").val("yyyy-MM-dd");
                $("#employment_end_date").val("yyyy-MM-dd");
                document.getElementById("employment_end_reason").value = "";
                alert_working_status = false;
                $("#div_status_resign_bail").hide();
                document.getElementById("status_resign_bail").checked = false;
            }
        } else if (employment_status == 2) {
            alert_working_status = false;
        }

    }

    // Process check break of employment status
    function check_break_status() {
        var break_status = $("#break_status").val();
        var employment_status = $("#employment_status").val();

        if (employment_status == 1) {
            if (break_status == 0) {
                $("#break_status").focus();
                $("#div_start_break_date").hide();
                $("#div_finish_break_date").hide();
                $("#div_break_reason").hide();
                $("#alert_break_status").show().html("*กรุณาเลือก สถานะการพักงาน");
                $("#employment_break_start").val("yyyy-MM-dd");
                $("#employment_break_finish").val("yyyy-MM-dd");
                document.getElementById("employment_break_reason").value = "";
                alert_break_status = true;
            } else if (break_status == 2) {
                $("#div_start_break_date").show();
                $("#div_finish_break_date").show();
                $("#div_break_reason").show();
                $("#alert_break_status").hide();
                alert_break_status = false;
            } else {
                $("#div_start_break_date").hide();
                $("#div_finish_break_date").hide();
                $("#div_break_reason").hide();
                $("#alert_break_status").hide();
                $("#employment_break_start").val("yyyy-MM-dd");
                $("#employment_break_finish").val("yyyy-MM-dd");
                document.getElementById("employment_break_reason").value = "";
                alert_break_status = false;
            }
        } else if (employment_status == 2) {
            alert_break_status = false;
        }


    }

    // Process check employment status employee or candidate
    function chk_employment_status() {
        var status = $("#employment_status").val();
        if (!status) {
            $("#alert_employment_status").show().html("กรุณาเลือกสถานะพนักงาน");
            $("#employment_status").focus();
            alert_employment_status = true;
        }

        if (status == 0) {
            $("#alert_employment_status").show().html("กรุณาเลือกสถานะพนักงาน");
            $("#employment_status").focus();

            alert_employment_status = true;

            document.getElementById("working_status").selectedIndex = 0;
            document.getElementById("break_status").selectedIndex = 0;

            $("#employment_end_date").val("yyyy-MM-dd");
            $("#employment_break_start").val("yyyy-MM-dd");
            $("#employment_break_finish").val("yyyy-MM-dd");

            $("#start_social_insurance_date").val("yyyy-MM-dd");
            $("#out_social_insurance_date").val("yyyy-MM-dd");
            $("#div_social").hide();
            $("#div_working_status").hide();
            $("#div_break_status").hide();

            document.getElementById("employment_end_reason").value = "";
            document.getElementById("employment_break_reason").value = "";
            $("#div_end_reason").hide();
            $("#div_break_reason").hide();
            $("#div_person_holiday").hide();
            $("#div_time_work").hide();
            document.getElementById("holiday1").checked = false;
            document.getElementById("holiday2").checked = false;
            document.getElementById("holiday3").checked = false;
            document.getElementById("holiday4").checked = false;
            document.getElementById("holiday5").checked = false;
            document.getElementById("holiday6").checked = false;
            document.getElementById("holiday7").checked = false;
            document.getElementById("holiday8").checked = false;
            $("#div_status_resign_bail").hide();
            document.getElementById("status_resign_bail").checked = false;
        } else if (status == 1) {
            $("#div_social").show();
            $("#div_working_status").show();
            $("#div_break_status").show();
            $("#alert_employment_status").hide();
            alert_employment_status = false;
            $("#div_person_holiday").show();
            $("#div_time_work").show();
            $("#div_status_resign_bail").hide();
        } else { 
            document.getElementById("working_status").selectedIndex = 0;
            document.getElementById("break_status").selectedIndex = 0;
            $("#employment_end_date").val("yyyy-MM-dd");
            $("#employment_break_start").val("yyyy-MM-dd");
            $("#employment_break_finish").val("yyyy-MM-dd");
            $("#start_social_insurance_date").val("yyyy-MM-dd");
            $("#out_social_insurance_date").val("yyyy-MM-dd");
            $("#div_social").hide();
            $("#div_working_status").hide();
            $("#div_break_status").hide();
            document.getElementById("employment_end_reason").value = "";
            document.getElementById("employment_break_reason").value = "";

            $("#div_end_reason").hide();
            $("#div_break_reason").hide();
            $("#alert_employment_status").hide();
            alert_employment_status = false;

            $("#div_person_holiday").show();
            $("#div_time_work").show();
            // document.getElementById("holiday1").checked = false;
            // document.getElementById("holiday2").checked = false;
            // document.getElementById("holiday3").checked = false;
            // document.getElementById("holiday4").checked = false;
            // document.getElementById("holiday5").checked = false;
            // document.getElementById("holiday6").checked = false;
            // document.getElementById("holiday7").checked = false;
            // document.getElementById("holiday8").checked = false;
            // alert_holiday = false;
            $("#div_status_resign_bail").hide();
            document.getElementById("status_resign_bail").checked = false;
        }
    }

    // Process check checkbox (holiday)
    function check_checkbox() {
        var count = 0; 
        var checked = 0;


        if ($("#holiday1").prop("checked")) count += 1;
        else if ($("#holiday2").prop("checked")) count += 1;
        else if ($("#holiday3").prop("checked")) count += 1;
        else if ($("#holiday4").prop("checked")) count += 1;
        else if ($("#holiday5").prop("checked")) count += 1;
        else if ($("#holiday6").prop("checked")) count += 1;
        else if ($("#holiday7").prop("checked")) count += 1;
        else if ($("#holiday8").prop("checked")) checked += 1;

        if (count == 0) {
            alert_holiday = true;
            $("#alert_holiday").show().html("*กรุณาเลือกวันหยุด ! ");
            $("#holiday1").focus();
            $("#div_no_holiday").show();
            $("#div_no_holiday_caution").show();   
        }else if (count >= 1 && count <= 7){
            alert_holiday = false;
            $("#alert_holiday").hide();
            $("#div_no_holiday").hide();
            $("#div_no_holiday_caution").show();          
        }else {
            alert_holiday = false;
            $("#alert_holiday").hide(); 
        }

        if (checked == 1){
            alert_holiday = false;
            $("#alert_holiday").hide();
            $("#div_holiday").hide();
            $("#div_no_holiday_caution").hide();
        }else{
            $("#holiday1").focus();
            $("#div_holiday").show();

        }
    }

    function check_employment_position() {
        var length = $("#employment_position").val().length;
        var employment_position = $("#employment_position").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        if (!length) {
            alert_employment_position = true;
            $("#alert_employment_position").show().html("*กรุณากรอก ตำแหน่ง");
            $("#employment_position").focus();
        } else if (length > 50) {
            alert_employment_position = true;
            $("#alert_employment_position").show().html("*กรุณากรอกไม่เกิน 50 ตัวอักษร");
            $("#employment_position").focus();
        } else if (length < 2) {
            alert_employment_position = true;
            $("#alert_employment_position").show().html("*กรุณากรอกข้อมูลอย่างน้อย 2 ตัวอักษร");
            $("#employment_position").focus();
        } else if (!pattern.test($("#employment_position").val())) {
            alert_employment_position = true;
            $("#alert_employment_position").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ เท่านั้น");
            $("#employment_position").focus();
        } else {
            $("#alert_employment_position").hide();
            alert_employment_position = false;
        }
    }

    function check_employment_department() {
        var length = $("#employment_department").val().length;
        var department = $("#employment_department").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        if (!department) {
            $("#alert_employment_department").show().html("*กรุณากรอก แผนก");
            $("#employment_department").focus();
            alert_employment_department = true;
        } else if (!pattern.test($("#employment_department").val())) {
            $("#alert_employment_department").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ เท่านั้น");
            $("#employment_department").focus();
            alert_employment_department = true;
        } else if (length < 2) {
            $("#alert_employment_department").show().html("*กรุณากรอกข้อมูลอย่างน้อย 2 ตัวอักษร");
            $("#employment_department").focus();
            alert_employment_department = true;
        } else {
            $("#alert_employment_department").hide();
            alert_employment_department = false;
        }
    }

    function check_employment_branch() {
        var length = $("#employment_branch").val().length;
        var branch = $("#employment_branch").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
        if (!branch) {
            $("#alert_employment_branch").show().html("*กรุณากรอก แผนก");
            $("#employment_branch").focus();
            alert_employment_branch = true;
        } else if (!pattern.test($("#employment_branch").val())) {
            $("#alert_employment_branch").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ เท่านั้น");
            $("#employment_branch").focus();
            alert_employment_branch = true;
        } else if (length < 5) {
            $("#alert_employment_branch").show().html("*กรุณากรอกข้อมูลอย่างน้อย 5 ตัวอักษร");
            $("#employment_branch").focus();
            alert_employment_branch = true;
        } else {
            $("#alert_employment_branch").hide();
            alert_employment_branch = false;
        }
    }

    function check_employment_salary() {
        var employment_money = $("#employment_money").val();
        var length = $("#employment_money").val().length;
        var pattern = new RegExp(/^[0-9 ]+$/);

        if (!length) {
            $("#alert_employment_money").show().html("*กรุณากรอกเงินเดือน");
            alert_employment_money = true;
            $("#employment_money").focus();
        } else if (!pattern.test($("#employment_money").val())) {
            alert_employment_money = true;
            $("#alert_employment_money").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#employment_money").focus();
        } else {
            $("#alert_employment_money").hide();
            alert_employment_money = false;
        }
    }

    function check_start_social() {
        var date_start_social = $("#start_social_insurance_date").val();
        var employment_status = $("#employment_status").val();

        if (employment_status == 1) {
            if (!date_start_social) {
                $("#start_social_insurance_date").focus();
                $("#alert_start_social").show().html("*กรุณากรอกวันที่เริ่มเข้าประกันสังคม");
                alert_start_social = true;
            } else {
                $("#alert_start_social").hide();
                alert_start_social = false;
            }
        }
    }

    function check_out_social() {
        var date_out_social = $("#out_social_insurance_date").val();
        var working_status = $("#working_status").val();

        if (working_status == 2) {
            if (!date_out_social) {
                $("#out_social_insurance_date").focus();
                $("#alert_out_social").show().html("*กรุณากรอกวันที่ออกจากประกันสังคม");
                alert_out_social = true;
            } else {
                $("#alert_out_social").hide();
                alert_out_social = false;
            }
        }
    }

    function check_start_break() {
        var employment_break_start = $("#employment_break_start").val();
        var break_status = $("#break_status").val();

        if (break_status == 2) {
            if (!employment_break_start) {
                $("#employment_break_start").focus();
                $("#alert_startdate_break").show().html("*กรุณากรอกวันที่เริ่มการพักงาน");
                alert_startdate_break = true;
            } else {
                $("#alert_startdate_break").hide();
                alert_startdate_break = false;
            }
        }
    }

    function check_finish_break() {
        var employment_break_finish = $("#employment_break_finish").val();
        var break_status = $("#break_status").val();

        if (break_status == 2) {
            if (!employment_break_finish) {
                $("#employment_break_finish").focus();
                $("#alert_finishdate_break").show().html("*กรุณากรอกวันที่สิ้นสุดการพักงาน");
                alert_finishdate_break = true;
            } else {
                $("#alert_finishdate_break").hide();
                alert_finishdate_break = false;
            }
        }
    }

    function check_finish_work() {
        var employment_end_date = $("#employment_end_date").val();
        var working_status = $("#working_status").val();

        if (working_status == 2) {
            if (!employment_end_date) {
                $("#employment_end_date").focus();
                $("#alert_employment_end_date").show().html("*กรุณากรอกวันที่ลาออก (ค.ศ.)");
                alert_employment_end_date = true;
            } else {
                $("#alert_employment_end_date").hide();
                alert_employment_end_date = false;
            }
        }
    }

    function check_end_reason() {
        var length = $("#employment_end_reason").val().length;
        var employment_end_reason = $("#employment_end_reason").val();
        var working_status = $("#working_status").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (working_status == 2) {
            if (!length) {
                alert_end_reason = true;
                $("#alert_end_reason").show().html("*กรุณากรอก เหตุผลที่ออก");
                $("#employment_end_reason").focus();
            } else if (!pattern.test($("#employment_end_reason").val())) {
                alert_end_reason = true;
                $("#alert_end_reason").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
                $("#employment_end_reason").focus();
            } else if (length > 100) {
                alert_end_reason = true;
                $("#alert_end_reason").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
                $("#employment_end_reason").focus();
            } else {
                alert_end_reason = false;
                $("#alert_end_reason").hide();
            }
        }
    }

    function check_break_reason() {
        var length = $("#employment_break_reason").val().length;
        var employment_break_reason = $("#employment_break_reason").val();
        var break_status = $("#break_status").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (break_status == 2) {
            if (!length) {
                alert_break_reason = true;
                $("#alert_break_reason").show().html("*กรุณากรอก เหตุผลที่ออก");
                $("#employment_break_reason").focus();
            } else if (!pattern.test($("#employment_break_reason").val())) {
                alert_break_reason = true;
                $("#alert_break_reason").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
                $("#employment_break_reason").focus();
            } else if (length > 100) {
                alert_break_reason = true;
                $("#alert_break_reason").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
                $("#employment_end_reason").focus();
            } else {
                alert_break_reason = false;
                $("#alert_break_reason").hide();
            }
        }
    }

    // function check_employment_company() {
    //     var length = $("#employment_company").val().length;
    //     var company = $("#employment_company").val();
    //     var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);
    //     if (!company) {
    //         $("#alert_employment_company").show().html("*กรุณากรอก บริษัท");
    //         $("#employment_company").focus();
    //         alert_employment_company = true;
    //     } else if (!pattern.test($("#employment_company").val())) {
    //         $("#alert_employment_company").show().html("*กรุณากรอกด้วยตัวอักษร A-Z,a-z,ก-ฮ เท่านั้น");
    //         $("#employment_company").focus();
    //         alert_employment_company = true;
    //     } else if (length < 3) {
    //         $("#alert_employment_company").show().html("*กรุณากรอกข้อมูลอย่างน้อย 3 ตัวอักษร");
    //         $("#employment_company").focus();
    //         alert_employment_company = true;
    //     } else {
    //         $("#alert_employment_company").hide();
    //         alert_employment_company = false;
    //     }
    // }

    function check_start_date() {
        var employment_status = $("#employment_status").val();
        var time_start = $("#time_start").val();

        if (employment_status != 0) {
            if (!time_start) {
                $("#alert_time_start").show().html("*กรุณากรอกเวลาเข้างาน ปกติ");
                alert_time_start = true;
                $("#time_start").focus();
            } else {
                $("#alert_time_start").hide();
                alert_time_start = false;
            }
        }
    }

    function check_end_date() {
        var employment_status = $("#employment_status").val();
        var time_end = $("#time_end").val();

        if (employment_status != 0) {
            if (!time_end) {
                $("#alert_time_end").show().html("*กรุณากรอกเวลาออกงาน ปกติ");
                alert_time_end = true;
                $("#time_end").focus();
            } else {
                $("#alert_time_end").hide();
                alert_time_end = false;
            }
        }
    }

    $("#chk_con").hide();
    function check_con() {
        console.log("___________________________________________________");
        console.log("alert_employment_company : " + alert_employment_company);
        console.log("alert_employment_position : " + alert_employment_position);
        console.log("alert_employment_money : " + alert_employment_money);
        console.log("alert_employment_department : " + alert_employment_department);
        console.log("alert_employment_branch : " + alert_employment_branch);

        console.log("alert_employment_status : " + alert_employment_status);
        console.log("alert_break_status : " + alert_break_status);
        console.log("alert_working_status : " + alert_working_status);

        console.log("alert_end_reason : " + alert_end_reason);
        console.log("alert_break_reason : " + alert_break_reason);

        console.log("alert_employment_end_date : " + alert_employment_end_date);
        console.log("alert_start_social : " + alert_start_social);
        console.log("alert_out_social : " + alert_out_social);
        console.log("alert_startdate_break : " + alert_startdate_break);
        console.log("alert_finishdate_break : " + alert_finishdate_break);
        console.log("alert_end_reason : " + alert_end_reason);
        console.log("alert_break_reason : " + alert_break_reason);
        console.log("alert_holiday : " + alert_holiday);
        var status_resign_bail = document.getElementById("status_resign_bail").checked;
        console.log("status_resign_bail is : " + status_resign_bail);

        var time_start = $("#time_start").val();
        var time_end = $("#time_end").val();
        console.log("time_start is : " + time_start);
        console.log("time_end is : " + time_end);

        var employment_status = $("#employment_status").val();
        var working_status = $("#working_status").val();
        console.log("employment_status is : " + employment_status);
        console.log("working_status is : " + working_status);
        console.log("alert_holiday : "+alert_holiday);
        console.log("alert_time_start : "+alert_time_start);
        console.log("alert_time_end : "+alert_time_end);
    }

    $("#form_add_employment").submit(function () {
        alert_employment_company = false;
        alert_employment_position = false;
        alert_employment_money = false;
        alert_employment_department = false;
        alert_employment_branch = false;

        alert_employment_status = false;
        alert_break_status = false;
        alert_working_status = false;

        alert_employment_end_date = false;
        alert_start_social = false;
        alert_out_social = false;
        alert_startdate_break = false;
        alert_finishdate_break = false;
        alert_end_reason = false;
        alert_break_reason = false;
        alert_holiday = false;
        alert_time_start = false;
        alert_time_end = false;

        check_break_status();

        check_working_status();
        chk_employment_status();
        check_employment_salary();
        // check_employment_branch();
        // check_employment_department();
        // check_employment_position();

        check_finish_work();
        check_start_break();
        check_finish_break();
        check_out_social();
        check_start_social();
        check_end_reason();
        check_break_reason();

        // check_employment_company();
        chk_employment_status();
        check_end_date();
        check_start_date();
        check_checkbox();

        if (alert_employment_position == false && alert_employment_money == false && alert_employment_department == false && alert_employment_branch == false && alert_employment_status == false && alert_break_status == false && alert_working_status == false && alert_employment_end_date == false && alert_start_social == false && alert_out_social == false && alert_startdate_break == false && alert_finishdate_break == false && alert_holiday == false && alert_time_start==false && alert_time_end==false){
            // console.log("go");
            return true;
        }else return false;

    });

</script>
