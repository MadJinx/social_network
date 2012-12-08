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
	<title>Your </title>
	</head>
	<body>
		<?php addMenu(); ?>
		<h1>Home Base</h1>
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
	$query = 'select message, date,
		(select fname from users where id = user_id) as fname,
		(select lname from users where id = user_id) as lname
		from messages where user_id = ?
		or user_id in (select user2 from friends where user1 = ?)
		order by date desc
		limit 20';
	$prep_query = $db->prepare($query);
	$prep_query->bind_param('ii', $id, $id);
	if ($prep_query->execute()) {
		$prep_query->bind_result($message, $date, $fname, $lname); ?>
		<h2>News Feed</h2>
		<fieldset>
			<?php while ($prep_query->fetch()) {
				echo "<pre>$fname $lname --- $date --- $message</pre>";
			} ?>
		</fieldset>
<?php
	}
	else {
		die('Failed to execute query');
	}

	$prep_query->close();
	$db->close();
?>

	</body>
</html>
