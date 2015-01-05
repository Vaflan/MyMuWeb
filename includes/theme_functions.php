<?php
/////// Start Language ///////
function language() {
 $select_lang = '';
 if($dh=opendir('lang/')) {
  while(($file=readdir($dh)) !== false) {
   $format = substr($file, -3);
   $name = substr($file, 0, -4);
   if($format=='php') {
    if($_SESSION['set_lang'] == $name) {$selected = ' selected';}
    else {$selected = '';}
    $select_lang .= '<option value="'.$name.'"'.$selected.'> '.$name.' </option>';
   }
  }
  closedir($dh);
 }
 echo '<form name="language" method="post" action=""><select name="set_lang" onChange="document.language.submit();" title="'.mmw_lang_language.'">'.$select_lang.'</select></form>';
}
/////// End Language ///////





/////// Start Theme ///////
function theme() {
 global $mmw;
 $select_theme = '';
 if($mmw['themes_auto'] > 0) {
  $dir = 'themes/';
  if($dh=opendir($dir)) {
   while(($file=readdir($dh)) !== false) {
    $type = filetype($dir.$file);
    if($type=='dir' && $file!='.' && $file!='..') {
     include($dir.$file.'/info.php');
     if($_SESSION['theme']==$file) {$selected = ' selected';}
     else {$selected = '';}
     $select_theme .= '<option value="'.$file.'"'.$selected.'> '.$mmw['thm_name'].' </option>';
    }
   }
   include($dir.$mmw['theme'].'/info.php');
   closedir($dh);
  }
 }
 else {
  foreach($mmw['themes'] AS $i=>$row) {
   if($_SESSION['theme']==$row[0]) {$selected = ' selected';}
   else {$selected = '';}
   $select_theme .= '<option value="'.$row[0].'"'.$selected.'> '.$row[1].' </option>';
  }
 }
 echo '<form name="theme" method="post" action=""><select name="set_theme" onChange="document.theme.submit();" title="'.mmw_lang_theme.'">'.$select_theme.'</select></form>';
}
/////// End Theme ///////





/////// Start Menu //////
function menu($style=NULL) {
 include('includes/menu.php');
 if(empty($style)) {$style = "<a href='$1'>$2</a><br/>";}
 foreach($mmw['menu'] AS $i=>$row) {
  $replace = str_replace('%id%', $i, $style);
  $replace = str_replace('%name%', $row[0], $replace);
  $replace = str_replace('%url%', $row[1], $replace);
  $text = '[url='.$row[1].'][name='.$row[0].']';
  echo preg_replace("/\[url\=(.*?)\]\[name\=(.*?)\]/is", $replace, $text)."\n";
 }
}
/////// End Menu ///////





/////// Start Login Form ///////
function login_form() {
 global $mmw;
 if(isset($_SESSION['pass']) && isset($_SESSION['user'])) {
  $account = clean_var($_SESSION['user']);
   /* Select Char */
  $form_setchar_sql = mssql_query("Select name FROM Character WHERE AccountID='".$account."'");
  $form_set_char_num = mssql_num_rows($form_setchar_sql);
  if($form_set_char_num > 0) {
   $setchar = '<form name="set_char" method="post" action=""><select name="setchar" onChange="document.set_char.submit();" title="'.mmw_lang_character_panel.'">';
   for($i=0; $i<$form_set_char_num; ++$i) {
    $form_setchar = mssql_fetch_row($form_setchar_sql);
    if($_SESSION['char_set']==$form_setchar[0]) {$selected = ' selected';}
    else {$selected = '';}
    $setchar .= '<option value="'.$form_setchar[0].'"'.$selected.'> '.$form_setchar[0].' </option>';
   }
   $setchar .= '</select></form>';
  }

   /* Mail Check */
  $char_guid = clean_var($_SESSION['char_guid']);
  $msg_num = @mssql_num_rows(@mssql_query("SELECT bRead FROM T_FriendMail WHERE GUID='".$char_guid."'"));
  $msg_new_num = @mssql_num_rows(@mssql_query("SELECT bRead FROM T_FriendMail WHERE GUID='".$char_guid."' AND bRead='0'"));
  if($mmw['private_message']['num'] <= $msg_num) {$msg_full = '<font color="red">Full!</font>';} else {$msg_full = '';}
  if(empty($msg_num)) {$msg_num = 0; $msg_new_num = 0;}

   /* End Form */
  echo mmw_lang_hello.' <b>'.$account.'</b>!<br>';
  include('includes/acc_menu.php');
  echo '<form action="" method="post" name="logout_account"><input name="logout" type="hidden" value="logout"><input type="submit" title="'.mmw_lang_logout.'" value="'.mmw_lang_logout.'"><br></form>';
  if($msg_new_num > 0) {echo '<script type="text/javascript">function flashit(id,cl){var c=document.getElementById(id); if(c.style.color==\'red\'){c.style.color=cl;} else {c.style.color=\'red\';}} setInterval("flashit(\'upmess\',\'#FFFFFF\')",500)</script>';}
 }
 else {
   /* No Login */
  echo '<form action="" method="post" name="login_account">'
   .mmw_lang_account.'<br><input name="account" type="text" title="'.mmw_lang_account.'" size="15" maxlength="10"><br>'
   .mmw_lang_password.'<br><input name="password" type="password" title="'.mmw_lang_password.'" size="15" maxlength="10"><br>'
   .'<a href="?op=lostpass">'.mmw_lang_lost_pass.'</a> <input name="login" type="hidden" value="login"> <input type="submit" value="'.mmw_lang_login.'" title="'.mmw_lang_login.'"></form>'."\n";
 }
}
/////// End Login Form ///////






/////// Start Online Char ///////
function who_online($return=NULL) {
 global $mmw;
 $char_list = array();
 $timeout = time() - $mmw['timeout_online'];
 $guest_num = mssql_num_rows(mssql_query("SELECT * FROM MMW_online WHERE online_date>'".$timeout."' AND online_char='' OR online_date>'".$timeout."' AND online_char=' '"));
 $online_res = mssql_query("SELECT online_char FROM MMW_online WHERE online_date>'".$timeout."' AND online_char!=''");
 $online_num = mssql_num_rows($online_res);
 if(!empty($online_num)) {
  for($i=0; $i<$online_num; ++$i) {
   $acc_online = mssql_fetch_row($online_res);
   $char_on = mssql_fetch_row(mssql_query("Select name,CtlCode From Character WHERE name='$acc_online[0]'"));
   $char_list[] = "<a href='?op=character&character=$char_on[0]' class='level$char_on[1]'>$char_on[0]</a>";
  }
 }
 else{
  $char_list[] = mmw_lang_there_is_nobody;
 }
 $who_online = mmw_lang_total_on_web.': '.($guest_num+$online_num).'<br>'.mmw_lang_total_guest.': '.$guest_num.'<br>'.mmw_lang_total_accounts.': '.$online_num.'<hr class="hr-online-acc" height="1">'.implode(', ', $char_list);

 if($return > 0) {return $who_online;}
 echo $who_online;
}
$who_online = who_online(true);
/////// END Online Char ///////





/////// Start Last in Forum ///////
function last_in_forum($top=NULL) {
 global $mmw;
 if(empty($top)) {$top = $mmw['last_in_forum'];}
 $style = '$4. <a href="$1" title="$3">$2</a><br/>';
 $result = mssql_query("SELECT TOP ".$top." f_id,f_title,f_text FROM MMW_forum ORDER BY f_date DESC");
 $forum_post = mssql_num_rows($result);
 if(empty($forum_post)) {echo mmw_lang_no_topics_in_forum;}
 for($i=0; $i<$forum_post; ++$i) {
  $row = mssql_fetch_row($result);
  $text = '[url=?forum='.$row[0].'][title='.$row[1].'][alt='.bbcode($row[2]).'][numb='.($i+1).']';
  echo preg_replace("/\[url\=(.*?)\]\[title\=(.*?)\]\[alt\=(.*?)\]\[numb\=(.*?)\]/is", $style, $text)."\n";
 }
}
/////// END Last in Forum ///////






/////// Start Voting ///////
$account = clean_var($_SESSION['user']);
switch($mmw['votes_check']) {
 case 'acc': $vote_by = $account; break;
 default: $vote_by = $_SERVER['REMOTE_ADDR']; break;
}

if(isset($_POST['id_vote']) && isset($_POST['answer'])) {
 $id_vote = clean_var($_POST['id_vote']);
 $answer = clean_var($_POST['answer']);
 if(!empty($vote_by)) {
  $check_your_vote = mssql_num_rows(mssql_query("SELECT answer FROM MMW_voterow WHERE ID_vote='".$id_vote."' and who='".$vote_by."'"));
  if($check_your_vote < 1) {
   mssql_query("INSERT INTO MMW_voterow (id_vote,who,answer) VALUES ('".$id_vote."','".$vote_by."','".$answer."')");
  }
 }
}

$vote_res = mssql_query("SELECT TOP 1 ID,question,answer1,answer2,answer3,answer4,answer5,answer6 FROM MMW_votemain ORDER BY NEWID()");
if(mssql_num_rows($vote_res) > 0) {
 $vote_row = mssql_fetch_row($vote_res);
 if(!empty($vote_by)) {
  $check_your_vote = mssql_num_rows(mssql_query("SELECT who,answer FROM MMW_voterow WHERE ID_vote='".$vote_row[0]."' and who='".$vote_by."'"));
 }
 $voting = '<form name="voting" method="post" action=""><b>'.$vote_row[1].'</b><br>';
 if($check_your_vote<1 && !empty($vote_by)) {
  for($c=1; $c<7; ++$c) {
   if(!empty($vote_row[$c+1])) {$voting .= '<div class="answer"><input id="$c" type="radio" name="answer" value="$c"> <label for="$c">$vote_row[$c+1]</label></div>';}
  }
  $voting .= '<div align="center"><input name="id_vote" type="hidden" value="'.$vote_row[0].'"><input type="submit" value="'.mmw_lang_to_vote.'"></div>';
 }
 else {
  $all_vote_num = mssql_num_rows(mssql_query("SELECT ID_vote FROM MMW_voterow WHERE ID_vote='".$vote_row[0]."'"));
  for($c=1; $c<7; ++$c) {
   if(!empty($vote_row[$c+1])) {
    $votes_row_num = mssql_num_rows(mssql_query("SELECT who,answer FROM MMW_voterow WHERE ID_vote='".$vote_row[0]."' and answer='".$c."'"));
    $img_file = default_img('bar.jpg');
    $size = @getimagesize($img_file);
    $img_width = ($votes_row_num > 0) ? ceil(100 * $votes_row_num / $all_vote_num) : 1;
    $voting .= '<div class="answer">'.$c.'. '.$vote_row[$c+1].' ('.$votes_row_num.')</div><div class="answer"><img src="'.$img_file.'" height="'.$size[1].'" width="'.$img_width.'%"></div>';
   }
  }
  $voting .= '<div align="center">'.mmw_lang_all_answers.': <b>'.$all_vote_num.'</b></div>';
 }
 $voting .= '</form>';
}
else {
 $voting = mmw_lang_no_vote;
}

function voting() {
 global $voting;
 echo $voting;
}
/////// END Voting ///////





/////// Start Statisitcs ///////
function statisitcs($style=NULL) {
 global $mmw,$back_color,$text_color;
 if($mmw['gm_show'] > 0) {$gm_not_show = " WHERE ctlcode<'8'";}

 $total_accounts = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO"));
 $total_characters = mssql_fetch_row(mssql_query("SELECT count(*) FROM Character".$gm_not_show));
 $total_guilds = mssql_fetch_row(mssql_query("SELECT count(*) FROM Guild WHERE G_Name!='".$mmw['gm_guild']."'"));
 $total_banneds = mssql_fetch_row(mssql_query("SELECT count(*) FROM MEMB_INFO WHERE bloc_code='1'"));
 $actives_acc = mssql_fetch_row(mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectTM>='".date('m/d/Y H:i:s', time() - 2592000)."'"));
 $users_connected = mssql_fetch_row(mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectStat='1'"));

 $serv_result = mssql_query("SELECT Name,experience,drops,gsport,ip,version,type,maxplayer from MMW_servers order by display_order asc");
 $serv_num = mssql_num_rows($serv_result);
 $server = array();
 for($i=0; $i<$serv_num; ++$i) {
  $row = mssql_fetch_row($serv_result);
  $players = current(mssql_fetch_row(mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectStat='1' AND ServerName='".$row[0]."'")));
  $id = $row[4].':'.$row[3];

  if(!isset($_SESSION['server_cache'][$id]) || $_SESSION['server_cache']['timeout']+$mmw['server_timeout'] < time()) {
   if($check=@fsockopen($row[4], $row[3], $ERROR_NO, $ERROR_STR, (float)0.5)) {fclose($check); $_SESSION['server_cache'][$id] = true;}
   else {$_SESSION['server_cache'][$id] = false;}
   $_SESSION['server_cache']['timeout'] = time();
  }
  $server[$i] = $row;
  $server[$i][] = $players;

  if($_SESSION['server_cache'][$id] > 0) {$server[$i][] = '<img src="'.default_img('online.gif').'" width="6" height="6"> <span class="online">'.mmw_lang_serv_online.'</span>';}
  else {$server[$i][] = '<img src="'.default_img('offline.gif').'" width="6" height="6"> <span class="offline">'.mmw_lang_serv_offline.'</span>';}
 }

 if($style=='cscw') {
  $cs_row = mssql_fetch_row(mssql_query("SELECT CASTLE_OCCUPY,owner_guild FROM MuCastle_DATA"));
  $cw_row = mssql_fetch_row(mssql_query("SELECT CRYWOLF_OCCUFY FROM MuCrywolf_DATA"));
  if(empty($cs_row[0])) {$cs_row[0] = '<span style="color: red">Not captured</span>';} else {$cs_row[0] = '<span style="color: green">Captured</span>';}
  if(empty($cs_row[1])) {$cs_row[1] = '<a href="?op=castlesiege">No Guild</a>';} else {$cs_row[1] = '<a href="?op=guild&guild='.$cs_row[1].'">'.$cs_row[1].'</a>';}
  if(empty($cw_row[0])) {$cw_row[0] = '<span style="color: red">Captured</span>';} else {$cw_row[0] = '<span style="color: green">Protected</span>';}
  echo 'Castle Siege: '.$cs_row[0]."<br>\n".'Owner Guild: '.$cs_row[1]."<br>\n".'Cry Wolf: '.$cw_row[0]."<br>\n";
  return true;
 }

 if($style=='main') {
  foreach($server AS $key=>$row) {
   $id = $key + 1;
   $bar = substr( ceil($row[8] * 100 / $row[7]) , 0, -1);
   if($bar < 1) {$bar = 0;} elseif($bar > 10) {$bar = 10;}
   if($key < 1) {echo "<style>@import url(images/main/style.css);</style>";}
   echo '<table border="0" cellSpacing="0" cellPadding="0" width="193"><tr><td height="26" style="background:url(\'images/main/'.$bar.'.png\'); cursor: pointer;" onmouseover="this.className=\'effect80\'" onmouseup="this.className=\'effect80\'" onmousedown="this.className=\'effect70\'" onmouseout="this.className=\'\'" onclick="expandit(\'main'.$id.'\')" align="center">';
   echo '<div class="main1" align="center">'.$row[0].' ('.$row[6].')</div></td></tr><tr><td id="main'.$id.'" style="display:none;">';
   echo '<table border="0" cellSpacing="0" cellPadding="0" width="100%"><tr><td class="maintl"></td><td class="maintc"></td><td class="maintr"></td></tr><tr><td class="maincl"></td><td class="mainc">';
   echo '<table border="0" celpadding="0" celspacing="0"><tr><td class="main2">'.mmw_lang_on_server.':</td><td class="main3">'.$row[8].'</td></tr><tr><td class="main2">'.mmw_lang_version.':</td><td class="main3">'.$row[5].'</td></tr><tr><td class="main2">'.mmw_lang_experience.':</td><td class="main3">'.$row[1].'</td></tr><tr><td class="main2">'.mmw_lang_drops.':</td><td class="main3">'.$row[2].'</td></tr></table>';
   echo '</td><td class="maincr"></td></tr><tr><td class="mainbl"></td><td class="mainbc"></td><td class="mainbr"></td></tr></table></td></tr></table>';
  }
  return true;
 }

 if($style=='blink' || $style=='fullblink') {
  if($style=='fullblink') {
   echo '<script type="text/javascript" src="scripts/textfader.js">//script_by_vaflan</script>';
   echo '<script type="text/javascript">function throbFade() { fade(2, Math.floor(throbStep / 2), (throbStep % 2) ? false : true); setTimeout(\'throbFade();\', (throbStep % 2) ? 100 : 4000); if(++throbStep > fader[2].message.length * 2 - 1) throbStep = 0;}';
   echo 'fader[2] = new fadeObj(2, \'statistics\', \''.$back_color.'\', \''.$text_color.'\', 30, 30, false);';
  }
  echo "\n ".'fader[2].message[0] = \''.mmw_lang_total_accounts.': '.$total_accounts[0].'<br>'.mmw_lang_total_characters.': '.$total_characters[0].'<br>'.mmw_lang_total_banneds.': '.$total_banneds[0].'<br>'.mmw_lang_total_actives.': '.$actives_acc[0].'<br>'.mmw_lang_total_guilds.': '.$total_guilds[0].'<br>'.mmw_lang_total_users_online.': '.$users_connected[0].'\';';
  foreach($server AS $key=>$row) {
   $id = $key + 1;
   echo "\n ".'fader[2].message['.$id.'] = \''.$row[0].'<br>'.mmw_lang_version.': '.$row[5].'<br>'.mmw_lang_experience.': '.$row[1].'<br>'.mmw_lang_drops.': '.$row[2].'<br>'.mmw_lang_type.': '.$row[6].'<br>'.$row[9].'\';';
  }
  if($style=='fullblink') {echo 'var throbStep = 0; setTimeout(\'throbFade();\', 1000);//by Vaflan</script><div id="statistics"></div>';}
  return true;
 }

 if($style=='default') {
  foreach($server AS $key=>$row) {
   $id = $key + 1;
   echo "\n ".'<span class="helplink" title="'.mmw_lang_version.': '.$row[5].'<br>'.mmw_lang_experience.': '.$row[1].'<br>'.mmw_lang_drops.': '.$row[2].'<br>'.mmw_lang_type.': '.$row[6].'">'.$row[0].'</span>: '.$row[9].'<br>'.mmw_lang_on_server.' '.$row[8].' '.mmw_lang_char.'<br>';
  }
  echo "\n ".mmw_lang_total_users_online.': '.$users_connected[0].'<br>'.mmw_lang_total_accounts.': '.$total_accounts[0].'<br>'.mmw_lang_total_characters.': '.$total_characters[0].'<br>'.mmw_lang_total_banneds.': '.$total_banneds[0].'<br>'.mmw_lang_total_actives.': '.$actives_acc[0].'<br>'.mmw_lang_total_guilds.': '.$total_guilds[0].'<br>';
  return true;
 }
}
/////// End Statisitcs ///////





/////// Start TOP List ///////
function top_list($what=NULL, $top=NULL) {
 global $mmw;
 if(empty($top)) {$top = '5';}
 if(empty($what)) {$what = 'char';}

 echo '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
 if($mmw['gm_show'] > 0) {$gm_not_show = " WHERE ctlcode<'8'";}

 if($what=='char') {
  $total = mssql_query("SELECT TOP ".$top." Name,cLevel,Reset FROM Character".$gm_not_show." ORDER BY reset desc, clevel desc");

  $top_stat = 2;
  $what_of_sort = mmw_lang_reset;
  $first_row = mssql_fetch_row(mssql_query("SELECT TOP 1 Reset FROM Character".$gm_not_show." ORDER BY reset desc, clevel desc"));
  if($first_row[0] < 1) {$top_stat = 1; $what_of_sort = mmw_lang_level;}

  echo '<tr><td width="14"><b>#</b></td><td><b>'.mmw_lang_character.'</b></td><td align="right" width="10"><b>'.$what_of_sort.'</b></td></td></tr>';
  for($i=0; $i<$top; ++$i) {
   $row = mssql_fetch_row($total);
   echo '<tr><td>'.($i+1).'</td><td><a href="?op=character&character='.$row[0].'">'.$row[0].'</a></td><td align="center">'.$row[$top_stat].'</td></tr>';
  }
 }
 elseif($what=='pk') {
  $total = mssql_query("SELECT TOP ".$top." Name,PKcount FROM Character".$gm_not_show." ORDER BY pkcount desc");
  echo '<tr><td width="14"><b>#</b></td><td><b>'.mmw_lang_character.'</b></td><td align="right" width="10"><b>'.mmw_lang_killed.'</b></td></td></tr>';

  for($i=0; $i<$top; ++$i) {
   $row = mssql_fetch_row($total);
   echo '<tr><td>'.($i+1).'</td><td><a href="?op=character&character='.$row[0].'">'.$row[0].'</a></td><td align="center">'.$row[1].'</td></tr>';
  }
 }
 elseif($what=='guild') {
  $total = mssql_query("SELECT TOP ".$top." G_Name,G_Score,G_Mark FROM Guild WHERE G_Name!='".$mmw['gm_guild']."' ORDER BY G_score desc");
  echo '<tr><td width="14"><b>#</b></td><td><b>'.mmw_lang_guild.'</b></td><td align="right" width="10"><b>'.mmw_lang_score.'</b></td></td></tr>';

  for($i=0; $i<$top; ++$i) {
   $row = mssql_fetch_row($total);
   echo '<tr><td>'.($i+1).'</td><td><a href="?op=guild&guild='.$row[0].'">'.$row[0].'</a></td><td align="center">'.$row[1].'</td></tr>';
  }
 }
 elseif($what=='ref') {
  $total = mssql_query("SELECT TOP ".$top." ref_acc,count(ref_acc) FROM memb_info WHERE ref_acc!=' ' group by ref_acc order by count(ref_acc) desc");
  echo '<tr><td width="14"><b>#</b></td><td><b>'.mmw_lang_account.'</b></td><td align="right" width="10"><b>'.mmw_lang_referral.'</b></td></td></tr>';

  for($i=0; $i<$top; ++$i) {
   $row = mssql_fetch_row($total);
   echo '<tr><td>'.($i+1).'</td><td><a href="?op=profile&profile='.$row[0].'">'.$row[0].'</a></td><td align="center">'.$row[1].'</td></tr>';
  }
 }
 elseif($what=='best') {
  $strong_row = mssql_fetch_row(mssql_query("SELECT TOP 1 Name FROM Character".$gm_not_show." ORDER BY strength DESC, dexterity DESC, vitality DESC, energy DESC, Leadership DESC"));
  if(empty($strong_row[0])) {$strong = '---';}
  else {$strong = '<a href="?op=character&character='.$strong_row[0].'">'.$strong_row[0].'</a>';}
  echo '<tr><td width="100%"><b>'.mmw_lang_very_strong.': '.$strong.'</b>';

  $gm_not_show = str_replace('WHERE', 'AND', $gm_not_show);
  if(empty($mmw['characters_class'])) {$mmw['characters_class'] = 7;}
  for($i=0;$i<$mmw['characters_class'];$i++) {
   $class = $i * 16;
   $strongs_row = mssql_fetch_row(mssql_query("SELECT TOP 1 Name FROM Character WHERE class>='$class' AND class<'".($class+16)."'".$gm_not_show." ORDER BY strength DESC, dexterity DESC, vitality DESC, energy DESC, Leadership DESC"));
   if(empty($strongs_row[0])) {$strong = '---';}
   else {$strong = '<a href="?op=character&character='.$strongs_row[0].'">'.$strongs_row[0].'</a>';}
   echo '<br>&raquo; '.char_class($class,'full').': '.$strong;
  }

  $gamer_row = mssql_fetch_row(mssql_query("SELECT TOP 1 GameIDC FROM AccountCharacter WHERE Id=(SELECT TOP 1 memb___id FROM MEMB_STAT WHERE ConnectStat='1' ORDER BY ConnectTM ASC)"));
  if(empty($gamer_row[0])) {$gamer = '---';}
  else {$gamer = '<a href="?op=character&character='.$gamer_row[0].'">'.$gamer_row[0].'</a>';}

  $guild_row = mssql_fetch_row(mssql_query("SELECT TOP 1 G_Name FROM Guild ORDER BY G_Score DESC"));
  if(empty($guild_row[0])) {$best_guild = '---';}
  else {$best_guild = '<a href="?op=guild&guild='.$guild_row[0].'">'.$guild_row[0].'</a>';}

  echo '<br><b>'.mmw_lang_best_gamer.': '.$gamer.'</b><br><b>'.mmw_lang_best_guild.': '.$best_guild.'</b></td></tr>';
 }
 echo '</table>';
}
/////// End TOP List ///////





/////// Start Pop Under //////
function popunder() {
 echo '<!-- OLD ENGINE POPUNDER THEME OF MMW (need delete from theme "popunder($mmw[popunder],$mmw[popunder_check]);") -->';
}
/////// End Pop Under ///////





/////// Start MP3 Player //////
function mp3_player() {
 global $media_color,$mmw;
 if($mmw['mp3_player'] > 0) {
  include('media/player.php');
 }
}
/////// End MP3 Player ///////





/////// Start MMW End //////
function end_mmw() {
 global $mmw;
 $TimeStart = $_SESSION['TimeStart']; $TimeEnd = gettimeofday();
 $ExecTime = ($TimeEnd['sec']+($TimeEnd['usec']/1000000)) - ($TimeStart['sec']+($TimeStart['usec']/1000000));
 echo 'MyMuWeb '.$mmw['version'].' by Vaflan. Generation Time: '.substr($ExecTime,0,5).'s.';
}
/////// End MMW End ///////
?>