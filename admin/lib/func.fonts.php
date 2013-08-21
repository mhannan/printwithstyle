<?php
function addFont($post) {
	extract($post);
	$font_title = mysql_real_escape_string($font_title);
	$fontFileName = '';
	if ($_FILES['font_file']["name"]) {
		$fileNameHandler = $_FILES['font_file']["name"];
		$file_newName = strtolower(str_replace(' ', '_', $font_title)) . '___' . date("mdyHis");
		$fontFileName = uploadFile('../../fonts/', $_FILES['font_file'], $file_newName);
	}
	$sql_1 = sprintf("INSERT INTO fonts  SET   font_label = '%s',   font_path = '%s'", $font_title, $fontFileName);

	$returnData = array();
	if (mysql_query($sql_1) or die(mysql_error())) {
		$okmsg = base64_encode("Information successfully added");
		$returnData[0] = "1";
		$returnData[1] = $okmsg;
	} else {
		$errmsg = base64_encode("Unable to update information due to : " . mysql_error());
		$returnData[0] = "0";
		$returnData[1] = $errmsg;
	}
	return $returnData;
}

function getFonts() {
	$sql = "SELECT * FROM fonts";
	$rSet = mysql_query($sql);
	return $rSet;
}

function generate_font_preview_by_ttf($font_id, $font_text, $font, $delete) {
	@header('Content-Type: image/png');
	$txt_size = 14;
	$rect = imagettfbbox($txt_size, 0, $font, $font_text);
	$tWidth = abs($rect[4] - $rect[6]);
	$tHeight = abs($rect[7] - $rect[1]);

	$im = imagecreatetruecolor($tWidth, 25);
	imagesavealpha($im, TRUE);
	imagealphablending($im, TRUE);
	/* make transparent */
	$black = imagecolorallocate($im, 0, 0, 0);
	imagefilledrectangle($im, 0, 0, 150, 25, $black);
	$trans_colour = imagecolorallocatealpha($im, 0, 0, 0, 127);
	imagefill($im, 0, 0, $trans_colour);
	/* add text to image */
	imagettftext($im, $txt_size - 2, 0, 0, 15, $black, $font, $font_text);

	$font_preview_fileName = str_replace(' ', '', $font_text) . '.png';
	$font_image_preview_file_name_with_path = '../../fonts/previews/' . $font_preview_fileName;
	/* save as the image as transparent png*/
	imagepng($im, $font_image_preview_file_name_with_path);
	imagedestroy($im);
	/* release the memory */

	echo "<img src='" . $font_image_preview_file_name_with_path . "' height='auto'>";
	/* update the image preview path to database */
	$sql = "UPDATE fonts SET font_preview_image ='{$font_preview_fileName}' WHERE font_id='{$font_id}'";
	mysql_query($sql);
}