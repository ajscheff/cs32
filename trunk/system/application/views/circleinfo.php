			<div id="circleheader">
				<?php echo '<h4>'.$name.'</h4>' ?>
			</div>
			<h4>members:</h4>	
			<?php foreach($admins as $admin) {
				echo '<p class="member">'.$admin.'</p>';
				}
			?>
			<h4>recent message:<h4>
			<?php foreach($messages as $message) {
				echo '<p class="message">'.$message.'</p>';
				}
			?>