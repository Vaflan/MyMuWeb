<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
} ?>
<fieldset class="content">
	<legend>Welcome</legend>
	This Is Unique Administrator Panel MyMuWeb <?php echo $mmw['version']; ?> By Vaflan,
	Installed <?php echo date('d.m.Y H:i:s', $mmw['installed']); ?>
	<hr>
	<b>News from the site of <a href="http://mymuweb.ru/" target="_blank">MyMuWeb.Ru</a></b>
	<span id="mmw_news">If you see this report, a server or JavaScript means with news about MyMuWeb turned off!</span>
	<script><?php echo @file_get_contents('http://mmw.clan.su/mmw_news.js'); ?></script>
</fieldset>