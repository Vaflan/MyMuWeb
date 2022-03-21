<?PHP
if($mmw[admin_check] < 1) {die("$die_start Security Admin Panel is Turn On $die_end");}
if(isset($_POST["edit_character_done"])) {edit_character();}
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
if($get_character_done[9] > 0){$mode[$get_character_done[9]] = "selected";} else{$mode[0] = "selected";}
if($get_character_done[16] > 0){$class[$get_character_done[16]] = "selected";} else{$class[0] = "selected";}

$online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$get_character_done[0]'");
$oc_row = mssql_fetch_row($online_check);
$get_chr = mssql_query("SELECT GameIDC FROM AccountCharacter WHERE Id='$get_character_done[0]'");
$get_acc_chr = mssql_fetch_row($get_chr);

if($oc_row[0]=='1'){$acc_status = "<font color='#00FF00'>Online</font>";}else{$acc_status = "<font color='#FF0000'>Offline</font>";}
if($get_acc_chr[0]==$character_edit && $oc_row[0]=='1'){$character_status = "<font color='#00FF00'>Online</font>";}else{$character_status = "<font color='#FF0000'>Offline</font>";}
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
			    <td><input name="zen" type="text" id="zen" value="<?echo $get_character_done[3];?>" maxlength="10" size="10"></td>
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
                                      <span class="normal_text">Exact Match</span></label>
                                      <br>
                                      <label>
                                      <input type="radio" name="search_type" value="0">
                                      <span class="normal_text">Partial Match</span></label>
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
			<?include_once("admin/inc/search_chr.php");?>
		</fieldset>
		</td>
	</tr>
<?}?>
</table>