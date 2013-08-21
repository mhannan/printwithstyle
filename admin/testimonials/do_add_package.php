<?php
       include("../config/conf.php");
       include( "../lib/func.customer.packages.php" );

       $responseData = addPackage($_POST);
           if( $responseData[0] == '1')
            {
                    $okmsg = base64_encode(" Package added  Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to add Package, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		