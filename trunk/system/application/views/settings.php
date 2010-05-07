<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
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
					<tr>
					<td>
					<?php echo '<form method="post" action="/index.php/settings/changePassword/'.$user_id.'">'; ?>
						<p>change your password:</p>
						<br/>
						<p>enter old password:</p>
						<input type="password" name="old_password"/>
						<p>enter new password:</p>
						<input type="password" name="new_password"/>
						<input class="button" type="submit" value="Go!"/>
					</form>
					</div>
					<div id="whaleback"></div>
			</div>
			</div>
			<div id="bottomshade"></div>
	</body>
</html>