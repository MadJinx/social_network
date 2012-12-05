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
				<label for="username">Username (email):</label>
					<input type="text" name="username" id="username" />
				<br />
				<label for="password">Password:</label>
					<input type="password" name="password" id="password" />
				<br />
				<input type="submit" value="Login" />
			</fieldset>
		</form>
	</div>
	<br/>
	<input type="button" id="nu" value="Create New User profile" onClick="toggleVis('nuser'); this.disabled = 'true';" />
	<div id="nuser">
		<form id="new_user" action="new_user.php" method="post" onsubmit="return validateNewUser()">
			<fieldset>
				<label id="fname_label" for="fname">First Name:</label>
					<input type="text" name="fname" id="fname" />
				<br />
				<label id="lname_label" for="lname">Last Name:</label>
					<input type="text" name="lname" id="lname" />
				<br />
				<label id="email_label" for="email">Email Address:</label>
					<input type="text" name="email" id="email" />
				<br />
				<label id="password_label" for="password">Password:</label>
					<input type="password" name="password" id="password" />
				<br />
				<label id="repass_label" for="repass">Re-Enter Password:</label>
					<input type="password" name="repass" id="repass" />
				<br />
				<input type="submit" value="Register">
			</fieldset>
		</form>
	</div>
</body>
</html>
