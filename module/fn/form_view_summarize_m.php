<?php

if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}
include("inc/topnav.php");
$month = $_GET['month'];
$year = date("Y");
$sql_select = "";
$m = strtotime(date("Y-m-d"));
$m_la = strtotime("-2 month" ,$m);
$m_sql = date("m" ,$m);
$m_la_sql = date("m" ,$m_la);


$sql_confirm = "SELECT * FROM hr_person_leave WHERE deleted = 0  AND confirm = 1 AND (month(person_leave_begin) = '$m_sql' OR month(person_leave_begin) = '$m_la_sql')";
$query_sql_confirm = mysqli_query($conn, $sql_confirm);
$amount_confirm = mysqli_num_rows($query_sql_confirm);
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
                            onclick="window.location='index.php'">
                            <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                        </button>
                    </div>



                    <div class="col-sm-3" style="padding:10px 15px 5px 0; text-align:right;"></div>
                    <div class="container">
                        <div class="col-sm-12">

                           <div class="row col-sm-12">
                             <div class="form-group col-sm-2">


                                <label class="">หัวข้อ : </label>
                                <?php 
                                $dateyear = date("Y");
                                ?>
                            </div>

                            <div class="form-group col-sm-10">
                                <input type="text" class="form-control" id="salary_title"
                                name="salary_title"
                                placeholder="หัวข้อ ตารางเงินเดือน" maxlength="200"
                                autofocus="autofocus" value="สรุปเงินเดือนประจำเดือน<?php 
                                switch ($month) {
                                    case "01" : echo "มกราคม";break; 
                                    case "02" : echo "กุมภาพันธ์";break; 
                                    case "03" : echo "มีนาคม";break; 
                                    case "04" : echo "เมษายน";break; 
                                    case "05" : echo "พฤษภาคม";break; 
                                    case "06" : echo "มิถุนายน";break; 
                                    case "07" : echo "กรกฏาคม";break; 
                                    case "08" : echo "สิงหาคม";break; 
                                    case "09" : echo "กันยายน";break; 
                                    case "10" : echo "ตุลาคม";break; 
                                    case "11" : echo "พฤศจิกายน";break; 
                                    case "12" : echo "ธันวาคม";break;
                                }?> พ.ศ.<?= fullThaiDate($dateyear, 0); ?>" disabled>
                                <div id="alert_salary_title"
                                style="color: red; font-weight: bold; margin-top: 5px;"></div>
                            </div>
                        </div>
                        <?php
                        $money = mysqli_query($conn,"SELECT SUM(hr_person_employment.employment_money) FROM `hr_person_employment`");
                        list($amount) = mysqli_fetch_array($money);
                        ?>

                        <div class="row">
                            <div >
                               <div class="form-group  col-sm-6">
                                <label class="col-sm-4 control-label ">จำนวนวันที่ทำงาน: </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" 
                                    autofocus="autofocus" disabled
                                    value="<?php switch ($month) {
                                        case "01" : echo "31";break; 
                                        case "02" : echo "29";break; 
                                        case "03" : echo "31";break; 
                                        case "04" : echo "30";break; 
                                        case "05" : echo "31";break; 
                                        case "06" : echo "30";break; 
                                        case "07" : echo "31";break; 
                                        case "08" : echo "31";break; 
                                        case "09" : echo "30";break; 
                                        case "10" : echo "31";break; 
                                        case "11" : echo "30";break; 
                                        case "12" : echo "31";break;
                                    }?> วัน">
                                    <div id="alert_fullname_thai"
                                    style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                </div>
                            </div></div>
                            <div class="form-group col-sm-6">
                                <label class="col-sm-4 control-label ">จำนวนวันที่ลา : </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" 
                                    placeholder="กรอก ชื่อเต็ม (Thai)"
                                    autofocus="autofocus" disabled
                                    value="<?= number_format($amount_confirm) ?> วัน" >
                                </div>
                            </div>
                        </div>

                    </div>

                    <div >
                       <div class="form-group  col-sm-6">
                        <?php $ot = mysqli_query($conn,"SELECT employment_ot FROM hr_person_employment WHERE employment_ot !=0") ;
                        $amount_ot = mysqli_num_rows($ot);?>
                        <label class="col-sm-4 control-label ">จำนวนคนที่ทำ ot : </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="salary_fullname_thai"
                            name="salary_fullname_thai"
                            placeholder="กรอก ชื่อเต็ม (Thai)"
                            autofocus="autofocus" disabled
                            value="<?= number_format($amount_ot)?> คน">
                            <div id="alert_fullname_thai"
                            style="color: red; font-weight: bold; margin-top: 5px;"></div>
                        </div>
                    </div></div>



                    <div class="row">
                        <div >
                           <div class="form-group  col-sm-6">
                            <label class="col-sm-4 control-label ">จำนวนคนทำงานในวันหยุด : </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" 
                                autofocus="autofocus" disabled
                                value="0 คน">

                            </div>
                        </div></div>


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
                                            <td style="text-align:right;"><?=number_format($amount)?> บาท</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>ค่าประจำตำแหน่ง</td>
                                            <td style="text-align:right;">0 บาท</td>

                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>จำนวนเงิน วันทำงานในวันหยุด</td>
                                            <td style="text-align:right;">0 บาท</td>

                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>จำนวนเงิน ot</td>
                                            <td style="text-align:right;">0 บาท </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>รายได้ การเดินทางต่างจังหวัด</td>
                                            <td style="text-align:right;">0 บาท</td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>โบนัสประจำปี</td>
                                            <td style="text-align:right;">0 บาท</td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>รายได้อื่นๆ</td>
                                            <td style="text-align:right;">0 บาท</td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>รวมรายได้ทั้งหมด</td>
                                            <td style="text-align:right;"><?=number_format($amount)?> บาท</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="form-group col-sm-11"><h4 class="page-header">รายการการหัก</h4>
                        </div>
                        <div class="form-group col-sm-1"></div>
                        <div class="row">

                            <div class="col-sm-12">
                                <table class="table table-bordered">

                                    <thead>
                                        <tr class="bg-danger">
                                            <th class="text-center">ลำดับ</th>
                                            <th class="text-center">รายการ</th>
                                            <th class="text-center">จำนวนเงิน</th>
                                        </tr>
                                    </thead>
                                    <?php  

                                    $sql_amount_kart = "
                                    SELECT * FROM fn_check_time  WHERE time_comment = 'ขาด' AND (month(time_datetime) = '$m_sql' OR month(time_datetime) = '$m_la_sql')
                                    ";
                                    $query_amount_kart = mysqli_query($conn,$sql_amount_kart);
                                    $amount_kart = mysqli_num_rows($query_amount_kart);
                                    $total_kart = 300*$amount_kart;
                                    $sql_amount_discount = "
                                    SELECT * FROM fn_check_time  WHERE time_comment = 'สาย' AND (month(time_datetime) = '$m_sql' OR month(time_datetime) = '$m_la_sql')
                                    ";
                                    $query_amount_discount = mysqli_query($conn,$sql_amount_discount);
                                    $amount_diuscont = mysqli_num_rows($query_amount_discount);
                                    mysqli_free_result($query_amount_discount);
                                    $select_time_discount = mysqli_query($conn,"
                                        SELECT SUM(TIME_FORMAT(time_timein, '%H')) FROM fn_check_time  WHERE time_comment = 'สาย' AND (month(time_datetime) = '$m_sql' OR month(time_datetime) = '$m_la_sql')
                                        ");
                                    list($time_discount) = mysqli_fetch_array($select_time_discount);
                                    $time_late = $time_discount;
                                    $time_in = 8*$amount_diuscont; 
                                    $time_total = $time_late - $time_in ; 
                                    ?>
                                    <tbody>
                                        <tr>
                                          <td>1</td>
                                          <td>หักมาสาย ชั่วโมงละ 1 บาท</td>
                                          <td style="text-align:right;"><?=$time_total?> บาท</td>
                                          <tr>
                                              <td>2</td>
                                              <td>หักขาดงาน วันละ 300 บาท</td>
                                              <td style="text-align:right;"><?=$total_kart?> บาท</td>
                                          </tr>
                                          <tr>
                                              <td>3</td>
                                              <td>เงินเบิกล่วงหน้า</td>
                                              <td style="text-align:right;">0 บาท</td>
                                          </tr>
                                          <tr>
                                              <tr>
                                                <td>4</td>
                                                <td>ค่าใช้จ่ายอุบัติเหตุ</td>
                                                <td style="text-align:right;">0 บาท</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>ค่าใช้จ่ายอื่นๆ</td>
                                                <td style="text-align:right;">0 บาท</td>
                                            </tr>
                                            <tr>
                                                <?php 
                                                $total_discount = $total_kart + $time_total;
                                                ?>
                                                <td>6</td>
                                                <td>รวมรายการหักเงิน ทั้งหมด</td>
                                                <td style="text-align:right;"><?=$total_discount?> บาท</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-group col-sm-11"><h4 class="page-header">
                                    รวมเงินเดือนสุทธิ</h4></div>
                                    <div class="form-group col-sm-1"></div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-success">
                                                <th class="text-center">รายการ</th>
                                                <th class="text-center">จำนวนเงิน</th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $total = $amount-$total_discount;
                                        ?>
                                        <tbody align="center">
                                          <tr>
                                            <td>รายได้สุทธิ</td>
                                            <td><?=number_format($total)?> บาท</td>
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



