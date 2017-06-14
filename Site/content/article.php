<?php
if(!isset($_GET['pageno'])){
	$redirect = "http://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]."&pageno=1";
	header("Location: ".$redirect);
}

$nameErr = $emailErr = "";
$name = $email = $content = "";

if (isset($_GET['id'])){

	$conn = sqlConnection();
	
	$sqlquery = "SELECT * FROM ARTICLE WHERE ID='" . $_GET['id'] . "'";

	$result = $conn->query($sqlquery);		
	
	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<a href="?page=home">Back to list</a>
		<h1 style = "margin-top:1%;"><?php echo $row["TITLE"]; ?></h1>
	</div>
	
	<div class="panel-body">
		<div class = "row">
			<div class = "col-xs-8 col-xs-offset-2">
				<div>
				<?php
					echo $row["CONTENT"];
				?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<h2>Add Comment</h2>
		<hr>
		<form action="" method="post">
			<div class="row">
				<div class="form-group col-xs-6">
					<label for="name" class="h4">Name</label>
					<input type="text" class="form-control" id="name" name = "name" placeholder="Enter name" required>
				</div>
				<div class="form-group col-xs-6">
					<label for="email" class="h4">Email</label>
					<input type="email" class="form-control" id="email" name = "email" placeholder="Enter email" required>
				</div>
			</div>
			<div class="form-group">
				<label for="message" class="h4 ">Message</label>
				<textarea id="message" name = "comment" class="form-control" rows="5" placeholder="Enter your message" required></textarea>
			</div>
			<button name="commentPost" type="submit" id="form-submitComment" class="btn btn-success btn-lg pull-right " value = "ARTICLE_COMMENT">Submit</button>
		</form>
		<div id="msgSubmit" class="h3 text-center hidden">Message Submitted!</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<h2>Comments</h2>
		<hr>
		
		<div class = "row" style = "margin: 0 auto;padding-left:5%;padding-right:5%;">
		<?php
			$sqlquery = "SELECT * FROM ARTICLE_COMMENT WHERE ARTICLE_ID = ".$_GET['id']." AND COMMENT_ID IS NULL";
			$result = $conn->query($sqlquery) or die(mysql_error());
			$rowCount = $result->num_rows; // Total number of rows
			
			$pagination = new Pagination(5, $rowCount);
		
			if($rowCount > 0){
				display_comments ($_GET['id'], $conn, $pagination->getOffset(), $pagination->getResultLimit());
			}else{
				echo "<p>No comments posted</p>";
			}
		?>
	
		
		</div>
		
	</div>
	<div class = "panel-footer text-center">
		<ul class="pagination" style = "float:none;display:inline-block;*display:inline;">
		<?php
			$pagination->display();
		?>
		</ul>
	</div>
</div>
<?php
	$numItems = 5;
	
	if (isset($_POST['commentReplyPost'])) {
		if(isset($_POST['commentReplyPost'])) $commentID = $_POST['commentReplyPost'];
		
		if (empty($_POST["name"])) {
			$nameErr = "Name is required";
		}else{
			$name = test_input($_POST["name"]);
		}
		
		if (empty($_POST["email"])) {
			$emailErr = "Email is required";
		}else {
			$email = test_input($_POST["email"]);
		}
		
		if (empty($_POST["comment"])) {
			$content = "";
		} else {
			$content = test_input($_POST["comment"]);
		}
		
		$sqlquery = "INSERT INTO ARTICLE_COMMENT (ARTICLE_ID, COMMENT_ID, USERNAME, EMAIL, CONTENT) VALUES 
		(".$_GET['id'].", ".$commentID.", '".$name."', '".$email."', '".$content."')";
		
		$result = $conn->query($sqlquery);		
		echo '<meta http-equiv="refresh" content="0">';
		exit();		
	}
	
	if (isset($_POST['commentPost'])) {
		
		if(isset($_POST['form-submitComment'])) $targetTable = $_POST['commentPost'];
		
		if (empty($_POST["name"])) {
			$nameErr = "Name is required";
		}else{
			$name = test_input($_POST["name"]);
			/* Uncomment when developing PROPER security measures
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/",$name)) 
			{
				$nameErr = "Only letters and white space allowed"; 
			}
			*/
		}
		
		if (empty($_POST["email"])) {
			$emailErr = "Email is required";
		}else {
			$email = test_input($_POST["email"]);
			/* Uncomment when developing PROPER security measures`
			// check if e-mail address is well-formed
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
			$emailErr = "Invalid email format"; 
			}
			*/
		}
		
		if (empty($_POST["comment"])) {
			$content = "";
		} else {
			$content = test_input($_POST["comment"]);
		}
		
		$sqlquery = "INSERT INTO ARTICLE_COMMENT (ARTICLE_ID, USERNAME, EMAIL, CONTENT) VALUES ( " 
		.$_GET['id']. ", '" .$name. "', '" .$email. "', '" .$content. "')";
	
		$result = $conn->query($sqlquery);		
		//header('Location: ?page=article&id=1');
		echo '<meta http-equiv="refresh" content="0">';
		exit();
	}	
	
	}else{
		header('Location: ?page=404.php');
		exit();
	}
	
	//$conn->close(); 
	exit();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


