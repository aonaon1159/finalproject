<?php
/**
 * Created by PhpStorm.
 * User: Avaibooking
 * Date: 2/19/2018
 * Time: 4:44 PM
 */
if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");
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
                    <i class="fa fa-money"></i> ข้อมูลเงินเดือน.
                    <div class="pull-right">
                        <div class="btn-group">

                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-9" style="padding-bottom:5px;">
                            <button class="btn btn-default" type="button"
                                    id="btn_nextpage"
                                    class="btn btn-default"
                                    onclick="window.location='index.php?mod=fn/form_view_salary&id=<?= $_GET['file_id'] ?>'">
                                <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                            </button>
                        </div>
                        <div class="col-sm-3" style="padding:10px 15px 5px 0; text-align:right;"></div>
                        <div class="container">
                            <?php
                            $i = 1;
                            $sql_select_income = "
                              SELECT * FROM fn_salary WHERE file_id='{$_GET["file_id"]}' AND salary_id='{$_GET["salary_id"]}'
                            ";
                            $query_salary_income = mysqli_query($conn, $sql_select_income);
                            $num_salary_income = mysqli_num_rows($query_salary_income);
                            $assoc_salary = mysqli_fetch_assoc($query_salary_income);




                            
                            ?>
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
                                        <table style="width:100%;">
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" id="person_id"
                                                           name="person_id" placeholder="รหัสพนักงาน"
                                                           maxlength="5" disabled autofocus="autofocus"
                                                           value="<?= $assoc_salary["person_id"] ?>">
                                                </td>
                                                <td style="width:20px;"></td>
                                                <td>
                                                    <button id="information_person" name="information_person" class="btn btn-info btn-sm"
                                                            onclick="window.location.href='index.php?mod=hr/form_view_person&id=<?=$assoc_salary["person_id"]?>'">
                                                        <i class="fa fa-sm fa fa-search"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>


                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label ">ชื่อเต็ม thai : </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="salary_fullname_thai"
                                               name="salary_fullname_thai"
                                               placeholder="กรอก ชื่อเต็ม (Thai)"
                                               onkeyup="return salary_fullname_thai();" maxlength="120"
                                               autofocus="autofocus" disabled
                                               value="<?= $assoc_salary["salary_fullname_thai"] ?>">
                                        <div id="alert_fullname_thai"
                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label">ประเภทการจ่ายเงิน : </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="salary_payment"
                                               name="salary_payment"
                                               placeholder="กรอก ประเภทการจ่ายเงิน"
                                               onkeyup="return salary_payment();" maxlength="30"
                                               autofocus="autofocus" disabled
                                               value="<?php 
                                               if ($assoc_salary["salary_payment"] == 0) { echo "กรุณาเลือกประเภทการจ่ายเงิน"; }
                                               if ($assoc_salary["salary_payment"] == 1) { echo "DAILY"; }
                                               if ($assoc_salary["salary_payment"] == 2) { echo "MONTHLY"; } ?>">
                                        <div id="alert_salary_payment"
                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label ">ตำแหน่ง : </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="salary_position"
                                               name="salary_position"
                                               placeholder="กรอก ตำแหน่ง"
                                               onkeyup="return salary_position();" maxlength="30"
                                               autofocus="autofocus" disabled
                                               value="<?php
                                               if ($assoc_salary["salary_position"] == 0) { echo "กรุณาเลือกตำแหน่งงาน"; }
                                               if ($assoc_salary["salary_position"] == 1) { echo "GM. / HRM. / QMR. "; }
                                               if ($assoc_salary["salary_position"] == 2) { echo "MANAGER"; }
                                               if ($assoc_salary["salary_position"] == 3) { echo "OFFICER"; }
                                               if ($assoc_salary["salary_position"] == 4) { echo "OPERATOR"; } ?>">
                                        <div id="alert_salary_position"
                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label">แผนก : </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="salary_department"
                                               name="salary_department"
                                               placeholder="กรอก แผนก"
                                               onkeyup="return salary_department();" maxlength="50"
                                               autofocus="autofocus" disabled
                                               value="<?php 
                                               if ($assoc_salary["salary_department"] == 0) { echo "กรุณาเลือกแผนกงาน"; }
                                               if ($assoc_salary["salary_department"] == 1) { echo "ADMIN"; }
                                               if ($assoc_salary["salary_department"] == 2) { echo "ACCOUNT"; }
                                               if ($assoc_salary["salary_department"] == 3) { echo "IT"; }
                                               if ($assoc_salary["salary_department"] == 4) { echo "PROGRAMMER"; } ?>">
                                        <div id="alert_salary_department"
                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label ">ส่วนงาน : </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="salary_section"
                                               name="salary_section"
                                               placeholder="กรอก ส่วนงาน"
                                               onkeyup="return salary_section();" maxlength="50"
                                               autofocus="autofocus" disabled
                                               value="<?php 
                                               if ($assoc_salary["salary_section"] == 0) { echo "กรุณาเลือกส่วนงาน"; }
                                               if ($assoc_salary["salary_section"] == 1) { echo "ช้างเผือก"; }
                                               if ($assoc_salary["salary_section"] == 2) { echo "พร้าว"; }
                                               if ($assoc_salary["salary_section"] == 3) { echo "อาเขต"; }
                                               if ($assoc_salary["salary_section"] == 4) { echo "แม่มาลัย"; }
                                               if ($assoc_salary["salary_section"] == 5) { echo "ปาย"; }
                                               if ($assoc_salary["salary_section"] == 6) { echo "ปางมะผ้า"; }
                                               if ($assoc_salary["salary_section"] == 7) { echo "แม่ฮ่องสอน"; }
                                               if ($assoc_salary["salary_section"] == 8) { echo "ฮอด"; }
                                               if ($assoc_salary["salary_section"] == 9) { echo "แม่สะเรียง"; }
                                               if ($assoc_salary["salary_section"] == 10) { echo "แม่ลาน้อย"; }
                                               if ($assoc_salary["salary_section"] == 11) { echo "ขุนยวม"; }
                                               if ($assoc_salary["salary_section"] == 12) { echo "ออฟฟิศเปรมประชา"; }
                                               if ($assoc_salary["salary_section"] == 13) { echo "ออฟฟิศเอเวีย"; } ?>">

                                        <div id="alert_salary_section"
                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label">สถานะ : </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="salary_status"
                                               name="salary_status"
                                               placeholder="กรอก สถานะ"
                                               onkeyup="return salary_status();" maxlength="30"
                                               autofocus="autofocus" disabled
                                               value="<?php 
                                               if ($assoc_salary["salary_status"] == 0 ) { echo "กรุณาเลือกสถานะ"; }
                                               if ($assoc_salary["salary_status"] == 1 ) { echo "รายวัน"; }
                                               if ($assoc_salary["salary_status"] == 2 ) { echo "รายเดือน"; } ?>">
                                        <div id="alert_salary_status"
                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-11"><h4 class="page-header">รายได้หลัก</h4>
                                            </div>
                                            <div class="form-group col-sm-1"></div>

                                            <table class="table table-bordered">

                                                <thead>
                                                <tr class="bg-primary">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">รายการ</th>
                                                    <th class="text-center">จำนวนเงิน</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>ค่าจ้าง/เงินเดือน</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income_rate"] == "") echo 0;
                                                        else {
                                                            $string_salary_income_rate = str_replace('|', '', $assoc_salary["salary_income_rate"]);
                                                            $tmp_salary_income_rate = str_replace(',', '', $string_salary_income_rate);
                                                            echo number_format($tmp_salary_income_rate, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                </tbody>

                                                <tbody>
                                                <tr>
                                                    <td>2</td>
                                                    <td>จำนวนวันที่ทำงาน</td>
                                                    <td style="text-align:right;">
                                                        <div style="float:left; width:10%">
                                                            <button id="information_person" name="information_person" class="btn btn-default btn-xs"
                                                                    onclick="window.location.href='index.php?mod=fn/form_view_person&id=<?=$assoc_salary["person_id"]?>'">
                                                                <i class="fa fa-file-text"></i>
                                                            </button>
                                                        </div>
                                                        <div style="float:right;">
                                                            <?php
                                                            if ($assoc_salary["salary_work_day"] == "") echo 0;
                                                            else {
                                                                $string_salary_work_day = str_replace('|', '', $assoc_salary["salary_work_day"]);
                                                                $tmp_salary_work_day = str_replace(',', '', $string_salary_work_day);
                                                                echo number_format($tmp_salary_work_day, 0, '.', ',') . " วัน";
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                <tbody>
                                                <tr>
                                                    <td>3</td>
                                                    <td>รวมค่าจ้าง</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income"] == "") echo 0;
                                                        else {
                                                            $string_salary_income = str_replace('|', '', $assoc_salary["salary_income"]);
                                                            $tmp_salary_income = str_replace(',', '', $string_salary_income);
                                                            echo number_format($tmp_salary_income, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>ค่าประจำตำแหน่ง</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income_position"] == "") echo 0;
                                                        else {
                                                            $string_salary_income_position = str_replace('|', '', $assoc_salary["salary_income_position"]);
                                                            $tmp_salary_income_position = str_replace(',', '', $string_salary_income_position);
                                                            echo number_format($tmp_salary_income_position, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>รวมค่าคอม</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income_commission"] == "") echo 0;
                                                        else {
                                                            $string_salary_income_commission = str_replace('|', '', $assoc_salary["salary_income_commission"]);
                                                            $tmp_salary_income_commission = str_replace(',', '', $string_salary_income_commission);
                                                            echo number_format($tmp_salary_income_commission, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>ค่าคอม รับฝากพัสดุ</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_commission_stock"] == "") echo 0;
                                                        else {
                                                            $string_salary_commission_stock = str_replace('|', '', $assoc_salary["salary_commission_stock"]);
                                                            $tmp_salary_commission_stock = str_replace(',', '', $string_salary_commission_stock);
                                                            echo number_format($tmp_salary_commission_stock, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>จำนวน วันทำงานในวันหยุด</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_holiday"] == "") echo 0;
                                                        else {
                                                            $string_salary_holiday = str_replace('|', '', $assoc_salary["salary_holiday"]);
                                                            $tmp_salary_holiday = str_replace(',', '', $string_salary_holiday);
                                                            echo number_format($tmp_salary_holiday, 0, '.', ',') . " วัน";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>จำนวนเงิน วันทำงานในวันหยุด</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income_holiday"] == "") echo 0;
                                                        else {
                                                            $string_salary_income_holiday = str_replace('|', '', $assoc_salary["salary_income_holiday"]);
                                                            $tmp_salary_income_holiday = str_replace(',', '', $string_salary_income_holiday);
                                                            echo number_format($tmp_salary_income_holiday, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>จำนวน ชั่วโมง ot</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if (!is_numeric($assoc_salary["salary_income_overtime_hours"]))
                                                            echo 0;
                                                        else {
                                                            $string_salary_income_overtime_hours = str_replace('|', '', $assoc_salary["salary_income_overtime_hours"]);
                                                            $tmp_salary_income_overtime_hours = str_replace(',', '', $string_salary_income_overtime_hours);
                                                            echo number_format($tmp_salary_income_overtime_hours, 0, '.', ',') . " ชั่วโมง";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>จำนวนเงิน ot</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income_overtime"] == "") echo 0;
                                                        else {
                                                            $string_salary_income_overtime = str_replace('|', '', $assoc_salary["salary_income_overtime"]);
                                                            $tmp_salary_income_overtime = str_replace(',', '', $string_salary_income_overtime);
                                                            echo number_format($tmp_salary_income_overtime, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>11</td>
                                                    <td>รายได้ การเดินทางต่างจังหวัด</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income_journey"] == "") echo 0;
                                                        else {
                                                            $string_salary_income_journey = str_replace('|', '', $assoc_salary["salary_income_journey"]);
                                                            $tmp_salary_income_journey = str_replace(',', '', $string_salary_income_journey);
                                                            echo number_format($tmp_salary_income_journey, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>12</td>
                                                    <td>รายได้อื่นๆ</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income_other"] == "") echo 0;
                                                        else {
                                                            $string_salary_income_other = str_replace('|', '', $assoc_salary["salary_income_other"]);
                                                            $tmp_salary_income_other = str_replace(',', '', $string_salary_income_other);
                                                            echo number_format($tmp_salary_income_other, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>13</td>
                                                    <td>รวม รายได้อื่นๆ</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income_othersum"] == "") echo 0;
                                                        else {
                                                            $string_salary_income_othersum = str_replace('|', '', $assoc_salary["salary_income_othersum"]);
                                                            $tmp_salary_income_othersum = str_replace(',', '', $string_salary_income_othersum);
                                                            echo number_format($tmp_salary_income_othersum, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>14</td>
                                                    <td>โบนัส</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income_bonus"] == "") echo 0;
                                                        else {
                                                            $string_salary_income_bonus = str_replace('|', '', $assoc_salary["salary_income_bonus"]);
                                                            $tmp_salary_income_bonus = str_replace(',', '', $string_salary_income_bonus);
                                                            echo number_format($tmp_salary_income_bonus, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>15</td>
                                                    <td>โบนัสประจำปี</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_income_bonusyear"] == "") echo 0;
                                                        else {
                                                            $string_salary_income_bonusyear = str_replace('|', '', $assoc_salary["salary_income_bonusyear"]);
                                                            $tmp_salary_income_bonusyear = str_replace(',', '', $string_salary_income_bonusyear);
                                                            echo number_format($tmp_salary_income_bonusyear, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>16</td>
                                                    <td>รวมรายได้ทั้งหมด</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if (($assoc_salary["salary_income_total"]) == "") echo 0;
                                                        else {
                                                            $string_salary_income_total = str_replace('|', '', $assoc_salary["salary_income_total"]);
                                                            $tmp_salary_income_total = str_replace(',', '', $string_salary_income_total);
                                                            echo number_format($tmp_salary_income_total, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <?php 
                                //
                                $sql_select_calculate_date = "SELECT calculate_pay,calculate_no_cut,calculate_cut_pay,calculate_work_on_holiday FROM fn_calculate_date WHERE scanfile_id = '{$_GET["file_id"]}' AND person_id = '{$assoc_salary["person_id"]}'";
                                $query_sql_select_calculate_date = mysqli_query($conn ,$sql_select_calculate_date);
                                list($calculate_pay,$calculate_no_cut,$calculate_cut_pay,$calculate_work_on_holiday) = mysqli_fetch_row($query_sql_select_calculate_date);

                                
                                ?>
                                <div class="form-group col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-11"><h4 class="page-header">รายการหัก</h4>
                                            </div>
                                            <div class="form-group col-sm-1"></div>
                                            <table class="table table-bordered">
                                                <?php
                                                $i = 1;
                                                $sql_select_income = "
                                                  SELECT * FROM fn_salary WHERE file_id='{$_GET["file_id"]}' AND salary_id='{$_GET["salary_id"]}'
                                                ";
                                                $query_salary_income = mysqli_query($conn, $sql_select_income);
                                                $num_salary_income = mysqli_num_rows($query_salary_income);

                                                $assoc_salary = mysqli_fetch_assoc($query_salary_income);
                                                ?>
                                                <thead>
                                                <tr class="bg-danger">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">รายการ</th>
                                                    <th class="text-center">จำนวนเงิน</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>ค่าใช้จ่าย หักมาสาย</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_expense_late"] == "") echo 0;
                                                        else {
                                                            $string_salary_expense_late = str_replace('|', '', $assoc_salary["salary_expense_late"]);
                                                            $tmp_salary_expense_late = str_replace(',', '', $string_salary_expense_late);
                                                            echo number_format($tmp_salary_expense_late, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>ค่าใช้จ่าย เงินเบิกล่วงหน้า</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_expense_before"] == "") echo 0;
                                                        else {
                                                            $string_salary_expense_before = str_replace('|', '', $assoc_salary["salary_expense_before"]);
                                                            $tmp_salary_expense_before = str_replace(',', '', $string_salary_expense_before);
                                                            echo number_format($tmp_salary_expense_before, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>ค่าใช้จ่ายอุบัติเหตุ</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_expense_accident"] == "") echo 0;
                                                        else {
                                                            $string_salary_expense_accident = str_replace('|', '', $assoc_salary["salary_expense_before"]);
                                                            $tmp_salary_expense_accident = str_replace(',', '', $string_salary_expense_accident);
                                                            echo number_format($tmp_salary_expense_accident, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>4</td>
                                                    <td>จำนวนวันลา</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_expense_leave"] == "") echo 0;
                                                        else {
                                                            $string_salary_expense_leave = str_replace('|', '', $assoc_salary["salary_expense_leave"]);
                                                            $tmp_salary_expense_leave = str_replace(',', '', $string_salary_expense_leave);
                                                            echo number_format($tmp_salary_expense_leave, 0, '.', ',') . " วัน";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>



                                                                                                                                                                <tr>




                                                <tr>
                                                    <td>5</td>
                                                    <td>จำนวนเงินงดจ่าย</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_expense_subtract"] == "") echo 0;
                                                        else {
                                                            $string_salary_expense_subtract = str_replace('|', '', $assoc_salary["salary_expense_subtract"]);
                                                            $tmp_salary_expense_subtract = str_replace(',', '', $string_salary_expense_subtract);
                                                            echo number_format($tmp_salary_expense_subtract, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>ค่าเงินค้ำประกัน</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_expense_bail"] == "") echo 0;
                                                        else {
                                                            $string_salary_expense_bail = str_replace('|', '', $assoc_salary["salary_expense_bail"]);
                                                            $tmp_salary_expense_bail = str_replace(',', '', $string_salary_expense_bail);
                                                            echo number_format($tmp_salary_expense_bail, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>ค่าใช้จ่ายอื่นๆ</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_expense_other"] == "") echo 0;
                                                        else {
                                                            $string_salary_expense_other = str_replace('|', '', $assoc_salary["salary_expense_other"]);
                                                            $tmp_salary_expense_other = str_replace(',', '', $string_salary_expense_other);
                                                            echo number_format($tmp_salary_expense_other, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>8</td>
                                                    <td>ค่าประกันสังคม</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_expense_insurance"] == "") echo 0;
                                                        else {
                                                            $string_salary_expense_insurance = str_replace('|', '', $assoc_salary["salary_expense_insurance"]);
                                                            $tmp_salary_expense_insurance = str_replace(',', '', $string_salary_expense_insurance);
                                                            echo number_format($tmp_salary_expense_insurance, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>ค่าภาษี</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_expense_tax"] == "") echo 0;
                                                        else {
                                                            $string_salary_expense_tax = str_replace('|', '', $assoc_salary["salary_expense_tax"]);
                                                            $tmp_salary_expense_tax = str_replace(',', '', $string_salary_expense_tax);
                                                            echo number_format($tmp_salary_expense_tax, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>รวมรายการหักเงิน ทั้งหมด</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if ($assoc_salary["salary_expense_total"] == "") echo 0;
                                                        else {
                                                            $string_salary_expense_total = str_replace('|', '', $assoc_salary["salary_expense_total"]);
                                                            $tmp_salary_expense_total = str_replace(',', '', $string_salary_expense_total);

                                                            $tmp_salary_expense_total = ($tmp_salary_expense_total + $tmp_salary_expense_insurance + $tmp_salary_expense_tax);
                                                            echo number_format($tmp_salary_expense_total, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="form-group col-sm-11"><h4 class="page-header">
                                                    เงินเดือนสุทธิ</h4></div>
                                            <div class="form-group col-sm-1"></div>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr class="bg-success">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">รายการ</th>
                                                    <th class="text-center">จำนวนเงิน</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>รายได้สุทธิ</td>
                                                    <td style="text-align:right;">
                                                        <?php
                                                        if (($assoc_salary["salary_income_net"]) == "") echo 0;
                                                        else {
                                                            $string_salary_income_net = str_replace('|', '', $assoc_salary["salary_income_net"]);
                                                            $tmp_salary_income_net = str_replace(',', '', $string_salary_income_net);
                                                            echo number_format($tmp_salary_income_net, 2, '.', ',') . " บาท";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-warning">
                                            <th class="text-center">scanfile_id</th>
                                            <th class="text-center">person_id</th>
                                            <th class="text-center">จำนวนวันที่จ่ายเงิน</th>
                                            <th class="text-center">จำนวนวันที่ไม่หักเงิน</th>
                                            <th class="text-center">จำนวนวันที่หักเงิน</th>
                                            <th class="text-center">จำนวนวันทำงานในวันหยุด</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="text-center">
                                            <?php echo $_GET["file_id"] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $assoc_salary["person_id"] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $calculate_pay ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $calculate_no_cut ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $calculate_cut_pay ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $calculate_work_on_holiday ?>
                                        </td>
                                    </tbody>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

    });

</script>


