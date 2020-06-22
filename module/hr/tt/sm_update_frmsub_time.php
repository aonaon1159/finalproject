<?php
if (isset($_POST['hidden_count_id']) AND isset($_POST['hidden_file_id']) AND isset($_POST['hidden_in_id']) AND isset($_POST['hidden_out_id'])) {
    if (isset($_POST["time_datetime"]) && isset($_POST["time_in"]) && isset($_POST["time_out"])) {
            $arr_temp_in = array($_POST["time_datetime"], "00:00:00");
            $arr_temp_out = array($_POST["time_datetime"], "00:00:00");
            $imp_datetime_in = implode(" ", $arr_temp_in);
            $imp_datetime_out = implode(" ", $arr_temp_out);
        } else {
            $arr_temp_in = array($_POST["time_datetime"], $_POST["time_in"]);
            $arr_temp_out = array($_POST["time_datetime"], $_POST["time_out"]);
            $imp_datetime_in = implode(" ", $arr_temp_in);
            $imp_datetime_out = implode(" ", $arr_temp_out);
        }
    
    
//        echo "date in : ".$imp_datetime_in." in id : ".$_POST["hidden_in_id"];
//        echo "date out : ".$imp_datetime_out." out id : ".$_POST["hidden_out_id"];
//        exit();
    $sql_i_time_transaction = "
        SELECT time_transaction FROM fn_scan
        WHERE date(time_datetime) = '{$_POST["time_datetime"]}' 
        AND person_id = '{$_POST["hidden_count_id"]}' AND time_transaction = 'I'
    ";
    $sql_o_time_transaction = "
        SELECT time_transaction FROM fn_scan
        WHERE date(time_datetime) = '{$_POST["time_datetime"]}' 
        AND person_id = '{$_POST["hidden_count_id"]}' AND time_transaction = 'O'
    ";

    $new_date_i = $_POST["time_datetime"]." ".$_POST["time_in"];
    $new_date_o = $_POST["time_datetime"]." ".$_POST["time_out"];



    $query_i_time_transaction = mysqli_query($conn ,$sql_i_time_transaction);
    $query_o_time_transaction = mysqli_query($conn ,$sql_o_time_transaction);

    $assoc_i_time_transaction = mysqli_fetch_assoc($query_i_time_transaction);    
    $assoc_o_time_transaction = mysqli_fetch_assoc($query_o_time_transaction);    

    $num_rows_i = mysqli_num_rows($query_i_time_transaction);
    $num_rows_o = mysqli_num_rows($query_o_time_transaction);



    if($num_rows_i === 0){
        $sql_insert_i = "
        INSERT INTO fn_scan 
        SET scanfile_id = '{$_POST['hidden_file_id']}',
        time_machine_id = '{$_POST['time_machine']}',
        time_machine_count = '{$_POST['hidden_count_id']}',
        person_id = '{$_POST["hidden_count_id"]}',
        time_department = '{$_POST["time_department_id"]}',
        time_fullname = '{$_POST["time_fullname"]}',
        time_datetime = '$new_date_i',
        time_transaction = 'I',
        time_company = '{$_POST["time_company"]}',
        time_comment = '',
        time_status = '{$_POST['status_sick']}'

        ";
        $query_insert_i = mysqli_query($conn ,$sql_insert_i);
    }else{
        $sql_update_i = "
        UPDATE fn_scan SET time_datetime = '$new_date_i',
        time_status = '{$_POST['status_sick']}'
        WHERE person_id = $_POST[hidden_count_id] AND date(time_datetime) = '$_POST[time_datetime]' AND time_transaction = 'I'
        ";
        $query_update_i = mysqli_query($conn ,$sql_update_i);        
    }

    if($num_rows_o === 0){
        $sql_insert_o = "
        INSERT INTO fn_scan 
        SET scanfile_id = '{$_POST['hidden_file_id']}',
        time_machine_id = '{$_POST['time_machine']}',
        time_machine_count = '{$_POST['hidden_count_id']}',
        person_id = '{$_POST["hidden_count_id"]}',
        time_department = '{$_POST["time_department_id"]}',
        time_fullname = '{$_POST["time_fullname"]}',
        time_datetime = '$new_date_o',
        time_transaction = 'O',
        time_company = '{$_POST["time_company"]}',
        time_comment = '',
        time_status = '{$_POST['status_sick']}'

        ";
        $query_insert_o = mysqli_query($conn ,$sql_insert_o); 
    }else{
        $sql_update_o = "
        UPDATE fn_scan SET time_datetime = '$new_date_o',
        time_status = '{$_POST['status_sick']}'
        WHERE person_id = $_POST[hidden_count_id] AND date(time_datetime) = '$_POST[time_datetime]' AND time_transaction = 'O'
        ";
        $query_update_o = mysqli_query($conn ,$sql_update_o);  
    }












    
    //     if($num_rows_i === 0){
    //         if($assoc_i_time_transaction["time_transaction"] == "I"){
    //             $sql_insert_i = "
    //             INSERT INTO fn_scan 
    //             SET scanfile_id = '{$_POST['hidden_file_id']}',
    //             time_machine_id = '{$_POST['time_machine']}',
    //             time_machine_count = '{$_POST['hidden_count_id']}',
    //             person_id = '{$_POST["hidden_count_id"]}',
    //             time_department = '{$_POST["time_department_id"]}',
    //             time_fullname = '{$_POST["time_fullname"]}',
    //             time_datetime = '$new_date_i',
    //             time_transaction = 'I',
    //             time_company = '{$_POST["time_company"]}',
    //             time_comment = '',
    //             time_status = '{$_POST['status_sick']}'
        
    //             ";
    //             $query_insert_i = mysqli_query($conn ,$sql_insert_i);
    //         }else{
    //             $sql_update_i = "
    //             UPDATE fn_scan SET time_datetime = '$new_date_i'
    //             WHERE person_id = $_POST[hidden_count_id] AND date(time_datetime) = '$_POST[time_datetime]' AND time_transaction = 'I'
    //             ";
    //             $query_update_i = mysqli_query($conn ,$sql_update_i);
    //         }
    // }

    
    //     if($num_rows_o === 0){
    //         if($assoc_o_time_transaction["time_transaction"] == "O"){
    //             $sql_insert_o = "
    //             INSERT INTO fn_scan 
    //             SET scanfile_id = '{$_POST['hidden_file_id']}',
    //             time_machine_id = '{$_POST['time_machine']}',
    //             time_machine_count = '{$_POST['hidden_count_id']}',
    //             person_id = '{$_POST["hidden_count_id"]}',
    //             time_department = '{$_POST["time_department_id"]}',
    //             time_fullname = '{$_POST["time_fullname"]}',
    //             time_datetime = '$new_date_o',
    //             time_transaction = 'O',
    //             time_company = '{$_POST["time_company"]}',
    //             time_comment = '',
    //             time_status = '{$_POST['status_sick']}'
    //             ";
    //             $query_insert_o = mysqli_query($conn ,$sql_insert_o);

    //         }else{
    //             $sql_update_o = "
    //             UPDATE fn_scan SET time_datetime = '$new_date_o'
    //             WHERE person_id = $_POST[hidden_count_id] AND date(time_datetime) = '$_POST[time_datetime]' AND time_transaction = 'O'
    //             ";
    //             $query_update_o = mysqli_query($conn ,$sql_update_o);
    //     }
    // }


//     $sql_update_time_in = "
//         UPDATE fn_scan SET
//         time_datetime='$imp_datetime_in'
//     ";
//     $sql_update_time_out = "
//         UPDATE fn_scan SET
//         time_datetime='$imp_datetime_out'
//     ";


//     if ($_POST['status_sick'] != NULL) {
//         $sql_update_time_in .= ",time_status='{$_POST["status_sick"]}'";
//         $sql_update_time_out .= ",time_status='{$_POST["status_sick"]}'";
//     }

//     if ($_POST['status_sick'] == NULL) {
//         $tmp_null = 0;
//         $sql_update_time_in .= ",time_status='$tmp_null'";
//         $sql_update_time_out .= ",time_status='$tmp_null'";
//     }

//     if ($_POST["time_comment"] != "") {
//         $sql_update_time_in .= "
//                 ,time_comment='{$_POST["time_comment"]}'
//                 WHERE time_id='{$_POST["hidden_in_id"]}'
//             ";
//         $sql_update_time_out .= "
//                 ,time_comment='{$_POST["time_comment"]}'
//                 WHERE time_id='{$_POST["hidden_out_id"]}'
//             ";
//     } else {
//         $temp_null = "";
//         $sql_update_time_in .= "
//                 ,time_comment='$temp_null'
//                 WHERE time_id='{$_POST["hidden_in_id"]}'
//             ";
//         $sql_update_time_out .= "
//                 ,time_comment='$temp_null'
//                 WHERE time_id='{$_POST["hidden_out_id"]}'
//             ";
//     }


// //        echo "sql in ".$sql_update_time_in; echo "<br>";
// //        echo "sql out ".$sql_update_time_out; echo "<br>";

//     $query_update_in = mysqli_query($conn, $sql_update_time_in);
//     $query_update_out = mysqli_query($conn, $sql_update_time_out);


//     if ($query_update_in && $query_update_out) {
        ?>
        <script>
            alert("แก้ไขข้อมูลเวลาทำงาน เรียบร้อยแล้ว!");
            window.location.href = 'index.php?mod=fn/form_view_timedetail&count_id=<?=$_POST["hidden_count_id"]?>&file_id=<?=$_POST["hidden_file_id"]?>';
        </script>
        <?php
    }
// }
?>