<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/css/base.css" />
	</head>
	<body>
		<div id="root">
			<div id="backshade">
			<div id="panel">
					<table id="masthead">
					<tr>
						<td><h1 id="logo">mobi</h1></td>
						<td style="width: 6px;"/>
						<td><h5 id="sublogo">mobile social networking</h5></td>
					<tr>
					</table>
					<div class="divider" style="height: 3px; width: 100%;"/>
					<div class="divider" style="height: 400px; width: 800px; margin: auto;">
						<h1>please signup:</h1>
						<form method="post" action="/index.php/welcome/createUser">
						username:
						<input type="text" name="username"/>
						password:
						<input type="password" name="password"/>
						<input type="submit" value="Go!"/>
						</form>
						<h1>please login:</h1>
						<form method="post" action="/index.php/welcome/login">
						username:
						<input type="text" name="username"/>
						password:
						<input type="password" name="password"/>
						<input type="submit" value="Go!"/>
						</form>
					</div>
			</div>
			</div>
		</div>	
	</body>
</html>