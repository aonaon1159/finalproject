<?php
/**
 * Created by PhpStorm.
 * User: Avaibooking
 * Date: 1/22/2018
 * Time: 4:47 PM
 */
if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

$uID = ($_SESSION["uID"]);
$createDate = date("Y/m/d H:i:s");

if ($_POST['hidden_add_id']) {
    // _________________________________ Process employment
    // Variable of end date of work
    if (isset($_POST['employment_start_date'])) $employment_start_date = $_POST['employment_start_date'];

    //Process age of work
    list($emp_year, $emp_month, $emp_day) = explode("-", $employment_start_date);
    if (!empty($_POST['employment_end_date'])) {
        list($end_year, $end_month, $end_day) = explode("-", $_POST['employment_end_date']);
        $age = ($end_year - $emp_year);
    } else {
        $age = 0;
    }

    if(!empty($_POST['time_start'])) $time_start = $_POST['time_start'];
    else $time_start = "";
    if(!empty($_POST['time_end'])) $time_end = $_POST['time_end'];
    else $time_end = "";

    $sql_insert_employment = "
      INSERT INTO hr_person_employment SET person_id='{$_POST["hidden_add_id"]}',
      employment_department='{$_POST["employment_department"]}', 
      employment_position='{$_POST["employment_position"]}',
      employment_money='{$_POST["employment_money"]}', 
      employment_status='{$_POST["employment_status"]}', 
      employment_work_status='{$_POST["working_status"]}', 
      employment_break_status='{$_POST["break_status"]}', 
      employment_start_date='$employment_start_date', 
      employment_age='$age',
      employment_time_start='$time_start',
      employment_time_end='$time_end'
    ";

    if (!empty($_POST['start_social_insurance_date'])) {
        $sql_insert_employment .= ",employment_start_social_insurance='{$_POST["start_social_insurance_date"]}' ";
    }

    if (!empty($_POST['employment_end_date'])) {
        $sql_insert_employment .= "
            ,employment_finish_date='{$_POST["employment_end_date"]}',
            employment_reason_endwork='{$_POST["employment_end_reason"]}',
            employment_out_social_insurance='{$_POST["out_social_insurance_date"]}'
        ";
    }

    //'$createDate','$uID','0','$createDate','0'
    if (!empty($_POST['employment_break_start'])) {
        $sql_insert_employment .= ",employment_start_break='{$_POST["employment_break_start"]}',employment_finish_break='{$_POST["employment_break_finish"]}',employment_reason_break='{$_POST["employment_break_reason"]}' ";
    }

    // _________________________________ Process Hr_person_holiday
    $str_data = "";
    if (isset($_POST["holiday"])) {
        $count_holiday = 0;
        foreach ($_POST["holiday"] as $temp) {
            if (count($_POST["holiday"]) <= 1)
                $str_data = $temp;
            else {
                if ($count_holiday == 0) $str_data = $temp . ",";
                else if ($count_holiday == ((count($_POST["holiday"])) - 1)) $str_data .= $temp;
                else $str_data .= $temp . ",";
            }
            $count_holiday += 1;
        }
    } else {
        $str_data = "0";
    }

    $sql_insert_person_holiday = "
      INSERT INTO hr_person_holiday SET 
      person_id='{$_POST["hidden_add_id"]}',
      holiday_value='$str_data',
      holiday_createBy='$uID',
      holiday_createDate='$createDate',
      holiday_updateBy='0',
      holiday_updateDate='$createDate',
      deleted='0'
    ";

//    echo "sql : ".$sql_insert_employment;
//    echo "<br> sql : ".$sql_insert_person_holiday;
//    exit();

    $query_insert_employment = mysqli_query($conn, $sql_insert_employment) or die("Sql error : " . mysqli_error($conn));
    $query_insert_person_holiday = mysqli_query($conn, $sql_insert_person_holiday) or die("Sql holiday error : " . mysqli_error($conn));
    if ($query_insert_employment AND $query_insert_person_holiday) mysqli_close($conn);
}
?>
<script>
    alert("เพิ่มข้อมูลสถานะการทำงาน เรียบร้อยแล้ว!");
    window.location = "index.php?mod=hr/manage_person";
</script>
