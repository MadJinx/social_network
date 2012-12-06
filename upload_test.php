<?php
	session_start();
	
	// Check to see if the user is logged in. If they are not, then redirect them to the index/login page.
	if(!(isset($_SESSION['user']))){
		header("Location: index.php");
	}
	// Include the common PHP file
	include_once("common.php");
	// Call the common header function.
	

	// NOTE: This check does not look for any sort of injection attack. Beware..
	if($_POST['img_name'] == "")
		$img_name = "default";
	else
		$img_name = $_POST['img_name'];

	// Call create image function from common.php
	create_images($img_name);
	common_header();

?>
	<title>Upload Test</title>
</head>
<body>
	<div>
		<p>Go to the images folder and see if the upload worked.</p>
		<p><a href="profile.php">Back to Profile</a></p>
	</div>
</body>
</html>
