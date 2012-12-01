<!--
		Display the last 5 status updates made by the user that belongs to the profile
		Display the information of the user who the profile belongs to
DONE	If the profile page belongs to the current user, then give them an option to edit the page
		Some logo or simple site description
DONE	A menu that allows users to navigate to their profile or any other that they have access to on the site (home, help, about, contact, etc..) in addition to allowing them to logout
		Any additional features that fit on a social network's profile page are encouraged but not required 
-->



<?php
	session_start();
	//addMenu();
	
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
<title>Your Profile</title>
</head>
<body>
	<?php addMenu(); ?>
	<h1>Welcome to your profile page</h1>
	<div>
		<p>You are logged in as <?= $_SESSION['user']."." ?></p>
		<p><a href="logout.php">Logout?</a></p>
		
		<!-- need to change the second part of the condition -->
		<?php if ( $_SESSION['user'] == $_SESSION['profile'] ){ ?>
			<p><a href="edit.php">Edit</a></p>
		<?php } ?>
	</div>
	<div>
		<p> job, school, lives, relationship, birthday, likes, </p>
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
			<p> Status 1 </p> </br>
			<p> Status 2 </p> </br>
			<p> Status 3 </p> </br>
			<p> Status 4 </p> </br>
			<p> Status 5 </p> </br>
		</fieldset>
	</div>
</body>
</html>