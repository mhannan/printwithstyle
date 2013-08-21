<?php

/*
	* To change this template, choose Tools | Templates
	* and open the template in the editor.
	*/

//$img = imagecreatefromgif("./3.gif");
$img = imagecreatefrompng("./2.png");
$size_x = imagesx($img);
$size_y = imagesy($img);

$temp = imagecreatetruecolor($size_x, $size_y);

//imagecolortransparent($temp, imagecolorallocate($temp, 0, 0, 0));
//imagealphablending($temp, false);
//imagesavealpha($temp, true);
$x = imagecopyresampled($temp, $img, 0, 0, ($size_x-1), 0, $size_x, $size_y, 0-$size_x, $size_y);
if ($x) {
    $img = $temp;
}
else {
    die("Unable to flip image");
}

//header("Content-type: image/gif");
header("Content-type: image/png");
imagegif($img);
imagedestroy($img);
?>
