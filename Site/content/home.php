
<?php
	$conn = sqlConnection();
	$sqlquery = "SELECT * FROM ARTICLE";
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
									<div>
										<img src="https://courses.telegraph.co.uk/images/26/default/coding625x351.jpg" class="img-responsive" alt="">
									</div>
								</div>
								<div class="panel-body" style = "padding-top:2%;padding-bottom:2%;">
									<div>
										<?php echo $row["CONTENT"]; ?>
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
			} 
		?>
	</div>
</div>
	
