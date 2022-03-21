<?PHP
$guild_get = stripslashes($_GET[guild]);

$sql_guild_check = mssql_query("SELECT g_name from guild WHERE g_name='$guild_get'"); 
$guild_check = mssql_num_rows($sql_guild_check);
$guild_mark_query = mssql_query("SELECT g_mark,g_score,g_master,g_notice from guild where g_name='$guild_get'");
$guild_mark_ = mssql_fetch_row($guild_mark_query);
$logo = urlencode(bin2hex($guild_mark_[0]));
if($guild_mark_[1]==NULL){$guild_mark_[1]="0";}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" height="109" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%"><div align="center">
        <fieldset>
        <legend>Guild <?echo $guild_get;?></legend>
        <table width="100%" height="108" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100%" valign="top">
                  <table width=100%>
                    <tr>
                      <td width="50" rowspan="3" align=left valign=top><img src='decode.php?decode=<?echo $logo;?>' height=50 width=50 broder=0></td>
                      <td align=left valign=top class="normal_text_white">Name: <?echo $guild_get;?><br/>
			Score: <?echo "$guild_mark_[1]";?><br/>
			Master:</span> <span class="link_rankings"><a href=index.php?op=character&character=<?echo $guild_mark_[2];?>><?echo $guild_mark_[2];?></a></span>
			</td>
                    </tr>
                    <tr>
                      <td align=left valign=top class="normal_text_white">Notice: <?echo $guild_mark_[3];?></td>
                    </tr>
                  </table>
		<br/>
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><div align="left"><?echo $guild_get;?> Members
                            <?include("modules/rankings/guild_members.php");?>
                    </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
          </tr>
        </table>
        </fieldset>
    </div></td>
  </tr>
</table>