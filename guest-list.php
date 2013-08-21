<?php
require 'admin/config/conf.php';
extract($_REQUEST);
if ( !isset( $id ) || $id <= 1 || $id == '' || empty($id) ) {
	die("ALLAH-o-AKBAR");
}
/* check for data in order details table */
$sql = "SELECT `data` FROM order_detail WHERE id = '{$id}'";
$data = mysql_query($sql) or die ("get guest list <br/>$sql<br/>" . mysql_error());
if ( is_resource( $data ) && mysql_num_rows( $data ) ) {
	
	$gids = mysql_fetch_object($data);
	$gids = unserialize( $gids->data );
	
	$gids = $gids['guest_ids'];
	
	$sql = "SELECT recipient_address FROM customer_guests WHERE guest_id IN ({$gids})";
	$guests = mysql_query($sql) or die ("get guest name<br/>$sql</br>" . mysql_error());
	if ( is_resource($guests) && mysql_num_rows($guests)) {
		$num_fields = mysql_num_fields($guests);
		/*
		$headers = array();
		
		for ($i = 0; $i < $num_fields; $i++) {
		    $headers[] = mysql_field_name($guests , $i);
		}
		*/
		$fp = fopen('php://output', 'w');
		if ($fp && $data) {
		    header('Content-Type: text/csv');
		    header("Content-Disposition: attachment; filename='{$id}-{$a}.csv'");
		    header('Pragma: no-cache');
		    header('Expires: 0');
		    //fputcsv($fp, $headers);
		    while ($row = mysql_fetch_array($guests) ) {
		    	$recipient_address = unserialize($row['recipient_address']);
		        fputcsv($fp, array_values($recipient_address));
		    }
		    die;
		}
	}
	die;
	
	
	
	
	$num_fields = mysql_num_fields($data);
	$headers = array();
	for ($i = 0; $i < $num_fields; $i++) {
	    $headers[] = mysql_field_name($data , $i);
	}
	$fp = fopen('php://output', 'w');
	if ($fp && $data) {
	    header('Content-Type: text/csv');
	    header('Content-Disposition: attachment; filename="export.csv"');
	    header('Pragma: no-cache');
	    header('Expires: 0');
	    fputcsv($fp, $headers);
	    while ($row = mysql_fetch_array($data) ) {
	        fputcsv($fp, array_values($row));
	    }
	    die;
	}
}