<?php
// Config For MyMuWeb 0.9 by Vaflan
// Please Safe All ©Vaflan


// MSSQL settings
$mmw['sql']['host'] = '127.0.0.1';				// Ip SQL Server
$mmw['sql']['user'] = 'USER';					// Login SQL
$mmw['sql']['pass'] = 'PASSWORD';				// Pass SQL
$mmw['sql']['database'] = 'MuOnline';				// DataBase SQL


// MyMuWeb Config
$mmw['md5'] = true;						// Server MD5 - TRUE or FALSE
$mmw['language'] = 'English';					// Default Language in Web
$mmw['webtitle'] = 'Name MuOnline Server';			// Web Title
$mmw['servername'] = 'Name MuOnline';				// Server Name
$mmw['serverwebsite'] = 'http://127.0.0.1/';			// WebSite
$mmw['theme'] = 'default';					// Name Of Folder in 'Themes/'
$mmw['themes_auto'] = true;					// TRUE(Get From Folder themes) or FALSE(Get From list from $mmw['themes'])
$mmw['themes'] = array(
 //array('FOLDER','NAME'),
 array('default','Default'),
);
$mmw['home_page'] = 'news.php';					// Name Module from 'Modules/'
$mmw['max_stats'] = 32767;					// Max Stats In Game
$mmw['free_hex'] = 32;						// 20(Season 0~2) or 32(Season 3~4) or Other(WareHouse.Items.Length / 120 * 2)
$mmw['max_ip_acc'] = 0;						// Max Account With one IP Address (if 0 no max)
$mmw['pkmoney'] = 1000000;					// Zen for Pk Clean (Min 1kk)
$mmw['move_zen'] = 1000000;					// Zen for move (Min 1kk)
$mmw['last_in_forum'] = 5;					// Max Topic in Block "Last in Forum"
$mmw['forum_of_new'] = 86400;					// New Topic in Forum with 'sec'
$mmw['forum_topic_hot'] = 15;					// Topic is Hot with num of comments
$mmw['timeout_online'] = 100;					// Time Out for Online on Web in 'sec'
$mmw['comment_time_out'] = 30;					// Comment Time Out
$mmw['min_send_zen'] = 1000000;					// Minimum Zen for Send to Char (Can 0)
$mmw['service_send_zen'] = 1000000;				// Service fee Zen for Send to Char (Can 0)
$mmw['zen_for_acc'] = 50000000;					// Zen For New Account (Can 0)
$mmw['referral']['switch'] = true;				// FALSE(NO Referral) or TRUE(Referral)
$mmw['referral']['zen'] = 1000000000;				// Zen For Referral (Min 1kk)
$mmw['max_char_wh_zen'] = 2000000000;				// Max Zen in Character and WareHouse
$mmw['gm_show'] = true;						// FALSE(Not Show in TOP) or TRUE(Show in TOP)
$mmw['gm_guild'] = 'GM Guild';					// GM guild name (Don't Show)
$mmw['private_message']['num'] = 50;				// Max Private Message
$mmw['private_message']['length'] = 300;			// How many Simbol in Private Message
$mmw['votes_check'] = 'acc';					// ip(Only Different IP) or acc(Only Different Account)
$mmw['mp3_player'] = false;					// FALSE(Not Show) or TRUE(Show) Mp3 Player
$mmw['popunder'] = true;					// FALSE(Not Show) or TRUE(Show) PopUnder in MyMuWeb
$mmw['popunder_check'] = true;					// If TRUE and Account Logined, PopUnder OFF.
$mmw['auto_func']['switch'] = true;				// FALSE(Turn Off) or TRUE(Turn On) Auto Func.
$mmw['auto_func']['dir'] = 'includes/func/';			// Directory for auto functions includes.
$mmw['show_all_error'] = true;					// Turn On or Off all Error's
$mmw['check_admin_panel'] = true;				// Check admin panel, Who where be.
$mmw['look_after_all'] = true;					// To look after all, Who where be.
$mmw['disable_credits'] = true;					// Register and add new acc to MEMB_CREDITS Table
$mmw['info_gm_and_blocked'] = true;				// Show info about GM and Blocked Char

// Switch Character Options
$mmw['reset'] = true;						// TRUE(All Can Reset) FALSE(Options Off).
$mmw['add_point'] = true;					// TRUE(All Can Add Point) FALSE(Options Off).
$mmw['pk_clear'] = true;					// TRUE(All Can PK Clear) FALSE(Options Off).
$mmw['move'] = true;						// TRUE(All Can Move) FALSE(Options Off).
$mmw['change_class'] = true;					// TRUE(All Can Change Class) FALSE(Options Off).

// News
$mmw['max_post_news'] = 5;					// Max News in 1 Page
$mmw['long_news_txt'] = 0;					// Long News Text, if 0 this options off
$mmw['news_row_1'] = '<div><b>English:</b></div>';		// News Row 1
$mmw['news_row_2'] = '<div><b>Russian:</b></div>';		// News Row 2
$mmw['news_row_3'] = '<div><b>Latvian:</b></div>';		// News Row 3

// Chat
$mmw['chat_autoreload'] = 10;					// AutoReload ChatBox sec
$mmw['chat_max_post'] = 40;					// Max Post on ChatBox
$mmw['chat_timeout'] = 10;					// TimeOut Send Message sec

// Statistics
$mmw['gens'] = true;						// Show Gens Sort in Rankings
$mmw['characters_class'] = 7;					// If 7 - in Best List is RF, if 6 RF empty
$mmw['statistics_char'] = '0,1,2,16,17,18,32,33,34,48,50,64,66,80,81,82,96,98';	// List of Character
$mmw['statistics_maps'] = '0,1,2,3,4,6,7,8,10,30,31,33,34,41,42,51,56,57';	// List of Locations (Maps)

// Reset System
$mmw['reset_level']['dw'] = 400;				// Level For Reset DW,SM,GrM
$mmw['reset_level']['dk'] = 400;				// Level For Reset DK,BK,BM
$mmw['reset_level']['fe'] = 400;				// Level For Reset Elf,ME,HE
$mmw['reset_level']['mg'] = 400;				// Level For Reset MG,DM
$mmw['reset_level']['dl'] = 400;				// Level For Reset DL,LE
$mmw['reset_level']['sm'] = 400;				// Level For Reset Sum,Bsum,Dim
$mmw['reset_level']['rf'] = 400;				// Level For Reset RF,FM
$mmw['reset_limit_level'] = 999;				// Max Reset (Limit)
$mmw['reset_limit_price'] = 0;					// Limited Price For Reset or 0
$mmw['reset_money'] = 10000000;					// Zen for Reset (Min 1kk)
$mmw['reset_money_system'] = true;				// TRUE(Zen*Reset) or FALSE(Default)
$mmw['reset_points']['dw'] = 100;				// Reset Points DW,SM,GrM
$mmw['reset_points']['dk'] = 100;				// Reset Points DK,BK,BM
$mmw['reset_points']['fe'] = 100;				// Reset Points Elf,ME,HE
$mmw['reset_points']['mg'] = 100;				// Reset Points MG,DM
$mmw['reset_points']['dl'] = 100;				// Reset Points DL,LE
$mmw['reset_points']['sm'] = 100;				// Reset Points Sum,Bsum,Dim
$mmw['reset_points']['rf'] = 100;				// Reset Points RF,FM
$mmw['reset_points_mode'] = true;				// TRUE(Points = 25) or FALSE(Default)
$mmw['reset_clean_command'] = true;				// TRUE(Command = 25) or FALSE(Default)
$mmw['level_up_mode'] = true;					// TRUE(ResetPoints*Reset) or FALSE(Points+ResetPoints)
$mmw['check_inventory'] = false;				// FALSE(NO Check) or TRUE(Check)
$mmw['clean_inventory'] = false;				// FALSE(NO Clean) or TRUE(Clean)
$mmw['clean_skills'] = false;					// FALSE(NO Clean) or TRUE(Clean)

// Castle Siege and JoinServer
$mmw['server_timeout'] = 60;					// kesh Server TimeOut (sec)
$mmw['castlesiege']['switch'] = true;				// TRUE(Is set in Web) FALSE(no in Web)
$mmw['castlesiege']['data'] = 'includes/MuCastleData.dat';	// Default Server File MuCastleData.dat
$mmw['castlesiege']['ip'] = '127.0.0.1';			// Castle Siege IP
$mmw['castlesiege']['port'] = '55901';				// Castle Siege port
$mmw['joinserver']['ip'] = '127.0.0.1';				// Join Server port for GM Message
$mmw['joinserver']['port'] = '55970';				// Join Server port for GM Message


// Admin Panel SecurityCode & MMW status (5 - GameMaster, 10 - Administrator)
$mmw['security_code'] = '4321';					// Admin Panel Security Code (Max 10 simbyl)
$mmw['status_rules'] = array(			
 // array(name,admin_panel,gm_option,gm_block,gm_msg,hex_wh,comment_delete,forum_add,forum_delete,forum_status,image_delete,chat_delete),
 10 => array('name'=>'Administrator','admin_panel'=>1,'gm_option'=>1,'gm_block'=>1,'gm_msg'=>1,'hex_wh'=>1,'comment_delete'=>1,'forum_add'=>1,'forum_delete'=>1,'forum_status'=>1,'image_delete'=>1,'chat_delete'=>1),
 5 => array('name'=>'Game Master','gm_option'=>1,'gm_block'=>1,'gm_msg'=>1,'hex_wh'=>1,'comment_delete'=>1,'forum_add'=>1,'forum_delete'=>1,'forum_status'=>1,'image_delete'=>1,'chat_delete'=>1),
 0 => array('name'=>'Member'),
);







// Config of site made off. Thank You!
// Engine MyMuWeb. Don't Edit Please!
// All this engine by Vaflan!
$mmw['rand_id'] = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
$mmw['warning']['red'] = '<font color=red><u>&#47;&#33;&#92;</u></font>'; $mmw['warning']['green'] = '<font color=green><u>&#47;&#33;&#92;</u></font>';
$mmw['version'] = chr(hexdec('30')).'.'.chr(hexdec('39')); if($mmw['show_all_error'] < 1) {error_reporting(0);}
$mmw['die']['start'] = "<table border='0' width='350' height='200' align='center' style='background:url(images/sql_die.png);padding:24px;'><tr><td valign='top' align='left'><b>MMW Result:</b><br>";$mmw['die']['end'] = "</td></tr></table>";
if($mmw['sql']['pass']=='Password' || $mmw['sql']['user']=='Login' || $mmw['sql']['database']=='DataBase' || $mmw['sql']['host']=='IP Address') {die($mmw['die']['start'].'Please Check config.php!'.$mmw['die']['end']);}
if(!extension_loaded('mssql')) {die($mmw['die']['start'].'Loading php_mssql.dll Falied!<br>Please Enable php_mssql.dll in your php.ini'.$mmw['die']['end']);}
$mssql_connect = @mssql_connect($mmw['sql']['host'],$mmw['sql']['user'],$mmw['sql']['pass']) or die($mmw['die']['start'].'MSSQL server is offline OR I can\'t Access to it!'.$mmw['die']['end']);
@mssql_select_db($mmw['sql']['database'], $mssql_connect) or die($mmw['die']['start'].'Database don\'t exists OR I can\'t Access to it!'.$mmw['die']['end']);
?>