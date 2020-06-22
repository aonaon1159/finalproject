<?php

if(!empty($_POST['branch_name'])){
	$sql_id = mysqli_query($conn ,"SELECT branch_id FROM hr_person_branch");
	
	$branch_id = 1;
	while(list($id) = mysqli_fetch_row($sql_id)){
		if($id!=$branch_id) break;
		else $branch_id++;
	}
	mysqli_free_result($sql_max);

    $sql_insert="INSERT INTO hr_person_branch(branch_id, branch_name) VALUES ('$branch_id','$_POST[branch_name]')";
    $query=mysqli_query($conn,$sql_insert);
    if($query) mysqli_close($conn);
?>
<script>
    alert("เพิ่มสาขา เรียบร้อยแล้ว!");
    window.location = "index.php?mod=hr/form_edit_employment&edit_id=<?=$_GET[id]?>";
</script>
<?php
}else{
?>
<script>
    alert("กรุณากรอกชื่อสาขา!");
    window.location = "index.php?mod=hr/form_add_branch&id=<?=$_GET[id]?>";
</script>
<?php
}
?>

