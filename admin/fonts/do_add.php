<?php
       include("../config/conf.php");
       include( "../lib/func.fonts.php" );
       include("../classes/upload_class.php");
       include("../lib/file.upload.php");

       $responseData = addFont($_POST);
           if( $responseData[0] == '1')
            {
                    $okmsg = base64_encode(" Font added  Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to add Font, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		