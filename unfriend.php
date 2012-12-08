<?php
	session_start();
	include_once("common.php");

	$db = getDatabaseHandle();
	$id = getUserId($db);
	unfriendUser($db, $id, $_POST['user2']);
	$db->close();

	header('location: friends.php');
?>
