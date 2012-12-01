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
		<h3>Log In</h3>
		<form action="user_check.php" method="post">
			<fieldset>
				<label for="username">Username(email):</label>
					<input type="text" name="username" id="username" />
				<br />
				<label for="password">Password:</label>
					<input type="password" name="password" id="password" />
				<br />
				<input type="submit" value="Submit">
			</fieldset>
		</form>
	</div>
	<p>OR</p>
	<div>
		<h3>Create New User Profile</h3>
		<form action="new_user.php" method="post">
			<fieldset>
				<label for="fname">First Name:</label>
					<input type="text" name="fname" id="fname" />
				<br />
				<label for="lname">Last Name:</label>
					<input type="text" name="lname" id="lname" />
				<br />
				<label for="email">Email Address:</label>
					<input type="text" name="email" id="email" />
				<br />
				<label for="password">Password:</label>
					<input type="password" name="password" id="password" />
				<br />
				<label for="repass">Re-Enter Password:</label>
					<input type="password" name="repass" id="repass" />
				<br />
				<input type="submit" value="Submit">
			</fieldset>
		</form>
	</div>
</body>
</html>