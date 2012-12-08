<?php
	session_start();

	// Include the common PHP file
	include_once("common.php");
	// Call the common header function.
	common_header();	

	$db = getDatabaseHandle();
	$id = getUserId($db);
	$prev_friend_ids = getFriendIds($db, $id);
	unfriendUsers($db, $prev_friend_ids, $_POST['friends']);
	befriendUsers($db, $id, $_POST['friends']);

	$db->close();

	header('location: members.php');
?>
