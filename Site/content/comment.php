<div class="panel panel-default arrow left" style = "margin-left:<?php echo $margin ?>%;">
	<div class="panel-body" style = "padding-bottom:0;">
		<div class = "row">
			<?php
				if(isset($counter)){
					if($counter % 2 == 0){
			?>
			<div class = "col-xs-2">
				<figure class="thumbnail" style = "border:none;">
					<img class="img-circle" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
					<figcaption class="text-center"><?php echo $comment["USERNAME"]; ?></figcaption>
				</figure>
			</div>
			<?php
					}
				}else{
			?>
				<div class = "col-xs-2">
					<figure class="thumbnail" style = "border:none;">
						<img class="img-circle" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
						<figcaption class="text-center"><?php echo $comment["USERNAME"]; ?></figcaption>
					</figure>
				</div>
			<?php
				}
			?>
			<div class = "col-xs-10">
				<header class="text-left">
					<div class="comment-user"><i class="fa fa-user"></i> <?php echo $comment["USERNAME"]; ?></div>
					<time class="comment-date" datetime="5-25-2017 01:05"><i class="fa fa-clock-o"></i><?php echo $comment["DATE_TIME"]; ?></time>
					<?php
						if(isset($to)){
							echo "<p>@".$to."</p>";
						}
					?>
				
				</header>
				<hr style = "margin-top:2%;margin-bottom:2%;">
				<div class="comment-post">
				<?php
					echo $comment["CONTENT"];
				?>
				</div>
				<hr style = "margin-top:2%;margin-bottom:2%;">
				<p class="text-right"><a class="btn btn-default btn-sm" data-toggle="collapse" data-target="#reply<?php echo $comment["ID"]; ?>"><i class="fa fa-reply"></i> reply</a></p>
			</div>
			<?php
				if(isset($counter)){
					if($counter % 2 == 1){
			?>
			<div class = "col-xs-2">
				<figure class="thumbnail" style = "border:none;">
					<img class="img-circle" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
					<figcaption class="text-center"><?php echo $comment["USERNAME"]; ?></figcaption>
				</figure>
			</div>
			<?php
					}
				}
			?>
		</div>
	</div>
	<div id="reply<?php echo $comment["ID"] ?>" class="collapse">
		<div class="panel panel-default">
			<div class="panel-body">
				<h2>Add Reply</h2>
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
					<button name="commentReplyPost" type="submit" id="form-submitReply" class="btn btn-success btn-lg pull-right " value = "<?php echo $comment["ID"]; ?>">Submit</button>
				</form>
				<div id="msgSubmit" class="h3 text-center hidden">Message Submitted!</div>
			</div>
		</div>
	</div>
</div>