<?php
	session_start();
	$_SESSION['profile'] = $_POST['uname'];
	header("Location: profile.php");
?>