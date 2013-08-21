<?php
if (!isset($_REQUEST['t'])) {
	die("ALLAH-O-AKBAR");
}
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include 'config/config.php';
$txt = nl2br(urldecode($_REQUEST['t']));
// text
$_t_size = (float) urldecode($_REQUEST['s']);
// text size
$_txt_size = (float)$_t_size * 0.75;
// text size
$_align = urldecode($_REQUEST['a']);
// alignment
$_font_family = FONTS_PATH . urldecode(strtolower($_REQUEST['f']));
// font name
$_color_hex = urldecode($_REQUEST['c']);
// text color
$_w = (int) urldecode($_REQUEST['w']);
// image width
$_h = (int) urldecode($_REQUEST['h']);
// image height
$_lh = isset($_REQUEST['lh']) && $_REQUEST['lh'] != 'undefined' ? $_REQUEST['lh'] : 20;
$txt_process = explode("<br />", $txt);
$tHeight = 0;
foreach ($txt_process as $tp) {
	$temp[] = trim($tp);
	$width_box = imagettfbbox($_txt_size, 0, $_font_family, trim($tp));
	$txtWidth[] = abs($width_box[4] - $width_box[6]);
	if ($counter == 0) {
		$t_y = abs($width_box[7] - $width_box[1]);
	}
	$counter++;
}
$tWidth = max($txtWidth);
unset($txt_process);
unset($temp);
$_w = $tWidth > $_w ? $tWidth : $_w;
$card = imagecreatetruecolor($_w, $_h);
imagesavealpha($card, TRUE);
imagealphablending($card, TRUE);
$black = imagecolorallocate($card, 0, 0, 0);
imagefilledrectangle($card, 0, 0, 150, 25, $black);
$trans_colour = imagecolorallocatealpha($card, 0, 0, 0, 127);
imagefill($card, 0, 0, $trans_colour);
$color = html2rgb($_color_hex);
$_str_color = imagecolorallocate($card, $color[0], $color[1], $color[2]);
$txt = explode('<br />', $txt);
$img_width = imagesx($card);
if (count($txt) > 4) {
	$_lh = $_h / count($txt);
} else {
	$_lh = 30;
}

foreach ($txt as $t) {
	$t = trim($t);
	$t = stripslashes($t);
	$t = str_replace('\\', '', $t);
	$t = trim($t);
	$underscores_count = substr_count($t, '_');
	$right_align = FALSE;
	if ($underscores_count) {
		$position = '';
		if (strpos($t, '_')) {
			$position = 'end';
		} else {
			$position = 'start';
		}
		$t = str_replace('_', '', $t);
		$dimensions = imagettfbbox($_txt_size, 0, $_font_family, $t);
		$textWidth = abs($dimensions[4] - $dimensions[0]);
		$textHeight = abs($dimensions[7] - $dimensions[1]) + 2;
		if ($position == 'start') {
			$right_align = TRUE;
			imageline($card, 0, $textHeight, 50, $textHeight, $_str_color);
		} else {
			imageline($card, $textWidth + 2, $textHeight, imagesx($card) - 1, $textHeight, $_str_color);
		}
	} else {
		$dimensions = imagettfbbox($_txt_size, 0, $_font_family, $t);
		$textWidth = abs($dimensions[4] - $dimensions[0]);
	}
	
	if ( $right_align ) {
		$x = 52;
	} else if ($_align == 'right') {
		$x = ($img_width - $textWidth) - 5;
	} else if ($_align == 'center') {
		$x = ceil(($img_width - $textWidth) / 2);
	} else {
		$x = ($img_width - $_w) + 5;
	}
	imagefttext($card, $_txt_size, 0, $x, $t_y, $_str_color, $_font_family, $t);
	$t_y += $_lh;
	$t_y -= 0.5;
}
header('Content-type: image/png');
imagepng($card);
imagedestroy($card);
