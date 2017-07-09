<?php
if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 

	$conn = sqlConnection();
	$sqlquery = "SELECT * FROM USERS WHERE ID = '".$_SESSION['user_id']."'";
	$result = $conn->query($sqlquery);
	$row = $result->fetch_assoc();

	$newPassword = $_POST['newPassword'];
	$confirmPassword = $_POST['confirmPassword'];
	
	$success = true;
	if($newPassword == $confirmPassword){
		$sqlquery = "UPDATE USERS SET PASS = '".$newPassword."' WHERE ID = ".$_SESSION['user_id'];
		$result = $conn->query($sqlquery);
		if ($result === TRUE) {
			echo "Record updated successfully"."<br>";
		} else {
			echo "Error updating record: " . $conn->error."<br>";
			$success = false;
		}
	}else{
		$success = false;
	}
		
	$conn->close();
	header("Location: ?page=changePassword&change=".$success);
}
?>