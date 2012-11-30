<?php
	// Begin the PHP session. This line must be on every page of your network for sessions to work!
	session_start();
	// Check to see if the user is logged in. This should be on most of your pages.
	if(isset($_SESSION['user'])){
		header("Location: profile.php");
	}
	// Include the common PHP file
	include_once("common.php");
	// Call the common header function.
	common_header();
?>
<title>Welcome Page</title>
</head>
<body>
	<h1>Welcome</h1>
	<div>
		<form action="user_check.php" method="post">
			<fieldset>
				<label for="username">Username:</label>
					<input type="text" name="username" id="username" />
				<br />
				<label for="password">Password:</label>
					<input type="password" name="password" id="password" />
				<br />
				<input type="submit" value="Submit">
			</fieldset>
		</form>
	</div>
</body>
</html>