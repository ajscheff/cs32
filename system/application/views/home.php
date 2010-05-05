<html>
	<head>
		<?php echo '<title>mobi: '.$username.'</title>'; ?>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/home.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.min.js"></script>
		<script type="text/javascript"><!--
		
				function defaultCircle() {
					if($first_circle > 0){
						loadCircle($first_circle);
					}
				}	
					
				function loadCircle(circle_id) {
				
					if (circle_id != 0) {
						$.post('/index.php/home/loadCircle/', { circle_id : circle_id }, function(data) {
							$('#circleinfo').html(data);
						});
					}
				}
				
				function showCircleForm() {
					$('#newcircleform').show();
				}
				
				function hideCircleForm() {
					$('#newcircleform').hide();
				}
					
			--></script>
	</head>
	<body onload="loadCircle(<?php echo $first_circle ?>)">
			<div id="backshade">
			<div id="panel" onload="javascript:defaultCircle()">
					<div id="masthead">
						<a id="title" href="/index.php/welcome/index">mobi</a>
						<p id="subtitle">mobile social networking</p>
						<p id="userstatus">Hello, <?php echo $username ?>!</p>
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
								<a id="newcirclebutton" href="javascript:showCircleForm()">New Circle</a>
						</div>
						<div id="circleinfo">
						</div>
					</div>
					<div id="whaleback"></div>
			</div>
			</div>
			<div id="bottomshade"></div>
			<form id="newcircleform" method="post" action="/index.php/home/createCircle/">
				<a style="float:right" href="javascript:hideCircleForm()">Close</a>
				<p>
					Circle name:
					<input type="text" name="circle_name"/>
				</p>
				<p>
					Circle email:
					<input type="text" name="email"/>@ombtp.com
				</p>
				<p>
					Privacy:
					<input type="radio" name="privacy" value="public">Public</input>
					<input type="radio" name="privacy" value="private">Private</input>
					<input type="radio" name="privacy" value="secret">Secret</input>
				</p>
				<p>
					<textarea rows="10" cols="30" name="description">Enter a description for your circle.</textarea>
					<input class="button" type="submit" value="Done!"/>
				</p>
			</form>
	</body>
</html>
