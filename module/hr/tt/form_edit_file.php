<?php
if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");
if (!isset($_GET["id"])) exit("<script>window.history.back();</script>");
include("inc/topnav.php");
?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">Salary management.</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-sm fa-folder-open"></i> หัวข้อ แก้ไขข้อมูลเงินเดือน.
                    <div class="pull-right">
                        <div class="btn-group">

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-sm-12">
                                <?php
                                $sql_select_file = "SELECT * FROM fn_salary_file WHERE file_id='{$_GET["id"]}'";
                                $query_file = mysqli_query($conn, $sql_select_file);
                                $assoc_file = mysqli_fetch_assoc($query_file);
                                ?>
                                <form id="form_edit_file" class="form-horizontal" role="form" method="post"
                                      enctype="multipart/form-data" action="index.php?mod=fn/sm_update_file">
                                    <h4 class="page-header">แก้ไขข้อมูลเงินเดือน</h4>
                                    <input type="hidden" id="hidden_file_id" name="hidden_file_id"
                                           value="<?= $assoc_file["file_id"] ?>">

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-9">
                                            <label class="col-sm-2 control-label">บริษัท : </label>
                                            <div class="col-sm-10">
                                                <select id="company" name="company" class="form-control"
                                                        autofocus="autofocus" onchange="check_company();">
                                                    <option value="0">- กรุณาเลือกบริษัท -</option>
                                                    <?php
                                                    $sql_select_company = "SELECT * FROM hr_person_company";
                                                    $query_select_company = mysqli_query($conn, $sql_select_company);
                                                    while ($assoc_company = mysqli_fetch_assoc($query_select_company)) {
                                                        ?>
                                                        <option value="<?= $assoc_company["company_id"] ?>"<?php if ($assoc_company["company_id"] == $assoc_file["file_company"]) {
                                                            echo "Selected";
                                                        } ?>><?= $assoc_company["company_name"] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div id="alert_company"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-9">
                                            <label class="col-sm-2 control-label ">หัวข้อ : </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="salary_title"
                                                       name="salary_title"
                                                       placeholder="หัวข้อ ตารางเงินเดือน"
                                                       onkeyup="return check_title();" maxlength="200"
                                                       autofocus="autofocus" value="<?= $assoc_file["file_title"] ?>">
                                                <div id="alert_salary_title"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-4">
                                            <div id="div_start_break_date">
                                                <label class="col-sm-5 control-label ">วันเริ่มต้น
                                                    : </label>
                                                <div class="col-sm-7">
                                                    <input type="date" class="form-control"
                                                           id="file_start_date"
                                                           name="file_start_date"
                                                           data-errormessage-value-missing="*กรุณากรอกวันเริ่มต้น (ค.ศ.)"
                                                           value="<?=$assoc_file["file_startdate"]?>"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <div id="div_finish_break_date">
                                                <label class="col-sm-5 control-label ">วันสิ้นสุด
                                                    : </label>
                                                <div class="col-sm-7">
                                                    <input type="date" class="form-control"
                                                           id="file_end_date"
                                                           name="file_end_date"
                                                           data-errormessage-value-missing="*กรุณากรอกวันสิ้นสุด (ค.ศ.)"
                                                           value="<?=$assoc_file["file_enddate"]?>"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-9">
                                            <label class="col-sm-2 control-label ">File (CSV TIS620) : </label>
                                            <div class="col-sm-10">
                                                <table style="width:100%;">
                                                    <tr>
                                                        <td>
                                                            <div class="form-group col-sm-12">
                                                                <input type="file" id="salary_file"
                                                                       name="salary_file" accept="pdf/*"
                                                                       class="form-control"
                                                                       style="width: 100%;" onchange="check_file();">
                                                                <div id="alert_salary_file"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div>
                                                                <img id="preview" class="img-responsive"
                                                                     style="max-width:200px; max-height: 100px;  padding:5px; margin:0 auto;">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <hr>
                                    </div>

                                    <div class="col-sm-12">
                                        <div style="float:right;">
                                            <button class="btn btn-primary" type="submit" id="submit">
                                                <i class="fa fa-sm fa-plus-square"></i> | บันทึกข้อมูล
                                            </button>

                                            <button type="reset" class="btn btn-default"
                                                    data-dismiss="modal" onclick="back_pagee();">ยกเลิก
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
    function back_pagee() {
        window.location = 'index.php?mod=fn/manage_salary';
    }

    $("#alert_salary_title").hide();
    var alert_salary_title = false;
    $("#alert_company").hide();
    var alert_company = false;
    $("#alert_salary_file").hide();
    var alert_salary_file = false;

    function check_company() {
        var company = $("#company").val();
        if (company == 0) {
            alert_company = true;
            $("#alert_company").show().html("*กรุณาเลือกบริษัทที่ทำงาน");
            $("#company").focus();
        } else {
            alert_company = false;
            $("#alert_company").hide();
        }
    }

    function check_title() {
        var salary_title = $("#salary_title").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ0-9+#._.-]+$/);
        if (!salary_title) {
            alert_salary_title = true;
            $("#alert_salary_title").show().html("*กรุณากรอกหัวข้อ");
            $("#salary_title").focus();
        } else if (!pattern.test($("#salary_title").val())) {
            alert_salary_title = true;
            $("#alert_salary_title").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#salary_title").focus();
        } else {
            alert_salary_title = false;
            $("#alert_salary_title").hide();
        }
    }

    function check_file() {
        var file = $("#salary_file").val();
        if (!file) {
            alert_salary_file = false;
            $("#alert_salary_file").hide();
        } else {
            alert_salary_file = false;
            $("#alert_salary_file").hide();
        }
    }

    $("#form_edit_file").submit(function () {
        alert_salary_title = false;
        alert_company = false;
        alert_salary_file = false;
        check_title();
        check_company();
        check_file();
        if (alert_salary_title == false && alert_company == false && alert_salary_file == false) return true;
        else return false;
    });

</script>



