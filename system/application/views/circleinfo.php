			<div id="circleheader">
				<?php echo '<h4>'.$name.'</h4>';
						echo '<p>'.$description.'</p>';
						
						if(is_admin>0){
							echo '<a id="deletebutton" href="javascript:deleteCircle('.$circle_id.')">Delete Circle</a>';
						}
						
						?>
			</div>
			<div>
				<div id="adminslist">
					<h5>admins:</h5>	
					<?php foreach($admins as $admin) {
						echo '<p class="admin">'.$admin.'</p>';
						}
					?>
				</div>
				<div id="messagelist">
					<h5>recent messages:<h5>
					<?php foreach($messages as $message) {
						echo '<p class="message">asf'.$message.'</p>';
						}
					?>
				</div>
			</div>