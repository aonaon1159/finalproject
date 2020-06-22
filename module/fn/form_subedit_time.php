<?php

if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

include("inc/topnav.php");

if (isset($_GET["count_id"]) && isset($_GET["file_id"]) && isset($_GET['in_id']) && isset($_GET["out_id"])) {
    $sql_select_in = "
      SELECT * FROM fn_scan 
      WHERE time_id='{$_GET["in_id"]}'
    ";
    $sql_select_out = "
      SELECT * FROM fn_scan 
      WHERE time_id='{$_GET["out_id"]}'
    ";
    $query_in = mysqli_query($conn, $sql_select_in);
    $query_out = mysqli_query($conn, $sql_select_out);
    $assoc_in = mysqli_fetch_assoc($query_in);
    $assoc_out = mysqli_fetch_assoc($query_out);

    if (mysqli_num_rows($query_in) || mysqli_num_rows($query_out)) {
        ?>
        <div id="page-wrapper-hr">
            <div class="row">
                <div class="col-sm-12" style="padding-left:30px;">
                    <h3 class="page-header">Time of work management.</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12" style="padding-left:30px;">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-graduation-cap"></i> หัวข้อ แก้ไขข้อมูลเวลาทำงาน.
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12" style="padding-bottom:5px;">
                                    <button class="btn btn-default" type="button"
                                            id="btn_nextpage"
                                            class="btn btn-default"
                                            onclick="window.location='index.php?mod=fn/form_view_timedetail&count_id=<?=$_GET["count_id"]?>&file_id=<?= $_GET['file_id'] ?>'">
                                        <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                                    </button>
                                </div>

                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <div style="padding: 10px 10px 10px 10px;">

                                            <form id="form_subedit_time" class="form-horizontal" role="form"
                                                  method="post"
                                                  enctype="multipart/form-data"
                                                  action="index.php?mod=fn/sm_update_frmsub_time">
                                                <div class="table-responsive">
                                                    <h4 class="page-header">ข้อมูลเวลาทำงาน</h4>
                                                    <input type="hidden" id="hidden_in_id" name="hidden_in_id"
                                                           value="<?= $_GET['in_id'] ?>">
                                                    <input type="hidden" id="hidden_out_id" name="hidden_out_id"
                                                           value="<?= $_GET['out_id'] ?>">

                                                    <input type="hidden" id="hidden_count_id" name="hidden_count_id"
                                                           value="<?= $_GET['count_id'] ?>">
                                                    <input type="hidden" id="hidden_file_id" name="hidden_file_id"
                                                           value="<?= $_GET['file_id'] ?>">

                                                    <?php
                                                    if (str_replace("0", "", $assoc_in["time_machine_id"]) == true)
                                                        $str_machine_id = str_replace("0", "", $assoc_in["time_machine_id"]);
                                                    ?>
                                                    <div class="col-sm-12">
                                                        <div class="form-group col-sm-4">
                                                            <label class="col-sm-4 control-label ">รหัสเครื่อง
                                                                : </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                       id="time_machine"
                                                                       name="time_machine"
                                                                       value="<?= $str_machine_id ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            <label class="col-sm-4 control-label ">บริษัท : </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                       id="time_company"
                                                                       name="time_company"
                                                                       value="<?= $assoc_in["time_company"] ?>"
                                                                       readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group col-sm-4">
                                                            <label class="col-sm-4 control-label ">ชื่อ - นามสกุล
                                                                : </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                       id="time_fullname"
                                                                       name="time_fullname"
                                                                       value="<?= $assoc_in["time_fullname"] ?>"
                                                                       readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            <label class="col-sm-4 control-label ">แผนก : </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                       id="time_department_id"
                                                                       name="time_department_id"
                                                                       value="<?= $assoc_in["time_department"] ?>"
                                                                       readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <hr>
                                                    </div>
                                                    <?php
                                                    $datetime_in = $assoc_in["time_datetime"];
                                                    $datetime_out = $assoc_out["time_datetime"];
                                                    $exp_date_in = explode(" ", $datetime_in);
                                                    $exp_date_out = explode(" ", $datetime_out);
                                                    ?>
                                                    <div class="col-sm-12">
                                                        <div class="form-group col-sm-4">
                                                            <label class="col-sm-4 control-label ">วันที่ : </label>
                                                            <div class="col-sm-8">
                                                                <input type="date" class="form-control"
                                                                       id="time_datetime"
                                                                       name="time_datetime"
                                                                       required
                                                                       data-errormessage-value-missing="กรุณากรอกวันที่"
                                                                       value="<?= $exp_date_in[0] ?>" readonly>
                                                                <div id="alert_datetime"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                            </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-sm-12"><br></div>
                                                      <div class="col-sm-12">
                                                        <div class="form-group col-sm-4">
                                                            <div class="form-group col-sm-4"></div>
                                                            <div class="form-group col-sm-8">
                                                                <input type="checkbox" id="status_sick"
                                                                       name="status_sick"
                                                                       value="1"
                                                                    <?php
                                                                    if ($assoc_in["time_status"] == 1 || $assoc_out["time_status"] == 1) echo "checked";
                                                                    ?>
                                                                > &emsp;&emsp;<b>ลาป่วย ( มีใบรับรองแพทย์ )</b> <br>
                                                            </div>

                                                        </div>
                                                              <div class="form-group col-sm-4">
                                                                <div class="form-group col-sm-4"></div>
                                                                <dvi class="form-group col-sm-8">
                                                                    <input type="checkbox" id="status_sick" name="status_sick"value="2"
                                                                    <?php
                                                                    if ($assoc_in["time_status"] == 2 OR $assoc_out["time_status"] == 2) echo "checked";
                                                                        ?>
                                                                        >&emsp;&emsp;<b>ทำงานในวันหยุด</b><br>
                                                               </div>
                                                               <div class="form-group col-sm-4">
                                                          <div class="form-group col-sm-8">
                                                            <?php if ($exp_date_in[1] != "00:00:00" && $exp_date_out[1] != "00:00:00"){ ?>
                                                                    <input type="checkbox" id="leave_work" name="leave_work" 
                                                                      onchange="leave_work_handler(event)"
                                                                    
                                                                        ><label for="leave_work">&emsp;&emsp;&emsp;&emsp;<b>ขาดงาน</b></label><br>
                                                               <?php }?>
                                                               </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group col-sm-4">
                                                            <label class="col-sm-4 control-label ">เวลาเข้า : </label>
                                                            <div class="col-sm-8">
                                                                <input type="time" class="form-control" id="time_in"
                                                                       name="time_in" step="2"
                                                                       placeholder="เวลาเข้างาน :" required
                                                                       data-errormessage-value-missing="กรุณากรอกเวลาเข้างาน"
                                                                       <?php 
                                                                       if ($assoc_in["time_transaction"] == "I") {
                                                                        echo "value='$exp_date_in[1]'";
                                                                       }else{
                                                                        echo "value=''";
                                                                       }
                                                                       ?>
                                                                       >
                                                                <div id="alert_time_in"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            <label class="col-sm-4 control-label ">เวลาออก
                                                                : </label>
                                                            <div class="col-sm-8">
                                                                <input type="time" class="form-control" id="time_out"
                                                                       name="time_out" step="2"
                                                                       placeholder="เวลาออกงาน :"
                                                                       required
                                                                       data-errormessage-value-missing="กรุณากรอกเวลาออกงาน"
                                                                       <?php 
                                                                       if ($assoc_out["time_transaction"] == "O") {
                                                                        echo "value='$exp_date_out[1]'";
                                                                       }else{
                                                                        echo "value=''";
                                                                       }
                                                                       ?>
                                                                       >
                                                                <div id="alert_time_out"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="form-group col-sm-8">
                                                            <label class="col-sm-2 control-label ">หมายเหตุ : </label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                       id="time_comment"
                                                                       placeholder="หมายเหตุ" onkeyup="check_comment();"
                                                                       name="time_comment"
                                                                       value="<?= $assoc_in["time_comment"] ?>">
                                                                <div id="alert_comment"
                                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
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
}
?>

<script>

    $("#alert_comment").hide();
    $("#alert_datetime").hide();
    $("#alert_time_in").hide();
    $("#alert_time_out").hide();

    var alert_comment = false;
    var alert_datetime = false;
    var alert_time_in = false;
    var alert_time_out = false;

    function check_comment() {
        var length = $("#time_comment").val().length;
        var time_comment = $("#time_comment").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ_]+$/);

        if (!length) {
            alert_comment = false;
            $("#alert_comment").hide();
        } else if (!pattern.test($("#time_comment").val())) {
            alert_comment = true;
            $("#alert_comment").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#degree_name").focus();
        } else if (length > 100) {
            alert_comment = true;
            $("#alert_comment").show().html("*กรุณากรอกไม่เกิน 100 ตัวอักษร");
            $("#degree_name").focus();
        } else {
            alert_comment = false;
            $("#alert_comment").hide();
        }
    }

    $("#form_subedit_time").submit(function () {

        alert_comment = false;
        alert_datetime = false;
        alert_time_in = false;
        alert_time_out = false;
        check_comment();

        if (alert_comment != true && alert_datetime != true && alert_time_in != true && alert_time_out != true) {
            return true;
        } else {
            return false;
        }

    });

  var time_in
  var time_out

  function leave_work_handler (event) {
    
    var isChecked = event.target.checked

    if (isChecked) {

      time_in = document.querySelector('#time_in').value
      time_out = document.querySelector('#time_out').value

      document.querySelector('#time_in').value = ''
      document.querySelector('#time_out').value = ''

      document.querySelector('#time_in').disabled = true
      document.querySelector('#time_out').disabled = true

      document.querySelector('#time_in').required = false
      document.querySelector('#time_out').required = false

    } else {

      document.querySelector('#time_in').value = time_in
      document.querySelector('#time_out').value = time_out

      document.querySelector('#time_in').disabled = false
      document.querySelector('#time_out').disabled = false

      document.querySelector('#time_in').required = true
      document.querySelector('#time_out').required = true

    }

  }


</script>

