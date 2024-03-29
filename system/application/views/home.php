<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
    <head>        
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<?php echo '<title>mobi: '.$username.'</title>'; ?>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/home.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.min.js"></script>
		<script type="text/javascript"><!--
		
				var curr_circle;
				var curr_user_selected;

				function submitNewCircle(){
					$('#emailtaken').hide();
					var email = $('#email').val();
					$.post('/index.php/home/emailExists/', { email : email }, function(data) {
							if(data == "0"){
								document.forms["newcircleform"].submit();
							} else {
								$('#emailtaken').show();
							}
						});
				}
					
				function loadCircle(circle_id) {
					curr_circle = circle_id;
					if (circle_id != 0) {
						$.post('/index.php/home/loadCircle/', { circle_id : circle_id }, function(data) {
							$('#circleinfo').html(data);
						});
					}
				}
				
				function addUser() {
					var number = $('#phone_number').val();
					var name = $('#name').val();
					var admin = 0;
					if ($('#admin').is(':checked')) admin = 1;
					var priv = $('input[name=priv]:checked').val();
					
					$.post('/index.php/home/addUser/', { circle_id: curr_circle, phone_number: number, public_name: name, admin: admin, privileges: priv }, function(data) {
						if (data == 0) {
							showAlreadyAdded();
						}
						else {
							$('#phone_number').val("");
							$('#name').val("");
							loadCircle(curr_circle);
						}
					});
				}
				
				function setUserAdmin(user_id, circle_id, admin) {
					$.post('/index.php/home/setUserAdmin/', {user_id: user_id, circle_id: circle_id, admin: admin}, function(data) {});
					loadCircle(curr_circle);
				}
				
				function leaveCircle() {
					$.post('/index.php/home/leaveCircle/', { circle_id: curr_circle }, function(data) {});
					document.location = '0';
				}
				
				function showUserSettings(user_id) {
					curr_user_selected = user_id;
					$('#usersettingspanel').show();
				}
				
				function hideUserSettings() {
					$('#usersettingspanel').hide();
				}
				
				function setUserSettings() {
					var priv = $('input[name=privSet]:checked').val();
					if (priv != undefined) {
						$.post('/index.php/home/setUserSettings/', { circle_id: curr_circle, user_id: curr_user_selected, privileges: priv }, function(data) {});
					}
					hideUserSettings();
				}
				
				function showAlreadyAdded() {
					$('#alreadyadded').show();				
				}
				
				function hideAlreadyAdded() {
					$('#alreadyadded').hide();
				}
				
				function showLeaveCircleOk() {
					$('#leavecircleok').show();				
				}
				
				function hideLeaveCircleOk() {
					$('#leavecircleok').hide();
				}
				
				function deleteCircle() {
					$.post('/index.php/home/deleteCircle/', { circle_id: curr_circle }, function(data) {});
					document.location = '0';
				}
				
				function showDeleteCircleOk() {
					$('#deletecircleok').show();
				}
				
				function hideDeleteCircleOk() {
					$('#deletecircleok').hide();
				}
				
				function showAddUserForm() {
					$('#adduserform').show();
				}
				
				function hideAddUserForm() {
					$('#adduserform').hide();
				}

				function showCircleForm() {
					$('#emailtaken').hide();
					$('#newcircleform').show();
				}
				
				function hideCircleForm() {
					$('#emailtaken').hide();
					$('#newcircleform').hide();
				}
				
				function deleteUserFromCircle(user_id, circle_id) {
					$.post('/index.php/home/removeUserFromCircle/',{user_id:user_id,circle_id:circle_id}, function(data) {
						$('#circleinfo').html(data);
					});
				}
					
			--></script>
	</head>
	<body onload="loadCircle(<?php echo $first_circle ?>)">
			<div id="backshade">
			<div id="panel">
					<div id="masthead">
						<a id="title" href="/index.php/welcome/index">mobi</a>
						<p id="subtitle">mobile social networking</p>
						<p id="userstatus">Hello, <?php echo $username ?>!</p>
						<a id="circlesbutton" href="/index.php/welcome/index">circles</a>
						<a id="settingsbutton" href="/index.php/settings/loadSettings/">settings</a>
						<a id="logoutbutton" href="/index.php/welcome/logout/">logout</a>
					</div>
					<div class="divider" style="height: 3px; width: 100%;"/>
					<div id="interactions">
						<div id="circlelist">
							<h4 style="margin-bottom: 10px;">Your circles:</h4>
								<?php foreach($circles as $circle) {
									echo '<a href="javascript:loadCircle('.$circle->id.')">'.$circle->name.'</a><br/><br/>';
									}
								?>
						</div>
						<div id="circleinfo">
						</div>
						<a id="newcirclebutton" href="javascript:showCircleForm()">New Circle</a>

					</div>
					<div id="misc">
						(c) 2010 mobi
						<a href="http://www.google.com">About Us</a>
						<a href="http://www.google.com">Jobs</a>
						<a href="http://www.google.com">Contact</a>
						<a href="http://www.google.com">Privacy</a>
						<a href="http://www.google.com">Terms</a>
					</div>
					<div id="whaleback"></div>
			</div>
			</div>
			<div id="bottomshade"></div>
			<form class="popup" id="newcircleform" method="post" action="/index.php/home/createCircle">
				<a class="closebutton" href="javascript:hideCircleForm()">Close</a>
				<p>
					Circle name:
					<input id="circle_name" type="text" name="circle_name"/>
				</p>
				<p id="emailtaken" class="error">The email you entered is taken by another circle, please choose a different email address.</p>
				<p>
					Circle email:
					<input id="email" type="text" name="email"/>@ombtp.com
				</p>
				<!--<p>
					Privacy:
					<input type="radio" name="privacy" value="public" checked="checked">Public</input>
					<input type="radio" name="privacy" value="private">Private</input>
					<input type="radio" name="privacy" value="secret">Secret</input>
				</p>-->
				<p>
					<textarea id="description" rows="10" cols="30" name="description">Enter a description for your circle.</textarea>
					<a href="javascript:submitNewCircle()">Done!</a>
				</p>
			</form>
			
			<form class="popup" id="usersettingspanel">
				<a class="closebutton" href="javascript:hideUserSettings()">Close</a>
					User can reply to: <br />
					All<input id="reply_all" type="radio" name="privSet" value="reply_all" /><br />
					Admins Only<input id="reply_admins" type="radio" name="privSet" value="reply_admins" /><br />
					None<input id="no_reply" type="radio" name="privSet" value="no_reply" /><br />
					<a href="javascript:setUserSettings()">Done!</a>
				</p>
			</form>
			
			<form class="popup" id="adduserform" method="post" action="javascript:addUser()">
				<a class="closebutton" href="javascript:hideAddUserForm()">Close</a>
				<p>
					Phone number:
					<input id="phone_number" type="text" name="phone_number"/>
				</p>
				<p>
					Name:
					<input id="name" type="text" name="name"/>
				</p>
				<p>
					Admin <input id="admin" type="checkbox" value="admin" />
				</p>
				<p>
					Reply to: <br />
					All<input id="reply_all" type="radio" name="priv" value="reply_all" checked="checked"/>
					Admins Only<input id="reply_admins" type="radio" name="priv" value="reply_admins" />
					None<input id="no_reply" type="radio" name="priv" value="no_reply" />	
				</p>
				<p>
					<input class="button" type="submit" value="Add User"/>
				</p>
			</form>
			
			<div class="popup" id="alreadyadded">
				<a class="closebutton" href="javascript:hideAlreadyAdded()">Close</a>A user with that phone number is already in this circle or the phone number is invalid!
			</div>
			
			<form class="popup" id="deletecircleok">
				<p style="align:center">
					<h3>Disband circle?</h3> <br>
					<p>This action cannot be undone</p>
					<a style="margin:5px" href="javascript:deleteCircle()">Yes</a>
					<a style="margin:5px" href="javascript:hideDeleteCircleOk()">No</a>
				</p>
			</form>
			
			<form class="popup" id="leavecircleok">
				<p style="align:center">
					<h3>Leave circle?</h3> <br>
					<p>This action cannot be undone</p>
					<a style="margin:5px" href="javascript:leaveCircle()">Yes</a>
					<a style="margin:5px" href="javascript:hideLeaveCircleOk()">No</a>
				</p>
			</form>
			
	</body>
</html>
