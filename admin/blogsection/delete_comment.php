<?php
       include("../config/conf.php");
       include( "../lib/func.blogsection.php" );
	   
	   
            if( deleteComments($_REQUEST) )
            {
                    $okmsg = base64_encode(" Comment Deleted Successfully. ");
                    echo "<script> window.location = 'comments_section.php?articleId=".$_GET['article_id']."&okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to Delete, please try again later. ");
                    echo "<script> window.location = 'comments_section.php?articleId=".$_GET['article_id']."&errmsg=$errmsg';</script>";
            }
		
				
	 
?>		