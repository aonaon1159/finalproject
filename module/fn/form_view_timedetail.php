<?php
if (isset($_GET['id'])){
include("inc/check_page.php");
include("inc/topnav.php");
$sql_select_person = "SELECT * FROM hr_person WHERE deleted = 0 AND person_id = {$_GET['id']}";
$query_select_person = mysqli_query($conn,$sql_select_person);
$person = mysqli_fetch_array($query_select_person);
$sql_select_department = "SELECT * FROM hr_person_employment WHERE person_id = {$_GET['id']}";
$query_select_department = mysqli_query($conn,$sql_select_department);
$department = mysqli_fetch_array($query_select_department);
}
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
                    <i class="fa fa-clock-o"></i> จัดการข้อมูลเวลาทำงาน.
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
                            onclick="window.location='?mod=fn/form_view_time'">
                            <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                        </button>
                    </div>
                    <div class="col-sm-3" style="padding:10px 15px 5px 0; text-align:right;"></div>
                    <div class="container">

                        <h4 class="page-header">ข้อมูลส่วนตัว</h4>
                        <div class="col-sm-12">
                            <div class="form-group col-sm-6">
                                <?php 
                                $sql_department = mysqli_query($conn, "SELECT department_name FROM hr_person_department WHERE department_id = $department[2]");
                                $departmented = mysqli_fetch_assoc($sql_department);?>
                                <label class="col-sm-4 control-label ">แผนก : </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="salary_position"
                                    name="salary_position"
                                    placeholder="กรอก ตำแหน่ง"
                                    autofocus="autofocus" disabled
                                    value="<?= $departmented["department_name"] ?>">
                                    <div id="alert_salary_position"
                                    style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <?php 
                                $sql_department = mysqli_query($conn, "SELECT position_name FROM hr_person_position WHERE position_id = $department[3]");
                                $departmented = mysqli_fetch_assoc($sql_department);?>
                                <label class="col-sm-4 control-label">ตำแหน่ง : </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="salary_payment"
                                    name="salary_payment"
                                    placeholder="กรอก ประเภทการจ่ายเงิน"
                                    autofocus="autofocus" disabled
                                    value="<?= $departmented['position_name'] ?>">
                                    <div id="alert_salary_payment"
                                    style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group col-sm-6">
                                <label class="col-sm-4 control-label ">รหัสพนักงาน : </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="person_id"
                                    name="person_id"
                                    placeholder="รหัสพนักงาน"
                                    maxlength="5" disabled
                                    autofocus="autofocus"
                                    value="<?=$_SESSION['uID']?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="col-sm-4 control-label ">ชื่อเต็ม ภาษาไทย : </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="salary_fullname_thai"
                                    name="salary_fullname_thai"
                                    placeholder="กรอก ชื่อเต็ม (Thai)"
                                    autofocus="autofocus" disabled
                                    value="<?= $person[2],$person[3] ?>">
                                    <div id="alert_fullname_thai"
                                    style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <h4 class="page-header">ตารางข้อมูลเวลทำงาน ประจำเดือน <?php 
                            $month_name = strtolower(date("M")); // name of each month
                                            switch ($month_name) {
                                                case "jan" : echo "มกราคม";break; 
                                                case "feb" : echo "กุมภาพันธ์";break; 
                                                case "mar" : echo "มีนาคม";break; 
                                                case "apr" : echo "เมษายน";break; 
                                                case "may" : echo "พฤษภาคม";break; 
                                                case "jun" : echo "มิถุนายน";break; 
                                                case "jul" : echo "กรกฏาคม";break; 
                                                case "aug" : echo "สิงหาคม";break; 
                                                case "sep" : echo "กันยายน";break; 
                                                case "oct" : echo "ตุลาคม";break; 
                                                case "nov" : echo "พฤศจิกายน";break; 
                                                case "dec" : echo "ธันวาคม";break;
                                            }?></h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th class="text-center">ลำดับ</th>
                                            <th class="text-center">วัน</th>
                                            <th class="text-center">วันที่</th>
                                            <th class="text-center">เวลาเข้างาน</th>
                                            <th class="text-center">เวลาออกงาน</th>
                                            <th class="text-center">จำนวนวันที่ไม่หัก</th>
                                            <th class="text-center">จำนวนวันที่หัก</th>
                                            <th class="text-center">หมายเหตุ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php 
                                $i = 0;
                                $m = strtotime(date("Y-m-d"));
                                $m_la = strtotime("-2 month" ,$m);
                                $m_sql = date("m" ,$m);
                                $m_la_sql = date("m" ,$m_la);
                                $sql_checktime = "SELECT * FROM fn_check_time 
                                                    WHERE person_id = {$_GET['id']} AND (month(time_datetime) = '$m_sql' OR month(time_datetime) = '$m_la_sql') ORDER BY `fn_check_time`.`time_datetime` ASC ";
                                $query_checktime = mysqli_query($conn,$sql_checktime);  
                                while ($check_time = mysqli_fetch_array($query_checktime)){ 
                                   $eng_date=strtotime($check_time['time_datetime']);     
                                    $i++;
                                ?>
                                        <tr class="bg-info">
                                            <td class="text-center <?php if ($check_time['time_comment'] == 'ขาด'){
                                               ?> bg-danger<?php }?><?php if ($check_time['time_comment'] == 'ลา'){
                                                ?> bg-warning<?php }?><?php if ($check_time['time_comment'] == 'สาย'){
                                                ?> bg-success<?php }?>"><?=$i?></td>
                                            <td class="text-center <?php if ($check_time['time_comment'] == 'ขาด'){
                                               ?> bg-danger<?php }?><?php if ($check_time['time_comment'] == 'ลา'){
                                                ?> bg-warning<?php }?><?php if ($check_time['time_comment'] == 'สาย'){
                                                ?> bg-success<?php }?>"><?= day_thai($eng_date);?></td>
                                            <td class="text-center <?php if ($check_time['time_comment'] == 'ขาด'){
                                               ?> bg-danger<?php }?><?php if ($check_time['time_comment'] == 'ลา'){
                                                ?> bg-warning<?php }?><?php if ($check_time['time_comment'] == 'สาย'){
                                                ?> bg-success<?php }?>"><?= $check_time['time_datetime'];?></td>
                                            <td class="text-center <?php if ($check_time['time_comment'] == 'ขาด'){
                                               ?> bg-danger<?php }?><?php if ($check_time['time_comment'] == 'ลา'){
                                                ?> bg-warning<?php }?><?php if ($check_time['time_comment'] == 'สาย'){
                                                ?> bg-success<?php }?>"><?= $check_time['time_timein'];?></td>
                                            <td class="text-center <?php if ($check_time['time_comment'] == 'ขาด'){
                                               ?> bg-danger<?php }?><?php if ($check_time['time_comment'] == 'ลา'){
                                                ?> bg-warning<?php }?><?php if ($check_time['time_comment'] == 'สาย'){
                                                ?> bg-success<?php }?>"><?= $check_time['time_timeout'];?></td>
                                            <td class="text-center <?php if ($check_time['time_comment'] == 'ขาด'){
                                               ?> bg-danger<?php }?><?php if ($check_time['time_comment'] == 'ลา'){
                                                ?> bg-warning<?php }?><?php if ($check_time['time_comment'] == 'สาย'){
                                                ?> bg-success<?php }?>"><?php if($check_time['time_discount'] == 0){
                                                echo "1";
                                            }else echo "0"; ?></td>
                                            <td class="text-center <?php if ($check_time['time_comment'] == 'ขาด'){
                                               ?> bg-danger<?php }?><?php if ($check_time['time_comment'] == 'ลา'){
                                                ?> bg-warning<?php }?><?php if ($check_time['time_comment'] == 'สาย'){
                                                ?> bg-success<?php }?>"><?php if ($check_time['time_discount'] == 0){
                                                echo "0";
                                            }else echo "1"; ?></td>
                                            <td class="text-center <?php  if ($check_time['time_comment'] == 'ขาด'){
                                               ?> bg-danger<?php }?><?php if ($check_time['time_comment'] == 'ลา'){
                                                ?> bg-warning<?php }?><?php if ($check_time['time_comment'] == 'สาย'){
                                                ?> bg-success<?php }?>"><?php 
                                            if($check_time['time_comment'] == 'เข้างานตรงเวลา'){
                                                echo "<b>เข้างานตรงเวลา</b>";
                                            }if($check_time['time_comment'] == 'สาย'){
                                                echo " <b style=\"color:#ff3300;\">สาย</b>";
                                            }if($check_time['time_comment'] == 'ขาด'){
                                                echo " <b style=\"color:#ff3300;\">ขาด</b>";
                                            }if($check_time['time_comment'] == 'ลา'){
                                                echo " <b>ลา</b>";
                                            }?></td>
                                            </tr>
                                        <?php } ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <h4 class="page-header">สรุปข้อมูลเวลทำงาน</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-success">
                                                <th class="text-center">รวมวันทำงาน</th>
                                                <th class="text-center">รวมวันที่หัก</th>
                                                <th class="text-center">รวมวันที่ไม่หัก</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql_amount_check = "SELECT * FROM fn_check_time 
                                                    WHERE person_id = {$_GET['id']}";
                                            $query_amount_check = mysqli_query($conn,$sql_checktime);
                                            $amount_check = mysqli_num_rows($query_amount_check);
                                            $sql_amount_discount = "SELECT * FROM fn_check_time 
                                                    WHERE person_id = {$_GET['id']} AND time_discount = 1 AND (month(time_datetime) = '$m_sql' OR month(time_datetime) = '$m_la_sql')";
                                            $query_amount_discount = mysqli_query($conn,$sql_amount_discount);
                                            $amount_diuscont = mysqli_num_rows($query_amount_discount);
                                            $sql_amount_nodiscount = "SELECT * FROM fn_check_time 
                                                    WHERE person_id = {$_GET['id']} AND time_discount = 0 AND (month(time_datetime) = '$m_sql' OR month(time_datetime) = '$m_la_sql')";
                                            $query_amount_nodiscount = mysqli_query($conn,$sql_amount_nodiscount);
                                            $amount_nodiuscont = mysqli_num_rows($query_amount_nodiscount);  
                                            ?>
                                            <tr class="bg-info">
                                                <th class="text-center"><?=number_format($amount_check)?></th>
                                                <th class="text-center"><?=number_format($amount_diuscont)?></th>
                                                <th class="text-center"><?=number_format($amount_nodiuscont)?></th>
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