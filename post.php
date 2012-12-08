<?php
	session_start();
	include_once("common.php");

	$db = getDatabaseHandle();
	$id = getUserId($db);

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
