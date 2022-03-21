<?PHP 
// Info About File.
// System By Vaflan.
// For MyMuWeb.

$file = stripslashes($_GET['f']);
$file = str_replace("/","",$file);
?>
<html>
<title>Info About File</title>
<body bgcolor="#CDCDCD">
<center>

<br>
<img src="logo.png">
<br>

<big><b>
<?
if(is_file($file)) {
	$format = substr($file, -3);
	$size = filesize($file) . " Bytes";
	echo "Name: $file (Format: $format, Size: $size)";
 }

else {
	echo "File Not Find!";
 }
?>
</b></big>

<?if($format == 'mp3'){?>
<br>
<embed src="player.swf?file=<?echo $file;?>&backcolor=0xCDCDCD&plugins=no" allowscriptaccess="always" width="400" height="20" bgcolor="#CDCDCD" quality="high" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
<?}?>

<br>
By Vaflan for MyMuWeb.

</center>
</body>
</html>