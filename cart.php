<?php
include 'config/config.php';
include 'header.php';
include 'lib/func.products.php';
?>
<script type="text/javascript" src="<?php echo siteURL . "js/thickbox-compress.js";?>"></script>
<link href="<?php echo siteURL . "css/thickbox.css";?>" rel="stylesheet" type="text/css" />
<div class="body_internal_wrapper">
	
	<div class="body_left" style="float: left; width: 100%;">
		<div class="addons_cart_table">
		<?php
		$cart = get_cart();
		if ( $cart ) {
			$no_checkout = TRUE;
			include 'cart-listing.php';
			
			
		} else {
			echo "You don't have any item in the cart.";
		}
		?>
		</div>
	</div>
</div>
<?php
include 'footer.php';
