<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}?>
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
                              <span class="normal_text">Partial Match</span></label>
                              <br>
                              <label>
                              <input type="radio" name="search_type" value="0">
                              <span class="normal_text">Exact Match</span></label>
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
                              <span class="normal_text">Partial Match</span></label>
                              <br>
                              <label>
                              <input type="radio" name="search_type" value="0">
                              <span class="normal_text">Exact Match</span></label>
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
                              <span class="normal_text">Partial Match</span></label>
                              <br>
                              <label>
                              <input type="radio" name="search_type" value="0">
                              <span class="normal_text">Exact Match</span></label>
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

<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
 <thead><tr>
  <td align="center">#</td>
  <td align="left">Character</td>
  <td align="left">Account</td>
  <td align="left">IP</td>
  <td align="left">Date Connect</td>
  <td align="center">Status</td>
 </tr></thead>
<?
$search_ip = clean_var(stripslashes($_POST['ip']));
$search_acc = clean_var(stripslashes($_POST['acc']));
$search_char = clean_var(stripslashes($_POST['char']));
$search_type = clean_var(stripslashes($_POST['search_type']));

if($search_type == 1) {
 if(isset($search_ip)) {$result = mssql_query("SELECT memb___id from MEMB_STAT where ip like '%$search_ip%'");}
 elseif(isset($search_acc)) {$result = mssql_query("SELECT memb___id from MEMB_STAT where memb___id like '%$search_acc%'");}
 elseif(isset($search_char)) {$result = mssql_query("SELECT accountid,name from Character where name like '%$search_char%'");}
}
else {
 if(isset($search_ip)) {$result = mssql_query("SELECT memb___id from MEMB_STAT where ip='$search_ip'");}
 elseif(isset($search_acc)) {$result = mssql_query("SELECT memb___id from MEMB_STAT where memb___id='$search_acc'");}
 elseif(isset($search_char)) {$result = mssql_query("SELECT accountid,name from Character where name='$search_char'");}
}

for($i=0;$i < @mssql_num_rows($result);$i++) {
 $row = mssql_fetch_row($result);
 $rank = $i+1;

 if(isset($search_char)) {
  $get_char_name = $row[1];
 }
 else {
  $get_char_result = mssql_query("Select GameIDC from AccountCharacter where Id='$row[0]'");
  $get_char_done = mssql_fetch_row($get_char_result);
  $get_char_name = $get_char_done[0];
 }

 $get_ip_result = mssql_query("Select ip,CONNECTTM,ConnectStat from MEMB_STAT where memb___id='$row[0]'");
 $get_ip_done = mssql_fetch_row($get_ip_result);

 if($get_ip_done[0] == NULL){$get_ip_done[0] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #120</font></td></tr></table>";}
 if($get_ip_done[2] == 0){$get_ip_done[2] ='<img src=images/Offline.gif>';}
 if($get_ip_done[2] == 1){$get_ip_done[2] ='<img src=images/Online.gif>';}
?>
 <tr>
  <td align='center'><?echo $rank;?>.</td>
  <td align='left'><?echo $get_char_name;?></td>
  <td align='left'><?echo $row[0];?></td>
  <td align='left'><?echo $get_ip_done[0];?></td>
  <td align='left'><?echo time_format($get_ip_done[1],"d.m.Y H:i");?></td>
  <td align='center'><?echo $get_ip_done[2];?></td>
 </tr>
<?}?>
</table>

		</fieldset>
		</td>
	</tr>
<?}?>
</table>