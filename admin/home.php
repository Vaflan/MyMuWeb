<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>Welcome</legend>
			This Is Unique Administrator Panel MyMuWeb <?echo $mmw[version];?> By Vaflan, Installed <?include('includes/installed.php'); echo date("d.m.Y H:i:s", $mmw[installed]);?><hr>
			<center><b>News from the site of <a href="http://mymuweb.ru/forum/22-2989" target="_blank">Topic on www.MyMuWeb.ru</a></b></center>
			
		</fieldset>
		</td>
	</tr>
</table>