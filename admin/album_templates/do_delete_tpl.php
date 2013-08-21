<?php
       include("../config/conf.php");
       include( "../lib/func.album.tpl.php" );

            if( deleteTpl($_REQUEST['tpl_id']) )
            {
                    $okmsg = base64_encode(" Template Deleted Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to Delete, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		