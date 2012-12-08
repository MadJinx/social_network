<?php
/*
*  This functions is a standard page header for each page. This allows me to easily change
*  the DOCTYPE or common style sheets for all of my webpages with very little effort.
*/
function common_header(){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="functions.js"></script>
	<link rel="stylesheet" type="text/css" href="format.css">
<?php
}

// adds menu bar for all pages
function addMenu() { ?>
	<div class="menu imen" onClick="toggleVis('m');">Menu</div>
	<div class="menu" id="m">
		<div class="imen" onClick="toggleVis('m');">Menu</div>
		<ul>
			<li><img src="images/home.png" alt="home" onClick="warp('home');"/></li>
			<li><img src="images/profile.png" alt="profile" onClick="warp('profile');"/></li>
			<li><img src="images/friends.png" alt="friends" onClick="warp('friends');"/></li>
			<li><img src="images/members.png" alt="members" onClick="warp('members');"/></li>
			<li><img src="images/logout.png" alt="logout" onClick="warp('logout');"/></li>
		</ul>
	</div>
	<div id="logo">
		<img src="images/pen.png" alt="pen"/>
		<h1>Bad Pen Social<h1>
	</div>
<?php
}

function addProfile($uname, $fname, $lname, $lives, $from, $pic) { ?>
	<div class="profiles">
		<table>
			<tr>
				<td>
					<img src="images/<?php echo $pic; ?>" alt="images/<?php echo $pic; ?>">
				</td>
				<td>
					<h4><?php echo $uname; ?></h4>
					<p><?php echo "$fname $lname"; ?></p>
					<h5>Lives in <?php echo $lives; ?></h5>
					<h5>From <?php echo $from; ?></h5>
				</td>
			</tr>
		</table>
	</div>
<?php }

/*
*  This function takes an uploaded image, resizes it, converts it to .jpg and stores it in a designated location
*/
function create_images($img_name){

	// Check to see if the file uploaded. NOTE: 'upload_image' is the name of the file input type on profile.php
	if(!is_uploaded_file($_FILES['upload_image']['tmp_name']) || $_FILES['upload_image']['error'] != UPLOAD_ERR_OK){
	    exit('File not uploaded.');
	}

	// Check to make sure that the file is an image file. (Useful for security purposes..)
	switch(strtolower($_FILES['upload_image']['type'])){
    	case 'image/jpeg':
    		echo $_FILES['upload_image']['tmp_name'];
        	$image = imagecreatefromjpeg($_FILES['upload_image']['tmp_name']);
        	break;
    	case 'image/png':
    		echo $_FILES['upload_image']['tmp_name'];
        	$image = imagecreatefrompng($_FILES['upload_image']['tmp_name']);
        	break;
    	case 'image/gif':
    		echo $_FILES['upload_image']['tmp_name'];
        	$image = imagecreatefromgif($_FILES['upload_image']['tmp_name']);
        	break;
    	default:
        	exit('Unsupported type: '.$_FILES['upload_image']['type']);
	}

	/******************************************************************************* 
	This example creates a larger image that is a maximum size of 400 X 400 pixels 
	********************************************************************************/

	// The maximum dimensions for your new image
	$max_width = 400;
	$max_height = 400;

	// The current dimensions for your new image
	$old_width = imagesx($image);
	$old_height = imagesy($image);

	// Scale the width and height according to your previous dimensions
	$scale = min($max_width/$old_width, $max_height/$old_height);

	// Create a new width and height based on the scale
	$new_width  = ceil($scale*$old_width);
	$new_height = ceil($scale*$old_height);

	// Actually create the new image
	$new = imagecreatetruecolor($new_width, $new_height);
	imagecopyresampled($new, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
	
	// Store the image in the "images" directory as image.jpg.
	imagejpeg($new, "images/".$img_name.".jpg", 90);
	
	// Clean up
	imagedestroy($image);
	imagedestroy($new);
}
?>
