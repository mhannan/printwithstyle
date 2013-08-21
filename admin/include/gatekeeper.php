<?php
session_start();
// session params @ : admin_id, admin_name, last_login_time

require("config/conf.php");
require("lib/func.user.php");

if(!isset($_SESSION['admin_id']) || !validusersession())
	die('<body style="background-color:#B21515"><div style="margin-top:100px; margin-left:auto; margin-right:auto; padding:10px; background-color:#fff; color:#B21515">Unauthorized Access.</div></body>');

	

?>