<?php
if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 
	
	$conn = sqlConnection();
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$content = $_POST['content'];
	
	$sqlquery = "UPDATE ARTICLE SET TITLE ='".$title."', CONTENT = '".$content."' WHERE ID = ".$id;
	$result = $conn->query($sqlquery);
	
	$success = true;
	if ($result === TRUE) {
		echo "Title and Content updated successfully"."<br>";
	} else {
		echo "Error updating record: " . $conn->error."<br>";
		$success = false;
	}
	
	if($_FILES['fileToUpload']['name'] != ""){
		$sqlquery = "SELECT * FROM ARTICLE WHERE ID = '".$id."'";
		$result = $conn->query($sqlquery);
		$row = $result->fetch_assoc();
		if(isset($row['ARTICLE_IMAGE'])){
			$originalFile = $row['ARTICLE_IMAGE']; 
		}
		
		$target_dir = "Media/Article/".$id."/";
		$file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = pathinfo($file,PATHINFO_EXTENSION);
		
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
		}
		
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded."."<br>";
			$sqlquery = "UPDATE ARTICLE SET ARTICLE_IMAGE = '".$file."' WHERE ID = ".$id;
			$result = $conn->query($sqlquery);
			if ($result === TRUE) {
				echo "Record updated successfully"."<br>";
				if(isset($originalFile)){
					if($originalFile != $file){
						if (!unlink($originalFile)){
							echo ("Error deleting $originalFile"."<br>");
							$success = false;
						}else{
							echo ("Deleted $originalFile"."<br>");
						}
					}
				}
			} else {
				echo "Error updating record: " . $conn->error."<br>";
				$success = false;
			}	
		}else{
			echo "Error Uploading File"."<br>";
			$success = false;
		}
	}else{
		echo "No File to Upload"."<br>";
	}
	
	$conn->close();
	header("Location: ?page=articleForm&id=".$id."&change=".$success);
}
?>