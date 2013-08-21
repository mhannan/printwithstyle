<?php
function getTestimonial_info($testimonial_id = '') {
	if ($testimonial_id == '')
		$sql = "SELECT * FROM testimonials AS t LEFT JOIN register_users AS u ON(t.user_id=u.id) ORDER BY t.testimonial_id DESC";
	else
		$sql = "SELECT * FROM testimonials AS t LEFT JOIN register_users AS u ON(t.user_id=u.id) WHERE t.testimonial_id = '{$testimonial_id}'";
	$rSet = mysql_query($sql);
	return $rSet;
}

function update_testimonial($post) {
	extract($post);
	$sql = "
		UPDATE testimonials SET 
		testimonial = '" . mysql_real_escape_string($testimonial_text) . "' 
		WHERE testimonial_id='{$testimonial_id}'";

	if (mysql_query($sql))
		return true;
	else
		return false;
}

function deleteTestimonial($testimonial_id) {
	$sql = "DELETE FROM testimonials WHERE testimonial_id='{$testimonial_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}

function activate($testimonial_id) {
	$sql = "UPDATE testimonials SET is_approved='1' WHERE testimonial_id='{$testimonial_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}

function deactivate($testimonial_id) {
	$sql = "UPDATE testimonials SET is_approved='0' WHERE testimonial_id='{$testimonial_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}