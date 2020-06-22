<?php
if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");

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
                    <i class="fa fa-file"></i> หัวข้อ เพิ่มข้อมูลเวลาทำงาน.
                    <div class="pull-right">
                        <div class="btn-group">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">

                                <form id="form_add_time" class="form-horizontal" role="form" method="post"
                                      enctype="multipart/form-data" action="index.php?mod=fn/sm_insert_time">
                                    <h4 class="page-header">เพิ่มข้อมูลเวลาทำงาน</h4>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-10">
                                            <label class="col-sm-2 control-label">บริษัท : </label>
                                            <div class="col-sm-7">
                                                <select id="company" name="company" class="form-control"
                                                        autofocus="autofocus" onchange="check_company();">
                                                    <option value="0">- กรุณาเลือกบริษัท -</option>
                                                    <?php
                                                    $sql_select_company = "SELECT * FROM hr_person_company";
                                                    $query_select_company = mysqli_query($conn, $sql_select_company);
                                                    while ($assoc_company = mysqli_fetch_assoc($query_select_company)) {
                                                        ?>
                                                        <option value="<?= $assoc_company["company_id"] ?>"><?= $assoc_company["company_name"] ?></option>
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
                                        <div class="form-group col-sm-10">
                                            <label class="col-sm-2 control-label ">หัวข้อ : </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="time_title"
                                                       name="time_title"
                                                       placeholder="หัวข้อ ข้อมูลเวลาทำงาน"
                                                       onkeyup="return check_title();" maxlength="200"
                                                       autofocus="autofocus">
                                                <div id="alert_time_title"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-10">
                                            <div id="div_start_break_date">
                                                <label class="col-sm-2 control-label ">วันเริ่มต้น
                                                    : </label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control"
                                                           id="time_start_date"
                                                           name="time_start_date"
                                                           data-errormessage-value-missing="*กรุณากรอกวันเริ่มต้น (ค.ศ.)"
                                                           required>
                                                </div>
                                            </div>
                                        <!-- </div>
                                        <div class="form-group col-sm-10"> -->
                                            <div id="div_finish_break_date">
                                                <label class="col-sm-2 control-label">วันสิ้นสุด
                                                    : </label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control"
                                                           id="time_end_date"
                                                           name="time_end_date"
                                                           data-errormessage-value-missing="*กรุณากรอกวันสิ้นสุด (ค.ศ.)"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-10">
                                            <label class="col-sm-2 control-label ">File (CSV TIS620) : </label>
                                            <div class="col-sm-5">
                                                <table style="width:100%;">
                                                    <tr>
                                                        <td>
                                                            <div class="form-group col-sm-12">
                                                                <input type="file" id="time_file"
                                                                       name="time_file" accept=".csv"
                                                                       class="form-control"
                                                                       style="width: 100%;" onchange="check_file();">
                                                                <div id="alert_time_file"
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
</div>


<script>
    function back_page() {
        window.location = 'index.php?mod=fn/manage_time';
    }

    $("#alert_time_title").hide();
    var alert_time_title = false;
    $("#alert_company").hide();
    var alert_company = false;
    $("#alert_time_file").hide();
    var alert_time_file = false;

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
        var time_title = $("#time_title").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ0-9+#._.-]+$/);
        if (!time_title) {
            alert_time_title = true;
            $("#alert_time_title").show().html("*กรุณากรอกหัวข้อ");
            $("#time_title").focus();
        } else if (!pattern.test($("#time_title").val())) {
            alert_time_title = true;
            $("#alert_time_title").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#time_title").focus();
        } else {
            alert_time_title = false;
            $("#alert_time_title").hide();
        }
    }

    function check_file() {
        var file = $("#time_file").val();
        if (!file) {
            alert_time_file = true;
            $("#alert_time_file").show().html("*กรุณากรอกข้อมูลไฟล์เวลาทำงาน");
            $("#time_file").focus();
        } else {
            alert_time_file = false;
            $("#alert_time_file").hide();
        }
    }

    $("#form_add_time").submit(function () {
        alert_time_title = false;
        alert_company = false;
        alert_time_file = false;
        check_title();
        check_company();
        check_file();
        if (alert_time_title == false && alert_company == false && alert_time_file == false) return true;
        else return false;
    });

</script>



