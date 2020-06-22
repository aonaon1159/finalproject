<?php
if (!isset($_SESSION["uID"]) or $_SESSION["uID"] == null) {
	header("location: ./");
	exit();
}
?>