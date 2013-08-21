<?php
       include("../config/conf.php");
       include("../classes/upload_class.php");
       include("../lib/photo.upload.php");
       include( "../lib/func.categories.card.php" );
       
	
		if( del_price_per_quantity($_GET['item_id']))
		{
			$okmsg = base64_encode(" Quantity Price deleted Successfully. ");
			echo "<script> window.location = 'card_config.php?card_id=".$_GET['card_id']."&okmsg=$okmsg';</script>";
		}
		else {
		
			$errmsg = base64_encode(" Unable to delete Quantity Price, card quantity or price could not be empty, please try again later. ");
			echo "<script> window.location = 'card_config.php?card_id=".$_GET['card_id']."&errmsg=$errmsg';</script>";
		}	
		
				
	 
?>		