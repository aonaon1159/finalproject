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
                                    onclick="window.location='index.php?mod=fn/form_view_time&id=<?= $_GET['file_id'] ?>'">
                                <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                            </button>
                        </div>
                        <div class="col-sm-3" style="padding:10px 15px 5px 0; text-align:right;"></div>
                        <div class="container">
                            <?php
                            $i = 1;
                            if (isset($_GET["file_id"])) $file_id = $_GET["file_id"];
                            else $file_id = $add_file_id;

                            if (isset($_GET["count_id"])) $count_id = $_GET["count_id"];
                            else $count_id = $add_count_id;
                            
                            $sql_select_name = "
                                  SELECT * FROM fn_scan 
                                  WHERE scanfile_id='$file_id' AND time_machine_count='$count_id'
                                  LIMIT 1
                            ";
                            $query_select_name = mysqli_query($conn, $sql_select_name);
                            $num_salary_income = mysqli_num_rows($query_select_name);
                            $assoc_name = mysqli_fetch_assoc($query_select_name);
                            ?>
                            <h4 class="page-header">ข้อมูลส่วนตัว</h4>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label ">บริษัท : </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="salary_position"
                                               name="salary_position"
                                               placeholder="กรอก ตำแหน่ง"
                                               autofocus="autofocus" disabled
                                               value="<?= $assoc_name["time_company"] ?>">
                                        <div id="alert_salary_position"
                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label">แผนก : </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="salary_payment"
                                               name="salary_payment"
                                               placeholder="กรอก ประเภทการจ่ายเงิน"
                                               autofocus="autofocus" disabled
                                               value="<?= $assoc_name["time_department"] ?>">
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
                                               value="<?php if ($assoc_name["person_id"] != NULL) echo $assoc_name["person_id"]; else echo " - "; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label ">ชื่อเต็ม ภาษาไทย : </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="salary_fullname_thai"
                                               name="salary_fullname_thai"
                                               placeholder="กรอก ชื่อเต็ม (Thai)"
                                               autofocus="autofocus" disabled
                                               value="<?= $assoc_name["time_fullname"] ?>">
                                        <div id="alert_fullname_thai"
                                             style="color: red; font-weight: bold; margin-top: 5px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12"><center><b style="font-size:20px;">| รายเดือน = 1 เท่า |<br> | รายวัน = x2 |</b></center></div>
                            <div class="col-sm-12">
                                <h4 class="page-header">ตารางข้อมูลเวลทำงาน</h4>
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
                                            <!-- <th class="text-center">จำนวนวันที่ทำงานในวันหยุด</th> -->
                                            <th class="text-center">หมายเหตุ</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        // Set date for chk time in and time out
                                        $date = explode(" ", $assoc_name["time_datetime"]);
                                        list($time_year, $time_month, $time_day) = explode("-", $date[0]);


                                        //____________________Select min and max this file
                                        $sql_min_day = "
                                            SELECT MIN(time_datetime) 
                                            FROM fn_scan
                                            WHERE scanfile_id='$file_id'
                                        ";
                                        $sql_max_day = "
                                            SELECT MAX(time_datetime)
                                            FROM fn_scan
                                            WHERE scanfile_id='$file_id'
                                        ";
                                        $query_min_day = mysqli_query($conn, $sql_min_day) or die("Sql error is : " . mysqli_error($conn));
                                        $query_max_day = mysqli_query($conn, $sql_max_day) or die("Sql error is : " . mysqli_error($conn));
                                        list($min_day) = mysqli_fetch_row($query_min_day);
                                        list($max_day) = mysqli_fetch_row($query_max_day);
                                        $str_time_min = strtotime($min_day);
                                        $str_time_max = strtotime($max_day);

                                        // ____________________Select holiday of person
                                        $sql_select_person_holiday = "
                                            SELECT holiday_value FROM hr_person_holiday
                                            WHERE person_id='{$assoc_name["person_id"]}'
                                        ";
                                        $query_select_person_holiday = mysqli_query($conn, $sql_select_person_holiday);
                                        $num_ho = mysqli_num_rows($query_select_person_holiday);
                                        list($this_person_holiday) = mysqli_fetch_row($query_select_person_holiday);
                                        $exp_this_person_holiday = explode(",", $this_person_holiday);

                                        $chk_holiday = 0; // variable chk holiday
                                        $count_loop = 1; // count of while loop
                                        $count_holiday = 0; // variable = 2 ,count of holiday chk holiday
                                        $count_working = 0; // count of working day
                                        $chk_dayof_working = 0; // variable chk working
                                        $chk_dayof_not_working = 0;  // variable chk holiday
                                        $day_not_charge = 0; // variable day not charge
                                        $day_charge = 0; // variable day charge
                                        // $count_work_in_holiday = 0; // variable count day work in holiday
                                        // $count_status_sick = 0; // variable count leave sick have certification
                                        $work_on_holiday = 0; // variable count work on holiday






                                        //___________________Select holiday of year
                                            $sql_select_holiday_of_year = "SELECT holiday_date,holiday_end FROM hr_year_holiday  
                                            ";
                                            $query_select_holiday_of_year = mysqli_query($conn, $sql_select_holiday_of_year);
                                            $num_year_ho = mysqli_num_rows($query_select_holiday_of_year);
                                            list($holiday_date,$holiday_end) = mysqli_fetch_row($query_select_holiday_of_year);
                                            


                                            $start_holiday_date = $holiday_date;
                                            $end_holiday_date = $holiday_end;


                                        while ($str_time_min <= $str_time_max) {
                                            $chk_work_in_holiday = false; // variable true,false day work in holiday
                                            $chk_time_min = date("Y-m-d", $str_time_min);
                                            // $chk_time_max = date("Y-m-d", $str_time_max);

                                            // ____________________Sql select time_datetime
                                            $sql_select_in = "
                                                SELECT time_id,time_datetime FROM fn_scan
                                                WHERE scanfile_id='$file_id' AND time_machine_count='{$assoc_name["time_machine_count"]}' AND time_datetime LIKE '%$chk_time_min%'
                                                ORDER BY time_datetime ASC
                                                LIMIT 1
                                            ";
                                            $sql_select_out = "
                                                SELECT time_id,time_datetime FROM fn_scan
                                                WHERE scanfile_id='$file_id' AND time_machine_count='{$assoc_name["time_machine_count"]}' AND time_datetime LIKE '%$chk_time_min%'
                                                ORDER BY time_datetime DESC
                                                LIMIT 1 
                                            ";
                                            $query_in = mysqli_query($conn, $sql_select_in) or die("Error in is : " . mysqli_error($conn));
                                            $query_out = mysqli_query($conn, $sql_select_out) or die("Error out is : " . mysqli_error($conn));
                                            // ____________________Sql select time_id
                                            $sql_select_in_time_id = "
                                                SELECT time_id,time_datetime FROM fn_scan
                                                WHERE scanfile_id='$file_id' AND time_machine_count='{$assoc_name["time_machine_count"]}' AND time_datetime LIKE '%$chk_time_min%'
                                                ORDER BY time_datetime ASC
                                            ";
                                            $sql_select_out_time_id = "
                                                SELECT time_id,time_datetime FROM fn_scan
                                                WHERE scanfile_id='$file_id' AND time_machine_count='{$assoc_name["time_machine_count"]}' AND time_datetime LIKE '%$chk_time_min%'
                                                ORDER BY time_datetime DESC
                                            ";
                                            $query_in_id = mysqli_query($conn, $sql_select_in_time_id) or die("Error in is : " . mysqli_error($conn));
                                            $query_out_id = mysqli_query($conn, $sql_select_out_time_id) or die("Error out is : " . mysqli_error($conn));

                                            // ____________________Sql select time_comment
                                            $sql_select_comment_in = "
                                                SELECT time_comment FROM fn_scan
                                                WHERE scanfile_id='$file_id' AND time_machine_count='{$assoc_name["time_machine_count"]}' AND time_datetime LIKE '%$chk_time_min%'
                                                ORDER BY time_datetime ASC
                                            ";
                                            $sql_select_comment_out = "
                                                SELECT time_comment FROM fn_scan
                                                WHERE scanfile_id='$file_id' AND time_machine_count='{$assoc_name["time_machine_count"]}' AND time_datetime LIKE '%$chk_time_min%'
                                                ORDER BY time_datetime DESC
                                            ";

                                            $query_comment_in = mysqli_query($conn, $sql_select_comment_in);
                                            $query_comment_out = mysqli_query($conn, $sql_select_comment_out);

                                            $sql_select_in_idBy = "
                                                SELECT time_id,time_datetime,time_status,time_transaction FROM fn_scan
                                                WHERE scanfile_id='$file_id' AND time_machine_count='{$assoc_name["time_machine_count"]}' AND time_datetime LIKE '%$chk_time_min%'
                                                ORDER BY time_datetime ASC
                                            ";
                                            $sql_select_out_idBy = "
                                                SELECT time_id,time_datetime,time_status,time_transaction FROM fn_scan
                                                WHERE scanfile_id='$file_id' AND time_machine_count='{$assoc_name["time_machine_count"]}' AND time_datetime LIKE '%$chk_time_min%'
                                                ORDER BY time_datetime DESC
                                            ";

                                            $query_in_idBy = mysqli_query($conn, $sql_select_in_idBy);
                                            $query_out_idBy = mysqli_query($conn, $sql_select_out_idBy);

                                            $query_in_idBy_workday = mysqli_query($conn, $sql_select_in_idBy);
                                            $query_out_idBy_workday = mysqli_query($conn, $sql_select_out_idBy);

                                            $query_in_idBy_break = mysqli_query($conn, $sql_select_in_idBy);
                                            $query_out_idBy_break = mysqli_query($conn, $sql_select_out_idBy);

                                            $query_in_idBy_chk = mysqli_query($conn, $sql_select_in_idBy);
                                            $query_out_idBy_chk = mysqli_query($conn, $sql_select_out_idBy);



                                            //____________Sql select time_transaction
                                            // $sql_select_check_i = "
                                            //     SELECT time_transaction FROM fn_scan
                                            //     WHERE scanfile_id='$file_id' AND time_machine_count='{$assoc_name["time_machine_count"]}' AND time_datetime LIKE '%$chk_time_min%'
                                            //     ORDER BY time_id DESC
                                            // ";
                                            // $sql_select_check_o = "
                                            //     SELECT time_transaction FROM fn_scan
                                            //     WHERE scanfile_id='$file_id' AND time_machine_count='{$assoc_name["time_machine_count"]}' AND time_datetime LIKE '%$chk_time_max%'
                                            //     ORDER BY time_id DESC
                                            // ";

                                            // $query_i = mysqli_query($conn ,$sql_select_check_i);
                                            // $query_o = mysqli_query($conn ,$sql_select_check_o);

                                            // mysqli_num_rows($query_i);
                                            // mysqli_num_rows($query_o);

                                            // $check_i = mysqli_fetch_assoc($query_i);
                                            // $check_o = mysqli_fetch_assoc($query_o);

                                            // echo "____[[[---";
                                            // print_r($check_i);
                                            // echo "---]]]____<br>____{{{---";
                                            // print_r($check_o);
                                            // echo "---}}}<br>";
                                            // echo "<br>";


                                            

                                            echo "<tbody><tr>";
                                            echo "<td>" . $count_loop . "</td>";

                                            $day_name = strtolower(date("l", $str_time_min)); // name of each day
                                            switch ($day_name) {
                                                case "monday" :
                                                    echo "<td>วันจันทร์</td>";
                                                    break;
                                                case "tuesday" :
                                                    echo "<td>วันอังคาร</td>";
                                                    break;
                                                case "wednesday" :
                                                    echo "<td>วันพุธ</td>";
                                                    break;
                                                case "thursday" :
                                                    echo "<td>วันพฤหัสบดี</td>";
                                                    break;
                                                case "friday" :
                                                    echo "<td>วันศุกร์</td>";
                                                    break;
                                                case "saturday" :
                                                    echo "<td>วันเสาร์</td>";
                                                    break;
                                                case "sunday" :
                                                    echo "<td>วันอาทิตย์</td>";
                                                    break;
                                            }



                                            
                                            echo "<td style='background-color:#fbedd4'>";
                                            $tmpDate = date("Y-m-d",$str_time_min);
                                            $tmpDate = strtotime($tmpDate); 
                                            echo showThaiDate(date("Y-m-d",$tmpDate));
                                            echo "</td>";


                                            

                                            $day_name = strtolower(date("l", $str_time_min)); // name of each day
                                            $date_time_min = date("Y-m-d", $str_time_min); // convert $str_time_min to format date

                                            $count_not_holiday = 0; // this variable =2 day = workday
                                            $chk_leave_day = 0; // this variable = 2 query time in and out =00:00:00:00
                                                                                        
                                            $tmpDate = date("Y-m-d" ,$tmpDate);









                                            
                                            for ($j = 0; $j < count($exp_this_person_holiday); $j++) { // 0 = Sunday, Monday=1, Tuesday=2, Wednesday=3, Thursday=4, Friday=5, 6 = Saturday;

                                               

                                            

                                            //___________________Select holiday title 
                                            $sql_select_holiday_title = "
                                                SELECT holiday_title FROM hr_year_holiday 
                                                WHERE holiday_date <= '$tmpDate' AND holiday_end >= '$tmpDate'
                                            ";
                                            $query_selecy_holiday_title = mysqli_query($conn ,$sql_select_holiday_title);
                                            $num_tilte_ho = mysqli_num_rows($query_selecy_holiday_title);
                                            list($holiday_title) = mysqli_fetch_row($query_selecy_holiday_title);
                                            $year_holiday_title = $holiday_title;



                                            //____________Select time_status
                                            $sql_select_time_status = "
                                                SELECT time_status FROM fn_scan 
                                                WHERE scanfile_id='$file_id' 
                                                AND time_machine_count='{$assoc_name["time_machine_count"]}' 
                                                AND time_datetime LIKE '%$chk_time_min%'
                                                ORDER BY time_datetime DESC
                                            ";
                                            
                                            $query_select_time_status = mysqli_query($conn ,$sql_select_time_status);
                                            $num_time_status = mysqli_num_rows($query_select_time_status);
                                            list($time_status) = mysqli_fetch_row($query_select_time_status);
                                            $time_status_person = $time_status;
                                            




                                            $sqlCheckHoliday = mysqli_query($conn ,"SELECT holiday_id FROM hr_year_holiday WHERE holiday_date <= '$tmpDate' AND holiday_end >= '$tmpDate'");

                                                if (mysqli_num_rows($sqlCheckHoliday)==0){ 

                                                    if ($exp_this_person_holiday[$j] != 0) {


                                                        if ($exp_this_person_holiday[$j] == 1 AND $day_name == "monday") {
                                                            if (mysqli_num_rows($query_in_idBy)) {
                                                                $start_time_Byid = mysqli_fetch_assoc($query_in_idBy);
                                                                echo "<td style='background-color:#fee7e8;'>";
                                                                $exp_time_in = explode(" ", $start_time_Byid["time_datetime"]);
                                                                    if ($exp_time_in[1] != "00:00:00") {
                                                                        if ($time_status_person == 0){
                                                                            if ($start_time_Byid["time_transaction"] == "I") {
                                                                                echo "<td style='background-color:#fee7e8'>";
                                                                                echo $exp_time_in[1];
                                                                            }else{
                                                                                echo "<td style='background-color:#fee7e8'>";
                                                                                echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                            }
                                                                        }else if ($time_status_person == 1){
                                                                            if ($start_time_Byid["time_transaction"] == "I"){
                                                                                echo "<td style='background-color:;'>";
                                                                                echo $exp_time_in[1];
                                                                            }else{
                                                                                echo "<td style='background-color:;'>";
                                                                                echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                            }
                                                                        }else{
                                                                            if ($start_time_Byid["time_transaction"] == "I"){
                                                                                echo "<td style='background-color:#E6E1FF;'>";
                                                                                echo $exp_time_in[1];
                                                                            }else{
                                                                                echo "<td style='background-color:#E8FFE1;'>";
                                                                                echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                            }
                                                                        }
                                                                } else {
                                                                    echo "<td style='background-color:;'>";
                                                                    echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                }
                                                                echo "</td>";
                                                        } else {
                                                            $chk_holiday++;
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาเข้า</td>
                                                            <?php
                                                        }


                                                            if (mysqli_num_rows($query_out_idBy)) {
                                                                $out_time_Byid = mysqli_fetch_assoc($query_out_idBy);
                                                                $exp_time_out = explode(" ", $out_time_Byid["time_datetime"]);
                                                                if ($exp_time_out[1] != "00:00:00") {
                                                               if ($time_status_person == 0){
                                                                    if($out_time_Byid["time_transaction"] == "O" ) {
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                        }
                                                                }else if ($time_status_person == 1){
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }else{
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:#E6E1FF;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style='background-color:;'>";
                                                                echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                            }
                                                            echo "</td>";
                                                        } else {
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาออก</td>
                                                            <?php
                                                        }


                                                            //______________________ Column break day or day.
                                                            if (mysqli_num_rows($query_in_id) OR mysqli_num_rows($query_out_id)) {
                                                                $assoc_get_in = mysqli_fetch_assoc($query_in_id);
                                                                $assoc_get_out = mysqli_fetch_assoc($query_out_id);
                                                                if ($query_comment_in OR $query_comment_out) {
                                                                    $assoc_comment_id = mysqli_fetch_assoc($query_comment_in);
                                                                    $assoc_comment_out = mysqli_fetch_assoc($query_comment_out);
                                                                }
                                                                if (mysqli_num_rows($query_in_idBy) != 0 || mysqli_num_rows($query_out_idBy) != 0) {
                                                                    $assoc_idBy_in = mysqli_fetch_assoc($query_in_idBy);
                                                                    $assoc_idBy_out = mysqli_fetch_assoc($query_out_idBy);
                                                                    $exp_idBy_in = explode(" ", $assoc_idBy_in["time_datetime"]);
                                                                    $exp_idBy_out = explode(" ", $assoc_idBy_out["time_datetime"]);

                                                                    //______________________ Holiday 00:00:00 have id in table fn_scan
                                                                    if ($exp_idBy_in[1] == "00:00:00" AND $exp_idBy_out[1] == "00:00:00") {
                                                                         if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $assoc_in_break = mysqli_fetch_assoc($query_in_idBy_break);
                                                                        $assoc_out_break = mysqli_fetch_assoc($query_out_idBy_break);
                                                                        $exp_in_break = explode(" ", $assoc_in_break["time_datetime"]);
                                                                        $exp_out_break = explode(" ", $assoc_out_break["time_datetime"]);
                                                                         if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                    }

                                                                }
                                                                
                                                            //______________________ Column comment
                                                            if ($exp_idBy_in[1] == "00:00:00" AND $exp_idBy_out[1] == "00:00:00") {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            } else {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            }
                                                            if ($time_status_person != NULL){
                                                                        if($time_status_person == 0) {
                                                                        ?>
                                                                            <td style="background-color:#fee7e8;text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                   <?php
                                                                        }else if ($time_status_person == 1) {
                                                                            ?>
                                                                            <td style="background-color:; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td style="background-color:#E6E1FF; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                         <td style="background-color:#E8FFE1; text-align:center; ">
                                                                        <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                           class="btn btn-xs btn-default">
                                                                            <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                        <?php
                                                                    }


                                                            // IF chk count of sum work day
                                                            if (mysqli_num_rows($query_in_idBy_chk) != 0 || mysqli_num_rows($query_out_idBy_chk) != 0) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);

                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_working += 1;
                                                                else $chk_dayof_working += 0;
                                                            } else $chk_dayof_working += 1;


                                                            } else {

                                                                if (mysqli_num_rows($query_in_idBy_chk) || mysqli_num_rows($query_out_idBy_chk)) {
                                                                    if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                    if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);
                                                                    $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                    $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                    if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_not_working += 0;
                                                                    else $chk_dayof_not_working += 1;

                                                                } else {
                                                                    $count_holiday += 1;
                                                                    $chk_dayof_not_working += 1;
                                                                }
                                                                echo "<td style='background-color:#fee7e8;'>1</td>";
                                                                echo "<td style='background-color:#fee7e8;'>0</td>";
                                                                $day_not_charge += 1;
                                                                ?>
                                                                <td style='background-color:#fee7e8;'>
                                                                    <font><b>วันหยุด</b></font>
                                                                </td>
                                                                <td style="background-color:#fee7e8; text-align:center; ">
                                                                    <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>"
                                                                       class="btn btn-xs btn-default">
                                                                        <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                </td>
                                                                <?php
                                                            }
                                                            $chk_work_in_holiday = false;
                                                    
                                                    



















            
                                                    } else if ($exp_this_person_holiday[$j] == 2 AND $day_name == "tuesday") {
                                                        if (mysqli_num_rows($query_in_idBy)) {
                                                            $start_time_Byid = mysqli_fetch_assoc($query_in_idBy);
                                                            $exp_time_in = explode(" ", $start_time_Byid["time_datetime"]);
                                                            if ($exp_time_in[1] != "00:00:00") {
                                                                    if ($time_status_person == 0){
                                                                        if ($start_time_Byid["time_transaction"] == "I") {
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else if ($time_status_person == 1){
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else{
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:#E6E1FF;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }

                                                                    }
                                                                } else {

                                                                    echo "<td style='background-color:;'>";
                                                                    echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                }
                                                                echo "</td>";
                                                        } else {
                                                            $chk_holiday++;
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาเข้า</td>
                                                            <?php
                                                        }

                                                        if (mysqli_num_rows($query_out_idBy)) {
                                                            $out_time_Byid = mysqli_fetch_assoc($query_out_idBy);
                                                            $exp_time_out = explode(" ", $out_time_Byid["time_datetime"]);
                                                            if ($exp_time_out[1] != "00:00:00") {
                                                               if ($time_status_person == 0){
                                                                    if($out_time_Byid["time_transaction"] == "O" ) {
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                        }
                                                                }else if ($time_status_person == 1){
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }else{
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:#E6E1FF;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }
                                                            } else {

                                                                echo "<td style='background-color:;'>";
                                                                echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                            }
                                                            echo "</td>";
                                                        } else {
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาออก</td>
                                                            <?php
                                                        }

                                                        //______________________ Column break day or day.
                                                        if (mysqli_num_rows($query_in_id) OR mysqli_num_rows($query_out_id)) {
                                                            $assoc_get_in = mysqli_fetch_assoc($query_in_id);
                                                            $assoc_get_out = mysqli_fetch_assoc($query_out_id);
                                                            if ($query_comment_in OR $query_comment_out) {
                                                                $assoc_comment_id = mysqli_fetch_assoc($query_comment_in);
                                                                $assoc_comment_out = mysqli_fetch_assoc($query_comment_out);
                                                            }
                                                            if (mysqli_num_rows($query_in_idBy) != 0 || mysqli_num_rows($query_out_idBy) != 0) {
                                                                $assoc_idBy_in = mysqli_fetch_assoc($query_in_idBy);
                                                                $assoc_idBy_out = mysqli_fetch_assoc($query_out_idBy);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out["time_datetime"]);

                                                                //______________________ Holiday 00:00:00 have id in table fn_scan
                                                                if ($exp_idBy_in[1] == "00:00:00" AND $exp_idBy_out[1] == "00:00:00") {
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                } else {
                                                                    $assoc_in_break = mysqli_fetch_assoc($query_in_idBy_break);
                                                                    $assoc_out_break = mysqli_fetch_assoc($query_out_idBy_break);
                                                                    $exp_in_break = explode(" ", $assoc_in_break["time_datetime"]);
                                                                    $exp_out_break = explode(" ", $assoc_out_break["time_datetime"]);
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                }

                                                            }

                                                            //______________________ Column comment
                                                            if ($exp_idBy_in[1] == "00:00:00" AND $exp_idBy_out[1] == "00:00:00") {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            } else {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            }
                                                            if ($time_status_person != NULL){
                                                                        if($time_status_person == 0) {
                                                                        ?>
                                                                            <td style="background-color:#fee7e8;text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                   <?php
                                                                        }else if ($time_status_person == 1) {
                                                                            ?>
                                                                            <td style="background-color:; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td style="background-color:#E6E1FF; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                         <td style="background-color:#E8FFE1; text-align:center; ">
                                                                        <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                           class="btn btn-xs btn-default">
                                                                            <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                        <?php
                                                                    }
                                                            // IF chk count of sum work day
                                                            if (mysqli_num_rows($query_in_idBy_chk) != 0 || mysqli_num_rows($query_out_idBy_chk) != 0) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);

                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_working += 1;
                                                                else $chk_dayof_working += 0;
                                                            } else $chk_dayof_working += 1;

                                                        } else {

                                                            if (mysqli_num_rows($query_in_idBy_chk) || mysqli_num_rows($query_out_idBy_chk)) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_not_working += 0;
                                                                else $chk_dayof_not_working += 1;

                                                            } else {
                                                                $count_holiday += 1;
                                                                $chk_dayof_not_working += 1;
                                                            }
                                                            echo "<td style='background-color:#fee7e8;'>1</td>";
                                                            echo "<td style='background-color:#fee7e8;'>0</td>";
                                                            $day_not_charge += 1;
                                                            ?>
                                                            <td style='background-color:#fee7e8;'>
                                                                <font><b>วันหยุด</b></font>
                                                            </td>
                                                            <td style="background-color:#fee7e8; text-align:center; ">
                                                                <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>"
                                                                   class="btn btn-xs btn-default">
                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                            </td>
                                                            <?php
                                                        }
                                                        // $chk_work_in_holiday = false;
                                                        





























                                                    } else if ($exp_this_person_holiday[$j] == 3 AND $day_name == "wednesday") {
                                                        if (mysqli_num_rows($query_in_idBy)) {
                                                            $start_time_Byid = mysqli_fetch_assoc($query_in_idBy);
                                                            $exp_time_in = explode(" ", $start_time_Byid["time_datetime"]);
                                                            if ($exp_time_in[1] != "00:00:00") {
                                                                    if ($time_status_person == 0){
                                                                        if ($start_time_Byid["time_transaction"] == "I") {
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else if ($time_status_person == 1){
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else{
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:#E6E1FF;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }

                                                                    }
                                                                } else {

                                                                    echo "<td style='background-color:;'>";
                                                                    echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                }
                                                                echo "</td>";
                                                        } else {
                                                            $chk_holiday++;
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาเข้า</td>
                                                            <?php
                                                        }

                                                        if (mysqli_num_rows($query_out_idBy)) {
                                                            $out_time_Byid = mysqli_fetch_assoc($query_out_idBy);
                                                            $exp_time_out = explode(" ", $out_time_Byid["time_datetime"]);
                                                            if ($exp_time_out[1] != "00:00:00") {
                                                               if ($time_status_person == 0){
                                                                    if($out_time_Byid["time_transaction"] == "O" ) {
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                        }
                                                                }else if ($time_status_person == 1){
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }else{
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:#E6E1FF;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style='background-color:;'>";
                                                                echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                            }
                                                            echo "</td>";
                                                        } else {
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาออก</td>
                                                            <?php
                                                        }

                                                        //______________________ Column break day or day.
                                                        if (mysqli_num_rows($query_in_id) OR mysqli_num_rows($query_out_id)) {
                                                            $assoc_get_in = mysqli_fetch_assoc($query_in_id);
                                                            $assoc_get_out = mysqli_fetch_assoc($query_out_id);
                                                            if ($query_comment_in OR $query_comment_out) {
                                                                $assoc_comment_id = mysqli_fetch_assoc($query_comment_in);
                                                                $assoc_comment_out = mysqli_fetch_assoc($query_comment_out);
                                                            }
                                                            if (mysqli_num_rows($query_in_idBy) != 0 || mysqli_num_rows($query_out_idBy) != 0) {
                                                                $assoc_idBy_in = mysqli_fetch_assoc($query_in_idBy);
                                                                $assoc_idBy_out = mysqli_fetch_assoc($query_out_idBy);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out["time_datetime"]);

                                                                //______________________ Holiday 00:00:00 have id in table fn_scan
                                                                if ($exp_time_in[1] == "00:00:00" AND $exp_time_out[1] == "00:00:00") {

                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                } else {
                                                                    $assoc_in_break = mysqli_fetch_assoc($query_in_idBy_break);
                                                                    $assoc_out_break = mysqli_fetch_assoc($query_out_idBy_break);
                                                                    $exp_in_break = explode(" ", $assoc_in_break["time_datetime"]);
                                                                    $exp_out_break = explode(" ", $assoc_out_break["time_datetime"]);
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                }

                                                            }

                                                            //______________________ Column comment
                                                            if ($exp_time_in[1] == "00:00:00" AND $exp_time_out[1] == "00:00:00") {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            } else {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            }
                                                            if ($time_status_person != NULL){
                                                                        if($time_status_person == 0) {
                                                                        ?>
                                                                            <td style="background-color:#fee7e8;text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                   <?php
                                                                        }else if ($time_status_person == 1) {
                                                                            ?>
                                                                            <td style="background-color:; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td style="background-color:#E6E1FF; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                         <td style="background-color:#E8FFE1; text-align:center; ">
                                                                        <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                           class="btn btn-xs btn-default">
                                                                            <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                        <?php
                                                                    }
                                                            // IF chk count of sum work day
                                                            if (mysqli_num_rows($query_in_idBy_chk) != 0 || mysqli_num_rows($query_out_idBy_chk) != 0) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);

                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_working += 1;
                                                                else $chk_dayof_working += 0;
                                                            } else $chk_dayof_working += 1;

                                                        } else {

                                                            if (mysqli_num_rows($query_in_idBy_chk) || mysqli_num_rows($query_out_idBy_chk)) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_not_working += 0;
                                                                else $chk_dayof_not_working += 1;

                                                            } else {
                                                                $count_holiday += 1;
                                                                $chk_dayof_not_working += 1;
                                                            }
                                                            echo "<td style='background-color:#fee7e8;'>1</td>";
                                                            echo "<td style='background-color:#fee7e8;'>0</td>";
                                                            $day_not_charge += 1;
                                                            ?>
                                                            <td style='background-color:#fee7e8;'>
                                                                <font><b>วันหยุด</b></font>
                                                            </td>
                                                            <td style="background-color:#fee7e8; text-align:center; ">
                                                                <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>"
                                                                   class="btn btn-xs btn-default">
                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                            </td>
                                                            <?php
                                                        }
                                                        $chk_work_in_holiday = false;




























                                                    } else if ($exp_this_person_holiday[$j] == 4 AND $day_name == "thursday") {
                                                        if (mysqli_num_rows($query_in_idBy)) {
                                                            $start_time_Byid = mysqli_fetch_assoc($query_in_idBy);
                                                            $exp_time_in = explode(" ", $start_time_Byid["time_datetime"]);
                                                            if ($exp_time_in[1] != "00:00:00") {
                                                                    if ($time_status_person == 0){
                                                                        if ($start_time_Byid["time_transaction"] == "I") {
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else if ($time_status_person == 1){
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else{
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:#E6E1FF;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }

                                                                    }
                                                                } else {

                                                                    echo "<td style='background-color:;'>";
                                                                    echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                }
                                                                echo "</td>";
                                                        } else {
                                                            $chk_holiday++;
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาเข้า</td>
                                                            <?php
                                                        }

                                                        if (mysqli_num_rows($query_out_idBy)) {
                                                            $out_time_Byid = mysqli_fetch_assoc($query_out_idBy);
                                                            echo "<td style='background-color:#fee7e8;'>";
                                                            $exp_time_out = explode(" ", $out_time_Byid["time_datetime"]);
                                                            if ($exp_time_out[1] != "00:00:00") {
                                                               if ($time_status_person == 0){
                                                                    if($out_time_Byid["time_transaction"] == "O" ) {
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                        }
                                                                }else if ($time_status_person == 1){
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }else{
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:#E6E1FF;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style='background-color:;'>";
                                                                echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                            }
                                                            echo "</td>";
                                                        } else {
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาออก</td>
                                                            <?php
                                                        }

                                                        //______________________ Column break day or day.
                                                        if (mysqli_num_rows($query_in_id) OR mysqli_num_rows($query_out_id)) {
                                                            $assoc_get_in = mysqli_fetch_assoc($query_in_id);
                                                            $assoc_get_out = mysqli_fetch_assoc($query_out_id);
                                                            if ($query_comment_in OR $query_comment_out) {
                                                                $assoc_comment_id = mysqli_fetch_assoc($query_comment_in);
                                                                $assoc_comment_out = mysqli_fetch_assoc($query_comment_out);
                                                            }
                                                            if (mysqli_num_rows($query_in_idBy) != 0 || mysqli_num_rows($query_out_idBy) != 0) {
                                                                $assoc_idBy_in = mysqli_fetch_assoc($query_in_idBy);
                                                                $assoc_idBy_out = mysqli_fetch_assoc($query_out_idBy);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out["time_datetime"]);

                                                                //______________________ Holiday 00:00:00 have id in table fn_scan
                                                                if ($exp_idBy_in[1] == "00:00:00" AND $exp_idBy_out[1] == "00:00:00") {
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                } else {
                                                                    $assoc_in_break = mysqli_fetch_assoc($query_in_idBy_break);
                                                                    $assoc_out_break = mysqli_fetch_assoc($query_out_idBy_break);
                                                                    $exp_in_break = explode(" ", $assoc_in_break["time_datetime"]);
                                                                    $exp_out_break = explode(" ", $assoc_out_break["time_datetime"]);
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                }

                                                            }

                                                            //______________________ Column comment
                                                            if ($exp_idBy_in[1] == "00:00:00" AND $exp_idBy_out[1] == "00:00:00") {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            } else {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            }
                                                            if ($time_status_person != NULL){
                                                                        if($time_status_person == 0) {
                                                                        ?>
                                                                            <td style="background-color:#fee7e8;text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                   <?php
                                                                        }else if ($time_status_person == 1) {
                                                                            ?>
                                                                            <td style="background-color:; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td style="background-color:#E6E1FF; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                         <td style="background-color:#E8FFE1; text-align:center; ">
                                                                        <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                           class="btn btn-xs btn-default">
                                                                            <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                        <?php
                                                                    }
                                                            // IF chk count of sum work day
                                                            if (mysqli_num_rows($query_in_idBy_chk) != 0 || mysqli_num_rows($query_out_idBy_chk) != 0) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);

                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_working += 1;
                                                                else $chk_dayof_working += 0;
                                                            } else $chk_dayof_working += 1;

                                                        } else {

                                                            if (mysqli_num_rows($query_in_idBy_chk) || mysqli_num_rows($query_out_idBy_chk)) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_not_working += 0;
                                                                else $chk_dayof_not_working += 1;

                                                            } else {
                                                                $count_holiday += 1;
                                                                $chk_dayof_not_working += 1;
                                                            }
                                                            echo "<td style='background-color:#fee7e8;'>1</td>";
                                                            echo "<td style='background-color:#fee7e8;'>0</td>";
                                                            $day_not_charge += 1;
                                                            ?>
                                                            <td style='background-color:#fee7e8;'>
                                                                <font><b>วันหยุด</b></font>
                                                            </td>
                                                            <td style="background-color:#fee7e8; text-align:center; ">
                                                                <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>"
                                                                   class="btn btn-xs btn-default">
                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                            </td>
                                                            <?php
                                                        }
                                                        $chk_work_in_holiday = false;







































                                                    } else if ($exp_this_person_holiday[$j] == 5 AND $day_name == "friday") {
                                                        if (mysqli_num_rows($query_in_idBy)) {
                                                            $start_time_Byid = mysqli_fetch_assoc($query_in_idBy);
                                                            $exp_time_in = explode(" ", $start_time_Byid["time_datetime"]);
                                                            if ($exp_time_in[1] != "00:00:00") {
                                                                    if ($time_status_person == 0){
                                                                        if ($start_time_Byid["time_transaction"] == "I") {
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else if ($time_status_person == 1){
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else{
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:#E6E1FF;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }

                                                                    }
                                                                } else {

                                                                    echo "<td style='background-color:;'>";
                                                                    echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                }
                                                                echo "</td>";
                                                        } else {
                                                            $chk_holiday++;
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาเข้า</td>
                                                            <?php
                                                        }

                                                        if (mysqli_num_rows($query_out_idBy)) {
                                                            $out_time_Byid = mysqli_fetch_assoc($query_out_idBy);
                                                            $exp_time_out = explode(" ", $out_time_Byid["time_datetime"]);
                                                            if ($exp_time_out[1] != "00:00:00") {
                                                               if ($time_status_person == 0){
                                                                    if($out_time_Byid["time_transaction"] == "O" ) {
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                        }
                                                                }else if ($time_status_person == 1){
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }else{
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:#E6E1FF;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style='background-color:;'>";
                                                                echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                            }
                                                            echo "</td>";
                                                        } else {
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาออก</td>
                                                            <?php
                                                        }

                                                        //______________________ Column break day or day.
                                                        if (mysqli_num_rows($query_in_id) OR mysqli_num_rows($query_out_id)) {
                                                            $assoc_get_in = mysqli_fetch_assoc($query_in_id);
                                                            $assoc_get_out = mysqli_fetch_assoc($query_out_id);
                                                            if ($query_comment_in OR $query_comment_out) {
                                                                $assoc_comment_id = mysqli_fetch_assoc($query_comment_in);
                                                                $assoc_comment_out = mysqli_fetch_assoc($query_comment_out);
                                                            }
                                                            if (mysqli_num_rows($query_in_idBy) != 0 || mysqli_num_rows($query_out_idBy) != 0) {
                                                                $assoc_idBy_in = mysqli_fetch_assoc($query_in_idBy);
                                                                $assoc_idBy_out = mysqli_fetch_assoc($query_out_idBy);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out["time_datetime"]);

                                                                //______________________ Holiday 00:00:00 have id in table fn_scan
                                                                if ($exp_time_in[1] == "00:00:00" AND $exp_time_out[1] == "00:00:00") {
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                } else {
                                                                    $assoc_in_break = mysqli_fetch_assoc($query_in_idBy_break);
                                                                    $assoc_out_break = mysqli_fetch_assoc($query_out_idBy_break);
                                                                    $exp_in_break = explode(" ", $assoc_in_break["time_datetime"]);
                                                                    $exp_out_break = explode(" ", $assoc_out_break["time_datetime"]);
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                }

                                                            }

                                                            //______________________ Column comment
                                                            if ($exp_time_in[1] == "00:00:00" AND $exp_time_out[1] == "00:00:00") {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            } else {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            }
                                                            if ($time_status_person != NULL){
                                                                        if($time_status_person == 0) {
                                                                        ?>
                                                                            <td style="background-color:#fee7e8;text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                   <?php
                                                                        }else if ($time_status_person == 1) {
                                                                            ?>
                                                                            <td style="background-color:; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td style="background-color:#E6E1FF; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                         <td style="background-color:#E8FFE1; text-align:center; ">
                                                                        <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                           class="btn btn-xs btn-default">
                                                                            <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                        <?php
                                                                    }
                                                            // IF chk count of sum work day
                                                            if (mysqli_num_rows($query_in_idBy_chk) != 0 || mysqli_num_rows($query_out_idBy_chk) != 0) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);

                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_working += 1;
                                                                else $chk_dayof_working += 0;
                                                            } else $chk_dayof_working += 1;

                                                        } else {

                                                            if (mysqli_num_rows($query_in_idBy_chk) || mysqli_num_rows($query_out_idBy_chk)) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_not_working += 0;
                                                                else $chk_dayof_not_working += 1;

                                                            } else {
                                                                $count_holiday += 1;
                                                                $chk_dayof_not_working += 1;
                                                            }
                                                            echo "<td style='background-color:#fee7e8;'>1</td>";
                                                            echo "<td style='background-color:#fee7e8;'>0</td>";
                                                            $day_not_charge += 1;
                                                            ?>
                                                            <td style='background-color:#fee7e8;'>
                                                                <font><b>วันหยุด</b></font>
                                                            </td>
                                                            <td style="background-color:#fee7e8; text-align:center; ">
                                                                <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>"
                                                                   class="btn btn-xs btn-default">
                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                            </td>
                                                            <?php
                                                        }
                                                        $chk_work_in_holiday = false;





































                                                    } else if ($exp_this_person_holiday[$j] == 6 AND $day_name == "saturday") {
                                                        if (mysqli_num_rows($query_in_idBy)) {
                                                            $start_time_Byid = mysqli_fetch_assoc($query_in_idBy);
                                                            $exp_time_in = explode(" ", $start_time_Byid["time_datetime"]);
                                                            if ($exp_time_in[1] != "00:00:00") {
                                                                    if ($time_status_person == 0){
                                                                        if ($start_time_Byid["time_transaction"] == "I") {
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else if ($time_status_person == 1){
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else{
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:#E6E1FF;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }

                                                                    }
                                                                } else {

                                                                    echo "<td style='background-color:;'>";
                                                                    echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                }
                                                                echo "</td>";
                                                        } else {
                                                            $chk_holiday++;
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาเข้า</td>
                                                            <?php
                                                        }

                                                        if (mysqli_num_rows($query_out_idBy)) {
                                                            $out_time_Byid = mysqli_fetch_assoc($query_out_idBy);
                                                            $exp_time_out = explode(" ", $out_time_Byid["time_datetime"]);
                                                            if ($exp_time_out[1] != "00:00:00") {
                                                               if ($time_status_person == 0){
                                                                    if($out_time_Byid["time_transaction"] == "O" ) {
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                        }
                                                                }else if ($time_status_person == 1){
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }else{
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:#E6E1FF;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style='background-color:;'>";
                                                                echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                            }
                                                            echo "</td>";
                                                        } else {
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาออก</td>
                                                            <?php
                                                        }

                                                        //______________________ Column break day or day.
                                                        if (mysqli_num_rows($query_in_id) OR mysqli_num_rows($query_out_id)) {
                                                            $assoc_get_in = mysqli_fetch_assoc($query_in_id);
                                                            $assoc_get_out = mysqli_fetch_assoc($query_out_id);
                                                            if ($query_comment_in OR $query_comment_out) {
                                                                $assoc_comment_id = mysqli_fetch_assoc($query_comment_in);
                                                                $assoc_comment_out = mysqli_fetch_assoc($query_comment_out);
                                                            }
                                                            if (mysqli_num_rows($query_in_idBy) != 0 || mysqli_num_rows($query_out_idBy) != 0) {
                                                                $assoc_idBy_in = mysqli_fetch_assoc($query_in_idBy);
                                                                $assoc_idBy_out = mysqli_fetch_assoc($query_out_idBy);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out["time_datetime"]);

                                                                //______________________ Holiday 00:00:00 have id in table fn_scan
                                                                if ($exp_idBy_in[1] == "00:00:00" AND $exp_idBy_out[1] == "00:00:00") {
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                } else {
                                                                    $assoc_in_break = mysqli_fetch_assoc($query_in_idBy_break);
                                                                    $assoc_out_break = mysqli_fetch_assoc($query_out_idBy_break);
                                                                    $exp_in_break = explode(" ", $assoc_in_break["time_datetime"]);
                                                                    $exp_out_break = explode(" ", $assoc_out_break["time_datetime"]);
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                }

                                                            }

                                                            //______________________ Column comment
                                                            if ($exp_idBy_in[1] == "00:00:00" AND $exp_idBy_out[1] == "00:00:00") {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            } else {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            }
                                                            if ($time_status_person != NULL){
                                                                        if($time_status_person == 0) {
                                                                        ?>
                                                                            <td style="background-color:#fee7e8;text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                   <?php
                                                                        }else if ($time_status_person == 1) {
                                                                            ?>
                                                                            <td style="background-color:; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td style="background-color:#E6E1FF; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                         <td style="background-color:#E8FFE1; text-align:center; ">
                                                                        <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                           class="btn btn-xs btn-default">
                                                                            <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                        <?php
                                                                    }
                                                            // IF chk count of sum work day
                                                            if (mysqli_num_rows($query_in_idBy_chk) != 0 || mysqli_num_rows($query_out_idBy_chk) != 0) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);

                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_working += 1;
                                                                else $chk_dayof_working += 0;
                                                            } else $chk_dayof_working += 1;

                                                        } else {

                                                            if (mysqli_num_rows($query_in_idBy_chk) || mysqli_num_rows($query_out_idBy_chk)) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_not_working += 0;
                                                                else $chk_dayof_not_working += 1;

                                                            } else {
                                                                $count_holiday += 1;
                                                                $chk_dayof_not_working += 1;
                                                            }
                                                            echo "<td style='background-color:#fee7e8;'>1</td>";
                                                            echo "<td style='background-color:#fee7e8;'>0</td>";
                                                            $day_not_charge += 1;
                                                            ?>
                                                            <td style='background-color:#fee7e8;'>
                                                                <font><b>วันหยุด</b></font>
                                                            </td>
                                                            <td style="background-color:#fee7e8; text-align:center; ">
                                                                <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>"
                                                                   class="btn btn-xs btn-default">
                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                            </td>
                                                            <?php
                                                        }
                                                        $chk_work_in_holiday = false;











































                                                    } else if ($exp_this_person_holiday[$j] == 7 AND $day_name == "sunday") {
                                                        if (mysqli_num_rows($query_in_idBy)) {
                                                            $start_time_Byid = mysqli_fetch_assoc($query_in_idBy);
                                                            $exp_time_in = explode(" ", $start_time_Byid["time_datetime"]);
                                                            if ($exp_time_in[1] != "00:00:00") {
                                                                    if ($time_status_person == 0){
                                                                        if ($start_time_Byid["time_transaction"] == "I") {
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#fee7e8'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else if ($time_status_person == 1){
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else{
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:#E6E1FF;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }

                                                                    }
                                                                } else {

                                                                    echo "<td style='background-color:#fee7e8;'>";
                                                                    echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                }
                                                                echo "</td>";
                                                        } else {
                                                            $chk_holiday++;
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาเข้า</td>
                                                            <?php
                                                        } 

                                                        if (mysqli_num_rows($query_out_idBy)) {
                                                            $out_time_Byid = mysqli_fetch_assoc($query_out_idBy);
                                                            $exp_time_out = explode(" ", $out_time_Byid["time_datetime"]);
                                                           if ($exp_time_out[1] != "00:00:00") {
                                                               if ($time_status_person == 0){
                                                                    if($out_time_Byid["time_transaction"] == "O" ) {
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#fee7e8'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                        }
                                                                }else if ($time_status_person == 1){
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }else{
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:#E6E1FF;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }
                                                            }  else {
                                                                    echo "<td style='background-color:#fee7e8;'>";
                                                                    echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                            }
                                                            echo "</td>";
                                                        } else {
                                                            ?>
                                                            <td style="background-color:#fee7e8;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาออก</td>
                                                            <?php
                                                        }

                                                        //______________________ Column break day or day.
                                                        if (mysqli_num_rows($query_in_id) OR mysqli_num_rows($query_out_id)) {
                                                            $assoc_get_in = mysqli_fetch_assoc($query_in_id);
                                                            $assoc_get_out = mysqli_fetch_assoc($query_out_id);
                                                            if ($query_comment_in OR $query_comment_out) {
                                                                $assoc_comment_id = mysqli_fetch_assoc($query_comment_in);
                                                                $assoc_comment_out = mysqli_fetch_assoc($query_comment_out);
                                                            }
                                                            if (mysqli_num_rows($query_in_idBy) != 0 || mysqli_num_rows($query_out_idBy) != 0) {
                                                                $assoc_idBy_in = mysqli_fetch_assoc($query_in_idBy);
                                                                $assoc_idBy_out = mysqli_fetch_assoc($query_out_idBy);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out["time_datetime"]);

                                                                //______________________ Holiday 00:00:00 have id in table fn_scan
                                                                if ($exp_idBy_in[1] == "00:00:00" AND $exp_idBy_out[1] == "00:00:00") {
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                } else {
                                                                    $assoc_in_break = mysqli_fetch_assoc($query_in_idBy_break);
                                                                    $assoc_out_break = mysqli_fetch_assoc($query_out_idBy_break);
                                                                    $exp_in_break = explode(" ", $assoc_in_break["time_datetime"]);
                                                                    $exp_out_break = explode(" ", $assoc_out_break["time_datetime"]);
                                                                     if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            if($time_status_person == 0){
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#fee7e8;'>1</td>
                                                                                <td style='background-color:#fee7e8;'>0</td>
                                                                            <?php
                                                                            }else if ($time_status_person == 1){
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:;'>1</td>
                                                                                <td style='background-color:;'>0</td>
                                                                            <?php
                                                                            }else{
                                                                                $count_holiday += 1;
                                                                                ?>
                                                                                <td style='background-color:#E6E1FF;'>1</td>
                                                                                <td style='background-color:#E6E1FF;'>0</td>
                                                                            <?php
                                                                            }
                                                                        }
                                                                }
                                                            }

                                                            //______________________ Column comment
                                                            if ($exp_idBy_in[1] == "00:00:00" AND $exp_idBy_out[1] == "00:00:00") {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            } else {
                                                                if ($time_status_person == 0) {
                                                                    ?>
                                                                    <td style='background-color:#fee7e8;'>
                                                                        <font><b>วันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else if ($time_status_person == 1){
                                                                    ?>
                                                                    <td style='background-color:;'>
                                                                        <font><b>ลาป่วย (มีใบรับรองเพทย์)</b></font>
                                                                    </td>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <td style='background-color:#E6E1FF;'>
                                                                        <font><b>ทำงานในวันหยุด</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            }
                                                            if ($time_status_person != NULL){
                                                                        if($time_status_person == 0) {
                                                                        ?>
                                                                            <td style="background-color:#fee7e8;text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                   <?php
                                                                        }else if ($time_status_person == 1) {
                                                                            ?>
                                                                            <td style="background-color:; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td style="background-color:#E6E1FF; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                         <td style="background-color:#E8FFE1; text-align:center; ">
                                                                        <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                           class="btn btn-xs btn-default">
                                                                            <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                        <?php
                                                                    }

                                                            // IF chk count of sum work day
                                                            if (mysqli_num_rows($query_in_idBy_chk) != 0 || mysqli_num_rows($query_out_idBy_chk) != 0) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);

                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_working += 1;
                                                                else $chk_dayof_working += 0;
                                                            } else $chk_dayof_working += 1;

                                                        } else {

                                                            if (mysqli_num_rows($query_in_idBy_chk) || mysqli_num_rows($query_out_idBy_chk)) {
                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);
                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_not_working += 0;
                                                                else $chk_dayof_not_working += 1;
                                                            } else {
                                                                $count_holiday += 1;
                                                                $chk_dayof_not_working += 1;
                                                            }
                                                            echo "<td style='background-color:#fee7e8;'>1</td>";
                                                            echo "<td style='background-color:#fee7e8;'>0</td>";
                                                            $day_not_charge += 1;
                                                            ?>
                                                            <td style='background-color:#fee7e8;'>
                                                                <font><b>วันหยุด</b></font>
                                                            </td>
                                                            <td style="background-color:#fee7e8; text-align:center; ">
                                                                <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>"
                                                                   class="btn btn-xs btn-default">
                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                            </td>
                                                            <?php
                                                        }
                                                        $chk_work_in_holiday = false;















































                                                    } else {
                                                        $count_not_holiday += 1;
                                                        if ($count_not_holiday == count($exp_this_person_holiday)) {
                                                            $count_working += 1;

                                                            // ___________________ if check in time
                                                            if (mysqli_num_rows($query_in)) {
                                                                $start_time = mysqli_fetch_assoc($query_in);
                                                                echo "<td>";
                                                                $exp_time_in = explode(" ", $start_time["time_datetime"]);
                                                                if ($exp_time_in[1] != "00:00:00") echo $exp_time_in[1];
                                                                else {
                                                                    echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                    // echo $exp_time_in[1];
                                                                    // $chk_leave_day += 1;
                                                                }
                                                                echo "</td>";
                                                            } else {
                                                                $chk_holiday++;
                                                                ?>
                                                                <td style="color:#DC143C; font-weight: bold;">ไม่ได้แสกนเวลาเข้า</td>
                                                                <?php
                                                            }
                                                            // ___________________ if check out time
                                                            if (mysqli_num_rows($query_out)) {
                                                                $out_time = mysqli_fetch_assoc($query_out);
                                                                echo "<td>";
                                                                $exp_time_out = explode(" ", $out_time["time_datetime"]);
                                                                if ($exp_time_out[1] != "00:00:00") echo $exp_time_out[1];
                                                                else {

                                                                echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    // echo $exp_time_out[1];
                                                                    // $chk_leave_day += 1;
                                                                }
                                                                echo "</td>";
                                                            } else { // if check holiday OR Leave working.
                                                                ?>
                                                                <td style="color:#DC143C; font-weight: bold;">ไม่ได้แสกนเวลาออก</td>
                                                                <?php
                                                            }

                                                            if (mysqli_num_rows($query_in_idBy_break) AND mysqli_num_rows($query_out_idBy_break)) {// check วันที่หัก and วันที่ไม่หัก
                                                                if (mysqli_num_rows($query_in_idBy_break) || mysqli_num_rows($query_out_idBy_break)) {
                                                                    if (mysqli_num_rows($query_in_idBy_break)) $assoc_in_break = mysqli_fetch_assoc($query_in_idBy_break);
                                                                    if (mysqli_num_rows($query_out_idBy_break)) $assoc_out_break = mysqli_fetch_assoc($query_out_idBy_break);
                                                                    $exp_in = explode(" ", $assoc_in_break["time_datetime"]);
                                                                    $exp_out = explode(" ", $assoc_out_break["time_datetime"]);
                                                                    if ($exp_in[1] == "00:00:00" AND $exp_out[1] == "00:00:00" AND $assoc_in_break["time_status"] != 1 AND $assoc_out_break["time_status"] != 1) {
                                                                        $day_charge += 1;
                                                                        ?>
                                                                        <td>0</td>
                                                                        <td>1</td>
                                                                        <?php
                                                                    } else {
                                                                        $chk_dayof_working += 1;
//                                                                        echo "<td>work :$chk_dayof_working | holiday $count_holiday | sick : $count_status_sick</td>";
                                                                        if ($assoc_in_break["time_status"] == 1 OR $assoc_out_break["time_status"] == 1) {// IF time_status = 1
                                                                            ?>
                                                                            <td>1</td>
                                                                            <td>0</td>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }

                                                            } else {
                                                                $chk_work_in_holiday = true;
                                                                if ($chk_work_in_holiday == true) {
                                                                    if (mysqli_num_rows($query_in_idBy_break)) $assoc_in_break = mysqli_fetch_assoc($query_in_idBy_break);
                                                                    if (mysqli_num_rows($query_out_idBy_break)) $assoc_out_break = mysqli_fetch_assoc($query_out_idBy_break);
//                                                                     if ($assoc_in_break["time_status"] == 1 OR $assoc_out_break["time_status"] == 1) { // IF time_status = 1
//                                                                         $count_work_in_holiday += 0;
// //                                                                        $count_status_sick += 1;
//                                                                     } else $count_work_in_holiday += 1;
                                                                    $day_charge += 1;
                                                                    echo "<td>0</td>";
                                                                    echo "<td>1</td>";
                                                                }

                                                                $chk_dayof_not_working += 1;
                                                                $day_not_charge += 1;
                                                            }

                                                            if ($chk_work_in_holiday == false) {
                                                                ?>
                                                                <td>
                                                                    <?php

                                                                    if ($chk_leave_day == 2) {
                                                                        echo "work :$chk_dayof_working | holiday $count_holiday | sick : $chk_dayof_not_working";
                                                                        echo "<b style='color:red'>ขาดงาน</b>";
                                                                    } else {
                                                                        if (mysqli_num_rows($query_in_idBy_workday)) {
                                                                            $assoc_in_Byid = mysqli_fetch_assoc($query_in_idBy_workday);
                                                                            $exp_Byid_in = explode(" ", $assoc_in_Byid["time_datetime"]);
                                                                        }
                                                                        if (mysqli_num_rows($query_out_idBy_workday)) {
                                                                            $assoc_out_Byid = mysqli_fetch_assoc($query_out_idBy_workday);
                                                                            $exp_Byid_out = explode(" ", $assoc_out_Byid["time_datetime"]);
                                                                        }

                                                                        if ($exp_Byid_in[1] == "00:00:00" AND $exp_Byid_out[1] == "00:00:00") {
                                                                            if ($assoc_in_Byid["time_status"] == 1 AND $assoc_out_Byid["time_status"] == 1) {
                                                                                echo "<b>ลาป่วยมีใบรับรองแพทย์</b>";
                                                                                $count_holiday += 1;
                                                                                // $count_status_sick += 1;
                                                                            } else if ($assoc_in_Byid["time_status"] == 2 AND $assoc_out_Byid["time_status"] == 2 ) {
                                                                                echo "<b>ทำงานในวันหยุด</b>";
                                                                                $work_on_holiday += 1;
                                                                            }else {echo "<b style='color:red'>ขาดงาน</b>";
                                                                            }
                                                                        } else {
                                                                            if ($assoc_in_Byid["time_status"] == 1 || $assoc_out_Byid["time_status"] == 1) {echo "<b>ลาป่วยมีใบรับรองแพทย์</b>"; 
                                                                        } else if ($assoc_in_Byid["time_status"] == 2 || $assoc_out_Byid["time_status"] == 2 ){
                                                                            echo "<b>ทำงานในวันหยุด</b>";
                                                                        }
                                                                            else {
                                                                                if (mysqli_num_rows($query_comment_in) OR mysqli_num_rows($query_comment_out) != 0) {
                                                                                    $assoc_comment_id = mysqli_fetch_assoc($query_comment_in);
                                                                                    $assoc_comment_out = mysqli_fetch_assoc($query_comment_out);
                                                                                }

                                                                                if ($query_comment_in) echo "<b>" . $assoc_comment_id["time_comment"] . "</b>";
                                                                                else if ($query_comment_out) echo "<b>" . $assoc_comment_out["time_comment"] . "</b>";
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <?php
                                                                if (mysqli_num_rows($query_in_idBy) OR mysqli_num_rows($query_out_idBy)) {
                                                                    $assoc_in_Byid = mysqli_fetch_assoc($query_in_idBy);
                                                                    $assoc_out_Byid = mysqli_fetch_assoc($query_out_idBy);
                                                                    ?>
                                                                    <td style="text-align:center;">
                                                                        <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&in_id=<?= $assoc_in_Byid["time_id"] ?>&out_id=<?= $assoc_out_Byid["time_id"] ?>"
                                                                           class="btn btn-xs btn-default">
                                                                            <span class="fa fa-cogs">  | แก้ไข </span></a>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            } else {
                                                                $assoc_in_Byid = mysqli_fetch_assoc($query_in_idBy);
                                                                $assoc_out_Byid = mysqli_fetch_assoc($query_out_idBy);

                                                                if ($chk_leave_day == 2) echo "<td><b style='color:red'>ขาดงาน</b></td>";
                                                                if (mysqli_num_rows($query_in_idBy_workday)) $assoc_in_Byid = mysqli_fetch_assoc($query_in_idBy_workday);
                                                                if (mysqli_num_rows($query_out_idBy_workday)) $assoc_out_Byid = mysqli_fetch_assoc($query_out_idBy_workday);

                                                                if ($assoc_in_Byid["time_status"] == 1 AND $assoc_out_Byid["time_status"] == 1) echo "<td><b>ลาป่วยมีใบรับรองแพทย์</b></td>";
                                                                else echo "<td><b style='color:red'>ขาดงาน</b></td>";

                                                                if (!mysqli_num_rows($query_in_id) OR !mysqli_num_rows($query_out_id)) {
                                                                    $assoc_in_id = mysqli_fetch_assoc($query_in_id);
                                                                    $assoc_out_id = mysqli_fetch_assoc($query_out_id);
                                                                    ?>
                                                                    <td style="text-align:center;">
                                                                        <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>"
                                                                           class="btn btn-xs btn-default">
                                                                            <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                    </td>
                                                                    <?php
                                                                }
                                                            }
                                                            break;
                                                        }
                                                    } // close if conditions
                                                } //close if !=0



























                                                } else  { //________holiday of year


                                                $sql_select_time_status = "
                                                    SELECT time_status FROM fn_scan 
                                                    WHERE scanfile_id='$file_id' 
                                                    AND time_machine_count='{$assoc_name["time_machine_count"]}' 
                                                    AND time_datetime LIKE '%$chk_time_min%'
                                                    ORDER BY time_datetime DESC
                                                ";
                                                
                                                $query_select_time_status = mysqli_query($conn ,$sql_select_time_status);
                                                $num_time_status = mysqli_num_rows($query_select_time_status);
                                                list($time_status) = mysqli_fetch_row($query_select_time_status);
                                                $time_status_person = $time_status;
                                                

                                                    if (mysqli_num_rows($query_in_idBy)) {
                                                            $start_time_Byid = mysqli_fetch_assoc($query_in_idBy);
                                                            $exp_time_in = explode(" ", $start_time_Byid["time_datetime"]);
                                                                if ($exp_time_in[1] != "00:00:00") {
                                                                    if ($time_status_person == 0){
                                                                        if ($start_time_Byid["time_transaction"] == "I") {
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else if ($time_status_person == 1){
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }
                                                                    }else{
                                                                        if ($start_time_Byid["time_transaction"] == "I"){
                                                                            echo "<td style='background-color:#E6E1FF;'>";
                                                                            echo $exp_time_in[1];
                                                                        }else{
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                        }

                                                                    }
                                                                } else {
                                                                            echo "<td style='background-color:#E8FFE1;'>";
                                                                            echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาเข้า</b>";
                                                                }
                                                                echo "</td>";
                                                        } else {
                                                            $chk_holiday++;
                                                            ?>
                                                            <td style="background-color:#E8FFE1;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาเข้า</td>
                                                            <?php
                                                        }
                                                    if (mysqli_num_rows($query_out_idBy)) {
                                                            $out_time_Byid = mysqli_fetch_assoc($query_out_idBy);
                                                            $exp_time_out = explode(" ", $out_time_Byid["time_datetime"]);
                                                            if ($exp_time_out[1] != "00:00:00") {
                                                               if ($time_status_person == 0){
                                                                    if($out_time_Byid["time_transaction"] == "O" ) {
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                        }
                                                                }else if ($time_status_person == 1){
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }else{
                                                                    if($out_time_Byid["time_transaction"] == "O" ){
                                                                        echo "<td style='background-color:#E6E1FF;'>";
                                                                        echo $exp_time_out[1];
                                                                    }else{
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                                    }
                                                                }
                                                            } else {
                                                                        echo "<td style='background-color:#E8FFE1;'>";
                                                                        echo "<b style='color:#DC143C;'>ไม่ได้แสกนเวลาออก</b>";
                                                            }
                                                            echo "</td>";
                                                        } else {
                                                            ?>
                                                            <td style="background-color:#E8FFE1;"><b style="color:#DC143C;">ไม่ได้แสกนเวลาออก</b></td>
                                                            <?php
                                                        }
                                                    
                                                    //___________________________


                                                        if (mysqli_num_rows($query_in_id) OR mysqli_num_rows($query_out_id)) {
                                                                $assoc_get_in = mysqli_fetch_assoc($query_in_id);
                                                                $assoc_get_out = mysqli_fetch_assoc($query_out_id);
                                                                if ($query_comment_in OR $query_comment_out) {
                                                                    $assoc_comment_id = mysqli_fetch_assoc($query_comment_in);
                                                                    $assoc_comment_out = mysqli_fetch_assoc($query_comment_out);
                                                                }
                                                                if (mysqli_num_rows($query_in_idBy) != 0 || mysqli_num_rows($query_out_idBy) != 0) {
                                                                    $assoc_idBy_in = mysqli_fetch_assoc($query_in_idBy);
                                                                    $assoc_idBy_out = mysqli_fetch_assoc($query_out_idBy);
                                                                    $exp_idBy_in = explode(" ", $assoc_idBy_in["time_datetime"]);
                                                                    $exp_idBy_out = explode(" ", $assoc_idBy_out["time_datetime"]);

                                                                    //______________________ Holiday 00:00:00 have id in table fn_scan

                                                                        
                                                                    if ($exp_time_in[1] !== "00:00:00" AND $exp_time_out[1] !== "00:00:00") {
                                                                        // echo "<td>".$exp_time_in[1]."</td>";
                                                                        // echo "<td>".print_r($assoc_idBy_in)."</td>";
                                                                        if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E8FFE1;'>1</td>
                                                                                <td style='background-color:#E8FFE1;'>0</td>
                                                                            <?php
                                                                            }
                                                                    } else {
                                                                        $assoc_in_break = mysqli_fetch_assoc($query_in_idBy_break);
                                                                        $assoc_out_break = mysqli_fetch_assoc($query_out_idBy_break);
                                                                        $exp_in_break = explode(" ", $assoc_in_break["time_datetime"]);
                                                                        $exp_out_break = explode(" ", $assoc_out_break["time_datetime"]);
                                                                        // $chk_dayof_not_working += 1;
                                                                        if ($time_status_person == 2) {
                                                                            $work_on_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                                <td style='background-color:#E6E1FF'></td>
                                                                            <?php
                                                                        }else{
                                                                            $count_holiday += 1;
                                                                            ?>
                                                                                <td style='background-color:#E8FFE1;'>1</td>
                                                                                <td style='background-color:#E8FFE1;'>0</td>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                    //______________________ Column comment
                                                                    if ($exp_time_in[1] !== "00:00:00" AND $exp_time_out[1] !== "00:00:00") {

                                                                        if ($time_status_person == 0){
                                                                            ?>
                                                                            <td style='background-color:#E8FFE1;'>
                                                                            <font><b><?=$year_holiday_title?></b></font>
                                                                            </td>
                                                                            <?php
                                                                        }else if ($time_status_person == 1) {
                                                                            ?>
                                                                            <td style='background-color:#E8FFE1;'>
                                                                            <font><b>ลาป่วยมีใบรับรองแพทย์</b></font>
                                                                            </td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                        <td style='background-color:#E6E1FF'>
                                                                            <font><b>ทำงานในวันหยุด</b></font>
                                                                        </td>
                                                                        <?php
                                                                        }
                                                                        
                                                                    } else {
                                                                        if ($time_status_person == 0 ){            
                                                                            ?>
                                                                            <td style='background-color:#E8FFE1;'>
                                                                                <font><b><?=$year_holiday_title ?></b></font>
                                                                            </td>
                                                                            <?php
                                                                        }else if ($time_status_person == 1 ){
                                                                            ?>
                                                                            <td style='background-color:#E8FFE1;'>
                                                                                <font><b>ลาป่วยมีใบรับรองแพทย์</b></font>
                                                                            </td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td style='background-color:#E6E1FF'>
                                                                                <font><b>ทำงานในวันหยุด</b></font>
                                                                            </td>
                                                                        <?php
                                                                        }
                                                                      //#e6ffee #E8FFE1
                                                                    }
                                                                    if ($time_status_person != NULL){
                                                                        if($time_status_person == 0) {
                                                                    ?>
                                                                            <td style="background-color:#E8FFE1;text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                   <?php
                                                                        }else if ($time_status_person == 1) {
                                                                            ?>
                                                                            <td style="background-color:#E8FFE1; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td style="background-color:#E6E1FF; text-align:center; ">
                                                                                <a href="index.php?mod=fn/form_subedit_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                                   class="btn btn-xs btn-default">
                                                                                    <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                            </td>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                         <td style="background-color:#E8FFE1; text-align:center; ">
                                                                        <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>&in_id=<?= $start_time_Byid["time_id"] ?>&out_id=<?= $out_time_Byid["time_id"] ?>"
                                                                           class="btn btn-xs btn-default">
                                                                            <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                        <?php
                                                                    }

                                                                    // IF chk count of sum work day
                                                                            if (mysqli_num_rows($query_in_idBy_chk) != 0 || mysqli_num_rows($query_out_idBy_chk) != 0) {
                                                                                if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                                if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);

                                                                                $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                                $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                                if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_working += 1;
                                                                                else $chk_dayof_working += 0;
                                                                            } else $chk_dayof_working += 1;


                                                                    } else {

                                                                        if (mysqli_num_rows($query_in_idBy_chk) || mysqli_num_rows($query_out_idBy_chk)) {
                                                                            if (mysqli_num_rows($query_in_idBy_chk)) $assoc_idBy_in_chk = mysqli_fetch_assoc($query_in_idBy_chk);
                                                                            if (mysqli_num_rows($query_out_idBy_chk)) $assoc_idBy_out_chk = mysqli_fetch_assoc($query_out_idBy_chk);
                                                                            $exp_idBy_in = explode(" ", $assoc_idBy_in_chk["time_datetime"]);
                                                                            $exp_idBy_out = explode(" ", $assoc_idBy_out_chk["time_datetime"]);
                                                                            if ($exp_idBy_in[1] != "00:00:00" OR $exp_idBy_out[1] != "00:00:00") $chk_dayof_not_working += 0;
                                                                            else $chk_dayof_not_working += 1;

                                                                        } else {
                                                                            $count_holiday += 1;
                                                                            $chk_dayof_not_working += 1;
                                                                        }
                                                                        echo "<td style='background-color:#E8FFE1;'>1</td>";
                                                                        echo "<td style='background-color:#E8FFE1;'>0</td>";
                                                                        $day_not_charge += 1;
                                                                        ?>
                                                                        <td style='background-color:#E8FFE1;'>
                                                                            
                                                                            <font><b>
                                                                                <?= $year_holiday_title?>
                                                                            </b></font>
                                                                        </td>
                                                                        <td style="background-color:#E8FFE1; text-align:center; ">
                                                                            <a href="index.php?mod=fn/form_subadd_time&count_id=<?= $_GET["count_id"] ?>&file_id=<?= $_GET["file_id"] ?>&date=<?= $date_time_min ?>"
                                                                               class="btn btn-xs btn-default">
                                                                                <span class="fa fa-cogs">  | แก้ไข</span></a>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    $chk_work_in_holiday = false;
                                                                        
                                                //     if (strtotime($start_holiday_date) < $end_holiday_date){     
                                                //         $start_holiday_date = strtotime($start_holiday_date ."+1 day");

                                                //     }else {
                                                    
                                                // }
                                                                    break;
                                            }
                                            } // close for loop

                                            $str_time_min = strtotime("+ 1 days", $str_time_min); // more day of each month #important
                                            $count_loop += 1; // count of while loop
                                            echo "</tr>";
                                        }
                                        ?>
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
                                            <tr>
                                                <?php
                                                //                                            echo "one : $chk_dayof_working";
                                                //                                            echo "two : $day_charge";
                                                //                                            echo "three : $count_holiday";
                                                //                                            echo "four : ".$count_status_sick;
                                                $sql_select_day_outandin = "SELECT salary_work_day,salary_expense_leave FROM fn_salary WHERE person_id = '{$assoc_name["person_id"]}'";
                                                $query_select_day_outandin = mysqli_query($conn, $sql_select_day_outandin) or die ("Sql error is : ". mysqli_error($conn));
                                                list($salary_work_day,$salary_expense_leave) = mysqli_fetch_row($query_select_day_outandin);



                                                // if ($count_status_sick > 0) {
                                                //     $chk_dayof_working -= $count_status_sick;
                                                //     $count_holiday += $count_status_sick;
                                                // }
                                                $dayof_working =$salary_work_day - $count_holiday - $day_charge;
                                                $dayof_charge = $day_charge;
                                                $dayof_holiday = $count_holiday;
                                                ?>

                                                <td style="text-align:center;">
                                                    <?php
                                                    if ($chk_dayof_working != 0) echo $dayof_working  . " วัน" ." ( ทำงานในวันหยุด " . $work_on_holiday ." วัน )";
                                                    else echo " 0 วัน";
                                                    
                                                    ?>
                                                </td>
                                                <td style="text-align:center;">
                                                    <?php
                                                    if ($day_charge != 0) echo $dayof_charge . " วัน";
                                                    else echo $dayof_charge . " วัน";
                                                    
                                                    
                                                    ?>
                                                </td>
                                                <td style="text-align:center;">
                                                    <?php
                                                    if ($count_holiday != 0) echo $dayof_holiday . " วัน";
                                                    else echo " 0 วัน";
                                                    
                                                    ?>
                                                </td>
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
                                    <?php
                                    $sql_select_calculate = "
                                        SELECT * FROM fn_calculate_date 
                                        WHERE scanfile_id = '$file_id' 
                                        AND person_id = '{$assoc_name["person_id"]}'
                                    ";
                                    $query_select_calculate = mysqli_query($conn, $sql_select_calculate);
                                    $query_num_rows = mysqli_num_rows($query_select_calculate);

                                    $query_num_rows;
                                    if ($query_num_rows === 0){
                                        $sql_insert_calculate = "INSERT INTO fn_calculate_date 
                                        SET scanfile_id = ' $file_id',
                                        person_id = '{$assoc_name["person_id"]}',
                                        calculate_pay = '$dayof_working',
                                        calculate_no_cut = '$dayof_holiday',
                                        calculate_cut_pay = '$dayof_charge',
                                        calculate_work_on_holiday = '$work_on_holiday'
                                        ";
                                        $query_insert_calculate = mysqli_query($conn,$sql_insert_calculate);
                                    }else{
                                        $sql_update_calculate = "UPDATE fn_calculate_date 
                                        SET calculate_pay = '$dayof_working',
                                        calculate_no_cut = '$dayof_holiday',
                                        calculate_cut_pay = '$dayof_charge',
                                        calculate_work_on_holiday = '$work_on_holiday'
                                        WHERE scanfile_id = '$file_id' AND person_id = '{$assoc_name["person_id"]}'
                                        ";
                                        $query_update_calculate = mysqli_query($conn,$sql_update_calculate);
                                    }
                                    

                                    ?>
<script>

    $(document).ready(function () {

        $('.dataTables-example').DataTable({
            // dom: '<"html5buttons"B>lTfgitp',
            // buttons: [],
            "language": {
                "sProcessing": "กำลังดำเนินการ...",
                "sLengthMenu": "แสดง  _MENU_  แถว",
                "sZeroRecords": "ไม่พบข้อมูล",
                "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                "sInfoPostFix": "",
                "sSearch": "ค้นหา:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "เิริ่มต้น",
                    "sPrevious": "ก่อนหน้า",
                    "sNext": "ถัดไป",
                    "sLast": "สุดท้าย"
                }
            }
        });

    });



</script>

