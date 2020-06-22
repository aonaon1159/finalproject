<?php

//    echo "coming del : ".$_POST['hidden_edit_id'];
//    echo "fgdafds : ".$_POST['hidden_history_id'];
//    exit();

if (isset($_POST['hidden_edit_id']) && isset($_POST['hidden_history_id'])) {
    $sql_update="UPDATE hr_person_history SET person_id='{$_POST["hidden_edit_id"]}', history_company='{$_POST["history_company"]}', history_position='{$_POST["history_position"]}', history_start='{$_POST["history_start"]}', history_finish='{$_POST["history_finish"]}', history_salary='{$_POST["history_salary"]}', history_reason='{$_POST["reason"]}' WHERE history_id='{$_POST["hidden_history_id"]}'";
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

