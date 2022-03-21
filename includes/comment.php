<?PHP
// Comment By Vaflan
// For MyMuWeb

if(isset($_POST['c_message'])){echo $rowbr; require("includes/character.class.php"); option::comment_send($c_id_blog,$c_id_code);}
if(isset($_POST['c_id_delete'])){echo $rowbr; require("includes/character.class.php"); option::comment_delete($_POST['c_id_delete']);}

$result = mssql_query("SELECT c_id,c_char,c_text,c_date FROM MMW_comment WHERE c_id_blog='$c_id_blog' AND c_id_code='$c_id_code' ORDER BY c_date ASC");
$comm_num = mssql_num_rows($result);
      echo '
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td width="60%" height="25">'.mmw_lang_total_comment.': <b>'.$comm_num.'</b></td>
	<td align="right" height="25">[ <a href="#sign">'.mmw_lang_add_comment.'</a> ]</td></tr>
	<tr><td colspan="2">
           ';
  for ($i = 0; $i < $comm_num; $i++)
  {
      $num = $i+1;
      $row = mssql_fetch_row($result);
      $time_c = date('H:i:s', $row[3]);
      $day_c = date('d.m.Y', $row[3]);
      $row[2] = bbcode(smile($row[2]));
      $char_info = $char_array[$row[1]];

      if($char_info == '') {
	$result_char = mssql_query("SELECT AccountID,CtlCode FROM Character WHERE Name='$row[1]'");
	$row_char = mssql_fetch_row($result_char);
	$result_acc = mssql_query("SELECT country,gender,avatar,hide_profile FROM memb_info WHERE memb___id='$row_char[0]'");
	$row_acc = mssql_fetch_row($result_acc);
	$char_array[$row[1]] = array($row_char[0],$row_char[1],$row_acc[0],$row_acc[1],$row_acc[2],$row_acc[3]);
	$char_info = $char_array[$row[1]];
      }

	if($char_info[4] != "" && $char_info[4] != " "){$avatar_c_e="<img src='$char_info[4]' width='110' alt='$row[1]' border='0'>";}
	else {$avatar_c_e="<img src='images/no_avatar.jpg' width='110' alt='No Àâàòîð' border='0'>";}

	if($char_info[2] == '0'){$country = "Not Set";}
	else{$country = country($char_info[2]);}

	if($char_info[5] == '0'){$avatar_c_e = "<a href='?op=profile&profile=$char_info[0]'>$avatar_c_e</a>";}
	else{$avatar_c_e = $avatar_c_e;}

	$c_num_result = mssql_query("SELECT c_id FROM MMW_comment WHERE c_char='$row[1]'");
	$comment_c_num = mssql_num_rows($c_num_result);

	if($_SESSION['mmw_status'] >= $mmw[comment_can_delete] || $_SESSION['char_set']==$row[1])
	{$edit = "<form action='' method='post' name='delete$num'><input name='c_id_delete' type='hidden' value='$row[0]'><a href='javascript://' title='".mmw_lang_delete."'><img src='images/delete.png' border='0' onclick='delete$num.submit()'></a></form>";}
	else {$edit = '';}

      echo '
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="aBlock">
	<tr><td style="padding:2px;" width="110" valign="top" align="center">'.$avatar_c_e.'</td>
	<td style="padding:4px;" valign="top"><div class="sizedcomment">'.$row[2].'</div></td>
	<td style="padding:2px;" align="center" width="114" valign="top">
	<table border="0" width="100%"><td class="aRight">â„–'.$num.'</td></table>
	'.mmw_lang_char.': <a class="level'.$char_info[1].'" href="?op=character&character='.$row[1].'">'.$row[1].'</a><br/>
	'.mmw_lang_country.': '.$country.'<br/>'.mmw_lang_gender.': '.gender($char_info[3]).'<br/>'.mmw_lang_comments.': '.$comment_c_num.'<br/><span title="'.$time_c.'"><i>'.mmw_lang_date.': '.$day_c.'</i></span><br/>'.$edit.'
	</td></tr>
	</table><br />
           ';
  }
      echo '</td></tr>
	<tr><td colspan="2"><a name="sign"></a></td></tr>
	</table>
           ';


  if($c_add_close == 'yes') {
	echo '<div align="center">'.mmw_lang_comment_close.'</div>';
  }
  elseif(isset($_SESSION['char_set']) && $_SESSION['char_set']!=' ' && isset($_SESSION['user'])) {
?>
	<form action="" method="post" name="comment">
<table border="0" width="100%" cellspacing="0" cellpadding="0" class="aBlock">
<tr><td style="padding: 4px;">
 <table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top"><textarea style="height:100px;width:100%;" rows="8" name="c_message" cols="30"></textarea></td>
 <td width="5%" align="center" style="padding-left:3px;">
  <script language=JavaScript>var ico;function smile(ico) {document.comment.c_message.value=document.comment.c_message.value+ico;}</script>
  <table border="0" cellpadding="3" class="smiles">
  <tr>
  <td class="sml1" align="center"><a href="JavaScript: smile(' >( ');"><img style="margin:0;padding:0;border:0;" src="images/smile/angry.gif" title="angry"></a></td>
  <td class="sml1" align="center"><a href="JavaScript: smile(' :D ');"><img style="margin:0;padding:0;border:0;" src="images/smile/biggrin.gif" title="biggrin"></a></td>
  <td class="sml1" align="center"><a href="JavaScript: smile(' B) ');"><img style="margin:0;padding:0;border:0;" src="images/smile/cool.gif" title="cool"></a></td>
  </tr><tr>
  <td class="sml1" align="center"><a href="JavaScript: smile(' ;( ');"><img style="margin:0;padding:0;border:0;" src="images/smile/cry.gif" title="cry"></a></td>
  <td class="sml1" align="center"><a href="JavaScript: smile(' <_< ');"><img style="margin:0;padding:0;border:0;" src="images/smile/dry.gif" title="dry"></a></td>
  <td class="sml1" align="center"><a href="JavaScript: smile(' ^_^ ');"><img style="margin:0;padding:0;border:0;" src="images/smile/happy.gif" title="happy"></a></td>
  </tr><tr>
  <td class="sml1" align="center"><a href="JavaScript: smile(' :( ');"><img style="margin:0;padding:0;border:0;" src="images/smile/sad.gif" title="sad"></a></td>
  <td class="sml1" align="center"><a href="JavaScript: smile(' :) ');"><img style="margin:0;padding:0;border:0;" src="images/smile/smile.gif" title="smile"></a></td>
  <td class="sml1" align="center"><a href="JavaScript: smile(' :o ');"><img style="margin:0;padding:0;border:0;" src="images/smile/surprised.gif" title="surprised"></a></td>
  </tr><tr>
  <td class="sml1" align="center"><a href="JavaScript: smile(' :p ');"><img style="margin:0;padding:0;border:0;" src="images/smile/tongue.gif" title="tongue"></a></td>
  <td class="sml1" align="center"><a href="JavaScript: smile(' %) ');"><img style="margin:0;padding:0;border:0;" src="images/smile/wacko.gif" title="wacko"></a></td>
  <td class="sml1" align="center"><a href="JavaScript: smile(' ;) ');"><img style="margin:0;padding:0;border:0;" src="images/smile/wink.gif" title="wink"></a></td>
  </tr></table>
 </td></tr>
 </table>
</td></tr>
<tr><td style="padding-bottom: 4px;" align="center"><input type="submit" value="<?echo mmw_lang_add_comment;?>"></td></tr>
</table>
</form>
<?
   }
  elseif(isset($_SESSION['pass']) && isset($_SESSION['user'])) {
      echo $die_start . mmw_lang_cant_add_no_char . $die_end;
   }
  else {
      echo '<div align="center">'.mmw_lang_guest_must_be_logged_on.'<br />[ <a href="?op=register">'.mmw_lang_register.'</a> | <a href="?op=login">'.mmw_lang_login.'</a> ]</div>';
   }
?>