<?php
extract($_REQUEST);

if ( !isset( $id ) || empty( $id ) ) {
	echo "<script type='text/javascript'> window.location = 'index.php';</script>";
}


require ('include/gatekeeper.php');
require ('../header.php');
require_once ("../lib/func.coupon.php");

$objCoupon->id = $id;
if ( !$objCoupon->set_code() ) { // ID didn't exists in the table, it will return FALSE
	echo "<script type='text/javascript'> window.location = 'index.php';</script>";
}


?>
<!-- that's IT-->	 
<div id="main-content"> <!-- Main Content Section with everything --> 
<?php
	$tab_show_class='default-tab';
	$show_my_tab= "";
?>
	<div class="content-box"><!-- Start Content Box --> 
		<div class="content-box-header">
			<h3>Edit Coupon Code</h3>
		</div>
		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
				<h3>Add New Envelop</h3>
				
				<form action="process.php" method="post" id="myform" enctype="multipart/form-data" >
					<input type="hidden" name="call" value="edit" />
					<input type="hidden" name="id" value="<?php echo $objCoupon->id;?>" />
					<table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
						<tr>
							<td style="padding:4px">Coupon Code</td>
							<td style="padding:4px"><input class="text-input small-input required" type="text" id="code" name="code" value="<?php echo $objCoupon->code;?>" /></td>
						</tr>
						<tr>
							<td style="padding:4px">Price(%)</td>
							<td style="padding:4px"><input class="text-input small-input required" type="text" id="price" name="price" style="width:120px !important"  value="<?php echo $objCoupon->price;?>"   /></td>
						</tr>
						<tr>
							<td style="padding:4px">Active</td>
							<td style="padding:4px"><input class="text-input small-input required" type="checkbox" id="is_active" name="is_active" value="1"  <?php echo $objCoupon->is_active == '1' ? 'checked="checked"' : NULL;?>  /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;<br /><input class="button" type="submit" value="Update" />&nbsp;&nbsp;<a href='index.php'>Back</a></td>
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

