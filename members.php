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
		<title>Members</title>
	</head>
	<body>
		<?php addMenu(); ?>

		<h1>Welcome to the Members Page</h1>
		<h2>Befriend members by checking the checkbox next to their name and pressing the 'Save' button.</h2>

		<form method="get" action="members.php" id="search">
			Search for Members you know:
			<table>
				<tr>
					<td>Email:</td>
					<td><input type="text" name="email" id="email"/></td>
				</tr>
			</table>
			<input type="submit" value="Search"/>
		</form>

		<form method="post" action="add_friends.php">
			<?php
				// Connect to DB
				$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
				if (mysqli_connect_errno()) {
					die('Failed to connect to database. Try again later.');
				}

				$email = $_SESSION['user'];
				$query = "select fname, lname, email, id, (
					select id in (
						select user2 from friends where user1 = (
							select id from users where email = '$email'))) as friend from users";
				$results = $db->query($query);
				if (!$results) {
					die('Invalid query ' + mysqli_error());
				}

				while ($row = $results->fetch_assoc()) {
					if ($row['email'] != $_SESSION['user']) {
						$id = $row['id'];
						$fname = $row['fname'];
						$lname = $row['lname'];
						$checked = $row['friend'] ? 'checked' : '';
						$checkbox = "<input type='checkbox' name='friends[]' value='$id' $checked/>";
						echo "<p>$fname $lname $checkbox</p>";
					}
				}

				$results->close();
				$db->close();
			?>
			<input type='submit' value='Save'/>
		</form>
	</body>
</html>
