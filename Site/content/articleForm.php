<?php
	if (isset($_SESSION['user_id']) &&  $_SESSION['user_id'] != ""){ 
		$action = "add";
		if (isset($_GET['id'])){
			$id = $_GET['id'];
			if($id != ""){
				$action = "edit";
			}
		}
		
		if($action == "edit"){
			$conn = sqlConnection();
			$sqlquery = "SELECT * FROM ARTICLE WHERE ID = ".$id;
			$result = $conn->query($sqlquery);
			$row = $result->fetch_assoc();
		}
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 style = "margin-top:1%;">
			<?php
				if($action == "add"){
					echo "Add Article";
				}else{
					echo "Edit Article";
				}
			?>
		</h3>
	</div>
	<div class="panel-body">
		<form action="<?php if($action == 'add'){ echo '?page=/operations/insertArticle'; }else{ echo '?page=/operations/updateArticle'; }?>" method="POST" enctype="multipart/form-data">
			<div class = "row">
				<div class = "col-xs-12 col-xs-offset-2">
					<div class="row">
						<div class="form-group col-xs-8">
								<label for="title" class="h4">Title</label>
								<input type="text" class="form-control" id="title" name = "title" value = "<?php if($action == 'edit') echo $row["TITLE"]; ?>" placeholder="Enter Title" required>
						</div>
					</div>
					<div class = "row">
						<div class="form-group col-xs-8">
							<label for="content" class="h4 ">Message</label>
							<textarea id="content" name = "content" class="form-control" rows="20" value = "" placeholder="Enter Article Content"  required><?php if($action == 'edit') echo $row["CONTENT"]; ?></textarea>
						</div>
					</div>
					
					<div class = "row">
						<div class="form-group col-xs-8">
							<label for="upload" class="h4">Article Image</label>
							<input type="file" id = "upload" name="fileToUpload" id="fileToUpload">
						</div>
					</div>
				
					<?php 
						if($action == "edit"){
					?>
							<input type = "hidden" value = "<?php echo $_GET['id']; ?>" name = "id">
					<?php
						}
					?>
					<input type="submit" value="Add" name="submit" style = "margin-top:10px;margin-bottom:10px;">
					<?php
						if(isset($_GET['change'])){
							if($_GET['change'] == 1){
								if($action == "add"){
									echo "Article successfully inserted";
								}else{
									echo "Article successfully updated";
								}
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