<?php
       include("../config/conf.php");
       
       include( "../lib/func.banner.php" );

            if( deleteBanner($_REQUEST['banner_id']) )
            {
                    $okmsg = base64_encode(" Banner Deleted Successfully. ");
                    echo "<script> window.location = 'index.php?tab=banner&okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to Delete, please try again later. ");
                    echo "<script> window.location = 'index.php?tab=banner&errmsg=$errmsg';</script>";
            }
		
				
	 
?>		