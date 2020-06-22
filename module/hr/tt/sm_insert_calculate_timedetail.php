<?php

if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
} else $session = ($_SESSION["uID"]);

if(isset($_POST['calculate_scanfile_id'])){	
	if($_POST['calculate_scanfile_id']!=0){
		$sql_select_person_id = mysqli_query($conn ,"SELECT person_id FROM fn_calculate_date WHERE person_id = '$calculate_person_id'");

		if(mysqli_num_rows($sql_select_person_id) === 0){ 
			mysqli_query($conn ,"INSERT INTO fn_calculate_date SET scanfile_id = '$calculate_scanfile_id',
				person_id = '$calculate_person_id',calculate_pay = '$calculate_pay',calculate_no_pay = '$calculate_no_pay', calculate_cut_pay = '$calculate_cut_pay'
				
			");
		}
	}
}
?>
