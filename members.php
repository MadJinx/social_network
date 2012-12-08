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
				$db = getDatabaseHandle();

				$user = $_SESSION['user'];
				if (isset($_GET['email'])) {
					$search = '%'.$_GET['email'].'%';
				}
				else {
					$search = '%';
				}
				$query = "select fname, lname, email, id, (
					select id in (
						select user2 from friends where user1 = (
							select id from users where email = ?))) as friend from users where email like ? and email <> ?";
				$prep_query = $db->prepare($query);
				$prep_query->bind_param('sss', $user, $search, $user);
				$prep_query->execute();
				$prep_query->bind_result($fname, $lname, $email, $id, $is_friend);

				$count = 0;
				while ($prep_query->fetch()) {
					$checked = $is_friend ? 'checked' : '';
					$checkbox = "<input type='checkbox' name='friends[]' value='$id' $checked/>";
					echo "<p>$fname $lname $checkbox</p>";
					++$count;
				}

				if ($count == 0) {
					echo "<p>No Members Found</p>";
				}
				else {
					echo "<input type='submit' value='Save'/>";
				}

				$prep_query->close();
				$db->close();
			?>
		</form>
	</body>
</html>
