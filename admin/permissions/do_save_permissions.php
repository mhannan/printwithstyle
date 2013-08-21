<?php
require('include/gatekeeper.php');

require_once('../lib/func.common.php');
require_once('../lib/func.user.php');
	
	
if( setAdminPermission($_POST) )
{
        $okmsg = base64_encode("Permission Saved Successfully.");
        echo "<script> window.location = 'index.php?okmsg=$okmsg';</script>";
}
else {

        $errmsg = base64_encode(" Unable to save Permissions, please try again later. ");
        echo "<script> window.location = 'index.php?errmsg=$errmsg';</script>";
}	
		
				
	 
?>	