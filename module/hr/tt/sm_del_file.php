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
            UPDATE fn_salary_file SET
            deleted='$one'
            WHERE file_id='{$_GET["id"]}'
        ";
    $query_update = mysqli_query($conn, $sql_update_file);
    if ($query_update) {
        $sql_del_salary = "
                DELETE FROM fn_salary 
                WHERE file_id='{$_GET["id"]}'
            ";
        $query_del_salary = mysqli_query($conn, $sql_del_salary);
        if ($query_del_salary) {
            ?>
            <script>
                alert("ลบข้อมูลไฟล์เงินเดือน เรียบร้อยแล้ว!");
                window.location = 'index.php?mod=fn/manage_salary';
            </script>
            <?php
        }
    }
}

?>