<?php

if (isset($_GET['add_id']) && isset($_GET['history_id'])) {
    $sql_del="DELETE FROM hr_person_history WHERE history_id='{$_GET["history_id"]}'";
    $query=mysqli_query($conn,$sql_del);
    if($query)
        mysqli_close($conn);
}

?>
<script>
    alert("ลบข้อมูลประวัติการทำงาน เรียบร้อยแล้ว!");
    window.location="index.php?mod=hr/form_add_history&add_id=<?=$_GET['add_id']?>";
</script>