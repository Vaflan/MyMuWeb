<?PHP include("config.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>MyMuWeb Install by Vaflan</title>
</head>
<body style="background: #FFFFFF;">
<center>

<?
echo $sql_die_start . 'Install SuccessFully End! <Br> Thenks For Use MyMuWeb. <br> By Vaflan' . $sql_die_end;
?>

<textarea style="Width: 300px; Height: 120px;">
<?
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
$add_profile[18]= "alter table dbo.memb_info add memb__pwd2 nvarchar(10)";
$add_profile[19]= "alter table dbo.character add Reset int not null default 0";
$add_profile[20]= "alter table dbo.warehouse add extMoney varchar not null default 0";

$md5_encrypt_create = "CREATE FUNCTION [dbo].[fn_md5] (@data VARCHAR(10), @data2 VARCHAR(10))
RETURNS BINARY(16) AS
BEGIN
DECLARE @hash BINARY(16)
EXEC master.dbo.XP_MD5_EncodeKeyVal @data, @data2, @hash OUT
RETURN @hash
END";

$use_md5_dll = "exec sp_addextendedproc 'XP_MD5_EncodeKeyVal', 'WZ_MD5_MOD.dll'";

$add_news = "INSERT INTO MMW_news(news_title,news_autor,news_category,news_date,news_eng,news_rus,news_id) VALUES ('MyMuWeb by Vaflan','Vaflan','NEWS','1240298291','[color=red]This Is MyMuWeb By Vaflan.[/color][br]If you see This News, Your Web Work.[br][i]Thenks for Use my MyMuWeb![/i]','','MyMuWeb')";
$add_server = "INSERT INTO MMW_servers(name,experience,drops,gsport,ip,display_order,version,type) VALUES ('Server 1','500x','75%','55901','127.0.0.1','1','1.02k','PVP')";

//Install DataBase
if(mssql_query("Use $muweb[database]")){echo "use_muonline - Done! \n";} else {echo "use_muonline - Error! \n";}

for($i=0; $i < 5; ++$i) { if(mssql_query($add_table[$i])){echo "add_table_$i - Done! \n";} else {echo "add_table_$i - Error! \n";} }

if(mssql_query($add_news)){echo "add_news - Done! \n";} else {echo "add_news - Error! \n";}
if(mssql_query($add_server)){echo "add_news - Done! \n";} else {echo "add_news - Error! \n";}

for($i=0; $i < 21; ++$i) { if(mssql_query($add_profile[$i])){echo "add_profile_$i - Done! \n";} else {echo "add_profile_$i - Error! \n";} }

if($muweb['md5']==1) {
 if(mssql_query($md5_encrypt_create)){echo "md5_encrypt_create - Done! \n";} else {echo "md5_encrypt_create - Error! \n";}
 if(mssql_query("Use master")){echo "use_master - Done! \n";} else {echo "use_master - Error! \n";}
 if(mssql_query($use_md5_dll)){echo "use_md5_dll - Done! \n";} else {echo "use_md5_dll - Error! \n";}
}
?>
</textarea>

</center>
</body>
</html>