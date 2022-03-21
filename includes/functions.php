<?PHP
/////// Start Default Modules //////
	//Now Module
function curent_module(){
if(isset($_GET['news'])){echo "&gt; <a href='?op=news'>News</a>";} 
elseif(isset($_GET['forum'])){echo "&gt; <a href='?op=forum'>Forum</a>";}
elseif(is_file("modules/$_GET[op].php")){echo "&gt; <a href=?op=$_GET[op]>".ucfirst($_GET['op'])."</a>";}
	
if($_GET['op']=='user'){		  
 if($_GET['op']=='user' and !isset($_GET['u'])){echo " &gt; <a href='?op=user&u=acc'>Acc</a>";}
 else{echo " &gt; <a href=?op=user&u=$_GET[u]>".ucfirst($_GET['u'])."</a>";}
 }
}


	//Statisitcs
function statisitcs(){
require("config.php");

$total_accounts = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO") );
$total_characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character WHERE ctlcode !='32' AND ctlcode !='8'") );
$total_guilds = mssql_fetch_row( mssql_query("SELECT count(*) FROM Guild WHERE G_Name!='$mmw[gm_guild]'") );
$total_banneds = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO WHERE bloc_code = '1'") );
$activ_acc = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_STAT") );
$users_connected = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectStat = '1'") );

echo "\n fader[2].message[0] = \"Total Accounts: $total_accounts[0]<br>Total Characters: $total_characters[0]<br>Total Banneds: $total_banneds[0]<br>Total Actives: $activ_acc[0]<br>Total Guilds: $total_guilds[0]<br>Online Users: $users_connected[0]\";";

$cs_data = mssql_fetch_row( mssql_query("SELECT owner_guild,siege_start_date,siege_end_date FROM MuCastle_DATA") );
$cs_gm = mssql_fetch_row( mssql_query("SELECT G_Master FROM Guild WHERE G_Name='$cs_data[0]'") );
if($cs_data[0]!="" && $cs_data[0]!=" ") {$cs_guild=$cs_data[0]; $cs_guildmaster=$cs_gm[0];}
else {$cs_guild="None"; $cs_guildmaster="None";}
$now_time = time();
$cs_start = time_format($cs_data[1],"d M Y");
$cs_end = time_format($cs_data[2],"d M Y");
if( strtotime($cs_start)+86400 > $now_time ) {$cs_period="Register";} //0 00:00 - 0 23:59
elseif( (strtotime($cs_start)+432000) > $now_time ) {$cs_period="Sing of Lord";} //1 00:00 - 4 23:59
elseif( (strtotime($cs_start)+500400) > $now_time ) {$cs_period="Info";} //5 00:00 - 5 19:00
elseif( (strtotime($cs_start)+586800) > $now_time ) {$cs_period="Ready";} //5 19:00 - 6 19:00
elseif( (strtotime($cs_start)+594000) > $now_time ) {$cs_period="Attack";} //6 19:00 - 6 21:00
else {$cs_period="Truce";}
echo "\n fader[2].message[1] = \"Castle Siege<br>Start: $cs_start<br>End: $cs_end<br>Now Guild: $cs_guild<br>King: $cs_guildmaster<br>Period: $cs_period\";";

$result = mssql_query("SELECT Name,experience,drops,gsport,ip,version,type from MMW_servers order by display_order asc");
for($i=0;$i < mssql_num_rows($result);++$i) {
$rank = $i+2;
$row = mssql_fetch_row($result);
if($check=@fsockopen($row[4],$row[3],$ERROR_NO,$ERROR_STR,(float)0.5)) {fclose($check); $status_done = "<img src=images/online.gif width=6 height=6> <span class='online'>Online";}
else {$status_done = "<img src=images/offline.gif width=6 height=6> <span class='offline'>Offline";} 
echo "\n fader[2].message[$rank] = \"$row[0]<br>Version: $row[5]<br>Experience: $row[1]<br>Drops: $row[2]<br>Type: $row[6]<br>$status_done\";";
    }
}


	//Jump Link
function jump($location) {
header('Location: '.$location.'');
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
                if($mmw['md5'] == 1) {$login_check = mssql_query("SELECT memb___id,admin FROM dbo.MEMB_INFO WHERE memb___id='$account' AND memb__pwd=[dbo].[fn_md5]('$password','$account')");}
                elseif ($mmw['md5'] == 0) {$login_check = mssql_query("SELECT memb___id,admin FROM dbo.MEMB_INFO WHERE memb___id='$account' AND memb__pwd='$password'");}
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
                if($mmw['md5'] == 1)
			{$login_check = mssql_query("SELECT * FROM dbo.MEMB_INFO WHERE memb___id='$login' AND memb__pwd=[dbo].[fn_md5]('$pass','$login')");}
                elseif($mmw['md5'] == 0)
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
}
if($msg_num=="" || $msg_num==" ") {$msg_num = 0; $msg_new_num = 0;}
/////// End Mail Check ///////









/////// Start Referral ///////
if(isset($_GET['ref'])) {$_SESSION['referal'] = stripslashes($_GET['ref']);}
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
$who_online = "There is nobody";
}
/////// END Online Char ///////
?>