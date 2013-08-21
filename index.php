<?php
ob_start();
session_start(); 
include_once("config/config.php");


// if affiliate user logged in then display modified header( modified for affiliate users) All general operation will keep working as it is, as we are using different session variable names for AFFILIATE
if(isset($_SESSION['aff_user_id']) && $_SESSION['aff_user_id'] != '')
    include("aff_header.php");
else
    include("header.php");



$pageName=@$_REQUEST['p'].'.php';
$showHomePage=true;
if(file_exists($pageName))
{
	$showHomePage=false;
}
if(@$_REQUEST['p']=='')
{
	include("home.php");
}
else
{
	$pageName=@$_REQUEST['p'].'.php';
	if(file_exists($pageName))
	{ 
		include($pageName);
	}
	else
	{
            // check if any 'p' param matches any article page slug name then display that
            
		echo '<span style="color:red;">Sorry requested page not found</span>'; 
		include("home.php");
	}
}
include("footer.php");?>