<?php
	session_start();
	
	// Check to see if the user is logged in. If they are not, then redirect them to the index/login page.
	if(!(isset($_SESSION['user']))){
		header("Location: index.php");
	}
	// Include the common PHP file
	include_once("common.php");
	// Call the common header function.
	
	$db = getDatabaseHandle();
	$id = getUserId($db);

	// Call create image function from common.php
	$img_name = create_images($id);
	$stmt = 'update users set image = ? where id = ?';
	$prep_stmt = $db->prepare($stmt);
	$prep_stmt->bind_param('ss', $img_name, $id);	
	if (!$prep_stmt->execute()) {
		die('Unable to update profile picture');
	}

	$db->close();
	header('Location: profile.php');
?>
