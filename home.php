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
	<title>Your Home</title>
	</head>
	<body>
		<?php addMenu(); ?>
		<h1>Welcome to the Home Page</h1>
		<form action='home.php' method='post'>
			<fieldset>
				<input type='text' />
			</fieldset>
		</form>
	</body>
</html>
