<?php
	session_start();
	/* 
	*  Check to see if the user exists within your database
	*  I didn't do that here, I'm just redirecting and setting a session..
	*/

	// If they didn't enter a username or password, they should be redirected back to the index page
	if($_POST['username'] == "" || $_POST['password'] == ""){
		header("Location: index.php?error=userFail");
	}
	// If they entered the correct information, then we set the session user to be their user id and redirect them to the profile page.
	else{
		$_SESSION['user'] = $_POST['username'];
		header("Location: profile.php");
	}
?>