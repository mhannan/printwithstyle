<?php
include("../config/conf.php");

//require_once('../lib/func.common.php');
require_once('../lib/func.blogsection.php');
//require_once('../lib/func.create_user_account.php');
	   
	 $responseData = updateBlogCommentStatus($_POST);
		
		//var_dump($responseData);
	//	exit;
		if( $responseData[0] == '1')
		{	
			$articleId=$_REQUEST['callbackId'];
			$okmsg = base64_encode(" Comment status updated Successfully. ");
			echo "<script> window.location = 'comments_section.php?articleId=$articleId&okmsg=$okmsg';</script>";
		}
		else {
		$articleId=$_REQUEST['callbackId'];
			$errmsg = base64_encode(" Unable to update status, please try again later. ");
			echo "<script> window.location = 'comments_section.php?articleId=$articleId&errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		