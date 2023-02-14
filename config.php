<?PHP
// Config For MyMuWeb 0.8.3
// Copyright by Vaflan
// Please Safe All (c)Vaflan


// MSSQL settings
$mmw['sqlhost'] = 'IP Address';			// Ip SQL Server
$mmw['sqluser'] = 'Login';			        // Login SQL
$mmw['sqlpass'] = 'Password';			// Pass SQL
$mmw['database'] = 'DataBase';			// DataBase SQL


// Admin Panel
$mmw['admin_panel_ip'] = '192.168.1.10'; // Admin/GM ip-adress from http://myip.ru to enter on admin panel (127.0.0.1 is enable, on local you can enter)
$mmw['admin_panel_ip_2'] = 'no';          // 2 Admin/GM ip-adress to enter on admin panel
$mmw['admin_panel_ip_3'] = 'no';          // 3 Admin/GM ip-adress to enter on admin panel

// MyMuWeb Config
$mmw['md5'] = 'no';					// Server MD5 yes or no
$mmw['tehnicalwork'] = 0;					// WebSite tehnical working(0/1)
$mmw['language'] = 'English';				// Default Language in Web
$mmw['webtitle'] = 'Name MuOnline Server';		// Web Title
$mmw['servername'] = 'Name MuOnline';			// Server Name
$mmw['serverwebsite'] = 'http://localhost/';		// WebSite
$mmw['theme'] = 'default';				// Name Of Folder in 'Themes/'
$mmw['themes_list'] = 'auto';				// auto(Get From Folder themes) or file(Get From File theme.php)
$mmw['home_page'] = 'news';				// Name Module from 'Modules/'
$mmw['max_stats'] = 32767;				// Max Stats In Game
$mmw['free_hex'] = 32;					// 20(Season 0~2) or 32(Season 3~4) or Other(WareHouse.Items.Length / 120 * 2)
$mmw['max_ip_acc'] = 0;					// Max Account With one IP Address (if 0 no max)
$mmw['pkmoney'] = 1000000;				// Zen for Pk Clean (Min 1kk)
$mmw['move_zen'] = 1000000;				// Zen for move (Min 1kk)
$mmw['gm'] = 'yes';					// no(Not Show in TOP) or yes(Show in TOP)
$mmw['gm_guild'] = 'GM Guild';				// GM guild name (Don't Show)
$mmw['last_in_forum'] = 5;				// Max Topic in Block "Last in Forum"
$mmw['forum_of_new'] = 86400;				// New Topic in Forum with 'sec'
$mmw['forum_topic_hot'] = 15;				// Topic is Hot with num of comments
$mmw['time_out_online'] = 100;				// Time Out for Online on Web in 'sec'
$mmw['comment_time_out'] = 30;				// Comment Time Out
$mmw['min_send_zen'] = 1000000;				// Minimum Zen for Send to Char (Can 0)
$mmw['service_send_zen'] = 1000000;			// Service fee Zen for Send to Char (Can 0)
$mmw['zen_for_acc'] = 50000000;				// Zen For New Account (Can 0)
$mmw['switch_ref'] = yes;				// no(NO Referral) or yes(Referral)
$mmw['zen_for_ref'] = 1000000000;			// Zen For Referral (Min 1kk)
$mmw['max_char_wh_zen'] = 2000000000;			// Max Zen in Character and WareHouse
$mmw['max_private_message'] = 50;			// Max Private Message
$mmw['max_length_private_message'] = 300;		// How many Simbol in Private Message
$mmw['votes_check'] = 'acc';				// ip(Only Different IP) or acc(Only Different Account)
$mmw['mp3_player'] = 'no';				// no(Not Show) or yes(Show) Mp3 Player
$mmw['popunder'] = 'no';					// no(Not Show) or yes(Show) PopUnder in MyMuWeb
$mmw['popunder_check'] = 'yes';				// If 'yes' and Account Logined, PoUnder OFF.
$mmw['auto_func'] = 'yes';				// no(Turn Off) or yes(Turn On) Auto Func.
$mmw['auto_func_dir'] = 'includes/func/';			// Directory for auto functions includes.
$mmw['show_all_error'] = 'yes';				// Turn On or Off all Error's
$mmw['check_admin_panel'] = 'yes';			// Check admin panel, Who where be.
$mmw['look_after_all'] = 'yes';				// To look after all, Who where be.
$mmw['disable_credits'] = 'false';				// Register and add new acc to MEMB_CREDITS Table
$mmw['all_characters_class'] = 7;				// If 7 - in Best List is RF, if 6 RF empty
$mmw['info_gm_and_blocked'] = 'true';			// Show info about GM and Blocked Char

// Switch Character Options
$mmw['reset'] = 'yes';					// yes(All Can Reset) no(Options Off).
$mmw['add_point'] = 'yes';				// yes(All Can Add Point) no(Options Off).
$mmw['pk_clear'] = 'yes';					// yes(All Can PK Clear) no(Options Off).
$mmw['move'] = 'yes';					// yes(All Can Move) no(Options Off).
$mmw['change_class'] = 'yes';				// yes(All Can Change Class) no(Options Off).


// News
$mmw['max_post_news'] = 5;				// Max News in 1 Page
$mmw['long_news_txt'] = 220;				// Long News Text, if 0 this options off
$mmw['news_row_1'] = '<div><b>English:</b></div>';	// News Row 1
$mmw['news_row_2'] = '<div><b>Russian:</b></div>';	// News Row 2
$mmw['news_row_3'] = '<div><b>Latvian:</b></div>';	// News Row 3


// Chat
$mmw['chat_autoreload'] = 10;				// AutoReload ChatBox sec
$mmw['chat_max_post'] = 40;				// Max Post on ChatBox
$mmw['chat_timeout'] = 10;				// TimeOut Send Message sec


// Statistics
$mmw['statistics_char'] = '0,1,2,16,17,18,32,33,34,48,50,64,66,80,81,82,96,98';		// List of Character
$mmw['statistics_maps'] = '0,1,2,3,4,6,7,8,10,30,31,33,34,41,42,51,56,57';	// List of Locations (Maps)


// Reset System
$mmw['reset_level_dw'] = 400;				// Level For Reset DW,SM,GrM
$mmw['reset_level_dk'] = 400;				// Level For Reset DK,BK,BM
$mmw['reset_level_elf'] = 400;				// Level For Reset Elf,ME,HE
$mmw['reset_level_mg'] = 400;				// Level For Reset MG,DM
$mmw['reset_level_dl'] = 400;				// Level For Reset DL,LE
$mmw['reset_level_sum'] = 400;				// Level For Reset Sum,Bsum,Dim
$mmw['reset_level_rf'] = 400;			// Level For Reset RF,FM
$mmw['reset_limit_level'] = 999;			// Max Reset (Limit)
$mmw['reset_limit_price'] = 0;				// Limited Price For Reset or 0
$mmw['reset_money'] = 10000000;				// Zen for Reset (Min 1kk)
$mmw['reset_system'] = 'yes';				// yes(Zen*Reset) or no(Default)
$mmw['reset_points_dw'] = 100;				// Reset Points DW,SM,GrM
$mmw['reset_points_dk'] = 100;				// Reset Points DK,BK,BM
$mmw['reset_points_elf'] = 100;				// Reset Points Elf,ME,HE
$mmw['reset_points_mg'] = 100;				// Reset Points MG,DM
$mmw['reset_points_dl'] = 100;				// Reset Points DL,LE
$mmw['reset_points_sum'] = 100;				// Reset Points Sum,Bsum,Dim
$mmw['reset_points_rf'] = 100;				// Reset Points RF,FM
$mmw['reset_mode'] = 'keep';				// reset(Points = 25) or keep(Default)
$mmw['reset_command'] = 'no';				// If reset mode = keep, can keep command on DL
$mmw['level_up_mode'] = 'normal';				// extra(ResetPoints*Reset) or normal(Points+ResetPoints)
$mmw['check_inventory'] = 'no';				// no(NO Check) or yes(Check)
$mmw['clean_inventory'] = 'no';				// no(NO Clean) or yes(Clean)
$mmw['clean_skills'] = 'no';				// no(NO Clean) or yes(Clean)
$mmw['mix_cs_memb_reset'] = 'no';				// yes(Reset Zen - Mix CastleSiege Reset Zen) or no(Default)
$mmw['max_zen_cs_reset'] = 100000000;			// Max Zen Need in CastleSiege Bank % For Reset Members Castle Siege (Min 1kk)
$mmw['num_for_mix_cs_reset'] = 10;			// How many '/' Max Zen to create % (Can't 0)


// Castle Siege and JoinServer
$mmw['server_timeout'] = 60;				// kesh Server TimeOut (sec)
$mmw['castle_siege'] = 'yes';				// yes(Is set in Web) no (no in Web)
$mmw['mu_castle_data'] = 'includes/MuCastleData.dat';	// Default Server File MuCastleData.dat
$mmw['gs_cs_ip'] = '127.0.0.1';				// Castle Siege IP
$mmw['gs_cs_port'] = 55901;				// Castle Siege port
$mmw['joinserver_port'] = 55970;			// Join Server port for GM Message


// Admin Panel SecurityCode & MMW status (5 - GameMaster, 10 - Administrator)
$mmw['admin_securitycode'] = '***';			// Admin Panel Security Code (Max 10 simbyl)
$mmw['status_rules'] = array(				// array(name,admin_panel,gm_option,gm_block,gm_msg,hex_wh,comment_delete,forum_add,forum_delete,forum_status,image_delete,chat_delete),
 10 => array('name'=>'Administrator','admin_panel'=>1,'gm_option'=>1,'gm_block'=>1,'gm_msg'=>1,'hex_wh'=>1,'comment_delete'=>1,'forum_add'=>1,'forum_delete'=>1,'forum_status'=>1,'image_delete'=>1,'chat_delete'=>1),
 5 => array('name'=>'Game Master','gm_option'=>1,'gm_block'=>1,'gm_msg'=>1,'hex_wh'=>1,'comment_delete'=>1,'forum_add'=>1,'forum_delete'=>1,'forum_status'=>1,'image_delete'=>1,'chat_delete'=>1),
 0 => array('name'=>'Member')
);









// Config of site made off. Thank You!
// Engine MyMuWeb. Don't Edit Please!
// All this engine by Vaflan!
$warning_red = '<font color=red><u>&#47;&#33;&#92;</u></font>'; $warning_green = '<font color=green><u>&#47;&#33;&#92;</u></font>';
$mmw['version'] = chr(hexdec('30')).'.'.chr(hexdec('38')); if($mmw['show_all_error'] == 'no') {error_reporting(0);}
$sql_die_start = "<table border='0' width='350' height='200' align='center' style='background:url(images/sql_die.png);padding:24px;'><tr><td valign='top' align='left'><b>MMW Result:</b><br>";$sql_die_end = "</td></tr></table>";
if($mmw['sqlpass']=='Password' || $mmw['sqluser']=='Login' || $mmw['database']=='DataBase' || $mmw['sqlhost']=='IP Address') {die("$sql_die_start Please Check config.php! $sql_die_end");}
if(!extension_loaded('mssql')) {die("$sql_die_start Loading php_mssql.dll Falied!<br>Please Enable php_mssql.dll in your php.ini $sql_die_end");}
$mssql_connect = @mssql_connect($mmw[sqlhost],$mmw[sqluser],$mmw[sqlpass]) or die("$sql_die_start MSSQL server is offline OR I can't Access to it! $sql_die_end");
@mssql_select_db($mmw[database], $mssql_connect) or die("$sql_die_start Database don't exists OR I can't Access to it! $sql_die_end");
if(isset($_POST[set_theme])) {$_SESSION[theme] = preg_replace("/[^a-zA-Z0-9_-]/",'',$_POST[set_theme]);}
if(isset($_GET[theme])) {$_SESSION[theme] = preg_replace("/[^a-zA-Z0-9_-]/",'',$_GET[theme]);}
if(isset($_SESSION[theme])) {$mmw[theme] = $_SESSION[theme];}
@include("themes/$mmw[theme]/info.php");
$alpha_num = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$mmw['rand_id'] = substr(str_shuffle($alpha_num), 0, 8);
$mmw['version'] = '0.8.3';
if($mmw['tehnicalwork'] == 1){die("$sql_die_start Website is temporarily closed for maintenance, try again later. $sql_die_end");}
?>