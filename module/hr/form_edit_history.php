<?php
if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

include("inc/topnav.php");

if (isset($_GET['edit_id'])) {
?>


<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">Human Resources.</h3>
        </div>
    </div>

    <?php
    $sql_select_education = "SELECT * FROM hr_person_education WHERE person_id='$_GET[edit_id]' ";
    $query_education = mysqli_query($conn, $sql_select_education);
    $num__education = mysqli_num_rows($query_education);

    $sql_history = "SELECT * FROM hr_person_history WHERE person_id='$_GET[edit_id]' ";
    $query_history = mysqli_query($conn, $sql_history);
    $num_history = mysqli_num_rows($query_history);

    $sql_select_person="
        SELECT person_id,person_prename,person_firstname_thai,person_lastname_thai FROM hr_person 
        WHERE person_id='{$_GET["edit_id"]}'
    ";
    $query_select_person=mysqli_query($conn,$sql_select_person);
    $person=mysqli_fetch_assoc($query_select_person);

    if ($num__education != 0 || $num_history != 0) {
    ?>
    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-graduation-cap"></i> หัวข้อ แก้ไขข้อมูลการศึกษาและประวัติการทำงาน.
                </div>
                <div class="table-responsive">
                    <div class="panel-body">
                        <div class="row">

                            <div style="">
                                <?php
                                if ($num__education != 0) {
                                    ?>
                                    <form id="form_subedit_education" class="form-horizontal" role="form"
                                          method="post"
                                          enctype="multipart/form-data"
                                          action="index.php?mod=hr/sm_del_education">

                                        <div class="col-sm-12">
                                            <div style="float:left;">
                                                <button class="btn btn-info" type="button"
                                                        id="btn_nextpage"
                                                        class="btn btn-info"
                                                        onclick="window.location='index.php?mod=hr/form_edit_person&id=<?= $_GET['edit_id'] ?>'"
                                                        style="float:right; ">
                                                    <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                                                </button>
                                            </div>
                                            <div style="float:right;">

                                                <button class="btn btn-info" type="button"
                                                        id="btn_nextpage"
                                                        class="btn btn-info"
                                                        onclick="window.location='index.php?mod=hr/form_edit_employment&edit_id=<?= $_GET['edit_id'] ?>'"
                                                        style="float:right; ">
                                                    ขั้นตอนต่อไป <i class="fa fa-long-arrow-right"></i>
                                                </button>

                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <h4 class="page-header">ข้อมูลบุคคล</h4>
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-4 control-label ">รหัสพนักงาน : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                           id="employment_person_id"
                                                           name="employment_person_id" value="<?= $person["person_id"] ?>"
                                                           disabled>
                                                </div>
                                            </div>
                                            <?php
                                            if ($person["person_prename"] == 1) $prename = "นาย";
                                            else if ($person["person_prename"] == 2) $prename = "นางสาว";
                                            else $prename = "นาง";
                                            ?>
                                            <div class="form-group col-sm-8">
                                                <label class="col-sm-2 control-label ">ชื่อ-สกุล : </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                           id="employment_fullname"
                                                           name="employment_fullname"
                                                           value="<?= $prename . " " . $person["person_firstname_thai"] . " " . $person["person_lastname_thai"] ?>"
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <table class="table table-bordered table-hover table-striped">
                                                <h4 class="page-header">ข้อมูลวุฒิการศึกษา</h4>
                                                <div style="float:right; padding-bottom:10px;">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                            onclick="edit_add_education();">
                                                        <i class="fa fa-sm fa-graduation-cap"></i> |
                                                        เพิ่มข้อมูลการศึกษา
                                                    </button>
                                                </div>

                                                <?php
                                                $sql_select = "SELECT * FROM hr_person_education WHERE person_id='$_GET[edit_id]' ORDER BY degree_id DESC ";
                                                $sql_select_major = "SELECT";
                                                $query = mysqli_query($conn, $sql_select);
                                                ?>
                                                <thead>
                                                <tr>
                                                    <th style="text-align:center;">ลำดับ</th>
                                                    <th style="text-align:center;">ชื่อสถาบันการศึกษา
                                                    </th>
                                                    <th style="text-align:center;">ประเภทวุฒิการศึกษา
                                                    </th>
                                                    <th style="text-align:center;">วุฒิการศึกษา</th>
                                                    <th style="text-align:center;">สาขาวิชา</th>
                                                    <th style="text-align:center;">เกรดเฉลี่ย</th>
                                                    <th style="text-align:center;">จัดการข้อมูล</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;
                                                while ($education = mysqli_fetch_array($query)) {
                                                    ?>

                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $education[3] ?></td>
                                                        <td>
                                                            <?php
                                                            $sql_select_degree_show = "SELECT degree_descript FROM hr_person_degree WHERE degree_id='$education[2]'";
                                                            $query_degree_show = mysqli_query($conn, $sql_select_degree_show);
                                                            list($name) = mysqli_fetch_row($query_degree_show);
                                                            echo "$name";
                                                            ?>
                                                        </td>
                                                        <td><?= $education[4] ?></td>
                                                        <td><?= $education[5] ?></td>
                                                        <td><?= $education[6] ?></td>

                                                        <td style="text-align:center;">
                                                            <a href="index.php?mod=hr/form_subedit_education&education_id=<?= $education[0] ?>&edit_id=<?= $_GET['edit_id'] ?>"
                                                               class="btn btn-xs btn-warning"><span class="fa fa-cogs"></span> | แก้ไข</a>
                                                            <a href="index.php?mod=hr/sm_subedit_del_education&education_id=<?= $education[0] ?>&edit_id=<?= $_GET['edit_id'] ?>"
                                                               class="btn btn-xs btn-danger"
                                                               onclick="return confirm('คุณต้องการลบข้อมูลจริงหรือไม่')"><span
                                                                        class="fa fa-minus-square"></span> | ลบ</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                    <?php
                                }

                                if ($num_history != 0) {
                                    ?>
                                    <form id="form_subedit_history" class="form-horizontal" role="form"
                                          method="post"
                                          enctype="multipart/form-data"
                                          action="index.php?mod=hr/sm_del_history">

                                        <div class="col-sm-12">
                                            <table class="table table-bordered table-hover table-striped">
                                                <h4 class="page-header">ข้อมูลประวัติการทำงาน</h4>

                                                <div style="float:right; padding-bottom:10px;">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                            onclick="edit_add_history();">
                                                        <i class="fa fa-sm fa-graduation-cap"></i> |
                                                        เพิ่มข้อมูลประวัติการทำงาน
                                                    </button>
                                                </div>
                                                <?php
                                                $sql_select = "SELECT * FROM hr_person_history WHERE person_id='$_GET[edit_id]' ORDER BY history_start DESC ";

                                                $query = mysqli_query($conn, $sql_select);
                                                ?>
                                                <thead>
                                                <tr>
                                                    <th style="text-align:center;">ลำดับ</th>
                                                    <th style="text-align:center;">ชื่อบริษัท</th>
                                                    <th style="text-align:center;">ตำแหน่ง</th>
                                                    <th style="text-align:center;">เงินเดือน</th>
                                                    <th style="text-align:center;">เหตุผลที่ออกจากงานเดิม
                                                    </th>
                                                    <th style="text-align:center;">วันที่เข้าทำงาน</th>
                                                    <th style="text-align:center;">วันที่ออกจากงาน</th>
                                                    <th style="text-align:center;">จัดการข้อมูล</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;
                                                while ($history = mysqli_fetch_array($query)) {
                                                    ?>

                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $history[2] ?></td>
                                                        <td><?= $history[3] ?></td>
                                                        <td><?= $history[6] . " บาท" ?></td>
                                                        <td><?= $history[7] ?></td>
                                                        <td><?= $history[4] ?></td>
                                                        <td><?= $history[5] ?></td>
                                                        <td style="text-align:center;">
                                                            <a href="index.php?mod=hr/form_subedit_history&history_id=<?= $history[0] ?>&edit_id=<?= $_GET['edit_id'] ?>"
                                                               class="btn btn-xs btn-warning"><span class="fa fa-cogs"> | แก้ไข</span></a>
                                                            <a href="index.php?mod=hr/sm_subedit_del_history&history_id=<?= $history[0] ?>&edit_id=<?= $_GET['edit_id'] ?>"
                                                               class="btn btn-xs btn-danger"
                                                               onclick="return confirm('คุณต้องการลบข้อมูลจริงหรือไม่')"><span
                                                                        class="fa fa-minus-square"> | ลบ</span></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }

                                                ?>
                                                </tbody>

                                            </table>
                                        </div>

                                    </form>
                                    <?php
                                }
                                ?>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <ul class="pager">
                <li><a href="?mod=main" class="btn btn-default">กลับสู่หน้าหลัก</a></li>
            </ul>

        </div>
        <?php
        }
        ?>
        <div id="div_add" style="padding:0 10px 0 15px;">
            <div class="col-sm-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-graduation-cap"></i> หัวข้อ แก้ไขข้อมูลการศึกษาและประวัติการทำงาน.
                    </div>
                    <div class="table-responsive">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">

                                    <div id="div_add_education">
                                        <form id="form_edit_education" class="form-horizontal" role="form"
                                              method="post"
                                              enctype="multipart/form-data"
                                              action="index.php?mod=hr/sm_subedit_insert_education">
                                            <h4 class="page-header">ข้อมูลการศึกษา</h4>
                                            <input type="hidden" id="hidden_edit_id" name="hidden_edit_id"
                                                   value="<?= $_GET['edit_id'] ?>">

                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">วุฒิการศึกษา
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="degree_level"
                                                                name="degree_level" autofocus="autofocus">
                                                            <?php
                                                            $sql_select_degree = "SELECT * FROM hr_person_degree ORDER BY degree_id DESC";
                                                            $query_degree = mysqli_query($conn, $sql_select_degree);
                                                            while ($degree = mysqli_fetch_array($query_degree)) {
                                                                ?>
                                                                <option value="<?= $degree[0] ?>"><?= $degree[2] ?></option>
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
                                                               onkeyup="return check_degree_name();"
                                                               maxlength="100"
                                                               autofocus="autofocus">
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
                                                               onkeyup="return check_gpa();" maxlength="4">
                                                        <div id="alert_gpa" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">วุฒิที่ได้รับ
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="degree"
                                                               name="degree"
                                                               placeholder="กรอกวุฒิที่ได้รับ"
                                                               onkeyup="return check_degree();"
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
                                                               maxlength="100">
                                                        <div id="alert_major" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">วันที่เข้าศึกษา
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control"
                                                               id="education_start"
                                                               name="education_start"
                                                               placeholder="วันที่เข้าศึกษา :"
                                                               required
                                                               data-errormessage-value-missing="กรุณากรอกวันที่เข้าศึกษา">
                                                        <div id="alert_education_start"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">วันที่จบการศึกษา
                                                        :</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control"
                                                               id="education_end"
                                                               name="education_end"
                                                               placeholder="กรอกสาขาวิชา/วิชาเอก"
                                                               required
                                                               data-errormessage-value-missing="กรุณากรอกวันที่จบการศึกษา">
                                                        <div id="alert_education_end" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <hr>
                                            </div>

                                            <div class="col-sm-12">
                                                <div style="float:right; padding-bottom:10px;">
                                                    <button class="btn btn-primary" type="submit" id="submit"
                                                            class="btn btn-default">
                                                        <i class="fa fa-sm fa-plus-square"></i> | บันทึกข้อมูล
                                                    </button>
                                                    <button type="reset" class="btn btn-default"
                                                            data-dismiss="modal" onclick="cancel_education();">
                                                        ยกเลิก
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div id="div_add_history">
                                        <form id="form_edit_history" class="form-horizontal" role="form"
                                              method="post"
                                              enctype="multipart/form-data"
                                              action="index.php?mod=hr/sm_subedit_insert_history">

                                            <h4 class="page-header">ข้อมูลการทำงาน</h4>

                                            <input type="hidden" id="hidden_edit_id" name="hidden_edit_id"
                                                   value="<?= $_GET['edit_id'] ?>">

                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-8">
                                                    <label class="col-sm-2 control-label ">ชื่อบริษัทที่ทำงาน
                                                        : </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control"
                                                               id="history_company"
                                                               name="history_company"
                                                               placeholder="ชื่อบริษัทที่ทำงาน"
                                                               onkeyup="return check_company_name();"
                                                               maxlength="100"
                                                               autofocus="autofocus">
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
                                                               autofocus="autofocus">
                                                        <div id="alert_history_position"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-8">
                                                    <label class="col-sm-2 control-label ">เหตุผลที่ออก
                                                        : </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="reason"
                                                               name="reason"
                                                               placeholder="เหตุผลที่ออก"
                                                               onkeyup="return check_reason();" maxlength="100"
                                                               autofocus="autofocus">
                                                        <div id="alert_reason" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">เงินเดือนครั้งสุดท้าย
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control"
                                                               id="history_salary"
                                                               name="history_salary"
                                                               placeholder="15000"
                                                               onkeyup="return check_history_salary();"
                                                               maxlength="30">
                                                        <div id="alert_history_salary" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">วันที่เข้าทำงาน
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control"
                                                               id="history_start"
                                                               name="history_start" required
                                                               data-errormessage-value-missing="กรุณากรอกวันที่เข้าทำงาน">
                                                        <div id="alert_education_start"
                                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <label class="col-sm-4 control-label ">วันที่ออกจากงาน
                                                        : </label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control"
                                                               id="history_finish"
                                                               name="history_finish" required
                                                               data-errormessage-value-missing="กรุณากรอกวันที่ออกจากงาน">
                                                        <div id="alert_education_end" style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-sm-12">
                                                <hr>
                                            </div>

                                            <div class="col-sm-12">
                                                <div style="float:right; padding-bottom:10px;">
                                                    <button class="btn btn-primary" type="submit" id="submit"
                                                            class="btn btn-default">
                                                        <i class="fa fa-sm fa-plus-square"></i> | บันทึกข้อมูล
                                                    </button>
                                                    <button type="reset" class="btn btn-default"
                                                            data-dismiss="modal" onclick="cancel_history();">
                                                        ยกเลิก
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

        $("#alert_degree_name").hide();
        $("#alert_gpa").hide();
        $("#alert_degree").hide();
        $("#alert_major").hide();
        $("#div_add").hide();
        $("#div_add_education").hide();
        $("#div_add_history").hide();

        var alert_degree_name = false;
        var alert_gpa = false;
        var alert_degree = false;
        var alert_major = false;

        $("#alert_company_name").hide();
        $("#alert_reason").hide();
        $("#alert_history_salary").hide();
        $("#alert_history_position").hide();

        var alert_company_name = false;
        var alert_reason = false;
        var alert_history_salary = false;
        var alert_history_position = false;

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
            var pattern = new RegExp(/^[0-9a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_-]+$/);

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
            var pattern = new RegExp(/^[0-9a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ_-]+$/);

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

        //Function for system on this page
        function edit_add_education() {
            // open && close
            $("#div_add").show();
            $("#div_add_education").show();
            // close div history (clear from history)
            document.getElementById("history_company").value = "";
            document.getElementById("history_position").value = "";
            document.getElementById("reason").value = "";
            document.getElementById("history_salary").value = "";
            $("#history_start").val("yyyy-MM-dd");
            $("#history_finish").val("yyyy-MM-dd");
            $("#div_add_history").hide();
            $("#degree_level").focus();
        }

        function cancel_education() {
            // open && close
            $("#div_add").hide();
            $("#div_add_education").hide();
        }

        function edit_add_history() {
            // open && close
            $("#div_add").show();
            $("#div_add_history").show();
            // close div education (clear from education)
            document.getElementById("degree_level").selectedIndex = 0;
            document.getElementById("degree_name").value = "";
            document.getElementById("gpa").value = "";
            document.getElementById("degree").value = "";
            document.getElementById("major").value = "";
            $("#education_start").val("yyyy-MM-dd");
            $("#education_end").val("yyyy-MM-dd");
            $("#div_add_education").hide();
            $("#history_company").focus();
        }

        function cancel_history() {
            // open && close
            $("#div_add").hide();
            $("#div_add_history").hide();
        }

        function show_console() {
            console.log("alert_company_name : " + alert_company_name);
            console.log("alert_history_position : " + alert_history_position);
            console.log("alert_reason : " + alert_reason);
            console.log("alert_history_salary : " + alert_history_salary);
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