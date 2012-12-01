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
		
		<!-- need to change the second part of the condition -->
		<?php if ( $_SESSION['user'] == $_SESSION['profile'] ){ ?>
			<input type="button" id="edit" value="Edit" onClick="toggleVis('edit_info');" />
		<?php } ?>
	</div>
	<div>
		<table>
			<tr>
				<td>Work:</td>
				<td>Goodtimes</td>
			</tr>
			<tr>
				<td>Education:</td>
				<td>Colorado School of Mines</td>
			</tr>
			<tr>
				<td>Lives In:</td>
				<td>Golden, CO</td>
			</tr>
			<tr>
				<td>From:</td>
				<td>Colorado Springs, CO</td>
			</tr>
			<tr>
				<td>Relationship:</td>
				<td>Single</td>
			</tr>
		</table>
		<div id="edit_info">
			<fieldset>
				<label for="work">Work:</label>
					<input type="text" name="work" id="work" value="job" />
				<br />
				<label for="edu">Education:</label>
					<input type="text" name="edu" id="edu" value="school" />
				<br />
				<label for="lives">Lives In:</label>
					<input type="text" name="liveCity" id="liveCity" value="city" />
					<input type="text" name="liveState" id="liveState" value="state" />
				<br />
				<label for="from">From:</label>
					<input type="text" name="fromCity" id="fromCity" value="city" />
					<input type="text" name="fromState" id="fromState" value="State" />
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