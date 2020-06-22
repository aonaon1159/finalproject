<?php

if (isset($_GET['add_id']) && isset($_GET['education_id'])) {
    $sql_del_education = "DELETE FROM hr_person_education WHERE education_id='{$_GET["education_id"]}'";
    $query_del = mysqli_query($conn, $sql_del_education);
    if ($query_del)
        mysqli_close($conn);
}

?>
<script>
    alert("ลบข้อมูลประวัติวุฒิการศึกษา เรียบร้อยแล้ว!");
    window.location = "index.php?mod=hr/form_add_history&add_id=<?=$_GET['add_id']?>";
</script>
