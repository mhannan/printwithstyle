<?php
       include("../config/conf.php");
       include( "../lib/func.pages.php" );
       include("../classes/upload_class.php");
       include("../lib/photo.upload.php");

       $responseData = addPage($_POST);
           if( $responseData[0] == '1')
            {
                    $okmsg = base64_encode(" Page added  Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to add page, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		