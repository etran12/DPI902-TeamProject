<?php
$redirect = "?page=home";
if(isset($_SESSION['username']) &&  $_SESSION['username'] != "") {	
	session_destroy();
	header("Location: $redirect");
	exit();
}else{
	header("Location: $redirect");
	exit();
}
?>