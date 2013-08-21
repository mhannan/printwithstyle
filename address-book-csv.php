<?php
include 'config/config.php';
extract($_REQUEST);
if ( !isset( $_SESSION['user_id'] ) || ( $_SESSION['user_id'] == 'NULL' ) ) {
	header( "Location: " . siteURL . "login-box.php?item_id={$item_id}&qty={$qty}" );
	exit;
}

$msg = '';
if ( isset( $upload_csv ) ) {
	if ( !$_FILES['sample_csv']['error'] ) {
		//ini_set("auto_detect_line_endings", TRUE);
		$file = $_FILES['sample_csv']['tmp_name'];
		$row = 0;
		if (($handle = fopen($file, "r")) !== FALSE) {
			while ( ($data = fgetcsv($handle, 2000, ",") ) !== FALSE) {
				$num = count($data);
				$first =  strtolower($data[0]);
				if ( strpos($first, 'name' ) === FALSE && strpos($first, 'use' ) === FALSE && !empty($first) ) {
					$row++;
					list(
						$_name,
						$_address,
						$_city,
						$_state, 
						$_zip,
						$_country
					) = $data;
					
					$recipient_address['_name'] = $_name;
					$recipient_address['_address'] = $_address;
					$recipient_address['_city'] = $_city;
					$recipient_address['_state'] = $_state;
					$recipient_address['_zip'] = $_zip;
					$recipient_address['_country'] = $_country;
					
					$return_address_col = mysql_escape_string( serialize( $recipient_address ) );
					$sql = "
					INSERT INTO " . TBL_GUESTS . " SET 
						guest_name = '$_name',
						recipient_address = '$return_address_col', 
						customer_id = {$_SESSION['user_id']}
					";
					//echo $sql; 
					mysql_unbuffered_query( $sql ) or die ( "Import error<br/>$sql</br/>" . mysql_error() );
				}
			}
			fclose($handle);
		}
		//ini_set("auto_detect_line_endings", FALSE);
		
		if ( $row > 0 ){
			$msg = "$row guest(s) inserted successfully.  <a href='address-book.php?item_id={$item_id}&qty={$qty}'>Continue</a>";
		}
	}
	
}

?>
<link href="<?php echo siteURL;?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo siteURL;?>js/jquery.min.js"></script>

<div class="popup_content">
	<ul class="return_address">
		<li>
			<h3>Upload Addresses</h3>
			<div class="return_address-section" style="opacity: 1; height: auto; ">
				<div class="return_address-content">
					<a href='<?php echo siteURL . 'uploads/sample.csv'; ?>'>Download</a> our sample csv<br/>
					A CSV file has a similar format to an Excel Spreadsheet. Type in the guest address information using the template in the Sample CSV and then upload the file. 
				</div>
				<div class="return_address-content">
					<form action="" method="post" enctype="multipart/form-data">
						<input type='hidden' name='item_id' value='<?php echo $item_id; ?>' />
						<input type='hidden' name='qty' value='<?php echo $qty; ?>' />
						<input type='file' name='sample_csv' id='sample_csv' /><br/>
						<input type='submit' class="btn_normal" value="Upload" name='upload_csv' id='upload_csv' /><br/><br/>
						<a href='<?php echo siteURL . "address-book.php?item_id={$item_id}&qty={$qty}"; ?>'>Return to Address Book</a>
					</form>
					<script type='text/javascript'>
						jQuery(document).ready(function($){
							$("#upload_csv").live ('click', function(){
								var csv_file = $("#sample_csv").val(); 
								if ( csv_file == '' ) {
									alert("Select CSV file"); return false; 
								}
								
								csv_file = csv_file.split('.');
								csv_file.reverse();
								var ext = csv_file[0].toLowerCase();
								
								if ( ext != 'csv' ) {
									alert("Provide valid CSV file"); return false;
								}
								return true;
							});
						});
					</script>
				</div>
			</div>
		</li>
		<li>
			<div class="return_address-section" style="opacity: 1; height: auto; ">
				<div id="recipients" class="return_address-content">
					<div class="recipient_Wrpp">
						<?php echo isset($msg) ? $msg : NULL; ?>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div> <!-- popup_wrapp -->