<?php
/*
								//database server
define('DB_SERVER', "sendwithstyle.db.8934688.hostedresource.com");
								//database login name
define('DB_USER', "sendwithstyle");
								//database login password
define('DB_PASS', "DSSdss786");
								//database name
define('DB_DATABASE', "sendwithstyle");

if($_SERVER['SERVER_NAME'] == 'designsoftstudios.net')
	define('siteURL', 'https://designsoftstudios.net/demo22/custom_projects/invitation_card/');
else
	define('siteURL', 'https://www.sendwithstyle.com/');

*/

								//database server
define('DB_SERVER', "localhost");
								//database login name
define('DB_USER', "root");
								//database login password
define('DB_PASS', "");
								//database name
define('DB_DATABASE', "dss_custom_invitationcard");

define('siteURL', 'http://localhost/invitation_card/');


define('JS_PATH', siteURL . 'js/');
define('BLANK_CARDS', siteURL . 'uploads/blank_cards/');
define('adminBlogSectionFilePath', siteURL . "uploads/blog_images");

define( 'CUSTOMER_CARDS_VIEW', siteURL . "uploads/customer_cards/" );
define( 'ENVELOPES', siteURL . 'uploads/card_envelops/');
define('ONE_ENVELOPE_COST', "0.15");
define('ADDRESS_ENVELOPE_COST', "0.60");
define('ADDRESS_STAMP_COST', "0.95");
define('MAIL_ENVELOPE_COST', "1.45");
define('RESPONSE_ADDRESS_ENVELOPE_COST', "0.50");

 /*
// Local Server Setting

							//database server
define('DB_SERVER', "localhost");
								//database login name
define('DB_USER', "root");
								//database login password
define('DB_PASS', "");
								//database name
define('DB_DATABASE', "basdemos_gas");

define('siteURL', 'http://localhost/gas4/');
*/
$link_id = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
if(!mysql_select_db(DB_DATABASE, $link_id)){
 die('<body style="background-color:#B21515"><div style="margin-top:100px; margin-left:auto; margin-right:auto; padding:10px; background-color:#fff; color:#B21515">Unable to connect database.</div></body>');
}

?>