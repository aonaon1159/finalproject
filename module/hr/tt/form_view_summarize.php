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
                    <i class="fa fa-money"></i> สรุปข้อมูลเงินเดือน.
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
                                    onclick="window.location='index.php?mod=fn/form_view_salary&id=<?= $_GET['id'] ?>'">
                                <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                            </button>
                        </div>
                        <div class="col-sm-3" style="padding:10px 15px 5px 0; text-align:right;"></div>
                        <div class="container">

                            <div class="col-sm-12">
                                <div class="form-group col-sm-12">
                                    <label class="col-sm-2 control-label">บริษัท : </label>
                                    <div class="col-sm-10">
                                        <select id="company" name="company" class="form-control"
                                                autofocus="autofocus" onchange="check_company();" disabled>
                                            <option value="0">- กรุณาเลือกบริษัท -</option>
                                            <?php
                                            $sql_select_file = "SELECT * FROM fn_salary_file WHERE file_id='{$_GET["id"]}'";
                                            $query_file = mysqli_query($conn, $sql_select_file);
                                            $assoc_file = mysqli_fetch_assoc($query_file);

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
                                <div class="form-group col-sm-12">
                                    <label class="col-sm-2 control-label ">หัวข้อ : </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="salary_title"
                                               name="salary_title"
                                               placeholder="หัวข้อ ตารางเงินเดือน"
                                               onkeyup="return check_title();" maxlength="200"
                                               autofocus="autofocus" value="<?= $assoc_file["file_title"] ?>" disabled>
                                        <div id="alert_salary_title"
                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <div class="form-group col-sm-11"><h4 class="page-header">รวมรายได้พนักงาน</h4>
                                    </div>
                                    <div class="form-group col-sm-1"></div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered">
                                                <?php
                                                $i = 1;
                                                $sql_select_salary_detail = "
                                                  SELECT * FROM fn_salary_detail WHERE file_id='{$_GET["id"]}'
                                                ";
                                                $query_salary_detail = mysqli_query($conn, $sql_select_salary_detail);
                                                $num_salary = mysqli_num_rows($query_salary_detail);

                                                $count = 1;
                                                $assoc_salary_detail = mysqli_fetch_assoc($query_salary_detail);
                                                ?>
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
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_rate"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                </tbody>

                                                <tbody>
                                                <tr>
                                                    <td>2</td>
                                                    <td>จำนวนวันที่ทำงาน</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_work_day"], 0, '.', ','); ?><?php echo " วัน" ?></td>
                                                </tr>
                                                </tbody>
                                                <tbody>
                                                <tr>
                                                    <td>3</td>
                                                    <td>รวมค่าจ้าง</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income"], 2, '.', ','); ?><?php echo " บาท" ?></td>

                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>ค่าประจำตำแหน่ง</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_position"], 2, '.', ','); ?><?php echo " บาท" ?></td>

                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>รวมค่าคอม</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_commission"], 2, '.', ','); ?><?php echo " บาท" ?></td>

                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>ค่าคอม รับฝากพัสดุ</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_commission_stock"], 2, '.', ','); ?><?php echo " บาท" ?></td>

                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>จำนวน วันทำงานในวันหยุด</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_holiday"], 0, '.', ','); ?><?php echo " วัน" ?></td>

                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>จำนวนเงิน วันทำงานในวันหยุด</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_holiday"], 2, '.', ','); ?><?php echo " บาท" ?></td>

                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>จำนวน ชั่วโมง ot</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_overtime_hours"], 0, '.', ','); ?><?php echo " ชั่วโมง" ?></td>

                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>จำนวนเงิน ot</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_overtime"], 2, '.', ','); ?><?php echo " บาท" ?></td>

                                                </tr>
                                                <tr>
                                                    <td>11</td>
                                                    <td>รายได้ การเดินทางต่างจังหวัด</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_journey"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>12</td>
                                                    <td>รายได้อื่นๆ</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_other"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>13</td>
                                                    <td>รวม รายได้อื่นๆ</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_othersum"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>14</td>
                                                    <td>โบนัส</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_bonus"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>15</td>
                                                    <td>โบนัสประจำปี</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_bonusyear"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>16</td>
                                                    <td>รวมรายได้ทั้งหมด</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_total"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-11"><h4 class="page-header">รวมรายการหัก</h4>
                                            </div>
                                            <div class="form-group col-sm-1"></div>
                                            <table class="table table-bordered">

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
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_expense_late"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>ค่าใช้จ่าย เงินเบิกล่วงหน้า</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_expense_before"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>ค่าใช้จ่ายอุบัติเหตุ</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_expense_accident"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>

                                                <tr>
                                                    <td>4</td>
                                                    <td>จำนวนวันลา</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_expense_leave"], 0, '.', ','); ?><?php echo " วัน" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>จำนวนเงินงดจ่าย</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_expense_subtract"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>ค่าเงินค้ำประกัน</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_expense_bail"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>ค่าใช้จ่ายอื่นๆ</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_expense_other"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>

                                                <tr>
                                                    <td>8</td>
                                                    <td>ค่าประกันสังคม</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_expense_insurance"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>ค่าภาษี</td>
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_expense_tax"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>รวมรายการหักเงิน ทั้งหมด</td>
                                                    <td style="text-align:right;"><?= number_format(($assoc_salary_detail["sum_expense_total"]), 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="form-group col-sm-11"><h4 class="page-header">
                                                    รวมเงินเดือนสุทธิ</h4></div>
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
                                                    <td style="text-align:right;"><?= number_format($assoc_salary_detail["sum_income_net"], 2, '.', ','); ?><?php echo " บาท" ?></td>
                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

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


