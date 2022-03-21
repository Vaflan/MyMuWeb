<?PHP
// Image Verify For MMW
// Creator =Master=, Edit by Vaflan
// generate 5 digit random Alpha

session_start();

$alphanum = "abcdefghijklmnopqwstuvwxyz0123456789";
$rand = substr(str_shuffle($alphanum), 0, 6);

// create the hash for the random number and put it in the session
$_SESSION['image_random_value'] = md5($rand);

// create the image
$image = imagecreate(54, 18);

// Generate 3 Img Color
$coloring = rand(1,3);
if($coloring == 1) {
	$bgColor = imagecolorallocate ($image, 0x79, 0x79, 0x79);
	$textColor = imagecolorallocate ($image, 0xEE, 0XEE, 0xEE);
 }
if($coloring == 2) {
	$bgColor = imagecolorallocate ($image, 0xCC, 0xCC, 0xCC);
	$textColor = imagecolorallocate ($image, 0x00, 0X00, 0x00);
 }
if($coloring == 3) {
	$bgColor = imagecolorallocate ($image, 0x00, 0x00, 0x00);
	$textColor = imagecolorallocate ($image, 0xFF, 0XFF, 0xFF);
 }

// write the random number
imagestring ($image, 4, 3, 1, $rand, $textColor);

// send several headers to make sure the image is not cached
// taken directly from the PHP Manual

// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// always modified
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache");


// send the content type header so the image is displayed properly
header('Content-type: image/jpeg');

// send the image to the browser
imagejpeg($image);

// destroy the image to free up the memory
imagedestroy($image);
?>