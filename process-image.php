<?php
if ( !isset( $_POST['action'] ) || empty( $_POST['action']) ) { die("ALLAH-O-AKBAR"); }
header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-store, no-cache, must-revalidate" );
header( "Cache-Control: post-check=0, pre-check=0", FALSE );
header( "Pragma: no-cache" );
include 'config/config.php';

extract($_REQUEST);
$src = end( explode( '/', $src ) );
$img = UPLOAD_PATH . $src;

$ext = strtolower( end( explode( '.', $img ) ) );
if ($ext == 'jpg' || $ext == 'jpeg' ) {
	$img_s = imagecreatefromjpeg( $img );
} else if ( $ext == 'png' ) {
	$img_s = imagecreatefrompng( $img );
} else if ( $ext == 'gif' ) {
	$img_s = imagecreatefromgif( $img );
} else {
	die('wrong type');
}
	
switch ($action) {
	case 'rp' : {
		list( $width, $height ) = getimagesize($img);
		$newwidth = $width * $ratio;
		$newheight = $height * $ratio;
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = $img_s;
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		break;
	}
	default: {
		die("Invalid");
	}
}

if ($ext == 'jpg' || $ext == 'jpeg' ) {
	imagejpeg($thumb, $img);
} else if ( $ext == 'png' ) {
	imagepng($thumb, $img);
} else if ( $ext == 'gif' ) {
	imagegif($thumb, $img);
} 
