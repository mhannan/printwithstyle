<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.dd.js"></script>
<link href="<?php echo siteURL;?>css/dd.css" rel="stylesheet" type="text/css" />
<?php

//var_dump($card_settings[0]['defaults']); 
//var_dump($card_settings[1]['defaults']);
if ( !defined( 'siteURL') ) { die("ALLAH-O-AKBAR"); }
echo '<label>Main Text</label><br/>';
/* generate main text font style dropdown */
$font_items = $card_settings[0]['font_items'];
if ( is_array($font_items ) ) { 
	$sql = "
	SELECT * FROM " . TBL_FONTS . "
	WHERE font_id IN ( " . implode(', ', $font_items ) . " ) 
	";
	$fonts = mysql_query($sql) or die ( "Get Font for Box</br>$sql<br/>" . mysql_error() );
		
	if ( mysql_num_rows( $fonts ) ) {
			echo "<select name='main[font]' id='main_font' onchange='generate_image()'>";
		while ($font = mysql_fetch_object( $fonts ) ) {
			$sel = ( isset( $main['font'] ) && $main['font'] == "$font->font_path" ) || ( $font->font_id == $card_settings[0]['defaults']['style'] ) ? ' selected="selected" ' : NULL;
			echo "<option value='{$font->font_path}' $sel title='".FONTS_PREVIEW."$font->font_preview_image' >{$font->font_label}</option>";
		}
		echo "</select>";
	}
	echo "<br/>";
}
/* generate main text size dropdown */
$s_font_size = $card_settings[0]['font_size'];
if ( $s_font_size ) {
	$min_size = (int)$s_font_size - 10;
	$max_size = $s_font_size + 10;
	echo "<select name='main[size]' id='main_size' class='smallDD'>";
	$preiouvsly_selected = FALSE;
	for($s = $min_size; $s <= $max_size; $s++ ) {
		if ( ( isset( $main['size'] ) && $main['size'] == "{$s}" ) || ( $s == $card_settings[0]['defaults']['size'] && !$preiouvsly_selected ) ) {
			$sel = ' selected="selected" '; $preiouvsly_selected = TRUE;
		} else {
			$sel = '';
		}
		echo "<option $sel value='{$s}'>{$s}px</option>";
	}
	echo '</select>';
}

/* generate main text color dropdown */
$a_font_colors = $card_settings[0]['font_color'];

if ( $a_font_colors ) {
	$previously_defined = FALSE;
	foreach($a_font_colors as $c ) {
		$sel = ( isset( $main['color']) && $main['color'] == $c && !$previously_defined ) ? ' checked="checked" ' : NULL;
		$previously_defined = is_null( $sel ) ? FALSE : TRUE;
		$mc_id = "m{$c}";
		echo "
		<label for='$mc_id' style='background-color: #{$c}; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer; border:1px solid #000;'></label>
		<input type='radio' class='main_color' $sel name='main[color]' id='{$mc_id}' value='{$c}' style='position: absolute; left: -10px; top: -10px;'/>
		";
	}
	if ( !$previously_defined ) {
		$default_color = $card_settings[0]['defaults']['color'];
		echo "
		<label for=default_m_'{$default_color}' style='background-color: #{$default_color}; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer; display:none; visibility: hidden;'></label>
		<input type='radio' class='main_color' checked='checked' name='main[color]' id='default_m_{$default_color}' value='{$default_color}' style='position: absolute; left: -10px; top: -10px; display:none; visibility: hidden;'/>
		";
	}
} 

/* generate main text alignment dropdown */
$preiouvsly_selected = FALSE;
if ( ( isset( $main['align'] ) && $main['align'] == 'left'  && !$preiouvsly_selected  ) || $card_settings[0]['defaults']['align'] == 'left' ) {
	$sel = ' checked="checked" '; $preiouvsly_selected = TRUE;
} else {
	$sel = '';
}

$ma_id = "m1";
echo "
<label for='$ma_id' style='background: url(images/align-left.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
<input type='radio' class='main_align' $sel name='main[align]' id='{$ma_id}' value='left' style='position: absolute; left: -10px; top: -10px;'/>
";

if ( ( isset( $main['align'] ) && $main['align'] == 'center' && !$preiouvsly_selected )  || $card_settings[0]['defaults']['align'] == 'center' ) {
	$sel = ' checked="checked" '; $preiouvsly_selected = TRUE;
} else {
	$sel = '';
}
$ma_id = "m2";
echo "
<label for='$ma_id' style='background: url(images/align-center.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
<input type='radio' class='main_align' $sel name='main[align]' id='{$ma_id}' value='center' style='position: absolute; left: -10px; top: -10px;'/>
";

		
if ( ( isset( $main['align'] ) && $main['align'] == 'right' && !$preiouvsly_selected ) || $card_settings[0]['defaults']['align'] == 'right' ) {
	$sel = ' checked="checked" '; $preiouvsly_selected = TRUE;
} else {
	$sel = '';
}
$ma_id = "m0";
echo "
<label for='$ma_id' style='background: url(images/align-right.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
<input type='radio' class='main_align' $sel name='main[align]' id='{$ma_id}' value='right' style='position: absolute; left: -10px; top: -10px;'/>
&nbsp;<a style='cursor: pointer;'>Apply</a>
";


/* bride groom style start */
echo "<br/>";
echo '<label>Couple Text</label><br/>'; 
/* generate main text font style dropdown */
$font_items = $card_settings[1]['font_items'];
if ( is_array($font_items ) ) {
	$sql = "
	SELECT * FROM " . TBL_FONTS . "
	WHERE font_id IN ( " . implode(', ', $font_items ) . " ) 
	";
	$fonts = mysql_query($sql) or die ( "Get Font for Box</br>$sql<br/>" . mysql_error() );
		
	if ( mysql_num_rows( $fonts ) ) {
			echo "<select name='couples[font]' id='couple_font' onchange='generate_image()'>";
		while ($font = mysql_fetch_object( $fonts ) ) {
			$sel = (isset( $couples['font'] ) && $couples['font'] == "$font->font_path") || ( $font->font_id == $card_settings[1]['defaults']['style'] ) ? ' selected="selected" ' : NULL;
			echo "<option value='{$font->font_path}' $sel title='".FONTS_PREVIEW."$font->font_preview_image' >{$font->font_label}</option>";
			//echo "<option value='{$font->font_path}' title='".FONTS_PREVIEW."$font->font_preview_image' >{$font->font_label}</option>";
		}
		echo "</select>";
	}
	echo "<br/>";
}
/* generate main text size dropdown */
$s_font_size = $card_settings[1]['font_size'];
if ( $s_font_size ) {
	$min_size = (int)$s_font_size - 10;
	$max_size = $s_font_size + 10;
	echo "<select name='couples[size]' id='couple_size' class='box_sizes smallDD'>";
	$preiouvsly_selected = FALSE;
	for($s = $min_size; $s <= $max_size; $s++ ) {
		if ( ( isset( $couples['size'] ) && $couples['size'] == "{$s}" ) || ( $s == $card_settings[1]['defaults']['size'] && !$preiouvsly_selected ) ) {
			$sel = ' selected="selected" '; $preiouvsly_selected = TRUE;
		} else {
			$sel = '';
		}
		echo "<option $sel value='{$s}'>{$s}px</option>";
	}
	echo '</select>';
}

/* generate main text color dropdown */
$a_font_colors = $card_settings[1]['font_color'];

if ( $a_font_colors ) {
	$previously_defined = FALSE;
	foreach($a_font_colors as $c ) {
		$sel = ( isset( $couples['color'] ) && $couples['color'] == $c && !$previously_defined ) ? ' checked="checked" ' : NULL;
		$previously_defined = is_null( $sel ) ? FALSE : TRUE;
		$cc_id = "c{$c}";
		echo "
		<label for='$cc_id' style='background-color: #{$c}; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer; border:1px solid #000;'></label>
		<input type='radio' class='couple_color' $sel name='couples[color]' id='{$cc_id}' value='{$c}' style='position: absolute; left: -10px; top: -10px;'/>
		";
	}
	if ( !$previously_defined ) {
		$default_color = $card_settings[1]['defaults']['color'];
		echo "
		<label for=default_m_'{$default_color}' style='background-color: #{$default_color}; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer; display:none; visibility: hidden;'></label>
		<input type='radio' class='couple_color' checked='checked' name='couples[color]' id='default_m_{$default_color}' value='{$default_color}' style='position: absolute; left: -10px; top: -10px; display:none; visibility: hidden;'/>
		";
	}
} 

/* generate main text alignment dropdown */
$preiouvsly_selected = FALSE;
if ( ( isset( $couples['align'] ) && $couples['align'] == 'left'  && !$preiouvsly_selected  ) || $card_settings[1]['defaults']['align'] == 'left' ) {
	$sel = ' checked="checked" '; $preiouvsly_selected = TRUE;
} else {
	$sel = '';
}

$ca_id = "c1";
echo "
<label for='$ca_id' style='background: url(images/align-left.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
<input type='radio' class='couple_align' $sel name='couples[align]' id='{$ca_id}' value='left' style='position: absolute; left: -10px; top: -10px;'/>
";

if ( ( isset( $couples['align'] ) && $couples['align'] == 'center' && !$preiouvsly_selected )  || $card_settings[1]['defaults']['align'] == 'center' ) {
	$sel = ' checked="checked" '; $preiouvsly_selected = TRUE;
} else {
	$sel = '';
}
$ca_id = "c2";
echo "
<label for='$ca_id' style='background: url(images/align-center.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
<input type='radio' class='couple_align' $sel name='couples[align]' id='{$ca_id}' value='center' style='position: absolute; left: -10px; top: -10px;'/>
";

		
if ( ( isset( $couples['align'] ) && $couples['align'] == 'right' && !$preiouvsly_selected ) || $card_settings[1]['defaults']['align'] == 'right' ) {
	$sel = ' checked="checked" '; $preiouvsly_selected = TRUE;
} else {
	$sel = '';
}
$ca_id = "c0";
echo "
<label for='$ca_id' style='background: url(images/align-right.png) no-repeat; border: 1px solid #efefef; float: left; width: 20px; height: 20px; margin-right: 5px; cursor: pointer;'></label>
<input type='radio' class='couple_align' $sel name='couples[align]' id='{$ca_id}' value='right' style='position: absolute; left: -10px; top: -10px;'/>
&nbsp;<a style='cursor: pointer;'>Apply</a>
";
/* bride groom style end */


/* hidden dimensions */
echo "<input type='hidden' name='w' value='{$dimensionss[0]}' />";
echo "<input type='hidden' name='h' value='{$dimensionss[1]}' />";

$txt[0] = nl2br($sample_text[0]);
$txt[0] = str_replace(array( '\r', '\n', '\t', '<br/>', '<br />' ), '', $txt[0]); 
$txt[0] = trim(strip_tags($txt[0]));

$txt[1] = nl2br($sample_text[1]);
$txt[1] = str_replace(array( '\r', '\n', '\t', '<br/>', '<br />' ), '', $txt[1]); 
$txt[1] = trim(strip_tags($txt[1]));

$txt[2] = nl2br($sample_text[2]);
$txt[2] = str_replace(array( '\r', '\n', '\t', '<br/>', '<br />' ), '', $txt[2]); 
$txt[2] = trim(strip_tags($txt[2]));
echo "<br/><br/><br/>";
?>
<style type="text/css">
	textarea { 
		overflow:hidden; height:auto; width:300px;
	}
	
	#main_font, #couple_font { 
		/*height:35px;*/
	}

	#box_1 {
		border: 1px solid #000; border-bottom: medium none; padding:0px; margin:0px;
	}
	#box_2 {
		border: 1px solid #000; border-top: medium none; border-bottom: medium none;  padding:0px; margin:0px; 
	}
	#box_3 {
		border: 1px solid #000; border-top: medium none;  padding:0px; margin:0px;
	}
	
</style>
	
<textarea id='box_1' name="texts[]"><?php echo trim($txt[0]); ?></textarea>
<textarea id='box_2' name="texts[]"><?php echo trim($txt[1]); ?></textarea>
<textarea id='box_3' name="texts[]"><?php echo trim($txt[2]); ?></textarea>
