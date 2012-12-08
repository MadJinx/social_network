<?php
	session_start();
	
	// Check to see if the user is logged in. If they are not, then redirect them to the index/login page.
	if(!(isset($_SESSION['user']))){
		header("Location: index.php");
	}
	// Include the common PHP file
	include_once("common.php");
	// Call the common header function.
	
	// Connect to DB
	$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
	if (mysqli_connect_errno()) {
		die('Failed to connect to database. Try again later.');
	}

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

	$db->close();

	// Call create image function from common.php
	create_images($id);
	common_header();

?>
	<title>Upload Test</title>
</head>
<body>
	<div>
		<p>Go to the images folder and see if the upload worked.</p>
		<p><a href="profile.php">Back to Profile</a></p>
	</div>
</body>
</html>
