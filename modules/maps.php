<?
if($_POST[map_num] > 0){$select[$_POST[map_num]]=" selected";} else{$select[0]=" selected";}
?>
<div class="brdiv"></div>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%"><fieldset>
      <legend>Maps Form</legend>
      <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td><form action="" method="post" name="maps" id="maps">
			<span class="normal_text_white">Name
                          <select name="map_num">
                            <option value="0"<?echo $select[0];?>>Lorencia</option>
                            <option value="1"<?echo $select[1];?>>Dungeon</option>
                            <option value="2"<?echo $select[2];?>>Devias</option>
                            <option value="3"<?echo $select[3];?>>Noria</option>
                            <option value="4"<?echo $select[4];?>>Lost Tower</option>
                            <option value="6"<?echo $select[6];?>>Stadium</option>
                            <option value="7"<?echo $select[7];?>>Atlans</option>
                            <option value="8"<?echo $select[8];?>>Tarkan</option>
                            <option value="10"<?echo $select[10];?>>Icarus</option>
                            <option value="30"<?echo $select[30];?>>Valley of Loren</option>
                            <option value="31"<?echo $select[31];?>>Land of Trials</option>
                          </select> 
                      <input type="submit" name="Submit" value="Submit" class="button">
			</span>
          </form></td>
        </tr>
      </table>
    </fieldset></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
<div class="brdiv"></div>
<b><?echo map($_POST[map_num]);?></b><br>
<img src="map.php?m=<?if(isset($_POST[map_num])){echo $_POST[map_num];}else{echo "0";};?>">
    </td>
  </tr>
</table>