<?php
include ("../config/conf.php");
include ('../lib/func.orders.php');

extract($_REQUEST);

$url = 'index.php';
if ( isset( $call ) && $call == 'update_status' ) {
	if ( $objOrder->order_status( $id, $status ) ) {
		$okmsg = base64_encode(" Status updated Successfully. ");
		$url = "index.php?okmsg=$okmsg";
	} else {
		$errmsg = base64_encode(" Unable to update Status, please try again later. ");
		$url = "index.php?errmsg=$errmsg";
	}
}
	echo "<script type='text/javascript'> window.location = '$url';</script>";
