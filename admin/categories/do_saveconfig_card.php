<?php
//var_dump($_REQUEST);
extract($_REQUEST);
$card_settings = array();
for ( $i = 1; $i <= $blocksCounter; $i++ ) {
	$data = array();
	
	$data[$i]['content_container_dimension'] = $content_container_dimension[$i];
	$data[$i]['content_container_position'] = $content_container_position[$i];
	$data[$i]['text_alignment_style'] = $text_alignment_style[$i];
	$data[$i]['line_height'] = $line_height[$i];
	$data[$i]['font_size'] = $font_size[$i];
	$data[$i]['font_items'] = $font_items[$i];
	$data[$i]['font_color'] = $font_color[$i];
	$data[$i]['defaults'] = $defaults[$i];
	$card_settings[] = $data[$i];
}


$serialize_settings = serialize($card_settings);

include("../config/conf.php");
include("../classes/upload_class.php");
include("../lib/photo.upload.php");
include( "../lib/func.categories.card.php" );
       
$responseData = saveCard_config( $card_id, $serialize_settings );

if( $responseData[0] == '1') {
	$okmsg = base64_encode(" Information Updated Successfully. ");
	echo "<script> window.location = 'card_config.php?card_id={$card_id}&okmsg={$okmsg}';</script>";
} else {
	$errmsg = base64_encode(" Unable to update, please try again later. ");
	echo "<script> window.location = 'card_config.php?card_id={$card_id}&errmsg={$errmsg}';</script>";
}