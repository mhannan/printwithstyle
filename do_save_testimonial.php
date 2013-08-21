<?php
include("config/config.php");
//include("admin/classes/upload_class.php");
//include("admin/lib/photo.upload.php");

include('lib/func.testimonial.php');


	
        if(save_testimonial($_SESSION['user_id'], $_POST['testimonialTxt']))
        {
             
                 $str = base64_encode('Thank you for writing your testimonial, it has been sent for approval.');
                 header('Location: index.php?p=testimonials&msg=succ&str='.$str); exit;
             
             
        }
        else
             $str = base64_encode('Sorry! unable to post your testimonial. please try again later');
             header('Location: index.php?p=testimonials&msg=err&str='.$str); exit;
	
?>    
