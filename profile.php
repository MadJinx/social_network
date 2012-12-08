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
	if(!(isset($_POST['uname']))){
		$_SESSION['profile'] = $_SESSION['user'];
	}
	else {
		$_SESSION['profile'] = $_POST['uname'];
	}
?>

<?php
	$email = $_SESSION['profile'];
	$db = getDatabaseHandle();

	$query = 'select email, work, edu, liveCity, liveState, fromCity, fromState, relationship, image from users';
	$result = $db->query($query);

	while ($row = $result->fetch_assoc()){
		if ($row['email'] == $email) {
			$work = htmlspecialchars($row['work']);
			$edu = htmlspecialchars($row['edu']);
			$liveCity = htmlspecialchars($row['liveCity']);
			$liveState = htmlspecialchars($row['liveState']);
			$fromCity = htmlspecialchars($row['fromCity']);
			$fromState = htmlspecialchars($row['fromState']);
			$relationship = htmlspecialchars($row['relationship']);
			$image = htmlspecialchars($row['image']);
		}
	}
	$result->free();
?>

		<title>Your Profile</title>
	</head>
	<body>
		<?php addMenu(); ?>
		<h1>Welcome to Yo' Profile</h1>
		<div>
			<h4>You are logged in as <?= htmlspecialchars($_SESSION['profile'])."." ?></h4>
			
			<!-- need to change the second part of the condition -->
			<?php if ( $_SESSION['profile'] == $_SESSION['user'] ){ ?>
				<input type="button" id="edit" value="Edit" onClick="toggleVis('edit_info');" />
			<?php } ?>
		</div>
		<div>
			<table>
				<tr>
					<td><strong>Work:</strong></td>
					<td><?php echo"$work" ?></td>
				</tr>
				<tr>
					<td><strong>Education:</strong></td>
					<td><?php echo"$edu" ?></td>
				</tr>
				<tr>
					<td><strong>Lives In:</strong></td>
					<td><?php echo"$liveCity" ?>, <?php echo"$liveState" ?></td>
				</tr>
				<tr>
					<td><strong>From:</strong></td>
					<td><?php echo"$fromCity" ?>, <?php echo"$fromState" ?></td>
				</tr>
				<tr>
					<td><strong>Relationship:</strong></td>
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
			<img class='border' src=<?php echo "images/$image"; ?> alt='profile image'/>
			<?php if ( $_SESSION['profile'] == $_SESSION['user'] ){ ?>
				<form action="upload_test.php" method="post" name="upload_image" enctype="multipart/form-data">
					<fieldset>
						<label for="upload_image">Pick an image to upload as profile picture:</label>
							<input type="file" name="upload_image" id="upload_image"/>
						<input type="submit" value="Upload" />
					</fieldset>
				</form>
			<?php } ?>
		</div> 
		<div>
			<p>Status History</p>
			<fieldset>
				<?php
					$id = getUserId($db);

					// Obtain 5 most recent messages
					$messages = array();
					$query = 'select message, date, id,
						(select fname from users where id = user_id) as fname,
						(select lname from users where id = user_id) as lname
						from messages where user_id = ?
						order by date desc
						limit 5';
					$prep_query = $db->prepare($query);
					$prep_query->bind_param('i', $id);
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
							echo "<pre><strong>".htmlspecialchars("$fname $lname --- $date")."</strong>\n".htmlspecialchars($message)."</pre>";
							
							echo "<ul>";
							$prep_comment_query->bind_param('i', $m_id);
							$prep_comment_query->execute();
							$prep_comment_query->bind_result($comment, $c_date, $c_fname, $c_lname);
							while ($prep_comment_query->fetch()) {
								echo "<li>";
								echo "<pre><strong>".htmlspecialchars("$c_fname $c_lname --- $c_date")."</strong>\n".htmlspecialchars($comment)."</pre>";
								echo "</li>";
							}
							echo "<textarea class='inline' name='comment' rows='1' cols='80' placeholder='Comment...'></textarea>";
							echo "<input class='vert_center buffer' type=submit value='Post'/>";
						echo "</ul>";
						echo "</form>";
						echo "</li>";
					}
					echo "</ul>";
					
					$prep_comment_query->close();
					$db->close();
				?>
			</fieldset>
		</div>
	</body>
</html>
