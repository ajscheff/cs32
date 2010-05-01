<html>
	<head>
		<?php echo '<title>mobi: '.$username.'</title>'; ?>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/home.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.min.js"></script>
		<script type="text/javascript"><!--
				
				function loadCircle($username, $circlename) {
					alert(username);
					}
					
					// get the values from the form
//					var value = $('#value').val();
//					var checked = $('#append').attr('checked');
//					
					
					// now, make an ajax call to the server to
					// get the return value for this input.
					// the return value will be in the variable
					// 'data'
//						$.post('/welcome/ajax_form_post/', { value : value }, function(data) {
					
						// set it in the displayHere paragraph
//						$('#displayHere').html(data);
						
						// finally, show the paragraph with id 'displayHere'
//						$('#displayHere').show();
						
						// append it to the div 'appendToMe' if the checkbox is checked
						
//						if (checked)
//							$('#appendToMe').append(data);
					
//					});
					
					
			--></script>
	</head>
	<body>
			<div id="backshade">
			<div id="panel">
					<div id="masthead">
						<a id="title" href="/index.php/welcome/index">mobi</a>
						<p id="subtitle">mobile social networking</p>
						<p id="userstatus">Hello, <?php echo $username ?>!</p>
						<?php echo '<a id="settingsbutton" href="/index.php/settings/loadSettings/'.$username.'">settings</a>';?>
					</div>
					<div class="divider" style="height: 3px; width: 100%;"/>
					<div id="interactions">
						<div id="circlelist">
							<h4 style="margin-bottom: 10px;">Your circles:</h4>
								<?php foreach($circles as $circle) {
									echo '<a href="javascript:loadCircle('.$username.','.$circle['name'].')">'.$circle['name'].'</a><br/><br/>';
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