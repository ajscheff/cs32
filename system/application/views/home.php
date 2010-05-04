<html>
	<head>
		<?php echo '<title>mobi: '.$username.'</title>'; ?>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/home.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.min.js"></script>
		<script type="text/javascript"><!--
				
				function loadCircle(circle_id) {
					$.post('/index.php/home/loadCircle/', { circle_id : circle_id }, function(data) {
						$('#circleinfo').html(data);
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
						<a id="settingsbutton" href="/index.php/settings/loadSettings/">settings</a>
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
					</div>
					<div id="whaleback"></div>
			</div>
			</div>
			<div id="bottomshade"></div>
	</body>
</html>
