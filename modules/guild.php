<?PHP
$guild_get = stripslashes($_GET[guild]);

$sql_guild_check = mssql_query("SELECT g_name from guild WHERE g_name='$guild_get'"); 
$guild_check = mssql_num_rows($sql_guild_check);
$guild_mark_query = mssql_query("SELECT g_mark,g_score,g_master,g_notice from guild where g_name='$guild_get'");
$guild_mark_ = mssql_fetch_row($guild_mark_query);
$logo = urlencode(bin2hex($guild_mark_[0]));
if($guild_mark_[1]==NULL){$guild_mark_[1]="0";}
?>
	<table width="100%" class="sort-table" cellpadding="0" cellspacing="0">
          <tr>
            <td width="54" align="center" rowspan="4"><img src='decode.php?decode=<?echo $logo;?>' width=50 broder=0></td>
            <td width="50" align="right">Name:</td>
            <td><?echo "$guild_get";?></td>
          </tr>
          <tr>
            <td align="right">Score:</td>
            <td><?echo "$guild_mark_[1]";?></td>
          </tr>
          <tr>
            <td align="right">Master:</td>
            <td><a href=index.php?op=character&character=<?echo $guild_mark_[2];?>><?echo $guild_mark_[2];?></a></td>
          </tr>
          <tr>
            <td align="right">Notice:</td>
            <td><?echo $guild_mark_[3];?></td>
          </tr>
	</table>
<?
echo $rowbr;

include("modules/rankings/guild_members.php");
?>