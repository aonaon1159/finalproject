<?php


if (isset($_GET['edit_id']) && isset($_GET['history_id'])) {
    $sql_del_history = "DELETE FROM hr_person_history WHERE person_id='{$_GET['edit_id']}' AND history_id='{$_GET["history_id"]}'";
    $query_del = mysqli_query($conn, $sql_del_history);
    if ($query_del) {
        mysqli_close($conn);
        ?>
        <script>
            alert("ลบข้อมูลประวัติการทำงาน เรียบร้อยแล้ว!");
            window.location = "index.php?mod=hr/form_edit_history&edit_id=<?=$_GET['edit_id']?>";
        </script>
        <?php
    }
}
?>

