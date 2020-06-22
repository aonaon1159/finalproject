<?php
if ($_GET['id']) {

    $sql_del = "DELETE FROM hr_person_company WHERE company_id='$_GET[id]'";
    $query_delete = mysqli_query($conn, $sql_del);

    if ($query_delete){
        mysqli_close($conn);
        ?>
        <script>
            alert("ลบบริษัทเรียบร้อยแล้ว!");
            window.location = "index.php?mod=hr/manage_add_company&id="+<?=$_GET['edit_id']?>;
        </script>
        <?php
    }
}
?>

