<?php
        include("../config/conf.php");
       include( "../lib/func.blogsection.php" );
	   
	   
            if( deleteBlogArticle($_REQUEST) )
            {
                    $okmsg = base64_encode(" Article Deleted Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to Delete, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		