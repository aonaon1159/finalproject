<?php

if(!empty($_POST['position_name'])){
	$sql_id = mysqli_query($conn ,"SELECT position_id FROM hr_person_position");
	
	$position_id = 1;
	while(list($id) = mysqli_fetch_row($sql_id)){
		if($id!=$position_id) break;
		else $position_id++;
	}
	// mysqli_free_result($sql_max);

    $sql_insert="INSERT INTO hr_person_position(position_id, position_name) VALUES ('$position_id','$_POST[position_name]')";
    $query=mysqli_query($conn,$sql_insert);
    if($query) mysqli_close($conn);
?>
<script>
    alert("เพิ่มตำแหน่ง เรียบร้อยแล้ว!"); 
    window.location = "index.php?mod=hr/form_edit_employment&edit_id=<?= $_GET['id']?>";
</script>
<?php
}else{
?>
<script>
    alert("กรุณากรอกชื่อตำแหน่ง!");
    window.location = "index.php?mod=hr/form_edit_position&id=<?= $_GET['id']?>";
</script>
<?php
}
?>

