<?php
if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");
if (!isset($_GET["salary_id"]) AND !isset($_GET["file_id"])) exit("<script>window.history.back();</script>");
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
                    <i class="fa fa-user-circle"></i> หัวข้อ แก้ไขข้อมูลเงินเดือน.
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
                                $sql_select_salary = "SELECT * FROM fn_salary WHERE salary_id='{$_GET["salary_id"]}' AND file_id='{$_GET["file_id"]}'";
                                $query_salary = mysqli_query($conn, $sql_select_salary);
                                $assoc_salary = mysqli_fetch_assoc($query_salary);

                                ?>
                                <form id="form_edit_salary" class="form-horizontal" role="form" method="post"
                                      enctype="multipart/form-data" action="index.php?mod=fn/sm_update_salary">
                                    <h4 class="page-header">แก้ไขข้อมูลเงินเดือน</h4>
                                    <input type="hidden" id="hidden_salary_id" name="hidden_salary_id"
                                           value="<?= $assoc_salary["salary_id"] ?>">
                                    <input type="hidden" id="hidden_file_id" name="hidden_file_id"
                                           value="<?= $assoc_salary["file_id"] ?>">
                                    <!-- _______________________________________________________ Start form edit detail of file salary _________________________________________________-->

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ลำดับ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="salary_count"
                                                       name="salary_count"
                                                       maxlength="50" disabled
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["salary_count"] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">รหัสพนักงาน : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="person_id"
                                                       name="person_id"
                                                       placeholder="รหัสพนักงาน"
                                                       maxlength="5" disabled
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["person_id"] ?>">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12"><br></div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">คำนำหน้าชื่อ Eng : </label>
                                            <div class="col-sm-8">
                                              <select id="salary_prefix_eng" name="salary_prefix_eng" class="form-control">
                                                <option value="0"
                                                <?php if ($assoc_salary["salary_prefix_eng"] == 0 ) { echo "selected"; } ?> >กรุณาเลือกคำนำหน้าชื่อ Eng</option>
                                                <option value="1"
                                                <?php if ($assoc_salary["salary_prefix_eng"] == 1 ) { echo "selected"; } ?> >Mr.</option>
                                                <option value="2"
                                                <?php if ($assoc_salary["salary_prefix_eng"] == 2 ) { echo "selected"; } ?> >Mis.</option>
                                                <option value="3"
                                                <?php if ($assoc_salary["salary_prefix_eng"] == 3 ) { echo "selected"; } ?> >Mrs.</option>
                                              </select>
                                                <!-- <input type="text" class="form-control" id="salary_prefix_eng"
                                                       name="salary_prefix_eng"
                                                       placeholder="กรอก คำนำหน้าชื่อ eng"
                                                       onchange="return salary_prefix_eng_edit();" maxlength="10"
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["salary_prefix_eng"] ?>"> -->
                                                <div id="alert_prefix_eng"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ชื่อ Eng : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="salary_name_eng"
                                                       name="salary_name_eng"
                                                       placeholder="กรอก ชื่อ eng"
                                                       onchange="return salary_name_eng_edit();" maxlength="50"
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["salary_name_eng"] ?>">
                                                <div id="alert_name_eng"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">นามสกุล Eng : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="salary_surname_eng"
                                                       name="salary_surname_eng"
                                                       placeholder="กรอก นามสกุล eng"
                                                       onchange="return salary_surname_eng_edit();" maxlength="50"
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["salary_surname_eng"] ?>">
                                                <div id="alert_surname_eng"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12"><br></div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ชื่อเต็ม thai : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="salary_fullname_thai"
                                                       name="salary_fullname_thai"
                                                       placeholder="กรอก ชื่อเต็ม (Thai)"
                                                       onchange="return salary_fullname_thai_edit();" maxlength="120"
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["salary_fullname_thai"] ?>">
                                                <div id="alert_fullname_thai"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label">ประเภทการจ่ายเงิน : </label>
                                            <div class="col-sm-8">
                                              <select id="salary_payment" name="salary_payment" class="form-control">
                                                <option value="0"
                                                <?php if ($assoc_salary["salary_payment"] == 0 ) { echo "selected"; } ?> >กรุณาเลือกประเภทการจ่ายเงิน</option>
                                                <option value="1"
                                                <?php if ($assoc_salary["salary_payment"] == 1 ) { echo "selected"; } ?> >DAILY</option>
                                                <option value="2"
                                                <?php if ($assoc_salary["salary_payment"] == 2 ) { echo "selected"; } ?> >MONTHLY</option>
                                              </select>
                                                <!-- <input type="text" class="form-control" id="salary_payment"
                                                       name="salary_payment"
                                                       placeholder="กรอก ประเภทการจ่ายเงิน"
                                                       onchange="return salary_payment_edit();" maxlength="30"
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["salary_payment"] ?>"> -->
                                                <div id="alert_salary_payment"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ตำแหน่ง : </label>
                                            <div class="col-sm-8">
                                              <select  id="salary_position" name="salary_position" class="form-control">
                                                <option value="0" 
                                                <?php if ($assoc_salary["salary_position"] == 0) { echo "selected"; } ?> >กรุณาตำแหน่งงาน</option>
                                                <option value="1" 
                                                <?php if ($assoc_salary["salary_position"] == 1) { echo "selected"; } ?> >GM. / HRM. / QMR. </option>
                                                <option value="2"
                                                <?php if ($assoc_salary["salary_position"] == 2) { echo "selected"; } ?> >MANAGER</option>
                                                <option value="3"
                                                <?php if ($assoc_salary["salary_position"] == 3) { echo "selected"; } ?> >OFFICER</option>
                                                <option value="4"
                                                <?php if ($assoc_salary["salary_position"] == 4) { echo "selected"; } ?> >OPERATOR</option>
                                              </select>

                                                <!-- <input type="text" class="form-control" id="salary_position"
                                                       name="salary_position"
                                                       placeholder="กรอก ตำแหน่ง"
                                                       onchange="return salary_position_edit();" maxlength="30"
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["salary_position"] ?>"> -->
                                                <div id="alert_salary_position"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label">แผนก : </label>
                                            <div class="col-sm-8">
                                              <select  id="salary_department" name="salary_department" class="form-control">
                                                <option value="0"
                                                <?php if ($assoc_salary["salary_department"] == 0) { echo "selected"; } ?> >กรุณาเลือกแผนกงาน</option>
                                                <option value="1"
                                                <?php if ($assoc_salary["salary_department"] == 1) { echo "selected"; } ?> >ADMIN</option>
                                                <option value="2"
                                                <?php if ($assoc_salary["salary_department"] == 2) { echo "selected"; } ?> >ACCOUNT</option>
                                                <option value="3"
                                                <?php if ($assoc_salary["salary_department"] == 3) { echo "selected"; } ?> >IT</option>
                                                <option value="4"
                                                <?php if ($assoc_salary["salary_department"] == 4) { echo "selected"; } ?> >PROGRAMMER</option>
                                              </select>
                                                <!-- <input type="text" class="form-control" id="salary_department"
                                                       name="salary_department"
                                                       placeholder="กรอก แผนก"
                                                       onchange="return salary_department_edit();" maxlength="50"
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["salary_department"] ?>"> -->
                                                <div id="alert_salary_department"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ส่วนงาน : </label>
                                            <div class="col-sm-8">
                                              <select  id="salary_section" name="salary_section" class="form-control">
                                                <option value="0"
                                                <?php if ($assoc_salary["salary_section"] == 0) { echo "selected"; } ?> >กรุณาเลือกส่วนงาน</option>
                                                <option value="1"
                                                <?php if ($assoc_salary["salary_section"] == 1) { echo "selected"; } ?> >ช้างเผือก</option>
                                                <option value="2"
                                                <?php if ($assoc_salary["salary_section"] == 2) { echo "selected"; } ?> >พร้าว</option>
                                                <option value="3"
                                                <?php if ($assoc_salary["salary_section"] == 3) { echo "selected"; } ?> >อาเขต</option>
                                                <option value="4"
                                                <?php if ($assoc_salary["salary_section"] == 4) { echo "selected"; } ?> >แม่มาลัย</option>
                                                <option value="5"
                                                <?php if ($assoc_salary["salary_section"] == 5) { echo "selected"; } ?> >ปาย</option>
                                                <option value="6"
                                                <?php if ($assoc_salary["salary_section"] == 6) { echo "selected"; } ?> >ปางมะผ้า</option>
                                                <option value="7"
                                                <?php if ($assoc_salary["salary_section"] == 7) { echo "selected"; } ?> >แม่ฮ่องสอน</option>
                                                <option value="8"
                                                <?php if ($assoc_salary["salary_section"] == 8) { echo "selected"; } ?> >ฮอด</option>
                                                <option value="9"
                                                <?php if ($assoc_salary["salary_section"] == 9) { echo "selected"; } ?> >แม่สะเรียง</option>
                                                <option value="10"
                                                <?php if ($assoc_salary["salary_section"] == 10) { echo "selected"; } ?> >แม่ลาน้อย</option>
                                                <option value="11"
                                                <?php if ($assoc_salary["salary_section"] == 11) { echo "selected"; } ?> >ขุนยวม</option>
                                                <option value="12"
                                                <?php if ($assoc_salary["salary_section"] == 12) { echo "selected"; } ?> >ออฟฟิศเปรมประชา</option>
                                                <option value="13"
                                                <?php if ($assoc_salary["salary_section"] == 13) { echo "selected"; } ?> >ออฟฟิศเอเวีย</option>
                                              </select>
                                                <!-- <input type="text" class="form-control" id="salary_section"
                                                       name="salary_section"
                                                       placeholder="กรอก ส่วนงาน"
                                                       onchange="return salary_section_edit();" maxlength="50"
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["salary_section"] ?>"> -->
                                                <div id="alert_salary_section"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label">สถานะ : </label>
                                            <div class="col-sm-8">
                                              <select id="salary_status" name="salary_status" class="form-control">
                                                <option value="0"
                                                <?php if ($assoc_salary["salary_status"] == 0 ) { echo "selected"; } ?> >กรุณาเลือกสถานะ</option>
                                                <option value="1"
                                                <?php if ($assoc_salary["salary_status"] == 1 ) { echo "selected"; } ?> >รายวัน</option>
                                                <option value="2"
                                                <?php if ($assoc_salary["salary_status"] == 2 ) { echo "selected"; } ?> >รายเดือน</option>
                                              </select>
                                                <!-- <input type="text" class="form-control" id="salary_status"
                                                       name="salary_status"
                                                       placeholder="กรอก สถานะ"
                                                       onchange="return salary_status_edit();" maxlength="30"
                                                       autofocus="autofocus"
                                                       value="<?= $assoc_salary["salary_status"] ?>"> -->
                                                <div id="alert_salary_status"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12"><br></div>
                                    <h4 class="page-header">ข้อมูลเงินเดือน</h4>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ค่าจ้าง/เงินเดือน : </label>
                                            <div class="col-sm-8">
                                                <?php
                                                if (str_replace('|', '', $assoc_salary["salary_income_rate"]) == true) {
                                                    $str_double_income = str_replace('|', '', $assoc_salary["salary_income_rate"]);
                                                    $str_comma_income = str_replace(",", "", $str_double_income);
                                                } else $str_comma_income = $assoc_salary["salary_income_rate"];
                                                ?>
                                                <input type="number" class="form-control" id="salary_income_rate"
                                                       name="salary_income_rate" placeholder="กรอก ค่าจ้าง/เงินเดือน"
                                                       min="0" max="1000000" autofocus="autofocus"
                                                       value="<?= $str_comma_income ?>">
                                                <div id="alert_income_rate"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label">จำนวนวันที่ทำงาน : </label>
                                            <div class="col-sm-8">
                                                <?php
                                                if (str_replace('|', '', $assoc_salary["salary_work_day"]) == true)
                                                    $str_comma_day = str_replace('|', '', $assoc_salary["salary_work_day"]);
                                                else $str_comma_day = $assoc_salary["salary_work_day"];
                                                ?>
                                                <input type="number" class="form-control" id="salary_work_day"
                                                       name="salary_work_day" placeholder="กรอก จำนวนวันที่ทำงาน"
                                                       max="31" min="0" autofocus="autofocus"
                                                       value="<?= $str_comma_day ?>">
                                                <div id="alert_work_day"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">รวมค่าจ้าง
                                                : </label>
                                            <div class="col-sm-8">
                                                <?php
                                                if (str_replace('|', '', $assoc_salary["salary_income"]) == true) {
                                                    $double_income = str_replace('|', '', $assoc_salary["salary_income"]);
                                                    $comma_salary_income = str_replace(',', '', $double_income);
                                                } else $comma_salary_income = $assoc_salary["salary_income"];
                                                ?>
                                                <input type="number" class="form-control" id="salary_income"
                                                       name="salary_income" readonly
                                                       value="<?= $comma_salary_income ?>">
                                                <div id="alert_income"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label">ค่าประจำตำแหน่ง : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_income_position"]) == true) {
                                                $comma_income_position = str_replace('|', '', $assoc_salary["salary_income_position"]);
                                            } else $comma_income_position = $assoc_salary["salary_income_position"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_income_position"
                                                       name="salary_income_position"
                                                       placeholder="กรอก ค่าประจำตำแหน่ง" min="0"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_income_position ?>">
                                                <div id="alert_income_position"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">รวมค่าคอม : </label>
                                            <div class="col-sm-8">
                                                <?php
                                                if (str_replace('|', '', $assoc_salary["salary_income_commission"]) == true) {
                                                    $comma_income_commission = str_replace('|', '', $assoc_salary["salary_income_commission"]);
                                                } else $comma_income_commission = $assoc_salary["salary_income_commission"];
                                                ?>
                                                <input type="number" class="form-control" id="salary_income_commission"
                                                       name="salary_income_commission" min="0"
                                                       placeholder="กรอก รวมค่าคอม"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_income_commission ?>">
                                                <div id="alert_income_commission"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label">ค่าคอม รับฝากพัสดุ : </label>
                                            <div class="col-sm-8"><?php
                                                if (str_replace('|', '', $assoc_salary["salary_commission_stock"]) == true) {
                                                    $comma_commission_stock = str_replace('|', '', $assoc_salary["salary_commission_stock"]);
                                                } else $comma_commission_stock = $assoc_salary["salary_commission_stock"];
                                                ?>
                                                <input type="number" class="form-control" id="salary_commission_stock"
                                                       name="salary_commission_stock" min="0"
                                                       placeholder="กรอก ค่าคอม รับฝากพัสดุ"
                                                       autofocus="autofocus"
                                                       value="">
                                                <div id="alert_commission_stock"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">จำนวนวันทำงานในวันหยุด : </label>
                                            <div class="col-sm-8">
                                                <?php
                                                if (str_replace('|', '', $assoc_salary["salary_holiday"]) == true)
                                                    $comma_salary_holiday = str_replace('|', '', $assoc_salary["salary_holiday"]);
                                                else $comma_salary_holiday = $assoc_salary["salary_holiday"];
                                                ?>
                                                <input type="number" class="form-control" id="salary_holiday"
                                                       name="salary_holiday"
                                                       placeholder="กรอก จำนวน วันทำงานในวันหยุด" min="0" max="31"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_salary_holiday ?>">
                                                <div id="alert_holiday"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">จำนวนเงิน วันทำงานในวันหยุด
                                                : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_income_holiday"]) == true) {
                                                if ($assoc_salary["salary_income_holiday"] == "0.00")
                                                    $comma_salary_income_holiday = 0;
                                                else {
                                                    $double_income_holiday = str_replace('|', '', $assoc_salary["salary_income_holiday"]);
                                                    $comma_salary_income_holiday = str_replace(',', '', $double_income_holiday);
                                                }
                                            } else $comma_salary_income_holiday = $assoc_salary["salary_income_holiday"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="salary_income_holiday"
                                                       name="salary_income_holiday"
                                                       max="31" min="0"
                                                       autofocus="autofocus" readonly
                                                       value="<?= $comma_salary_income_holiday ?>">
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-sm-12"><br></div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">จำนวน ชั่วโมง ot : </label>
                                            <?php



                                            if (!is_numeric($assoc_salary["salary_income_overtime_hours"]))
                                                $comma_salary_income_holiday = str_replace('|', '', $assoc_salary["salary_income_overtime_hours"]);
                                            else $comma_salary_income_holiday = $assoc_salary["salary_income_overtime_hours"];
                                            ?>
                                            <div class="col-sm-8">
                                              <input type="number" class="form-control" id="salary_income_overtime_hours"
                                                       name="salary_income_overtime_hours"
                                                       placeholder="กรอก รวม รายได้อื่นๆ"
                                                       autofocus="autofocus" 
                                                       value="<?= $comma_salary_income_holiday ?>">
                                                <div id="alert_income_overtime_hours"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">จำนวนเงิน ot : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_income_overtime"]) == true) {
                                                $double_income_overtime = str_replace('|', '', $assoc_salary["salary_income_overtime"]);
                                                $comma_salary_income_overtime = str_replace(',', '', $double_income_overtime);
                                            } else if ($assoc_salary["salary_income_overtime"] == "")
                                                $comma_salary_income_overtime = 0;
                                            else $comma_salary_income_overtime = $assoc_salary["salary_income_overtime"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_income_overtime"
                                                       name="salary_income_overtime"
                                                       autofocus="autofocus"
                                                       

                                                       value="<?= $comma_salary_income_overtime ?>" readonly>
                                                <div id="alert_income_overtime"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">รายได้ การเดินทางต่างจังหวัด
                                                : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_income_journey"]) == true)
                                                $comma_income_journey = str_replace('|', '', $assoc_salary["salary_income_journey"]);
                                            else $comma_income_journey = $assoc_salary["salary_income_journey"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_income_journey"
                                                       name="salary_income_journey" min="0"
                                                       placeholder="กรอก รายได้ การเดินทางต่างจังหวัด"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_income_journey ?>">
                                                <div id="alert_income_journey"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">รายได้อื่นๆ : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_income_other"]) == true)
                                                $comma_income_other = str_replace('|', '', $assoc_salary["salary_income_other"]);
                                            else $comma_income_other = $assoc_salary["salary_income_other"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_income_other"
                                                       name="salary_income_other" min="0"
                                                       placeholder="กรอก รายได้อื่นๆ"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_income_other ?>">
                                                <div id="alert_income_other"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                      <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ประเภท OT
                                                : </label>
                                            <?php
                                            $sql_select_employment_ot = mysqli_query($conn ,"SELECT employment_ot FROM hr_person_employment WHERE person_id='{$_GET["salary_id"]}'");
                                            list($fetch_ot) = mysqli_fetch_row($sql_select_employment_ot);
                                            ?>
                                            <div class="col-sm-8">
                                              <input type="text" class="form-control" id="ot_status" name="ot_status" value="<?php 
                                              if ($fetch_ot == 0) { echo "กรุณาเลือกประเภท OT"; }
                                              else if ($fetch_ot == 1) { echo "ไม่มีโอที"; }
                                              else if ($fetch_ot == 2) { echo "ตามเงินเดือน"; }
                                              else if ($fetch_ot == 3) { echo "7 ชม. / 100 บ."; }
                                              else if ($fetch_ot == 4) { echo "1 ชม. / 30 บ."; } 
                                              else { echo "1 ชม. / 25 บ."; }
                                               ?>" readonly>

                                              
                                              <!-- <select id="ot_status" name="ot_status" class="form-control" autofocus="autofocus" onchange="salary_process();">
                                                <option value="0" <?php if ($fetch_ot == 0) {
                                                    echo " selected";
                                                } ?> >กรุณาเลือกประเภท OT </option>
                                                <option value="1" <?php if ($fetch_ot == 1) {
                                                    echo " selected";
                                                } ?> >ไม่มีโอที
                                                </option>
                                                <option value="2" <?php if ($fetch_ot == 2) {
                                                    echo " selected";
                                                } ?> >ตามเงินเดือน
                                                </option>
                                                <option value="3" <?php if ($fetch_ot == 3) {
                                                    echo " selected";
                                                } ?> >7 ชม. / 100 บ.
                                                </option>
                                                <option value="4" <?php if ($fetch_ot == 4) {
                                                    echo " selected";
                                                } ?> >1 ชม. / 30 บ.
                                                </option>
                                                <option value="5" <?php if ($fetch_ot == 5) {
                                                    echo " selected";
                                                } ?> >1 ชม. / 25 บ.
                                                </option>
                                              </select> -->
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">รวม รายได้อื่นๆ
                                                : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_income_othersum"]) == true) {
                                                $comma_income_othersum = str_replace('|', '', $assoc_salary["salary_income_othersum"]);
                                            } else $comma_income_othersum = $assoc_salary["salary_income_othersum"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_income_othersum"
                                                       name="salary_income_othersum"
                                                       placeholder="กรอก รวม รายได้อื่นๆ"
                                                       autofocus="autofocus" readonly
                                                       value="<?= $comma_income_othersum ?>">
                                                <div id="alert_income_othersum"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12"><br></div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">โบนัส : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_income_bonus"]) == true) {
                                                $comma_income_bonus = str_replace('|', '', $assoc_salary["salary_income_bonus"]);
                                            } else $comma_income_bonus = $assoc_salary["salary_income_bonus"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_income_bonus"
                                                       name="salary_income_bonus"
                                                       placeholder="กรอก โบนัส" min="0"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_income_bonus ?>">

                                                <div id="alert_income_bonus"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">โบนัสประจำปี : </label>
                                            <div class="col-sm-8">
                                                <?php
                                                if (str_replace('|', '', $assoc_salary["salary_income_bonusyear"]) == true) {
                                                    $comma_income_bonusyear = str_replace('|', '', $assoc_salary["salary_income_bonusyear"]);
                                                } else $comma_income_bonusyear = $assoc_salary["salary_income_bonusyear"];
                                                ?>
                                                <input type="number" class="form-control" id="salary_income_bonusyear"
                                                       name="salary_income_bonusyear"
                                                       placeholder="กรอก โบนัสประจำปี" min="0"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_income_bonusyear ?>">

                                                <div id="alert_income_bonusyear"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">รวมรายได้ทั้งหมด
                                                : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_income_total"]) == true) {
                                                $comma_income_total = str_replace('|', '', $assoc_salary["salary_income_total"]);
                                            } else $comma_income_total = $assoc_salary["salary_income_total"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_income_total"
                                                       name="salary_income_total" min="0"
                                                       placeholder="กรอก รวมรายได้ทั้งหมด"
                                                       autofocus="autofocus" readonly
                                                       value="<?= $comma_income_total ?>">
                                                <div id="alert_income_total"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12"><br></div>
                                    <h4 class="page-header">ข้อมูลรายการหักออก</h4>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ค่าใช้จ่าย หักมาสาย : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_expense_late"]) == true) {
                                                $comma_expense_late = str_replace('|', '', $assoc_salary["salary_expense_late"]);
                                            } else $comma_expense_late = $assoc_salary["salary_expense_late"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_expense_late"
                                                       name="salary_expense_late" min="0"
                                                       placeholder="กรอก ค่าใช้จ่าย หักมาสาย"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_expense_late ?>">
                                                <div id="alert_expense_late"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ค่าใช้จ่าย เงินเบิกล่วงหน้า
                                                : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_expense_before"]) == true) {
                                                $comma_expense_before = str_replace('|', '', $assoc_salary["salary_expense_before"]);
                                            } else $comma_expense_before = $assoc_salary["salary_expense_before"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_expense_before"
                                                       name="salary_expense_before"
                                                       placeholder="กรอก ค่าใช้จ่าย เงินเบิกล่วงหน้า" min="0"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_expense_before ?>">
                                                <div id="alert_expense_before"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ค่าใช้จ่ายอุบัติเหตุ : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_expense_accident"]) == true) {
                                                $comma_expense_accident = str_replace('|', '', $assoc_salary["salary_expense_accident"]);
                                            } else $comma_expense_accident = $assoc_salary["salary_expense_accident"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_expense_accident"
                                                       name="salary_expense_accident"
                                                       placeholder="กรอก ค่าใช้จ่ายอุบัติเหตุ"
                                                       min="0"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_expense_accident ?>">
                                                <div id="alert_expense_accident"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">จำนวนวันลา : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_expense_leave"]) == true)
                                                $comma_expense_leave = str_replace('|', '', $assoc_salary["salary_expense_leave"]);
                                            else $comma_expense_leave = $assoc_salary["salary_expense_leave"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_expense_leave"
                                                       name="salary_expense_leave"
                                                       placeholder="กรอก จำนวนวันลา" min="0"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_expense_leave ?>">
                                                <div id="alert_expense_leave"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">จำนวนเงินงดจ่าย : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_expense_subtract"]) == true) {
                                                $comma_expense_subtract = str_replace('|', '', $assoc_salary["salary_expense_subtract"]);
                                            } else $comma_expense_subtract = $assoc_salary["salary_expense_subtract"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_expense_subtract"
                                                       name="salary_expense_subtract"
                                                       placeholder="กรอก จำนวนเงินงดจ่าย" readonly
                                                       autofocus="autofocus"
                                                       value="<?= $comma_expense_subtract ?>">
                                                <div id="alert_expense_subtract"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12"><br></div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ค่าเงินค้ำประกัน : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_expense_bail"]) == true) {
                                                $comma_salary_expense_bail = str_replace('|', '', $assoc_salary["salary_expense_bail"]);
                                            } else $comma_salary_expense_bail = $assoc_salary["salary_expense_bail"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_expense_bail"
                                                       name="salary_expense_bail"
                                                       placeholder="กรอก ค่าเงินค้ำประกัน" min="0"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_salary_expense_bail ?>">
                                                <div id="alert_expense_bail"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ค่าใช้จ่ายอื่นๆ : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_expense_other"]) == true) {
                                                $comma_expense_other = str_replace('|', '', $assoc_salary["salary_expense_other"]);
                                            } else $comma_expense_other = $assoc_salary["salary_expense_other"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_expense_other"
                                                       name="salary_expense_other"
                                                       placeholder="กรอก ค่าใช้จ่ายอื่นๆ" min="0"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_expense_other ?>">
                                                <div id="alert_expense_other"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">รวมรายการหักเงิน
                                                : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_expense_total"]) == true) {
                                                $comma_income_total = str_replace('|', '', $assoc_salary["salary_expense_total"]);
                                            } else $comma_income_total = $assoc_salary["salary_expense_total"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_expense_total"
                                                       name="salary_expense_total"
                                                       placeholder="กรอก รวมรายการหักเงิน" readonly
                                                       autofocus="autofocus"
                                                       value="<?= $comma_income_total ?>">
                                                <div id="alert_expense_total"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12"><br></div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ค่าประกันสังคม : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_expense_insurance"]) == true) {
                                                $comma_expense_insurance = str_replace('|', '', $assoc_salary["salary_expense_insurance"]);
                                            } else $comma_expense_insurance = $assoc_salary["salary_expense_insurance"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_expense_insurance"
                                                       name="salary_expense_insurance"
                                                       placeholder="กรอก ค่าประกันสังคม"
                                                       min="0"
                                                       onchange="salary_process();" maxlength="10"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_expense_insurance ?>">
                                                <div id="alert_expense_insurance"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ค่าภาษี : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_expense_tax"]) == true) {
                                                $comma_expense_tax = str_replace('|', '', $assoc_salary["salary_expense_tax"]);
                                            } else $comma_expense_tax = $assoc_salary["salary_expense_tax"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary_expense_tax"
                                                       name="salary_expense_tax"
                                                       placeholder="กรอก ค่าภาษี" min="0"
                                                       autofocus="autofocus"
                                                       value="<?= $comma_expense_tax ?>">
                                                <div id="alert_expense_tax"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">รายได้
                                                หลังหักค่าใช้จ่าย : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_income_sum"]) == true) {
                                                $comma_income_sum = str_replace('|', '', $assoc_salary["salary_income_sum"]);
                                            } else $comma_income_sum = $assoc_salary["salary_income_sum"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="salary_income_sum"
                                                       name="salary_income_sum"
                                                       placeholder="กรอก รายได้ หลังหักค่าใช้จ่าย" min="0"
                                                       autofocus="autofocus" readonly
                                                       value="<?= $comma_income_sum ?>">
                                                <div id="alert_income_sum"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12"><br></div>
                                    <h4 class="page-header">ข้อมูลเงือนเดือนสุทธิ</h4>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label " style="color:#f0ad4e;">รายได้สุทธิ
                                                : </label>
                                            <?php
                                            if (str_replace('|', '', $assoc_salary["salary_income_net"]) == true) {
                                                $comma_net = str_replace('|', '', $assoc_salary["salary_income_net"]);
                                            } else $comma_net = $assoc_salary["salary_income_net"];
                                            ?>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="salary_income_net"
                                                       name="salary_income_net"
                                                       placeholder="กรอก รายได้สุทธิ" min="0"
                                                       autofocus="autofocus" readonly
                                                       value="<?= $comma_net ?>">
                                                <div id="alert_income_net"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">เลขที่บัญชี : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="salary_account_id"
                                                       name="salary_account_id"
                                                       placeholder="กรอก เลขที่บัญชี"
                                                       onchange="salary_process();" maxlength="30"
                                                       autofocus="autofocus"
                                                       value="<?php
                                                       if (str_replace('|', '', $assoc_salary["salary_account_id"]) == true)
                                                           echo str_replace('|', '', $assoc_salary["salary_account_id"]);
                                                       else echo $assoc_salary["salary_account_id"];
                                                       ?>">
                                                <div id="alert_account_id"
                                                     style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- _______________________________________________________ Finish form edit detail of file salary _________________________________________________-->

                                    <div class="col-sm-12">
                                        <hr>
                                    </div>

                                    <div class="col-sm-12">
                                        <div style="float:right;">

                                            <button class="btn btn-warning" type="button" id="btn_process"
                                                    onclick="check_process();">
                                                <i class="fa fa-sm fa-repeat"></i> | คำนวณ
                                            </button>

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

    $("#btn_process").hide();

    function back_page() {
        window.location = 'index.php?mod=fn/form_view_salary&id=<?= $_GET['file_id'] ?>';
    }

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }

    $("#alert_prefix_eng").hide();
    var alert_prefix_eng = false;
    $("#alert_name_eng").hide();
    var alert_name_eng = false;
    $("#alert_surname_eng").hide();
    var alert_surname_eng = false;
    $("#alert_fullname_thai").hide();
    var alert_fullname_thai = false;
    $("#alert_payment").hide();
    var alert_payment = false;
    $("#alert_salary_position").hide();
    var alert_salary_position = false;
    $("#alert_salary_department").hide();
    var alert_salary_department = false;
    $("#alert_salary_section").hide();
    var alert_salary_section = false;
    $("#alert_salary_status").hide();
    var alert_salary_status = false;

    $("#alert_income_overtime_hours").hide();
    var alert_income_overtime_hours = false;

    $("#alert_account_id").hide();
    var alert_account_id = false;

    function salary_prefix_eng_edit() {
        var salary_prefix_eng = $("#salary_prefix_eng").val();
        var pattern = new RegExp(/^[a-zA-z.,]+$/);

        if (!salary_prefix_eng) {
            alert_prefix_eng = false;
            $("#alert_prefix_eng").hide();
        } else if (!pattern.test($("#salary_prefix_eng").val())) {
            alert_prefix_eng = true;
            $("#alert_prefix_eng").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z เท่านั้น");
            $("#salary_prefix_eng").focus();
        } else {
            alert_prefix_eng = false;
            $("#alert_prefix_eng").hide();
        }
    }

    function salary_name_eng_edit() {
        var salary_name_eng = $("#salary_name_eng").val();
        var pattern = new RegExp(/^[a-zA-Z]+$/);

        if (!salary_name_eng) {
            alert_name_eng = false;
            $("#alert_name_eng").hide();
        } else if (!pattern.test($("#salary_name_eng").val())) {
            alert_name_eng = true;
            $("#alert_name_eng").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z เท่านั้น");
            $("#salary_name_eng").focus();
        } else {
            alert_name_eng = false;
            $("#alert_name_eng").hide();
        }
    }

    function salary_surname_eng_edit() {
        var salary_surname_eng = $("#salary_surname_eng").val();
        var pattern = new RegExp(/^[A-Za-z]+$/);
        if (!salary_surname_eng) {
            alert_surname_eng = false;
            $("#alert_surname_eng").hide();
        } else if (!pattern.test($("#salary_surname_eng").val())) {
            alert_surname_eng = true;
            $("#alert_surname_eng").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z เท่านั้น");
            $("#salary_surname_eng").focus();
        } else {
            alert_surname_eng = false;
            $("#alert_surname_eng").hide();
        }
    }

    function salary_fullname_thai_edit() {
        var salary_fullname_thai = $("#salary_fullname_thai").val();
        var pattern = new RegExp(/^[ก-ฮะ-ๅ์่-๋็/, .ๆฯ()]+$/);
        if (!salary_fullname_thai) {
            alert_fullname_thai = true;
            $("#alert_fullname_thai").show().html("*กรุณากรอก ชื่อเต็ม ชื่อเล่นภาษาไทย");
            $("#salary_fullname_thai").focus();
        } else if (!pattern.test($("#salary_fullname_thai").val())) {
            alert_fullname_thai = true;
            $("#alert_fullname_thai").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ เท่านั้น");
            $("#salary_fullname_thai").focus();
        } else {
            alert_fullname_thai = false;
            $("#alert_fullname_thai").hide();
        }
    }

    function salary_payment_edit() {
        var salary_payment = $("#salary_payment").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ]+$/);
        if (!salary_payment) {
            alert_payment = false;
            $("#alert_payment").hide();
        } else if (!pattern.test($("#salary_payment").val())) {
            alert_payment = true;
            $("#alert_payment").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#salary_payment").focus();
        } else {
            alert_payment = false;
            $("#alert_payment").hide();
        }
    }

    function salary_position_edit() {
        var salary_position = $("#salary_position").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ]+$/);
        if (!salary_position) {
            alert_salary_position = false;
            $("#alert_salary_position").hide();
        } else if (!pattern.test($("#salary_position").val())) {
            alert_salary_position = true;
            $("#alert_salary_position").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#salary_position").focus();
        } else {
            alert_salary_position = false;
            $("#alert_salary_position").hide();
        }
    }

    function salary_department_edit() {
        var salary_department = $("#salary_department").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ]+$/);
        if (!salary_department) {
            alert_salary_department = false;
            $("#alert_salary_department").hide();
        } else if (!pattern.test($("#salary_department").val())) {
            alert_salary_department = true;
            $("#alert_salary_department").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#salary_department").focus();
        } else {
            alert_salary_department = false;
            $("#alert_salary_department").hide();
        }
    }

    function salary_section_edit() {
        var salary_section = $("#salary_section").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ]+$/);
        if (!salary_section) {
            alert_salary_section = true;
            $("#alert_salary_section").show().html("*กรุณากรอกส่วนงาน");
            $("#salary_section").focus();
        } else if (!pattern.test($("#salary_section").val())) {
            alert_salary_section = true;
            $("#alert_salary_section").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#salary_section").focus();
        } else {
            alert_salary_section = false;
            $("#alert_salary_section").hide();
        }
    }

    function salary_status_edit() {
        var salary_status = $("#salary_status").val();
        var pattern = new RegExp(/^[a-zA-Zก-ฮะ-ๅ์่-๋็/, .ๆฯ]+$/);
        if (!salary_status) {
            alert_salary_status = false;
            $("#alert_salary_status").hide();
        } else if (!pattern.test($("#salary_status").val())) {
            alert_salary_status = true;
            $("#alert_salary_status").show().html("*กรุณากรอกด้วยตัวอักษร A-Z, a-z, ก-ฮ เท่านั้น");
            $("#salary_department").focus();
        } else {
            alert_salary_status = false;
            $("#alert_salary_status").hide();
        }
    }

    function calIncome(rate, day) {
        var income = ((parseInt(rate) / 30) * parseInt(day));
        return Math.round(income);
    }

    function calIncome_holiday(rate, holiday) {
        var income_holiday = ((parseInt(rate) / 30) * parseInt(holiday));
        return Math.round(income_holiday);
    }

    function calIncome_ot(rate, hours, ot_status) {
        if (ot_status == "กรุณาเลือกประเภท OT" ) {
          var income_ot =0;
          return income_ot;
        }else if (ot_status == "ไม่มีโอที" ) {
          var income_ot =0;
          return Math.round(income_ot);
        }else if (ot_status == "ตามเงินเดือน" ) {
          var income_ot = ((parseInt(rate) / 30 / 8) * hours);
          return Math.round(income_ot);
        }else if (ot_status == "7 ชม. / 100 บ." ) {
          if(hours >= 7){
            var income_ot = (hours / 7) * 100;
            return Math.round(income_ot);
          }else{
            var income_ot = 0;
            return Math.round(income_ot);
          }
        }else if (ot_status == "1 ชม. / 30 บ." ) {
          var income_ot = (hours * 30);
          return Math.round(income_ot);
        }else {
          var income_ot = (hours * 25);
          return Math.round(income_ot);
        }
    }

    function calIncome_other(other, journey) {
        var income_other = (parseInt(other) + parseInt(journey));
        return Math.round(income_other);
    }

    function calIncome_total(othersum, overtime, holiday, commission, stock, position, income) {
        // alert("othersum : "+othersum+"overtime : "+overtime+"holiday : "+holiday+"commission : "+commission+"stock : "+stock+"position : "+position+"income : "+income);
        var income_total = (parseInt(othersum) + parseInt(overtime) + parseInt(holiday) + parseInt(commission) + parseInt(stock) + parseInt(position) + parseInt(income));
        return Math.round(income_total);
    }

    function calExpense_subtract(rate, leave) {
        var subtract = ((parseInt(rate) / 30) * parseFloat(leave));
        return Math.round(subtract);
    }

    function calSum_expense(expense_other, expense_bail, expense_subtract, expense_before, expense_late) {
        var sum_expense = (parseInt(expense_other) + parseInt(expense_bail) + parseInt(expense_subtract) + parseInt(expense_before) + parseInt(expense_late));
        return Math.round(sum_expense);
    }

    function calTruth_income(income, expense) {
        var truth_income = (parseInt(income) - parseInt(expense));
        return Math.round(truth_income);
    }

    function valTotal_income(truth_income, insurance, tax) {
        var net_income = (parseInt(truth_income) - (parseInt(insurance) + parseInt(tax)));
        return Math.round(net_income);
    }

    $(document).ready(function () {

        //_______________________ Process cal truth income
        $("#salary_income_rate,#salary_work_day").change(function () {
            var rate = $("#salary_income_rate").val();
            var day = $("#salary_work_day").val();
            $("#salary_income").val(calIncome(rate, day));
        });

        //_______________________ Process cal holiday
        $("#salary_income_rate,#salary_holiday").change(function () {
            var rate = $("#salary_income_rate").val();
            var holiday = $("#salary_holiday").val();
            $("#salary_income_holiday").val(calIncome_holiday(rate, holiday));
        });

        //_______________________ Process sum overtime
        $("#salary_income_overtime_hours,#salary_income_rate,#ot_status").change(function () {
            // alert(" coming cal ot!");
            var rate = $("#salary_income_rate").val();
            var hour = $("#salary_income_overtime_hours").val();
            var ot_status = $("#ot_status").val();
            var income_overtime = $("#salary_income_overtime").val();
            if (!parseInt(hour) == true && hour != 0) {
                // alert("if : "+hour);
                $("#salary_income_overtime").val(income_overtime);
            }
            else $("#salary_income_overtime").val(calIncome_ot(rate, hour, ot_status));
        });

        //_______________________ Process sum other income
        $("#salary_income_other,#salary_income_journey").change(function () {
            var income_other = $("#salary_income_other").val();
            var income_journey = $("#salary_income_journey").val();
            if (income_other && income_journey)
                $("#salary_income_othersum").val(calIncome_other(income_other, income_journey));
            else if (income_journey && !income_other)
                $("#salary_income_othersum").val(income_journey);
            else if (income_other && !income_journey)
                $("#salary_income_othersum").val(income_other);
        });

        //_______________________ Process sum income
        $("#salary_income_rate,#salary_work_day,#salary_income_overtime_hours,#salary_income_other,#salary_income_journey,#salary_income_othersum,#salary_income_overtime,#salary_income_holiday,#salary_income_commission,#salary_commission_stock,#salary_income_position,#salary_income").change(function () {
            var rate = $("#salary_income_rate").val();
            var day = $("#salary_work_day").val();
            var hour = $("#salary_income_overtime_hours").val();
            var other = $("#salary_income_other").val();
            var journey = $("#salary_income_journey").val();

            var othersum = $("#salary_income_othersum").val();
            var overtime = $("#salary_income_overtime").val();
            var holiday = $("#salary_income_holiday").val();
            var commission = $("#salary_income_commission").val();
            var stock = $("#salary_commission_stock").val();
            var position = $("#salary_income_position").val();
            var income = $("#salary_income").val();

            if (rate || day || hour || other || journey || othersum || overtime || holiday || commission || stock || position || income) {
                if (othersum == "") othersum = 0;
                if (overtime == "") overtime = 0;
                if (holiday == "") holiday = 0;
                if (commission == "") commission = 0;
                if (stock == "") stock = 0;
                if (position == "") position = 0;
                if (income == "") income = 0;
                $("#salary_income_total").val(calIncome_total(othersum, overtime, holiday, commission, stock, position, income));
            }
        });

        //_______________________ Process sub subtract
        $("#salary_expense_leave,#salary_income_rate").change(function () {
            var rate = $("#salary_income_rate").val();
            var leave = $("#salary_expense_leave").val();
            $("#salary_expense_subtract").val(calExpense_subtract(rate, leave));
        });

        //_______________________ Process sum expense
        $("#salary_expense_other,#salary_expense_bail,#salary_expense_subtract,#salary_expense_before,#salary_expense_late,#salary_income_rate,#salary_expense_leave").change(function () {

            var expense_other = $("#salary_expense_other").val();
            var expense_bail = $("#salary_expense_bail").val();
            var expense_subtract = $("#salary_expense_subtract").val();
            var expense_before = $("#salary_expense_before").val();
            var expense_late = $("#salary_expense_late").val();

            if (expense_other == "") expense_other = 0;
            if (expense_bail == "") expense_bail = 0;
            if (expense_subtract == "") expense_subtract = 0;
            if (expense_before == "") expense_before = 0;
            if (expense_late == "") expense_late = 0;

            // alert(" expense_other : "+expense_other+" expense_bail : "+expense_bail+" expense_subtract : "+expense_subtract+" expense_before : "+expense_before+" expense_late : "+expense_late);
            $("#salary_expense_total").val(calSum_expense(expense_other, expense_bail, expense_subtract, expense_before, expense_late));
        });

        //_______________________ Process cal truth income
        $("#salary_expense_total,#salary_income_total,#salary_expense_other,#salary_expense_bail,#salary_expense_subtract,#salary_expense_before,#salary_expense_late,#salary_income_rate,#salary_expense_leave,#salary_income_rate,#salary_work_day,#salary_income_overtime_hours,#salary_income_other,#salary_income_journey,#salary_income_othersum,#salary_income_overtime,#salary_income_holiday,#salary_income_commission,#salary_commission_stock,#salary_income_position,#salary_income").change(function () {

            var expense_total = $("#salary_expense_total").val();
            var income_total = $("#salary_income_total").val();
            // alert("expense_total : " + income_total + " expense_total : " + expense_total);
            $("#salary_income_sum").val(calTruth_income(income_total, expense_total));
        });

        //_______________________ Process cal total salary
        $("#salary_expense_total,#salary_income_total,#salary_expense_other,#salary_expense_bail,#salary_expense_subtract,#salary_expense_before,#salary_expense_late,#salary_income_rate,#salary_expense_leave,#salary_income_rate,#salary_work_day,#salary_income_overtime_hours,#salary_income_other,#salary_income_journey,#salary_income_othersum,#salary_income_overtime,#salary_income_holiday,#salary_income_commission,#salary_commission_stock,#salary_income_position,#salary_income,#salary_expense_insurance,#salary_expense_tax").change(function () {
            // alert("coming !");
            var tax = $("#salary_expense_tax").val();
            var insurance = $("#salary_expense_insurance").val();
            var truth_income = $("#salary_income_sum").val();
            if (tax == "") tax = 0;
            if (insurance == "") insurance = 0;
            if (truth_income == "") truth_income = 0;
            $("#salary_income_net").val(valTotal_income(truth_income, insurance, tax));
        });


    });


    /* __________________________Start process calculate salary__________________________ */
    function salary_process() {
        var pattern = new RegExp(/^[0-9, .-]+$/);
        var pattern1 = new RegExp(/^[0-9ก-ฮะ-ๅ์่-๋็/, .ๆฯ]+$/);

        var salary_income_overtime_hours = $("#salary_income_overtime_hours").val();
        if (!salary_income_overtime_hours) {
            alert_income_overtime_hours = false;
            $("#alert_income_overtime_hours").hide();
        } else if (!pattern1.test($("#salary_income_overtime_hours").val())) {
            alert_income_overtime_hours = true;
            $("#alert_income_overtime_hours").show().html("*กรุณากรอกด้วยตัวอักษร ก-ฮ, 0-9 เท่านั้น");
            $("#salary_income_overtime_hours").focus();
        } else {
            alert_income_overtime_hours = false;
            $("#alert_income_overtime_hours").hide();
        }

        var salary_account_id = $("#salary_account_id").val();
        if (!salary_account_id) {
            alert_account_id = false;
            $("#alert_account_id").hide();
        } else if (!pattern.test($("#salary_account_id").val())) {
            alert_account_id = true;
            $("#alert_account_id").show().html("*กรุณากรอกด้วยตัวเลข 0-9 เท่านั้น");
            $("#salary_account_id").focus();
        } else {
            alert_account_id = false;
            $("#alert_account_id").hide();
        }

    }

    /* __________________________Finish process calculate salary__________________________ */

    $("#form_edit_salary").submit(function () {

        alert_prefix_eng = false;
        alert_name_eng = false;
        alert_surname_eng = false;
        alert_fullname_thai = false;
        alert_payment = false;
        alert_salary_position = false;
        alert_salary_department = false;
        alert_salary_section = false;
        alert_salary_status = false;

        alert_income_overtime_hours = false;
        alert_account_id = false;

        salary_prefix_eng_edit();
        salary_name_eng_edit();
        salary_surname_eng_edit();
        salary_fullname_thai_edit();
        salary_payment_edit();
        // salary_position_edit();
        salary_department_edit();
        salary_section_edit();
        salary_status_edit();

        salary_process();

        if (alert_prefix_eng == false &&
            alert_name_eng == false &&
            alert_surname_eng == false &&
            alert_fullname_thai == false &&
            alert_payment == false &&
            alert_salary_position == false &&
            alert_salary_department == false &&
            alert_salary_section == false &&
            alert_salary_status == false &&
            alert_income_overtime_hours == false &&
            alert_account_id == false
        ) return true;
        else return false;
    });

</script>



