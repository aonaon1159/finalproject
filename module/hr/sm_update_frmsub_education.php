<?php

if (isset($_POST['hidden_edit_id']) && isset($_POST['hidden_education_id'])) {
    $sql_update="UPDATE hr_person_education SET person_id='{$_POST["hidden_edit_id"]}', degree_id='{$_POST["degree_level"]}',education_name='{$_POST["degree_name"]}',education_degree='{$_POST["degree"]}',education_major='{$_POST["major"]}', education_gpa='{$_POST["gpa"]}', education_start='{$_POST["education_start"]}', education_finish='{$_POST["education_end"]}' WHERE education_id='{$_POST["hidden_education_id"]}'";
    $query = mysqli_query($conn, $sql_update) or die("Sql error is : " . mysqli_error($conn));
    if ($query)
    mysqli_close($conn);
    ?>
    <script>
        alert("แก้ไขข้อมูลวุฒิการศึกษา เรียบร้อยแล้ว!");
        window.location = "index.php?mod=hr/form_edit_history&edit_id=<?=$_POST['hidden_edit_id']?>";
    </script>
    <?php
    exit();
}
?>

