<?php
if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");
if (!isset($_GET["id"])) exit("<script>window.history.back();</script>");
include("inc/topnav.php");
?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">Time of work management.</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-file"></i> หัวข้อ แก้ไขข้อมูลเงินเดือน.
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
                                $sql_select_file = "SELECT * FROM fn_scan_file WHERE scanfile_id='{$_GET["id"]}'";
                                $query_file = mysqli_query($conn, $sql_select_file);
                                $assoc_file = mysqli_fetch_assoc($query_file);
                                ?>
                                <form id="form_edit_file" class="form-horizontal" role="form" method="post"
                                      enctype="multipart/form-data" action="index.php?mod=fn/sm_update_time">
                                    <h4 class="page-header">แก้ไขข้อมูลเงินเดือน</h4>
                                    <input type="hidden" id="hidden_file_id" name="hidden_file_id"
                                           value="<?= $assoc_file["scanfile_id"] ?>">

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
                                                        <option value="<?= $assoc_company["company_id"] ?>"<?php if ($assoc_company["company_id"] == $assoc_file["scanfile_company"]) {
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
                                                <input type="text" class="form-control" id="scan_title"
                                                       name="scan_title"
                                                       placeholder="หัวข้อ ข้อมูลเวลาทำงาน"
                                                       onkeyup="return check_title();" maxlength="200"
                                                       autofocus="autofocus" value="<?= $assoc_file["scanfile_title"] ?>">
                                                <div id="alert_scan_title"
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
                                                           id="time_start_date"
                                                           name="time_start_date"
                                                           data-errormessage-value-missing="*กรุณากรอกวันเริ่มต้น (ค.ศ.)"
                                                           value="<?=$assoc_file["scanfile_startdate"]?>"
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
                                                           id="time_end_date"
                                                           name="time_end_date"
                                                           data-errormessage-value-missing="*กรุณากรอกวันสิ้นสุด (ค.ศ.)"
                                                           value="<?=$assoc_file["scanfile_enddate"]?>"
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
                                                                <input type="file" id="scan_file"
                                                                       name="scan_file" accept="pdf/*"
                                                                       class="form-control"
                                                                       style="width: 100%;" onchange="check_file();">
                                                                <div id="alert_scan_file"
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

                                            <button type="button" class="btn btn-default" onclick="show_alert();" id="btn_alert" name="btn_alert">Show console</button>
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
        window.location = 'index.php?mod=fn/manage_time';
    }

    $("#alert_scan_title").hide();
    var alert_scan_title = false;
    $("#alert_company").hide();
    var alert_company = false;
    $("#alert_scan_file").hide();
    var alert_scan_file = false;

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
        var scan_title = $("#scan_title").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ0-9+#._.-]+$/);
        if (!scan_title) {
            alert_scan_title = true;
            $("#alert_scan_title").show().html("*กรุณากรอกหัวข้อ");
            $("#scan_title").focus();
        } else if (!pattern.test($("#scan_title").val())) {
            alert_scan_title = true;
            $("#alert_scan_title").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#scan_title").focus();
        } else {
            alert_scan_title = false;
            $("#alert_scan_title").hide();
        }
    }

    function check_file() {
        var file = $("#scan_file").val();
        if (!file) {
            alert_scan_file = false;
            $("#alert_scan_file").hide();
        } else {
            alert_scan_file = false;
            $("#alert_scan_file").hide();
        }
    }

    $("#btn_alert").hide();
    function show_alert(){
        console.log("alert_scan_title : "+alert_scan_title);
        console.log("alert_company : "+alert_company);
        console.log("alert_scan_file : "+alert_scan_file);
    }

    $("#form_edit_file").submit(function () {
        alert_scan_title = false;
        alert_company = false;
        alert_scan_file = false;
        check_title();
        check_company();
        check_file();
        if (alert_scan_title == false && alert_company == false && alert_scan_file == false) return true;
        else return false;
    });

</script>



