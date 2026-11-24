<?PHP 
// Info About File.
// System By Vaflan.
// For MyMuWeb.

// SECURITY FIX: only the forward slash was stripped, so on Windows a value
// like ?f=..\..\config.php escaped media/ and let is_file()/filesize()
// disclose the existence and size of arbitrary files. Drop every directory
// component instead, and require a bare file name.
$file = stripslashes($_GET['f']);
$file = basename(str_replace('\\', '/', $file));
if($file == '.' || $file == '..') { $file = ''; }
?>
<html>
<title>Info About File</title>
<body bgcolor="#CDCDCD">
<center>

<br>
<img src="../images/mmw.png">
<br>

<big><b>
<?
if($file != '' && is_file($file)) {
	$format = substr($file, -3);
	$size = filesize($file) . " Bytes";
	echo "Name: ".htmlspecialchars($file)." (Format: ".htmlspecialchars($format).", Size: $size)";
 }

else {
	echo "File Not Find!";
 }
?>
</b></big>

<?if($format == 'mp3'){?>
<br>
<embed src="player.swf?file=<?echo $file;?>&backcolor=0xCDCDCD" allowscriptaccess="always" width="400" height="20" bgcolor="#CDCDCD" quality="high" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
<?}?>

<br>
By Vaflan for MyMuWeb.

</center>
</body>
</html>