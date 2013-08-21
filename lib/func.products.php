<?php

function getLatest_addedCards($limit, $objDb) {
	$res = $objDb->select_table_join('SELECT * FROM cards LEFT JOIN categories ON(cards.cat_id = categories.cat_id)', 'categories.cat_id = 1', 'rand()', $limit);
	return $res;
}

function getCard_byId($card_id, $objDb) {
	$res = $objDb -> select_table_join('SELECT * FROM cards LEFT JOIN categories ON(cards.cat_id = categories.cat_id)', 'cards.card_id="' . mysql_real_escape_string($card_id) . '"');
	$rec = mysql_fetch_array($res);
	return $rec;
}

function getMatchingCards_byCatId($card_id, $card_code) {
	$sql = "
	SELECT * FROM cards matching
	WHERE card_code = '{$card_code}' AND card_id <> $card_id
	ORDER BY cat_id
	LIMIT 6
	";
	$res = mysql_query($sql) or die("getMatchingCards_byCatId<br/>$sql" . mysql_error());
	return $res;
}

function getCard_unitLowestPrice($card_id, $objDb) {
	$res = $objDb->SelectTable('cards_and_papertype_relation_with_pricing', 'quantity, price', "card_id={$card_id} AND quantity IS NOT NULL AND price IS NOT NULL AND quantity > 1", 'quantity DESC', '', '1');
	if (mysql_num_rows($res) > 0) {
		$rec = mysql_fetch_array($res);
		$quantity = $rec['quantity'];
		$price = $rec['price'];
		if ($price > 0) {
			$unit_price = round($price/$quantity, 2);
			//return $price;
			return $unit_price;
		} else
			return false;
	} else
		return false;

}

function getCards_byCatId($cat_id, $objDb) {
	$res = $objDb->SelectTable('cards', '*', 'cat_id="' . mysql_real_escape_string($cat_id) . '" AND is_active = 1', "sort_order ASC");

	return $res;

}

function getCards_byKeyword($keyword, $objDb) {
	$res = $objDb->SelectTable('cards', '*', 'card_title LIKE "%' . mysql_real_escape_string($keyword) . '%" OR card_code LIKE "%' . mysql_real_escape_string($keyword) . '%" OR card_description LIKE"%' . mysql_real_escape_string($keyword) . '%"');
	return $res;
}

function getCatName_byId($cat_id, $objDb) {
	$res = $objDb->SelectTable('categories', 'cat_title', 'cat_id="' . $cat_id . '"');
	if (mysql_num_rows($res) > 0) {
		$rec = mysql_fetch_array($res);
		return $rec['cat_title'];
	} else
		return false;
}

function cancel_order($gid, $customer_id, $objDb) {
	$res = $objDb->DeleteTable('customer_guests', 'guest_id= "' . $gid . '" AND customer_id="' . $customer_id . '"');
	return $res;
}

function get_card_paper_sets($card_id) {
	/*
	$sql = "
		SELECT 
			pt.paper_name, 
			pt.paper_color_name, 
			pt.paper_weight, 
			pt.paper_id,
			GROUP_CONCAT( 
				cpr.card_paper_relation_id,  '||',
				cpr.quantity,  '||',
				cpr.price
				ORDER BY cpr.quantity ASC
				SEPARATOR  '{data}'
				
			) AS data
		FROM paper_types AS pt
		LEFT JOIN cards_and_papertype_relation_with_pricing AS cpr ON cpr.paper_id = pt.paper_id
		WHERE cpr.card_id = $card_id
		AND cpr.quantity > 1
		AND cpr.price > 0
		GROUP BY pt.paper_id
		ORDER BY pt.paper_id ASC
		";
		*/
	//echo $sql;
	 $sql = "
		SELECT 
			pt.paper_name, 
			pt.paper_color_name, 
			pt.paper_weight, 
			pt.paper_id,
			cpr.card_paper_relation_id,
			cpr.quantity,
			cpr.price
		FROM paper_types AS pt
		LEFT JOIN cards_and_papertype_relation_with_pricing AS cpr ON cpr.paper_id = pt.paper_id
		WHERE cpr.card_id = '".$card_id."'
		AND cpr.quantity > 1
		AND cpr.price > 0
		ORDER BY cpr.quantity ASC
	";
	$res = mysql_query($sql) or die("get_card_paper_sets</br>$sql" . mysql_error());
	return $res;
}

function getMatchingCards($card_ids) {
	$sql = "
	SELECT * FROM cards
				LEFT JOIN categories ON(cards.cat_id = categories.cat_id)
				WHERE cards.card_code IN ( SELECT card_code FROM cards WHERE card_id IN ({$card_ids}) )
				AND cards.card_id NOT IN ($card_ids)
				ORDER BY cards.card_code DESC ";
				
	$res = mysql_query($sql) or die("getMatchingCards<br/>$sql" . mysql_error());
	return $res;
}