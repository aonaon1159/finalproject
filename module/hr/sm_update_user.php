	<?php  
	$update_user = "UPDATE hr_person SET cre_login = 1 WHERE person_id = $fullname";
	mysql_query($conn, $update_user);
	?>