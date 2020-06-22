<?php
/**
 * Created by PhpStorm.
 * User: Avaibooking
 * Date: 2/12/2018
 * Time: 3:56 PM
 */
if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");
else $session = ($_SESSION["uID"]);

if (isset($_POST["company"])) {
    $dateUpdate = date("Y-m-d H:i:s");
    $sql_update_file = "
        UPDATE fn_scan_file SET 
        scanfile_company='{$_POST["company"]}',
        scanfile_title='{$_POST["scan_title"]}',
        scanfile_startdate='{$_POST["time_start_date"]}',
        scanfile_enddate='{$_POST["time_end_date"]}',
        scanfile_updateDate='$dateUpdate',
        scanfile_updateBy='$session'
    ";

    if ($_FILES["scan_file"]["name"] != "") {
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
        if ($_FILES["scan_file"]["type"] != "application/vnd.ms-excel") {
            ?>
            <script>
                alert("* กรุณาใส่ข้อมูล FILE เป็นไฟล์ .CSV (TIS620) เท่านั้น");
                window.history.back();
            </script>
            <?php
            exit();
        }
        $tmp_file = $_FILES["scan_file"]["tmp_name"];

        $rds = '';
        for ($i = 0; $i < 5; $i++) {
            $rds .= $characters[rand(0, strlen($characters) - 1)];
        }

        $target_dir = "storages/time_csv/" . date("Ymd");
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $upload_file = $target_dir . "/" . basename($_FILES["scan_file"]["name"]);
        $ext = pathinfo($upload_file, PATHINFO_EXTENSION);

        $new_name = "CSV_" . date("His") . "_{$rds}_{$session}." . $ext;
        $target_file = $target_dir . "/" . basename($new_name);
        if (move_uploaded_file($_FILES["scan_file"]["tmp_name"], $target_file)) {
            $local_file = $target_file;
        } else {
//            exit("error : ".$_FILES["scan_file"]["error"]."| tmp_name : ".$_FILES["scan_file"]["tmp_name"]."| name : ".$_FILES["scan_file"]["name"]."| size : ".$_FILES["scan_file"]["size"]."| type : ".$_FILES["scan_file"]["type"]);
            die("
            Sorry, there was an error uploading your file. Please contact system administrator.<br>
            File Upload Name: {$_FILES["scan_file"]["name"]}<br>
            New Upload Name: $newName<br>
            Target File Name: $target_file<br>
            Error #: {$_FILES["scan_file"]["error"]} : " . $phpFileUploadErrors[$_FILES["scan_file"]["error"]]
            );
        }
        $uploadOk = 1;
    }


    if ($local_file != ""){
        $sql_delete_time="
            DELETE FROM fn_scan WHERE scanfile_id='{$_POST["hidden_file_id"]}'
        ";
        $query_delete_time=mysqli_query($conn,$sql_delete_time);

        $edit_id=$_POST["hidden_file_id"];
        $comment=""; $status=0;
        $sql_update_insert = "
            LOAD DATA LOCAL INFILE '$local_file'
            INTO TABLE fn_scan
            CHARACTER SET UTF8
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\\r\\n'
            (time_machine_id,time_machine_count,person_id,time_department,time_fullname,time_datetime,time_transaction,time_company)
            SET scanfile_id='$edit_id', time_comment='$comment', time_status='$status'
        ";
//        echo "sql scan is : ".$sql_update_insert;
//        exit();
        $query_update_scan = mysqli_query($conn, $sql_update_insert);
        if ($query_update_scan) unlink("././$local_file");
    }

    if($_FILES["scan_file"]["tmp_name"]!=""){
        $sql_update_file.="
            ,scanfile_name='$local_file'
            WHERE scanfile_id='{$_POST["hidden_file_id"]}'
        ";
    }else  $sql_update_file.=" WHERE scanfile_id='{$_POST["hidden_file_id"]}' ";

    $query_update_file = mysqli_query($conn, $sql_update_file);

    if ($query_update_file OR $query_update_scan) {
        ?>
        <script>
            alert("แก้ไขไฟล์ข้อมูลเวลาทำงาน เรียบร้อยแล้ว!");
            window.location = "index.php?mod=fn/manage_time";
        </script>
        <?php
    }


}


?>