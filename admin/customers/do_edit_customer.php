<?php
       include("../config/conf.php");
       include( "../lib/func.agent.php" );
	$responseData = update_agent($_POST);
		if( $responseData[0] == '1')
		{
			$okmsg = base64_encode(" AGENT Updated Successfully. ");
			echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
		}
		else {
		
			$errmsg = base64_encode(" Unable to update, please try again later. ");
			echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		