<?php
// define variables and set to empty values
$nameErr = $emailErr = "";
$name = $email = $comment = "";

//Determines if Comment is a Reply to a Comment or a Comment on the Article
$targetTable = "";

if (isset($_GET['id']))
{
	/*
	// Create connection
	$conn = new mysqli($serverName, $username, $password, $dbName);
	// Check connection
	if ($conn->connect_error) 
	{
		
		echo $_GET['id'];

		die("Connection failed: " . $conn->connect_error);
	} 
	*/
	$conn = sqlConnection();
	
	$sqlquery = "SELECT * FROM ARTICLE WHERE ID='" . $_GET['id'] . "'";

	$result = $conn->query($sqlquery);		

	//echo $result->fetch_fields();
	if ($result->num_rows > 0) 
	{
		while($row = $result->fetch_row())
		{
			echo $row[1];
			echo $row[2];
			echo $row[3];
		}
	} 
	else 
	{
		echo "0 results";
	}
$conn->close(); 
}

if (isset($_POST['commentPost'])) 
{
	if(isset($_POST['form-submitComment']))
		$targetTable = $_POST['commentPost'];
	//else if (isset($_POST['form-submitReply']))
		//$targetTable = $_POST['form-submitReply'];
	
	if (empty($_POST["name"])) 
	{
		$nameErr = "Name is required";
	}
	else
	{
		$name = test_input($_POST["name"]);
		
		/* Uncomment when developing PROPER security measures
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) 
		{
			$nameErr = "Only letters and white space allowed"; 
		}
		*/
	}
  
	if (empty($_POST["email"])) 
	{
		$emailErr = "Email is required";
	}
	else 
	{
		$email = test_input($_POST["email"]);
		
		/* Uncomment when developing PROPER security measures`
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
		$emailErr = "Invalid email format"; 
		}
		*/
	}
	if (empty($_POST["comment"])) 
	{
		$comment = "";
	} 
	else 
	{
		$comment = test_input($_POST["comment"]);
	}
  
	/*
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	} 
	
	*/
	
	$conn = sqlConnection();
	
	//Adjust Query to do insert
	$sqlquery = "INSERT INTO ARTICLE_COMMENT (ARTICLE_ID, USERNAME, EMAIL, CONTENT) VALUES ( " 
	.$_POST['id']. ", " .$username. ", " .$email. ", " .$content. " )";

	$result = $conn->query($sqlquery);		
	
	//echo $result->fetch_fields();
	if ($result) 
	{
		echo "Successful Insert";
	} 
	else 
	{
		echo "Failed Insert";
	}
	$conn->close(); 
}

function sqlConnection()
{
	//DB Variables
	$serverName = "localhost";
	$username = "user";
	$password = "password";
	$dbName = "dpi902";
	
	// Create connection
	$conn = new mysqli($serverName, $username, $password, $dbName);
	// Check connection

	if ($conn->connect_error) 
	{
		echo $_GET['id'];

		die("Connection failed: " . $conn->connect_error);
	}
	
	return $conn;
}

function securityFilter()
{
	
}
function securityScreen1()
{
	
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<a href="">Back to list</a>
		<h1 style = "margin-top:1%;">Website security</h1>
	</div>
	<div class="panel-body">
		<div class = "row">
			<div class = "col-xs-8 col-xs-offset-2">
				<div>
				<?php
				/*
					$conn = sqlConnection();
					
					$sqlquery = "SELECT * FROM ARTICLE WHERE ID='" .$_GET['id']. "'";
					$result = $conn->query($sqlquery);		

					//echo $result->fetch_fields();
					if ($result->num_rows > 0) 
					{
						while($row = $result->fetch_row())
						{
							echo $row[2];
						}
					} 
					else 
					{
						echo "0 results";
					}
					$conn->close(); 
					*/
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
		<div class="row">
			<div class="form-group col-xs-6">
				<label for="name" class="h4">Name</label>
				<input type="text" class="form-control" id="name" placeholder="Enter name" required>
			</div>
			<div class="form-group col-xs-6">
				<label for="email" class="h4">Email</label>
				<input type="email" class="form-control" id="email" placeholder="Enter email" required>
			</div>
		</div>
		<div class="form-group">
			<label for="message" class="h4 ">Message</label>
			<textarea id="message" class="form-control" rows="5" placeholder="Enter your message" required></textarea>
		</div>
		<button name="commentPost" type="submit" id="form-submitComment" class="btn btn-success btn-lg pull-right " value = "ARTICLE_COMMENT">Submit</button>
		<div id="msgSubmit" class="h3 text-center hidden">Message Submitted!</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<h2>Comments</h2>
		<hr>
		<div class = "row" style = "margin: 0 auto;padding-left:5%;padding-right:5%;">
			<div class="panel panel-default arrow left">
				<div class="panel-body" style = "padding-bottom:0;">
					<div class = "row">
						<div class = "col-xs-2">
							<figure class="thumbnail" style = "border:none;">
								<img class="img-circle" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
								<figcaption class="text-center">username</figcaption>
							</figure>
						</div>
						<div class = "col-xs-10">
							<header class="text-left">
								<div class="comment-user"><i class="fa fa-user"></i> username</div>
								<time class="comment-date" datetime="5-25-2017 01:05"><i class="fa fa-clock-o"></i> May 25, 2017</time>
							</header>
							<hr style = "margin-top:2%;margin-bottom:2%;">
							<div class="comment-post">
							<p>
								Comment
							</p>
							</div>
							<hr style = "margin-top:2%;margin-bottom:2%;">
							<p class="text-right"><a href="" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> reply</a></p>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default arrow left" style = "margin-left:10%;">
				<div class="panel-body" style = "padding-bottom:0;">
					<div class = "row">
						<div class = "col-xs-2">
							<figure class="thumbnail" style = "border:none;">
								<img class="img-circle" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
								<figcaption class="text-center">username</figcaption>
							</figure>
						</div>
						<div class = "col-xs-10">
							<header class="text-left">
								<div class="comment-user"><i class="fa fa-user"></i> username</div>
								<time class="comment-date" datetime="5-25-2017 01:05"><i class="fa fa-clock-o"></i> May 25, 2017</time>
							</header>
							<hr style = "margin-top:2%;margin-bottom:2%;">
							<div class="comment-post">
							<p>
								Comment
							</p>
							</div>
							<hr style = "margin-top:2%;margin-bottom:2%;">
							<p class="text-right"><a href="" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> reply</a></p>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default arrow left">
				<div class="panel-body" style = "padding-bottom:0;">
					<div class = "row">
						<div class = "col-xs-10">
							<header class="text-left">
								<div class="comment-user"><i class="fa fa-user"></i> username</div>
								<time class="comment-date" datetime="5-25-2017 01:05"><i class="fa fa-clock-o"></i> May 25, 2017</time>
							</header>
							<hr style = "margin-top:2%;margin-bottom:2%;">
							<div class="comment-post">
							<p>
								Comment
							</p>
							</div>
							<hr style = "margin-top:2%;margin-bottom:2%;">
							<p class="text-right"><a href="" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> reply</a></p>
						</div>
						<div class = "col-xs-2">
							<figure class="thumbnail" style = "border:none;">
								<img class="img-circle" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
								<figcaption class="text-center">username</figcaption>
							</figure>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default arrow left">
				<div class="panel-body" style = "padding-bottom:0;">
					<div class = "row">
						<div class = "col-xs-2">
							<figure class="thumbnail" style = "border:none;">
								<img class="img-circle" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
								<figcaption class="text-center">username</figcaption>
							</figure>
						</div>
						<div class = "col-xs-10">
							<header class="text-left">
								<div class="comment-user"><i class="fa fa-user"></i> username</div>
								<time class="comment-date" datetime="5-25-2017 01:05"><i class="fa fa-clock-o"></i> May 25, 2017</time>
							</header>
							<hr style = "margin-top:2%;margin-bottom:2%;">
							<div class="comment-post">
							<p>
								Comment
							</p>
							</div>
							<hr style = "margin-top:2%;margin-bottom:2%;">
							<p class="text-right"><a href="" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> reply</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
