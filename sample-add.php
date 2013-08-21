<?php
include 'config/config.php';
extract($_REQUEST);


$add_sample = new table_class('cart');
$add_sample->id_card = $item_id;
$add_sample->id_customer = $_SESSION['user_id'];
$add_sample->ip = $_SESSION['ip'];
$add_sample->session_id = $_SESSION['session_id']; 
$add_sample->is_sample = 1;
/* check if this is already exists */
if ( $add_sample->populate("AND", TRUE) === FALSE ) {
	$add_sample->paper_type = $paper_type;
	$add_sample->quantity_price = $qty_price;
	$add_sample->insert();
	$msg = "Sample added to your cart.";
} else {
	$add_sample->paper_type = $paper_type;
	$add_sample->quantity_price = $qty_price;
	$add_sample->update();
	$msg = "Sample updated to your cart.";
}
?>
<link href="<?php echo siteURL;?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo siteURL;?>js/jquery.min.js"></script>

<div class="popup_content">
	<ul class="return_address">
		<li>
			<h3>Sample Request</h3>
			<div class="return_address-section" style="opacity: 1; height: auto; ">
				<div class="return_address-content"><?php echo isset($msg) ? $msg : NULL; ?></div>
			</div>
		</li>
	</ul>
</div> <!-- popup_wrapp -->

<script type='text/javascript'>
	function remove_popup() {
		self.parent.tb_remove();
	}
	setTimeout(self.parent.tb_remove, 1500);
</script>
