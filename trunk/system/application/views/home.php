<html>
	<head>
		<?php echo '<title>mobi: '.$username.'</title>'; ?>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/home.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.min.js"></script>
		<script type="text/javascript"><!--

				function submitNewCircle(){
					var email = $('#email').val();
					$.post('/index.php/home/emailExists/', { email : email }, function(data) {
							if(data == '0'){
								document.forms["newcircleform"].submit();
							} else {
								$('#emailtakenpopup').show();
							}
						});
				}
					
				function loadCircle(circle_id) {
					if (circle_id != 0) {
						$.post('/index.php/home/loadCircle/', { circle_id : circle_id }, function(data) {
							$('#circleinfo').html(data);
						});
					}
				}
				
				function hideEmailTakenPopup(){
					$('#emailtakenpopup').hide();
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
			<div id="panel">
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
			<form id="newcircleform" method="post" action="/index.php/home/createCircle">
				<a style="float:right" href="javascript:hideCircleForm()">Close</a>
				<p>
					Circle name:
					<input id="circle_name" type="text" name="circle_name"/>
				</p>
				<p>
					Circle email:
					<input id="email" type="text" name="email"/>@ombtp.com
				</p>
				<p>
					Privacy:
					<input type="radio" name="privacy" value="public" checked="checked">Public</input>
					<input type="radio" name="privacy" value="private">Private</input>
					<input type="radio" name="privacy" value="secret">Secret</input>
				</p>
				<p>
					<textarea id="description" rows="10" cols="30" name="description">Enter a description for your circle.</textarea>
					<a href="javascript:submitNewCircle()">Done!</a>
				</p>
			</form>
			<div id="emailtakenpopup">
				<a style="float:right" href="javascript:hideEmailTakenPopup()">Close</a>The email you entered is taken by another circle, please choose a different email address.
			</div>
	</body>
</html>
