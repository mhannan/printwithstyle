<?php
include ("../config/conf.php");
include ('../lib/func.coupon.php');

extract($_REQUEST);

$url = 'index.php';
if ( isset( $call ) ) {
	switch ($call) {
		case 'add': {
			$objCoupon->code = $code;
			$objCoupon->price = $price;
			$objCoupon->is_active = isset($is_active) ? 1 : 0;
			if ( $objCoupon->insert() ) {
				$okmsg = base64_encode("Coupon saved Successfully.");
				$url = "index.php?okmsg=$okmsg";
			} else {
				$errmsg = base64_encode("Unable to save coupon, please try again later.");
				$url = "index.php?errmsg=$errmsg";
			}
			break;
		}
		
		case 'delete': {
			$objCoupon->id = $id;
			if ( $objCoupon->delete() ) {
				$okmsg = base64_encode("Coupon deleted Successfully.");
				$url = "index.php?okmsg=$okmsg";
			} else {
				$errmsg = base64_encode("Unable to delete coupon, please try again later.");
				$url = "index.php?errmsg=$errmsg";
			}
			break;
		}
		
		case 'edit': {
			$objCoupon->code = $code;
			$objCoupon->price = $price;
			$objCoupon->is_active = isset($is_active) ? 1 : 0;
			$objCoupon->id = $id;
			if ( $objCoupon->update() ) {
				$okmsg = base64_encode("Coupon updated Successfully.");
				$url = "index.php?okmsg=$okmsg";
			} else {
				$errmsg = base64_encode("Unable to save coupon, please try again later.");
				$url = "index.php?errmsg=$errmsg";
			}
			break;
		}
	}
}

echo "<script type='text/javascript'> window.location = '$url';</script>";