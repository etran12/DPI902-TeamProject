<?php
	if(!isset($_GET['pageno'])){
		$redirect = "http://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]."&pageno=1";
		header("Location: ".$redirect);
	}
	if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 
		$conn = sqlConnection();
		$sqlquery = "SELECT * FROM ARTICLE";
		$result = $conn->query($sqlquery);
		
		$rowCount = $result->num_rows;
		$pagination = new Pagination(4, $rowCount);
		
		$sqlquery = "SELECT * FROM ARTICLE ORDER BY ID DESC LIMIT ".$pagination->getOffset().", ".$pagination->getResultLimit();
		$result = $conn->query($sqlquery);	
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3> Articles </h3>
	</div>
	<div class="panel-body">
		<ul class="list-group">
			<?php
				if ($result->num_rows > 0){
					while($row = $result->fetch_assoc()){
			?>
					<li class="list-group-item clearfix">
						<a href = "?page=article&id=<?php echo $row["ID"]; ?>"><?php echo $row['TITLE']; ?></a>
						<div class = "pull-right">
							<a href = "?page=articleForm&id=<?php echo $row["ID"]; ?>">Edit</a>
							
							<form id = "hidden_form<?php echo $row['ID']; ?>" action="?page=/operations/deleteArticle" method="POST" style="display: none">
								<input class = "listInput" type="hidden" name="id" value="<?php echo $row['ID']; ?>">
							</form>
							<a href = "" onclick="$('#hidden_form<?php echo $row['ID']; ?>').submit(); return false;">Delete</a>
						</div>
					</li>
			<?php
					}
				}else{
					echo "No Articles to Display";
				}
			?>
		</ul>
	</div>
	<?php
		if(isset($pagination)){
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
		}
	?>
</div>
<?php
	}
?>

