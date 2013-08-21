<?
function uploadFile($UploadDir_path, $PhotoNameHandler, $new_name2) {
	$my_upload2 = new file_upload;
	$my_upload2 -> upload_dir = $UploadDir_path;
	$my_upload2 -> extensions = array(".ttf");
	$my_upload2 -> max_length_filename = 150;
	$my_upload2 -> rename_file = true;
	$my_upload2 -> the_temp_file = $PhotoNameHandler['tmp_name'];
	$my_upload2 -> the_file = $PhotoNameHandler['name'];
	$my_upload2 -> http_error = $PhotoNameHandler['error'];
	$my_upload2 -> file_size = $PhotoNameHandler['size'];

	if ($my_upload2 -> check_file_size($my_upload2 -> file_size)) {
		if ($my_upload2 -> upload($new_name2)) {
			$full_path2 = $my_upload2 -> upload_dir . $my_upload2 -> file_copy;
			$info2 = $my_upload2 -> get_uploaded_video_file_info($full_path2);
		}
	}

	$abc2 = explode(" ", $info2);
	$pos2 = strpos($abc2[2], "File");
	$image_name = substr($abc2[2], 0, $pos2 - 1);
	return $image_name;
}

function make_thumb($source_imagePath, $dest_imagePath, $new_w, $new_h) {
	$ext = getExtension($source_imagePath);
	list($img_width, $img_height) = getimagesize($source_imagePath);
	if (($img_width <= $new_w) && ($img_height <= $new_h)) {
		copy($source_imagePath, $dest_imagePath);
		return true;
	}
	
	if (!strcmp("jpg", $ext) || !strcmp("jpeg", $ext))
		$src_img = imagecreatefromjpeg($source_imagePath);

	if (!strcmp("png", $ext))
		$src_img = imagecreatefrompng($source_imagePath);

	if (!strcmp("gif", $ext))
		$src_img = imagecreatefromgif($source_imagePath);

	$old_x = imageSX($src_img);
	$old_y = imageSY($src_img);

	// next we will calculate the new dimmensions for the thumbnail image
	// the next steps will be taken:
	// 	1. calculate the ratio by dividing the old dimmensions with the new ones
	//	2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
	//		and the height will be calculated so the image ratio will not change
	//	3. otherwise we will use the height ratio for the image
	// as a result, only one of the dimmensions will be from the fixed ones
	$ratio1 = $old_x / $new_w;
	$ratio2 = $old_y / $new_h;
	if ($ratio1 > $ratio2) {
		$thumb_w = $new_w;
		$thumb_h = $old_y / $ratio1;
	} else {
		$thumb_h = $new_h;
		$thumb_w = $old_x / $ratio2;
	}

	// we create a new image with the new dimmensions
	$dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);

	// resize the big image to the new created one
	imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);

	// output the created image to the file. Now we will have the thumbnail into the file named by $filename
	if (!strcmp("png", $ext))
		imagepng($dst_img, $dest_imagePath);
	else if (!strcmp("gif", $ext))
		imagegif($dst_img, $dest_imagePath);
	else
		imagejpeg($dst_img, $dest_imagePath);
}

// This function reads the extension of the file.
// It is used to determine if the file is an image by checking the extension.
function getExtension($str) {
	$i = strrpos($str, ".");
	if (!$i) {
		return "";
	}
	$l = strlen($str) - $i;
	$ext = substr($str, $i + 1, $l);
	return $ext;
}