<?php
       include("../config/conf.php");
       require_once("../lib/func.testimonial.php");
       
	//$responseData = updateEvent($_POST);
	//	if( $responseData[0] == '1')
        if(update_testimonial($_POST))
		{
			$okmsg = base64_encode(" Information Updated Successfully. ");
			echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
		}
		else {
		
			$errmsg = base64_encode(" Unable to update, please try again later. ");
			echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		