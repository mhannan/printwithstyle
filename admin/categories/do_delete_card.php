<?php
       include("../config/conf.php");
       
       include( "../lib/func.categories.card.php" );

            if( deleteCard($_REQUEST['card_id']) )
            {
                    $okmsg = base64_encode(" Card Deleted Successfully. ");
                    echo "<script> window.location = 'cards.php?cat_id=".$_REQUEST['cat_id']."&okmsg=$okmsg';</script>";
            }
            else {

                    $errmsg = base64_encode(" Unable to Delete, please try again later. ");
                    echo "<script> window.location = 'cards.php?cat_id=".$_REQUEST['cat_id']."&errmsg=$errmsg';</script>";
            }
		
				
	 
?>		