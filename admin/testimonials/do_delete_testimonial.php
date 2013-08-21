<?php
       include("../config/conf.php");
       
       include( "../lib/func.testimonial.php" );

            if( deleteTestimonial($_REQUEST['testimonial_id']) )
            {
                    $okmsg = base64_encode(" The Testimonial Deleted Successfully. ");
                    echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to Delete, please try again later. ");
                    echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
            }
		
				
	 
?>		