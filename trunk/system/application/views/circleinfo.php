			<div id="circleheader">
				<?php
					if($is_admin != '0')
						echo '<a id="deletebutton" href="javascript:deleteCircle('.$circle_id.')">Delete Circle</a>';	
					echo '<h3>'.$name.'</h3>'.$email;
					echo '<p>'.$description.'</p>';	

				?>
			</div>
			<div>
				<div id="adminslist">
					<h4 style="padding-bottom: 3px;">admins:</h4>	
					<?php foreach($admins as $admin) {
						echo '<p class="admin">'.$admin.'</p>';
						}
					?>
					<br/>
					<h4 style="padding-bottom: 3px;">members:</h4>
					<?php foreach($members as $member) {
						echo '<p class="admin">'.$member.'</p>';
						}
					?>
				</div>
				<div id="messagelist">
					<h4 style="padding-bottom: 3px;">recent messages:<h4>
					<?php foreach($messages as $message) {
						echo '<p class="message">'.$message.'</p>';
						}
					?>
				</div>
			</div>
