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
	<div>
		<h3>Log In</h3>
		<form action="user_check.php" method="post">
			<fieldset>
				<table>
					<tr>
						<td>Username (email):</td>
						<td><input type="text" name="username" id="username" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" id="password" /></td>
					</tr>
				</table>
				<input type="submit" value="Login" />
			</fieldset>
		</form>
	</div>
	<br/>
	<input type="button" id="nu" value="Create New User profile" onClick="toggleVis('nuser'); this.disabled = 'true';" />
	<div id="nuser">
		<form id="new_user" action="new_user.php" method="post" onsubmit="return validateNewUser()">
			<fieldset>
				<table>
					<tr>
						<td>First Name:</td>
						<td><input type="text" name="fname" id="fname" /></td>
					</tr>
					<tr>
						<td>Last Name:</td>
						<td><input type="text" name="lname" id="lname" /></td>
					</tr>
					<tr>
						<td>Email Address:</td>
						<td><input type="text" name="email" id="email" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" id="password" /></td>
					</tr>
					<tr>
						<td>Re-Enter Password:</td>
						<td><input type="password" name="repass" id="repass" /></td>
					</tr>
				</table>
				<input type="submit" value="Register"/>
			</fieldset>
		</form>
	</div>

	<?php if (isset($_GET['error'])) { 
		if ($_GET['error'] == 'userExists') { ?>
			<script>
				alert("Error: User Exists. Please use different email.");
			</script>
	<?php } else { ?>
			<script>
				alert("Error: Username/Password pair invalid.");
			</script>
		<?php }
	} ?>
</body>
</html>
