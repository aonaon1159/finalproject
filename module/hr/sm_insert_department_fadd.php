<?php

if(!empty($_POST['department_name'])){
	$sql_id = mysqli_query($conn ,"SELECT department_id FROM hr_person_department");
	
	$department_id = 1;
	while(list($id) = mysqli_fetch_row($sql_id)){
		if($id!=$department_id) break;
		else $department_id++;
	}
	// mysqli_free_result($sql_max);

    $sql_insert="INSERT INTO hr_person_department(department_id, department_name) VALUES ('$department_id','$_POST[department_name]')";
    $query=mysqli_query($conn,$sql_insert);
    if($query) mysqli_close($conn);
?>
<script>
    alert("เพิ่มแผนก เรียบร้อยแล้ว!");
    window.location = "index.php?mod=hr/form_add_employment&add_id=<?=$_GET['id']?>";
</script>
<?php
}else{
?>
<script>
    alert("กรุณากรอกชื่อแผนก!");
    window.location = "index.php?mod=hr/form_add_department&id=<?=$_GET['id']?>";
</script>
<?php
}
?>

