<?php

//    echo "$_POST[hidden_edit_id]','$_POST[degree_level]','$_POST[gpa]','$_POST[education_start]','$_POST[education_end]";
if (isset($_POST['hidden_edit_id']) && isset($_POST['degree_name'])) {
    $sql_insert = "INSERT INTO hr_person_education(person_id, degree_id,education_name,education_degree,education_major, education_gpa, education_start, education_finish) VALUES('{$_POST["hidden_edit_id"]}','{$_POST["degree_level"]}','{$_POST["degree_name"]}','{$_POST["degree"]}','{$_POST["major"]}','{$_POST["gpa"]}','{$_POST["education_start"]}','{$_POST["education_end"]}') ";
    $query = mysqli_query($conn, $sql_insert) or die("Sql error is : " . mysqli_error($conn));
    if ($query) {
        mysqli_close($conn);
        ?>
        <script>
            alert("เพิ่มข้อมูลวุฒิการศึกษา เรียบร้อยแล้ว!");
            window.location = "index.php?mod=hr/form_edit_history&edit_id=<?=$_POST['hidden_edit_id']?>";
        </script>
        <?php
        exit();
    }
}
?>

