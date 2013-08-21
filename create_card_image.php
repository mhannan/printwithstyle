<?php
include 'config/config.php';
$_path = BLANK_CARDS . "1_031512153339.png"; //1_031512153339.jpg
$_str =  array("Together with their parents
Nazli Sanam
and
Sheikh Sobish Imtiaz
request the pleasure of your company
at the celebration of their union",
"on Saturday, the Twenty-Four of October,
Two Thousand and Fifteen
at Half Past Eight in Evening",
"at the Check In, Rohtas Road,
Karachi Company,
Islamabad, Pakistan");

$_x = array( 20, 20, 20);
$_y = array( 20, 175, 275);
$_w = array( 354, 355, 352 );
$_h = array( 136, 86, 123 );
$_txt_size = array(10, 10, 10);
$_align = array( 'Right', 'Center', 'Left' );

$_font_family = array( FONTS_PATH . 'arial.ttf',  FONTS_PATH . 'verdana.ttf',  FONTS_PATH . 'georgia.ttf');
$_color_hex = array( "#00FF00", "#9FB3F2", "#D8F78F");


$card = imagecreatefrompng( $_path );

for( $i = 0; $i <= 2; $i++ ) {
	$color = html2rgb( $_color_hex[$i] );
	$_str_color = imagecolorallocate( $card, $color[0], $color[1], $color[2] );
	
	$temp = imagecreatetruecolor($_w[$i], $_h[$i]);
	imagesavealpha($temp, TRUE);
	imagealphablending($temp, TRUE);
	$black = imagecolorallocate($temp, 0, 0, 0);
	imagefilledrectangle($temp, 0, 0, 150, 25, $black);
	
	$trans_colour = imagecolorallocatealpha($temp, 0, 0, 0, 127);
	imagefill($temp, 0, 0, $trans_colour);
	
	$txt = $_str[$i];
	$txt = str_replace(array( '\n', '\t' ), '', $txt );
	$txt = str_replace( '\r', '<br />', $txt ); 
	$txt = nl2br($txt);
	$txt = explode('<br />', $txt);
	$t_y = 20;
	foreach( $txt as $t ) {
		$t = trim($t);
		$dimensions = imagettfbbox($_txt_size[$i], 0, $_font_family[$i], $t);
		if ( $_align[$i] == 'Right' ) { // right align
			$textWidth = abs($dimensions[4] - $dimensions[0]);
			$x = imagesx( $temp ) - $textWidth;
			imagettftext($temp, $_txt_size[$i], 0, $x-5, $t_y, $_str_color, $_font_family[$i], $t);
		} else if ( $_align[$i] == 'Center' ) { // center align
			$text_width = abs( $dimensions[4] - $dimensions[0] );
			$position_center = ceil( (imagesx( $card ) - $text_width ) / 2 );
			imagettftext($temp, $_txt_size[$i], 0, $position_center, $t_y, $_str_color, $_font_family[$i], $t);
		} else { // left align
			$x = imagesx( $temp ) - $_w[$i];
			imagettftext($temp, $_txt_size[$i], 0, $_x[$i], $t_y, $_str_color, $_font_family[$i], $t);
		}
		$t_y+=20;
	}
	
	imagecopy($card, $temp, $_x[$i], $_y[$i], 0, 0, $_w[$i], $_h[$i]);	
}

header('Content-type: image/png');
imagepng( $card );
imagedestroy( $card );