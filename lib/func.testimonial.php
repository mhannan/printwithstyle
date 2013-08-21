<?php
function getTestimonials($objDb) {
	$res = $objDb -> select_table_join('SELECT * FROM testimonials AS t LEFT JOIN register_users AS u ON(t.user_id = u.id)', 't.is_approved="1"');
	return $res;
}

function save_testimonial($author_id, $text) {
	if ( $author_id > 0 ) {
		$sql = "
			INSERT INTO testimonials SET 
			user_id = '" . mysql_real_escape_string($author_id) . "' , 
			testimonial = '" . mysql_real_escape_string($text) . "', 
			date_posted = curdate()
		";
		if (mysql_query($sql))
			return true;
		else
			return false;
	} else {
		return false; 
	}
}