<?php
include 'config/config.php';
extract($_REQUEST);
/* get cards sample prices */
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
	WHERE cpr.card_id = {$item_id}
	AND cpr.quantity = 1
	AND cpr.price > 0
	GROUP BY pt.paper_id
	ORDER BY pt.paper_id ASC
";
$card_paper_sets = mysql_query($sql) or die ( "get_card_paper_sets</br>$sql" . mysql_error() );
	
$options_paper_types = '';
$dv_qty_prices = '';
if ( mysql_num_rows( $card_paper_sets ) ) {
	while ($paper = mysql_fetch_object( $card_paper_sets ) ) {
		$name = $paper->paper_name . ' ( ' . $paper->paper_color_name . ' - ' . $paper->paper_weight . ' )';
		$sel = isset($paper_type) && $paper_type == $paper->paper_id ? ' selected="selected" ' : NULL;
		$options_paper_types .= "<option value='$paper->paper_id' $sel>$name</option>";
		$qps = explode( '{data}', $paper->data );
		$dv_qty_prices .= "<textarea id='qp_$paper->paper_id' style='display:none; visibility: hidden;'>";
		foreach($qps as $qp) {
			$qp_data = explode('||', $qp);
			$val = "{$qp_data[0]}||{$qp_data[1]}||{$qp_data[2]}";
			$sel = isset($qty_price) && $qty_price == $val ? ' selected="selected" ' : NULL;
			$dv_qty_prices .= "<option value='$val' $sel>Quantity: {$qp_data[1]} - Price: $ {$qp_data[2]}</option>";		
		}
		$dv_qty_prices .= "</textarea>";
	}
}

echo $dv_qty_prices;
		
?>
<link href="<?php echo siteURL;?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo siteURL;?>js/jquery.min.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#paper_type").live ('change', function() {
			var _id = $("#paper_type").val();
			var _options = $("#qp_"+_id+"").val();
			$("#qty_price").html(_options);
			$("#qty_price").trigger('change');
		});
		$("#paper_type").trigger('change');
		
		$("#qty_price").live ('change', function() {
			var _sel_price = $("#qty_price").val().split('||');
			var _price = "Your Price : $ " + _sel_price[2];
			_price += "<br/>Your Quantity: " + _sel_price[1];
			$(".personalized_txt").html(_price);
		});
		$("#qty_price").trigger('change');
	});
</script>
<div class="popup_content">
	<ul class="return_address">
		<li>
			<h3>Select Paper Type and Quantity</h3>
			<div class="return_address-section" style="opacity: 1; height: auto; ">
				<div class="return_address-content">
					<form action='sample-add.php' method='post'>
						<input type='hidden' name='add_sample' value='1' />
						<input type='hidden' name='item_id' value='<?php echo $item_id; ?>' />
					<div class="detail_form_wrapp" style="margin-top:10px">
						<label>Paper Type:</label>
						<select name="paper_type" id="paper_type" style="width: 65%;">
							<?php echo $options_paper_types; ?>
						</select> <!-- type dropdown -->
					</div>
					<div class="detail_form_wrapp"  style="margin-top:10px">
						<label>Quantity:</label>
						<select name='qty_price' id="qty_price" style="width: 65%;"></select>
					</div>
					<div class="detail_form_wrapp"  style="margin-top:10px">
						<input type="submit" value="Add to Cart" class="personalized_btn" name="btnAddSampleToCart">
					</div>
					</form>
				</div>
			</div>
		</li>
	</ul>
</div> <!-- popup_wrapp -->