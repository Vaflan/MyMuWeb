<?php
// Resize by Vaflan
function img_resize($img_src, $sizew, $sizeh, $save_dir, $save_name) {
 $save_dir .= (substr($save_dir,-1) != "/") ? "/" : "";
 $gis = GetImageSize($img_src);
 $type = $gis[2];
 switch($type) {
  case "1": $imorig = imagecreatefromgif($img_src); break;
  case "2": $imorig = imagecreatefromjpeg($img_src); break;
  case "3": $imorig = imagecreatefrompng($img_src); break;
  default:  $imorig = imagecreatefromjpeg($img_src);
 }

 $width = imageSX($imorig);
 $height = imageSY($imorig);
 if($gis[0] <= $sizew && $gis[1] <= $sizeh) {
  if(is_file($save_dir.$save_name)){unlink($save_dir.$save_name);}
  rename($img_src,$save_dir.$save_name);	
 }
 else {
  // if(is_file($img_src)) {unlink($img_src);}

  // длина исходной картинки
  $edited_width = $sizew;
  $new_height = $height * $sizew / $width;
  // высота исходной картинки
  if($sizeh<$new_height) {$edited_height = $sizeh; $edited_width = $sizew * $sizeh / $new_height;}
  else {$edited_height = $new_height;}
	                      
  $im = imagecreate($edited_width, $edited_height);
  $im = imagecreatetruecolor($edited_width,$edited_height);
  if(imagecopyresampled($im, $imorig, 0, 0, 0, 0, $edited_width, $edited_height, $width, $height)) {
   if(imagejpeg($im, $save_dir.$save_name)) {return true;}
   else {return false;}
  }
 }   
}
?>