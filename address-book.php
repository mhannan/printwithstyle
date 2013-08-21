<?php
include 'config/config.php';
extract($_REQUEST);
if ( !isset( $_SESSION['user_id'] ) || ( $_SESSION['user_id'] == 'NULL' ) ) {
	header( "Location: " . siteURL . "login-box.php?item_id={$item_id}&qty={$qty}" );
	exit;
}

$where = "id = {$_SESSION['user_id']}";
$result = $objDb->SelectTable( USERS, "return_address", $where );
if ( mysql_num_rows( $result ) ) {
	$row = mysql_fetch_object( $result );
	$return_address = unserialize( $row->return_address );
} else {
	$return_address['return_name'] = '';
	$return_address['return_address'] = '';
	$return_address['return_city'] = '';
	$return_address['return_state'] = '';
	$return_address['return_zip'] = '';
	$return_address['return_country'] = '';
}
?>
<link href="<?php echo siteURL;?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo siteURL;?>js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo siteURL . "js/thickbox-compress.js";?>"></script> -->

<script type="text/javascript">
	jQuery(document).ready(function($){
		$("div#add_new_recipient").hide();
		$("a#add_recipient").live ('click', function() {
			$("div#add_new_recipient").slideToggle();
		});
		$("#btn_cancel_recipient").live ('click', function() {
			$("div#add_new_recipient").slideUp();
		});
		
		$("#btn_save").live ('click', function() {
			if ( $("#return_name").val() == '' ) {
				alert("provide name please.")
				$("#return_name").focus();
				return;
			} else if ( $("#return_address").val() == '' ) {
				alert("provide address please.")
				$("#return_address").focus();
				return;
			} else if ( $("#return_city").val() == '' ) {
				alert("provide city please.")
				$("#return_city").focus();
				return;
			} else if ( $("#return_state").val() == '' ) {
				alert("provide state please.")
				$("#return_state").focus();
				return;
			} else if ( $("#return_zip").val() == '' ) {
				alert("provide zip please.")
				$("#return_zip").focus();
				return;
			}
			
			dataString = $("form#frm_return_add").serializeArray();
			$.ajax({
			  type: "POST",
			  url: "<?php echo siteURL;?>process-ajax.php",
			  data: dataString,
			  success: function(ret) {
			  	$("#ret").html(ret);
			  	alert("Data has been saved successfully.");
						self.parent.set_returnAddressFlag();
			  	self.parent.tb_remove();
			  }
			});
			
		});
		
		$("#btn_add_recipient").live ('click', function() {
			if ( $("#_name").val() == '' ) {
				alert("provide name please.")
				$("#_name").focus();
				return;
			} else if ( $("#_address").val() == '' ) {
				alert("provide address please.")
				$("#_address").focus();
				return;
			} else if ( $("#_city").val() == '' ) {
				alert("provide city please.")
				$("#_city").focus();
				return;
			} else if ( $("#_state").val() == '' ) {
				alert("provide state please.")
				$("#_state").focus();
				return;
			} else if ( $("#_zip").val() == '' ) {
				alert("provide zip please.")
				$("#_zip").focus();
				return;
			}
			
			dataString = $("form#frm_new").serializeArray();
			$.ajax({
				type: "POST",
				url: "<?php echo siteURL;?>process-ajax.php",
				data: dataString,
				success: function(ret) {
					self.location.href = self.location.href;
					/*
					$("div#recipients table tbody").append(ret);
					
					$("#_name").val('');
					$("#_address").val('');
					$("#_city").val('');
					$("#_state").val('');
					$("#_zip").val('');
					$("#_country").val('');
                                    */
				}
			});
			$("#get_guests").show(); 
		});
		$("#get_guests").live ('click', function() {
			
			var chks = $(".chk_guests");
			var _valid = false;
			var counter = 0;
			var _comma_seperated = new Array();
			chks.each(function() {
				if ( $(this).is(':checked') ) {
					_valid = true;
					_comma_seperated[counter] = $(this).val();
					counter++;
				}
			});
			if ( _valid ) {
				if ( counter > <?php echo isset($qty) && !empty($qty) ? $qty : 1000; ?> ) {
					alert("There are more guest addresses selected than the number of cards purchased.\r\n\r\nPlease reduce the number of addresses or increase the number of cards purchased.")
				} else {
					var data = _comma_seperated.join(',');
					self.parent.set_guests(data, counter);
					self.parent.tb_remove();
				}
			} else {
				alert("Select atleast one recipient");
			}
		});
		
		$("#upload_csv").live ("click", function() {
			
			var chks = $(".chk_guests");
			var _valid = false;
			var counter = 0;
			var _comma_seperated = new Array();
			chks.each(function() {
				if ( $(this).is(':checked') ) {
					_valid = true;
					_comma_seperated[counter] = $(this).val();
					counter++;
				}
			});
			if ( _valid ) {
				var data = _comma_seperated.join(',');
				self.parent.set_guests(data, counter);
			}
			return true;
		});
		
		/* checked already selected guests from session */
		//var g_ids = '<?php echo $guests_ids; ?>';
		var g_ids = self.parent.get_guests();
		g_id = g_ids.toString().split(',');
		var _total = g_id.length;
		for(i = 0; i < _total; i++ ) {
			$("input[value='"+g_id[i]+"']").prop('checked', true);
		}
		
		$("ul.return_address > li h3").live ('click', function() {
			$("div.designers").not($(this).next()).hide();
			$(this).next().toggle();
		});
		$("div.designers").hide();
		
		var select_deselect_all = function(check){
			$(".chk_guests").each(function() {
				$(this).prop('checked', check);
			});
		};
		$("#chk_all").live ('click', function(){
			var chk = ( $(this).prop('checked') ) ? 'checked' : false;
			select_deselect_all(chk);
			$("#chk_none").prop('checked', false);
		});
		
		$("#chk_none").live ('click', function(){
			var chk = ( $(this).prop('checked') ) ? false : false;
			select_deselect_all(chk);
			$("#chk_all").prop('checked', false);
		});
		
		<?php
		 if(isset($_GET['showReturnAddressOnly']) && $_GET['showReturnAddressOnly']=='true')
			{
				 echo'				// if "showReturnAddressOnly=true" then show only RETURN ADDRESS Block
												$("ul.return_address li").hide();
												$("ul.return_address li:first").show();
												$(".return_address-content").show(); ';
			}
		?>
	});
</script>
<div class="popup_content">
	<ul class="return_address">
		<li>
			<h3>Enter the Return Address for your envelopes</h3>
				<div class="return_address-content designers">
				<form id="frm_return_add">
					<input type="hidden" name="call" value="save_return_address" />
					<table width="680" border="0">
						<tr>
							<td width="59"><label for="return_name">Name: </label></td>
							<td width="155">
								<input type="text" name="return_name"  id="return_name" value="<?php echo $return_address['return_name']; ?>" />
							</td>
							<td width="75"><label for="return_address">Address :</label></td>
							<td width="147">
								<input type="text" name="return_address" id="return_address" value="<?php echo $return_address['return_address']; ?>" />
							</td>
							<td width="61"><label for="return_city">City :</label></td>
							<td width="156">
								<input type="text" name="return_city" id="return_city" value="<?php echo $return_address['return_city']; ?>" />
							</td>
						</tr>
						<tr>
							<td><label for="return_state">State:</label></td>
							<td>
								<input type="text" name="return_state" id="return_state" value="<?php echo $return_address['return_state']; ?>" />
							</td>
							<td><label for="return_zip">Zip :</label></td>
							<td>
								<input type="text" name="return_zip" id="return_zip" value="<?php echo $return_address['return_zip']; ?>" />
							</td>
							<td><label for="return_country">Country :</label></td>
							<td>
								<input type="text" name="return_country" id="return_country" value="<?php echo $return_address['return_country']; ?>" />
							</td>
						</tr>
						<tr>
							<td colspan="6">
								<input type="button" value="Save & Close" id="btn_save" class="btn_normal" style="height: 30px;" />
							</td>
						</tr>
					</table>
				</form>
				</div>
		</li>
		<li>
			<h3><a href="#add-new" id="add_recipient">Add</a></h3>
			
			<div class="return_address-content designers">
				<form id="frm_new">
					<input type="hidden" name="call" value="save_new_recipient" />
					<em>Enter guest name exactly as you want it to appear on the invitation, i.e. 'Mr. and Mrs. Brian Johnson'</em>
					<table width="680" border="0">
					<tr>
						<td width="59"><label for="_name">Name: </label></td>
						<td width="155">
							<input type="text" id="_name" name="_name" />
						</td>
						<td width="75"><label for="_address">Address :</label></td>
						<td width="147">
							<input type="text" id="_address" name="_address" />
						</td>
						<td width="61"><label for="_city">City :</label></td>
						<td width="156">
							<input type="text" id="_city" name="_city" />
						</td>
					</tr>
					<tr>
						<td><label for="_state">State:</label></td>
						<td>
							<input type="text" id="_state" name="_state" />
						</td>
						<td><label for="_zip">Zip :</label></td>
						<td>
							<input type="text" id="_zip" name="_zip" />
						</td>
						<td><label for="_country">Country (optional):</label></td>
						<td>
							<input type="text" id="_country" name="_country" />
						</td>
					</tr>
					<tr>
						<td colspan="6">
							<input type="button" value="Add" id="btn_add_recipient" class='btn_normal' /> &nbsp;
							<input type="reset" value="Reset" class='btn_normal' /><br/><br/><br/>
							<a href="<?php echo siteURL . "address-book-csv.php?item_id={$item_id}&qty={$qty}"; ?>" 
								style="text-align: center!important; vertical-align: middle!important;padding-top: 7px!important;"
								class="btn_normal"
								id="upload_csv">Upload CSV</a><br/><br/><br/>
							Upload multiple addresses at once using our spreadsheet (CSV) template
							
						</td>
					</tr>
				</table>
				</form>
			</div>

		</li>
		<li>
			<h3>Recipients</h3>
				<div id="recipients" class="return_address-content designers">
					<div class="recipient_Wrpp">
						<form id="frm_guests">
						Select guests to send your invitations to:<br/><br/>
						<label for='chk_all' style='float:none;'>Select All</label><input type='checkbox' id='chk_all' />&nbsp; &nbsp;
						<label for='chk_none' style='float:none;'>Deselect All</label><input type='checkbox' id='chk_none' />
						<?php
							$where = "customer_id = {$_SESSION['user_id']}";
							$result = $objDb->SelectTable( TBL_GUESTS, "*", $where );
							if ( mysql_num_rows( $result ) ) {
								while ($row = mysql_fetch_object( $result ) ) {
									$data = unserialize( $row->recipient_address );
									$dv_class = $dv_class == "recipient_row" ? "recipient_row_odd" : "recipient_row"; 
								?>
								<div class="<?php echo $dv_class; ?>">
									<span>
										<input type='checkbox' value='<?php echo $row->guest_id;?>' name='guests[]' class='chk_guests' />
									</span>
									<label><?php echo $row->guest_name;?>&nbsp;&nbsp;:&nbsp;&nbsp;
									<?php echo "{$data['_address']}, {$data['_city']}, {$data['_state']} {$data['_zip']} {$data['_country']}";?></label>
								</div>
							<?php
								} // while 
							} // have recipients 
							?>
						</form>
						<?php
						$style = mysql_num_rows( $result ) ? 'display:block;' : 'display:none;';
						echo "<input type='button' id='get_guests' value='Continue'  class='btn_normal' style='$style' />";
						?>
					</div>
				</div>
		</li>
		
		
	</ul>
</div> <!-- popup_wrapp -->