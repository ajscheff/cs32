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
						<a id="settingsbutton" href="/index.php/settings/loadSettings">settings</a>
					</div>
					<div class="divider" style="height: 3px; width: 100%;"/>
					<table id="interactions">
					<tr>
					<td>
					<?php echo '<form method="post" action="/index.php/settings/changePassword/'.$username.'">'; ?>
						<p>change your password:</p>
						<br/>
						<p>enter old password:</p>
						<input type="password" name="old_password"/>
						<p>enter new password:</p>
						<input type="password" name="new_password"/>
						<input type="submit" value="change password"/>
					</form>
					</td>
					</tr>
					</table>
					<div id="whaleback"></div>
			</div>
			</div>
			<div id="bottomshade"></div>
	</body>
</html>