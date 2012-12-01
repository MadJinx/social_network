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
<title>Your Profile</title>
</head>
<body>
	<?php addMenu(); ?>
	<h1>Welcome to your profile page</h1>
	<div>
		<p>You are logged in as <?= $_SESSION['user']."." ?></p>
		<p><a href="logout.php">Logout?</a></p>
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
</body>
</html>