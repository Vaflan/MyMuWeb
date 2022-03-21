<?PHP
$guild_get = clean_var(stripslashes($_GET[guild]));

$guild_query = mssql_query("SELECT g_mark,g_score,g_master,g_notice,g_union from guild where g_name='$guild_get'");
$guild_row = mssql_fetch_row($guild_query);
$logo = urlencode(bin2hex($guild_row[0]));
if($guild_row[1]==NULL || $guild_row[1]==' ') {$guild_row[1]="0";}

$guild_row[3] = str_replace('�','',$guild_row[3]);

if($guild_row[4]!=0 && $guild_row[4]!=' ') {
$alliance_guild_query = mssql_query("SELECT g_name from guild where Number='$guild_row[4]'");
$alliance_guild_row = mssql_fetch_row($alliance_guild_query);
}
?>
	<table width="100%" class="sort-table" cellpadding="0" cellspacing="0">
          <tr>
            <td width="80" align="center" rowspan="5"><img src="decode.php?decode=<?echo $logo;?>" width="80" broder="0"></td>
            <td width="100" align="right"><?echo mmw_lang_guild;?>:</td>
            <td><?echo $guild_get;?></td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_score;?>:</td>
            <td><?echo $guild_row[1];?></td>
          </tr>
          <tr>
            <td align="right"><?echo guild_status(128);?>:</td>
            <td><a href="?op=character&character=<?echo $guild_row[2];?>"><?echo $guild_row[2];?></a></td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_notice;?>:</td>
            <td><?echo $guild_row[3];?></td>
          </tr>
	<?if($guild_row[4]!=0 && $guild_row[4]!=' ') {?>
          <tr>
            <td align="right"><?echo mmw_lang_alliance;?>:</td>
            <td><a href="?op=alliance&num=<?echo $guild_row[4];?>"><?echo $alliance_guild_row[0];?></a></td>
          </tr>
	<?}?>
	</table>

<?echo $rowbr;?>

<table class="sort-table" cellspacing="0" cellpadding="0" border="0" width="100%">
<thead><tr>
	<td>#</td>
	<td><?echo mmw_lang_character;?></td>
	<td><?echo mmw_lang_reset;?></td>
	<td><?echo mmw_lang_level;?></td>
	<td><?echo mmw_lang_class;?></td>
	<td><?echo mmw_lang_status;?></td>
</tr></thead>
<?
$result = mssql_query("SELECT name,G_Status from guildmember where g_name='$guild_get' order by G_Status desc");
for($i=0;$i < mssql_num_rows($result);++$i)
{
$row = mssql_fetch_row($result);
$sql_character = mssql_query("Select clevel,reset,class,AccountID from character where name='$row[0]'");
$character_show = mssql_fetch_row($sql_character);

             $status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$character_show[3]'");
             $status = mssql_fetch_row($status_reults);
             $statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$character_show[3]'");
             $statusdc = mssql_fetch_row($statusdc_reults);

             if($status[0] == 1 && $statusdc[0] == $row[0]) 
		{$status[0] ='<img src=./images/online.gif width=6 height=6>';}
             else {$status[0] ='<img src=./images/offline.gif width=6 height=6>';}

$rank = $i+1;
echo "<tbody><tr> 
<td>$rank</td>
<td>$status[0] <a href=?op=character&character=$row[0]>$row[0]</a></td>
<td>$character_show[1]</td>
<td>$character_show[0]</td>
<td>".char_class($character_show[2],off)."</td>
<td>".guild_status($row[1])."</td>
</tr></tbody>";    
}            
?>
</table>