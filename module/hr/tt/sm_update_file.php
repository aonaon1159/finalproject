<?php
/**
 * Created by PhpStorm.
 * User: Avaibooking
 * Date: 2/15/2018
 * Time: 2:45 PM
 */
if (isset($_POST["hidden_file_id"])) {
    $dateUpdate = date("Y-m-d H:i:s");
    $sql_update_file = "
            UPDATE fn_salary_file SET 
            file_company='{$_POST["company"]}',
            file_title='{$_POST["salary_title"]}',
            file_startdate='{$_POST["file_start_date"]}',
            file_enddate='{$_POST["file_end_date"]}',
            file_updatedDate='$dateUpdate',
            file_updatedBy='{$_SESSION["uID"]}'
        ";

    if ($_FILES["salary_file"]["name"] != "") {
        $phpFileUploadErrors = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';


        if ($_FILES["salary_file"]["type"] != "application/vnd.ms-excel") {
            ?>
            <script>
                alert("* กรุณาใส่ข้อมูล FILE เป็นไฟล์ .CSV (UFT8) เท่านั้น");
                window.history.back();
            </script>
            <?php
            exit();
        }

        $check = $_FILES["salary_file"]["tmp_name"];
        if ($check !== false) {
            $rds = '';
            for ($i = 0; $i < 5; $i++) {
                $rds .= $characters[rand(0, strlen($characters) - 1)];
            }

            $target_dir_resume = "storages/csv/" . date("Ymd");
            if (!file_exists($target_dir_resume)) {
                mkdir($target_dir_resume, 0777, true);
            }
            $upload_file = $target_dir_resume . "/" . basename($_FILES["salary_file"]["name"]);
            $ext = pathinfo($upload_file, PATHINFO_EXTENSION);

            $new_name = "CSV_" . date("His") . "_{$rds}_{$_SESSION["uID"]}." . $ext;
            $target_file = $target_dir_resume . "/" . basename($new_name);

            if (move_uploaded_file($_FILES["salary_file"]["tmp_name"], $target_file)) {
                $local_file = $target_file;
            } else {
                die("
					Sorry, there was an error uploading your file. Please contact system administrator.<br>
					File Upload Name: {$_FILES["salary_file"]["name"]}<br>
					New Upload Name: $newName<br>
					Target File Name: $target_file<br>
					Error #: {$_FILES["salary_file"]["error"]} : " . $phpFileUploadErrors[$_FILES["salary_file"]["error"]]
                );
            }
            $uploadOk = 1;
            $sql_update_file .= ",file_name='$local_file'";
        } else $uploadOk = 0;

    }

    //____________________________________________________________ Update fn_salary_file
    $sql_update_file .= "WHERE file_id='{$_POST["hidden_file_id"]}'";
    $query_update_file = mysqli_query($conn, $sql_update_file) or die("Error : " . mysqli_error($conn));
    if ($query_update_file) {
        //____________________________________________________________ Delete fn_salary.

        if (isset($local_file)) {
            $sql_delete_salary = "
                DELETE FROM fn_salary 
                WHERE file_id='{$_POST["hidden_file_id"]}'
            ";
            $query_del_salary = mysqli_query($conn, $sql_delete_salary);
            if ($query_del_salary) {
                //____________________________________________________________ Insert fn_salary.
                $sql_update_insert = "
                   LOAD DATA LOCAL INFILE '$local_file'
                    INTO TABLE fn_salary
                    CHARACTER SET TIS620
                    FIELDS TERMINATED BY ','
                    LINES TERMINATED BY '\\r\\n' 
                    IGNORE 4 LINES
                    (salary_count,person_id,salary_prefix_eng,salary_name_eng,salary_surname_eng,salary_fullname_thai,salary_payment,salary_position,salary_department,salary_section,salary_status,salary_income_rate,salary_work_day,salary_income,salary_income_position,salary_income_commission,salary_commission_stock,salary_holiday,salary_income_holiday,salary_income_overtime_hours,salary_income_overtime,salary_income_journey,salary_income_other,salary_income_othersum,salary_income_bonus,salary_income_bonusyear,salary_income_total,salary_expense_late,salary_expense_before,salary_expense_accident,salary_expense_leave,salary_expense_subtract,salary_expense_bail,salary_expense_other,salary_expense_total,salary_income_sum,salary_expense_insurance,salary_expense_tax,salary_income_net,salary_account_id)
                    SET file_id='{$_POST["hidden_file_id"]}'
               ";
                $query_update_insert = mysqli_query($conn, $sql_update_insert);

                if ($query_update_insert) {
                    //____________________________________________________________ Process calculate salary detail.
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

                    $sql_select_salary = "SELECT * FROM fn_salary WHERE file_id='{$_POST["hidden_file_id"]}'";
                    $query_salary = mysqli_query($conn, $sql_select_salary);
                    $num_salary = mysqli_num_rows($query_salary);
                    $limit_row_salary = $num_salary - 1;
                    $count = 1;
                    while ($assoc_salary = mysqli_fetch_assoc($query_salary)) {
                        if ($count < $limit_row_salary) {

                            // ______________ Start calculating income && expense ___________________//
                            $salary_income_rate += str_replace('|', '', $assoc_salary["salary_income_rate"]);
                            $salary_work_day += str_replace('|', '', $assoc_salary["salary_work_day"]);
                            $salary_income += str_replace('|', '', $assoc_salary["salary_income"]);

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

                        }
                        $count++;
                    }

                    $sql_update_detail = "UPDATE fn_salary_detail SET 
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
                            sum_income_journey='$tmp_salary_income_journey',
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
                            WHERE file_id='{$_POST["hidden_file_id"]}'
                    ";

                    $query_update_salary_detail = mysqli_query($conn, $sql_update_detail);
                    if ($query_update_salary_detail) {
                        unlink("././$local_file");
                        ?>
                        <script>
                            alert("แก้ไขไฟล์ข้อมูลเงินเดือน เรียบร้อยแล้ว!");
                            window.location = 'index.php?mod=fn/manage_salary';
                        </script>
                        <?php
                    }
                }
            }
        } else {
            ?>
            <script>
                alert("แก้ไขไฟล์ข้อมูลเงินเดือน เรียบร้อยแล้ว!");
                window.location = 'index.php?mod=fn/manage_salary';
            </script>
            <?php
        }

    }

}
?>