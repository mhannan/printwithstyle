<?php
require ('include/gatekeeper.php');

$_SESSION['urlselected'] = 'categories';
require ('../header.php');
//require_once('../lib/func.common.php');
require_once ("../lib/func.categories.php");
require_once ("../lib/func.categories.card.php");
require_once ("../lib/func.paper.php");

$cat_res = getCategory_info($_GET['cat_id']);
$cat_row = mysql_fetch_array($cat_res);

if (!checkPermission($_SESSION['admin_id'], 'view_cards', 'admin')) {
	$errmsg = base64_encode('You are not allowed to view that Page');
	echo "<script> window.location = '../index.php?errmsg=$errmsg';</script>";
	exit ;

}

$customerFilter = "";
?>
 
<!-- that's IT-->	 
<div id="main-content"> <!-- Main Content Section with everything --> 
<?php 	
 if(isset($_GET['okmsg'])) {
?>
	<div class="notification success png_bg">
		<a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
		<div><?php echo base64_decode($_GET['okmsg']); ?></div>
	</div>

<?php
} 
if(isset($_GET['errmsg'])) {
?>
	<div class="notification error png_bg">
		<a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
		<div><?php echo base64_decode($_GET['errmsg']); ?></div>
	</div>
<?php
}
$tab_show_class='default-tab';
$show_my_tab= "";
if(isset($_REQUEST['customer'])) {
	$tab_show_class='';
	$show_my_tab= "default-tab";
	//echo ""
	$customer=$_REQUEST['select_customer'];
}
?>
<div class="content-box"><!-- Start Content Box --> 
	<div class="content-box-header">
		<h3><?php echo $cat_row['cat_title']; ?></h3>
		<ul class="content-box-tabs">
			<li> <a href="#tab1" class="<?php echo $tab_show_class; ?>">Listing </a> </li> <!-- href must be unique and match the id of target div -->
			<?php
			if (checkPermission($_SESSION['admin_id'], 'add_card', 'admin'))
				echo "<li><a href='#tab2' >Add New</a></li>";
            ?>
		</ul>
		<div class="clear:both"></div>
	</div> <!-- End .content-box-header -->

	<div class="content-box-content">
		<div class="tab-content <?php echo $tab_show_class; ?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
			<form action='' method='post' name='frmOrder' id="frmOrder">
			<table>
				<thead>
					<tr bgcolor="#CCFFCC">
						<th><b>S.No</b></th>
						<th><b>Sort Order</b></th>
                        <th><b>Card Title</b></th>
                        <th><b>Card Code</b></th>
                        <th><b>Card Size</b></th>
                        <th><b>Card Description</b></th>
                        <th><b>Sample Requests</b></th>
                        <th><b>Status</b></th>
                        <th><b>Action</b></th>
                    </tr>
                </thead>
				<?php
			 	$cards_rSet = getCards_by_cat_id($_GET['cat_id']);	// filter is being initialized on top of page and bein updated in filter part
				$i = 1;
				while( $row = mysql_fetch_array( $cards_rSet ) ) {
					$sample_link = "N/A";
					if ( $_REQUEST['cat_id'] == '1' && $row['content_area_of_card'] == '1' ) {
						$sql = "SELECT count(id) as total FROM sample_requests WHERE id_card = {$row['card_id']}";
						$requests = mysql_query($sql) or die ('count sample requests<br/>$sql</br>' . mysql_error());
						$sample_requests = mysql_result($requests, 0, 'total' );
						$sample_link = "<a href='sample-requests.php?card_id={$row['card_id']}'>{$sample_requests}</a>";
					}
					
					
					$sort_order = $row['sort_order'] ? $row['sort_order'] : $i; 
				?>
					<tr valign="middle">
						<td><?php echo $i ?></td>
						<td>
							<?php
							echo "<input type='hidden' name='ids[]' value='{$row['card_id']}' />";
							echo "<input type='text' name='sort_orders[]' value='{$sort_order}' tabindex='{$i}' style='width: 25px;' />";
							?>
							
						</td>
						
						
						<td><?php echo $row['card_title']; ?> </td>
						<td><?php echo $row['card_code']; ?> </td>
						<td><?php echo $row['card_size']; ?> </td>
						<td><?php echo $row['card_description']; ?> </td>
						<td><?php echo $sample_link; ?> </td>
						<td><?php
						if ($row['is_active'] == 1)
							echo "<img src='" . siteURL . "admin/resources/images/icons/check.png' width='20px' title='active' >";
						else
							echo "<img src='" . siteURL . "admin/resources/images/icons/hourglass.png' width='20px' title='inactive' >";
 						?>
 						</td>
 						<td><?php
 						if (checkPermission($_SESSION['admin_id'], 'config_card', 'admin'))
 							echo "<a href='card_config.php?card_id=" . $row['card_id'] . "' title='Config'><img src='" . siteURL . "admin/resources/images/icons/hammer_screwdriver.png' alt='Config' /></a> &nbsp;&nbsp;&nbsp;";
						if (checkPermission($_SESSION['admin_id'], 'update_card', 'admin'))
							echo "<a href='card_edit.php?card_id=" . $row['card_id'] . "' title='Edit'><img src='" . siteURL . "admin/resources/images/icons/pencil.png' alt='Edit' /></a> &nbsp;&nbsp;&nbsp;";
						if (checkPermission($_SESSION['admin_id'], 'delete_card', 'admin'))
							echo "<a href='do_delete_card.php?card_id=" . $row['card_id'] . "&cat_id=" . $_GET['cat_id'] . "' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='" . siteURL . "admin/resources/images/icons/cross.png' alt='Delete' /></a>";
						?>
						</td>
					</tr>
                <?php
					$i++;
					}
					if($i == 1) {
						echo "<tr><td colspan='7'> ( No Record Found ) </td></tr>";
					} else {
						echo "<tr><td>&nbsp;</td><td colspan='6'><input type='button' name='btnSaveOrder' id='btnSaveOrder' value='Update Order' /></td></tr>";
					}
				?>
			</table>
			
			</form>
			<script type='text/javascript'>
				jQuery(document).ready(function($){
					$("#btnSaveOrder").live ('click', function() {
						var dataStr = $("#frmOrder").serializeArray();
						$.ajax({
							type: "POST",
							url: "save-order.php",
							data: dataStr,
							success: function(ret) {
								alert("Sort Order updated successfully.");
							}
						});
						return;
					});
				});
			</script>
		</div> <!-- End #tab1 -->
		
		<div class="tab-content" id="tab2">
        	<h3><span style='color:#666'><?php echo $cat_row['cat_title']; ?> &raquo;</span> Add New Card</h3>
        	<form action="do_add_card.php" method="post" name="manage_account" id="myform"  enctype="multipart/form-data">
        		<table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
        			<tr>
        				<td style="padding:4px" width="30%">Card Title <input type="hidden" name="cat_id" value="<?php echo $_GET['cat_id']; ?>"></td>
        				<td style="padding:4px" width="60%"> <input class="text-input small-input required" type="text" id="txtField" name="card_title"   /></td>
    				</tr>
    				<tr>
    					<td style="padding:4px" width="30%">Card Code</td>
    					<td style="padding:4px" width="60%"> <input class="text-input small-input required" type="text" id="txtField" name="card_code"   /></td>
					</tr>
					<tr valign="top">
						<td style="padding:4px; vertical-align: top" width="30%">Card Description</td>
						<td style="padding:4px" width="60%"> <textarea class="text-input small-input required" id="txtField" name="card_description" style="width:250px; height: 60px"  ></textarea></td>
					</tr>
					<tr>
						<td style="padding:4px">Select Card Background</td>
						<td style="padding:4px"><input class="text-input small-input required" type="file" id="txtField" name="card_bg"  /></td>
					</tr>
					<tr>
						<td style="padding:4px">Select Ready-made Card Sample <br><span style="color:#999; font-size:11px">(ready made preview for customers)</span> </td>
						<td style="padding:4px"> <input class="text-input small-input" type="file" id="txtField" name="card_sample_bg"  /></td>
					</tr>
					<tr>
						<td style="padding:4px">Select Card Thumbnail</td>
						<td style="padding:4px"><input class="text-input small-input required" type="file" id="txtField" name="card_thumbnail_path"  /></td>
					</tr>
					<tr>
						<td style="padding:4px">Select Card Size</td>
						<td style="padding:4px">
							Width:&nbsp; <input style="width:80px" class="text-input small-input required" type="text" id="digitField" name="card_size_width"  /> inch<br>
                            Height: <input style="width:80px" class="text-input small-input required" type="text" id="digitField" name="card_size_height"  /> inch
                        </td>
                    </tr>
                    <tr>
                    	<td style="padding:4px">Select Paper Types for Card</td>
                    	<td style="padding:4px"><?php echo getPapers_in_HtmlElement('paperTypes[]', '', 'paperTypeClass', 'checkbox'); ?></td>
                	</tr>
                	<?php if ( isset( $_REQUEST['cat_id'] ) && ($_REQUEST['cat_id'] == '2' || $_REQUEST['cat_id'] == '7'  )) :
					// thank you / save the date card and check for does this card have an image block or not?
					?>
					<tr>
    					<td style="padding:4px" width="30%">Photo Box?</td>
    					<td style="padding:4px" width="60%">
    						<input class="paperTypeClass" type="checkbox" id="have_photo" name="have_photo" value="1"/>
    					</td>
					</tr>
                	<?php endif; ?>
                	<?php if ( isset( $_REQUEST['cat_id'] ) && ($_REQUEST['cat_id'] == '1' ) ) :
					// sample card checkbox 
					?>
					<tr>
    					<td style="padding:4px" width="30%">Sample Request?</td>
    					<td style="padding:4px" width="60%">
    						<input class="paperTypeClass" type="checkbox" id="sample_request" name="sample_request" value="1"/>
    					</td>
					</tr>
                	<?php endif; ?>
                	<tr>
                		<td>&nbsp;</td>
                		<td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td>
            		</tr>
        		</table>
    		</form>
		</div> <!-- End #tab2 -->        
	</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>
<div id="footer"></div>
</div> <!-- End #main-content -->
</div>
</body>
  

<!-- Download From www.exet.tk-->
</html>

