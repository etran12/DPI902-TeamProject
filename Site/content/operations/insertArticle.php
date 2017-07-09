<?php
if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 
	$conn = sqlConnection();
	
	$title = $_POST['title'];
	$content = $_POST['content'];
	
	$sqlquery = "INSERT INTO ARTICLE (TITLE, CONTENT) VALUES('".$title."','".$content."')";
	$result = $conn->query($sqlquery);
	
	$success = true;
	if ($result === TRUE) {
		echo "Record inserted successfully"."<br>";
	} else {
		echo "Error inserting record: " . $conn->error."<br>";
		$success = false;
	}
	
	if($_FILES['fileToUpload']['name'] != ""){
		$id = $conn->insert_id;
		
		$target_dir = "Media/Article/".$id."/";
		$file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = pathinfo($file,PATHINFO_EXTENSION);
		
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
		}
		
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded."."<br>";
			$sqlquery = "UPDATE ARTICLE SET ARTICLE_IMAGE = '".$file."' WHERE ID = '".$id."'";
			$result = $conn->query($sqlquery);
			if ($result === TRUE) {
				echo "Record updated successfully"."<br>";
			} else {
				echo "Error updating record: " . $conn->error."<br>";
				$success = false;
			}
		}else{
			$success  = false;
		}
	}
	
	$conn->close();
	header("Location: ?page=articleForm&change=".$success);
}
?>