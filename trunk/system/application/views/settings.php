<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
    <head>        
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.min.js"></script>
		<script type="text/javascript"><!--
		
			function changePassword() {
				var old_password = $('#old_password').val();
				$.post('/index.php/settings/checkPassword', {password:old_password}, function(data) {
					if(data == '1') {
						document.forms["changepasswordform"].submit();
					} else {
						$('#passwordwrongpopup').show();
					}
				});
			}
					
			--></script>
	</head>
	<body>
			<div id="backshade">
			<div id="panel">
					<div id="masthead">
						<a id="title" href="/index.php/welcome/index">mobi</a>
						<p id="subtitle">mobile social networking</p>
						<p id="userstatus">Hello, <?php echo $username ?>!</p>
						<a id="circlesbutton" href="/index.php/welcome/index">circles</a>
						<a id="settingsbutton" href="/index.php/settings/loadSettings">settings</a>
						<a id="logoutbutton" href="/index.php/welcome/logout/">logout</a>
					</div>
					<div class="divider" style="height: 3px; width: 100%;"/>
					<div id="interactions">
						<form id="changepasswordform" method="post" action="/index.php/settings/changePassword/">
							<p>change your password:
								<p>enter old password:
									<input id="old_password" type="password" name="old_password"/>
									enter new password:
									<input id="new_password" type="password" name="password"/>
									<a href="javascript:changePassword()">Go!</a>
								</p>
							</p>							
						</form>
					</div>
					<div id="whaleback"></div>
			</div>
			</div>
			<div id="bottomshade"></div>
			<div class="popup" id="passwordwrongpopup">
				<a class="closebutton" href="javascript:hidePasswordWrongPopup()">Close</a>The password you entered was not correct!  Your password has not been changed.
			</div>
	</body>
</html>