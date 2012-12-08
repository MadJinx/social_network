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
	<title>Your Friends</title>
	</head>
	<body>
		<?php addMenu(); ?>
		<h1>Bad PenPals</h1>

		<?php
			$db = getDatabaseHandle();
			$id = getUserId($db);
			
			$query = "select user2 from friends where user1 = $id";
			$results = $db->query($query);

			if (!$results) {
				die('Invalid query');
			}

			$query = 'select fname, lname, email, liveCity, liveState, fromCity, fromState, image from users where id = ?';
			$prep_query = $db->prepare($query);
			while ($row = $results->fetch_assoc()) {
				$id2 = $row['user2'];
				$prep_query->bind_param('i', $id2);
				if ($prep_query->execute()) {
					$prep_query->bind_result($fname, $lname, $email, $liveCity, $liveState, $fromCity, $fromState, $image);
					$prep_query->fetch();
		?>
					<form action="unfriend.php" method="post" id='friend_form<?php echo $id2 ?>'>
						<input type='hidden' name='user2' value='<?php echo $id2 ?>'/>
					</form>
					<form action="profile.php" method="post">
					<?php addProfile($email, $fname, $lname, "$liveCity, $liveState", "$fromCity, $fromState", $image); ?>
					<td>
						<input type="submit" class='block' value="Go to Profile"/>
						<input type='submit' class='block' form='friend_form<?php echo $id2 ?>' value='Unfriend'/>
					</td>
					</tr></table></div></form>
		<?php
				}
				else {
					die('Error obtaining friends list');
				}
			}

			$prep_query->close();
			$results->close();
			$db->close();
		?>
	</body>
</html>
