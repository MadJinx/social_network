<?php
	session_start();

	// If they didn't enter a username or password, they should be redirected back to the index page
	if($_POST['username'] == "" || $_POST['password'] == ""){
		header("Location: index.php?error=userFail");
	}

	// Connect to DB
	$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
	if (mysqli_connect_errno()) {
		die('Failed to connect to database. Try again later.');
	}

	// Check database for member information
	$query = 'select pass from users where email = ?';
	$prep_query = $db->prepare($query);
	$prep_query->bind_param('s', $_POST['username']);
	$prep_query->execute();
	$prep_query->bind_result($password);

	// If the user entered the correct user/password pair, send them to their profile
	if ($prep_query->fetch() && $password == $_POST['password']) {
		$db->close();
		$prep_query->close();
		$_SESSION['user'] = $_POST['username'];
		header("Location: profile.php");
	}

	// The user entered an incorrect username/password pair
	$db->close();
	$prep_query->close();
	header("Location: index.php?error=userFail");
?>
