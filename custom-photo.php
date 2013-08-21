<?php
include 'config/config.php';
error_reporting(1);
//unset($_SESSION['photos']);
extract($_REQUEST);

if ( isset($call) && $call == "upload_photo" ) {
	if ( !$_FILES['upload_photo']['error'] ) {
		$file_name = upload_file( $_FILES['upload_photo'], NULL, $w, $h, $card_w, $card_h );
		if ( $file_name ) {
			if ( is_array( $_SESSION['photos'] ) && !in_array($file_name, $_SESSION['photos'] ) ) {
				$_SESSION['photos'][] = $file_name;
			} else if ( !is_array( $_SESSION['photos'] ) ) {
				$_SESSION['photos'][] = $file_name;
			}
			
		}
		
		/* redirect to photo editing page */
		$counter = count($_SESSION['photos'])-1;
		header("Location: custom-crop.php?&w={$w}&h={$h}&card_w={$card_w}&card_h={$card_h}&pid=$counter");
		exit;
	}
}
$_SESSION['photos'] = array_merge(array(), $_SESSION['photos']);
?>
<link href="<?php echo siteURL;?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo siteURL;?>js/jquery.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function(){
		
		jQuery("a.btn_normal").live ('click', function(){
			self.parent.update_photo_strip();
			self.parent.tb_remove();
		});
		
		jQuery("a.delete").live ('click', function() {
			if ( !confirm("Are you sure to delete?") ) {
				return false;
			}
			var $ele = $(this);
			jQuery.post(
				"<?php echo siteURL . "process-ajax.php";?>",
				{
					call : 'delete_uploaded_photos',
					photo : this.id
				},
				function (ret) {
					$ele.parent().parent().remove();
				}
			);
			return false;
		});
		
		$("#btnUpload").live ('click', function() {
			$("#Uploading_image").html("Uploading image. Please wait .... ");
		});
	});
</script>
<div class="popup_content" style='width: 790px'>
	<style type="text/css">
		ul.return_address li table {
			border-left: 1px solid #DEE3E4;
			border-top: 1px solid #DEE3E4;
			clear: both;
			margin: auto;
			padding: 0 !important;
			text-align: left;
			width: 671px;
		}
		ul.return_address li table td {
			border-bottom: 1px solid #DEE3E4;
			border-right: 1px solid #DEE3E4;
			color: #507577;
			font-family: Arial,Helvetica,sans-serif;
			font-size: 12px;
			margin: 0;
			padding: 10px 5px;
			text-align: center;
		}
	</style>
	<ul class="return_address" style='width: 790px'>
		<li>
			<h3 style='width: 790px'>Upload Photo</h3>
			<div class="return_address-section" style="opacity: 1; height: auto; ">
				<div class="return_address-content">
				<form id="frm_upload" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="call" value="upload_photo" />
					<input type="file" name="upload_photo" id="photo" /><br/><br/>
					<em style='margin-left: 20px;'>Upload Photos from your computer (gif, jpg, jpeg, png)</em><br/>
					<span id="Uploading_image" style='font-size: 12px;'></span>
					<input type="submit" value="Upload" id="btnUpload" class="btn_normal" />
				</form>
				</div>
			</div>
		</li>
		<?php if ( is_array( $_SESSION['photos'] ) && count( $_SESSION['photos'] ) ) : ?>
		<li>
			<h3 style='width: 790px'>Uploaded Photo</h3>
			<table style='width: 790px'>
			<?php
			$counter = 0;
			foreach( $_SESSION['photos'] as $p ) {
				
				$path = UPLOAD_PATH . $p;
				
				if ( file_exists( $path ) ) {
					$dimensions = getimagesize( $path );
					$width = $dimensions[0];
					$height = $dimensions[1];
					
					$p2 = get_thumbnail_name($p, 1);
					$src = PHOTOS_PATH . $p2 . "?" . time();

					?>
					<tr>
						<td width="131">
							<a href="<?php echo siteURL;?>custom-crop.php?pid=<?php echo $counter . "&w={$w}&h={$h}&card_w={$card_w}&card_h={$card_h}";?>">
							<img src="<?php echo $src;?>" alt="<?php echo $p;?>" style="width: 75px;" />
							</a>
						</td>
						<td width="189">
							<?php echo $p; ?>
						</td>
						<td width="193">
							<?php echo "Width: {$width} x Height: {$height}"; ?> 
						</td>
						<td width="74">
							<a href="#!delete" id="<?php echo $counter;?>" class="delete"><img src="<?php echo siteURL;?>images/icons/cross_circle.png" alt="delete" /></a>
						</td>
					</tr>
					<?php
				} else {
					unset( $_SESSION['photos'][$counter] );
				}
				$counter++;
			}
			?>
			</table>
		</li>
		<?php endif; ?>
		<li>
			<a class="btn_normal" style="padding-top: 5px; text-align: center; cursor: pointer;" id="done">Done</a>
		</li>
	</ul>
</div> <!-- popup_wrapp -->