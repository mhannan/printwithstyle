<?php
include("../config/conf.php");
include("../classes/upload_class.php");
include("../lib/photo.upload.php");
include( "../lib/func.categories.card.php" );

if( add_price_per_quantity($_POST)) {
	$okmsg = base64_encode("Quantity Price added Successfully.");
	echo "<script> window.location = 'card_config.php?card_id=".$_POST['card_id']."&okmsg=$okmsg';</script>";
} else {
	$errmsg = base64_encode(" Unable to add Quantity Price, card quantity or price could not be empty, please try again later. ");
	echo "<script> window.location = 'card_config.php?card_id=".$_POST['card_id']."&errmsg=$errmsg';</script>";
}