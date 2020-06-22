<?php

if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

include("inc/topnav.php");

if (isset($_GET['edit_id'])) {
    $sql_select_history="SELECT * FROM hr_person_history WHERE history_id='$_GET[history_id]' AND person_id='$_GET[edit_id]'";
    $query_history=mysqli_query($conn,$sql_select_history);
    $edit_history=mysqli_fetch_array($query_history);

    ?>

   

    <div id="page-wrapper-hr">
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <h3 class="page-header">Human Resources.</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-graduation-cap"></i> หัวข้อ เพิ่มข้อมูลการศึกษาและประวัติการทำงาน.
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <div style="padding: 10px 10px 10px 10px;">

                                        <form id="form_edit_history" class="form-horizontal" role="form" method="post"
                                              enctype="multipart/form-data"
                                              action="index.php?mod=hr/sm_subedit_update_history">
                                            <div class="table-responsive">
                                                <h4 class="page-header">ข้อมูลการทำงาน</h4>

                                                <input type="hidden" id="hidden_edit_id" name="hidden_edit_id"
                                                       value="<?= $_GET['edit_id'] ?>">

                                                <input type="hidden" id="hidden_history_id" name="hidden_history_id"
                                                       value="<?= $_GET['history_id'] ?>">

                                                <div class="col-sm-12">
                                                    <div class="form-group col-sm-8">
                                                        <label class="col-sm-2 control-label ">ชื่อบริษัทที่ทำงาน
                                                            : </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="history_company"
                                                                   name="history_company"
                                                                   placeholder="ชื่อบริษัทที่ทำงาน"
                                                                   onkeyup="return check_company_name();"
                                                                   maxlength="100"
                                                                   autofocus="autofocus" value="<?=$edit_history[2]?>">
                                                            <div id="alert_company_name" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">ตำแหน่ง :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                   id="history_position"
                                                                   name="history_position"
                                                                   placeholder="ตำแหน่ง"
                                                                   onkeyup="return check_history_position();"
                                                                   maxlength="100"
                                                                   autofocus="autofocus" value="<?=$edit_history[3]?>">
                                                            <div id="alert_history_position" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group col-sm-8">
                                                        <label class="col-sm-2 control-label ">เหตุผลที่ออก : </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="reason"
                                                                   name="reason"
                                                                   placeholder="เหตุผลที่ออก"
                                                                   onkeyup="return check_reason();" maxlength="100"
                                                                   autofocus="autofocus" value="<?=$edit_history[7]?>">
                                                            <div id="alert_reason" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">เงินเดือนครั้งสุดท้าย
                                                            : </label>
                                                        <div class="col-sm-8">
                                                            <?php
                                                                $old_salary=$edit_history[6];
                                                                $money=explode(".",$old_salary);
                                                            ?>
                                                            <input type="text" class="form-control" id="history_salary"
                                                                   name="history_salary"
                                                                   placeholder="15000"
                                                                   onkeyup="return check_history_salary();"
                                                                   maxlength="30" value="<?=$money[0]?>">
                                                            <div id="alert_history_salary" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">วันที่เข้าทำงาน
                                                            : </label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" id="history_start"
                                                                   name="history_start" required
                                                                   data-errormessage-value-missing="กรุณากรอกวันที่เข้าทำงาน" value="<?=$edit_history[4]?>">
                                                            <div id="alert_education_start" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">วันที่ออกจากงาน
                                                            : </label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" id="history_finish"
                                                                   name="history_finish" required
                                                                   data-errormessage-value-missing="กรุณากรอกวันที่ออกจากงาน" value="<?=$edit_history[5]?>">
                                                            <div id="alert_education_end" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-sm-12">
                                                    <hr>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group col-sm-14" style="float:right;">
                                                        <button class="btn btn-primary" type="submit" id="submit"
                                                                class="btn btn-default">
                                                            <i class="fa fa-sm fa-plus-square"></i> | บันทึกข้อมูล
                                                        </button>
                                                    </div>
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

    </div>
    <?php
}
?>

<script>

    $("#alert_company_name").hide();
    $("#alert_reason").hide();
    $("#alert_history_salary").hide();
    $("#alert_history_position").hide();

    var alert_company_name = false;
    var alert_reason = false;
    var alert_history_salary = false;
    var alert_history_position = false;

    function check_company_name() {

        var length = $("#history_company").val().length;
        var history_company = $("#history_company").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_0-9]+$/);

        if (!length) {
            alert_company_name = true;
            $("#alert_company_name").show().html("*กรุณากรอก ชื่อบริษัท");
            $("#history_company").focus();
        } else if (!pattern.test($("#history_company").val())) {
            alert_company_name = true;
            $("#alert_company_name").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#history_company").focus();
        } else if (length > 100) {
            alert_company_name = true;
            $("#alert_company_name").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            $("#history_company").focus();
        } else {
            alert_company_name = false;
            $("#alert_company_name").hide();
        }
    }

    function check_reason() {

        var length = $("#reason").val().length;
        var reason = $("#reason").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (!length) {
            alert_reason = true;
            $("#alert_reason").show().html("*กรุณากรอก เหตุผลที่ออก");
            $("#reason").focus();
        } else if (!pattern.test($("#reason").val())) {
            alert_reason = true;
            $("#alert_reason").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#reason").focus();
        } else if (length > 100) {
            alert_reason = true;
            $("#alert_reason").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            $("#reason").focus();
        } else {
            alert_reason = false;
            $("#alert_reason").hide();
        }
    }

    function check_history_position() {

        var length = $("#history_position").val().length;
        var history_position = $("#history_position").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (!length) {
            alert_history_position = true;
            $("#alert_history_position").show().html("*กรุณากรอก เหตุผลที่ออก");
            $("#history_position").focus();
        } else if (!pattern.test($("#history_position").val())) {
            alert_history_position = true;
            $("#alert_history_position").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#history_position").focus();
        } else if (length > 100) {
            alert_history_position = true;
            $("#alert_history_position").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            $("#history_position").focus();
        } else {
            alert_history_position = false;
            $("#alert_history_position").hide();
        }
    }

    function check_history_salary() {
        var pattern = new RegExp(/^[0-9., ]+$/);
        var history_salary = $("#history_salary").val();

        if (!history_salary) {
            $("#alert_history_salary").show().html("*กรุณากรอกเงินเดือน");
            alert_history_salary = true;
            $("#history_salary").focus();
        } else if (history_salary == "_") {
            $("#alert_history_salary").show().html("*กรุณากรอกเงินเดือน");
            alert_history_salary = true;
            $("#history_salary").focus();
        } else if (!pattern.test($("#history_salary").val())) {
            alert_history_salary = true;
            $("#alert_history_salary ").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#history_salary").focus();
        } else {
            $("#alert_history_salary").hide();
            alert_history_salary = false;
        }
    }

    function show_console() {
        console.log("alert_company_name : " + alert_company_name);
        console.log("alert_history_position : " + alert_history_position);
        console.log("alert_reason : " + alert_reason);
        console.log("alert_history_salary : " + alert_history_salary);
    }

    $("#form_edit_history").submit(function () {

        alert_company_name = false;
        alert_history_position = false;
        alert_reason = false;
        alert_history_salary = false;
        check_history_salary();
        check_history_position();
        check_reason();
        check_company_name();

        if (alert_company_name == false && alert_history_position == false && alert_reason == false && alert_history_salary == false) {
            return true;
        } else {
            return false;
        }
    });


</script>