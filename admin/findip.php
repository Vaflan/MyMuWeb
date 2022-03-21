<?PHP
if($mmw[admin_check] < 1) {die("$die_start Security Admin Panel is Turn On $die_end");}
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>Find Ip</legend>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		 <tr>
		  <td align="center">
			<form action="" method="post" name="with_ip">
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			  <tr>
			    <td width="42%" align="right">IP Address</td>
			    <td><input name="ip" type="text" id="ip" size="17" maxlength="15"></td>
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
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Find"></td>
			  </tr>
			</table>
			</form>
		  </td>
		  <td align="center">
			<form action="" method="post" name="with_acc">
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			  <tr>
			    <td width="42%" align="right">Account</td>
			    <td><input name="acc" type="text" id="acc" size="17" maxlength="10"></td>
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
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Find"></td>
			  </tr>
			</table>
			</form>
		  </td>
		  <td align="center">
			<form action="" method="post" name="with_char">
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			  <tr>
			    <td width="42%" align="right">Character</td>
			    <td><input name="char" type="text" id="char" size="17" maxlength="10"></td>
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
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Find"></td>
			  </tr>
			</table>
			</form>
		  </td>
		 </tr>
		</table>
		</fieldset>
		</td>
	</tr>
<?if(isset($_POST["ip"]) || isset($_POST["acc"]) || isset($_POST["char"])) {?>
	<tr>
		<td align="center">
		<fieldset>
		<legend>Search Character IP Results</legend>
			<?include("admin/inc/find_ip.php");?>
		</fieldset>
		</td>
	</tr>
<?}?>
</table>