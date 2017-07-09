<?php
	if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 
		$conn = sqlConnection();
		$sqlquery = "SELECT * FROM USERS WHERE ID = ".$_SESSION['user_id'];
		$result = $conn->query($sqlquery);
		$row = $result->fetch_assoc();
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 style = "margin-top:1%;">Change Password</h>
	</div>
	<div class="panel-body">
		
		<form action="?page=/operations/updatePassword" method="POST" enctype="multipart/form-data">
			<div class = "row">
				<div class = "col-xs-12 col-xs-offset-2">
					<div class="row">
						<div class="form-group col-xs-8">
							<label for="pass1" class="h4">Password</label>
							<input type="password" class="form-control" id="pass1" name = "newPassword" value = "" placeholder="Enter New Password" required>
						</div>
					</div>
					<div class = "row">
						<div class="form-group col-xs-8">
							<label for="pass2" class="h4">Confirm Password</label>
							<input type="password" class="form-control" id="email" name = "confirmPassword" value = "" placeholder="Confirm New Password" required>
						</div>
					</div>
					<input type="submit" value="Change Password" name="submit" style = "margin-top:10px;margin-bottom:10px;">
					<?php
						if(isset($_GET['change'])){
							if($_GET['change'] == 1){
							echo "Password successfully updated";
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