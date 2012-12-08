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

	// Obtain 20 most recent messages
	$messages = array();

	$query = 'select message, date, id,
		(select fname from users where id = user_id) as fname,
		(select lname from users where id = user_id) as lname
		from messages where user_id = ?
		or user_id in (select user2 from friends where user1 = ?)
		order by date desc
		limit 20';
	$prep_query = $db->prepare($query);
	$prep_query->bind_param('ii', $id, $id);
	if ($prep_query->execute()) {
		$prep_query->bind_result($message, $date, $m_id, $fname, $lname);
		while ($prep_query->fetch()) {
			$tmp = array();
			$tmp['fname'] = $fname;
			$tmp['lname'] = $lname;
			$tmp['date'] = $date;
			$tmp['message'] = $message;
			$tmp['m_id'] = $m_id;
			$messages[] = $tmp;
		}
	}
	else {
		die('Failed to execute query');
	}

	$prep_query->close();
	
	$comment_query = 'select comment, date,
		(select fname from users where id = user_id) as fname,
		(select lname from users where id = user_id) as lname
		from comments where message_id = ?
		order by date desc';
	$prep_comment_query = $db->prepare($comment_query);

	echo '<h2>News Feed</h2>';
	echo '<fieldset>';
		echo "<ul>";
		foreach ($messages as $row) {
			echo "<li>";
			echo "<form method='post' action='post.php'>";
				$fname = $row['fname'];
				$lname = $row['lname'];
				$message = $row['message'];
				$date = $row['date'];
				$m_id = $row['m_id'];

				echo "<input type='hidden' name='message_id' value='$m_id'/>";
				echo "<pre><strong>$fname $lname --- $date</strong>\n$message</pre>";
				
		echo "<ul>";
				$prep_comment_query->bind_param('i', $m_id);
				$prep_comment_query->execute();
				$prep_comment_query->bind_result($comment, $c_date, $c_fname, $c_lname);
				while ($prep_comment_query->fetch()) {
			echo "<li>";
			echo "<pre><strong>$c_fname $c_lname --- $c_date</strong>\n$comment</pre>";
			echo "</li>";
				}
				echo "<textarea class='inline' name='comment' rows='1' cols='80' placeholder='Comment...'></textarea>";
				echo "<input class='vert_center buffer' type=submit value='Post'/>";
		echo "</ul>";
			echo "</form>";
			echo "</li>";
		}
		echo "</ul>";
	echo "</fieldset>";

	$prep_comment_query->close();
	$db->close();
?>
	</body>
</html>
