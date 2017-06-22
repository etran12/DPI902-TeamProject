<?php

$error = false;
$conn = sqlConnection();

if(isset($_POST['submit'])){
	
	$email = $_POST["email"];
	$password = $_POST["password"];

	$sqlquery = "SELECT * FROM USERS WHERE EMAIL = '".$email."' AND PASS = '".$password."'";
	$result = $conn->query($sqlquery);
	
	if ($result){
		if($result->num_rows > 0){
			$user = $result->fetch_assoc();
			$_SESSION["user_id"] = $user["ID"];
			$_SESSION["username"] = $user["USERNAME"];
	
		
			if(!empty($_POST["remember"])) {
				setcookie ("member_login",$_POST["email"],time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ("member_password",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
			} else {
				if(isset($_COOKIE["member_login"])) {
					setcookie ("member_login","");
				}
				if(isset($_COOKIE["member_password"])) {
					setcookie ("member_password","");
				}
			}
			
			
			//$conn->close();
			header('Location: ?page=home');
			exit();
		}else{
			$error = true;
		}
	}
}

?>
<div class="panel panel-default" style = "width:350px;margin:0;">
	<div class="panel-heading">
		<div class="panel-title"><p>Login</p></div>
	</div>
	<div class="panel-body" style="padding-left:35px;padding-right:35px;padding-bottom:0;">
		<form id="loginform" class="form-horizontal" method="POST" action="">
			<div class = "form-group">
				<div class="input-group pull-left">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input id="email" type="text" class="form-control" name="email" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" placeholder="Email" required>
				</div>
			</div>

			<div class = "form-group">
				<div class="input-group pull-left">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="password" type="password" class="form-control" name="password" value = "<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>" placeholder="Password" required>
				</div>
			</div>
			
			<div class="form-group">
				<input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> />
				<label>Remember me</label>
			</div>
			
			<div class="form-group">
				<button type="submit" name = 'submit' class="btn btn-primary">Login</button>
				<?php
				if($error){
				?>
					<p style = "color:red;margin-top:5px;margin-bottom:0;">Invalid Credentials</p>
				<?php
				}
				?>
			</div>
			
		</form>
	</div>
</div>



