<?php
	session_start();

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$pass  = $_POST['password'];

	$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
	if (mysqli_connect_errno()) {
		die('Failed to connect to database. Try again later.');
	}

	$query = 'insert into users(fname, lname, email, pass) values(?, ?, ?, ?)';
	$stmt  = $db->prepare($query);
	$stmt->bind_param('ssss', $fname, $lname, $email, $pass);

	if ($stmt->execute()) {
		$stmt->close();
		$db->close();
		$_SESSION['user'] = $email;
		header('location: profile.php');
	}

	$stmt->close();
	$db->close();
	die('Failed to create new user. Try again later.');
?>
