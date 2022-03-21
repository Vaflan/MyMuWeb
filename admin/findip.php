<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>Find Ip</legend>
			<form action="" method="post" name="search_ip" id="search_ip">
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			  <tr>
			    <td width="42%" align="right">Character</td>
			    <td><input name="ip_search" type="text" id="ip_search" size="17" maxlength="10"></td>
			  </tr>
			  <tr>
			    <td align="right">Search type</td>
			    <td>
                              <label>
                              <input type="radio" name="search_type" value="1" checked>
                              <span class="normal_text">Exact Match</span></label>
                              <br>
                              <label>
                              <input type="radio" name="search_type" value="0">
                              <span class="normal_text">Partial Match</span></label>
                              <br></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Find ip"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
		</td>
	</tr>
<?if(isset($_POST["ip_search"])) {?>
	<tr>
		<td align="center">
		<fieldset>
		<legend>Search Character IP Results</legend>
			<?include("admin/inc/search_ip.php");?>
		</fieldset>
		</td>
	</tr>
<?}?>
</table>