<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
	</head>
	<body>
			<div id="backshade">
			<div id="panel">
					<div id="masthead">
						<a id="title" href="http://www.google.com">mobi</a>
						<p id="subtitle">mobile social networking</p>
					</div>
					<div class="divider" style="height: 3px; width: 100%;"/>
					<table id="interactions">
					<tr>
						<td>
						<h2>Welcome to mobi!</h2>
						<br/>
						<p> Mobi is a new service that let's groups of people stay in contact on the go.  It's fast, free, and easy!</p>
						<br/>
						<a href="http://www.google.com">learn more</a>
						</td>
						<td class="divider" style="width:3px; height=100%;"></td>
						<td>
							<h1>please signup:</h1>
							<form method="post" action="/index.php/welcome/createUser">
							<p>username:</p>
							<input type="text" name="username"/>
							<p>password:</p>
							<input type="password" name="password"/>
							<input type="submit" value="Go!"/>
							</form>
							<h1>please login:</h1>
							<form method="post" action="/index.php/welcome/login">
							<p>username:</p>
							<input type="text" name="username"/>
							<p>password:</p>
							<input type="password" name="password"/>
							<input type="submit" value="Go!"/>
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
