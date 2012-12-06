<?php
	session_start();
	$work = $_POST['work'];
	$edu = $_POST['edu'];
	$liveCity = $_POST['liveCity'];
	$liveState = $_POST['liveState'];
	$fromCity = $_POST['fromCity'];
	$fromState = $_POST['fromState'];
	if ($_POST['relationship'] == '---Select One---') {
			$relationship = '';
	}
	$relationship = $_POST['relationship'];
	$email = $_SESSION['user'];
	$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
	if (mysqli_connect_errno()) {
		die('Failed to connect to database. Try again later.');
	}
	
	$query = 'update users set work = ?, edu = ?, liveCity = ?, liveState = ?, fromCity = ?, fromState = ?, relationship = ? where email = ?';
	$stmt  = $db->prepare($query);
	if (!$stmt) {
		die ('Bad query');
	}
	$stmt->bind_param('ssssssss', $work, $edu, $liveCity, $liveState, $fromCity, $fromState, $relationship, $email);
	
	if ($stmt->execute()) {
		$stmt->close();
		$db->close();
		header('location: profile.php');
	}

	$stmt->close();
	$db->close();
	die('Failed to create new user. Try again later.');
?>
