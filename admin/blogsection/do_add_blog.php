<?php

ob_start();
session_start();


       include("../config/conf.php");
       include( "../lib/func.blogsection.php" );
       include("../classes/upload_class.php");
       include("../lib/photo.upload.php");

            if( addBlogArticle($_POST) )
            {
                    $okmsg = base64_encode(" New articles added  Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to add article, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		