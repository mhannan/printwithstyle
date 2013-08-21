<?php
       include("../config/conf.php");
       require_once("../lib/func.designevent.php");

	//$responseData = mark_winner($_GET['design_id']);
		//if( $responseData[0] == '1')


              if(unmark_winner($_GET['design_id']))
		{
			$okmsg = base64_encode(" Information Updated Successfully. ");
			echo "<script> window.location = 'designs.php?event_id=".$_GET['event_id']."&okmsg=$okmsg';</script>";
		}
		else {

			$errmsg = base64_encode(" Unable to update, please try again later. ");
			echo "<script> window.location = 'designs.php?event_id=".$_GET['event_id']."&errmsg=$errmsg';</script>";
		}



?>