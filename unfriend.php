<?php
	session_start();

	// Connect to DB
	$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
	if (mysqli_connect_errno()) {
		die('Failed to connect to database. Try again later.');
	}

	// Obtain session user's id
	$query = 'select id from users where email = ?';
	$prep_query = $db->prepare($query);
	$prep_query->bind_param('s', $_SESSION['user']);
	if ($prep_query->execute()) {
		$prep_query->bind_result($id);
		$prep_query->fetch();
		$prep_query->close();
	}
	else {
		die('Failed to execute query');
	}

	// Delete friends who now have their name unchecked
	$stmt = 'delete from friends where user2 = ?';
	$prep_stmt = $db->prepare($stmt);
	$prep_stmt->bind_param('i', $_POST['user2']);
	$prep_stmt->execute();
	$prep_stmt->close();
	$db->close();

	header('location: friends.php');
?>
