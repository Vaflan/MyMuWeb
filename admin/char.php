<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

// Character Editor
if(isset($_POST["edit_character_done"])) {
 $post_character = $_POST['character'];
 $post_level = $_POST['level'];
 $post_reset = $_POST['reset'];
 $post_zen = $_POST['zen'];
 $post_gm = $_POST['gm'];
 $post_strength = $_POST['strength'];
 $post_agility = $_POST['agility'];
 $post_vitality = $_POST['vitality'];
 $post_energy = $_POST['energy'];
 $post_command = $_POST['command'];
 $post_leveluppoint = $_POST['leveluppoint'];
 $post_pklevel = $_POST['pklevel'];
 $post_pktime = $_POST['pktime'];
 $post_mapnumber = $_POST['mapnumber'];
 $post_mapposx = $_POST['mapposx'];
 $post_mapposy = $_POST['mapposy'];
 $post_class = $_POST['class'];
 $get_account = mssql_query("SELECT accountid,Name from character where Name='$post_character'");
 $get_account_done = mssql_fetch_row($get_account);

 $online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$get_account_done[0]'");
 $oc_row = mssql_fetch_row($online_check);
 $get_chr = mssql_query("SELECT GameIDC FROM AccountCharacter WHERE Id='$get_account_done[0]'");
 $get_acc_chr = mssql_fetch_row($get_chr);

 if(empty($post_character) || empty($post_level) || empty($post_strength) || empty($post_agility) || empty($post_vitality) || empty($post_energy)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(mssql_num_rows($get_account) <= 0) {echo "$warning_red Error: Character $post_character Doesn't Exist!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif($oc_row[0]!=0 && $get_acc_chr[0]==$get_account_done[1]) {echo "$warning_red Error: Character $post_character Must Be Logged Off!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(ereg('[^0-9]', $post_level)) {echo "$warning_red Error: Please Use Only Numbers At Level!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(ereg('[^0-9]', $post_reset)) {echo "$warning_red Error: Please Use Only Numbers At Reset!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(ereg('[^0-9]', $post_zen)) {echo "$warning_red Error: Please Use Only Numbers At Zen!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(ereg('[^0-9]', $post_leveluppoint)) {echo "$warning_red Error: Please Use Only Numbers At Level Up Point!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(ereg('[^0-9]', $post_pklevel)) {echo "$warning_red Error: Please Use Only Numbers At PK Level!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(ereg('[^0-9]', $post_pktime)) {echo "$warning_red Error: Please Use Only Numbers At PK Time!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(ereg('[^0-9]', $post_mapnumber)) {echo "$warning_red Error: Please Use Only Numbers At Map Number!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(ereg('[^0-9]', $post_mapposx)) {echo "$warning_red Error: Please Use Only Numbers At Map x!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(ereg('[^0-9]', $post_mapposy)) {echo "$warning_red Error: Please Use Only Numbers At Map y!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("UPDATE character SET [clevel]='$post_level',[reset]='$post_reset',[money]='$post_zen',[ctlcode]='$post_gm',[strength]='$post_strength',[dexterity]='$post_agility',[vitality]='$post_vitality',[energy]='$post_energy',[leadership]='$post_command',[LevelUpPoint]='$post_leveluppoint',[PkLevel]='$post_pklevel',[PkTime]='$post_pktime',[mapnumber]='$post_mapnumber',[mapposx]='$post_mapposx',[mapposy]='$post_mapposy',[class]='$post_class' WHERE name='$post_character'");
  echo "$warning_green Character $post_character SuccessFully Edited!";
  writelog("a_edit_char","Character $_POST[character] Has Been <font color=#FF0000>Edited</font> with the next->Level:$_POST[level]|Reset:$_POST[reset]|Zen:$_POST[zen]|Strengh:$_POST[strength]|Agiltiy:$_POST[agility]|Vitality:$_POST[vitality]|Energy:$_POST[energy]|Command:$_POST[command]|LevelUpPoint:$_POST[leveluppoint]|ResTime:$_POST[restime]|PkLevel:$_POST[pklevel]|PkTime:$_POST[pktime]|MapNumber:$_POST[mapnumber]|MapX:$_POST[mapposx]|Mapy:$_POST[mapposy]");
 }
}
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>

<?
if(isset($_POST["character_search_edit"]) || isset($_GET["chr"])) {
 if(isset($_GET['chr'])) {$_POST['character_search_edit'] = $_GET['chr'];}
 $character_edit = stripslashes($_POST['character_search_edit']);
 $get_character = mssql_query("Select accountid,clevel,reset,money,strength,dexterity,vitality,energy,leadership,ctlcode,LevelUpPoint,PkLevel,PkTime,mapnumber,mapposx,mapposy,Class from character where name='$character_edit'");
 $get_character_done = mssql_fetch_row($get_character);
 if($get_character_done[9] > 0) {$mode[$get_character_done[9]] = "selected";} else {$mode[0] = "selected";}
 if($get_character_done[16] > 0) {$class[$get_character_done[16]] = "selected";} else {$class[0] = "selected";}

 $online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$get_character_done[0]'");
 $oc_row = mssql_fetch_row($online_check);
 $get_chr = mssql_query("SELECT GameIDC FROM AccountCharacter WHERE Id='$get_character_done[0]'");
 $get_acc_chr = mssql_fetch_row($get_chr);

 if($oc_row[0]=='1') {$acc_status = "<font color='#00FF00'>Online</font>";}else{$acc_status = "<font color='#FF0000'>Offline</font>";}
 if($get_acc_chr[0]==$character_edit && $oc_row[0]=='1') {$character_status = "<font color='#00FF00'>Online</font>";}else{$character_status = "<font color='#FF0000'>Offline</font>";}
?>
		<legend>Character <?echo $get_character_done[0];?></legend>
			<form action="" method="post" name="edit_character_form" id="edit_character_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			  <tr>
			    <td width="42%" align="right">Account</td>
			    <td><a href="?op=acc&acc=<?echo $get_character_done[0];?>"><?echo $get_character_done[0];?></a>  <?echo $acc_status;?></td>
			  </tr>
			  <tr>
			    <td align="right">Character</td>
			    <td><?echo $character_edit;?> <?echo $character_status;?></td>
			  </tr>
			  <tr>
			    <td align="right">Level</td>
			    <td><input name="level" type="text" id="level" value="<?echo $get_character_done[1];?>" maxlength="3" size="3"></td>
			  </tr>
			  <tr>
			    <td align="right">Reset</td>
			    <td><input name="reset" type="text" id="reset" value="<?echo $get_character_done[2];?>" maxlength="3" size="3"></td>
			  </tr>
			  <tr>
			    <td align="right">Level Up Point</td>
			    <td><input name="leveluppoint" type="text" id="leveluppoint" value="<?echo $get_character_done[10];?>" maxlength="5" size="5"></td>
			  </tr>
			  <tr>
			    <td align="right">Zen</td>
			    <td><input name="zen" type="text" id="zen" value="<?echo $get_character_done[3];?>" maxlength="10" size="12"></td>
			  </tr>
			  <tr>
			    <td align="right">Class</td>
			    <td>
				<select name="class" size="1" id="class">
					<option value=0 <?echo $class[0];?>>DW</option><option value=1 <?echo $class[1];?>>SM</option><option value=2 <?echo $class[2];?>>GrM</option><option value=16 <?echo $class[16];?>>DK</option><option value=17 <?echo $class[17];?>>BK</option><option value=18 <?echo $class[18];?>>BM</option><option value=32 <?echo $class[32];?>>ELF</option><option value=33 <?echo $class[33];?>>ME</option>
					<option value=34 <?echo $class[34];?>>HE</option><option value=48 <?echo $class[48];?>>MG</option><option value=49 <?echo $class[49];?>>DM</option><option value=64 <?echo $class[64];?>>DL</option><option value=65 <?echo $class[65];?>>LE</option><option value=80 <?echo $class[80];?>>Sum</option><option value=81 <?echo $class[81];?>>Bsum</option><option value=82 <?echo $class[82];?>>Dim</option>
				</select>
			    </td>
			  </tr>
			  <tr>
			    <td align="right">Mode</td>
			    <td><select name="gm" size="1" id="gm"><option value=0 <?echo $mode[0];?>>Normal</option><option value=1 <?echo $mode[1];?>>Blocked</option><option value=8 <?echo $mode[8];?>>GM Invisible</option><option value=32 <?echo $mode[32];?>>Game Master</option></select></td>
			  </tr>
			  <tr>
			    <td align="right">Strength</td>
			    <td><input name="strength" type="text" id="strength" value="<?echo $get_character_done[4];?>" maxlength="5" size="5"></td>
			  </tr>
			  <tr>
			    <td align="right">Agility</td>
			    <td><input name="agility" type="text" id="agility" value="<?echo $get_character_done[5];?>" maxlength="5" size="5"></td>
			  </tr>
			  <tr>
			    <td align="right">Vitality</td>
			    <td><input name="vitality" type="text" id="vitality" value="<?echo $get_character_done[6];?>" maxlength="5" size="5"></td>
			  </tr>
			  <tr>
			    <td align="right">Energy</td>
			    <td><input name="energy" type="text" id="energy" value="<?echo $get_character_done[7];?>" maxlength="5" size="5"></td>
			  </tr>
			  <tr>
			    <td align="right">Command</td>
			    <td><input name="command" type="text" id="command" value="<?echo $get_character_done[8];?>" maxlength="5" size="5"></td>
			  </tr>
			  <tr>
			    <td align="right">Pk Level, Time</td>
			    <td><input name="pklevel" type="text" id="pklevel" value="<?echo $get_character_done[11];?>" maxlength="2" size="2"> <input name="pktime" type="text" id="pktime" value="<?echo $get_character_done[12];?>" maxlength="3" size="3"></td>
			  </tr>
			  <tr>
			    <td align="right">Map, x, y</td>
			    <td><input name="mapnumber" type="text" id="mapnumber" value="<?echo $get_character_done[13];?>" maxlength="2" size="2"> <input name="mapposx" type="text" id="mapposx" value="<?echo $get_character_done[14];?>" maxlength="3" size="3"> <input name="mapposy" type="text" id="mapposy" value="<?echo $get_character_done[15];?>" maxlength="3" size="3"></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input type="submit" name="Edit Character" value="Edit Character"> <input type="hidden" name="edit_character_done" value"edit_character_done"> <input type="hidden" name="character" value="<?echo $character_edit;?>"> <input type="reset" name="Reset" value="Reset"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
		</td>
	</tr>
	<tr>
		<td align="center">
		<fieldset>
<?}?>
		<legend>Search Character</legend>
			<form action="" method="post" name="search_" id="search_">
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			  <tr>
			    <td width="42%" align="right">Character</td>
			    <td><input name="character_search" type="text" id="character_search" size="17" maxlength="10"></td>
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
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Search Character"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
		</td>
	</tr>
<?if(isset($_POST["character_search"])) {?>
	<tr>
		<td align="center">
		<fieldset>
		<legend>Search Character Results</legend>

<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
 <thead><tr>
  <td align="center">#</td>
  <td align="left">Name</td>
  <td align="left">Account</td>
  <td align="left">Level</td>
  <td align="left">Resets</td>
  <td align="left">Class</td>
  <td align="center">Status</td>
  <td align="center">Edit</td>
 </tr></thead>
<?
$search = clean_var(stripslashes($_POST['character_search']));
$search_type = clean_var(stripslashes($_POST['search_type']));

if($_POST['search_type']==0) {$result = mssql_query("SELECT Name,Class,cLevel,reset,strength,dexterity,vitality,energy,accountid,ctlcode from Character where name='$search'");}
if($_POST['search_type']==1) {$result = mssql_query("SELECT Name,Class,cLevel,reset,strength,dexterity,vitality,energy,accountid,ctlcode  from Character where name like '%$search%'");}

for($i=0;$i < mssql_num_rows($result);++$i) {
 $row = mssql_fetch_row($result);
 $rank = $i+1;

 $status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[8]'");
 $status = mssql_fetch_row($status_reults);

 if($status[0] == 0){$status[0] ='<img src=images/offline.gif>';}
 if($status[0] == 1){$status[0] ='<img src=images/online.gif>';}

 if($row[9] == 1) {$row[9] = "<table><tr><td bgcolor='yellow'><font color='#000000' size='1'>Blocked</font></td></tr></table>";}
 elseif($row[9] == 32 || $row[9] == 8) {$row[9] = "<table><tr><td bgcolor='blue'><font color='#FFFFFF' size='1'>GM</font></td></tr></table>";}
 elseif($row[9] == 0) {$row[9] = "Normal";}

 $character_table_edit = "<form action='' method='post'><input type='submit'value='Edit'><input name='character_search_edit' type='hidden' value='$row[0]'></form>";
?>
 <tr>
  <td align='center'><?echo $rank;?>.</td>
  <td align='left'><?echo $row[0];?></td>
  <td align='left'><a href='?op=acc&acc=<?echo $row[8];?>'><?echo $row[8];?></a></td>
  <td align='left'><?echo $row[2];?></td>
  <td align='left'><?echo $row[3];?></td>
  <td align='left'><?echo char_class($row[1]);?></td>
  <td align='center'><?echo $status[0];?></td>
  <td align='center'><?echo $character_table_edit;?></td>
 </tr>
<?}?>
</table>

		</fieldset>
		</td>
	</tr>
<?}?>
</table>