<?PHP 
// Search All Images in Folder.
// Gallery By Vaflan.
// For MyMuWeb.
// Vers. 1.2

 $dir = "gallery/";

function byteConvert($bytes) {
	$s = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB');
	$e = floor(log($bytes)/log(1024));
	return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
}

// Add Image
if(isset($_GET[w]) && isset($_SESSION['char_set'])) {
 if(isset($_FILES['image'])) {
  if(is_file($dir.$mmw[rand_id].'.dat')) {
	echo $die_start . mmw_lang_image_exists . $die_end;
  }
  else {
	$file_name = basename($_FILES['image']['name']);
	$file_size = $_FILES['image']['size'];
	$file_format = strtolower(substr($file_name, -3));
	$file_maxsize = "2000000";
	$target = $dir.$mmw[rand_id].".$file_format";

	if(empty($_FILES['image']) || empty($_POST[name]) || empty($_POST[comment])) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	}
	elseif($file_size > $file_maxsize) {
		echo $die_start . mmw_lang_file_size_max . $die_end;
	}
	elseif($file_format!='jpg' && $file_format!='png' && $file_format!='gif') {
		echo $die_start . mmw_lang_image_no_image . $die_end;
	}
	elseif(move_uploaded_file($_FILES['image']['tmp_name'],$target)) {
		$name = bugsend(stripslashes($_POST[name]));
		$comment = bugsend(stripslashes($_POST[comment]));
		$author = stripslashes($_SESSION['char_set']);
		$date = time();
		$image_size = getimagesize($target);

		$data = "<?PHP\n// Info Image By MyMuWeb\n\$format = '$file_format';\n\$name = '$name';\n\$author = '$author';\n\$comment = '$comment';\n\$date = '$date';\n\$width = '$image_size[0]';\n\$height = '$image_size[1]';\n\$size = '$file_size';\n?>";
		$fp = fopen($dir.$mmw[rand_id].".dat", 'w');
		fputs($fp, $data);
		fclose($fp);
		echo $okey_start . mmw_lang_image_uploaded . $okey_end;
		writelog("gallery","Image <b>$mmw[rand_id]</b> Has Been <font color=#FF0000>Added</font>");
	}
	else {
		echo "$die_start Total ErroR! $die_end";
	}
  }
  echo $rowbr;
 }
?>
<form name="upload" enctype="multipart/form-data" method="post">
  <table class="sort-table" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right"><?echo mmw_lang_image_file;?>:</td>
      <td><input type="file" id="image" name="image"></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_image_name;?>:</td>
      <td><input name='name' type='text' size='30' maxlength='30' value='<?echo $_POST[name];?>'></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_image_comment;?>:</td>
      <td><input name='comment' type='text' size='30' maxlength='30' value='<?echo $_POST[comment];?>'></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_image;?>:</td>
      <td><input type='submit' name='Submit' value='<?echo mmw_lang_upload;?>'> <input type='reset' name='Reset' value='<?echo mmw_lang_renew;?>'></td>
    </tr>
  </table>
</form>
<?
}
elseif(isset($_GET[w])) {
	echo $die_start . mmw_lang_guest_must_be_logged_on . $die_end;
}


// Delete Image
if(isset($_POST['id_delete'])) {
   $file_name = $_POST['id_delete'];
   if(is_file($dir.$file_name.'.dat')) {
	include($dir.$file_name.'.dat');
	if($_SESSION['mmw_status'] >= $mmw[image_can_delete] || $_SESSION['char_set'] == $author) {
		unlink($dir.$file_name.'.'.$format);
		unlink($dir.$file_name.".dat");
		echo $okey_start . mmw_lang_image_deleted . $okey_end;
		writelog("gallery","Image <b>$file_name</b> Has Been <font color=#FF0000>Deleted</font>");
	}
   }
   else {
	echo $die_start . mmw_lang_left_blank . $die_end;
   }
   echo $rowbr;
}


// Read Folder
if($dh = opendir($dir)) {
     while (($file = readdir($dh)) !== false) {
	  $format = substr($file, -3);
	  if($format == 'dat') {
		$num = $num + 1;
		$file_name = substr($file, 0, -4);
		include($dir.$file_name.'.dat');
		$url = $dir.$file_name.'.'.$format;

		$sizew = $width;
		$sizeh = $height;

		if($sizeh > 120) {
			$sizeh = 120;
			$sizew = $width * $sizeh / $height;
		}
		if($sizew > 160) {
			$sizew = 160;
			$sizeh = $height * $sizew / $width;
		}

		if($char_info[$author][0] == '') {
		   $result_char = mssql_query("SELECT AccountID,CtlCode FROM Character WHERE Name='$author'");
		   $char_info[$author] = mssql_fetch_row($result_char);
		}

		if($_SESSION['mmw_status'] >= $mmw[image_can_delete] || $_SESSION['char_set'] == $author)
		{$edit = "<form action='' method='post' name='delete_$file_name'><input name='id_delete' type='hidden' value='$file_name'><a href='javascript://' title='".mmw_lang_delete."'><img src='".default_img("delete.png")."' border='0' onclick='delete_$file_name.submit()'></a></form>";}
		else {$edit = '';}

		$file_list = $file_list . "<table border='0' cellpadding='0' cellspacing='0' width='100%' class='aBlock'>
			<tr><td style='padding:2px;' width='160' align='center'>
			<a href='$url' target='_blank' title='".mmw_lang_image_size.": $width x $height'><img src='$url' border='0' height='$sizeh' width='$sizew'></a></td>
			<td style='padding:4px;' valign='top'><a href='$url' target='_blank'><big><b>$name</b></big></a> $edit<br>".mmw_lang_author.": <a href='?op=character&character=$author' class='level".$char_info[$author][1]."'>$author</a><br>".mmw_lang_image_comment.": $comment<br>".mmw_lang_date.": ".date('d.m.Y H:i:s',$date)."<br>".mmw_lang_image_size.": $width x $height<br>".mmw_lang_file_size.": ".byteConvert($size)."</td></tr>
			</table> \n " . $rowbr;
	  }
     }
     closedir($dh);

   if(!isset($_GET[w])) {
	if(isset($_SESSION['char_set']) && $_SESSION['char_set']!=' ' && isset($_SESSION['user'])) {$upload_acc_check = "<a href='?op=gallery&w=add'>".mmw_lang_upload_image."</a>";}
	elseif(isset($_SESSION['pass']) && isset($_SESSION['user'])) {$upload_acc_check = mmw_lang_cant_add_no_char;}
	else {$upload_acc_check = mmw_lang_guest_must_be_logged_on;}

     echo "
	<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
	<td width='50%'>".mmw_lang_total_image.": <b>$num</b></td>
	<td align='right'>[ $upload_acc_check ]</td>
	</tr><table>
	";
     echo $file_list;
   }
}
?>