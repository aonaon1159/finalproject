<?php
/**
 * Created by PhpStorm.
 * User: Avaibooking
 * Date: 2/12/2018
 * Time: 3:56 PM
 */


if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
} else $session = ($_SESSION["uID"]);

if (isset($_POST["company"])) {
//    exit("value of company : ".$_POST["company"]);
    $datetime = date("Y-m-d H:i:s");
    // prepare sql statement
    $sql_insert_file = "
            INSERT INTO fn_salary_file SET 
            file_company='{$_POST["company"]}',
            file_title='{$_POST["salary_title"]}',
            file_startdate='{$_POST["salary_start_date"]}',
            file_enddate='{$_POST["salary_end_date"]}',
            file_createDate='$datetime',
            file_createBy='$session',
            deleted='0'
        ";

//    exit("check = ".$sql_insert_file);

    // input file manipulation
    if ($_FILES["salary_file"]["name"] != "") { 
        // if ($_FILES["salary_file"]["type"] != "application/vnd.ms-excel") {
        ?>
        <!-- <script>
                 alert("* กรุณาใส่ข้อมูล FILE เป็นไฟล์ .CSV (TIS620) เท่านั้น");
                 // window.history.back();
        </script> -->
        <?php
        //     exit();
        // }
        $tmp_file = $_FILES["salary_file"]["tmp_name"];

        // random temporary filename
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rds = '';
        for ($i = 0; $i < 5; $i++) {
            $rds .= $characters[rand(0, strlen($characters) - 1)];
        }

        // saving the temporary file to the directory
        $target_dir = "storages/csv/" . date("Ymd");
        // if the directory doesn't exist, then create it and set a permission to everyone can read
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        // naming the file
        $upload_file = $target_dir . "/" . basename($_FILES["salary_file"]["name"]);
        $ext = pathinfo($upload_file, PATHINFO_EXTENSION);

        $new_name = "CSV_" . date("His") . "_{$rds}_{$session}." . $ext;
        $target_file = $target_dir . "/" . basename($new_name);

        $uploadOk = move_uploaded_file($_FILES["salary_file"]["tmp_name"], $target_file);
        // move the file from php temporary dir to the desired dir
        if ($uploadOk) {
            $local_file = $target_file;
            // read file
            $text = file_get_contents($target_file);
            // convert file 
            // this is utf-8
            $probe = iconv('TIS620', 'UTF-8', $text);
            if (strlen($probe)> 0) {
                // this is not utf-8
                $text = iconv('TIS620','UTF-8',$text);
            }
            // replace , with empty character before put file
            $text = str_replace(',','', $text);
            // replace 'tab' with , for terminated field 
            $text = preg_replace('/\t/',',',$text);
            // explode 3 row at the end of line
            $tsvRows = explode(PHP_EOL, $text);
            // reverse array data
            $reverseTsv = array_reverse($tsvRows);
            // splice out array [0] then reverse it back 
            $tsvRows = array_reverse(array_splice($reverseTsv, 1));
            // merge data 
            $text = implode(PHP_EOL, $tsvRows);

                        // // replace | with empty character
                        // $text = str_replace('|', '', $text);
                        // // explode 3 row at the end of line
                        // $csvRows = explode(PHP_EOL, $text);            
                        // // reverse array data 
                        // $reverseCsv = array_reverse($csvRows);
                        // // splice out array[0] - [4] then reverse it back
                        // $csvRows = array_reverse(array_splice($reverseCsv, 4));
                        // // merge data 
                        // $text = implode(PHP_EOL, $csvRows);

            // put file back to target
            file_put_contents($target_file, $text);
            // unset all of variant
            unset($text);
            unset($csvRows);
            unset($reverseCsv);

        } else {
//            exit("error : ".$_FILES["salary_file"]["error"]."| tmp_name : ".$_FILES["salary_file"]["tmp_name"]."| name : ".$_FILES["salary_file"]["name"]."| size : ".$_FILES["salary_file"]["size"]."| type : ".$_FILES["salary_file"]["type"]);

            die("
            Sorry, there was an error uploading your file. Please contact system administrator.<br>
            File Upload Name: {$_FILES["salary_file"]["name"]}<br>
            New Upload Name: $newName<br>
            Target File Name: $target_file<br>
            Error #: {$_FILES["salary_file"]["error"]} : " . $phpFileUploadErrors[$_FILES["salary_file"]["error"]]
            );

        }
        
    }

    // if the file moving is done
    if (isset($local_file)) {
        $sql_insert_file .= ",file_name='$local_file' ";
        $query_insert_file = mysqli_query($conn, $sql_insert_file);

        if ($query_insert_file) {
            $sql_select_file = "SELECT MAX(file_id) FROM fn_salary_file ";

            $query_file = mysqli_query($conn, $sql_select_file);
            list($max_id) = mysqli_fetch_row($query_file);

            $sql_insert_salary = "
                    LOAD DATA LOCAL INFILE '$local_file'
                    INTO TABLE fn_salary
                    CHARACTER SET UTF8
                    FIELDS TERMINATED BY ','
                    LINES TERMINATED BY '\\r\\n' 
                    IGNORE 4 LINES
                    (salary_count,person_id,salary_prefix_eng,salary_name_eng,salary_surname_eng,salary_fullname_thai,salary_payment,salary_position,salary_department,salary_section,salary_status,salary_income_rate,salary_work_day,salary_income,salary_income_position,salary_income_commission,salary_commission_stock,salary_holiday,salary_income_holiday,salary_income_overtime_hours,salary_income_overtime,salary_income_journey,salary_income_other,salary_income_othersum,salary_income_bonus,salary_income_bonusyear,salary_income_total,salary_expense_late,salary_expense_before,salary_expense_accident,salary_expense_leave,salary_expense_subtract,salary_expense_bail,salary_expense_other,salary_expense_total,salary_income_sum,salary_expense_insurance,salary_expense_tax,salary_income_net,salary_account_id)
                    SET file_id='$max_id'
                ";

            $query_insert_salary = mysqli_query($conn, $sql_insert_salary);

            if ($query_insert_salary) {

                $salary_income_rate = 0;
                $salary_work_day = 0;
                $salary_income = 0;
                $salary_income_position = 0;
                $salary_income_commission = 0;
                $salary_commission_stock = 0;
                $salary_holiday = 0;
                $salary_income_holiday = 0;
                $salary_income_overtime_hours = 0;
                $salary_income_overtime = 0;
                $salary_income_journey = 0;
                $salary_income_other = 0;
                $salary_income_othersum = 0;
                $salary_income_bonus = 0;
                $salary_income_bonusyear = 0;
                $salary_income_total = 0;
                $salary_expense_late = 0;
                $salary_expense_before = 0;
                $salary_expense_accident = 0;
                $salary_expense_leave = 0;
                $salary_expense_subtract = 0;
                $salary_expense_bail = 0;
                $salary_expense_other = 0;
                $salary_expense_total = 0;
                $salary_income_sum = 0;
                $salary_expense_insurance = 0;
                $salary_expense_tax = 0;
                $salary_income_net = 0;

                $sql_select_salary = "SELECT * FROM fn_salary WHERE file_id='$max_id'";
                $query_salary = mysqli_query($conn, $sql_select_salary);
                $num_salary = mysqli_num_rows($query_salary);
                $count = 1;
                while ($assoc_salary = mysqli_fetch_assoc($query_salary)) {

                    // ______________ Start calculating income && expense ___________________//
                    $salary_income_rate += floatval(str_replace('|', '', $assoc_salary["salary_income_rate"]));
                    $salary_work_day += str_replace('|', '', $assoc_salary["salary_work_day"]);
                    $salary_income += floatval(str_replace('|', '', $assoc_salary["salary_income"]));

                    if ($assoc_salary["salary_income_position"] == "") {
                        $tmp_salary_income_position = 0;
                        $salary_income_position += $tmp_salary_income_position;
                    } else {
                        $salary_income_position += str_replace('|', '', $assoc_salary["salary_income_position"]);
                    }

                    if ($assoc_salary["salary_income_commission"] == "") {
                        $tmp_salary_income_commission = 0;
                        $salary_income_commission += $tmp_salary_income_commission;
                    } else {
                        $salary_income_commission += str_replace('|', '', $assoc_salary["salary_income_commission"]);
                    }

                    if ($assoc_salary["salary_commission_stock"] == "") {
                        $tmp_salary_commission_stock = 0;
                        $salary_commission_stock += $tmp_salary_commission_stock;
                    } else {
                        $salary_commission_stock += str_replace('|', '', $assoc_salary["salary_commission_stock"]);
                    }

                    if ($assoc_salary["salary_holiday"] == "") {
                        $tmp_salary_holiday = 0;
                        $salary_holiday += $tmp_salary_holiday;
                    } else {
                        $salary_holiday += str_replace('|', '', $assoc_salary["salary_holiday"]);
                    }

                    if ($assoc_salary["salary_income_holiday"] == "") {
                        $tmp_salary_income_holiday = 0;
                        $salary_income_holiday += $tmp_salary_income_holiday;
                    } else {
                        $salary_income_holiday += str_replace('|', '', $assoc_salary["salary_income_holiday"]);
                    }

                    if (!is_numeric($assoc_salary["salary_income_overtime_hours"])) {
                        $tmp_income_overtime_hours = 0;
                        $salary_income_overtime_hours += $tmp_income_overtime_hours;
                    } else {
                        $salary_income_overtime_hours += str_replace('|', '', $assoc_salary["salary_income_overtime_hours"]);
                    }

                    if ($assoc_salary["salary_income_overtime"] == "") {
                        $tmp_salary_income_overtime = 0;
                        $salary_income_overtime += $tmp_salary_income_overtime;
                    } else {
                        $salary_income_overtime += str_replace('|', '', $assoc_salary["salary_income_overtime"]);
                    }

                    if ($assoc_salary["salary_income_journey"] == "") {
                        $tmp_salary_income_journey = 0;
                        $salary_income_journey += $tmp_salary_income_journey;
                    } else {
                        $salary_income_journey += str_replace('|', '', $assoc_salary["salary_income_journey"]);
                    }

                    if ($assoc_salary["salary_income_other"] == "") {
                        $tmp_salary_income_journey = 0;
                        $salary_income_other += $tmp_salary_income_journey;
                    } else {
                        $salary_income_other += str_replace('|', '', $assoc_salary["salary_income_other"]);
                    }

                    if ($assoc_salary["salary_income_othersum"] == "") {
                        $tmp_salary_income_othersum = 0;
                        $salary_income_othersum += $tmp_salary_income_othersum;
                    } else {
                        $salary_income_othersum += str_replace('|', '', $assoc_salary["salary_income_othersum"]);
                    }

                    if ($assoc_salary["salary_income_bonus"] == "") {
                        $tmp_salary_income_bonus = 0;
                        $salary_income_bonus += $tmp_salary_income_bonus;
                    } else {
                        $salary_income_bonus += str_replace('|', '', $assoc_salary["salary_income_bonus"]);
                    }

                    if ($assoc_salary["salary_income_bonusyear"] == "") {
                        $tmp_salary_income_bonusyear = 0;
                        $salary_income_bonusyear += $tmp_salary_income_bonusyear;
                    } else {
                        $salary_income_bonusyear += str_replace('|', '', $assoc_salary["salary_income_bonusyear"]);
                    }

                    if ($assoc_salary["salary_income_total"] == "") {
                        $tmp_salary_income_total = 0;
                        $salary_income_total += $tmp_salary_income_total;
                    } else {
                        $salary_income_total += str_replace('|', '', $assoc_salary["salary_income_total"]);
                    }

                    if ($assoc_salary["salary_expense_late"] == "") {
                        $tmp_salary_expense_late = 0;
                        $salary_expense_late += $tmp_salary_expense_late;
                    } else {
                        $salary_expense_late += str_replace('|', '', $assoc_salary["salary_expense_late"]);
                    }

                    if ($assoc_salary["salary_expense_before"] == "") {
                        $tmp_salary_expense_before = 0;
                        $salary_expense_before += $tmp_salary_expense_before;
                    } else {
                        $salary_expense_before += str_replace('|', '', $assoc_salary["salary_expense_before"]);
                    }

                    if ($assoc_salary["salary_expense_accident"] == "") {
                        $tmp_salary_expense_accident = 0;
                        $salary_expense_accident += $tmp_salary_expense_accident;
                    } else {
                        $salary_expense_accident += str_replace('|', '', $assoc_salary["salary_expense_accident"]);
                    }

                    if ($assoc_salary["salary_expense_leave"] == "") {
                        $tmp_salary_expense_leave = 0;
                        $salary_expense_leave += $tmp_salary_expense_leave;
                    } else {
                        $salary_expense_leave += $assoc_salary["salary_expense_leave"];
                    }

                    if ($assoc_salary["salary_expense_subtract"] == "") {
                        $tmp_salary_expense_subtract = 0;
                        $salary_expense_subtract += $tmp_salary_expense_subtract;
                    } else {
                        $salary_expense_subtract += str_replace('|', '', $assoc_salary["salary_expense_subtract"]);
                    }

                    if ($assoc_salary["salary_expense_bail"] == "") {
                        $tmp_salary_expense_bail = 0;
                        $salary_expense_bail += $tmp_salary_expense_bail;
                    } else {
                        $salary_expense_bail += str_replace('|', '', $assoc_salary["salary_expense_bail"]);
                    }

                    if ($assoc_salary["salary_expense_other"] == "") {
                        $tmp_salary_expense_other = 0;
                        $salary_expense_other += $tmp_salary_expense_other;
                    } else {
                        $salary_expense_other += str_replace('|', '', $assoc_salary["salary_expense_other"]);
                    }

                    if ($assoc_salary["salary_expense_total"] == "") {
                        $tmp_salary_expense_total = 0;
                        $salary_expense_total += $tmp_salary_expense_total;
                    } else {
                        $salary_expense_total += str_replace('|', '', $assoc_salary["salary_expense_total"]);
                    }

                    if ($assoc_salary["salary_income_sum"] == "") {
                        $tmp_salary_income_sum = 0;
                        $salary_income_sum += $tmp_salary_income_sum;
                    } else {
                        $salary_income_sum += str_replace('|', '', $assoc_salary["salary_income_sum"]);
                    }

                    if ($assoc_salary["salary_expense_insurance"] == "") {
                        $tmp_salary_expense_insurance = 0;
                        $salary_expense_insurance += $tmp_salary_expense_insurance;
                    } else {
                        $salary_expense_insurance += str_replace('|', '', $assoc_salary["salary_expense_insurance"]);
                    }

                    if ($assoc_salary["salary_expense_tax"] == "") {
                        $tmp_salary_expense_tax = 0;
                        $salary_expense_tax += $tmp_salary_expense_tax;
                    } else {
                        $salary_expense_tax += str_replace('|', '', $assoc_salary["salary_expense_tax"]);
                    }

                    if ($assoc_salary["salary_income_net"] == "") {
                        $tmp_salary_income_net = 0;
                        $salary_income_net += $tmp_salary_income_net;
                    } else {
                        $salary_income_net += str_replace('|', '', $assoc_salary["salary_income_net"]);
                    }

                
                    $count++;
                }

                $sql_insert_salary_detail = "
                    INSERT INTO fn_salary_detail SET 
                    file_id='$max_id',
                    sum_income_rate='$salary_income_rate',
                    sum_work_day='$salary_work_day',
                    sum_income='$salary_income',
                    sum_income_position='$salary_income_position',
                    sum_income_commission='$salary_income_commission',
                    sum_commission_stock='$salary_commission_stock',
                    sum_holiday='$salary_holiday',
                    sum_income_holiday='$salary_income_holiday',
                    sum_income_overtime_hours='$salary_income_overtime_hours',
                    sum_income_overtime='$salary_income_overtime',
                    sum_income_journey='$salary_income_journey',
                    sum_income_other='$salary_income_other',
                    sum_income_othersum='$salary_income_othersum',
                    sum_income_bonus='$salary_income_bonus',
                    sum_income_bonusyear='$salary_income_bonusyear',
                    sum_income_total='$salary_income_total',
                    sum_expense_late='$salary_expense_late',
                    sum_expense_before='$salary_expense_before',
                    sum_expense_accident='$salary_expense_accident',
                    sum_expense_leave='$salary_expense_leave',
                    sum_expense_subtract='$salary_expense_subtract',
                    sum_expense_bail='$salary_expense_bail',
                    sum_expense_other='$salary_expense_other',
                    sum_expense_total='$salary_expense_total',
                    sum_income_sum='$salary_income_sum',
                    sum_expense_insurance='$salary_expense_insurance',
                    sum_expense_tax='$salary_expense_tax',
                    sum_income_net='$salary_income_net'
                ";

                $query_insert_salary_detail = mysqli_query($conn, $sql_insert_salary_detail);
                if ($query_insert_salary_detail) {
                    ?>
                    <script>
                        alert("เพิ่มไฟล์ข้อมูลเงินเดือน เรียบร้อยแล้ว!");
                        window.location = "index.php?mod=fn/manage_salary";
                    </script>
                    <?php
                }
            }

        }
    }


}

?>