<?php 
extract($_REQUEST);

if ( isset($sort_orders) ) {
	require ('include/gatekeeper.php');
	
	$total = count($sort_orders);
	$sql = "";
	for( $i = 0; $i < $total; $i++ ) {
		$so = isset($sort_orders[$i]) && !empty($sort_orders[$i]) && is_numeric($sort_orders[$i]) ? $sort_orders[$i] : $i; 
		mysql_unbuffered_query("UPDATE cards SET sort_order = {$so} WHERE card_id = {$ids[$i]};");
	}
}
