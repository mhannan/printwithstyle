<?php
function getEvent_info($event_id = '') {
	if ($event_id == '')
		$sql = "SELECT * FROM events ORDER BY event_id ASC";
	else
		$sql = "SELECT * FROM events WHERE event_id = '{$event_id}'";
	$rSet = mysql_query($sql);
	return $rSet;
}

function getEventTitle_byId($event_id) {
	$res = getEvent_info($event_id);
	$row = mysql_fetch_array($res);
	return $row['event_title'];
}

function event_designs_received_count($event_id = '') {
	$sql = "SELECT * FROM event_designs_submitted WHERE event_id='{$event_id}'";
	$res = mysql_query($sql);
	$count = mysql_num_rows($res);
	return $count;
}

function addEvent($post) {
	extract($post);
	$event_title = mysql_real_escape_string($event_title);
	$start_date = mysql_real_escape_string($start_date);
	$end_date = mysql_real_escape_string($end_date);
	$description = mysql_real_escape_string($event_description);

	$sql_1 = sprintf("
		INSERT INTO events 
		(event_title, start_date, end_date, description, prize) 
		VALUES ('%s','%s','%s','%s','%s')", 
		$event_title, $start_date, $end_date, $description, $winner_prize
	);

	$returnData = array();
	if (mysql_query($sql_1) or die(mysql_error())) {
		$okmsg = base64_encode("Information added successfully");
		$returnData[0] = "1";
		$returnData[1] = $okmsg;
	} else {
		$errmsg = base64_encode("Unable to add information due to : " . mysql_error());
		$returnData[0] = "0";
		$returnData[1] = $errmsg;
	}
	return $returnData;

}

function updateEvent($post) {
	extract($post);
	$event_title = mysql_real_escape_string($event_title);
	$start_date = mysql_real_escape_string($start_date);
	$end_date = mysql_real_escape_string($end_date);
	$description = mysql_real_escape_string($event_description);

	$sql_1 = sprintf("
		UPDATE events SET 
		event_title= '%s' , 
		start_date='%s', 
		end_date='%s', 
		description='%s', 
		prize='%s'
		WHERE event_id='%s'", 
		$event_title, $start_date, $end_date, $description, $winner_prize, $event_id
	);

	$returnData = array();
	if (mysql_query($sql_1) or die(mysql_error())) {
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

function deleteEvent($event_id) {
	$sql = "DELETE FROM events WHERE event_id = '{$event_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}

function getEvent_designs($event_id, $orderby = '') {
	if ($orderby != '')
		$sql = " SELECT * FROM event_designs_submitted WHERE event_id='{$event_id}' ORDER BY " . $orderby;
	else
		$sql = " SELECT * FROM event_designs_submitted WHERE event_id='{$event_id}'";
	$res = mysql_query($sql);

	return $res;
}

function mark_winner($design_id) {
	$sql = "UPDATE event_designs_submitted SET winning_status='1' WHERE event_design_id='{$design_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}

function unmark_winner($design_id) {
	$sql = "UPDATE event_designs_submitted SET winning_status='0' WHERE event_design_id='{$design_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}