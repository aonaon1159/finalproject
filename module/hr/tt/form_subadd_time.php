<?php
/**
 * Created by PhpStorm.
 * User: Avaibooking
 * Date: 1/22/2018
 * Time: 11:24 AM
 */
if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

include("inc/topnav.php");

if (isset($_GET["count_id"]) && isset($_GET["file_id"])) {

    $sql_select_thistime = "
        SELECT * FROM fn_scan
        WHERE time_machine_count='{$_GET["count_id"]}' AND  scanfile_id='{$_GET["file_id"]}'
        LIMIT 1
    ";

    $query_thistime = mysqli_query($conn, $sql_select_thistime);
    if (mysqli_num_rows($query_thistime)) $assoc_thistime = mysqli_fetch_assoc($query_thistime);

    
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
                    <div class="table-responsive">

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
                                    <form id="form_subadd_time" class="form-horizontal" role="form" method="post"
                                          enctype="multipart/form-data"
                                          action="index.php?mod=fn/sm_insert_frmsub_time">

                                        <h4 class="page-header">ข้อมูลเวลาทำงาน</h4>

                                        <input type="hidden" id="hidden_count_id" name="hidden_count_id"
                                               value="<?= $_GET['count_id'] ?>">
                                        <input type="hidden" id="hidden_file_id" name="hidden_file_id"
                                               value="<?= $_GET['file_id'] ?>">
                                        <input type="hidden" id="hidden_date" name="hidden_date"
                                               value="<?= $_GET['date'] ?>">
                                        <?php
                                        if (isset($_GET['in_id']) || isset($_GET['out_id'])) {
                                            ?>
                                            <input type="hidden" id="hidden_in_id" name="hidden_in_id"
                                                   value="<?= $_GET['in_id'] ?>">
                                            <input type="hidden" id="hidden_out_id" name="hidden_out_id"
                                                   value="<?= $_GET['out_id'] ?>">
                                            <?php
                                            $sql_select_in = "
                                                        SELECT time_datetime FROM fn_scan
                                                        WHERE time_id='{$_GET["in_id"]}'
                                                    ";
                                            $sql_select_out = "
                                                        SELECT time_datetime FROM fn_scan
                                                        WHERE time_id='{$_GET["out_id"]}'
                                                    ";
                                            $query_in = mysqli_query($conn, $sql_select_in);
                                            $query_out = mysqli_query($conn, $sql_select_out);

                                            $assoc_time_in = mysqli_fetch_assoc($query_in);
                                            $assoc_time_out = mysqli_fetch_assoc($query_out);
                                        }

                                        if (str_replace("0", "", $assoc_thistime["time_machine_id"]) == true)
                                            $str_machine_id = str_replace("0", "", $assoc_thistime["time_machine_id"]);
                                        ?>
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">รหัสเครื่อง : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="time_company"
                                                           name="time_company" value="<?= $str_machine_id ?>"
                                                           readonly>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">บริษัท : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="time_company"
                                                           name="time_company"
                                                           value="<?= $assoc_thistime["time_company"] ?>"
                                                           readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">ชื่อ - นามสกุล
                                                    : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="time_fullname"
                                                           name="time_fullname"
                                                           value="<?= $assoc_thistime["time_fullname"] ?>"
                                                           readonly>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">แผนก : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="time_company"
                                                           name="time_company"
                                                           value="<?= $assoc_thistime["time_department"] ?>"
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
                                                    <input type="date" class="form-control" id="time_datetime"
                                                           name="time_datetime"
                                                           required
                                                           data-errormessage-value-missing="กรุณากรอกวันที่"
                                                           value="<?= $_GET["date"] ?>" readonly>
                                                    <div id="alert_datetime"
                                                         style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12"><br></div>
                                        <div class="form-group col-sm-12">
                                            <div class="form-group col-sm-4">
                                                <div class="form-group col-sm-4"></div>
                                                <div class="form-group col-sm-8">
                                                    <input type="checkbox" id="status_sick" name="status_sick"
                                                           value="1"
                                                        <?php
                                                        if ($assoc_in["time_status"] == 1 OR $assoc_out["time_status"] == 1) echo "checked";
                                                        ?>
                                                    > &emsp;&emsp;<b>ลาป่วย ( มีใบรับรองแพทย์ )</b><br>
                                                </div>

                                            </div>
                                            <div class="form-group col-sm-4">
                                                <div class="form-group col-sm-4"></div>
                                                <dvi class="form-group col-sm-8">
                                                    <input type="checkbox" id="status_sick" name="status_sick"value="2"
                                                    <?php
                                                    if ($assoc_in["time_status"] == 2 OR $assoc_out["time_status"] == 2) echo "checked";
                                                        ?>
                                                        > &emsp;&emsp;<b>ทำงานในวันหยุด</b><br>
                                        </div>
                                        </dvi>
                                        <div class="col-sm-12">
                                            <?php
                                            if (mysqli_num_rows($query_in) != 0) {
                                                $exp_in = explode(" ", $assoc_time_in["time_datetime"]);
//                                                        echo "date in : ".$assoc_time_in["time_datetime"];
                                                ?>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">เวลาเข้า : </label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control"
                                                               id="time_in"
                                                               name="time_in" step="2"
                                                               data-errormessage-value-missing="*กรุณากรอกเวลาเริ่มงาน"
                                                               required autofocus="autofocus" value="<?= $exp_in[1] ?>">
                                                        <div id="alert_time_in"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">เวลาเข้า : </label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control"
                                                               id="time_in"
                                                               name="time_in" step="2"
                                                               data-errormessage-value-missing="*กรุณากรอกเวลาเริ่มงาน"
                                                               required autofocus="autofocus">
                                                        <div id="alert_time_in"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            if (mysqli_num_rows($query_out) != 0) {
                                                $exp_out = explode(" ", $assoc_time_out["time_datetime"]);
//                                                        echo "date out : ".$assoc_time_out["time_datetime"];
                                                ?>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">เวลาออก
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control"
                                                               id="time_out"
                                                               name="time_out" step="2"
                                                               data-errormessage-value-missing="*กรุณากรอกเวลาออกงาน"
                                                               required autofocus="autofocus"
                                                               value="<?= $exp_out[1] ?>">
                                                        <div id="alert_time_out"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">เวลาออก
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control"
                                                               id="time_out"
                                                               name="time_out" step="2"
                                                               data-errormessage-value-missing="*กรุณากรอกเวลาออกงาน"
                                                               required autofocus="autofocus">
                                                        <div id="alert_time_out"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>

                                        <div class="col-sm-12">
                                            <?php
                                            if (isset($_GET["in_id"]) OR isset($_GET["out_id"])) {
                                                $sql_select_this_comment_in = "
                                                            SELECT time_comment FROM fn_scan
                                                            WHERE time_id='{$_GET["in_id"]}'
                                                        ";
                                                $sql_select_this_comment_out = "
                                                            SELECT time_comment FROM fn_scan
                                                            WHERE time_id='{$_GET["out_id"]}'
                                                        ";
                                                $query_comment_in = mysqli_query($conn, $sql_select_this_comment_in);
                                                $query_comment_out = mysqli_query($conn, $sql_select_this_comment_out);
                                                if (mysqli_num_rows($query_comment_in) != 0 OR mysqli_num_rows($query_comment_out) != 0) {
                                                    $assoc_comment_in = mysqli_fetch_assoc($query_comment_in);
                                                    $assoc_comment_out = mysqli_fetch_assoc($query_comment_out);
                                                    if (mysqli_num_rows($query_comment_in) != 0) $tmp_comment = $assoc_comment_in["time_comment"];
                                                    else if (mysqli_num_rows($query_comment_out) != 0) $tmp_comment = $assoc_comment_out["time_comment"];
                                                    ?>
                                                    <div class="form-group col-sm-8">
                                                        <label class="col-sm-2 control-label ">หมายเหตุ : </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="time_comment"
                                                                   placeholder="หมายเหตุ" onkeyup="check_comment();"
                                                                   name="time_comment" value="<?= $tmp_comment ?>">
                                                            <div id="alert_comment"
                                                                 style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="form-group col-sm-8">
                                                    <label class="col-sm-2 control-label ">หมายเหตุ : </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="time_comment"
                                                               placeholder="หมายเหตุ" onkeyup="check_comment();"
                                                               name="time_comment">
                                                        <div id="alert_comment"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

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

    $("#form_subadd_time").submit(function () {
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


</script>