<?php

//echo "ss : ".$_POST['hidden_edit_id'];
if (isset($_POST['hidden_edit_id'])) {
    $sql_insert = "INSERT INTO hr_person_history(person_id, history_company, history_position, history_start, history_finish, history_salary, history_reason) VALUES('{$_POST["hidden_edit_id"]}','{$_POST["history_company"]}','{$_POST["history_position"]}','{$_POST["history_start"]}','{$_POST["history_finish"]}','{$_POST["history_salary"]}','{$_POST["reason"]}') ";
    $query = mysqli_query($conn, $sql_insert);
    if ($query) {
        mysqli_close($conn);
        ?>
        <script>
            alert("เพิ่มข้อมูลประวัติการทำงาน เรียบร้อยแล้ว!");
            window.location = "index.php?mod=hr/form_edit_history&edit_id=<?=$_POST['hidden_edit_id']?>";
        </script>
        <?php
        exit();
    }

}
?>

