<?php
	session_start();
	include_once("common.php");

	$work = $_POST['work'];
	$edu = $_POST['edu'];
	$liveCity = $_POST['liveCity'];
	$liveState = $_POST['liveState'];
	$fromCity = $_POST['fromCity'];
	$fromState = $_POST['fromState'];
	$relationship = $_POST['relationship'];
	if ($relationship == '---Select One---') {
			$relationship = 'Single';
	}
	$email = $_SESSION['user'];
	
	$db = getDatabaseHandle();

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
