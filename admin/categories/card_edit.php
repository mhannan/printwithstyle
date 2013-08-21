<?php
require ('include/gatekeeper.php');
require ('../header.php');
require_once ("../lib/func.paper.php");
require_once ("../lib/func.categories.card.php");

if (isset($_REQUEST['card_id']))
	$cardSet = getCard_info($_REQUEST['card_id']);
$row = mysql_fetch_array($cardSet);
//print_r($row); exit;

$card_sizeArr = explode('-', $row['card_size']);
// 0:33 inch  , 1: 44 inch
$card_width = explode(' ', $card_sizeArr[0]);
$card_width = $card_width[0];
$card_height = explode(' ', $card_sizeArr[1]);
$card_height = $card_height[0];
?>

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">
    <div class="content-box-header">
        <h3><span style='color:#666'><?php echo $row['cat_title']; ?> &raquo;</span> <?php echo $row['card_title']; ?></h3>
    </div>
  	
    <div class="content-box-content">
    	<h3> Edit Card </h3>
    	<form action="do_edit_card.php" method="post" name="manage_account" id="myform" enctype="multipart/form-data">
    		<table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
    			<tr>
    				<td style="padding:4px" width="30%">Card Title <input type="hidden" name="cat_id" value="<?php echo $row['cat_id']; ?>">  <input type="hidden" name="card_id" value="<?php echo $_GET['card_id']; ?>"></td>
    				<td style="padding:4px" width="60%"> <input class="text-input small-input required" type="text" id="txtField" name="card_title"  value="<?php echo $row['card_title']; ?>" /></td>
    			</tr>
    			<tr>
    				<td style="padding:4px" width="30%">Card Code</td>
    				<td style="padding:4px" width="60%"> <input class="text-input small-input required" type="text" id="txtField" name="card_code"  value="<?php echo $row['card_code']; ?>" /></td>
    			</tr>
    			<tr valign="top">
    				<td style="padding:4px; vertical-align: top" width="30%">Card Description</td>
    				<td style="padding:4px" width="60%"> <textarea class="text-input small-input required" id="txtField" name="card_description" style="width:250px; height: 60px"  ><?php echo $row['card_description']; ?></textarea></td>
				</tr>
				<tr>
					<td style="padding:4px">Select Card Background</td>
					<td style="padding:4px"><input class="text-input small-input required" type="file" id="txtField" name="card_bg"  /><span style="margin-left:20px; color:#666; font-size: 11px">(leave blank to keep old image unchanged)</span>
						<?php
						if ($row['card_bg_path'] != "")
							echo "<br><img style='border:1px solid #666; margin-top:3px;' src='../../uploads/blank_cards/" . $row['card_bg_path'] . "' width='80px'>";
						?>
                    </td>
                </tr>
                <tr>
                	<td style="padding:4px">Select Ready-made Card Sample <br><span style="color:#999; font-size:11px">(ready made preview for customers)</span> </td>
                	<td style="padding:4px"> <input class="text-input small-input" type="file" id="txtField" name="card_sample_bg"  /><span style="margin-left:20px; color:#666; font-size: 11px">(leave blank to keep old image unchanged)</span>
                		<?php
                		if ($row['card_sample_path'] != "")
                			echo "<br><img style='border:1px solid #666; margin-top:3px;' src='../../uploads/sample_cards/" . $row['card_sample_path'] . "' width='80px'>";
            			?>
        			</td>
    			</tr>
    			 <tr>
                	<td style="padding:4px">Select Card Thumbnail<br></td>
                	<td style="padding:4px"> <input class="text-input small-input" type="file" id="txtField" name="card_thumbnail_path"  /><span style="margin-left:20px; color:#666; font-size: 11px">(leave blank to keep old image unchanged)</span>
                		<?php
                		if ($row['card_thumbnail_path'] != "")
                			echo "<br><img style='border:1px solid #666; margin-top:3px;' src='../../uploads/sample_cards/" . $row['card_thumbnail_path'] . "' width='80px'>";
            			?>
        			</td>
    			</tr>
    			<tr>
    				<td style="padding:4px">Select Card Size</td>
    				<td style="padding:4px">Width:&nbsp; <input style="width:80px" class="text-input small-input required" type="text" id="digitField" name="card_size_width" value="<?php echo $card_width; ?>" /> inch<br>
    					Height: <input style="width:80px" class="text-input small-input required" type="text" id="digitField" name="card_size_height"  value="<?php echo $card_height; ?>" /> inch
					</td>
				</tr>
				<tr>
					<td style="padding:4px">Select Paper Types for Card</td>
					<td style="padding:4px"><?php echo getPapers_in_HtmlElement_asSelected('paperTypes[]', '', 'paperTypeClass', 'checkbox', $row['card_id']); ?></td>
				</tr>
				<?php if ( isset( $row['cat_id'] ) && ($row['cat_id'] == '2' || $row['cat_id'] == '7' ) ) :
				// save the date card and check for does this card have an image block or not?
				$chk = isset( $row['have_photo'] ) && $row['have_photo'] == "1" ? ' checked="checked" ' : NULL;
				?>
				<tr>
					<td style="padding:4px" width="30%">Photo Box?</td>
					<td style="padding:4px" width="60%">
					<input class="paperTypeClass" type="checkbox" id="have_photo" name="have_photo" value="1" <?php echo $chk; ?>/>
					</td>
				</tr>
				<?php endif; ?>
				<?php if ( isset( $row['cat_id'] ) && ($row['cat_id'] == '1' ) ) :
				// sample card request
				$chk = isset( $row['content_area_of_card'] ) && $row['content_area_of_card'] == "1" ? ' checked="checked" ' : NULL;
				?>
				<tr>
					<td style="padding:4px" width="30%">Sample Request?</td>
					<td style="padding:4px" width="60%">
					<input class="paperTypeClass" type="checkbox" id="sample_request" name="sample_request" value="1" <?php echo $chk; ?>/>
					</td>
				</tr>
				<?php endif;
				$is_active = isset( $row['is_active'] ) && $row['is_active'] == "1" ? ' checked="checked" ' : NULL;
				?>
				<tr>
					<td style="padding:4px" width="30%">Enable</td>
					<td style="padding:4px" width="60%">
					<input class="paperTypeClass" type="checkbox" id="is_active" name="is_active" value="1" <?php echo $is_active; ?>/>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td>
				</tr>
            </table>
        </form>
    </div>
</div>
</div>
 <script type="text/javascript">
	function validate_user() {
		var flag = true;

		if ($('#fullname').val() == "") {
			$('#fullname').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#fullname').css('border', '1px solid #d8d9db');

		if ($('#username').val() == "") {
			$('#username').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#username').css('border', '1px solid #d8d9db');

		if ($('#password').val() == "") {
			$('#password').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#password').css('border', '1px solid #d8d9db');

		if ($('#email').val() == "") {
			$('#email').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#emai').css('border', '1px solid #d8d9db');

		return flag;
	}
</script>
</body>
</html>
