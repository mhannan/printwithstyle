<?php
       include("../config/conf.php");
       
       include("../classes/upload_class.php");
       include("../lib/photo.upload.php");
       include( "../lib/func.designevent.php" );

       $responseData = addEvent($_POST);
           if( $responseData[0] == '1')
            {
                    $okmsg = base64_encode(" Event added  Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to add Event, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		