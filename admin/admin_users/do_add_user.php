<?php
       include("../config/conf.php");
	   include( "../lib/func.user.php" ); 
	
		if( createAdminUser($_POST) )
		{
			$okmsg = base64_encode(" USER created  Successfully. ");
			echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
		}
		else {
		
			$errmsg = base64_encode(" Unable to create user, please try again later. ");
			echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		