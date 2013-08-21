<?php
       include("../config/conf.php");
       
       include( "../lib/func.designevent.php" );
            if( deleteEvent($_REQUEST['event_id']) )
            {
                    $okmsg = base64_encode(" Event Deleted Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to Delete, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		