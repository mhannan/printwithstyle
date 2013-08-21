<?php
include("config/config.php");
include("admin/classes/upload_class.php");
include("admin/lib/photo.upload.php");

include('lib/func.designevent.php');
	
	
        if(submit_event_design($_POST))
        {
             
                 $str = base64_encode('Thankyou for participating and submiting your design. We shall let you know if your design stands out for the winning design.');
                 header('Location: index.php?p=be_designer&msg=succ&str='.$str); exit;
             
             
        }
        else
             $str = base64_encode('Sorry! unable to submit your design. please try again later');
             header('Location: index.php?p=be_designer&msg=err&str='.$str); exit;
	
?>    
