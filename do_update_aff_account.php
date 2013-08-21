<?php
@session_start();
include("config/config.php");
//include("admin/classes/upload_class.php");
//include("admin/lib/photo.upload.php");

include('lib/func.user.php');


	
        if(update_affiliate_account($_POST))
        {
             
            $str = base64_encode('Account information has been updated successfully');
           // print_r($_SESSION);
            header('Location: index.php?p=aff_dashboard&msg=succ&str='.$str); exit;
             
             
        }
        else{
             $str = base64_encode('Sorry! invalid login information entered.');
             header('Location: index.php?p=affiliate&action=login&msg=err&str='.$str); exit;
        }
	
?>    
