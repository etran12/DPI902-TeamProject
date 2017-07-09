<?php
	if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 
		$conn = sqlConnection();
		$sqlquery = "SELECT * FROM USERS WHERE ID = ".$_SESSION['user_id'];
		$result = $conn->query($sqlquery);
		$row = $result->fetch_assoc();
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 style = "margin-top:1%;">Change User Information</h3>
	</div>
	<div class="panel-body">
		<form action="?page=/operations/updateUser" method="POST" enctype="multipart/form-data">
			<div class = "row">
				<div class = "col-xs-12 col-xs-offset-2">
					<div class="row">
						<div class="form-group col-xs-8">
								<label for="name" class="h4">Name</label>
								<input type="text" class="form-control" id="name" name = "username" value = "<?php echo $row['USERNAME']; ?>" placeholder="Enter name" required>
						</div>
					</div>
					<div class = "row">
						<div class="form-group col-xs-8">
							<label for="email_address" class="h4">Email</label>
							<input type="email" class="form-control" id="email_address" name = "email" value = "<?php echo $row['EMAIL']; ?>" placeholder="Enter email" required>
						</div>
					</div>
					<div class = "row">
						<div class="form-group col-xs-8">
							<label for="upload" class="h4">Profile Picture</label>
							<input type="file" id = "upload" name="fileToUpload" id="fileToUpload">
						</div>
					</div>
	
					<input type="submit" value="Update User" name="submit" style = "margin-top:10px;margin-bottom:10px;">
					<?php
						if(isset($_GET['change'])){
							if($_GET['change'] == 1){
							echo "Update was successful";
							}else{
								echo "Sorry, something went wrong"; 
							}
						}
					?>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
	}
?>