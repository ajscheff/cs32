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
						<?php echo'<a id="settingsbutton" href="/index.php/settings/loadSettings/'.$username.'">settings</a>';?>
					</div>
					<div class="divider" style="height: 3px; width: 100%;"/>
					<table id="interactions">
					<tr>
						<td id="circlelist">
						<h4 style="margin-bottom: 10px;">Your circles:</h4>
							<?php foreach($circles as $circle) {
								echo '<p class="circle">'.$circle['name'].'</p>';
								}
								?>
						</td>
						<td class="divider" style="width:3px; height=100%;"></td>
						<td>
							<h4>members:</h4>	
							<?php foreach($circles[0]['members'] as $member) {
								echo '<p class="member">'.$member.'</p>';
								}
							?>
							<h4>recent message:<h4>
							<?php foreach($circles[0]['messages'] as $message) {
								echo '<p class="message">'.$message.'</p>';
								}
							?>
							</td>
					</tr>
					</table>
					<div id="whaleback"></div>
			</div>
			</div>
			<div id="bottomshade"></div>
	</body>
</html>