<?php
       include("../config/conf.php");
       include( "../lib/func.paper.php" );

       $responseData = addPaper($_POST);
           if( $responseData[0] == '1')
            {
                    $okmsg = base64_encode(" Paper added  Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to add Paper, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		