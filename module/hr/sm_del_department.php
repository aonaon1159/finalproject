<?php
if ($_GET['id']) {

    $sql_del = "DELETE FROM hr_person_department WHERE department_id='$_GET[id]'";
    $query_delete = mysqli_query($conn, $sql_del);

    if ($query_delete){
        mysqli_close($conn);
        ?>
        <script>
            alert("ลบแผนกียบร้อยแล้ว!");
            window.location = "index.php?mod=hr/manage_department&id="+<?=$_GET['edit_id']?>;
        </script>
        <?php
    }
}
?>

