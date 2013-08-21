<?php
       include("../config/conf.php");
	   include( "../lib/func.agent.php" );
	
		if( createAgentUser($_POST) )
		{
			$okmsg = base64_encode(" AGENT created  Successfully. ");
			echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
		}
		else {
		
			$errmsg = base64_encode(" Unable to create AGENT, please try again later. ");
			echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		