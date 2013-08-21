<?php
require ('include/gatekeeper.php');
$_SESSION['urlselected'] = 'oders';
require ('../header.php');
require_once ("../lib/func.orders.php");

if (!checkPermission($_SESSION['admin_id'], 'view_orders', 'admin')) {
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
if ( isset( $_GET['errmsg'] ) ) {
?>
  <div class="notification error png_bg">
	 <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
	<div><?php echo base64_decode($_GET['errmsg']); ?></div>
</div>
<?php
}
?>
	<div class="content-box"><!-- Start Content Box --> 
		<div class="content-box-header">
			<h3>Orders</h3>
			<ul class="content-box-tabs">
				<li><a class="default-tab">Listing</a></li>
			</ul>
			<div class="clear:both"></div>
		</div> <!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab">
				<table>
					<thead>
						<tr>
							<th>Sr. Nr.</th>
							<th>Customer Name</th>
							<th>Order Amount</th>
							<th>Order Date</th>
							<th>Shippping Method / Price</th>
							<th>Billing Address</th>
							<th>Shippping Address</th>
							<th>Order Status</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$table = $objOrder->get_all();
						if ( $table ) {
							$nr = 0;
							while( $row = mysql_fetch_object( $table ) ) {
								$nr++;
								$reviewed = $row->admin_reviewed ? NULL : 'style="background-color: #D0E5E4;"';
								$shipping_method = explode( "|", $row->billing_phone );
								
								$_billing = isset($row->billing) ? unserialize($row->billing) : FALSE;
								$billing = $shipping = "";
								if ( $_billing ) {
									$billing = "Name: {$_billing['name']}<br/>";
									$billing .= "Address: {$_billing['address']}<br/>";
									$billing .= "City: {$_billing['city']}<br/>";
									$billing .= "State: {$_billing['state']}<br/>";
									$billing .= "Zip: {$_billing['zip']}<br/>";
									$billing .= "Country: {$_billing['country']}<br/>";
									$billing .= "Phone #: {$_billing['phone']}";
								}
								
								$_shipping = isset($row->shipping) ? unserialize($row->shipping) : FALSE;
								if ( $_shipping ) {
									$shipping = "Name: {$_shipping['name']}<br/>";
									$shipping .= "Address: {$_shipping['address']}<br/>";
									$shipping .= "City: {$_shipping['city']}<br/>";
									$shipping .= "State: {$_shipping['state']}<br/>";
									$shipping .= "Zip: {$_shipping['zip']}<br/>";
									$shipping .= "Country: {$_shipping['country']}<br/>";
									$shipping .= "Phone #: {$_shipping['phone']}";
								}
								
								
								echo "
								<tr $reviewed>
									<td>$nr</td>
									<td>{$row->customer_name}</td>
									<td>&#36; {$row->total_price}</td>
									<td>{$row->order_date}</td>
									<td>{$shipping_method[0]} / &#36; {$shipping_method[1]}</td>
									<td>{$billing}</td>
									<td>{$shipping}</td>
									<td>{$row->status}</td>
									<td><a href='order_detail.php?id={$row->id}'>Details</a></td>
								</tr>
								";
							} // while 
						} else { // if empty table  
							echo "<tr><td colspan='5'>No Order found.</td></tr>";
						}
						?>
					</tbody>
						
				</table>
			</div> <!-- End #tab1 -->
		</div> <!-- End .content-box-content -->
	</div> <!-- End .content-box -->
	<div class="clear"></div>
	<div id="footer"></div>
</div>
</div>
</body>
</html>