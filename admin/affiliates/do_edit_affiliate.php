<?php
       include("../config/conf.php");
       include( "../lib/func.affiliate.php" );
       
		if(updateAffiliate($_POST) )
		{
			$okmsg = base64_encode(" Information Updated Successfully. ");
			echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
		}
		else {
		
			$errmsg = base64_encode(" Unable to update, please try again later. ");
			echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		