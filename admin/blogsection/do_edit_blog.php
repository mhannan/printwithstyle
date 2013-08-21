<?php
ob_start();
session_start();
     include("../config/conf.php");
     include( "../lib/func.blogsection.php" );
     include("../classes/upload_class.php");
     include("../lib/photo.upload.php");
     
	$responseData = updateBlogArticle($_POST);
		if( $responseData[0] == '1')
		{
			$okmsg = base64_encode(" Article Post Updated Successfully. ");
			echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
		}
		else {
		
			$errmsg = base64_encode(" Unable to update, please try again later. ");
			echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		