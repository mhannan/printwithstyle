<?php
include("../config/config.php");
//include("admin/classes/upload_class.php");
//include("admin/lib/photo.upload.php");

include('../lib/func.user.php');


	
        if(recoverPswd($_POST['email']))
        {
             
            echo "<div style='padding:3px; border:1px dashed #5d9800;color:#5d9800; background-color:#dbf3b5'>Password recovery email sent at your email. Please check your mailbox</div>";
             
             
        }
        else
             echo "<div style='padding:3px; border:1px dashed #980000;color:#980000; background-color:#fbcdcd'>Sorry, system is unable to match any account with your provided email</div>";
	
?>    
