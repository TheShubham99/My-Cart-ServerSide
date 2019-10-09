<?php

 
 $thefile = $_FILES['file'];
 $name=$_FILES['file']['name'];
 if(!empty($thefile))
 {
	 $target_dir = "images/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
 
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    //    echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
          echo "UPLOADED";
	}
	else{
		echo "error";
	}
 
 }
 else
 {
     echo "Failed!";
 }
?>