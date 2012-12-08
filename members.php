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

		<h1>Bad Pen Members</h1>

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
				if (isset($_GET['email'])) {
					$search = $_GET['email'];
					$query = "select fname, lname, email, id, (
						select id in (
							select user2 from friends where user1 = (
								select id from users where email = '$email'))) as friend from users where email like '%$search%'";
				}
				else {
					$query = "select fname, lname, email, id, liveCity, liveState, fromCity, fromState, image,  (
						select id in (
							select user2 from friends where user1 = (
								select id from users where email = '$email'))) as friend from users";
				}
				$results = $db->query($query);
				if (!$results) {
					die('Invalid query ' + mysqli_error());
				}

				$count = 0;
				while ($row = $results->fetch_assoc()) {
					if ($row['email'] != $_SESSION['user']) {
						$id = $row['id'];
						$email = $row['email'];
						$fname = $row['fname'];
						$lname = $row['lname'];
						$liveCity = $row['liveCity'];
						$liveState = $row['liveState'];
						$fromCity = $row['liveCity'];
						$fromState = $row['liveState'];
						$image = $row['image'];
						$checked = $row['friend'] ? 'checked' : '';
						$checkbox = "<input type='checkbox' name='friends[]' value='$id' $checked/>";
						++$count;
			?>
					<?php addProfile($email, $fname, $lname, "$liveCity, $liveState", "$fromCity, $fromState", $image); ?>
					<td>
						<input type="submit" class='block' value="Go to Profile"/>
						<input type='checkbox' name='friends[]' value='$id' $checked>Friends</input>
					</td>
					</tr></table></div></form>
						
			<?php
					}
				}

				if ($count == 0) {
					echo "<p>No Members Found</p>";
				}
				else {
					echo "<input type='submit' value='Save'/>";
				}

				$results->close();
				$db->close();
			?>
		</form>
	</body>
</html>
