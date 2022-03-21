<?
if(isset($_POST["edit_character_done"])){edit_character();}

if(isset($_POST["character_search_edit"]) || isset($_GET["chr"])){

if(isset($_GET['chr'])){$_POST['character_search_edit'] = $_GET['chr'];}
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

echo '
<table width="400" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td>
		<fieldset>
			<legend>Character '.$get_character_done[0].'</legend>
                                                              <form action="" method="post" name="edit_character_form" id="edit_character_form">
                                                                    <table width="100%" border="0" cellspacing="4" cellpadding="0">
                                                                      <tr>
                                                                        <td width="50%" scope="row"><div align="right" class="text_administrator">Account</div></td>
                                                                        <td width="50%" scope="row" class="text_administrator"><a href="?op=acc&acc='.$get_character_done[0].'">'.$get_character_done[0].'</a>  '.$acc_status.'</td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td width="50%" scope="row"><div align="right" class="text_administrator">Character</div></td>
                                                                        <td width="50%" scope="row" class="text_administrator">'.$character_edit.' '.$character_status.'</td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Level</div></td>
                                                                        <td scope="row"><input name="level" type="text" id="level" value="'.$get_character_done[1].'" maxlength="3" size="3"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Resets</div></td>
                                                                        <td scope="row"><input name="resets" type="text" id="resets" value="'.$get_character_done[2].'" maxlength="3" size="3"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Level Up Point</div></td>
                                                                        <td scope="row"><input name="leveluppoint" type="text" id="leveluppoint" value="'.$get_character_done[10].'" maxlength="5" size="5"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Zen</div></td>
                                                                        <td scope="row"><input name="zen" type="text" id="zen" value="'.$get_character_done[3].'" maxlength="10" size="10"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Class</div></td>
                                                                        <td scope="row"><select name="class" size="1" id="class"><option value=0 '.$class[0].'>DW</option><option value=1 '.$class[1].'>SM</option><option value=16 '.$class[16].'>DK</option><option value=17 '.$class[17].'>BK</option><option value=32 '.$class[32].'>ELF</option><option value=33 '.$class[33].'>ME</option><option value=48 '.$class[48].'>MG</option><option value=64 '.$class[64].'>DL</option></select></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Mode</div></td>
                                                                        <td scope="row"><select name="gm" size="1" id="gm"><option value=0 '.$mode[0].'>Normal</option><option value=1 '.$mode[1].'>Blocked</option><option value=8 '.$mode[8].'>GM Invisible</option><option value=32 '.$mode[32].'>Game Master</option></select></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Strength</div></td>
                                                                        <td scope="row"><input name="strength" type="text" id="strength" value="'.$get_character_done[4].'" maxlength="5" size="5"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Agility</div></td>
                                                                        <td scope="row"><input name="agility" type="text" id="agility" value="'.$get_character_done[5].'" maxlength="5" size="5"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Vitality</div></td>
                                                                        <td scope="row"><input name="vitality" type="text" id="vitality" value="'.$get_character_done[6].'" maxlength="5" size="5"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Energy</div></td>
                                                                        <td scope="row"><input name="energy" type="text" id="energy" value="'.$get_character_done[7].'" maxlength="5" size="5"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Command</div></td>
                                                                        <td scope="row"><input name="command" type="text" id="command" value="'.$get_character_done[8].'" maxlength="5" size="5"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Pk Level, Time</div></td>
                                                                        <td scope="row"><input name="pklevel" type="text" id="pklevel" value="'.$get_character_done[11].'" maxlength="2" size="2"> <input name="pktime" type="text" id="pktime" value="'.$get_character_done[12].'" maxlength="3" size="3"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Map, x, y</div></td>
                                                                        <td scope="row"><input name="mapnumber" type="text" id="mapnumber" value="'.$get_character_done[13].'" maxlength="2" size="2"> <input name="mapposx" type="text" id="mapposx" value="'.$get_character_done[14].'" maxlength="3" size="3"> <input name="mapposy" type="text" id="mapposy" value="'.$get_character_done[15].'" maxlength="3" size="3"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><input type="hidden" name="edit_character_done" value"edit_character_done"></td>
                                                                        <td scope="row"><input type="hidden" name="character" value="'.$character_edit.'"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row" align="right"><input type="submit" name="Edit Character" value="Edit Character" class="button"></td>
                                                                        <td scope="row"><input type="reset" name="Reset" value="Reset" class="button"></td>
                                                                      </tr>
                                                                    </table>
                                                              </form>
		</fieldset>
    </td>
  </tr>
</table> ';
}?>

<table width="400" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td>
        <fieldset>
        <legend>Search Character</legend>
              <form action="" method="post" name="search_" id="search_">
                       <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                <tr>
                                  <td colspan="2"><span class="normal_text">Character:</span> <input name="character_search" type="text" id="character_search" size="17" maxlength="10"></td>
                                </tr>
                                <tr>
                                  <td width="70"><span class="normal_text">Search type</span></td>
                                  <td><p>
                                      <label>
                                      <input type="radio" name="search_type" value="1" checked>
                                      <span class="normal_text">Exact Match</span></label>
                                      <br>
                                      <label>
                                      <input type="radio" name="search_type" value="0">
                                      <span class="normal_text">Partial Match</span></label>
                                      <br>
                                  </p></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><input type="submit" name="Submit" value="Search Character"></td>
                                </tr>
                       </table>
               </form>
        </fieldset>
    </td>
  </tr>
</table>

<table width="600" border="0" cellspacing="4" cellpadding="0"> 
  <tr>
    <td scope="row" align="center">
	<?if(isset($_POST["character_search"])){include("admin/inc/search_chr.php");}?>
    </td>
  </tr>
</table>