<?php
       include("../config/conf.php");
       include( "../lib/func.agent.php" );

            if( deleteAgent($_REQUEST['agent_id']) )
            {
                    $okmsg = base64_encode(" Agent Deleted Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to Delete, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		