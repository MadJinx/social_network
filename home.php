<?php
	session_start();
	
	// Check to see if the user is logged in. If they are not, then redirect them to the index/login page.
	if(!(isset($_SESSION['user']))){
		header("Location: index.php");
	}
	// Include the common PHP file
	include_once("common.php");
	// Call the common header function.
	common_header();
?>
	<title>Your Home</title>
	</head>
	<body>
		<?php addMenu(); ?>
		<h1>Welcome to the Home Page</h1>
		<form action='post.php' method='post'>
			<fieldset>
				<textarea id='message' name='message' rows='4' cols='80' maxlength='255' placeholder="Anything you'd like to share today?"></textarea>
				<input type='submit' value='Post'/>
			</fieldset>
		</form>

<?php
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

	// Obtain 5 most recent messages
	$query = 'select message, date from messages where user_id = ? order by date desc limit 5';
	$prep_query = $db->prepare($query);
	$prep_query->bind_param('s', $id);
	if ($prep_query->execute()) {
		$prep_query->bind_result($message, $date);
		while ($prep_query->fetch()) {
			echo "<pre>$message $date</pre>";
		}
	}
	else {
		die('Failed to execute query');
	}

	$prep_query->close();
	$db->close();
?>

	</body>
</html>
