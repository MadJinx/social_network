<?php
	session_start();
	$work = $_POST['work'];
	$edu = $_POST['edu'];
	$liveCity = $_POST['liveCity'];
	$liveState = $_POST['liveState'];
	$fromCity = $_POST['fromCity'];
	$fromState = $_POST['fromState'];
	if ($relationship == '---Select One---') {
			$relationship = '';
	}
	$relationship = $_POST['relationship'];
	$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
	if (mysqli_connect_errno()) {
		die('Failed to connect to database. Try again later.');
	}
	
	$query = 'update users set (work, edu, liveCity, liveState, fromCity, fromState, relationship) values(?, ?, ?, ?, ?, ?, ?) where email=$_SESSION['user']';
	$stmt  = $db->prepare($query);
	$stmt->bind_param('sssssss', $work, $edu, $liveCity, $liveState, $fromCity, $fromState, $relationship);
	
	if ($stmt->execute()) {
		$stmt->close();
		$db->close();
		header('location: profile.php');
	}

	$stmt->close();
	$db->close();
	die('Failed to create new user. Try again later.');
?>