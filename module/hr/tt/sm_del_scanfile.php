<?php
/**
 * Created by PhpStorm.
 * User: Avaibooking
 * Date: 2/7/2018
 * Time: 2:47 PM
 */

if (isset($_GET["id"])) {
    $one = 1;
    $sql_update_file = "
            UPDATE fn_scan_file SET
            deleted='$one'
            WHERE scanfile_id='{$_GET["id"]}'
        ";
    $query_update = mysqli_query($conn, $sql_update_file);
    if ($query_update) {
        $sql_del_time = "
                DELETE FROM fn_scan 
                WHERE scanfile_id='{$_GET["id"]}'
            ";
        $query_del_time = mysqli_query($conn, $sql_del_time);
        if ($query_del_time) {
            ?>
            <script>
                alert("ลบข้อมูลไฟล์เวลาทำงาน เรียบร้อยแล้ว!");
                window.location = 'index.php?mod=fn/manage_time';
            </script>
            <?php
        }

    }
}

?>