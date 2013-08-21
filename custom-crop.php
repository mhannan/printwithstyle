<?php
include 'config/config.php';
if ( !isset( $_REQUEST['pid'] ) ) {
	header( 'Location: ' . siteURL );
	exit;
}
extract($_REQUEST);
//$img = PHOTOS_PATH . $_SESSION['photos'][$pid];
$img = get_thumbnail_name($_SESSION['photos'][$pid], NULL);
$img = PHOTOS_PATH  . $img;	
if ( isset( $cw ) && !empty( $cw ) ) { // cropped and done pressed
	$img_thumb = UPLOAD_PATH . $_SESSION['photos'][$pid];
	$img_thumb = get_thumbnail_name($img_thumb, 200);
	
	/* get the image extension */
	$ext = strtolower( end( explode( '.', $img ) ) );
	if ($ext == 'jpg' || $ext == 'jpeg' ) {
		$img_r = imagecreatefromjpeg( $img );
	} else if ( $ext == 'png' ) {
		$img_r = imagecreatefrompng( $img );
	} else if ( $ext == 'gif' ) {
		$img_r = imagecreatefromgif( $img );
	} else {
		die('wrong type');
	}

	$w = (int)round($w);
	$h = (int)round($h);
	
	$dst_r = imagecreatetruecolor( $w, $h );
	imagesavealpha($dst_r, TRUE);
	imagealphablending($dst_r, TRUE);
	$trans_colour = imagecolorallocatealpha($dst_r, 255, 255, 255, 127);
	imagefilledrectangle($dst_r, 0, 0, $cw, $ch, $trans_colour);
	imagefill( $dst_r, 0, 0, $trans_colour );
	
	imagecopyresampled( $dst_r, $img_r, 0, 0, $x, $y, $w, $h, $cw, $ch );
	
	
	
	if ($ext == 'jpg' || $ext == 'jpeg' ) {
		imagejpeg( $dst_r, $img_thumb, 90 );
	} else if ( $ext == 'png' ) {
		imagepng( $dst_r, $img_thumb );
	} else if ( $ext == 'gif' ) {
		imagegif( $dst_r, $img_thumb );
	}
	
	header( 'Location: ' . siteURL . "custom-photo.php?w={$w}&h={$h}&card_w={$card_w}&card_h={$card_h}" );
	exit;	
}

$loading_url = siteURL . 'images/loading_image.gif';
echo "<img src='$loading_url' alt='tt' style='display:none; visibility: hidden;' />";


?>
<link href="<?php echo siteURL;?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/scriptaculous.js"></script>
<script type="text/javascript" src="<?php echo siteURL;?>js/cropper.js"></script>
<link href="<?php echo siteURL;?>js/cropper.css" rel="stylesheet" type="text/css" />
<script type='text/javascript'>
	function SaveCoords(c, d) {
		$('x').value = c.x1;
		$('y').value = c.y1;
		$('new_w').value = d.width;
		$('new_h').value = d.height;
	};
	
	Event.observe( 
		window, 
		'load', 
		function() { 
			new Cropper.ImgWithPreview( 
				'dss',
				{ 
					minWidth: <?php echo $w;?>, 
					minHeight: <?php echo $h;?>,
					ratioDim: { x: <?php echo $w;?>, y: <?php echo $h;?> },
					displayOnInit: true, 
					onEndCrop: SaveCoords,
					previewWrap: 'preview'
				} 
			) 
		} 
	);
	
	
</script>
<div class="popup_content" style="width: 790px;">
	<ul class="return_address" style="width: 790px;">
		<li>
			<h3 style='width: 790px'>
				Crop Photo
				<!-- <a style='cursor: pointer;' id='resize_plus'>+</a>&nbsp;
				<a style='cursor: pointer;' id='resize_minus'>-</a> -->
			</h3>
			<div id="preview" style="position: fixed; top: 50px; right: 20px; z-index: 1000; display: none; visibility: hidden;"></div>
			<div style='width: 790px; height: 590px; overflow: auto;'>
			<img src="<?php echo $img;?>" alt="Design Soft Studios" id="dss" />
			</div>
		</li>
		<li>
			<form action="" method="post" name="frm_crop" id="frm_crop">
				<input type='hidden' id='ratio' value='1' />
				<input type="hidden" name="cropped" value="cropped" />
				<input type="hidden" name="w" value="<?php echo $w;?>" />
				<input type="hidden" name="h" value="<?php echo $h;?>" />
				<input type="hidden" name="x" id="x" value="0" />
				<input type="hidden" name="y" id="y" value="0" />
				<input type="hidden" name="cw" id="new_w" value="0" />
				<input type="hidden" name="ch" id="new_h" value="0" />
				<input type="submit" class="btn_normal" value="Done" />
			</form>
			<a href="<?php echo siteURL . "custom-photo.php?w={$w}&h={$h}&card_w={$card_w}&card_h={$card_h}";?>" class="btn_normal" style="padding-top: 5px; text-align: center;" >Cancel</a>
		</li>
	</ul>
</div> <!-- popup_wrapp -->


