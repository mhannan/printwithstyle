<?php
function getBlogArticles($article_id = '') {
	if (isset($article_id) && $article_id != '')
		$sql = "SELECT * FROM blog_section WHERE id='" . mysql_real_escape_string($article_id) . "'";
	else
		$sql = "SELECT * FROM blog_section";
	$res = mysql_query($sql);
	return $res;
}

function update_post_view_counter($article_id) {
	$sql = "UPDATE blog_section SET viewed_count_popularity= viewed_count_popularity+1 WHERE id='" . mysql_real_escape_string($article_id) . "'";
	mysql_query($sql);
}

function getPopularPosts($limit) {
	$sql = "SELECT * FROM blog_section ORDER BY viewed_count_popularity DESC LIMIT $limit";
	$res = mysql_query($sql);
	return $res;
}

function getLatestPosts($limit) {
	$sql = "SELECT * FROM blog_section ORDER BY id DESC LIMIT $limit";
	$res = mysql_query($sql);
	return $res;
}

//****************************** Article Comments Section *************************//

function post_article_comment($customer_id, $comment, $article_id) {
	if ( !empty($comment) && $customer_id !="") {
		$comment = mysql_real_escape_string($comment);
		$sql = "INSERT INTO blog_comments SET
			commentedOnArticleId = '" . mysql_real_escape_string($article_id) . "' ,
			commentedByUserId = '" . mysql_real_escape_string($customer_id) . "' ,
			comments = '" . mysql_real_escape_string(str_replace('\r\n','<br>',strip_tags($comment))) . "' ,
			date_commented = curdate() ,
			`status` = '1'";
		if (mysql_query($sql))
			return true;
		else
			return false;
	} else {
		return false;
	}
}

function get_article_comments_count($article_id) {
	$sql = "SELECT * FROM blog_comments WHERE commentedOnArticleId='" . mysql_real_escape_string($article_id) . "' AND `status`='1'";
	$res = mysql_query($sql);
	return mysql_num_rows($res);
}

function get_article_comments($article_id) {
	$sql = "SELECT * FROM blog_comments AS b LEFT JOIN register_users AS u
		ON(b.commentedByUserId = u.id)
		WHERE b.`status`='1' AND b.commentedOnArticleId='" . mysql_real_escape_string($article_id) . "'";
	$res = mysql_query($sql);
	return $res;
}