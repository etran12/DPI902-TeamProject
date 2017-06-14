<?php
	$headerImage = "/Site/Media/header-bg.jpg";
	$headerTitle = "Home";
	
	$conn = sqlConnection();

	if(isset($_GET['page'])){
		$page = $_GET['page'];
		if($page == "article"){
			$id = $_GET['id'];
			$sqlquery = "SELECT TITLE, ARTICLE_IMAGE FROM ARTICLE WHERE ID = ".$id;
			$result = $conn->query($sqlquery);
			$row = $result->fetch_assoc();
			
			$headerTitle = $row["TITLE"];
			$headerImage = $row["ARTICLE_IMAGE"];
		}
	}
?>
<script>
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
				 <a class="navbar-brand" style = "padding:0;" href=""><img src="" class = "img-responsive"></a>
			</div>
			<div id="navbar">
				<ul class="nav navbar-nav">
					<li><a href="?page=home">Home</a></li>
				</ul>
				
				<ul class="nav pull-right">
					<li class="dropdown" style = "margin-top:3px;">
						<a class="btn btn-default" href="" data-toggle="dropdown">Sign In <strong class="caret"></strong></a>
						<div class="dropdown-menu" style="padding: 5px; min-width:100%;">
							<?php
								include("content/login.php");
							?>
						</div>
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
			echo "background-image: url('/Site/Media/header-bg.jpg');";
		}
	?>
	">
		<div class = "text-center" style = "padding-top:8%;">
			<div style = "color:white;font-family: 'Droid Serif', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-style: italic;font-size: 35px;line-height: 22px;">Hacking 101</div>
			<h3 style = "color:white;font-family: 'Montserrat', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;font-weight: 700;font-size: 50px;line-height: 50px;"><?php echo $headerTitle; ?></h3>
		</div>
	</div>
</header>
