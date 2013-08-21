<?php
require ('include/gatekeeper.php');
require ('../header.php');
require_once ("../lib/func.coupon.php");
?>
<!-- that's IT-->	 
<div id="main-content"> <!-- Main Content Section with everything --> 
<?php 	
if(isset($_GET['okmsg'])) {
?>
   <div class="notification success png_bg">
		<a href="#" class="close">
			<img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" />
		</a>
		<div><?php echo base64_decode($_GET['okmsg']); ?></div>
	</div>

<?php
}
if( isset($_GET['errmsg']) ) {
?>
  <div class="notification error png_bg">
	<a href="#" class="close">
		<img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" />
	</a>
	<div><?php echo base64_decode($_GET['errmsg']); ?></div>
	</div>

<?php
}
	$tab_show_class='default-tab';
	$show_my_tab= "";
?>
	<div class="content-box"><!-- Start Content Box --> 
		<div class="content-box-header">
			<h3>Coupon Codes</h3>
			<ul class="content-box-tabs">
				<li><a href="#tab1" class="<?php echo $tab_show_class; ?>">Listing</a></li>
				<li><a href='#tab2' >Add New</a></li>
			</ul>
			<div class="clear:both"></div>
		</div>
		<div class="content-box-content">
			<div class="tab-content <?php echo $tab_show_class; ?>" id="tab1">
				<table>
					<thead>
						<tr bgcolor="#CCFFCC">
							<th><b>S.No</b></th>
							<th><b>Coupon Code</b></th>
							<th><b>Price</b></th>
							<th><b>Status</b></th>
							<th><b>&nbsp;</b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$table = $objCoupon->get_all();
						if ( $table ) {
							$nr = 0;
							while( $row = mysql_fetch_object( $table ) ) {
								$nr++;
								$is_active = $row->is_active == '1' ? 'Active' : 'Inactive'; 
								echo "
								<tr>
									<td>$nr</td>
									<td>{$row->code}</td>
									<td>% {$row->price}</td>
									<td>$is_active </td>
									<td>
										[<a href='edit-code.php?id={$row->id}'>Edit</a>]
										[<a href='process.php?call=delete&id={$row->id}' onclick='return confirm(&quot;Are you sure to delete?&quot;)'>Delete</a>]
									</td>
								</tr>
								";
							} // while 
						} else { // if empty table  
							echo "<tr><td colspan='5'>No Coupon Code found.</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="tab-content" id="tab2">
				<h3>Add New</h3>
				
				<form action="process.php" method="post" id="myform" enctype="multipart/form-data" >
					<input type="hidden" name="call" value="add" />
					<table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
						<tr>
							<td style="padding:4px">Coupon Code</td>
							<td style="padding:4px"><input class="text-input small-input required" type="text" id="code" name="code" /></td>
						</tr>
						<tr>
							<td style="padding:4px">Price(%)</td>
							<td style="padding:4px"><input class="text-input small-input required" type="text" id="price" name="price" style="width:120px !important"  /></td>
						</tr>
						<tr>
							<td style="padding:4px">Active</td>
							<td style="padding:4px"><input class="text-input small-input required" type="checkbox" id="is_active" name="is_active" value="1" /></td>
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
	<div class="clear"></div>
	<div id="footer"></div>
</div>
</div>
</body>
</html>

