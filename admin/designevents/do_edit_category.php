<?php
       include("../config/conf.php");
       include( "../lib/func.customer.packages.php" );
       
	$responseData = updatePackage($_POST);
		if( $responseData[0] == '1')
		{
			$okmsg = base64_encode(" Information Updated Successfully. ");
			echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
		}
		else {
		
			$errmsg = base64_encode(" Unable to update, please try again later. ");
			echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		