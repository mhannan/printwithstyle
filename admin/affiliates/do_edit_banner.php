<?php
       include("../config/conf.php");
       include("../classes/upload_class.php");
       include("../lib/photo.upload.php");
       include( "../lib/func.banner.php" );

       
       
	$responseData = updateBanner($_POST); 
		if( $responseData[0] == '1')
		{
			$okmsg = base64_encode(" Information Updated Successfully. ");
			echo "<script> window.location = 'index.php?tab=banner&okmsg=$okmsg';</script>";
		}
		else {
		
			$errmsg = base64_encode(" Unable to update, please try again later. ");
			echo "<script> window.location = 'index.php?tab=banner&errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		