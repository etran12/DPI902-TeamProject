<?php
	if(isset($_GET['page'])){
		if(!isset($_GET['pageno'])){
			$redirect = "http://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]."&pageno=1";
			header("Location: ".$redirect);
			exit();
		}
	}else{
		if(!isset($_GET['pageno'])){
			$redirect = "http://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]."?pageno=1";
			header("Location: ".$redirect);
			exit();
		}
	}
	$conn = sqlConnection();
	$sqlquery = "SELECT * FROM ARTICLE";
	$result = $conn->query($sqlquery);	
	
	$rowCount = $result->num_rows; // Total number of rows
	$pagination = new Pagination(4, $rowCount);
	$sqlquery = "SELECT * FROM ARTICLE ORDER BY ID DESC LIMIT ".$pagination->getOffset().", ".$pagination->getResultLimit();
	$result = $conn->query($sqlquery);	
?>
<div class="panel panel-default">
	<div class="panel-body">
		<?php
			if ($result->num_rows > 0) {
				$rowWidth = 2;
				$counter = 0;
				while($row = $result->fetch_assoc()){
					if($counter % 2 == $rowWidth) echo '<div class = "row">';
					?>
						<div class = "col-xs-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<div> 
										<a href="?page=article&id=<?php echo $row["ID"]; ?>"><h1 style = "margin:0"><?php echo $row["TITLE"]; ?></h1></a>
									</div>
									<hr style = "margin-top:1%;margin-bottom:1%">
									<time class="comment-date" datetime="5-25-2017 01:05"><i class="fa fa-clock-o"></i> <?php echo $row["DATE_TIME"]; ?></time>
									<hr style = "margin-top:1%;margin-bottom:1%">
									<div style = "max-height:200px;overflow:hidden;">
										
										<img src="
										<?php
										
											if(isset($row["ARTICLE_IMAGE"])){
												echo $row["ARTICLE_IMAGE"];
											}else{
												echo "Media/header-bg.jpg";
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
					<?php
					if($counter % 2 == $rowWidth) echo '</div>';
					$counter++;
				}
			}else{
				echo "No Articles to Display";
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
		$conn->close();
	?>
</div>

