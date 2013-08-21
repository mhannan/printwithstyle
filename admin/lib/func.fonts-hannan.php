<?php

 //@@@@@@@@@@@@@@@@@@@ Album Backgrounds Management @@@@@@@@@@@@@@@@@@

function addFont($post)
{
    extract($post);
    $font_title = mysql_real_escape_string($font_title);
    

    $fontFileName = '';   // will be updated after picture upload

   

    if($_FILES['font_file']["name"])
      {
            $fileNameHandler = $_FILES['font_file']["name"];
            $file_newName = strtolower(str_replace(' ','_',$font_title)).'___'.date("mdyHis");
            $fontFileName = uploadFile('../../fonts/', $_FILES['font_file'], $file_newName);
        }

  

    $sql_1 = sprintf("INSERT INTO fonts  SET   font_label = '%s',   font_path = '%s'",
                                                $font_title, $fontFileName);


	$returnData = array();
        if(mysql_query($sql_1) or die(mysql_error()))
        {
            $okmsg = base64_encode("Information successfully added");
            $returnData[0] = "1";
            $returnData[1] = $okmsg;
        }
        else{
            $errmsg = base64_encode("Unable to update information due to : ".  mysql_error());
            $returnData[0] = "0";
            $returnData[1] = $errmsg;
        }
      return $returnData;
}


function getFonts()
{
     $sql 	= "SELECT * FROM fonts";
     $rSet  = mysql_query($sql);
     return $rSet;
}



function generate_font_preview_by_ttf($font_id, $font_text, $font_ttf_file_path)
{
    // Create a 300x150 image
    // Set the content-type
    ob_start();
    @header('Content-Type: image/png');

    // Create the image
    $im = imagecreatetruecolor(250, 40);

    // Create some colors
    $white = imagecolorallocate($im, 255, 255, 255);
    $grey = imagecolorallocate($im, 128, 128, 128);
    $black = imagecolorallocate($im, 0, 0, 0);
    imagefilledrectangle($im, 0, 0, 399, 49, $white);

    // The text to draw
    $text = $font_text;     //'Testing...';
    // Replace path by your own font path
    $font = $font_ttf_file_path;                //'fonts/Alcohole.ttf';

    // Add some shadow to the text
    //imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

    // Add the text
    imagettftext($im, 20, 0, 10, 20, $black, $font, $text);

    $font_preview_fileName = str_replace(' ','',$font_text).'.png';
    $font_image_preview_file_name_with_path = '../../fonts/previews/'.$font_preview_fileName;
    // Using imagepng() results in clearer text compared with imagejpeg()
    imagepng($im, $font_image_preview_file_name_with_path);
    imagedestroy($im);

    echo "<img src='".$font_image_preview_file_name_with_path."' height='40px'>";

    $sql = "UPDATE fonts SET font_preview_image ='".$font_preview_fileName."' WHERE font_id='".$font_id."'";
    mysql_query($sql);
}


function deleteTpl($tpl_id)
{
    $sql = "DELETE FROM album_templates WHERE tpl_id = '$tpl_id'";
    if(mysql_query($sql))
        return true;
    else
        return false;
}
?>