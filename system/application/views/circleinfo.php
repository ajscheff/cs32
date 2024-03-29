			<div id="circleheader">
				<?php
					if($is_admin == 1) {
						echo '<a class="managebutton" href="javascript:showDeleteCircleOk()">Disband Circle</a>';
						echo '<a class="managebutton" href="javascript:showAddUserForm()">Add Users</a>';
					}
					echo '<a class="managebutton" href="javascript:showLeaveCircleOk()">Leave Circle</a>';
					
					echo '<h3>'.$name.'</h3>';
					echo '<p>'.$email.'@ombtp.com</p>';
					echo '<p>'.$description.'</p>';	
				?>
			</div>
			<div>
				<div id="adminslist">
					<h4 style="padding-bottom: 3px;">admins:</h4>	
					<?php foreach($admins as $admin) {
						echo '<p class="member">'.$admin['public_name'];
						if($is_admin == 1) {
							echo '<a class="micromanagebutton" href="javascript:setUserAdmin('.$admin['user_id'].','.$circle_id.', 0)">v</a>';
							echo '<a class="micromanagebutton" href="javascript:showUserSettings('.$admin['user_id'].')">o</a>';
						}
						echo '</p>';
					}
					?>
					<br/>
					<h4 style="padding-bottom: 3px;">members:</h4>
					<?php foreach($members as $member) {
						echo '<p class="member">'.$member['public_name'];
						if($is_admin == 1) {
							echo '<a class="micromanagebutton" href="javascript:deleteUserFromCircle('.$member['user_id'].','.$circle_id.')">x</a>';
							echo '<a class="micromanagebutton" href="javascript:setUserAdmin('.$member['user_id'].','.$circle_id.', 1)">^</a>';
							echo '<a class="micromanagebutton" href="javascript:showUserSettings('.$member['user_id'].')">o</a>';
						}
						echo '</p>';
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
