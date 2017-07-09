<?php
$redirect = "?page=home";
if(isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != "") {	
	session_destroy();
	header("Location: $redirect");
	exit();
}else{
	header("Location: $redirect");
	exit();
}
?>