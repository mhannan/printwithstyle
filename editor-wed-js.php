<?php
if ( !defined( 'siteURL') ) { die("ALLAH-O-AKBAR"); }
$loading_url = siteURL . 'images/loading_image.gif';
echo "<img src='$loading_url' alt='tt' style='display:none; visibility: hidden;' />";
?>
<script type="text/javascript">
jQuery(document).ready(function($){
		$("#main_font, #couple_font").msDropDown({style: 'background-color: #efefef; color: #efefef; length: 100%; width: 150px; height: 23px;'});


  /* avoiding two dropDown overlapping using z-index */
		   $('.dd').click(function(e){
									//alert('clicked');
									// first of all reset z-index of all classes and their children to normal
									$('.dd, .dd .ddTitle, .dd .ddChild').css('z-index','1');
									$(this,this +' .ddTitle',this +' .ddChild').css('z-index','9990');
									
					});
		/* avoiding two dropDown overlapping using z-index */
		
		
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
			$("#b1").css( { 
				'background-image' : "url('<?php echo $loading_url; ?>')",
				'background-repeat' : "repeat"
			});
			_t = $("#box_1").val();
			_t = _t.replace(/’/g, "'");
			_t = _t.replace(/”/g, "'");
			_t = _t.replace(/–/g, '-');
			_t1 = _t.replace(/"/g, "'");
			_t = $("#box_2").val();
			_t = _t.replace(/’/g, "'");
			_t = _t.replace(/”/g, "'");
			_t = _t.replace(/–/g, '-');
			_t2 = _t.replace(/"/g, "'");
			_t = $("#box_3").val();
			_t = _t.replace(/’/g, "'");
			_t = _t.replace(/”/g, "'");
			_t = _t.replace(/–/g, '-');
			_t3 = _t.replace(/"/g, "'");
			
		
			var url = '';
			var _param = "";
			_param += "w=" + $("#b1").width();
			_param += "&h=" + $("#b1").height();
			_param += "&main[]=" + $("#main_font").val();
			_param += "&main[]=" + $("#main_size").val();
			_param += "&main[]=" + $(".main_color:checked").val();
			_param += "&main[]=" + $(".main_align:checked").val();
			_param += "&couples[]=" + $("#couple_font").val();
			_param += "&couples[]=" + $("#couple_size").val();
			_param += "&couples[]=" + $(".couple_color:checked").val();
			_param += "&couples[]=" + $(".couple_align:checked").val();
			_param += "&texts[]=" + escape(_t1);
			_param += "&texts[]=" + escape(_t2);
			_param += "&texts[]=" + escape(_t3);
			var _url = "<?php echo siteURL;?>create_wed_image.php?"+ _param;
			
			var img = new Image();
			var show_alert = false;
			img.onload = function() {
				var height = this.height;
				var width = this.width;
				var _w = parseInt($("#b1").width());// + 280;
				var _h = parseInt($("#b1").height());
				
				var _str = "Original Width: " + _w;
				_str += "<br/>Generated Width: " + width;
				_str += "<br/>Original Height: " + _h;
				_str += "<br/>Generated Height: " + height;
				$("#dv_hidden").html(_str);
				if ( height > _h || width > _w ) {
					show_alert = true;
				}
				if ( show_alert ) {
					$("#box_1").parent().css({'border' : '1px solid #D04947', 'background-color' : "#FFAD32" });
				} else {
					$("#box_1").parent().css({'border' : 'medium none', 'background-color' : "#fff" });
				}
				
				$("#b1").css( {
					'background-image' : "url('" + _url + "')",
					'background-repeat' : "no-repeat",
					'background-position' : 'center center'
				});
			}
			img.src = _url;
		};
		
		$("#box_1, #box_2, #box_3, #main_font, #main_size, #couple_font, #couple_size, .main_color, .couple_color, .main_align, .couple_align").live ('change', generate_image);
		
		generate_image();
				
		$("#box_1, #box_2, #box_3").autoGrow();
	});
</script>