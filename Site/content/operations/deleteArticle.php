<?php
if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 
	$conn = sqlConnection();
	$id = $_POST['id'];
	
	echo $id; 
	$sqlquery = "DELETE FROM ARTICLE WHERE ID = ".$id;
	$result = $conn->query($sqlquery);
	
	$conn->close();
	header("Location: ?page=articleList");
}
?>