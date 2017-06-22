<?php
if(!isset($_GET['pageno'])){
	$redirect = "http://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]."&pageno=1";
	header("Location: ".$redirect);
}

if (isset($_GET['srch-term'])){
	$conn = sqlConnection();
	
	$searchTerm = $_GET['srch-term'];
	
	$sqlquery = "SELECT * FROM ARTICLE WHERE MATCH (TITLE,CONTENT) AGAINST ('".$searchTerm."' IN BOOLEAN MODE)";
	$result = $conn->query($sqlquery);	
	$rowCount = $result->num_rows; // Total number of rows
	$pagination = new Pagination(4, $rowCount);
	
	$sqlquery = "SELECT * FROM ARTICLE WHERE MATCH (TITLE,CONTENT) AGAINST ('".$searchTerm."' IN BOOLEAN MODE) ORDER BY ID DESC LIMIT ".$pagination->getOffset().", ".$pagination->getResultLimit();
	$result = $conn->query($sqlquery);	
?>
<div class="panel panel-default">
	<div class="panel-body">
<?php
	if ($result->num_rows > 0){
		

		while($row = $result->fetch_assoc()){
?>
			<div class = "row">
				<div class = "col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div> 
								<a href="?page=article&id=<?php echo $row["ID"]; ?>"><h1 style = "margin:0"><?php echo $row["TITLE"]; ?></h1></a>
							</div>
							<hr style = "margin-top:1%;margin-bottom:1%">
							<time class="comment-date" datetime="5-25-2017 01:05"><i class="fa fa-clock-o"></i> <?php echo $row["DATE_TIME"]; ?></time>
							<hr style = "margin-top:1%;margin-bottom:1%">
							<div style = "max-height:250px;overflow:hidden;">
								<img src="
								<?php
									if(isset($row["ARTICLE_IMAGE"])){
										echo $row["ARTICLE_IMAGE"];
									}else{
										echo "/Media/header-bg.jpg";
									}	
								?> 
								" class="img-responsive" alt="">
							</div>
						</div>
						<div class="panel-body" style = "padding-top:2%;padding-bottom:2%;">
							<div>
								<?php 
									$content = $row["CONTENT"]; 
									if (strlen($content) <=150) {
										 echo $content;
									} else {
										echo substr($content, 0, 150) . '...';
									}
								?>
							</div>
							<hr style = "margin-top:2%;margin-bottom:2%">
							<div class = "pull-right">
								<a href="?page=article&id=<?php echo $row["ID"]; ?>">More <span class = "glyphicon glyphicon-arrow-right"></span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php
		}
	}else{
		echo "No Results";
	}
?>
	</div>
	<?php
		if($pagination->getRowCount() > $pagination->getResultLimit()){
	?>
	<div class = "panel-footer text-center">
		<ul class="pagination" style = "float:none;display:inline-block;*display:inline;">
		<?php
			$pagination->display();
		?>
		</ul>
	</div>
	<?php
		}
	?>
</div>	
<?php
}
?>
