<?php
	session_start();

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$pass  = $_POST['password'];

	// Connect to DB
	$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
	if (mysqli_connect_errno()) {
		die('Failed to connect to database. Try again later.');
	}

	// Check if user exists with provided email
	$query = 'select * from users where email = ?';
	$prep_query = $db->prepare($query);
	$prep_query->bind_param('s', $email);
	$prep_query->execute();
	$prep_query->store_result();

	if ($prep_query->num_rows > 0) {
		$prep_query->close();
		$db->close();
		header('location: index.php?error=userExists');
	}

	// Insert new information into DB
	$stmt = 'insert into users(fname, lname, email, pass) values(?, ?, ?, ?)';
	$prep_stmt = $db->prepare($stmt);
	$prep_stmt->bind_param('ssss', $fname, $lname, $email, $pass);

	if ($prep_stmt->execute()) {
		$prep_stmt->close();
		$db->close();
		$_SESSION['user'] = $email;
		header('location: profile.php');
	}

	// Failed to insert new user into DB
	$prep_stmt->close();
	$db->close();
	die('Failed to create new user. Try again later.');
?>
