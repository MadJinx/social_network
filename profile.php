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
	// $email = $_SESSION['user'];
	// $db = new mysqli('localhost', 'team09', 'maroon', 'team09');
	// if (mysqli_connect_errno()) {
		// die('Failed to connect to database. Try again later.');
	// }

	// $query = 'select work, edu, liveCity, liveState, fromCity, fromState, relationship from users where email=csoto@mymail.mines.edu';
	// $stmt = $db->prepare($query);
	// $stmt->bind_param('s', $email);
	// $result = $stmt->query();

	// $row = $result->fetch_assoc();

	// $work = $row['work'];
	// $edu = $row['edu'];
	// $liveCity = $row['liveCity'];
	// $liveState = $row['liveState'];
	// $fromCity = $row['fromCity'];
	// $fromState = $row['fromState'];
	// $relationship = $row['relationship'];

	// $result->free();
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
				<td><?php $work ?></td>
			</tr>
			<tr>
				<td>Education:</td>
				<td><?php $edu ?></td>
			</tr>
			<tr>
				<td>Lives In:</td>
				<td><?php $liveCity ?>, <?php $liveState ?></td>
			</tr>
			<tr>
				<td>From:</td>
				<td><?php $fromCity ?>, <?php $fromState ?></td>
			</tr>
			<tr>
				<td>Relationship:</td>
				<td><?php $relationship ?></td>
			</tr>
		</table>
		<form action="edit.php" method="post">
			<div id="edit_info">
				<fieldset>
					<label for="work">Work:</label>
						<input type="text" name="work" id="work" value="<?php $work ?>" />
					<br />
					<label for="edu">Education:</label>
						<input type="text" name="edu" id="edu" value="<?php $edu ?>" />
					<br />
					<label for="lives">Lives In:</label>
						<input type="text" name="liveCity" id="liveCity" value="<?php $liveCity ?>" />
						<input type="text" name="liveState" id="liveState" value="<?php $liveState ?>" />
					<br />
					<label for="from">From:</label>
						<input type="text" name="fromCity" id="fromCity" value="<?php $fromCity ?>" />
						<input type="text" name="fromState" id="fromState" value="<?php $fromState ?>" />
					<br />
					<select>
						<option> ---Select One---</option>
						<option value="single">Single</option>
						<option value="dating">Dating</option>
						<option value="married">Married</option>
						<option value="discerning">Discerning</option>
					</select>
					<br />
					<input type="submit" value="Submit">
				</fieldset>
			</div>
		</form>
	</div>
	<div>
		<p>Try uploading an image.</p>
		<form action="upload_test.php" method="post" name="upload_image" enctype="multipart/form-data">
			<fieldset>
<!--				<label for="upload_image">Pick an image to upload:</label>
					<input type="file" name="upload_image" id="upload_image"/>
				<br />
-->				<label for"img_name">What do you want your image to be called?</label>
					<input type="text" name="img_name" id="img_name" />
				<input type="submit" value="Upload" />
			</fieldset>
		</form>
	</div> 
	<div>
		<p> Status' Big Woophf want to fight about it </p>
		<fieldset>
			<p> <?= $_SESSION['user'] ?> Status 1 </p> </br>
			<p> <?= $_SESSION['user'] ?> Status 2 </p> </br>
			<p> <?= $_SESSION['user'] ?> Status 3 </p> </br>
			<p> <?= $_SESSION['user'] ?> Status 4 </p> </br>
			<p> <?= $_SESSION['user'] ?> Status 5 </p> </br>
		</fieldset>
	</div>
</body>
</html>