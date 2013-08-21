<?php
function addBlogArticle($post) {
	extract($post);
	$title = mysql_real_escape_string($title);
	$description = mysql_real_escape_string($postContent);
	$addedByAdminId = $_SESSION['admin_id'];
	$lastModifiedByAdminId = $_SESSION['admin_id'];
	$blogFileName = "";
	if ($_FILES['blog_image']["name"]) {
		$fileNameHandler = $_FILES['blog_image']["name"];
		$file_newName = 'blog_img_' . date("mdyHis");
		$blogFileName = uploadPhoto('../../uploads/blog_images/', $_FILES['blog_image'], $file_newName);
	}

	$sql = sprintf("
		INSERT INTO blog_section SET 
		title = '%s', 
		description = '%s' ,
		currentDate = curdate(), 
		image = '%s' , 
		addedByAdminId = '%s' ,
		lastModifiedByAdminId = '%s' , 
		last_modified = curdate()", 
		$title, $description, $blogFileName, $addedByAdminId, $lastModifiedByAdminId
	);

	if (mysql_query($sql))
		return true;
	else
		return false;
}

function updateBlogArticle($post) {
	extract($post);
	$articleId = mysql_real_escape_string($articleId);
	$title = mysql_real_escape_string($title);
	$description = mysql_real_escape_string($postContent);

	$blogFileName = $oldImg_name;
	if ($_FILES['blog_image']["name"]) {
		$fileNameHandler = $_FILES['blog_image']["name"];
		$file_newName = 'blog_img_' . date("mdyHis");
		$blogFileName = uploadPhoto('../../uploads/blog_images/', $_FILES['blog_image'], $file_newName);
		@unlink('../../uploads/blog_images/' . $oldImg_name);
	}

	$lastModifiedByAdminId = $_SESSION['admin_id'];

	$sql_1 = sprintf("
		UPDATE blog_section SET 
		title = '%s', 
		description = '%s' , 
		image='%s',
		lastModifiedByAdminId = '%s'  , 
		last_modified = curdate()
		WHERE id='%s' ", 
		$title, $description, $blogFileName, $lastModifiedByAdminId, $articleId
	);

	$returnData = array();
	if (mysql_query($sql_1)) {
		$okmsg = base64_encode("Information successfully updated");
		$returnData[0] = "1";
		$returnData[1] = $okmsg;
	} else {
		$errmsg = base64_encode("Unable to update information due to : " . mysql_error());
		$returnData[0] = "0";
		$returnData[1] = $errmsg;
	}

	return $returnData;
}

function getBlog_info($blogId = '') {
	if ($blogId == '')
		$sql = "SELECT * FROM blog_section ORDER BY id desc";
	else
		$sql = "SELECT * FROM blog_section WHERE id = '$blogId'";
	$rSet = mysql_query($sql);
	return $rSet;
}

function getArticleById($articleId = '') {
	if ($articleId == '')
		$sql = "SELECT * FROM blog_section ORDER BY id ASC";
	else
		$sql = "SELECT * FROM blog_section WHERE id = '{$articleId}'";
	$rSet = mysql_query($sql);
	$row = mysql_fetch_array($rSet);
	return $row;
}

function getTotalNumOfComments($articleId) {
	$sql = "
		SELECT count(commentedOnArticleId) as totalcomments
		FROM blog_comments WHERE  commentedOnArticleId = '{$articleId}' group by commentedOnArticleId";
	$rSet = mysql_query($sql);
	$row = mysql_fetch_array($rSet);
	if ($row['totalcomments'] > 0) {
		return $row['totalcomments'];
	} else {
		return 0;
	}
}

function displayTotalComments($articleId) {
	$sql = "
		SELECT commentedOnArticleId
		FROM blog_comments WHERE commentedOnArticleId = '{$articleId}' ";
	$rSet = mysql_query($sql);
	return mysql_num_rows($rSet);
}

function getAllCommentsOnThisArticle($articleId) {
	$sql = "
		SELECT * FROM blog_comments AS b 
		LEFT JOIN register_users AS u ON(b.commentedByUserId = u.id)
		WHERE  b.commentedOnArticleId='{$articleId}";
	$rSet = mysql_query($sql);
	return $rSet;
}

function addBlogComments($post) {
	extract($post);
	$commentedByUserId = $_SESSION['userId'];
	$date_commented = date("Y-m-d");
	$commentedOnArticleId = $articleId;
	$sql_1 = sprintf("
		INSERT INTO blog_comments SET 
		commentedByUserId = '%s', 
		comments = '%s' ,
		commentedOnArticleId = '%s' , 
		date_commented = '%s' ", 
		mysql_real_escape_string($commentedByUserId), 
		mysql_real_escape_string($comments), 
		mysql_real_escape_string($commentedOnArticleId), 
		$date_commented
	);

	$returnData = array();
	if (mysql_query($sql_1)) {
		$okmsg = base64_encode("Information successfully updated");
		$returnData[0] = "1";
		$returnData[1] = $okmsg;
	} else {
		$errmsg = base64_encode("Unable to update information due to : " . mysql_error());
		$returnData[0] = "0";
		$returnData[1] = $errmsg;
	}

	return $returnData;
}

function updateBlogCommentStatus($post) {
	extract($post);
	$status = mysql_real_escape_string($status);
	$id = mysql_real_escape_string($id);

	$sql_1 = sprintf("UPDATE blog_comments SET `status` = '%s'  WHERE Id='%s' ", $status, $id);

	$returnData = array();
	if (mysql_query($sql_1)) {
		$okmsg = base64_encode("Information successfully updated");
		$returnData[0] = "1";
		$returnData[1] = $okmsg;
	} else {
		$errmsg = base64_encode("Unable to update information due to : " . mysql_error());
		$returnData[0] = "0";
		$returnData[1] = $errmsg;
	}

	return $returnData;
}

function deleteComments($requestpost = '') {
	extract($requestpost);
	$sql = "DELETE FROM blog_comments WHERE Id = '$comment_id'";
	//  exit;
	if (mysql_query($sql))
		return true;
	else
		return false;
}

function deleteBlogArticle($requestpost = '') {
	extract($requestpost);

	if ($oldimage != '') {
		$oldimage = '../../uploads/blog_images/' . $oldimage;
		@unlink($oldimage);
	}

	$sql = "DELETE FROM blog_section WHERE id = '$articleId'";
	if (mysql_query($sql)) {
		$sql_cmts = "DELETE FROM blog_comments WHERE commentedOnArticleId = '$articleId'";
		mysql_query($sql_cmts);
		return true;
	} else
		return false;
}