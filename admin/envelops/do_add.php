<?php
       include("../config/conf.php");
       include( "../lib/func.envelop.php" );
       include("../classes/upload_class.php");
       include("../lib/photo.upload.php");

       $responseData = addEnvelop($_POST);
           if( $responseData[0] == '1')
            {
                    $okmsg = base64_encode(" Envelop added  Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to add Envelop, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		