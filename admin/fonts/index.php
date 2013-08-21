<?php
require ('include/gatekeeper.php');

$_SESSION['urlselected'] = '';
require ('../header.php');

//require_once("../lib/func.customer.packages.php");
require_once ("../lib/func.fonts.php");

if (!checkPermission($_SESSION['admin_id'], 'view_fonts', 'admin')) {
	$errmsg = base64_encode('You are not allowed to view that Page');
	echo "<script> window.location = '../index.php?errmsg=$errmsg';</script>";
	exit ;

}

$customerFilter = "";
?>
<script type="text/javascript">
	function validateForm() {
		var flag = true;
		if ($('#font_file').val() == '') {
			$('#font_file').css('border', '1px solid red');
			flag = false;
		} else
			$('#font_file').css('border', '1px solid #ccc');

		if ($('#font_title').val() == '') {
			$('#font_title').css('border', '1px solid red');
			flag = false;
		} else
			$('#font_file').css('border', '1px solid #ccc');

		return flag;
	}
</script>
 
 
<!-- that's IT-->	 
<div id="main-content"> <!-- Main Content Section with everything --> 
<?php 	
 if(isset($_GET['okmsg']))
{
?>
   <div class="notification success png_bg">
				<a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div><?php echo base64_decode($_GET['okmsg']); ?></div>
			</div>

<?php
	}

	if(isset($_GET['errmsg']))
	{
?>
  		  <div class="notification error png_bg">
			 <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>					<?php echo base64_decode($_GET['errmsg']); ?>				</div>
			</div>

<?php
	}

	$tab_show_class='default-tab';
	$show_my_tab= "";
	if(isset($_REQUEST['customer']))
	{
	$tab_show_class='';
	$show_my_tab= "default-tab";
	//echo ""
	$customer=$_REQUEST['select_customer'];
	}
?>
	
			<div class="content-box"><!-- Start Content Box --> 
				
				<div class="content-box-header">
					<h3>Fonts</h3>
					<ul class="content-box-tabs">
						<li> <a href="#tab1" class="<?php echo $tab_show_class; ?>">Listing </a> </li> <!-- href must be unique and match the id of target div -->
						<?php
						if (checkPermission($_SESSION['admin_id'], 'add_package', 'admin'))
							echo "<li><a href='#tab2' >Add New</a></li>";
						?>
						<!-- Customer Search tab -->
						<!-- <li><a href="#tab3" class="< ?php echo $show_my_tab;?>">Search</a></li> -->
					</ul>
					<div class="clear:both"></div>
				</div> <!-- End .content-box-header -->

				<div class="content-box-content">
					<div class="tab-content <?php echo $tab_show_class; ?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						<div>
							<form action="do_add.php" method="post" name="manage_account" id="myform" enctype="multipart/form-data" onsubmit="return validateForm()" >
								<fieldset style="padding:10px; border:1px solid #ccc">
									<legend>Add Font</legend>
									<div style="float:left; margin: 0px 20px">Font Title : <input type="text" name="font_title" id="font_title" class="text-input medium-input required"></div>
									<div style="float:left; margin: 0px 20px">Font TTF File : <input type="file" name="font_file" id="font_file" class="text-input medium-input required"> <br>
										<span style="color:#888; font-size:10px">(Please use only TTF type font file)</span></div>
										<div style="float:left; margin:0px 20px"><input class="button" type="submit" value="Submit" /></div>
								</fieldset>
							</form>
						</div>
						<table>
							<thead>
								<tr bgcolor="#CCFFCC">
									<th><b>Fonts Listing</b></th>
								</tr>
							</thead>
							<tr>
								<td>
								<?php
								$fontSet = getFonts();	// filter is being initialized on top of page and bein updated in filter part
								$i = 1;
								while( $row = mysql_fetch_array( $fontSet ) ) {
								?>
									<div style="float:left; height:40px; width:200px; overflow: hidden; padding:5px; margin:0px 10px 20px 0px; border:1px solid #ccc; background-color:#fafafa">
										<div style="float: right;">
										<img src='<?php echo siteURL;?>admin/resources/images/icons/cross.png' alt='Delete' class='delete_font' id="<?php echo $row['font_id']; ?>" style='cursor: pointer;' />
										</div>
								<?php
									if ( $row['font_path'] == '' )// for windows standard fonts
										echo $row['font_label'];
									elseif ($row['font_preview_image'] != '')// for external file font which preview already generated by system
										echo "<img src='../../fonts/previews/" . $row['font_preview_image'] . "' height='auto'>";
									else {// else read the TTF file and generate preview
										echo generate_font_preview_by_ttf( $row['font_id'], $row['font_label'], '../../fonts/' . $row['font_path'] );
										// generate font preview by converting its label to PNG using its own font file
									}
									
								?>
									</div>
	 							<?php
								$i++;
								}
								?>
								<div style="clear:both"></div>
								<script type="text/javascript">
									jQuery(document).ready(function($) {
										$(".delete_font").live ('click', function() {
											if ( confirm("Are you sure to delete?") ) {
												var _id = this.id;
												self.location.href = "delete.php?fid="+_id;
											}
											
										});
									});
								</script>
								</td>
							</tr>
					</table>
					</div> <!-- End #tab1 -->
					<div class="tab-content" id="tab2">
						<h3> Add New Background </h3>
						<form action="do_add_background.php" method="post" name="manage_account" id="myform" enctype="multipart/form-data" >
							<table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
								<tr>
									<td style="padding:4px">Background Title</td>
									<td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="bgTitle"   /></td>
								</tr>
								<tr>
									<td style="padding:4px">Select Background</td>
									<td style="padding:4px"><input class="text-input small-input required" type="file" id="txtField" name="bgImage"  /></td>
								</tr>
								<tr>
									<td style="padding:4px">Background for Packages</td>
									<td style="padding:4px"> <?php echo getPackages_inHTML('checkbox', 'package_types[]'); ?> </td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td>
								</tr>
							</table>
						</form>
					</div>
				</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
			<div class="clear"></div>
		<div id="footer"></div>
	</div>
</div>
</body>
</html>