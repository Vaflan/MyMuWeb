<?PHP include("config.php"); $pg=$_GET['pg'];?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>MyMuWeb 0.3 Install by Vaflan</title>
</head>
<body style="background: #FFFFFF;">
<center>

<?
// START PAGE
if($pg=='1' || $pg=='') {
echo "$sql_die_start <small>Install Page 1</small> <br> <b>Welcome To Installer MMW!</b> <Br> Next Page You Install Table's and Column's<br> <a href='install.php?pg=2'>Next -></a> $sql_die_end";
}
// NEXT PAGE
elseif($pg=='2') {
echo "$sql_die_start <small>Install Page 2</small> <br> <b>Table's and Column's Install End!</b> <Br> Next Page You Create Admin <br> <a href='install.php?pg=3'>Next -></a> $sql_die_end";

echo '<br><textarea style="Width: 300px; Height: 120px;">';

//// TABLES

$add_table[0] = "if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_comment]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_comment]

CREATE TABLE [dbo].[MMW_comment] (
	[c_id] [nvarchar] (50) NULL ,
	[c_id_blog] [nvarchar] (50) NULL ,
	[c_id_code] [nvarchar] (50) NULL ,
	[c_char] [nvarchar] (50) NULL ,
	[c_text] [text] NULL ,
	[c_date] [nvarchar] (50) NULL
) ON [PRIMARY]";


$add_table[1] = "if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_forum]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_forum]


CREATE TABLE [dbo].[MMW_forum] (
	[f_id] [nvarchar] (50) NULL ,
	[f_char] [nvarchar] (50) NULL ,
	[f_title] [nvarchar] (50) NULL ,
	[f_text] [text] NULL ,
	[f_date] [nvarchar] (50) NULL ,
	[f_lostchar] [nvarchar] (50) NULL ,
) ON [PRIMARY]";



$add_table[2] = "if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_links]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_links]

CREATE TABLE [dbo].[MMW_links] (
	[link_name] [varchar] (100) NULL ,
	[link_address] [text] NULL ,
	[link_description] [text] NULL ,
	[link_id] [varchar] (100) NULL ,
	[link_date] [varchar] (100) NULL 
) ON [PRIMARY]";



$add_table[3] = "if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_news]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_news]

CREATE TABLE [dbo].[MMW_news] (
	[news_id] [nvarchar] (100) NULL ,
	[news_title] [nvarchar] (100) NULL ,
	[news_category] [nvarchar] (100) NULL ,
	[news_eng] [text] NULL ,
	[news_rus] [text] NULL ,
	[news_autor] [nvarchar] (100) NULL ,
	[news_date] [nvarchar] (100) NULL 
) ON [PRIMARY]";



$add_table[4] = "if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_servers]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_servers]


CREATE TABLE [dbo].[MMW_servers] (
	[name] [nvarchar] (100) NULL ,
	[experience] [nvarchar] (100) NULL ,
	[drops] [nvarchar] (100) NULL ,
	[gsport] [nvarchar] (100) NULL ,
	[ip] [nvarchar] (100) NULL ,
	[display_order] [nvarchar] (100) NULL ,
	[version] [nvarchar] (100) NULL ,
	[type] [nvarchar] (50) NULL 
) ON [PRIMARY]";


//// PROFILE ADD

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
$add_profile[17]= "alter table dbo.memb_info add admin int not null default 0";
$add_profile[18]= "alter table dbo.warehouse add extMoney nvarchar(100)";
$add_profile[19]= "alter table dbo.character add Reset int not null default 0";
$add_profile[20]= "alter table dbo.memb_info add memb__pwd2 nvarchar(10)";

$md5_encrypt_create = "CREATE FUNCTION [dbo].[fn_md5] (@data VARCHAR(10), @data2 VARCHAR(10))
RETURNS BINARY(16) AS
BEGIN
DECLARE @hash BINARY(16)
EXEC master.dbo.XP_MD5_EncodeKeyVal @data, @data2, @hash OUT
RETURN @hash
END";

$use_md5_dll = "exec sp_addextendedproc 'XP_MD5_EncodeKeyVal', 'WZ_MD5_MOD.dll'";

$add_news = "INSERT INTO MMW_news(news_title,news_autor,news_category,news_date,news_eng,news_rus,news_id) VALUES ('MyMuWeb by Vaflan','Vaflan','NEWS','1240298291','[color=red]This Is MyMuWeb By Vaflan.[/color][br]If you see This News, Your Web Work.[br][i]Thank for Use MyMuWeb![/i]','','MyMuWeb')";
$add_server = "INSERT INTO MMW_servers(name,experience,drops,gsport,ip,display_order,version,type) VALUES ('Server 1','500x','75%','55901','127.0.0.1','1','1.02k','PVP')";

//Install DataBase
if(mssql_query("Use $mmw[database]")){echo "use_$mmw[database] - Done! \n";} else {echo "use_$mmw[database] - Error! \n";}

for($i=0; $i < 5; ++$i) { if(mssql_query($add_table[$i])){echo "add_table_$i - Done! \n";} else {echo "add_table_$i - Error! \n";} }

if(mssql_query($add_news)){echo "add_news - Done! \n";} else {echo "add_news - Error! \n";}
if(mssql_query($add_server)){echo "add_news - Done! \n";} else {echo "add_news - Error! \n";}

for($i=0; $i < 21; ++$i) { if(mssql_query($add_profile[$i])){echo "add_profile_$i - Done! \n";} else {echo "add_profile_$i - Error! \n";} }

echo " --- \n";

if($mmw['md5']==yes) {
 if(mssql_query($md5_encrypt_create)){echo "md5_encrypt_create - Done! \n";} else {echo "md5_encrypt_create - Error! \n";}
 if(mssql_query("Use master")){echo "use_master - Done! \n";} else {echo "use_master - Error! \n";}
 if(mssql_query($use_md5_dll)){echo "use_md5_dll - Done! \n";} else {echo "use_md5_dll - Error! \n";}
}

echo " --- \n";

if(mssql_query("Use $mmw[database]")){echo "use_$mmw[database] - Done! \n";} else {echo "use_$mmw[database] - Error! \n";}

echo '</textarea>';
}
// NEXT PAGE
elseif($pg=='3') {

$sql = mssql_query("Select memb___id FROM dbo.MEMB_INFO");
$users = "<option value='register'>Need Register</option>";

for($i=0; $i < mssql_num_rows($sql); ++$i) {
	$row = mssql_fetch_row($sql);
	$users = $users."<option value='$row[0]'>$row[0]</option>";
}

echo "$sql_die_start <small>Install Page 3</small> <br> <b>Select User For Admin!</b> <br> <form name='admin' method='post' action='install.php?pg=4'><select name='user' onChange='document.admin.submit();'><option value=''>Please Select</option>$users</select></form> $sql_die_end";
}
// NEXT PAGE
elseif($pg=='4') {

$date = date('m/d/Y H:i:s', time());
$login = $_POST['user'];
$password = $_POST['pass'];

if($login=='' || $login==' ') {
echo "$sql_die_start <small>Install Page 4</small> <br> <b>No Selected!</b> <br> If you need Admin, go Back <br> <a href='install.php?pg=3'>Back</a> $sql_die_end";
}
elseif($login!='register') {
	if($mmw['md5'] == yes && isset($password)) {
		mssql_query("INSERT INTO MEMB_INFO (memb___id,memb__pwd,memb_name,sno__numb,mail_addr,appl_days,modi_days,out__days,true_days,mail_chek,bloc_code,ctl1_code,memb__pwd2,fpas_ques,fpas_answ,country,gender,hide_profile,ref_acc) VALUES ('$login',[dbo].[fn_md5]('$password','$login'),'Administrator','1234','admin@mmw.net','$date','$date','2008-12-20','2008-12-20','1','0','0','$password','Who_You_Are','admin_mmw','','male','0','')");
	}
	elseif($mmw['md5'] == no && isset($password)) {
		mssql_query("INSERT INTO MEMB_INFO (memb___id,memb__pwd,memb_name,sno__numb,mail_addr,appl_days,modi_days,out__days,true_days,mail_chek,bloc_code,ctl1_code,memb__pwd2,fpas_ques,fpas_answ,country,gender,hide_profile,ref_acc) VALUES ('$login','$password','Administrator','1234','admin@mmw.net','$date','$date','2008-12-20','2008-12-20','1','0','0','$password','Who_You_Are','admin_mmw','','male','0','')");
		mssql_query("INSERT INTO VI_CURR_INFO (ends_days,chek_code,used_time,memb___id,memb_name,memb_guid,sno__numb,Bill_Section,Bill_value,Bill_Hour,Surplus_Point,Surplus_Minute,Increase_Days) VALUES ('2005','1',1234,'$login','$login',1,'7','6','3','6','6','2003-11-23 10:36:00','0' )");                    
	}
mssql_query("UPDATE MEMB_INFO SET [admin]='9' WHERE memb___id='$login'");
echo "$sql_die_start <small>Install Page 4</small> <br> <b>Admin Created!</b> <br> Now $login is Admin in Web <br> <a href='.'>Go To Web</a> $sql_die_end";
}
else {
echo "$sql_die_start <small>Install Page 4</small> <br> <form name='admin' method='post' action='install.php?pg=4'><input name='user' type='text' size='10' maxlength='10' value='Acc'> <input name='pass' type='text' size='10' maxlength='10' value='Pass'> $rowbr <input type='submit' value='New Account'> </form> $sql_die_end";
}

}
// ERROR
else {
echo "ERROR!";
}
?>


</center>
</body>
</html>