<?PHP
$alliance = clean_var(stripslashes($_GET[num]));

$guild_query = mssql_query("SELECT g_name,g_master,g_mark FROM Guild WHERE Number='$alliance'");
$guild_row = mssql_fetch_row($guild_query);
$logo = urlencode(bin2hex($guild_row[2]));
$guild_mark = "<a class='helpLink' href='#' onclick=\"showHelpTip(event,'<img src=decode.php?decode=$logo height=60 width=60>',false); return false\"><img src='decode.php?decode=$logo' height='10' width='10' broder='0'></a> <a href='?op=guild&guild=$guildm[0]'>$guildm[0]</a>";
?>
	<table width="300" class="sort-table" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td width="100" align="right"><?echo mmw_lang_alliance;?>:</td>
            <td><a href="?op=guild&guild=<?echo $guild_row[0];?>"><?echo $guild_row[0];?></a> <?echo $guild_mark;?></td>
          </tr>
          <tr>
            <td align="right"><?echo guild_status(128);?>:</td>
            <td><a href="?op=character&character=<?echo $guild_row[1];?>"><?echo $guild_row[1];?></a></td>
          </tr>
	</table>

<?echo $rowbr;?>

<center>
<br><?echo mmw_lang_guilds_in_alliance;?><br>&nbsp;</br>
          <table class='sort-table' border='0' cellpadding='0' cellspacing='0'>                
          <thead><tr>
          <td>#</td>
          <td><?echo mmw_lang_guild;?></td>
          <td><?echo guild_status(128);?></td>
          <td><?echo mmw_lang_members;?></td>
          </tr></thead>

<?
$alliance_result = mssql_query("SELECT G_Name,G_Master,G_Mark FROM Guild WHERE G_Union='$alliance'");
for($i=0;$i < mssql_num_rows($alliance_result);++$i) {
	$rank = $i+1;
	$alliance_row = mssql_fetch_row($alliance_result);
	$alliance_logo = urlencode(bin2hex($alliance_row[2]));
	$guild_mark = "<a class='helpLink' href='#' onclick=\"showHelpTip(event,'<img src=decode.php?decode=$alliance_logo height=60 width=60>',false); return false\"><img src='decode.php?decode=$alliance_logo' height='10' width='10' broder='0'></a> <a href='?op=guild&guild=$guildm[0]'>$guildm[0]</a>";
	$members = mssql_num_rows( mssql_query("SELECT name FROM Guildmember WHERE G_Name='$alliance_row[0]'") );

echo 	"<tbody><tr>
            <td>$rank</td>
            <td><a href='?op=guild&guild=$alliance_row[0]'>$alliance_row[0]</a> $guild_mark</td>
            <td><a href='?op=character&character=$alliance_row[1]'>$alliance_row[1]</a></td>
            <td>$members</td>
            </tr></tbody>";
}
?>
</table>
</center>