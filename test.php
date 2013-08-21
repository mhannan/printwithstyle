<?php
include 'config/config.php';
?>
<html>
<head>
<title>Text Customization Demo</title>
</head>
<body>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.dd.js"></script>
<link href="css/dd.css" rel="stylesheet" type="text/css" />
<div style="overflow: hidden; position: relative; float: left; background-image: url('uploads/blank_cards/1_061312100211.png'); width: 600px; height: 840px;" id="page_workArea">
	<div id="container" style="height: 571px;margin: 133px;width: 330px;">
		
	</div>
</div>
<div id="editor_boxes" style="float: left; margin-left: 20px; width: 400px; border: 1px solid #000; height: auto; padding: 20px;">
	<label>Main Text Font</label><br/>
	<?php
	$sql = "
	SELECT * FROM " . TBL_FONTS . " WHERE font_id > 10 ORDER BY font_label ASC	";
	$fonts = mysql_query($sql) or die ( "Get Font for Box</br>$sql<br/>" . mysql_error() );
	if ( mysql_num_rows( $fonts ) ) {
		echo "<select name='main_font' id='main_font' onchange='generate_image()'>";
		while ($font = mysql_fetch_object( $fonts ) ) {
			echo "<option value='{$font->font_path}' title='".FONTS_PREVIEW."$font->font_preview_image' >{$font->font_label}</option>";
		}
		echo "</select>";
	}
	
	for ($s = 8; $s <= 40; $s++ ) {
		$sel = $s == 24 ? ' selected="selected" ' : NULL;
		$sizes .= "<option value='{$s}' $sel>{$s}</option>";
	}
	echo "<br/><label>Main Text Size</label><br/>";
	echo "<select id='main_size'>$sizes</select><br/>";
	
	echo "
	<table><tr><td>
	<label for='mc_1' style='background-color: #603813; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='main_color' checked='checked' name='mc[]' id='mc_1' value='603813' style='position: absolute; left: -9999px;'/>
	<label for='mc_2' style='background-color: #bfd63a; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='main_color' name='mc[]' id='mc_2' value='bfd63a' style='position: absolute; left: -9999px;'/>
	<label for='mc_3' style='background-color: #000000; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='main_color' name='mc[]' id='mc_3' value='000000' style='position: absolute; left: -9999px;'/>
	</td><td>
	<label for='ma_1' style='background: url(images/align-left.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='main_align' name='ma[]' id='ma_1' value='left' style='position: absolute; left: -9999px;'/>
	<label for='ma_2' style='background: url(images/align-center.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='main_align' name='ma[]' id='ma_2' value='center' style='position: absolute; left: -9999px;'  checked='checked'/>
	<label for='ma_3' style='background: url(images/align-right.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='main_align' name='ma[]' id='ma_3' value='right' style='position: absolute; left: -9999px;'/>
	</td></tr></table>
	";
	?>
	<hr />
	<label>Couple Text Font</label><br/>
	<?php
	$sql = "
	SELECT * FROM " . TBL_FONTS . " ORDER BY font_label ASC	";
	$fonts = mysql_query($sql) or die ( "Get Font for Box</br>$sql<br/>" . mysql_error() );
	if ( mysql_num_rows( $fonts ) ) {
		echo "<select name='couple_font' id='couple_font' onchange='generate_image()'>";
		while ($font = mysql_fetch_object( $fonts ) ) {
			echo "<option value='{$font->font_path}' title='".FONTS_PREVIEW."$font->font_preview_image' >{$font->font_label}</option>";
		}
		echo "</select>";
	}
	echo "<br/><label>Couple Text Size</label><br/>";
	echo "<select id='couple_size'>$sizes</select><br/>";
	echo "
	<table><tr><td>
	<label for='cc_1' style='background-color: #603813; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='couple_color' checked='checked' name='cc[]' id='cc_1' value='603813' style='position: absolute; left: -9999px;'/>
	<label for='cc_2' style='background-color: #bfd63a; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='couple_color' name='cc[]' id='cc_2' value='bfd63a' style='position: absolute; left: -9999px;'/>
	<label for='cc_3' style='background-color: #000000; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='couple_color' name='cc[]' id='cc_3' value='000000' style='position: absolute; left: -9999px;'/>
	</td><td>
	<label for='ca_1' style='background: url(images/align-left.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='couple_align' name='ca[]' id='ca_1' value='left' style='position: absolute; left: -9999px;'/>
	<label for='ca_2' style='background: url(images/align-center.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='couple_align' name='ca[]' id='ca_2' value='center' style='position: absolute; left: -9999px;' checked='checked'/>
	<label for='ca_3' style='background: url(images/align-right.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='couple_align' name='ca[]' id='ca_3' value='right' style='position: absolute; left: -9999px;'/>
	</td></tr></table>
	";
	?>
	<style type="text/css">
		textarea { 
			overflow:hidden; height:auto; width:300px;
		}
		
		#main_font, #couple_font { 
			/*height:35px;*/
		}

		#box_1 {
			border: 1px solid #000; border-bottom: medium none; padding:0px; margin:0px; margin-left: 50px;
		}
		#box_2 {
			border: 1px solid #000; border-top: medium none; border-bottom: medium none;  padding:0px; margin:0px; margin-left: 50px; 
		}
		#box_3 {
			border: 1px solid #000; border-top: medium none;  padding:0px; margin:0px; margin-left: 50px; 
		}
		
	</style>
	
	<hr>
	<textarea id='box_1' style=""><?php echo trim("
Mr. & Mrs. Dennis Porter and 
Mr. & Mrs. Samuel Evans
request the pleasure of your company
at the marriage of their children"); ?></textarea>
	<textarea id='box_2' style=""><?php echo trim("
Elizabeth Anne Porter
&
Brian Alexander Evans");?></textarea>
	<textarea id='box_3' style=""><?php echo trim("
Saturday, the first of October
two thousand and twelve
six o`clock in the evening
Marriott Denver West
1243 Elton Avenue, Denver, Colorado
Reception to follow"); ?></textarea>

<div id="dv_hidden" style="height: auto;"></div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#main_font, #couple_font").msDropDown({style: 'background-color: #efefef; color: #efefef; length: 100%; width: 150px; height: 23px;'});

		jQuery.fn.autoGrow = function(){
			return this.each(function(){
				// Variables
				var colsDefault = 40;
				var rowsDefault = this.rows;
				
				//Functions
				var grow = function() {
					growByRef(this);
				}
				
				var growByRef = function(obj) {
					var linesCount = 0;
					var lines = obj.value.split('\n');
					
					for (var i=lines.length-1; i>=0; --i) {
						linesCount += Math.floor((lines[i].length / colsDefault) + 1);
					}
		
					if (linesCount >= rowsDefault)
						obj.rows = linesCount + 1;
					else
						obj.rows = rowsDefault;
				}
				
				var characterWidth = function (obj){
					var characterWidth = 0;
					var temp1 = 0;
					var temp2 = 0;
					var tempCols = obj.cols;
					
					obj.cols = 1;
					temp1 = obj.offsetWidth;
					obj.cols = 2;
					temp2 = obj.offsetWidth;
					characterWidth = temp2 - temp1;
					obj.cols = tempCols;
					
					return characterWidth;
				}
				
				// Manipulations
				this.style.width = "auto";
				this.style.height = "auto";
				this.style.overflow = "hidden";
				this.style.width = ((characterWidth(this) * colsDefault) + 6) + "px";
				//this.style.width = "300px";
				this.onkeyup = grow;
				this.onfocus = grow;
				this.onblur = grow;
				growByRef(this);
			});
		};
		
		
		
		
		
		
		
		
		generate_image = function() {
			$("#dv_hidden").html("Processing..... please wait");
			var url = '';
			
			var _param = "";
			_param += "w=" + $("#container").width();
			_param += "&h=" + $("#container").height();
			_param += "&mains[]=" + $("#main_font").val();
			_param += "&mains[]=" + $("#main_size").val();
			_param += "&couples[]=" + $("#couple_font").val();
			_param += "&couples[]=" + $("#couple_size").val();
			_param += "&mains[]=" + $(".main_color:checked").val();
			_param += "&couples[]=" + $(".couple_color:checked").val();
			_param += "&mains[]=" + $(".main_align:checked").val();
			_param += "&couples[]=" + $(".couple_align:checked").val();
			_param += "&texts[]=" + encodeURIComponent($("#box_1").val());
			_param += "&texts[]=" + encodeURIComponent($("#box_2").val());
			_param += "&texts[]=" + encodeURIComponent($("#box_3").val());
			
			var _url = "<?php echo siteURL;?>test_image.php?"+ _param;
			
			//alert(_url);
			var img = new Image();
			var show_alert = false;
			img.onload = function() {
				var height = this.height;
				var width = this.width;
				var _w = parseInt($("#container").width());// + 280;
				var _h = parseInt($("#container").height());
				
				var _str = "Original Width: " + _w;
				_str += "<br/>Generated Width: " + width;
				_str += "<br/>Original Height: " + _h;
				_str += "<br/>Generated Height: " + height;
				$("#dv_hidden").html(_str);
				if ( height > _h || width > _w ) {
					show_alert = true;
				}
				if ( show_alert ) {
					$("#editor_boxes").css({'border' : '1px solid #D04947', 'background-color' : "#FFAD32" });
				} else {
					$("#editor_boxes").css({'border' : '1px solid #000000', 'background-color' : "#FFF" });
				}
				
				$("#container").css( {
					'background-image' : "url('" + _url + "')",
					'background-repeat' : "no-repeat",
					'background-position' : 'center center'
				});
				
				//$("#dv_hidden").html(" ");
			}
			img.src = _url;
			
			
			
			
		};
		
		$("#box_1, #box_2, #box_3, #main_font, #main_size, #couple_font, #couple_size, .main_color, .couple_color, .main_align, .couple_align").live ('change', generate_image);
		
		generate_image();
				
		$("#box_1, #box_2, #box_3").autoGrow();
		//$("#box_1, #box_2, #box_3").trigger('keyup');
	});
</script>
</body>
</html>