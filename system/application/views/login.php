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
				
				function loginFailed(failed) {
					if(failed == "true") {
						$('#wrongpasswordmessage').show();
					}
				}
				
				function signUp() {
					$('#usernametaken').hide();
					$('#passwordsdontmatch').hide();
					var password1 = $('#password').val();
					var password2 = $('#password2').val();
					if(password1==password2) {
						$.post('index.php/welcome/signup/', $('#signupform').serialize(), function(data) {
							if(data == "0") {
								$('#successfulsignup').show();
							} else if (data == "-1") {
								$('#alreadyregistered').show();
							} else {
								$('#usernametaken').show();
							}
						});
					} else {
						$('#passwordsdontmatch').show();
					}
				}
				
				function hideAlreadyRegistered() {
					$('#alreadyregistered').hide();
				}
				
				function hidePasswordsDontMatch() {
					$('#passwordsdontmatch').hide();
				}
	
			--></script>
	</head>
	<?php echo '<body onload="javascript:loginFailed(\''.$loginfailed.'\')">';?>
			<div id="backshade">
			<div id="panel">
					<div id="masthead">
						<a class="mastheadbutton" id="title" href="/index.php/welcome/index">mobi</a>
						<p id="subtitle">mobile social networking</p>
					</div>
					<div class="divider" style="height: 3px; width: 100%;"/>
					<div id="interactions">
						<h2 id="welcome">Welcome to mobi!</h2>
						<p id="summary"> Mobi is a free new service that keeps people in touch on the go.  Learn more or sign up today!</p>
						<a id="learn" href="javascript:showLearnMore()">Learn More</a>
						<a id="sign" href="javascript:showSignUp()">Sign Up</a>
						<form id="login" method="post" action="/index.php/welcome/login/">
							<h4>Sign in:</h4>
							<p id ="wrongpasswordmessage" class="error">The username and password you entered did not match.</p>
							<p>
								<input id="loginusername" class="logininput" type="text" name="username" value="username" onfocus="this.value=''" size="25"/>
								<input id="loginpassword" class="logininput" type="text" name="password" value="password" onfocus="this.value='';this.type='password'" size="25"/>
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
			<div class="popup" id="learnmore">
				<a class="closebutton" href="javascript:hideLearnMore()">Close</a>
				<p> 
				Mobi is a new kind of social networking platform that is centered around the phone rather than the internet. Users create groups of their friends (called circles) on the website. The user can then communicate with their circles via unique email addresses that receive SMS messages, and automatically relay them out to other circle members. Mobi is ideal for social groups, school clubs, and larger organizations that want to communicate via SMS.
				</p>
			</div>
			<form class="popup" id="signupform" method="post" action="javascript:signUp()">
				<p><a class="closebutton" href="javascript:hideSignUp()">Close</a></p>
				<p id="usernametaken" class="error">This username is already in use.</p>
				<p>
					username:
					<input type="text" id="username" name="username"/>
				</p>
				<p id="passwordsdontmatch" class="error">These passwords did not match</p>
				<p>	
					password:
					<input type="password" id="password" name="password"/>
				</p>
				<p>
					type your pasword again:
					<input type="password" id="password2" name="password2"/>
				</p>
				<p>
				give a public name, this name will be viewable by the public:
					<input type="text" id="public_name" name="public_name"/>
				</p>
				<p class="error" id="alreadyregistered">Someone is already registered with that phone number!</p>
				<p>
					provide your phone number:<br/>
					<input type="text" id="phone_number" name="phone_number"/>
				</p>
				<p>
					<input class="button" type="submit" value="Sign Up!"/>
				</p>
			</form>
			<div class="popup" id="successfulsignup">
				<a class="closebutton" href="/index.php/home/loadHomeView/">Take me home!</a>
				<p>You have been successfully signed up for mobi.  Welcome.</p>
			</div>
	</body>
</html>
