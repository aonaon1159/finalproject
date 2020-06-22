<?php

if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

include("inc/topnav.php");

if (isset($_GET['edit_id'])) {

    $sql_select_degree="SELECT * FROM hr_person_education WHERE education_id='$_GET[education_id]'";
    $query_degree=mysqli_query($conn,$sql_select_degree);
    $edit_degree=mysqli_fetch_row($query_degree);

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
                        <i class="fa fa-graduation-cap"></i> หัวข้อ แก้ไขข้อมูลการศึกษา.
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <div style="padding: 10px 10px 10px 10px;">

                                        <form id="form_edit_education" class="form-horizontal" role="form" method="post"
                                              enctype="multipart/form-data"
                                              action="index.php?mod=hr/sm_update_frmsub_education">
                                            <div class="table-responsive">

                                                <h4 class="page-header">ข้อมูลการศึกษา</h4>
                                                <input type="hidden" id="hidden_edit_id" name="hidden_edit_id"
                                                       value="<?= $_GET['edit_id'] ?>">
                                                <input type="hidden" id="hidden_education_id" name="hidden_education_id"
                                                       value="<?= $_GET['education_id'] ?>">

                                                <div class="col-sm-12">
                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">วุฒิการศึกษา : </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="degree_level"
                                                                    name="degree_level" autofocus="autofocus">
                                                                <?php
                                                                $sql_select_degree = "SELECT * FROM hr_person_degree ORDER BY degree_id DESC";
                                                                $query_degree = mysqli_query($conn, $sql_select_degree);
                                                                while ($degree = mysqli_fetch_array($query_degree)) {
                                                                    ?>
                                                                    <option value="<?= $degree[0] ?>" <?php if($edit_degree[2]==$degree[0])echo "selected"; ?>><?= $degree[2] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-8">
                                                        <label class="col-sm-2 control-label ">ชื่อสถาบันการศึกษา
                                                            : </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="degree_name"
                                                                   name="degree_name"
                                                                   placeholder="กรอกชื่อสถาบันการศึกษา"
                                                                   onkeyup="return check_degree_name();" maxlength="100"
                                                                   autofocus="autofocus" value="<?=$edit_degree[3]?>">
                                                            <div id="alert_degree_name" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">เกรดเฉลี่ย : </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="gpa"
                                                                   name="gpa"
                                                                   placeholder="กรุณากรอกเกรดเฉลี่ย"
                                                                   onkeyup="return check_gpa();" maxlength="4" value="<?=$edit_degree[6]?>">
                                                            <div id="alert_gpa" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">วุฒิที่ได้รับ : </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="degree"
                                                                   name="degree"
                                                                   placeholder="กรอกวุฒิที่ได้รับ"
                                                                   onkeyup="return check_degree();" value="<?=$edit_degree[4]?>"
                                                                   maxlength="100">
                                                            <div id="alert_degree" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">สาขาวิชา/วิชาเอก
                                                            : </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="major"
                                                                   name="major"
                                                                   placeholder="กรอกสาขาวิชา/วิชาเอก"
                                                                   onkeyup="return check_major();"
                                                                   maxlength="100" value="<?=$edit_degree[5]?>">
                                                            <div id="alert_major" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">วันที่เข้าศึกษา
                                                            : </label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" id="education_start"
                                                                   name="education_start"
                                                                   placeholder="วันที่เข้าศึกษา :"
                                                                   required
                                                                   data-errormessage-value-missing="กรุณากรอกวันที่เข้าศึกษา" value="<?=$edit_degree[7]?>">
                                                            <div id="alert_education_start" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="col-sm-4 control-label ">วันที่จบการศึกษา
                                                            :</label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" id="education_end"
                                                                   name="education_end"
                                                                   placeholder="กรอกสาขาวิชา/วิชาเอก"
                                                                   required
                                                                   data-errormessage-value-missing="กรุณากรอกวันที่จบการศึกษา" value="<?=$edit_degree[8]?>">
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

    $("#alert_degree_name").hide();
    $("#alert_gpa").hide();
    $("#alert_degree").hide();
    $("#alert_major").hide();

    var alert_degree_name = false;
    var alert_gpa = false;
    var alert_degree = false;
    var alert_major = false;

    function check_degree_name() {

        var length = $("#degree_name").val().length;
        var degree_name = $("#degree_name").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (!length) {
            alert_degree_name = true;
            $("#alert_degree_name").show().html("*กรุณากรอก ชื่อสถาบันการศึกษา");
            $("#degree_name").focus();
        } else if (!pattern.test($("#degree_name").val())) {
            alert_degree_name = true;
            $("#alert_degree_name").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#degree_name").focus();
        } else if (length > 100) {
            alert_degree_name = true;
            $("#alert_degree_name").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            $("#degree_name").focus();
        } else {
            alert_degree_name = false;
            $("#alert_degree_name").hide();
        }
    }

    function check_gpa() {
        var pattern = new RegExp(/^[0-9. ]+$/);
        var gpa = $("#gpa").val().substring(2, 3);

        if (!gpa) {
            $("#alert_gpa").show().html("*กรุณากรอกเกรดเฉลี่ย");
            alert_gpa = true;
            $("#gpa").focus();
        } else if (gpa == "_") {
            $("#alert_gpa").show().html("*กรุณากรอกเกรดเฉลี่ย");
            alert_gpa = true;
            $("#gpa").focus();
        } else if (!pattern.test($("#gpa").val())) {
            alert_gpa = true;
            $("#alert_gpa ").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#gpa").focus();
        } else {
            $("#alert_gpa").hide();
            alert_gpa = false;
        }
    }

    function check_degree() {
        var length = $("#degree").val().length;
        var degree = $("#degree").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (!length) {
            alert_degree_name = true;
            $("#alert_degree").show().html("*กรุณากรอก วุฒิที่ได้รับ");
            $("#degree").focus();
        } else if (!pattern.test($("#degree").val())) {
            alert_degree = true;
            $("#alert_degree").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#degree").focus();
        } else if (length > 100) {
            alert_degree = true;
            $("#alert_degree").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            $("#degree").focus();
        } else {
            alert_degree = false;
            $("#alert_degree").hide();
        }
    }

    function check_major() {
        var length = $("#major").val().length;
        var major = $("#major").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (!length) {
            alert_major = true;
            $("#alert_major").show().html("*กรุณากรอก สาขาวิชา");
            $("#major").focus();
        } else if (!pattern.test($("#major").val())) {
            alert_major = true;
            $("#alert_major").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#major").focus();
        } else if (length > 100) {
            alert_major = true;
            $("#alert_major").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            $("#major").focus();
        } else {
            alert_major = false;
            $("#alert_major").hide();
        }
    }

    $("#form_edit_education").submit(function () {

        alert_major = false;
        check_major();
        alert_degree = false;
        check_degree();
        alert_gpa = false;
        check_gpa();
        alert_degree_name = false;
        check_degree_name();

        if (alert_degree_name != true && alert_gpa != true && alert_degree != true && alert_major != true) {
            return true;
        } else {
            return false;
        }

    });

</script>