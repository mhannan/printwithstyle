<?php
include 'config/config.php';
if ( !isset( $_REQUEST['pid'] ) ) {
	header( 'Location: ' . siteURL );
	exit;
}
extract($_REQUEST);
$img = PHOTOS_PATH . $_SESSION['photos'][$pid];

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

	$cw = (int)round($cw);
	$ch = (int)round($ch);
	
	$dst_r = imagecreatetruecolor( $cw, $ch );
	imagesavealpha($dst_r, TRUE);
	imagealphablending($dst_r, TRUE);
	$trans_colour = imagecolorallocatealpha($dst_r, 255, 255, 255, 127);
	imagefilledrectangle($dst_r, 0, 0, $cw, $ch, $trans_colour);
	imagefill( $dst_r, 0, 0, $trans_colour );
	
	imagecopyresampled( $dst_r, $img_r, 0, 0, $x, $y, $cw, $ch, $cw, $ch );
	
	
	
	if ($ext == 'jpg' || $ext == 'jpeg' ) {
		imagejpeg( $dst_r, $img_thumb, 90 );
	} else if ( $ext == 'png' ) {
		imagepng( $dst_r, $img_thumb );
	} else if ( $ext == 'gif' ) {
		imagegif( $dst_r, $img_thumb );
	}
	
	header( 'Location: ' . siteURL . "custom-photo.php?w={$w}&h={$h}" );
	exit;	
}

$loading_url = siteURL . 'images/loading_image.gif';
echo "<img src='$loading_url' alt='tt' style='display:none; visibility: hidden;' />";


?>
<link href="<?php echo siteURL;?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo siteURL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo siteURL;?>js/jquery.Jcrop.min.js"></script>
<link href="<?php echo siteURL;?>js/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#done").live ('click', function(){
			document.frm_crop.submit();
			return false;
		});
		var jcrop_api = null;
		
		
		var initJcrop = function() { $('#dss').Jcrop({
			aspectRatio: <?php echo $w;?>/<?php echo $h;?>,
			allowMove: true,
			allowSelect: true,
			allowResize: true,
			minSize: [ 10, 10 ],
			maxSize: [ <?php echo $w;?>, <?php echo $h;?> ],
			onChange: SaveCoords,
			onSelect: SaveCoords
			},
			function(){
				jcrop_api = this;}
			);
		};
		initJcrop();
		function SaveCoords(c) {
			$('#x').val(c.x);
			$('#y').val(c.y);
			$('#w').val(c.w);
			$('#h').val(c.h);
		};
		
		var resize_image = function(src, ratio) {
			jcrop_api.destroy();
			$.post(
				"<?php echo siteURL;?>process-image.php",
				{
					action : 'rp',
					ratio : ratio,
					src : "<?php echo $img; ?>"
				},
				function() {
					var img = new Image();
					img.onload = function() {
						var height = this.height;
						var width = this.width;
						
						$('img#dss')
						.attr('src', src + '?' + Math.random())
						.css({
							"width" : width,
							"height" : height
						});
						$("div.jcrop-holder").find('img')
						.attr('src', src + '?' + Math.random())
						.css({
							"width" : width,
							"height" : height
						});
						
						$("div.jcrop-tracker, div.jcrop-holder").css({
							"width" : width,
							"height" : height
						});
						
					};
					img.src = src + '?' + Math.random();
					initJcrop();
				}
			);
		};
		$("a#resize_plus").live ("click", function() {
			var src = $('img#dss').attr('src'); 
			queryPos = src.indexOf('?');
			if( queryPos != -1 ) {
				src = src.substring(0, queryPos);
			}
			$('img#dss').attr('src', '<?php echo $loading_url;?>'); // temporary loading image
			/* get current ratio */ 
			var ratio = parseFloat($("#ratio").val())  + 0.1;
			/* pass it to function to generate the image */
			resize_image(src, ratio);
			/* update the ratio */
			var new_ratio = parseFloat(ratio);
			$("#ratio").val(new_ratio);
		});
		
		$("a#resize_minus").live ("click", function() {
			var src = $('img#dss').attr('src'); 
			queryPos = src.indexOf('?');
			if( queryPos != -1 ) {
				src = src.substring(0, queryPos);
			}
			$('img#dss').attr('src', '<?php echo $loading_url;?>'); // temporary loading image
			/* get current ratio */ 
			var ratio = parseFloat($("#ratio").val()) - 0.1;
			/* pass it to function to generate the image */
			resize_image(src, ratio);
			/* update the ratio */
			var new_ratio = parseFloat(ratio);
			$("#ratio").val(new_ratio);
		});
	});
</script>
<div class="popup_content" style="width: 890px;">
	<ul class="return_address" style="width: 890px;">
		<li>
			<h3 style='width: 890px'>
				Crop Photo
				<!-- <a style='cursor: pointer;' id='resize_plus'>+</a>&nbsp;
				<a style='cursor: pointer;' id='resize_minus'>-</a> -->
				
			</h3>
			<img src="<?php echo $img;?>" alt="Design Soft Studios" id="dss" />
		</li>
		<li>
			<form action="" method="post" name="frm_crop" id="frm_crop">
				<input type='hidden' id='ratio' value='1' />
				<input type="hidden" name="cropped" value="cropped" />
				<input type="hidden" name="w" value="<?php echo $w;?>" />
				<input type="hidden" name="h" value="<?php echo $h;?>" />
				<input type="hidden" name="x" id="x" value="0" />
				<input type="hidden" name="y" id="y" value="0" />
				<input type="hidden" name="cw" id="w" value="0" />
				<input type="hidden" name="ch" id="h" value="0" />
				<input type="submit" class="btn_normal" value="Done" />
			</form>
			<a href="<?php echo siteURL . "custom-photo.php?w={$w}&h={$h}";?>" class="btn_normal" style="padding-top: 5px; text-align: center;" >Cancel</a>
		</li>
	</ul>
</div> <!-- popup_wrapp -->