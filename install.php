<?PHP include("config.php"); $pg=$_GET['pg'];?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>MyMuWeb <?echo $mmw[version];?> Install by Vaflan</title>
</head>
<body style="background: #FFFFFF;">
<center>

<?
if($_SERVER[REMOTE_ADDR]!='127.0.0.1' && $_SERVER[REMOTE_ADDR]!=$mmw[sqlhost] && $_SERVER[REMOTE_ADDR]!=$_SERVER[SERVER_NAME] && $_SERVER[REMOTE_ADDR]!=$_SERVER[SERVER_ADDR]) {
 die("$sql_die_start Install only For IP: 127.0.0.1 or LocalHost<br><a href=http://127.0.0.1/install.php>Go To Normal Install</a> $sql_die_end");
}

// START PAGE
if($pg=='1' || $pg=='') {
 echo "$sql_die_start <small>Install Page 1</small> <br> <b>Welcome To Installer MMW $mmw[version]!</b> <Br> Next Page You Install Table's and Column's<br> <a href='install.php?pg=2'>Next -></a> $sql_die_end";
 $data = "<?PHP\n// MyMuWeb Installed Date\n\$mmw[installed] = '".time()."';\n?>";
 $install_data = fopen("includes/installed.php", 'w');
 fputs($install_data, $data);
 fclose($install_data);
}



// NEXT PAGE
elseif($pg=='2') {
 echo "$sql_die_start <small>Install Page 2</small> <br> <font color=red><b>In 'config.php' Now MD5 Set: $mmw[md5] !</b></font> <Br> Check your server, can support MD5?!<br> <a href='install.php?pg=3'>Next -></a> $sql_die_end";
}



// NEXT PAGE
elseif($pg=='3') {
 echo "$sql_die_start <small>Install Page 3</small> <br> <b>Table's and Column's Install End!</b> <Br> Next Page You Create Admin <br> <a href='install.php?pg=4'>Next -></a> $sql_die_end";

 echo "<div style='width: 300px; height: 120px; color: #FFFFFF; dis1play:none;'>";

 //// CREAT TABLES
 $filename = 'includes/db_mmw.sql';
 $handle = fopen($filename, 'r');
 $creat_tables = fread($handle, filesize($filename));
 fclose($handle);

 //// PROFILE ADD COLUMNS
 $add_profile[0]= "alter table dbo.memb_info add country int not null default 0";
 $add_profile[1]= "alter table dbo.memb_info add gender nvarchar(100)";
 $add_profile[2]= "alter table dbo.memb_info add age int not null default 0";
 $add_profile[3]= "alter table dbo.memb_info add y nvarchar(100)";
 $add_profile[4]= "alter table dbo.memb_info add msn nvarchar(100)";
 $add_profile[5]= "alter table dbo.memb_info add icq nvarchar(100)";
 $add_profile[6]= "alter table dbo.memb_info add skype nvarchar(100)";
 $add_profile[7]= "alter table dbo.memb_info add avatar nvarchar(100)";
 $add_profile[8]= "alter table dbo.memb_info add hide_profile int not null default 0";
 $add_profile[9]= "alter table dbo.memb_info add ref_acc varchar(100)";
 $add_profile[10]= "alter table dbo.memb_info add ref_check int not null default 0";
 $add_profile[11]= "alter table dbo.memb_info add char_set nvarchar(100)";
 $add_profile[12]= "alter table dbo.memb_info add date_online int not null default 0";
 $add_profile[13]= "alter table dbo.memb_info add block_date int not null default 0";
 $add_profile[14]= "alter table dbo.memb_info add blocked_by nvarchar(100)";
 $add_profile[15]= "alter table dbo.memb_info add unblock_time int not null default 0";
 $add_profile[16]= "alter table dbo.memb_info add block_reason nvarchar(100)";
 $add_profile[17]= "alter table dbo.memb_info add memb__pwd2 nvarchar(10)";
 $add_profile[18]= "alter table dbo.memb_info add ip nvarchar(15)";
 $add_profile[19]= "alter table dbo.memb_info add mmw_status int not null default 0";
 $add_profile[20]= "alter table dbo.warehouse add extMoney nvarchar(100) null";
 $add_profile[21]= "alter table dbo.guild add G_union int not null default 0";
 $add_profile[22]= "alter table dbo.guildmember add G_status int not null default 0";
 $add_profile[23]= "alter table dbo.character add leadership int not null default 0";
 $add_profile[24]= "alter table dbo.character add Reset int not null default 0";

 //// INSERT INTO TABLES
 $add_news = "INSERT INTO MMW_news(news_title,news_autor,news_category,news_date,news_row_1,news_row_2,news_id) VALUES ('MyMuWeb $mmw[version] by Vaflan','Vaflan','NEWS','1240298291','[color=red]This Is MyMuWeb $mmw[version] By Vaflan.[/color][br]If you conduct a news, Your WebSite Works.[br][i]Thanks For the Use of MyMuWeb![/i]','[color=green]Этот MyMuWeb $mmw[version] От Vaflan.[/color][br]Если ты видешь новость, Твой Сайт Работает.[br][i]Спасибо За Использование MyMuWeb![/i]','MyMuWeb')";
 $add_server = "INSERT INTO MMW_servers(name,experience,drops,gsport,ip,display_order,version,type,maxplayer) VALUES ('Server 1','500x','75%','55901','127.0.0.1','1','1.02k','PVP','100')";
 $add_link = "INSERT INTO MMW_links(link_name,link_address,link_description,link_id,link_size,link_date) VALUES ('MuOnline Media Main','media/main.mp3','This Is Test Link','MyMuWeb','1,13 MB','2009-07-12 10:36:00')";

 //// CREAT MAIL SYSTEM (if v.97)
 $creat_table_mail = "CREATE TABLE [dbo].[T_FriendMail] (
	[MemoIndex] [int] NULL ,
	[GUID] [int] NULL ,
	[FriendName] [varchar] (10) NULL ,
	[wDate] [smalldatetime] NULL ,
	[Subject] [varchar] (50) NULL ,
	[bRead] [bit] NULL ,
	[Memo] [varbinary] (1000) NULL ,
	[Photo] [binary] (13) NULL ,
	[Dir] [tinyint] NULL ,
	[Act] [tinyint] NULL 
 ) ON [PRIMARY]

 CREATE TABLE [dbo].[T_FriendMain] (
	[GUID] [int] NULL ,
	[Name] [varchar] (10) NULL ,
	[FriendCount] [tinyint] NULL ,
	[MemoCount] [int] NULL ,
	[MemoTotal] [int] NULL 
 ) ON [PRIMARY]";

 //Install DataBase
 if(@mssql_query("Use $mmw[database]")){echo "use_$mmw[database] - Done! \n";} else {echo "use_$mmw[database] - Error! \n";}
 echo " --- \n";
 if(@mssql_query($creat_tables)){echo "creat_tables - Done! \n";} else {echo "creat_tables - Error! \n";}
 echo " --- \n";
 if(@mssql_query($add_news)){echo "add_news - Done! \n";} else {echo "add_news - Error! \n";}
 if(@mssql_query($add_server)){echo "add_server - Done! \n";} else {echo "add_server - Error! \n";}
 if(@mssql_query($add_link)){echo "add_link - Done! \n";} else {echo "add_link - Error! \n";}
 echo " --- \n";
 if(@mssql_query($creat_table_mail)){echo "creat_table_mail - Done! \n";} else {echo "creat_table_mail - Error! \n";}
 echo " --- \n";
 for($i=0; $i < count($add_profile); ++$i) {
  if(@mssql_query($add_profile[$i])){echo "add_profile_$i - Done! \n";} else {echo "add_profile_$i - Error! \n";}
 }

 echo " --- \n";

 if($mmw['md5']==yes) {
  $use_md5_dll = "exec sp_addextendedproc 'XP_MD5_EncodeKeyVal', 'WZ_MD5_MOD.dll'";
  $md5_encrypt_create = "CREATE FUNCTION [dbo].[fn_md5] (@data VARCHAR(10), @data2 VARCHAR(10))
  RETURNS BINARY(16) AS
  BEGIN
  DECLARE @hash BINARY(16)
  EXEC master.dbo.XP_MD5_EncodeKeyVal @data, @data2, @hash OUT
  RETURN @hash
  END";

  if(@mssql_query($md5_encrypt_create)){echo "md5_encrypt_create - Done! \n";} else {echo "md5_encrypt_create - Error! \n";}
  if(@mssql_query("Use master")){echo "use_master - Done! \n";} else {echo "use_master - Error! \n";}
  if(@mssql_query($use_md5_dll)){echo "use_md5_dll - Done! \n";} else {echo "use_md5_dll - Error! \n";}
  echo " --- \n";
 }

 if(@mssql_query("Use $mmw[database]")){echo "use_$mmw[database] - Done! \n";} else {echo "use_$mmw[database] - Error! \n";}

 echo '</div>';
}





// NEXT PAGE
elseif($pg=='4') {
 $sql = mssql_query("Select memb___id FROM dbo.MEMB_INFO");
 $users = "<option value='register'>Need Register</option>";

 for($i=0; $i < mssql_num_rows($sql); ++$i) {
	$row = mssql_fetch_row($sql);
	$users = $users."<option value='$row[0]'>$row[0]</option>";
 }
 echo "$sql_die_start <small>Install Page 4</small> <br> <b>Select User For Admin!</b> <br> <form name='admin' method='post' action='install.php?pg=5'><select name='user'><option value=''>Please Select</option>$users</select> <input type='submit' value='Okey'></form> $sql_die_end";
}






// NEXT PAGE
elseif($pg=='5') {
 $date = date('m/d/Y H:i:s', time());
 $login = $_POST['user'];
 $password = $_POST['pass'];

 if($login=='' || $login==' ') {
  echo "$sql_die_start <small>Install Page 5</small> <br> <b>No Selected!</b> <br> If you need Admin, go Back <br> <a href='install.php?pg=4'>Back</a> $sql_die_end";
 }
 elseif($login!='register') {
	if($mmw['md5'] == yes && isset($password)) {
		mssql_query("INSERT INTO MEMB_INFO (memb___id,memb__pwd,memb_name,sno__numb,mail_addr,appl_days,modi_days,out__days,true_days,mail_chek,bloc_code,ctl1_code,memb__pwd2,fpas_ques,fpas_answ,country,gender,hide_profile,ref_acc) VALUES ('$login',[dbo].[fn_md5]('$password','$login'),'Admin','1234','admin@mmw.net','$date','$date','2008-12-20','2008-12-20','1','0','0','$password','WhoYouAre','admin','0','male','0','0')");
	}
	elseif($mmw['md5'] == no && isset($password)) {
		mssql_query("INSERT INTO MEMB_INFO (memb___id,memb__pwd,memb_name,sno__numb,mail_addr,appl_days,modi_days,out__days,true_days,mail_chek,bloc_code,ctl1_code,memb__pwd2,fpas_ques,fpas_answ,country,gender,hide_profile,ref_acc) VALUES ('$login','$password','Admin','1234','admin@mmw.net','$date','$date','2008-12-20','2008-12-20','1','0','0','$password','WhoYouAre','admin','0','male','0','0')");
		mssql_query("INSERT INTO VI_CURR_INFO (ends_days,chek_code,used_time,memb___id,memb_name,memb_guid,sno__numb,Bill_Section,Bill_value,Bill_Hour,Surplus_Point,Surplus_Minute,Increase_Days) VALUES ('2005','1',1234,'$login','$login',1,'7','6','3','6','6','2003-11-23 10:36:00','0' )");                    
	}
  mssql_query("UPDATE MEMB_INFO SET [mmw_status]='9' WHERE memb___id='$login'");
  echo "$sql_die_start <small>Install Page 5</small> <br> <b>Admin Created!</b> <br> Now $login is Admin in MyMuWeb <br> <a href='.'>Go To WebSite</a> $sql_die_end";
 }
 else {
  echo "$sql_die_start <small>Install Page 5</small> <br> <form name='admin' method='post' action=''><input name='user' type='text' size='10' maxlength='10' value='Acc'> <input name='pass' type='text' size='10' maxlength='10' value='Pass'> $rowbr <input type='submit' value='New Account'> </form> $sql_die_end";
 }
}
// ERROR
else {
 echo "$sql_die_start Total ErroR! $sql_die_end";
}
?>

</center>
</body>
</html>