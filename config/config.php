<?php
error_reporting(0);
session_start();
require_once("clsDatabaseManager.php");
include_once("constants.php");
include_once("connect.php");
include_once("functions.php");

$today = date("Ymd");
$currentYear=date('Y');
$currentMonth=date('m');
$currentDateTime=date('y-m-d h:m:s a');

$objDb=new clsDatabaseManager();
if ( function_exists( 'date_default_timezone_set' ) ) {
	date_default_timezone_set('Asia/Karachi');
}


$wording_date = date( "M j, Y" );
$wording_time = date( "h:i A" ); 
$wedding_wordings = array(
'couples_parents_names' => 	array(
trim("Together with
<!--GP-->Mr. & Mrs. Dennis Porter<!--GP--> and
<!--BP-->Mr. & Mrs.Samuel Evans<!--BP--><!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->and<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
request the pleasure of your company
at the  celebration of their union
<!--D-->Saturday, the first of October
two thousand and twelve<!--D-->
<!--T-->six o`clock in the evening<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"),
trim("Together with
<!--GP-->Mr. & Mrs. Dennis Porter<!--GP--> and
<!--BP-->Mr. & Mrs.Samuel Evans<!--BP--><!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->and<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
request the pleasure of your company
at the  celebration of their union
<!--D-->$wording_date<!--D-->
<!--T-->$wording_time<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
")
, '10', 'GP|BP|B|AND|G|D|T|A1|A2|A3'
),
'couples_names_only' =>
array(
trim("
Together with their parents<!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->and<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
request the pleasure of your company
at the celebration of their union
<!--D-->Saturday, the first of October
two thousand and twelve<!--D-->
<!--T-->six o`clock in the evening<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"),
trim("
Together with their parents<!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->and<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
request the pleasure of your company
at the celebration of their union
<!--D-->$wording_date<!--D-->
<!--T-->$wording_time<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"), '8', 'B|AND|G|D|T|A1|A2|A3'
), 
'bride_groom_standard' =>
array(
trim("<!--GP-->Mr. & Mrs. Dennis Porter<!--GP--> and
<!--BP-->Mr. & Mrs. Samuel Evans<!--BP-->
request the pleasure of your company
at the marriage of their children<!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->and<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->Saturday, the first of October
two thousand and twelve<!--D-->
<!--T-->six o`clock in the evening<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"),
trim("<!--GP-->Mr. & Mrs. Dennis Porter<!--GP--> and
<!--BP-->Mr. & Mrs. Samuel Evans<!--BP-->
request the pleasure of your company
at the marriage of their children<!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->and<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->$wording_date<!--D-->
<!--T-->$wording_time<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"), '10', 'GP|BP|B|AND|G|D|T|A1|A2|A3'
),
'bride_groom_4set' => 
array(
trim("<!--GP-->Mr. & Mrs. Dennis Porter<!--GP-->
<!--GP2-->Mr. & Mrs. Peter Miller<!--GP2-->
<!--BP-->Mr. & Mrs. Samuel Evans<!--BP--> and
<!--BP2-->Mr. & Mrs. Adam Nelson<!--BP2-->
request the pleasure of your company
at the marriage of their children<!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->and<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->Saturday, the first of October
two thousand and twelve<!--D-->
<!--T-->six o`clock in the evening<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"),
trim("<!--GP-->Mr. & Mrs. Dennis Porter<!--GP-->
<!--GP2-->Mr. & Mrs. Peter Miller<!--GP2-->
<!--BP-->Mr. & Mrs. Samuel Evans<!--BP--> and
<!--BP2-->Mr. & Mrs. Adam Nelson<!--BP2-->
request the pleasure of your company
at the marriage of their children<!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->and<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->$wording_date<!--D-->
<!--T-->$wording_time<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"), '12', 'GP|GP2|BP|BP2|B|AND|G|D|T|A1|A2|A3'
),
'bride_parent_standard' => 
	array(
trim("
<!--BP-->Mr. & Mrs. Dennis Porter<!--BP-->
request the pleasure of your company
at the marriage of their daughter<!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->to<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->Saturday, the first of October
two thousand and twelve<!--D-->
<!--T-->six o`clock in the evening<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"),
trim("
<!--BP-->Mr. & Mrs. Dennis Porter<!--BP-->
request the pleasure of your company
at the marriage of their daughter<!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->to<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->$wording_date<!--D-->
<!--T-->$wording_time<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
")
, '9', 'BP|B|AND|G|D|T|A1|A2|A3'
),
'bride_parent_2set' => 
array(
trim("
<!--BP-->Mr. & Mrs. Dennis Porter<!--BP--> and
<!--BP2-->Mr. & Mrs. Peter Miller<!--BP2-->
request the pleasure of your company
at the marriage of their daughter<!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->to<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->Saturday, the first of October
two thousand and twelve<!--D-->
<!--T-->six o`clock in the evening<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"),
trim("
<!--BP-->Mr. & Mrs. Dennis Porter<!--BP--> and
<!--BP2-->Mr. & Mrs. Peter Miller<!--BP2-->
request the pleasure of your company
at the marriage of their daughter<!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->to<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->$wording_date<!--D-->
<!--T-->$wording_time<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
")
, '10', 'BP|BP2|B|AND|G|D|T|A1|A2|A3'
),
'groom_parent_standard' => 
array(
trim("<!--GP-->Mr. & Mrs. Samuel Evans<!--GP-->
request the pleasure of your company
at the marriage of <!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->to their son<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->Saturday, the first of October
two thousand and twelve<!--D-->
<!--T-->six o`clock in the evening<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"),
trim("<!--GP-->Mr. & Mrs. Samuel Evans<!--GP-->
request the pleasure of your company
at the marriage of <!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->to their son<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->$wording_date<!--D-->
<!--T-->$wording_time<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"), '9', 'GP|B|AND|G|D|T|A1|A2|A3'
),
'groom_parent_2set' => 
array(
trim("
<!--GP-->Mr. & Mrs. Samuel Evans<!--GP--> and 
<!--GP2-->Mr. & Mrs. Adam Nelson<!--GP2-->
request the pleasure of your company
at the marriage of <!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->to their son<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->Saturday, the first of October
two thousand and twelve<!--D-->
<!--T-->six o`clock in the evening<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"),
trim("
<!--GP-->Mr. & Mrs. Samuel Evans<!--GP--> and 
<!--GP2-->Mr. & Mrs. Adam Nelson<!--GP2-->
request the pleasure of your company
at the marriage of <!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->to their son<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
<!--D-->$wording_date<!--D-->
<!--T-->$wording_time<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"), '10', 'GP|GP2|B|AND|G|D|T|A1|A2|A3'
),
'couple_hosting_standard' =>
array(
trim("
<!--dss--><!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->and<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
request the pleasure of your company
at the celebration of their union
<!--D-->Saturday, the first of October
two thousand and twelve<!--D-->
<!--T-->six o`clock in the evening<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
"),
trim("
<!--dss--><!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->and<!--AND-->
<!--G-->Brian Alexander Evans<!--G--><!--dss-->
request the pleasure of your company
at the celebration of their union
<!--D-->$wording_date<!--D-->
<!--T-->$wording_time<!--T-->
<!--A1-->Marriott Denver West<!--A1-->
<!--A2-->1243 Elton Avenue, Denver<!--A2-->, <!--A3-->Colorado<!--A3-->
Reception to follow
")
, '8', 'B|AND|G|D|T|A1|A2|A3'
)
);

function replace_sample_with_dynamic( &$sample, $col, $replace_with, $date_time_wording = NULL ) {
	
	if ( $col == 'T' || $col == 'D' || $col == 'RD' || $col == 'A' ) {
		return;
	} else if ( $col == 'date' ) {
		$len = $date_time_wording == 9 ? "<!--RD-->" : "<!--D-->";
		$day = $replace_with['d'];
		$month = $replace_with['m'];
		$year = $replace_with['y'];
		$month_name = get_month_name_by_number( $month, NULL );
		$day_num = int_to_words($day);
		
		if ( !$date_time_wording ) {
			//Saturday, the first of October, two thousand twelve
			$date = "$year-$month-$day";
			$replace_day = get_month_name_by_number( NULL, $date );
			$year_words = int_to_words($year);
			$day_num = day_to_words($day);
			$replace_with = "{$replace_day}, the {$day_num} of {$month_name},\r\n{$year_words}";
		} else if ( $date_time_wording == "5" ) {
			$replace_with = "{$month}.{$day}.{$year}";
		} else if ( $date_time_wording == "2" ) {
			$replace_with = "{$month_name} {$day}, {$year}";
		} else if ( $date_time_wording == "3" ) {
			$day_num = day_to_words($day);
			$replace_with = "{$month_name} {$day_num}, {$year}";
		} else if ( $date_time_wording == "9" ) {
			$day_wordth = day_to_words($day);
			$replace_with = "{$day_wordth} of {$month_name}";
		} else {
			//May 8, 2012
			$replace_with = " $month_name $day, $year";
		}
	} else if ($col == 'time') {
		$len = "<!--T-->";
		$hour = (int)$replace_with['h'];
		$min = $replace_with['m'];
		$ampm = $replace_with['ampm'];
		if ( !$date_time_wording ) {
			//Six o’clock in the evening
			$hour = int_to_words( (int)$hour );
			$minute = (int)$min == '00' ? "$hour o`clock" : "Half Past $hour";
			$ampm = $ampm == 'PM' ? 'evening' : 'morning';
			$replace_with = "$minute in the $ampm";
		} else {
			//06:20 PM
			$replace_with = "{$hour}:{$min} $ampm";
		}
	} else {
		$len = "<!--$col-->"; // set the length of the placeholder	
	}
	

	$pos1 = $pos2 = 0;
	$pos1 = stripos( $sample, $len ); // get first occurance

	$pos2 = strrpos( $sample, $len ); // get last occurance
	$start =  (int)$pos1 + strlen($len); // add lenght of the placeholder 
	$length = (int)$pos2 - (int)$pos1 - strlen($len); // last position minus first position minus length of placeholder
	$text = substr( $sample, $start, $length );
	//echo "<br/>" . $text . " -> " . $replace_with . "<br/>";
	//$replace_with = empty($replace_with) && ($text == '&' || strtolower($text) == 'and' ) ? $text : $replace_with;
	$replace_with = $len == "<!--AND-->" ? $text : $replace_with; 
	$sample = str_replace( $text, $replace_with, $sample );
}


function get_name_by_code_wordings( $code ) {
	switch ( $code ) {
		case 'B' : {
			return "Bride's Name:"; break;
		}
		case 'BP' : {
			return "Bride's Parents Name:"; break;
		}
		case 'BP2' : {
			return "Bride's Parents 2nd Name:"; break;
		}
		case 'G' : {
			return "Groom's Name:"; break;
		}
		case 'GP' : {
			return "Groom's Parents Name:"; break;
		}
		case 'GP2' : {
			return "Groom's Parents 2nd Name:"; break;
		}
		case 'D' : {
			return "Event Date:"; break;
		}
		case 'RD' : {
			return "Date the Response is Requested:"; break;
		}
		case 'T' : {
			return "Event Time:"; break;
		}
		case 'A1' : {
			return "Location:"; break;
		}
		case 'A2' : {
			return "Street Address:"; break;
		}
		case 'A3' : {
			return "City, State:"; break;
		}
		/* enclosure cards */
		case 'T1' : {
			return "Title:"; break;
		}
		case 'TT1' : {
			return "Title (such as ‘Event Details’ or ‘Reception’):"; break;
		}
		case 'T2' : {
			return "Content / Description:"; break;
		}
		case 'ET2' : {
			return "Content / Description:"; break;
		}
		case 'P' : {
			return "Phone:"; break;
		}
		case 'E1' : {
			return "Entrée One (Optional):"; break;
		}
		case 'E2' : {
			return "Entrée Two (Optional):"; break;
		}
		case 'E3' : {
			return "Entrée Three (Optional):"; break;
		}
		case 'U' : {
			return "Website: (Optional)"; break;
		}
		
		case 'BG' : {
			return "Couple Name:"; break;
		}
		
		case 'AND' : {
			return ""; break;
		}
		
		case 'TY' : {
			return "Thank You Text:";
			break;
		}
	}
}



$nwords = array("Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen", "Twenty", 30 => "Thirty", 40 => "Forty", 50 => "Fifty", 60 => "Sixty", 70 => "Seventy", 80 => "Eighty", 90 => "Ninety" ); 
function int_to_words( $x ) {
	global $nwords;
	if(!is_numeric($x)){
		$w = '#';
	}else if(fmod($x, 1) != 0){
		$w = '#'; 
	}else{
		if($x < 0){
			$w = 'minus ';
			$x = -$x;
		} else {
			$w = '';
		}
		if($x < 21) {
			$w .= $nwords[$x];
		} else if($x < 100) {
			$w .= $nwords[10 * floor($x/10)];
			$r = fmod($x, 10); 
			if($r > 0) {
				$w .= '-'. $nwords[$r];
			}
		} else if($x < 1000) {
			$w .= $nwords[floor($x/100)] .' Hundred'; 
			$r = fmod($x, 100);
			if($r > 0) {
				$w .= ' and '. int_to_words($r);
			}
		} else if($x < 100000) {
			$w .= int_to_words(floor($x/1000)) .' Thousand';
			$r = fmod($x, 1000);
			if($r > 0) {
				$w .= ' '; 
				if($r < 100) {
					$w .= 'and ';
				}
				$w .= int_to_words($r);
			} 
		} else {
			$w .= int_to_words(floor($x/1000000)) .' Million';
			$r = fmod($x, 1000000);
			if($r > 0) {
				$w .= ' '; 
				if($r < 100) {
					$word .= 'and ';
				}
				$w .= int_to_words($r);
			} 
		}
	}
	return $w;
}

function html2rgb( $color = "#000000" ) {
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
	
	if ( strlen( $color ) >= 6 ) { /* greater than six is not valid hex color code we ignore extra characters and use 6 */
		list($r, $g, $b) = array( $color[0].$color[1], $color[2].$color[3], $color[4].$color[5] );
	} else if ( strlen( $color ) == 3 ) { /* double the three color code F0F > FF00FF */
		list($r, $g, $b) = array( $color[0].$color[0], $color[1].$color[1], $color[2].$color[2] );
	} else { 
		return false;
	}
	
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );
	/* 0 => Red, 1 => Green, 2 => Blue */
	return array( $r, $g, $b );
}


/* Ground, Third-Day, Second-Day, Next-Day */
global $shipping_payments;
$shipping_payments = array(
	"25" => array( "8.95", "14.45", "19.45", "29.25"),
	"50" => array( "11.95", "18.45", "23.45", "33.25"),
	"100" => array( "13.95", "22.45", "27.45", "37.25"),
	"125" => array( "15.95", "24.45", "29.45", "39.25"),
	"150" => array( "17.95", "26.45", "31.45", "41.25"),
	"175" => array( "19.95", "28.45", "33.45", "43.25"),
	"200" => array( "0.00", "28.45", "33.45", "43.25"),
	"2000000000000" => array( "0.00", "30.45", "35.45", "45.25")
); 

function generate_shipping_dd( $arr, $selected = NULL ) {
	$shipping_name = array(
	"Ground", "Third Day", "Second Day", "Next Day"
	);
	$dd = "<select name='shipping_price' id='shipping_price'>";
	$index = 0;
	foreach( $arr as $ar ) {
		$name = $shipping_name[$index];
		$value = "{$name}|{$ar}";
		$sel = $value == $selected ? ' selected="selected" ' : NULL;
		$dd .= "<option value='{$value}' $sel>{$name} (&#36; {$ar})";
		$index++;
	}
	$dd .= "</select>";
	return $dd;
}
function get_shipping_by_price( $price = 0 , $selected = NULL) {
	global $shipping_payments;
	foreach( $shipping_payments as $key => $val ) {
		if ( (float)$key >= $price ) {
			echo generate_shipping_dd($val, $selected);
			break;
		}
	}
}

$state_list;
$state_list = array(
	"Alabama",  
	"Alaska",  
	"Arizona",  
	"Arkansas",  
	"California",  
	"Colorado",  
	"Connecticut",  
	"Delaware",  
	"District Of Columbia",  
	"Florida",  
	"Georgia",  
	"Hawaii",  
	"Idaho",  
	"Illinois",  
	"Indiana",  
	"Iowa",  
	"Kansas",  
	"Kentucky",  
	"Louisiana",  
	"Maine",  
	"Maryland",  
	"Massachusetts",  
	"Michigan",  
	"Minnesota",  
	"Mississippi",  
	"Missouri",  
	"Montana",
	"Nebraska",
	"Nevada",
	"New Hampshire",
	"New Jersey",
	"New Mexico",
	"New York",
	"North Carolina",
	"North Dakota",
	"Ohio",  
	"Oklahoma",  
	"Oregon",  
	"Pennsylvania",  
	"Rhode Island",  
	"South Carolina",  
	"South Dakota",
	"Tennessee",  
	"Texas",  
	"Utah",  
	"Vermont",  
	"Virginia",  
	"Washington",  
	"West Virginia",  
	"Wisconsin",  
	"Wyoming"
);

/* save the date wording */
$enclosure_card = array(
trim("<!--TT1-->TITLE<!--TT1--><!--dss--><!--ET2-->DESCRIPTION<!--ET2-->"),
'2',
'TT1|ET2'
);

$accommodation_cart = array(
trim("<!--TT1-->TITLE<!--TT1--><!--dss--><!--ET2-->DESCRIPTION<!--ET2-->"),
'2',
'TT1|ET2'
); 

/*array(trim(
"<!--T1-->Accommodations<!--T1--><!--dss-->
<!--T2-->for your convenience, we`ve reserved a block<br/>
of rooms at the following hotel:<!--T2-->
<!--A1-->Broadmoor Hotel<!--A1--><br/>
<!--A2-->1 Lake Avenue, Colorado Springs<!--A2-->
<!--A3-->Colorado<!--A3-->
<!--P-->719-577-5770<!--P-->
make your reservation by <!--D-->06.15.12<!--D-->
"), "7", "T1|T2|A1|A2|A3|P|D" 
);
*/


$response_card = array(
trim("<!--T1-->The Favor of your response is requested by the<!--T1--><!--dss-->
<!--RD-->The $wording_date<!--RD--><!--dss-->
M _ <!--dss-->
_ Joyfully Accepts<!--dss-->
_ Regretfully Declines<!--dss-->
Please initial the entrée choice for each guest<!--dss-->
_ <!--E1-->Grilled Salmon<!--E1--><!--dss-->
_ <!--E2-->Filet Mignon<!--E2--><!--dss-->
_ <!--E3-->Oven Roasted Chicken<!--E3--><!--dss-->
Or RSVP at <!--U-->www.ElizabethAndBriansWedding.com<!--U-->
"), "5", "E1|E2|E3|RD|U"
);

$save_the_date = array(
trim("<!--T1-->Save the Date for the wedding of<!--T1--> <!--dss-->
<!--B-->Elizabeth Anne Porter<!--B-->
<!--AND-->&<!--AND-->
<!--G-->Brian Alexander Evans<!--G--> <!--dss-->
are getting married on 
<!--D-->September 1st 2012<!--D-->
<!--A3-->Littleton, Colorado<!--A3-->
Formal invitation to follow
"), "6", "T1|B|AND|G|D|A3"
);


$thankyou_card = array(
trim("<!--T1-->Thank You<!--T1--><!--dss-->
<!--BG-->Elizabeth & Brian<!--BG-->"),
'2',
'T1|BG'
);

$thankyou_card_no_photo = array(
trim("
<!--TY-->Thank You<!--TY--><!--dss-->
<!--BG-->Elizabeth & Brian<!--BG-->"),
'2',
'TY|BG'
);