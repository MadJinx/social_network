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

	// Obtain current friends list ids
	$query = "select user2 from friends where user1 = $id";
	$results = $db->query($query);
	if (!$results) {
		die('Invalid query');
	}

	// Delete friends who now have their name unchecked
	$stmt = 'delete from friends where user2 = ?';
	$prep_stmt = $db->prepare($stmt);

	while ($row = $results->fetch_assoc()) {
		$id2 = $row['user2'];
		if (!in_array($id2, (array) $_POST['friends'])) {
			$prep_stmt->bind_param('i', $id2);
			if (!$prep_stmt->execute()) {
				die("Could not delete user with id $id2");
			}
		}
	}
	$prep_stmt->close();

	// Add new friendships to DB
	$stmt = 'insert into friends values(?, ?)';
	$prep_stmt = $db->prepare($stmt);

	foreach ((array) $_POST['friends'] as $id2) {
		$prep_stmt->bind_param('ii', $id, $id2);

		if (!$prep_stmt->execute()) {
			header('location: members.php?error=friends');
		}
	}

	$prep_stmt->close();
	$db->close();

	header('location: members.php');
?>
