<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.dd.js"></script>
<link href="<?php echo siteURL;?>css/dd.css" rel="stylesheet" type="text/css" />

<?php
if ( !defined( 'siteURL') ) { die("ALLAH-O-AKBAR"); }
$box_style_ids = array();
$total_boxes = count($card_settings);
for ( $i = 0; $i < $total_boxes; $i++ ) {
	$sel = $previous_font = NULL;
	$name_id = "e_box[{$i}]";
	$txt = $sample_text[$i];
	$txt = nl2br(stripslashes($txt));
	$txt = str_replace(array( '\r', '\n', '\t', '<br />', '<br/>' ), '', $txt); // replace newline, carriage return, tab 
	$txt = trim(strip_tags($txt)); // strip tags as html tags are showing within the textarea
	/* get font styles for this box */
	$font_items = $card_settings[$i]['font_items'];
	if ( is_array($font_items ) ) {
		$sql = "
		SELECT * FROM " . TBL_FONTS . "
		WHERE font_id IN ( " . implode(', ', $font_items ) . " ) 
		";
		$fonts = mysql_query($sql) or die ( "Get Font for Box</br>$sql<br/>" . mysql_error() );
		
		$font_dd = '';
		if ( mysql_num_rows( $fonts ) ) {
			$font_dd = "<select name='font_style[{$i}]' id='font_style{$i}' class='box_fonts' onchange='generate_image(jQuery(this).parent().parent().parent().find(\"textarea\"));'>";
			while ($font = mysql_fetch_object( $fonts ) ) {
				if ( isset( $font_style ) && $font_style[$i] == "$font->font_path" ) {
					$sel = ' selected="selected" '; $previous_font = TRUE; 
				} else if ( $font->font_id == $card_settings[$i]['defaults']['style'] && is_null( $previous_font ) ) {
					$sel = ' selected="selected" '; 
				} else {
					$sel = NULL;
				}
				$font_dd .= "<option value='{$font->font_path}' $sel title='".FONTS_PREVIEW."$font->font_preview_image' >{$font->font_label}</option>";
			}
			$font_dd .= "</select>";
			$box_style_ids[] = "font_style{$i}";
		} else {
			$font_dd = '';
		}
	} else {
		$font_dd = '';
	}
	
	/* generate size dropdown */
	$s_font_size = $card_settings[$i]['font_size'];
	$size_dd = '';
	if ( $s_font_size ) {
		$min_size = (int)$s_font_size - 10;
		$max_size = $s_font_size + 10;
		$size_dd = "<select name='font_size[{$i}]' id='font_size{$i}' class='box_sizes smallDD'>";
		$preiouvsly_selected = FALSE;
		for($s = $min_size; $s <= $max_size; $s++ ) {
			if ( ( isset( $font_size ) && $font_size[$i] == "{$s}px" ) || ( $s == $card_settings[$i]['defaults']['size'] && !$preiouvsly_selected ) ) {
				$sel = ' selected="selected" '; $preiouvsly_selected = TRUE;
			} else {
				$sel = '';
			}
			$size_dd .= "<option $sel value='{$s}px'>{$s}px</option>";
		}
		$size_dd .= '</select>';
	} else {
		$size_dd = '';	
	}
	
	/* generate color dropdown */
	$a_font_colors = $card_settings[$i]['font_color'];
	$color_dd = '';
	if ( $a_font_colors ) {
		$previously_defined = FALSE;
		foreach($a_font_colors as $c ) {
			$sel = ( isset( $font_color[$i] ) && $font_color[$i] == $c && !$previously_defined ) ? ' checked="checked" ' : NULL;
			$previously_defined = is_null( $sel ) ? FALSE : TRUE;
			$rbo_id = "{$i}{$c}";
			$color_dd .= "
			<label for='$rbo_id' style='background-color: #{$c}; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer; border:1px solid #000;'></label>
			<input type='radio' class='box_color' $sel name='font_color[{$i}]' id='{$rbo_id}' value='{$c}' style='position: absolute; left: -10px; top: -10px;'/>
			";
		}
		if ( !$previously_defined ) {
			$default_color = $card_settings[$i]['defaults']['color'];
			$color_dd .= "
			<label for=default_'{$default_color}' style='background-color: #{$default_color}; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer; display:none; visibility: hidden;'></label>
			<input type='radio' class='box_color' checked='checked' name='font_color[{$i}]' id='default_{$default_color}' value='{$default_color}' style='position: absolute; left: -10px; top: -10px; display:none; visibility: hidden;'/>
			";
		}
		
	} else {
		$color_dd = '';	
	}
	
	/* generate line height dropdown */
	$s_lh = $card_settings[$i]['line_height'];
	$lh_dd = '';
	if ( $s_lh ) {
		$min_size = (int)$s_lh - 10;
		$max_size = $s_lh + 10;
		$lh_dd = "<select name='line_height[{$i}]' id='line_height{$i}' class='box_lh smallDD'>";
		$preiouvsly_selected = FALSE;
		for($s = $min_size; $s <= $max_size; $s++ ) {
			if ( ( isset( $line_height ) && $line_height[$i] == "{$s}" ) || $s == $s_lh && !$preiouvsly_selected ) {
				$sel = ' selected="selected" '; $preiouvsly_selected = TRUE;
			} else {
				$sel = '';
			}
			$lh_dd .= "<option $sel value='{$s}'>$s</option>";
		}
		$lh_dd .= '</select>';
	} else {
		$lh_dd = '';	
	}
	
	/* generate alignment dropdown */
	$cur_align = $card_settings[$i]['text_alignment_style'];
	$preiouvsly_selected = FALSE;

	$align_dd = '';
	
	if ( ( isset( $font_align ) && $font_align[$i] == 'left'  && !$preiouvsly_selected  ) || $card_settings[$i]['defaults']['align'] == 'left' ) {
		$sel = ' checked="checked" '; $preiouvsly_selected = TRUE;
	} else {
		$sel = '';
	}
	
	$rbo_id = "{$i}1";
	$align_dd .= "
	<label for='$rbo_id' style='background: url(images/align-left.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='box_align' $sel name='font_align[{$i}]' id='{$rbo_id}' value='left' style='position: absolute; left: -10px; top: -10px;'/>
	";
	
	if ( ( isset( $font_align ) && $font_align[$i] == 'center' && !$preiouvsly_selected )  || $card_settings[$i]['defaults']['align'] == 'center' ) {
		$sel = ' checked="checked" '; $preiouvsly_selected = TRUE;
	} else {
		$sel = '';
	}
	$rbo_id = "{$i}2";
	$align_dd .= "
	<label for='$rbo_id' style='background: url(images/align-center.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='box_align' $sel name='font_align[{$i}]' id='{$rbo_id}' value='center' style='position: absolute; left: -10px; top: -10px;'/>
	";
	
			
	if ( ( isset( $font_align ) && $font_align[$i] == 'right' && !$preiouvsly_selected ) || $card_settings[$i]['defaults']['align'] == 'right' ) {
		$sel = ' checked="checked" '; $preiouvsly_selected = TRUE;
	} else {
		$sel = '';
	}
	$rbo_id = "{$i}0";
	$align_dd .= "
	<label for='$rbo_id' style='background: url(images/align-right.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
	<input type='radio' class='box_align' $sel name='font_align[{$i}]' id='{$rbo_id}' value='right' style='position: absolute; left: -10px; top: -10px;'/>
	";
	
	if ( $row['cat_id'] == "7" && $row['have_photo'] == '1' && $i > 1 ) { // thank you card, it has only one block for editor  
		break;
	}
	
	/* hidden dimension {w,h} position {x,y}*/
	$h = "b". ($i + 1);
	$hd_dimension = "dimension_$h";
	$hd_position = "position_$h";
	$hd_dimension_val = isset( $dimension[$i] ) ? $dimension[$i] : $card_settings[$i]['content_container_dimension'];
	$hd_position_val = isset( $position[$i] ) ? $position[$i] : $card_settings[$i]['content_container_position'];
	?>
	<div class="edit_boxes">
		<p class="image_alert">
			There seems to be some problem in your text.<br/>
			- Try reduce the font size.<br/>
			- Try change the font style.<br/>
			- Provide proper line breaks in the paragraph. 
		</p>
		<div class="settings">
		<?php echo $font_dd; // . $lh_dd; ?>
		</div>
		<textarea name="<?php echo $name_id;?>" id="<?php echo $name_id;?>" class="display_box" rel="b<?php echo ($i + 1);?>"><?php echo $txt;?></textarea>
		<div class="settings">
		<?php echo $size_dd . $color_dd . $align_dd; ?> <a style="cursor: pointer;">Apply</a>
		</div>
		<input type="hidden" id="<?php echo $hd_dimension;?>" name="dimension[]" value="<?php echo $hd_dimension_val; ?>" />
		<input type="hidden" id="<?php echo $hd_position;?>" name="position[]" value="<?php echo $hd_position_val;?>" />
	</div>
	<?php
}