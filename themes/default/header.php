<?php // This is Header Theme ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<title><?php echo $mmw['webtitle']; ?></title>
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<script src="scripts/jquery.js"></script>
	<script src="scripts/functions.js"></script>
	<link href="<?php echo $mmw['theme_dir']; ?>/style.css" rel="stylesheet" type="text/css" media="all">
	<link href="<?php echo $mmw['theme_dir']; ?>/favicon.ico" rel="shortcut icon">
</head>
<body style="background:#000000 url('<?php echo $mmw['theme_img']; ?>/bg.png');margin:20px;padding:0">
<div align="center">
	<a href="<?php echo $mmw['serverwebsite']; ?>" title="<?php echo mmw_lang_home_page . ' ' . $mmw['servername']; ?>">
		<img src="<?php echo $mmw['theme_img']; ?>/logo.png" border="0">
	</a>
</div>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr height="90">
		<td width="114" style="background:url('<?php echo $mmw['theme_img']; ?>/up_left.png') no-repeat left" align="right"
			valign="bottom"> <?php language(); ?> </td>
		<td style="background:url('<?php echo $mmw['theme_img']; ?>/up_center.png');padding-top:14px;color:#9F9F9F"
			align="center" valign="top">
			<marquee behavior="scroll" loop="-1" width="100%" scrollamount="2" hspace="0" vspace="0" scrolldelay="60"
					 onmouseover='this.stop()' onmouseout='this.start()'>
				<b>Welcome to Web <?php echo $mmw['servername']; ?>! Online Game MMORPG!</b>
			</marquee>
		</td>
		<td width="114" style="background:url('<?php echo $mmw['theme_img']; ?>/up_right.png') no-repeat right" valign="bottom"> <?php theme(); ?> </td>
	</tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="15" style="background:url('<?php echo $mmw['theme_img']; ?>/center_left.png') left top repeat-y"></td>
		<td style="background:url('<?php echo $mmw['theme_img']; ?>/background.png')" align="center">

			<table width="100%" border="0" align="center">
				<tr>
					<td width="164" valign="top" style="padding:4px">
						<!-- Block -->

						<table cellpadding="0" cellspacing="0" class="block-table">
							<tr>
								<td class="block-left"></td>
								<td class="block-up"></td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td class="block-left"></td>
								<td style="padding: 5px;">
									<div class="block-title"><?php echo mmw_lang_account_menu; ?></div>
									<?php login_form(); ?>
								</td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td colspan="3" class="block-down"></td>
							</tr>
						</table>

						<?php echo $rowbr; ?>

						<table cellpadding="0" cellspacing="0" class="block-table">
							<tr>
								<td class="block-left"></td>
								<td class="block-up"></td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td class="block-left"></td>
								<td style="padding: 5px;">
									<div class="block-title"><?php echo mmw_lang_menu; ?></div>
									<?php menu('<a href="%url%" onmouseover="document.getElementById(\'menu%id%\').src=\'' . $mmw['theme_img'] . '/link.gif\';" onmouseout="document.getElementById(\'menu%id%\').src=\'' . $mmw['theme_img'] . '/link.png\';"><img src="' . $mmw['theme_img'] . '/link.png" id="menu%id%"> <b>%name%</b></a><br>'); ?>
								</td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td colspan="3" class="block-down"></td>
							</tr>
						</table>

						<?php echo $rowbr; ?>

						<table cellpadding="0" cellspacing="0" class="block-table">
							<tr>
								<td class="block-left"></td>
								<td class="block-up"></td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td class="block-left"></td>
								<td style="padding: 5px;">
									<div class="block-title"><?php echo mmw_lang_statistic; ?></div>
									<?php statisitcs('fullblink'); ?>
								</td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td colspan="3" class="block-down"></td>
							</tr>
						</table>

						<?php echo $rowbr; ?>

						<table cellpadding="0" cellspacing="0" class="block-table">
							<tr>
								<td class="block-left"></td>
								<td class="block-up"></td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td class="block-left"></td>
								<td style="padding: 5px;">
									<div class="block-title"><?php echo mmw_lang_top; ?></div>
									<?php top_list('best'); ?>
								</td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td colspan="3" class="block-down"></td>
							</tr>
						</table>

						<?php echo $rowbr; ?>

						<table cellpadding="0" cellspacing="0" class="block-table">
							<tr>
								<td class="block-left"></td>
								<td class="block-up"></td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td class="block-left"></td>
								<td style="padding: 5px;">
									<div class="block-title"><?php echo mmw_lang_voting; ?></div>
									<?php voting(); ?>
								</td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td colspan="3" class="block-down"></td>
							</tr>
						</table>

						<?php echo $rowbr; ?>

						<table cellpadding="0" cellspacing="0" class="block-table">
							<tr>
								<td class="block-left"></td>
								<td class="block-up"></td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td class="block-left"></td>
								<td style="padding: 5px;">
									<div class="block-title"><?php echo mmw_lang_last_in_forum; ?></div>
									<?php last_in_forum($mmw['last_in_forum']); ?>
								</td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td colspan="3" class="block-down"></td>
							</tr>
						</table>

						<?php echo $rowbr; ?>

						<table cellpadding="0" cellspacing="0" class="block-table">
							<tr>
								<td class="block-left"></td>
								<td class="block-up"></td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td class="block-left"></td>
								<td style="padding: 5px;">
									<div class="block-title"><?php echo mmw_lang_who_is_on_web; ?></div>
									<?php who_online(); ?>
								</td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td colspan="3" class="block-down"></td>
							</tr>
						</table>

						<?php echo $rowbr; ?>

						<table cellpadding="0" cellspacing="0" class="block-table">
							<tr>
								<td class="block-left"></td>
								<td class="block-up"></td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td class="block-left"></td>
								<td style="padding: 5px;">
									<div class="block-title"><?php echo mmw_lang_ads_banners; ?></div>
									<?php echo file_get_contents('ADS.txt'); ?>
								</td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td colspan="3" class="block-down"></td>
							</tr>
						</table>

						<?php echo $rowbr; ?>

						<table cellpadding="0" cellspacing="0" class="block-table">
							<tr>
								<td class="block-left"></td>
								<td class="block-up"></td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td class="block-left"></td>
								<td style="padding: 5px;">
									<div class="block-title"><?php echo mmw_lang_server_time; ?></div>
									<?php include_once 'includes/times.php';?>
								</td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td colspan="3" class="block-down"></td>
							</tr>
						</table>

						<!-- /Block -->
					</td>
					<td valign="top" style="padding-right:4px; padding-top:4px; padding-bottom:4px;">
						<!-- Body -->

						<table cellpadding="0" cellspacing="0" class="block-table">
							<tr>
								<td class="block-left"></td>
								<td class="block-up"></td>
								<td class="block-right"></td>
							</tr>
							<tr>
								<td class="block-left"></td>
								<td style="padding: 5px;">
									<div class="block-title" style="text-align: left;">
										<a href="<?php echo $mmw['serverwebsite']; ?>"><?php echo mmw_lang_home_page; ?></a>
										&gt;
										<a href="?op=info"><?php echo $mmw['servername']; ?></a>
										<?php current_module(); ?>
									</div>