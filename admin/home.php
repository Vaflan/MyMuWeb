<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>Welcome</legend>
			This Is Unique Administrator Panel MyMuWeb <?echo $mmw[version];?> By Vaflan, Installed <?include('includes/installed.php'); echo date("d.m.Y H:i:s", $mmw[installed]);?><hr>
			<center><b>News from the site of <a href="http://www.mymuweb.ru/" target="_blank">www.MyMuWeb.Ru</a></b></center>
			<span id="mmw_news">If you see this report, a server or JavaScript means with news about MyMuWeb turned off!</span>
			<script language="javascript" src="http://mymuweb.ru/mmw_news.js"></script>
		</fieldset>
		</td>
	</tr>
</table>