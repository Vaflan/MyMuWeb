<?
if(isset($_POST["clear_logs"])){clear_logs($_POST["log_name"]);}
?>

<table width="430" border="0" cellspacing="4" cellpadding="0">
  <tr>
    <td height="35"><fieldset>
      <legend>Client Requests </legend>
       <table width="100%" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td class="link_logs"><a href="logs.php?log=requests" target="_blank">Requests</a></td>
          <td class="link_logs">
            <form action="" method="post" name="clear01" id="clear01">
               <input name="log_name" type="hidden" id="log_name" value="requests"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form>
          </td>
        </tr>
       </table>
    </fieldset></td>
  </tr>
  <tr>
    <td><fieldset>
      <legend>Admin Side</legend>
      <table width="385" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td class="link_logs"><a href="logs.php?log=news" target="_blank">News Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear12" id="clear12">
               <input name="log_name" type="hidden" id="log_name" value="news"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=server" target="_blank">Server Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear13" id="clear13">
               <input name="log_name" type="hidden" id="log_name" value="server"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=link" target="_blank">Downloads Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear14" id="clear14">
               <input name="log_name" type="hidden" id="log_name" value="link"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=sql_query" target="_blank">SQL Query Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear15" id="clear15">
               <input name="log_name" type="hidden" id="log_name" value="sql_query"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=edit_char" target="_blank">Edit Character Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear17" id="clear17">
               <input name="log_name" type="hidden" id="log_name" value="edit_char"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=edit_acc" target="_blank">Edit Account Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear18" id="clear18">
               <input name="log_name" type="hidden" id="log_name" value="edit_acc"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=del_acc" target="_blank">Delete Account Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear19" id="clear19">
               <input name="log_name" type="hidden" id="log_name" value="del_acc"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=edit_acc_wh" target="_blank">Edit Account WH Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear110" id="clear110">
               <input name="log_name" type="hidden" id="log_name" value="edit_acc_wh"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
      </table>
    </fieldset></td>
  </tr>
  <tr>
    <td><fieldset>
      <legend>Client Side</legend>
      <table width="385" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td class="link_logs"><a href="logs.php?log=money" target="_blank">Ware House Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear21" id="clear21">
               <input name="log_name" type="hidden" id="log_name" value="money"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=resets" target="_blank">Resets Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear22" id="clear22">
               <input name="log_name" type="hidden" id="log_name" value="resets"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=stats" target="_blank">Stats Add Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear23" id="clear23">
               <input name="log_name" type="hidden" id="log_name" value="stats"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=referral" target="_blank">Referral Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear24" id="clear24">
               <input name="log_name" type="hidden" id="log_name" value="referral"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=clearpk" target="_blank">Clear Pk Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear25" id="clear25">
               <input name="log_name" type="hidden" id="log_name" value="clearpk"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=move" target="_blank">Move Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear26" id="clear26">
               <input name="log_name" type="hidden" id="log_name" value="move"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
        <tr>
          <td class="link_logs"><a href="logs.php?log=send_zen" target="_blank">Send Zen Logs</a></td>
          <td class="link_logs"><?if($_SESSION[a_admin_level] > 6){?>
            <form action="" method="post" name="clear28" id="clear28">
               <input name="log_name" type="hidden" id="log_name" value="send_zen"> <input name="clear_logs" type="hidden" id="clear_logs"> <input type="submit" name="Submit" value="Clear">
            </form><?}?>
          </td>
        </tr>
      </table>
    </fieldset></td>
  </tr>
</table>