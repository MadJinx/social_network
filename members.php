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

		<form method="post" action="add_friends.php">
			<?php
				// Connect to DB
				$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
				if (mysqli_connect_errno()) {
					die('Failed to connect to database. Try again later.');
				}

				$query = 'select fname, lname, email, id from users';
				$results = $db->query($query);
				if (!$results) {
					die('Invalid query ' + mysqli_error());
				}

				while ($row = $results->fetch_assoc()) {
					if ($row['email'] != $_SESSION['user']) {
						$id = $row['id'];
						$fname = $row['fname'];
						$lname = $row['lname'];
						$checkbox = "<input type='checkbox' name='friends[]' value='$id'/>";
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
