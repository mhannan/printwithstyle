<?php
@session_start();
include("config/config.php");
//include("admin/classes/upload_class.php");
//include("admin/lib/photo.upload.php");

include('lib/func.user.php');


	
        if(add_favorite($_GET['url']))
        {
             
            $str = base64_encode('Item added successfully in your favorites');
           // print_r($_SESSION);
            header('Location: '.base64_decode($_GET['url']).'&msg=succ&str='.$str); exit;
             
             
        }
        else{
             $str = base64_encode('Sorry! unable to add item in favorites please try again later.');
             header('Location: '.base64_decode($_GET['url']).'&msg=err&str='.$str); exit;
        }
	
?>