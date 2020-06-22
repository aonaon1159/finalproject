<?php

if (isset($_POST["hidden_date"]) && isset($_POST["time_in"]) && isset($_POST["time_out"])) { 

    $sql_select_thistime = "
            SELECT * FROM fn_scan
            WHERE time_machine_count='{$_POST["hidden_count_id"]}' AND  scanfile_id='{$_POST["hidden_file_id"]}'
            LIMIT 1
        ";

    $query_thistime = mysqli_query($conn, $sql_select_thistime);
    if (mysqli_num_rows($query_thistime)) $assoc_thistime = mysqli_fetch_assoc($query_thistime);

    // ______________ Set variable datetime for insert
    $tmp_datetime_in = $_POST["hidden_date"] . " " . $_POST["time_in"];
    $tmp_datetime_out = $_POST["hidden_date"] . " " . $_POST["time_out"];

    $transaction_in = "I";
    $transaction_out = "O";
    $time_default = $_POST["hidden_date"] . " " . "00:00:00";
//    echo "check_status : ".$_POST["status_sick"];



    if (isset($_POST["hidden_in_id"]) || isset($_POST["hidden_out_id"])) { // Have get in_id,out_id

        if (!isset($_GET["in_id"]) AND isset($_GET["out_id"])) { //insert in_id , update out_id

            $sql_insert_in_id = "
              INSERT INTO fn_scan SET
                scanfile_id='{$_POST["hidden_file_id"]}',
                time_machine_id='{$assoc_thistime["time_machine_id"]}',
                time_machine_count='{$_POST["hidden_count_id"]}',
                person_id='{$assoc_thistime["person_id"]}',
                time_department='{$assoc_thistime["time_department"]}',
                time_fullname='{$assoc_thistime["time_fullname"]}',
                time_transaction='$transaction_in',
                time_company='{$assoc_thistime["time_company"]}' 
            ";

            if ($_POST["status_sick"] != NULL) {
                if ($_POST["status_sick"] === 1) {
                    $sql_insert_in_id .= ",time_datetime='$time_default',";
                }else{
                    $sql_insert_in_id .= ",time_datetime='$tmp_datetime_in',";
                }

            }else{ 
                $sql_insert_in_id .= ",time_datetime='$tmp_datetime_in',";

            }

            if ($_POST["status_sick"] != NULL) {
                if ($_POST["status_sick"] === 1) {
                    $sql_update_out_id = "
                    UPDATE fn_scan SET
                    time_datetime='$time_default'
                  ";
                }else{
                    $sql_update_out_id = "
                    UPDATE fn_scan SET
                    time_datetime='$tmp_datetime_in'
                  ";
                }
            } else {
                    $sql_update_out_id = "
                    UPDATE fn_scan SET
                    time_datetime='$tmp_datetime_out'
                  ";
            }


        } else if (!isset($_GET["out_id"]) AND isset($_GET["in_id"])) { //update in_id , insert out_id
            $sql_insert_out_id = "
                INSERT INTO fn_scan SET
                scanfile_id='{$_POST["hidden_file_id"]}',
                time_machine_id='{$assoc_thistime["time_machine_id"]}',
                time_machine_count='{$_POST["hidden_count_id"]}',
                person_id='{$assoc_thistime["person_id"]}',
                time_department='{$assoc_thistime["time_department"]}',
                time_fullname='{$assoc_thistime["time_fullname"]}',
                time_transaction='$transaction_out',
                time_company='{$assoc_thistime["time_company"]}' 
            ";

            if ($_POST["status_sick"] != NULL) {
                if($_POST["status_sick"] === 1) {
                    $sql_insert_out_id .= ",time_datetime='$time_default',";
                }else{
                   $sql_insert_out_id .= ",time_datetime='$tmp_datetime_out',"; 
                }
            }else{
            $sql_insert_out_id .= ",time_datetime='$tmp_datetime_out',";
            }

            if ($_POST["status_sick"] != NULL) {
                if($_POST["status_sick"] === 1) {
                    $sql_update_in_id = "
                    UPDATE fn_scan SET
                    time_datetime='$time_default'
                ";
                }else{
                   $sql_update_in_id = "
                    UPDATE fn_scan SET
                    time_datetime='$tmp_datetime_in'
                "; 
                }
            } else {
                $sql_update_in_id = "
                    UPDATE fn_scan SET
                    time_datetime='$tmp_datetime_in'
                ";
            }


        } else { 

            if ($_POST["status_sick"] != NULL) {
                if($_POST["status_sick"] === 1) {
                    $sql_update_in_id = "
                    UPDATE fn_scan SET
                    time_datetime='$time_default'
                    ";
                    $sql_update_out_id = "
                    UPDATE fn_scan SET
                    time_datetime='$time_default'
                    ";
                }else{
                    $sql_update_in_id = "
                    UPDATE fn_scan SET
                    time_datetime='$tmp_datetime_in'
                    ";
                    $sql_update_out_id = "
                    UPDATE fn_scan SET
                    time_datetime='$tmp_datetime_out'
                    ";
                }
            } else {
                    $sql_update_in_id = "
                    UPDATE fn_scan SET
                    time_datetime='$tmp_datetime_in'
                    ";

                    $sql_update_out_id = "
                    UPDATE fn_scan SET
                    time_datetime='$tmp_datetime_out'
                    ";
            }

        }

        if ($_POST["time_comment"] != "") {
            if (isset($sql_insert_in_id)) $sql_insert_in_id .= ",time_comment='{$_POST["time_comment"]}'";
            if (isset($sql_insert_out_id)) $sql_insert_out_id .= ",time_comment='{$_POST["time_comment"]}'";
            if (isset($sql_update_in_id)) $sql_update_in_id .= ",time_comment='{$_POST["time_comment"]}'";
            if (isset($sql_update_out_id)) $sql_update_out_id .= ",time_comment='{$_POST["time_comment"]}'";
        } else {
            $tmp_null = "";
            if (isset($sql_insert_in_id)) $sql_insert_in_id .= ",time_comment='$tmp_null' ";
            if (isset($sql_insert_out_id)) $sql_insert_out_id .= ",time_comment='$tmp_null' ";
            if (isset($sql_update_in_id)) $sql_update_in_id .= ",time_comment='$tmp_null' ";
            if (isset($sql_update_out_id)) $sql_update_out_id .= ",time_comment='$tmp_null' ";
        }

        if ($_POST["status_sick"] != NULL) {
            if (isset($sql_insert_in_id)) $sql_insert_in_id .= ",time_status='{$_POST["status_sick"]}'";
            if (isset($sql_insert_out_id)) $sql_insert_out_id .= ",time_status='{$_POST["status_sick"]}'";
            if (isset($sql_update_in_id)) $sql_update_in_id .= ",time_status='{$_POST["status_sick"]}'";
            if (isset($sql_update_out_id)) $sql_update_out_id .= ",time_status='{$_POST["status_sick"]}'";
        }

        if (isset($sql_update_in_id)) $sql_update_in_id .= "WHERE time_id='{$_POST["hidden_in_id"]}'";
        if (isset($sql_update_out_id)) $sql_update_out_id .= "WHERE time_id='{$_POST["hidden_out_id"]}'";

//        if(isset($sql_insert_in_id)) echo "insert in : ".$sql_insert_in_id."<br>";
//        if(isset($sql_insert_out_id)) echo "insert out : ".$sql_insert_out_id."<br>";
//        if(isset($sql_update_in_id)) echo "update in : ".$sql_update_in_id."<br>";
//        if(isset($sql_update_out_id)) echo "update out : ".$sql_update_out_id."<br>";

        if (isset($sql_insert_in_id)) $query_insert_in_id = mysqli_query($conn, $sql_insert_in_id);
        if (isset($sql_insert_out_id)) $query_insert_out_id = mysqli_query($conn, $sql_insert_out_id);
        if (isset($sql_update_in_id)) $query_update_in_id = mysqli_query($conn, $sql_update_in_id);
        if (isset($sql_update_out_id)) $query_update_out_id = mysqli_query($conn, $sql_update_out_id);

//        if($query_insert_in_id) echo "insert in";
//        if($query_insert_out_id) echo "insert out";
//        if($query_update_in_id) echo "update in";
//        if($query_update_out_id) echo "update out";
//        exit();

        if ($query_insert_in_id OR $query_insert_out_id OR $query_update_in_id OR $query_update_out_id) {
            ?>
            <script>
                alert("แก้ไขข้อมูลเวลาทำงาน เรียบร้อยแล้ว!");
                window.location.href = 'index.php?mod=fn/form_view_timedetail&count_id=<?=$_POST["hidden_count_id"]?>&file_id=<?=$_POST["hidden_file_id"]?>'
            </script>
            <?php
        }

    } else { // Have get in_id,out_id
 
//        echo "coming !";
        $sql_insert_in = "
        INSERT INTO fn_scan SET 
            scanfile_id='{$_POST["hidden_file_id"]}',
            time_machine_id='{$assoc_thistime["time_machine_id"]}',
            time_machine_count='{$_POST["hidden_count_id"]}',
            person_id='{$assoc_thistime["person_id"]}',
            time_department='{$assoc_thistime["time_department"]}',
            time_fullname='{$assoc_thistime["time_fullname"]}',
            time_transaction='$transaction_in',
            time_company='{$assoc_thistime["time_company"]}'
        ";

        $sql_insert_out = "
            INSERT INTO fn_scan SET 
            scanfile_id='{$_POST["hidden_file_id"]}',
            time_machine_id='{$assoc_thistime["time_machine_id"]}',
            time_machine_count='{$_POST["hidden_count_id"]}',
            person_id='{$assoc_thistime["person_id"]}',
            time_department='{$assoc_thistime["time_department"]}',
            time_fullname='{$assoc_thistime["time_fullname"]}',
            time_transaction='$transaction_out',
            time_company='{$assoc_thistime["time_company"]}'
        ";

        if ($_POST["time_comment"] != "") {
            $sql_insert_in .= "
                ,time_comment='{$_POST["time_comment"]}'
            ";
            $sql_insert_out .= "
                ,time_comment='{$_POST["time_comment"]}'
            ";
        }

        if (isset($_POST["status_sick"]) != NULL) { 
            // echo "sick != null";
            if ($_POST["status_sick"] === 1) { 
                // echo " sick === 1";
                if (isset($sql_insert_in)) $sql_insert_in .= ",time_status='{$_POST["status_sick"]}',time_datetime='$time_default' ";
                if (isset($sql_insert_out)) $sql_insert_out .= ",time_status='{$_POST["status_sick"]}',time_datetime='$time_default' ";
            }else{ 
                // echo "sick !== 1 ";
                $sql_insert_in .= ",time_status='{$_POST["status_sick"]}',time_datetime='$tmp_datetime_in' ";
                $sql_insert_out .= ",time_status='{$_POST["status_sick"]}',time_datetime='$tmp_datetime_out' ";
            }
        } else { 
            // echo "sick == null";
            $sql_insert_in .= ",time_datetime='$tmp_datetime_in' ";
            $sql_insert_out .= ",time_datetime='$tmp_datetime_out' ";
        }

//        echo "sql in ".$sql_insert_in; echo "<br>";
//        echo "sql out ".$sql_insert_out; echo "<br>";
//        exit();
        $query_in = mysqli_query($conn, $sql_insert_in) or die("Error is : " . mysqli_error($conn));
        $query_out = mysqli_query($conn, $sql_insert_out) or die("Error is : " . mysqli_error($conn));

        if ($query_in && $query_out) {
            ?>
            <script>
                alert("แก้ไขข้อมูลเวลาทำงาน เรียบร้อยแล้ว!");
                window.location.href = 'index.php?mod=fn/form_view_timedetail&count_id=<?=$_POST["hidden_count_id"]?>&file_id=<?=$_POST["hidden_file_id"]?>';
            </script>
            <?php
        }
    }


}
?>