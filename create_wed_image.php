<?php
header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-store, no-cache, must-revalidate" );
header( "Cache-Control: post-check=0, pre-check=0", false );
header( "Pragma: no-cache" );

include 'config/config.php';
error_reporting(E_ALL);
extract($_REQUEST);

/* define variables */
$original_txt = $original_txt_br = $temp = $couple = array();

/* save original text and exploded array */
foreach($texts as $tt) {
	$tt = nl2br(urldecode( $tt ) );
	$original_txt[] = $tt;
	$original_txt_br[] = explode('<br />', $tt );
}

/* 0 => font-style, 1 => font-size, 2 => color, 3 => align */
foreach( $main as $mt ) {
	$temp[] = urldecode( $mt );
}
$main = $temp;
unset($temp);

/* 0 => font-style, 1 => font-size, 2 => color, 3 => align */
foreach( $couples as $ct ) {
	$temp[] = urldecode( $ct );
}
$couple = $temp;
unset($temp);

/* count total rows */
$total_box_1 = count($original_txt_br[0]); /* first text block */ 
$total_box_2 = count($original_txt_br[1]); /* bride / groom text block */
$bride_row = -1;
$groom_row = -1;

if ( !empty( $original_txt_br[1][0] ) ) { /* means there is not bride / groom text block */
	/* bride row will be at first text block count */
	$bride_row = (int)$total_box_1;
	/* groom row either next to bride_row or next + 1 (AND) row */
	$groom_row = $total_box_2 > 2 ? (int)$bride_row + 2 : (int)$bride_row + 1;
}

/* implode the original text by <br /> (nl2br) generate <br /> tag and then explode it with the same */
$txt_process = explode( '<br />', implode('<br />', $original_txt ) );


/* remove extra spaces from each line and get each line ttfbox width to be use for imagecreatetruecolor */
$counter = $bride_groom_h = $y = 0;
foreach ($txt_process as $tp) {
	$temp[] = trim($tp);
	if ( $counter == $bride_row || $counter == $groom_row ) {
		$font_style = FONTS_PATH . strtolower( $couple[0] );
		$font_size = $couple[1];
	} else {
		$font_style = FONTS_PATH . strtolower( $main[0] );
		$font_size = $main[1];
	}
	
	$width_box = imagettfbbox($font_size, 0, $font_style, trim($tp));
	$txtWidth[] = abs( $width_box[4]-$width_box[6] );
	if ( $counter == 0 ) {
		/* default y axis for the text */
		$y = abs( $width_box[7]-$width_box[1] ); 
	} else if ( $counter == $bride_row ) {
		$bride_groom_h = abs( $width_box[7]-$width_box[1] );
	}
	
	$counter++;
}

$tWidth = max($txtWidth);
$txt_process = $temp;
unset($temp);

$w =  $tWidth > $w ? $tWidth : $w;

/* create true color image with the provided height and calculated width */
$card = imagecreatetruecolor( $w, $h );
/* some one says, this is required for transparency */
imagesavealpha($card, TRUE);
imagealphablending($card, TRUE);
$transparent = imagecolorallocatealpha($card, 0, 0, 0, 127);
imagefilledrectangle($card, 0, 0, imagesx($card), imagesy($card), $transparent);
imagefill( $card, 0, 0, $transparent );

/* temporary border */
//imagerectangle($card, 0,0, imagesx($card)-1, imagesy($card)-1, imagecolorallocate($card, 0, 0, 0) );

/* get total rows of exploded original texts */
$total_rows = count( $txt_process );

/* this will be use for alignment */
$img_width = imagesx( $card );
/* default x axis for the text */
$x = 5 ;

/* set line height, provided height divided by total rows + 2 for bride / groom */
$lh = $h / $total_rows + 2 ;
$lh = $lh < 30 ? 30 : $lh;
$lh-=2;
/* start the loop on each text row */
for( $i = 0; $i < $total_rows; $i++ ) {
	$t = $txt_process[$i];
	/* define required variables */
	$image_txt_font = '';
	$image_txt_size = '';
	$cur_color = '';
	
	if ( $i == $bride_row || $i == $groom_row ) { /* bride groom row */ 
		$image_txt_font = FONTS_PATH . strtolower( $couple[0] ); /* font-file */
		$image_txt_size = $couple[1]; /* font size */
		$y = $i == $bride_row ? ($y + $lh/5) : $y + ($lh/10); /* increase y axis by 5 in case of bride row */
		$_c = html2rgb( $couple[2] ); /* color code */
		$cur_color = imagecolorallocate( $card, $_c[0], $_c[1], $_c[2] );
		$_align = $couple[3]; /* alignment */
	} elseif ( $i > $bride_row && $i < $groom_row ) { /* and row */
		$image_txt_font = FONTS_PATH . strtolower( $main[0] ); /* font-file */
		$image_txt_size = $main[1]; /* font-size */
		$y = $y - 5; /* decreate the y axis by 15 after bride row and before groom row */
		$_c = html2rgb( $main[2] ); /* color code */
		$cur_color = imagecolorallocate( $card, $_c[0], $_c[1], $_c[2] );
		$_align = $couple[3]; /* alignment */
	} 
	else { /* other rows */ 
		$image_txt_font = FONTS_PATH . strtolower( $main[0] ); /* font-file */
		$image_txt_size = $main[1]; /* font-size */
		$_c = html2rgb( $main[2] ); /* color code */
		$cur_color = imagecolorallocate( $card, $_c[0], $_c[1], $_c[2] );
		$_align = $main[3]; /* alignment */
	}
	
	/* get the dimensions for the current text line */
	$dimensions = imagettfbbox($image_txt_size, 0, $image_txt_font, $t);
	$line_Width = abs( $dimensions[4] - $dimensions[0] ); /* this will be used for alignment */
	
	if ( $_align == 'right' ) { /* right align */
		/* image with minus line width - 5 for space from border */
		$x =  ( $img_width - $line_Width ) - 5;
	} else if ( $_align == 'center' ) { /* center align */
		/* get the ceiling of image width minus line width divided by two */
		$x = ceil( ( $img_width - $line_Width ) / 2 );
	} else { /* left align */
		/* image width minus calculated width plus 5 for space from broder */
		$x = ( $img_width - $w ) + 5 ;
	}
	/* write text to image with font-size, x point, y point, color, font-file, text */
	imagettftext($card, $image_txt_size, 0, $x, $y, $cur_color, $image_txt_font, $t);
	
	//imagefttext($card, $image_txt_size, 0, $x, $y, $cur_color, $image_txt_font, $t);
	/* increase the y axis with calculated line height */
	$y = $lh + $y;
}
//die;
header('Content-type: image/png');
imagepng( $card );
imagedestroy( $card );
exit;