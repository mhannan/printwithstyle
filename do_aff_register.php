<?php
include("config/config.php");
//include("admin/classes/upload_class.php");
//include("admin/lib/photo.upload.php");

include('lib/func.user.php');


	
        if(register_affiliate($_POST))
        {
             
                 /*$str = base64_encode('Your comment posted successfully');
                 header('Location: index.php?p=thankyou_affiliate&msg=succ&str='.$str); exit;*/
            header('Location: index.php?p=thankyou_affiliate'); exit;
             
             
        }
        else
             $str = base64_encode('Sorry! the user with same email aready exists.');
             header('Location: index.php?p=affiliate&action=reg&msg=err&str='.$str); exit;
	
?>    
