<?php
@session_start();
include("config/config.php");
//include("admin/classes/upload_class.php");
//include("admin/lib/photo.upload.php");

include('lib/func.user.php');


	
        if(recoverPswd($_POST['your_email']))
        {
             
            $str = base64_encode('Your password has been recovered. An email has been sent over your email with details.');
           // print_r($_SESSION);
            header('Location: index.php?p=login&msg=succ&str='.$str); exit;
             
             
        }
        else{
             $str = base64_encode('Sorry! no record exists against the email.');
             header('Location: index.php?p=login&msg=err&str='.$str); exit;
        }
	
?>    
