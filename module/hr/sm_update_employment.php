<?php


if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");

$uID = ($_SESSION["uID"]);
$updateDate = date("Y/m/d H:i:s");

if ($_POST['hidden_edit_id'] || $_POST['hidden_employ_id']) {

    // Variable of end date of work //Process age of work
    if (!empty($_POST['employment_start_date'])) {
        $employment_start_date = $_POST['employment_start_date'];
        if ($employment_start_date != NULL) {
            list($emp_year, $emp_month, $emp_day) = explode("-", $employment_start_date);
            if (!empty($_POST['employment_end_date'])) {
                $employment_end_date = $_POST['employment_end_date'];
                list($end_year, $end_month, $end_day) = explode("-", $employment_end_date);
                $age = ($end_year - $emp_year);
            } else {
                $date = date("Y/m/d");
                list($year, $month, $day) = explode("/", $date);
                $age = ($year - $emp_year);
            }
        }
    } else $age = 0;

    if (!empty($_POST['time_start'])) $time_start = $_POST['time_start'];
    else $time_start = "";
    if (!empty($_POST['time_end'])) $time_end = $_POST['time_end'];
    else $time_end = "";

    // main update sql
    $sql_update_employment = "UPDATE hr_person_employment SET 
        person_id='{$_POST["hidden_edit_id"]}',
        employment_company='{$_POST["employment_company"]}',
        employment_branch='{$_POST["employment_branch"]}',
        employment_department='{$_POST["employment_department"]}',
        employment_position='{$_POST["employment_position"]}',
        employment_money='{$_POST["employment_money"]}',
        employment_status='{$_POST["employment_status"]}',
        employment_work_status='{$_POST["working_status"]}',
        employment_break_status='{$_POST["break_status"]}',
        employment_age='$age',
        employment_time_start='$time_start',
        employment_time_end='$time_end',
        employment_ot='{$_POST["employment_ot"]}'
    
     ";


    if (!empty($_POST['employment_start_date']))
        $sql_update_employment .= ",employment_start_date='$employment_start_date'";
    else if ($_POST['employment_start_date'] == '')
        $sql_update_employment .= ",employment_start_date=NULL";

    if (!empty($_POST['start_social_insurance_date']))
        $sql_update_employment .= ",employment_start_social_insurance='{$_POST["start_social_insurance_date"]}'";
    if ($_POST['start_social_insurance_date'] == "")
        $sql_update_employment .= ",employment_start_social_insurance=NULL";

    // not null value of end working
    if (!empty($_POST['employment_end_date']) || !empty($_POST["employment_end_reason"]) || !empty($_POST["out_social_insurance_date"])) {
        $sql_update_employment .= "
            ,employment_finish_date='{$_POST["employment_end_date"]}',
            employment_reason_endwork='{$_POST["employment_end_reason"]}',
            employment_out_social_insurance='{$_POST["out_social_insurance_date"]}'
        ";
    }

    // null value of end working
    if ($_POST['employment_end_date'] == "") $sql_update_employment .= ",employment_finish_date=NULL";
    if ($_POST["employment_end_reason"] == "") $sql_update_employment .= ",employment_reason_endwork=''";
    if ($_POST["out_social_insurance_date"] == "") $sql_update_employment .= ",employment_out_social_insurance=NULL";

    // Variable of break date of employee // not null value of break
    if (!empty($_POST['employment_break_start']) || !empty($_POST["employment_break_finish"]) || !empty($_POST["employment_break_reason"])) {
        $sql_update_employment .= "
            ,employment_start_break='{$_POST["employment_break_start"]}',
            employment_finish_break='{$_POST["employment_break_finish"]}',
            employment_reason_break='{$_POST["employment_break_reason"]}'
        ";
    }

    // if check employment_status_bail
    if (!empty($_POST["status_resign_bail"])) $sql_update_employment .= ",employment_status_bail='{$_POST["status_resign_bail"]}' ";
    if (empty($_POST["status_resign_bail"])) $sql_update_employment .= ",employment_status_bail='0' ";

//    echo "status bail : ".$sql_update_employment; exit();

    // null value of break
    if (empty($_POST['employment_break_start'])) $sql_update_employment .= ",employment_start_break=NULL";
    if (empty($_POST["employment_break_finish"])) $sql_update_employment .= ",employment_finish_break=NULL";
    if (empty($_POST["employment_break_reason"])) $sql_update_employment .= ",employment_reason_break=''";
    $sql_update_employment .= " WHERE employment_id='{$_POST["hidden_employ_id"]}' ";

    // _________________________________ Process Hr_person_holiday
//    echo "holiday : ";
//    if(isset($_POST["holiday"])){
//        foreach($_POST["holiday"] as $temp){
//            echo $temp ;
//        }
//    }
//    echo "<br>";

    $str_data = "";
    if (isset($_POST["holiday"])) {
        $count_holiday = 0;
        foreach ($_POST["holiday"] as $temp) {
            if (count($_POST["holiday"]) <= 1) $str_data = $temp;
            else {
                if ($count_holiday == 0) $str_data = $temp . ",";
                else if ($count_holiday == ((count($_POST["holiday"])) - 1)) $str_data .= $temp;
                else $str_data .= $temp . ",";
            }
            $count_holiday += 1;
        }
    } else $str_data = "0";

    // ____________________________ Sql update person holiday.
    $sql_update_person_holiday = "
      UPDATE hr_person_holiday SET 
      holiday_value='$str_data',
      holiday_updateBy='$uID',
      holiday_updateDate='$updateDate'
      WHERE person_id='{$_POST["hidden_edit_id"]}'
    ";

//    echo "sql emp : " . $sql_update_employment . "<br>";
//    echo "<hr>";
//    echo "sql holiday : " . $sql_update_person_holiday;
//    echo "status : ".$_POST["status_resign_bail"];
//    if(empty($_POST["status_resign_bail"])) echo "0";
//    exit();

    $query_update_holiday = mysqli_query($conn, $sql_update_person_holiday);
    $query_update_employment = mysqli_query($conn, $sql_update_employment);

    if ($query_update_employment || $query_update_holiday) {
        mysqli_close($conn);
        ?>
        <script>
            alert("แก้ไขข้อมูลสถานะการทำงาน เรียบร้อยแล้ว!");
            window.location = "index.php?mod=hr/manage_person";
        </script>
        <?php
        exit();
    }
}
?>

