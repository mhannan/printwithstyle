<?php
include("../config/conf.php");
include( "../lib/func.fonts.php" );

extract($_REQUEST);
if ( isset( $fid ) && !empty( $fid ) ) {
	$sql = "DELETE FROM fonts WHERE font_id = {$fid}";
	
	if ( mysql_query($sql) ) {
		$msg = base64_encode("Font is delete successfully.");
	} else {
		$msg = base64_encode("There is an error when deleting the font.");
	}
	
	$url = siteURL . "admin/fonts/?okmsg={$msg}";
	header("Location: $url");
} else {
	header("Location: $url");
}
