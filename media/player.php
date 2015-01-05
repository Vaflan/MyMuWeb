<?PHP 
// Search All Mp3 in Folder and Creat New XML.
// System By Vaflan.
// Player by FLV.
// For MyMuWeb.

 $num = "0";
 $dir = "media/";
 $xml = "playlist.xml";

// Read Folder
if($dh = opendir($dir)) {
     while (($file = readdir($dh)) !== false) {
	  $format = substr($file, -3);
	  if($format == 'mp3') {
		$num = $num + 1;
		$size = filesize($dir.$file) . " Bytes";
		$track[$num] = "\n        <track>\n            <location>$dir$file</location>\n            <title>$num. $file</title>\n            <creator>MyMuWeb</creator>\n            <annotation>MuOnline MMORPG Music by Vaflan</annotation>\n            <info>".$dir."?f=$file</info>\n        </track>\n";
		$folder_list = $folder_list . $track[$num];
	  }
     }
     closedir($dh);
}

// Creat Data for XML
$data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<playlist version=\"1\" xmlns=\"http://xspf.org/ns/0/\">\n    <title>MuOnline MMORPG Music by Vaflan</title>\n    <creator>MyMuWeb By Vaflan</creator>\n    <info>http://mmw.clan.su</info>\n    <trackList>\n\n";
$data = $data . $track[rand(1,$num)] . $folder_list;
$data = $data . "\n\n    </trackList>\n</playlist>";

// Writh to XML
$fd = fopen($dir.$xml, "w");
fwrite($fd, $data);
fclose($fd);

echo $rowbr;
?>

<center>
<embed src="media/player.swf?file=media/playlist.xml&autostart=true&volume=100&backcolor=0x<?echo $media_color;?>" allowscriptaccess="always" width="400" height="20" bgcolor="#<?echo $media_color;?>" quality="high" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</center>