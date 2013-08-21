<?php
if ( !isset( $_REQUEST['position'] ) ) {
	die("ALLAH-O-AKBAR");
}

header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-store, no-cache, must-revalidate" );
header( "Cache-Control: post-check=0, pre-check=0", false );
header( "Pragma: no-cache" );
include 'config/config.php';

$data = $_REQUEST;
$sql = "SELECT cat_id, card_bg_path, card_settings FROM " . TBL_CARDS . " WHERE card_id = {$data['item_id']}";
$card_data = mysql_query($sql) or die (" $sql <br/>". mysql_error());

if ( !mysql_num_rows( $card_data ) ) { die('wrong data'); }

$card_data = mysql_fetch_object( $card_data );

$card_settings = unserialize($card_data->card_settings);

$total_boxes = count( $card_settings );

for ( $i = 0; $i < $total_boxes; $i++ ) {
	$dimensions = explode( '_', $card_settings[$i]['content_container_dimension'] );
	$o_w[] = $dimensions[0];
	$o_h[] = $dimensions[1];
	$position = explode( '_', $card_settings[$i]['content_container_position'] );
	$_x[] = $position[0];
	$_y[] = $position[1];
}

$_path = BLANK_CARDS . "$card_data->card_bg_path";

$_str =  $data['e_box'];
$_txt_size = $data['font_size']; 
$_align = $data['font_align']; 
$_font_family = $data['font_style'];
$_color_hex = $data['font_color'];
$_lh = $data['line_height'];
//var_dump($_txt_size, $_align, $_font_family);

/* get the image extension */
$ext = strtolower( end( explode( '.', $_path ) ) );
if ($ext == 'jpg' || $ext == 'jpeg' ) {
	$card = imagecreatefromjpeg( $_path );
} else if ( $ext == 'png' ) {
	$card = imagecreatefrompng( $_path );
} else if ( $ext == 'gif' ) {
	$card = imagecreatefromgif( $_path );
} else {
	die('wrong type');
}
$temp = array();
foreach($_str as $st ){
	$st = urldecode($st);
	$st = nl2br($st);
	
	$st = explode("<br />", $st);
	$temp = array_merge($temp, $st);
}

//var_dump($total_boxes);
//die;
for( $i = 0; $i < $total_boxes; $i++ ) {
	
	$txt = nl2br($_str[$i]); // text
	//var_dump($_txt_size[$i]);
	$_t_size = (float)str_replace("px", '', $_txt_size[$i]); // text size
	$txt_size = (float)$_t_size * 0.75; // text size
	$t_align = strtolower($_align[$i]); // alignment 
	$font_family = FONTS_PATH . urldecode( strtolower($_font_family[$i]) ); // font name 
	$color_hex = $_color_hex[$i]; // text color
	$_w = (int)$o_w[$i]; // image width 
	$_h = (int)$o_h[$i]; // image height 
	//$_lh = isset( $_REQUEST['lh'] ) && $_REQUEST['lh'] != 'undefined' ? $_REQUEST['lh'] : 20;
	
	/* check for text height width */
	$txt_process = explode("<br />", $txt );
	//var_dump($txt_process);
	$tHeight = $counter = 0;
	foreach ($txt_process as $tp) {
		$temp[] = trim($tp);
		
		$width_box = imagettfbbox($txt_size, 0, $font_family, trim($tp));
		$txtWidth[] = abs( $width_box[4]-$width_box[6] );
		
		if ( $counter == 0 ) {
			/* default y axis for the text */
			$t_y = abs( $width_box[7]-$width_box[1] ); 
		}	
		$counter++;
	}
	
	//var_dump($temp);
	$tWidth = max($txtWidth);
	unset($txt_process);
	unset($temp);
	//var_dump($_w, $tWidth);
	//$_w =  $tWidth > $_w ? $tWidth : $_w;
	
	/* create true color image */
	$tempcard = imagecreatetruecolor($_w, $_h);
	/* some one says, this is required for transparency */
	imagesavealpha($tempcard, TRUE);
	imagealphablending($tempcard, TRUE);
	/* make transparent */
	$trans_colour = imagecolorallocatealpha($tempcard, 0, 0, 0, 127);
	imagefilledrectangle($tempcard, 0, 0, 150, 25, $trans_colour);
	imagefill( $tempcard, 0, 0, $trans_colour );
	/* generate color rgb from hex code */	
	$color = html2rgb( $color_hex );
	$_str_color = imagecolorallocate( $card, $color[0], $color[1], $color[2] );

	$txt = explode( '<br />', $txt );
	//$t_y = 10;
	
	/* loop for each line of exploded text and aligned them */
	$img_width = imagesx( $tempcard );
	
	if ( count($txt) > 4 ) {
		$_lh = $_h / count($txt);
	} else {
		$_lh = 30;
	}
	
	//$_lh = $_lh < 20 ? 20 : $_lh;
	
	foreach( $txt as $t ) {
		$t = trim($t);
		
		$t = stripslashes($t);
		$t = str_replace('\\', '', $t);
		$t = trim( $t );
		$underscores_count = substr_count($t, '_');
		$right_align = FALSE;
		if ( $underscores_count ) {
			$position = '';
			if ( strpos( $t , '_' ) ) { // > 0
				$position = 'end';
			} else { // 0 
				$position = 'start';
			}
			$t = str_replace('_', '', $t); // remove the underscores
			 
			$dimensions = imagettfbbox($txt_size, 0, $font_family, $t);
			$textWidth = abs($dimensions[4] - $dimensions[0]);
			$textHeight = abs( $dimensions[7] - $dimensions[1] ) + 2;
			
			if ( $position == 'start' ) {
				$right_align = TRUE;
				imageline($tempcard, 0, $textHeight, 50, $textHeight, $_str_color);
			} else {
				imageline($tempcard, $textWidth+2, $textHeight, imagesx($card)-1, $textHeight, $_str_color);
			}
			
		} else {
			$dimensions = imagettfbbox($txt_size, 0, $font_family, $t);
			$textWidth = abs($dimensions[4] - $dimensions[0]);
		}
		
		if ( $right_align ) {
			$x = 52;
		} else if ( $t_align == 'right' ) { // right align
			$x =  ($img_width - $textWidth)-5;
		} else if ( $t_align == 'center' ) { // center align
			$x = ceil( ($img_width - $textWidth ) / 2 );
		} else { // left align
			$x = ($img_width - $_w) + 5 ;
		}

		$printed = imagefttext($tempcard, $txt_size, 0, $x, $t_y, $_str_color, $font_family, $t);
		$t_y += $_lh;
	}

	
	//imagerectangle($tempcard, 0,0, imagesx($tempcard)-1, imagesy($tempcard)-1, $_str_color );
	
	$copied = imagecopy( $card, $tempcard, $_x[$i], $_y[$i], 0, 0, $_w, $_h );
	//var_dump($copied);
}
//die;
/* attached uploaded image */
if ( isset( $data['up'] ) ) {
	/* get the image extension */
	$up = urldecode($data['up']);
	$ext = strtolower( end( explode( '.', $up ) ) );
	if ($ext == 'jpg' || $ext == 'jpeg' ) {
		$uploaded = imagecreatefromjpeg( $up );
	} else if ( $ext == 'png' ) {
		$uploaded = imagecreatefrompng( $up );
	} else if ( $ext == 'gif' ) {
		$uploaded = imagecreatefromgif( $up );
	}
	
	if ( $uploaded ) {
		list( $up_width, $up_height ) = getimagesize($up);
		if($card_data->cat_id)		// for saveTheDate card the 4th box is used for image so we pick here 4th box position index from '4th' index that is on [3]
				imagecopy($card, $uploaded, $_x[3], $_y[3], 0, 0, $up_width, $up_height);
		else
				imagecopy($card, $uploaded, $_x[2], $_y[2], 0, 0, $up_width, $up_height);
	}
}
//die;
if ( isset( $_REQUEST['add_to_cart'] ) ) {
	imagepng( $card, CUSTOMER_CARDS . $_REQUEST['add_to_cart'] );
	imagedestroy( $card );	
} else {
	header('Content-type: image/png');
	imagepng( $card );
	imagedestroy( $card );	
}