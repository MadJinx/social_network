<!--
		Display the last 5 status updates made by the user that belongs to the profile
		Display the information of the user who the profile belongs to
DONE	If the profile page belongs to the current user, then give them an option to edit the page
		Some logo or simple site description
DONE	A menu that allows users to navigate to their profile or any other that they have access to on the site (home, help, about, contact, etc..) in addition to allowing them to logout
		Any additional features that fit on a social network's profile page are encouraged but not required 
		Add profile picture
-->



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

<?php
	$email = $_SESSION['user'];
	$db = new mysqli('localhost', 'team09', 'maroon', 'team09');
	if (mysqli_connect_errno()) {
		die('Failed to connect to database. Try again later.');
	}

	$query = 'select email, work, edu, liveCity, liveState, fromCity, fromState, relationship from users';
	$result = $db->query($query);

	while ($row = $result->fetch_assoc()){
		if ($row['email'] == $email) {
			$work = $row['work'];
			$edu = $row['edu'];
			$liveCity = $row['liveCity'];
			$liveState = $row['liveState'];
			$fromCity = $row['fromCity'];
			$fromState = $row['fromState'];
			$relationship = $row['relationship'];
		}
	}
	$result->free();
?>

		<title>Your Profile</title>
	</head>
	<body>
		<?php addMenu(); ?>
		<h1>Welcome to your profile page</h1>
		<div>
			<p>You are logged in as <?= $_SESSION['user']."." ?></p>
			
			<!-- need to change the second part of the condition -->
			<?php if ( $_SESSION['user'] == $_SESSION['profile'] ){ ?>
				<input type="button" id="edit" value="Edit" onClick="toggleVis('edit_info');" />
			<?php } ?>
		</div>
		<div>
			<table>
				<tr>
					<td>Work:</td>
					<td><?php echo"$work" ?></td>
				</tr>
				<tr>
					<td>Education:</td>
					<td><?php echo"$edu" ?></td>
				</tr>
				<tr>
					<td>Lives In:</td>
					<td><?php echo"$liveCity" ?>, <?php echo"$liveState" ?></td>
				</tr>
				<tr>
					<td>From:</td>
					<td><?php echo"$fromCity" ?>, <?php echo"$fromState" ?></td>
				</tr>
				<tr>
					<td>Relationship:</td>
					<td><?php echo"$relationship" ?></td>
				</tr>
			</table>
			<form action="edit.php" method="post">
				<div id="edit_info">
					<fieldset>
						<table>
							<tr>
								<td>Work:</td>
								<td><input type="text" name="work" id="work" value="<?php echo"$work" ?>" /></td>
							</tr>
							<tr>
								<td>Education:</td>
								<td><input type="text" name="edu" id="edu" value="<?php echo"$edu" ?>" /></td>
							</tr>
							<tr>
								<td>Lives In:</td>
								<td><input type="text" name="liveCity" id="liveCity" value="<?php echo"$liveCity" ?>" />
								<input type="text" name="liveState" id="liveState" value="<?php echo"$liveState" ?>" /></td>
							</tr>
							<tr>
								<td>From:</td>
								<td><input type="text" name="fromCity" id="fromCity" value="<?php echo"$fromCity" ?>" />
								<input type="text" name="fromState" id="fromState" value="<?php echo"$fromState" ?>" /></td>
							</tr>
							<tr>
								<td>Relationship:</td>
								<td><select name="relationship">
									<option value="single">Single</option>
									<option value="dating">Dating</option>
									<option value="married">Married</option>
									<option value="discerning">Discerning</option>
								</select></td>
							</tr>
						</table>
						<input type="submit" value="Submit">
					</fieldset>
				</div>
			</form>
		</div>
		<div>
			<p>Try uploading an image.</p>
			<form action="upload_test.php" method="post" name="upload_image" enctype="multipart/form-data">
				<fieldset>
					<label for="upload_image">Pick an image to upload:</label>
						<input type="file" name="upload_image" id="upload_image"/>
					<label for"img_name">What do you want your image to be called?</label>
						<input type="text" name="img_name" id="img_name" />
					<input type="submit" value="Upload" />
				</fieldset>
			</form>
		</div> 
		<div>
			<p>Status History</p>
			<fieldset>
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
							echo "<pre>$date --- $message</pre>";
						}
					}
					else {
						die('Failed to execute query');
					}

					$prep_query->close();
					$db->close();
				?>
			</fieldset>
		</div>
	</body>
</html>
