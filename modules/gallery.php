<?php
/**
 * Search All Images in Folder.
 * Gallery V2.1 By Vaflan For MyMuWeb.
 * @var array $mmw
 * @var string $okey_start
 * @var string $okey_end
 * @var string $die_start
 * @var string $die_end
 * @var string $rowbr
 * @var int $flash_body_size
 */

$dir = 'media/gallery/';

function byteConvert($bytes)
{
	$s = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB');
	$e = floor(log($bytes) / log(1024));
	return sprintf('%.2f ' . $s[$e], ($bytes / pow(1024, floor($e))));
}

if (isset($_SESSION['user']) && !empty($_SESSION['character'])) {
	$upload_acc_check = '<a href="?op=gallery&w=add">' . mmw_lang_upload_image . '</a>';
} elseif (isset($_SESSION['user'])) {
	$upload_acc_check = mmw_lang_cant_add_no_char;
} else {
	$upload_acc_check = mmw_lang_guest_must_be_logged_on;
}


// Delete Image
if (isset($_POST['id_delete'])) {
	$file_name = preg_replace('/[^\w_-]/', '', $_POST['id_delete']);
	$dataFile = __DIR__ . '/../' . $dir . $file_name . '.php';
	if (is_file($dataFile)) {
		unset($author);
		include $dataFile;
		/** @var string $author */
		/** @var string $format */
		if ($mmw['status_rules'][$_SESSION['mmw_status']]['image_delete'] || $_SESSION['character'] === $author) {
			unlink($dir . $file_name . '.' . $format);
			unlink($dir . 'small_' . $file_name . '.' . $format);
			unlink($dataFile);
			mssql_query("DELETE FROM dbo.MMW_comment WHERE c_id_code='{$file_name}'");
			echo $okey_start . mmw_lang_image_deleted . $okey_end;
			writelog('gallery', 'Image <b>' . $file_name . '</b> Has Been <span style="color:#F00">Deleted</span>');
		}
	} else {
		echo $die_start . mmw_lang_left_blank . $die_end;
	}
	echo $rowbr;
}

// Add Image
if (isset($_GET['w']) && $_GET['w'] === 'add' && !empty($_SESSION['character'])) {
	if (isset($_FILES['image'])) {
		if (is_file($dir . $mmw['rand_id'] . '.php')) {
			echo $die_start . mmw_lang_image_exists . $die_end;
		} else {
			$file_name = basename($_FILES['image']['name']);
			$file_size = $_FILES['image']['size'];
			$file_format = strtolower(substr($file_name, -3));
			$file_maxsize = '2000000';
			$target = $dir . $mmw['rand_id'] . '.' . $file_format;

			if (empty($_FILES['image']) || empty($_POST['name']) || empty($_POST['comment'])) {
				echo $die_start . mmw_lang_left_blank . $die_end;
			} elseif ($file_size > $file_maxsize) {
				echo $die_start . mmw_lang_file_size_max . $die_end;
			} elseif (!in_array($file_format, array('jpg', 'png', 'gif'))) {
				echo $die_start . mmw_lang_image_no_image . $die_end;
			} elseif (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
				$name = bugsend(stripslashes($_POST['name']));
				$comment = bugsend(stripslashes($_POST['comment']));
				$author = $_SESSION['character'];
				$image_size = getimagesize($target);
				$date = time();

				$data = "<?php\n// Info Image By MyMuWeb\n\$format = '$file_format';\n\$name = '$name';\n\$author = '$author';\n\$comment = '$comment';\n\$date = '$date';\n\$width = '$image_size[0]';\n\$height = '$image_size[1]';\n\$size = '$file_size';\n";
				$fp = fopen($dir . $mmw['rand_id'] . '.php', 'w');
				fputs($fp, $data);
				fclose($fp);
				echo $okey_start . mmw_lang_image_uploaded . $okey_end;
				writelog('gallery', 'Image <b>' . $mmw['rand_id'] . '</b> Has Been <span style="color:#F00">Added</span>');
			} else {
				echo $die_start . 'Total error!' . $die_end;
			}
		}
		echo $rowbr;
	}
	?>
	<form name="upload" enctype="multipart/form-data" method="post">
		<table class="sort-table" style="margin:0 auto;border:0;padding:0">
			<tr>
				<td align="right"><?php echo mmw_lang_image_file; ?>:</td>
				<td><input type="file" id="image" name="image"></td>
			</tr>
			<tr>
				<td align="right"><?php echo mmw_lang_image_name; ?>:</td>
				<td>
					<input name="name" type="text" size="30" maxlength="30" value="<?php echo $_POST['name']; ?>">
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo mmw_lang_image_comment; ?>:</td>
				<td>
					<input name="comment" type="text" size="30" maxlength="255" value="<?php echo $_POST['comment']; ?>">
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo mmw_lang_image; ?>:</td>
				<td>
					<input type="submit" value="<?php echo mmw_lang_upload; ?>">
					<input type="reset" value="<?php echo mmw_lang_renew; ?>">
				</td>
			</tr>
		</table>
	</form>
	<?php
} elseif (isset($_GET['w']) && $_GET['w'] === 'add') {
	echo $die_start . mmw_lang_guest_must_be_logged_on . $die_end;
} elseif (!empty($_GET['w'])) {
	$file_name = preg_replace('/[^\w_-]/', '', $_GET['w']);
	if (!empty($file_name) && is_file($dir . $file_name . '.php')) {
		include $dir . $file_name . '.php';
		/** @var string $name */
		/** @var string $width */
		/** @var string $height */
		/** @var int $date */
		/** @var int $size */
		$url = $dir . $file_name . '.' . $format;
		$smallUrl = $dir . 'small_' . $file_name . '.' . $format;

		$edit = '';
		if ($mmw['status_rules'][$_SESSION['mmw_status']]['image_delete'] || $_SESSION['character'] === $author) {
			$edit .= ' <form action="" method="post" name="delete_' . $file_name . '"><input name="id_delete" type="hidden" value="' . $file_name . '"><img src="' . default_img('delete.png') . '" border="0" onclick="document.delete_' . $file_name . '.submit()" title="' . mmw_lang_delete . '"></form> ';
		}
		?>
		<div style="text-align: right">
			[ <?php echo $upload_acc_check; ?> ]
		</div>
		<div style="text-align: center; font-weight: bold;">
			<a href="<?php echo $url; ?>"><big><?php echo $name; ?></big></a> <?php echo $edit; ?>
		</div>
		<table class="aBlock" style="margin:0 auto;">
			<tr>
				<td style="padding:2px;text-align:center">
					<a href="<?php echo $url; ?>" target="_blank" title="<?php echo mmw_lang_image_size . ": $width x $height"; ?>">
						<img src="<?php echo $smallUrl; ?>" border="0" alt="<?php echo $name; ?>">
					</a>
				</td>
			</tr>
		</table>
		<?php echo $rowbr; ?>
		<div class="eDetails">
			<?php echo mmw_lang_image_size . ": $width" . "x" . $height . "px/" . byteConvert($size) ?>
			| <?php echo mmw_lang_date . ": <span title='" . date('H:i:s', $date) . "'>" . date('d.m.Y', $date) . '</span>'; ?>
			| <?php echo mmw_lang_author . ": <a href='?op=character&character=$author'>$author</a>"; ?>
		</div>
		<?php
		comment_module(3, $file_name);
	} else {
		echo $die_start . mmw_lang_left_blank . $die_end;
	}
}


// Read Folder
if (!isset($_GET['w']) && $dh = opendir($dir)) {
	$num = 0;
	$file_list = '';
	$char_info = array();
	while (($file = readdir($dh)) !== false) {
		$format = substr($file, -3);
		if ($format === 'php') {
			$num++;
			$file_name = substr($file, 0, -4);
			include $dir . $file_name . '.php';
			$url = $dir . $file_name . '.' . $format;
			$smallUrl = $dir . 'small_' . $file_name . '.' . $format;

			if (!is_file($smallUrl)) {
				img_resize($url, $flash_body_size, $flash_body_size, $dir, 'small_' . $file_name . '.' . $format);
			}
			$image_size = getimagesize($smallUrl);

			$sizeW = $image_size[0];
			$sizeH = $image_size[1];

			if ($sizeH > 120) {
				$sizeH = 120;
				$sizeW = $width * $sizeH / $height;
			}
			if ($sizeW > 160) {
				$sizeW = 160;
				$sizeH = $height * $sizeW / $width;
			}

			if (empty($char_info[$author][0])) {
				$result_char = mssql_query("SELECT CtlCode FROM dbo.Character WHERE Name='{$author}'");
				$char_info[$author] = mssql_fetch_row($result_char);
			}

			$edit = '';
			if ($mmw['status_rules'][$_SESSION['mmw_status']]['image_delete'] || $_SESSION['character'] === $author) {
				$edit .= ' <form action="" method="post" name="delete_' . $file_name . '"><input name="id_delete" type="hidden" value="' . $file_name . '"><img src="' . default_img('delete.png') . '" border="0" onclick="document.delete_' . $file_name . '.submit()" title="' . mmw_lang_delete . '"></form> ';
			}

			$file_list .= '<table class="aBlock" style="width:100%">
			<tr>
				<td style="padding:2px;width:160px;text-align:center">
					<a href="?op=gallery&w=' . $file_name . '" title="' . mmw_lang_image_size . ': ' . $width . ' x ' . $height . '">
						<img src="' . $smallUrl . '" height="' . $sizeH . '" width="' . $sizeW . '" alt="' . $name . '" border="0">
					</a>
				</td>
				<td style="padding:4px;" valign="top">
					<a href="?op=gallery&w=' . $file_name . '"><big><b>' . $name . '</b></big></a> ' . $edit . '<br>
					' . mmw_lang_author . ': <a href="?op=character&character=' . $author . '" class="level' . $char_info[$author][0] . '">' . $author . '</a><br>
					' . mmw_lang_image_comment . ': ' . $comment . '<br>
					' . mmw_lang_date . ': ' . date('d.m.Y H:i:s', $date) . '<br>
					' . mmw_lang_image_size . ': ' . $width . 'x' . $height . '<br>
					' . mmw_lang_file_size . ': ' . byteConvert($size) . '
				</td>
			</tr>
			</table>' . PHP_EOL . $rowbr;
		}
	}
	closedir($dh);

	?>
	<div>
		<span style="float:right">[ <?php echo $upload_acc_check; ?> ]</span>
		<?php echo mmw_lang_total_image; ?>: <b><?php echo $num; ?></b>
	</div>
	<?php
	echo $rowbr . $file_list;
}