<?php
ob_start();
session_start();
include_once ("../config/conf.php");
$task = $_REQUEST['task'];
if ($task == "enter_comments") {
	extract($_POST);
	$cols = "commentedByUserId,commentedOnArticleId,date_commented,comments";
	$values = "'$user_id','$comment_id','$comment_date','".mysql_real_escape_string($comment)."'";
	mysql_query("INSERT INTO blog_comments($cols)VALUES($values)");
	header("location:../index.php?p=blog_detail&post_id=$comment_id&msg=succ");
	exit ;
} else {
	header("location:index.php");
}