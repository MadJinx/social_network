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
	
	//need to set to the person's page we view. 
	$_SESSION['profile'] = $_SESSION['user'];
?>
	<title>Members</title>
	</head>
	<body>
		<?php addMenu(); ?>
		<h1>Welcome to the Members Page</h1>

		<?php
			// Connect to DB
			$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
			if (mysqli_connect_errno()) {
				die('Failed to connect to database. Try again later.');
			}

			$query = 'select fname, lname from users';
			$results = $db->query($query);
			if (!$results) {
				die('Invalid query' + mysqli_error());
			}

			while ($row = $results->fetch_assoc()) {
				$fname = $row['fname'];
				$lname = $row['lname'];
				echo "<p>$fname $lname</p>";
			}

			$results->close();
			$db->close();
		?>

	</body>
</html>
