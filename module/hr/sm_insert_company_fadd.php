<?php

if(!empty($_POST['company_name'])){
	$sql_id = mysqli_query($conn ,"SELECT company_id FROM hr_person_company");
	
	$company_id = 1;
	while(list($id) = mysqli_fetch_row($sql_id)){
		if($id!=$company_id) break;
		else $company_id++;
	}
	// mysqli_free_result($sql_max);

    $sql_insert="INSERT INTO hr_person_company(company_id, company_name ,company_description) VALUES ('$company_id','$_POST[company_name]','$_POST[company_description]')";
    $query=mysqli_query($conn,$sql_insert);
    if($query) mysqli_close($conn);
?>
<script>
    alert("เพิ่มบริษัท เรียบร้อยแล้ว!");
    window.location = "index.php?mod=hr/form_add_employment&add_id=<?=$_GET['id']?>";
</script>
<?php
}else{
?>
<script>
    alert("กรุณากรอกชื่อบริษัท!");
    window.location = "index.php?mod=hr/form_add_company&id=<?=$_GET['id']?>";
</script>
<?php
}
?>

