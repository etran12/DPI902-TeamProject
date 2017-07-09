<?php
	session_start();
	ob_start();

	$headerImage = "/Site/Media/header-bg.jpg";
	$headerTitle = "Home";

	$conn = sqlConnection();
	
	if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 
		$sqlquery = "SELECT * FROM USERS WHERE ID = '".$_SESSION['user_id']."'";
		$result = $conn->query($sqlquery);
		$user_row = $result->fetch_assoc();
		$userImage = $user_row["USER_IMAGE"];
	}

	if(isset($_GET['page'])){
		$page = $_GET['page'];
		if($page == "article"){
			$id = $_GET['id'];
			
			$sqlquery = "SELECT TITLE, CONTENT, ARTICLE_IMAGE, DATE_TIME FROM ARTICLE WHERE ID = ".$id;
			
			
			$result = $conn->query($sqlquery);
			global $num_rows;	
			if(!empty($result)){
				$num_rows = $result->num_rows;
				
				global $row;
				$row = $result->fetch_assoc();
				
				$headerTitle = $row["TITLE"];
				$headerImage = $row["ARTICLE_IMAGE"];
			}else{
				$num_rows = 0;
			}
		}
	}
?>
<script>
	$(document).ready(function() {
    $('.nav li').hover(function() {
        $(this).addClass('active');
      },function() {
        $(this).removeClass('active');
      });
	});
	$(function() {
	  // Setup drop down menu
	  $('.dropdown-toggle').dropdown();
	 
	  // Fix input element click problem
	  $('.dropdown input, .dropdown label').click(function(e) {
		e.stopPropagation();
	  });
	});
</script>
<header>
	<nav class="navbar navbar-default" style = "margin:0">
		<div class="container">
			<div class="navbar-header">
				 <a class="navbar-brand" style = "padding:5px;" href="?page=home"><img style = "height: 100%;width:auto;" src="Media/logo.png" ></a>
			</div>
			<div id="navbar">
				<ul class="nav navbar-nav">
					<li><a href="?page=home">Home</a></li>
				</ul>
				
				<ul class="nav pull-right">
					<li class="dropdown" style = "margin-top:7px;">
						<?php
						if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 
							
						?>
							<style>
								.b-image:before{
									background-image : url(
									<?php
										if(isset($userImage)){
											echo $userImage;
										}else{
											echo "http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg";
										}
									?>
									);
									background-size: 20px 20px;
									background-repeat: no-repeat;
									border-radius: 25px;
								}
							</style>
							
							<button class="btn btn-default button-image b-image" data-toggle="dropdown" href=""><?php echo $user_row['USERNAME']; ?> <strong class="caret"></strong></button>
							
						<?php
						}else{ 
						?>
							<button class="btn btn-default" href="" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Sign In <strong class="caret"></strong></button>
						<?php
						}
						?>
						<ul class="dropdown-menu" style="padding: 5px; min-width:100%;">
							<?php
							if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 
							?>
								<li><a href="?page=editUserInfo"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Change User Information</a></li>
								<li><a href="?page=changePassword"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Change Password</a></li>
								<li><a href="?page=articleForm&action=add"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Add Article</a></li>
								<li><a href="?page=articleList"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Edit Articles</a></li>
								<li><a href="?page=/operations/logout"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a></li>
							<?php
							}else{ 
								include("content/login.php");
							}
							?>
						</ul>
					</li>
				</ul>
				
				<form class="navbar-form pull-right" role="search" method="GET" action="">
					<div class="input-group add-on">
					  <input type="hidden" name="page" value="search">
					  <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
					  <div class="input-group-btn">
						 <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					  </div>
					</div>
				</form>
				
			</div>
		</div>
	</nav>
	<div style = "width:100%;height:10px;background-color:steelblue;margin:0;"></div>
	<div id = "headerImageBox" style = "
	<?php
		if(isset($headerImage)){
			echo "background-image: url('".$headerImage."');";
		}else{
			echo "background-image: url('Media/header-bg.jpg');";
		}
	?>
	">
		<div class = "text-center" style = "padding-top:8%;">
			<div style = "color:white;font-family: 'Droid Serif', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-style: italic;font-size: 35px;line-height: 22px;">Hacking 101</div>
			<h3 style = "color:white;font-family: 'Montserrat', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;font-weight: 700;font-size: 50px;line-height: 50px;"><?php echo $headerTitle; ?></h3>
		</div>
	</div>
</header>
