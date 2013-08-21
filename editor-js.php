<?php
if ( !defined( 'siteURL') ) { die("ALLAH-O-AKBAR"); }
$loading_url = siteURL . 'images/loading_image.gif';
echo "<img src='$loading_url' alt='tt' style='display:none; visibility: hidden;' />";
?>
<style type="text/css">
	div.edit_boxes {
		clear:both; 
		overflow: hidden;
	}
</style>
<script type="text/javascript">
	var validation = null;
	function generate_image(txtbox) {
		var _t = $(txtbox).val(); // || $(txtbox).text() || $(txtbox).html();
		
		//_t = escape(_t);
		_t = _t.replace(/’/g, "'");
		_t = _t.replace(/”/g, "'");
		_t = _t.replace(/–/g, '-');
		_t = _t.replace(/"/g, "'");
		
		$(txtbox).val(_t);
		var _id = $(txtbox).attr('rel');
		/* set default loading image */
		
		_loading = '<?php echo $loading_url;?>';
		
		$("#"+_id).css( { 
			'background-image' : "url('" + _loading + "')",
			'background-repeat' : "repeat"
		});
		
		
		var _w = $("#dimension_" + _id).val().split('_')[0];
		var _h = $("#dimension_" + _id).val().split('_')[1]-5;
		var _s = $(txtbox).parent().find('div.settings').find('.box_sizes').val();
		var _a = $(txtbox).parent().find('div.settings').find('.box_align:checked').val();
		var _f = $(txtbox).parent().find('div.settings').find('.box_fonts').val();
		//var _lh = $(txtbox).parent().find('div.settings').find('.box_lh').val();
		var _c = $(txtbox).parent().find('div.settings').find('.box_color:checked').val();
		//var _params = "w=" + _w + "&h=" + _h + "&lh=" + _lh + "&s=" + _s + "&a=" + _a + "&f=" + _f + "&c=" + _c + "&t=" + encodeURIComponent(_t);
		var _params = "w=" + _w + "&h=" + _h + "&s=" + _s + "&a=" + _a + "&f=" + _f + "&c=" + _c + "&t=" + escape(_t);
		var _url = "<?php echo siteURL;?>create_image.php?"+ _params;
		/* check the return image height width */
		
		var img = new Image();
		var show_alert = false;
		img.onload = function() {
			var height = this.height;
			var width = this.width;
			//if ( height > _h || width > _w ) {
			if ( width > _w ) {
				show_alert = true;
			}
			if ( show_alert ) {
				$(txtbox).css({'border' : '1px solid #D04947'}).parent().find("p.image_alert").show().css({ 'width' : $(txtbox).width() } );
			} else {
				$(txtbox).css({'border' : 'medium none'}).parent().find("p.image_alert").hide().css({ 'width' : "auto" } );
			}
			
			$("#"+_id).css( {
				'background-image' : "url('" + _url + "')",
				'background-repeat' : "no-repeat"
			});
		};
		img.src = _url;
	}
		
	jQuery(document).ready(function($){
		$("#<?php echo implode(', #', $box_style_ids); ?>").msDropDown({style: 'background-color: #efefef; color: #efefef; height: 23px; z-index: 99; margin-bottom: 10px;'});

		/* attach focus event on textarea to display settings */
		$("div.edit_boxes textarea").live ('focus', function() {
			$("div.settings").not($(this).parent().find('div.settings')).hide();
			$(this).parent().find('div.settings').show();
			
			$("div.edit_boxes").css({'border' : 'none medium'});
			
			$(this).parent().css({'border' : '3px solid #000'});
			
			$(".display_box").css({'height' : '80px'});
			$(this).css({'height' : '100px'});
		});
		
		$("div.edit_boxes textarea").each( function() {
			$(this).css({'width' : '300px', 'height' : '80px'});
		});
		
		
		/* attach change text event on textarea to update the display box text */
		$("div.edit_boxes textarea").live ('change', function() {
			generate_image( this); 
		});
		
		/* text align dropdown */
		$(".box_align").live ('change', function() {
			var $ele = $(this).parent().parent().find('textarea');
			generate_image( $ele );
		});
		
		
		/* font size dropdown */
		$(".box_sizes").live ('change', function() {
			var $ele = $(this).parent().parent().find('textarea');
			generate_image( $ele );
		});
		
		
		/* line height dropdown */
		$(".box_lh").live ('change', function() {
			var $ele = $(this).parent().parent().find('textarea');
			generate_image( $ele );
		});
		
		/* box color dropdown */
		$(".box_color").live ('change', function() {
			var $ele = $(this).parent().parent().find('textarea');
			generate_image( $ele );
			
			$(this).parent().find('.box_color').css({'border' : "2px solid #"+$(this).val() });
		});
		
		/* attach event on click event of the display box to show its settings */
		$(".card_content_holder_mobile").live ('click', function() {
			var _rel = $(this).attr('id');
			$("div.edit_boxes textarea[rel='"+_rel+"']").focus();
		});
		
		/* geneate the image by triggering any control event */
		$(".box_align").trigger('change');
	});
	
	
	
</script>