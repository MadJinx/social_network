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

	// Insert new information into DB
	if (isset($_POST['message'])) {
		$stmt = 'insert into messages(message, date, user_id) values(?, NOW(), ?)';
		$prep_stmt = $db->prepare($stmt);
		$prep_stmt->bind_param('si', $_POST['message'], $id);
	}
	else if (isset($_POST['comment'])) {
		$stmt = 'insert into comments(comment, date, user_id, message_id) values(?, NOW(), ?, ?)';
		$prep_stmt = $db->prepare($stmt);
		$prep_stmt->bind_param('sii', $_POST['comment'], $id, $_POST['message_id']);
	}

	if ($prep_stmt->execute()) {
		$prep_stmt->close();
		$db->close();
		header('Location: home.php');
	}

	$prep_stmt->close();
	$db->close();
	header('Location: home.php?error=postFail');
?>
