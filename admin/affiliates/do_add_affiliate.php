<?php
       include("../config/conf.php");
       include( "../lib/func.affiliate.php" );
	
		if( createAffiliate($_POST) )
		{
			$okmsg = base64_encode(" Affiliate created  Successfully. ");
			echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
		}
		else {
		
			$errmsg = base64_encode(" Unable to create Affiliate, there possibally exists affiliate with same email. please try again. ");
			echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		