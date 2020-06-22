<?php

if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");
include("inc/topnav.php");
$id = $_GET['id'];
$sql_select_department = "SELECT * FROM hr_person_employment WHERE person_id = $id";
$query_select_department = mysqli_query($conn,$sql_select_department);
$department = mysqli_fetch_array($query_select_department);
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
              onclick="window.history.back();">
              <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
            </button>
          </div>
          <div class="col-sm-3" style="padding:10px 15px 5px 0; text-align:right;"></div>
          <div class="container">
            <?php
            $sql_select_person = "
            SELECT * FROM hr_person WHERE person_id=$id";
            $query_select_person = mysqli_query($conn, $sql_select_person);
            $person = mysqli_fetch_array($query_select_person);
            ?>



            <div class="col-sm-12">
              <div class="form-group col-sm-6">
                <label class="col-sm-4 control-label ">รหัสพนักงาน : </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="salary_count"
                  name="salary_count"
                  maxlength="50" disabled
                  autofocus="autofocus"
                  value="<?= $person[0] ?>">
                </div>
              </div>
              <div class="form-group col-sm-6">
                <label class="col-sm-4 control-label ">ชื่อเต็ม thai : </label>
                <div class="col-sm-8">
                  <?php $ser = "นาง";
                  if($person[1] == 1){
                    $ser = "นาย";
                  }elseif ($person[1] == 2){
                    $ser = "นางสาว";
                  } ?>
                  <input type="text" class="form-control" id="person_id"
                  name="person_id" placeholder="รหัสพนักงาน"
                  maxlength="5" disabled autofocus="autofocus"
                  value="<?=$ser?> <?= $person[2]?> <?=$person[3] ?>">
                </div>
              </div>

            </div>



            <?php 
            $sql_department = mysqli_query($conn, "SELECT department_name FROM hr_person_department WHERE department_id = $department[3]");
            $departmented = mysqli_fetch_assoc($sql_department);?>



            <div class="col-sm-12">
              <div class="form-group col-sm-6">
                <label class="col-sm-4 control-label ">ตำแหน่ง : </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control"  maxlength="120"
                  autofocus="autofocus" disabled
                  value="<?= $departmented['department_name'] ?>">
                  <div id="alert_fullname_thai"
                  style="color: red; font-weight: bold; margin-top: 5px;"></div>
                </div>
              </div>
              <?php 
              $sql_department = mysqli_query($conn, "SELECT position_name FROM hr_person_position WHERE position_id = $department[2]");
              $departmented = mysqli_fetch_assoc($sql_department);?>
              <div class="form-group col-sm-6">
                <label class="col-sm-4 control-label">แผนก : </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" maxlength="30"
                  autofocus="autofocus" disabled
                  value="<?= $departmented['position_name'] ?>">
                </div>
              </div>
            </div>



           <div class="col-sm-12" >
              <div class="form-group col-sm-6">
                <div class="row">
                  <div class="col-sm-12">
                    <?php 
                    $m = strtotime(date("Y-m-d"));
                    $m_la = strtotime("-2 month" ,$m);
                    $m_sql = date("m" ,$m);
                    $m_la_sql = date("m" ,$m_la);
                    $sql_amount_check = "SELECT * FROM fn_check_time 
                    WHERE person_id =  $person[0] AND (month(time_datetime) = '$m_sql' OR month(time_datetime) = '$m_la_sql')";
                    $query_amount_check = mysqli_query($conn,$sql_amount_check);
                    $amount_check = mysqli_num_rows($query_amount_check);
                    ?>
                    <label class="col-sm-4 control-label">จำนวนวันที่ทำงาน : 
                      <i class="fa fa-file-text" onclick="window.location.href='index.php?mod=fn/time_check'"></i></label> 
                      <div class="col-sm-8">
                        <input type="text" class="form-control"  maxlength="120"
                        autofocus="autofocus" disabled
                        value="<?=number_format($amount_check)?> วัน">
                      </button>            
                    </div>  
                  </div>          
                </div>  
              </div>

               <!-- ______________________________________ -->
            
             <?php          
              $sql_amount_discount = "
              SELECT * FROM fn_check_time WHERE person_id = $person[0] AND time_comment = 'สาย' AND (month(time_datetime) = '$m_sql' OR month(time_datetime) = '$m_la_sql')
                                    ";
              $query_amount_discount = mysqli_query($conn,$sql_amount_discount);
              $amount_diuscont = mysqli_num_rows($query_amount_discount);
              mysqli_free_result($query_amount_discount);
              $select_time_discount = mysqli_query($conn,"
              SELECT SUM(TIME_FORMAT(time_timein, '%H')) FROM fn_check_time WHERE person_id = $person[0] AND time_comment = 'สาย' AND (month(time_datetime) = '$m_sql' OR month(time_datetime) = '$m_la_sql')
                                    ");
              list($time_discount) = mysqli_fetch_array($select_time_discount);
              $time_late = $time_discount;
              $time_in = 8*$amount_diuscont; 
              $time_total = $time_late - $time_in ; 
             ?>
              <div class="form-group col-sm-6">
                <label class="col-sm-4 control-label ">จำนวนวันที่มาสาย : </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control"  maxlength="120"
                  autofocus="autofocus" disabled
                  value="<?=number_format($amount_diuscont)?> วัน (<?=$time_total?> ชั่วโมง)">
                  <div id="alert_fullname_thai"
                  style="color: red; font-weight: bold; margin-top: 5px;"></div>
                </div>
              </div>
            </div>
            
            <!-- ______________________________________ -->
            <?php 
            $sql_amount_leave = "SELECT time_comment FROM fn_check_time 
            WHERE person_id =  $person[0] AND time_comment = 'ลา'";
            $query_amount_leave = mysqli_query($conn,$sql_amount_leave);
            $amount_leave = mysqli_num_rows($query_amount_leave);
            ?>
          <div class="col-sm-12">
              <div class="form-group col-sm-6">
                <label class="col-sm-4 control-label ">จำนวนวันลา : </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control"  maxlength="120"
                  autofocus="autofocus" disabled
                  value="<?=number_format($amount_leave)?> วัน">
                  <div id="alert_fullname_thai"
                  style="color: red; font-weight: bold; margin-top: 5px;"></div>
              </div>
            </div>
              <?php          
              $sql_amount_kart = "
              SELECT * FROM fn_check_time WHERE person_id = $person[0] AND time_comment = 'ขาด' AND (month(time_datetime) = '$m_sql' OR month(time_datetime) = '$m_la_sql')
                                    ";
              $query_amount_kart = mysqli_query($conn,$sql_amount_kart);
              $amount_kart = mysqli_num_rows($query_amount_kart);
              $total_kart = 300*$amount_kart;
             ?>
              <div class="form-group col-sm-6">
                <label class="col-sm-4 control-label">จำนวนวันที่ขาด : </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" maxlength="30"
                  autofocus="autofocus" disabled
                  value="<?=number_format($amount_kart)?> วัน">
                </div>
              </div>
            </div>

              <!-- ______________________________________ -->


              <div class="col-sm-12">
                <div class="form-group col-sm-6">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group col-sm-11"><h4 class="page-header">รายได้หลัก</h4>
                      </div>
                      <?php 
                      $select_salary = mysqli_query($conn, "SELECT employment_money FROM hr_person_employment WHERE person_id = $id ");
                      List($salary) = mysqli_fetch_array($select_salary);
                       ?>
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
                            <td style="text-align:right;"><?=number_format($salary)?> บาท</td>
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
                              <td style="text-align:right;"><?=number_format($salary)?> บาท</td>
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
                                  $total = $salary-$total_discount;
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

