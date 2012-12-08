<?php
	session_start();
	include_once("common.php");

	$db = getDatabaseHandle();
	$id = getUserId($db);
	$prev_friend_ids = getFriendIds($db, $id);
	unfriendUsers($db, $id, $prev_friend_ids, $_POST['friends']);
	befriendUsers($db, $id, $_POST['friends']);

	$db->close();

	header('location: members.php');
?>
