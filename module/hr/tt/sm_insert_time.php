<?php
/**
 * Created by PhpStorm.
 * User: Avaibooking
 * Date: 2/12/2018
 * Time: 3:56 PM
 */
if (!isset($_SESSION["uID"])) {
    // exit("<script>window.location = './';</script>");
} else $session = ($_SESSION["uID"]);

            
if (isset($_POST["company"])) {
//    exit("value of company : ".$_POST["company"]);
    $datetime = date("Y-m-d H:i:s");
    $sql_insert_file = "
            INSERT INTO fn_scan_file SET 
            scanfile_company='{$_POST["company"]}',
            scanfile_title='{$_POST["time_title"]}',
            scanfile_startdate='{$_POST["time_start_date"]}',
            scanfile_enddate='{$_POST["time_end_date"]}',
            scanfile_createDate='$datetime',
            scanfile_createBy='$session',
            deleted='0'
        ";
       
//    exit("check = ".$sql_insert_file);
    if ($_FILES["time_file"]["name"] != "") {
        // if ($_FILES["time_file"]["type"] != "application/vnd.ms-excel") {
        //     ?>
        <!-- //     <script>
        //         alert("* กรุณาใส่ข้อมูล FILE เป็นไฟล์ .CSV (TIS620) เท่านั้น");
        //         window.history.back();
        //     </script>
        //  -->    <?php
        //     exit();
        // }
        $tmp_file = $_FILES["time_file"]["tmp_name"];
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rds = '';
        for ($i = 0; $i < 5; $i++) {
            $rds .= $characters[rand(0, strlen($characters) - 1)];
        }

        $target_dir = "storages/time_csv/" . date("Ymd");
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $upload_file = $target_dir . "/" . basename($_FILES["time_file"]["name"]);
        $ext = pathinfo($upload_file, PATHINFO_EXTENSION);

        $new_name = "CSV_" . date("His") . "_{$rds}_{$session}." . $ext;
        $target_file = $target_dir . "/" . basename($new_name);
        if (move_uploaded_file($_FILES["time_file"]["tmp_name"], $target_file)) {
            $local_file = $target_file;

            
                            // read file
                            // $text = file_get_contents($target_file);


                            // // // convert file 
                            // // // this is utf-8
                            // $probe = iconv('TIS620','UTF-8',$text);
                            // if (strlen($probe) > 0){
                            //     // this is tis-620
                            //     $text = iconv('TIS620','UTF-8',$text);
                            // }

                            
                            // $tsvRows = explode(PHP_EOL, $text);
                            // // $reverseTsv = array_reverse($tsvRows);
                            // $tsvRows = array_reverse(array_splice($tsvRows,1));
                            // $tsvReverse = array_reverse($tsvRows);
                            // $text = implode(PHP_EOL, $tsvReverse);
                            // // put file back to target
                            // file_put_contents($target_file, $text);
                            
                            // unset($text);
            
            
        } else {
//            exit("error : ".$_FILES["time_file"]["error"]."| tmp_name : ".$_FILES["time_file"]["tmp_name"]."| name : ".$_FILES["time_file"]["name"]."| size : ".$_FILES["time_file"]["size"]."| type : ".$_FILES["time_file"]["type"]);
            die("
            Sorry, there was an error uploading your file. Please contact system administrator.<br>
            File Upload Name: {$_FILES["time_file"]["name"]}<br>
            New Upload Name: $newName<br>
            Target File Name: $target_file<br>
            Error #: {$_FILES["time_file"]["error"]} : " . $phpFileUploadErrors[$_FILES["time_file"]["error"]]
            );
        }
        $uploadOk = 1;
    }

    if ($local_file != "") {

        


        $sql_insert_file .= ",scanfile_name='$local_file' ";
        $query_insert_file = mysqli_query($conn, $sql_insert_file);



        if ($query_insert_file) {
            $sql_select_file = " SELECT MAX(scanfile_id) FROM fn_scan_file ";


            $query_file = mysqli_query($conn, $sql_select_file);
            list($max_id) = mysqli_fetch_row($query_file);
            $comment="";
            $status=0;
            $sql_insert_salary = "
                LOAD DATA LOCAL INFILE '$local_file'
                INTO TABLE fn_scan
                CHARACTER SET UTF8
                FIELDS TERMINATED BY ','
                LINES TERMINATED BY '\\r\\n' 
                (time_machine_id,time_machine_count,person_id,time_department,time_fullname,time_datetime,time_transaction,time_company)
                SET scanfile_id='$max_id', time_comment='$comment', time_status='$status'
            ";


            $query_insert_salary = mysqli_query($conn, $sql_insert_salary);

            if ($query_insert_salary) {
                unlink("././$local_file");
                ?>
                <script>
                    alert("เพิ่มไฟล์ข้อมูลเวลาทำงาน เรียบร้อยแล้ว!");
                    window.location = "index.php?mod=fn/manage_time";
                </script>
                <?php
            }

        }
    }
    
}

$add_file_id = $max_id;
$sql_select_person = mysqli_query($conn , "SELECT DISTINCT person_id FROM fn_scan WHERE scanfile_id = '$add_file_id'");

while(list($add_count_id) = mysqli_fetch_row($sql_select_person)){

include("form_view_timedetail.php"); 


}

?>
