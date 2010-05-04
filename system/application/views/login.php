<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
    <head>        
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
		<link rel="stylesheet" type="text/css" href="/css/login.css" />
		<title>mobi</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.min.js"></script>
		<script type="text/javascript"><!--
				
				function showLearnMore() {
					$('#signupform').hide();
					$('#learnmore').show();
				}
				
				function hideLearnMore() {
					$('#learnmore').hide();
				}
				
				function showSignUp() {
					$('#learnmore').hide();
					$('#signupform').show();
				}
				
				function hideSignUp() {
					$('#signupform').hide();
				}
	
			--></script>
	</head>
	<body>
			<div id="backshade">
			<div id="panel">
					<div id="masthead">
						<a id="title" href="/index.php/welcome/index">mobi</a>
						<p id="subtitle">mobile social networking</p>
					</div>
					<div class="divider" style="height: 3px; width: 100%;"/>
					<div id="interactions">
						<h2 id="welcome">Welcome to mobi!</h2>
						<p id="summary"> Mobi is a free new service that keeps people in touch on the go.  Learn more or sign up today!</p>
						<a id="learn" href="javascript:showLearnMore()">Learn More</a>
						<a id="sign" href="javascript:showSignUp()">Sign Up</a>
						<form id="login" method="post" action="/index.php/welcome/login">
							<p>
							<h4>Sign in:</h4>
							<br/>
							<input id="logininput" type="text" name="username" value="username" size="25"/>
							<br/>
							<input id="logininput" type="password" name="password" value="" size="25"/>
							<br/>
							<input id="loginbutton" class="button" type="submit" value="Login" style="float:right"/>
							</p>
						</form>
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
			<div id="learnmore">
				<a style="float:right;" href="javascript:hideLearnMore()">Close</a>
				<p> Mobi is a free service that let's people text multiple other people at once with just one text message!</p>
			</div>
			<form id="signupform" method="post" action="">
				<input type="text" name="username"/>
				<input type="password" name="password1"/>
				<input type="password" name="password2"
			</form>
	</body>
</html>
