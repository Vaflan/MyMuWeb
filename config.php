<?PHP
// Config For MyMuWeb 0.6
// Copyright by Vaflan
// Please Safe All (c)Vaflan


// MSSQL settings
$mmw[sqlhost] = 'IP Address';		// Ip SQL Server
$mmw[sqluser] = 'Login';		// Login SQL
$mmw[sqlpass] = 'Password';		// Pass SQL
$mmw[database] = 'DataBase';		// DataBase SQL
$mmw[md5] = 'no';			// Server MD5 yes or no


// MyMuWeb Config
$mmw[theme] = 'default';				// Name Of Folder in 'Themes/'
$mmw[language] = 'English';				// Default Language in Web
$mmw[webtitle] = 'Name MuOnline Server';		// Web Title
$mmw[servername] = 'Name MuOnline';			// Server Name
$mmw[serverwebsite] = 'http://localhost/';		// WebSite
$mmw[max_stats] = '32767';				// Max Stats In Game
$mmw[free_hex] = '20';					// 20(Season 0~2) or 32(Season 3~4) or Other(WareHouse.Items.Length / 120 * 2)
$mmw[max_ip_acc] = '0';					// Max Account With one IP Address (if 0 no max)
$mmw[pkmoney] = '1000000';				// Zen for Pk Clean (Min 1kk)
$mmw[move_zen] = '1000000';				// Zen for move (Min 1kk)
$mmw[gm] = 'yes';					// no(Not Show in TOP) or yes(Show in TOP)
$mmw[gm_guild] = 'GM Guild';				// GM guild name (Don't Show)
$mmw[last_in_forum] = '5';				// Max Topic in Block "Last in Forum"
$mmw[max_post_forum] = '100';				// Max Topic in Forum
$mmw[comment_time_out] = '15';				// Comment Time Out
$mmw[min_send_zen] = '1000000';				// Minimum Zen for Send to Char (Can 0)
$mmw[service_send_zen] = '1000000';			// Service fee Zen for Send to Char (Can 0)
$mmw[zen_for_acc] = '50000000';				// Zen For New Account (Can 0)
$mmw[switch_ref] = 'yes';				// no(NO Referral) or yes(Referral)
$mmw[zen_for_ref] = '1000000000';			// Zen For Referral (Min 1kk)
$mmw[max_char_wh_zen] = '2000000000';			// Max Zen in Character and WareHouse
$mmw[max_private_message] = '50';			// Max Private Message
$mmw[max_length_private_message] = '300';		// How many Simbol in Private Message
$mmw[votes_check] = 'acc';				// ip(Only Different IP) or acc(Only Different Account)
$mmw[mp3_player] = 'yes';				// no(Not Show) or yes(Show) Mp3 Player
$mmw[popunder] = 'yes';					// no(Not Show) or yes(Show) PopUnder in MyMuWeb
$mmw[popunder_check] = 'yes';				// If 'yes' and Account Logined, PoUnder OFF.
$mmw[show_all_error] = 'yes';				// Turn On or Off all Error's
$mmw[look_after_all] = 'no';				// To look after all, Who where be.


// Switch Character Options
$mmw[reset] = 'yes';					// yes(All Can Reset) no(Options Off).
$mmw[add_point] = 'yes';				// yes(All Can Add Point) no(Options Off).
$mmw[pk_clear] = 'yes';					// yes(All Can PK Clear) no(Options Off).
$mmw[move] = 'yes';					// yes(All Can Move) no(Options Off).
$mmw[change_class] = 'yes';				// yes(All Can Change Class) no(Options Off).


// News
$mmw[max_post_news] = '5';				// Max News in 1 Page
$mmw[long_news_txt] = '220';				// Long News Text, if 0 this options off
$mmw[news_row_1] = '<div><b>English:</b></div>';	// News Row 1
$mmw[news_row_2] = '<div><b>Russian:</b></div>';	// News Row 2
$mmw[news_row_3] = '<div><b>Latvian:</b></div>';	// News Row 3
$mmw[news_row_end] = '';				// This is All Row End


// Reset System
$mmw[reset_level_dw] = '400';				// Level For Reset DW,SM,GrM
$mmw[reset_level_dk] = '400';				// Level For Reset DK,BK,BM
$mmw[reset_level_elf] = '400';				// Level For Reset Elf,ME,HE
$mmw[reset_level_mg] = '400';				// Level For Reset MG,DM
$mmw[reset_level_dl] = '400';				// Level For Reset DL,LE
$mmw[reset_level_sum] = '400';				// Level For Reset Sum,Bsum,Dim
$mmw[reset_limit_level] = '999';			// Max Reset (Limit)
$mmw[reset_limit_price] = '0';				// Limited Price For Reset or 0
$mmw[reset_money] = '10000000';				// Zen for Reset (Min 1kk)
$mmw[reset_system] = 'yes';				// yes(Zen*Reset) or no(Default)
$mmw[resetpoints] = '0';				// Reset Points
$mmw[resetmode] = 'keep';				// reset(Points = 25) or keep(Default)
$mmw[levelupmode] = 'normal';				// extra(ResetPoints*Reset) or normal(Points+ResetPoints)
$mmw[check_inventory] = 'no';				// no(NO Check) or yes(Check)
$mmw[clean_inventory] = 'no';				// no(NO Clean) or yes(Clean)
$mmw[clean_skills] = 'no';				// no(NO Clean) or yes(Clean)
$mmw[mix_cs_memb_reset] = 'no';				// yes(Reset Zen - Mix CastleSiege Reset Zen) or no(Default)
$mmw[max_zen_cs_reset] = '100000000';			// Max Zen Need in CastleSiege Bank % For Reset Members Castle Siege (Min 1kk)
$mmw[num_for_mix_cs_reset] = '10';			// How many '/' Max Zen to create % (Can't 0)


// Castle Siege and JoinServer
$mmw[castle_siege] = 'yes';				// yes(Is set in Web) no (no in Web)
$mmw[gs_cs_ip] = '127.0.0.1';				// Castle Siege IP
$mmw[gs_cs_port] = '55901';				// Castle Siege port
$mmw[joinserver_port] = '55970';			// Join Server port for GM Message


// Admin Panel & Level (3 - GM, 6 - Mini Admin, 9 - Admin)
$mmw[admin_securitycode] = '4321';			// Admin Panel Security Code (Max 10 simbyl)
$mmw[min_level_to_ap] = '3';				// Min Level To Enter Admin Panel
$mmw[gm_option_open] = '3';				// Add GM Option Menu
$mmw[gm_msg_send] = '3';				// Send GM Message to Server
$mmw[hex_wh_can] = '6';					// Can edit Ware House HEX
$mmw[comment_can_delete] = '3';				// Comment Can Delete with this level
$mmw[forum_can_delete] = '3';				// Topic Can Delete with this level
$mmw[forum_can_status] = '3';				// Topic Can Close with this level
$mmw[image_can_delete] = '3';				// Image Can Delete with this level






// Config of site made off. Thank You!
// Engine MyMuWeb. Don't Edit Please!
// All this engine by Vaflan!
$mmw[version] = '0.6';
if($mmw[show_all_error] == 'no') {error_reporting(0);}
$sql_die_start = '<table border="0" width="350" height="200" align="center" style="background:url(images/sql_die.png);" cellpadding="25"><tr><td valign="top"><b>MMW Result:</b><br>';$sql_die_end = '</td></tr></table>';
if($mmw[sqlpass]=='Password' || $mmw[sqluser]=='Login' || $mmw[database]=='DataBase' || $mmw[sqlhost]=='IP Address') {die("$sql_die_start Please Check config.php! $sql_die_end");}
$mssql_connect = @mssql_connect($mmw[sqlhost],$mmw[sqluser],$mmw[sqlpass]) or die("$sql_die_start MSSQL server is offline OR I can't Access to it! $sql_die_end");
@mssql_select_db($mmw[database], $mssql_connect) or die("$sql_die_start Database don't exists OR I can't Access to it! $sql_die_end");
if(isset($_GET[theme])) {$_SESSION[theme] = $_GET[theme];}
if(isset($_POST[set_theme])) {$_SESSION[theme] = $_POST[set_theme];}
if(isset($_SESSION[theme])) {$mmw[theme] = $_SESSION[theme];}
if(is_file("themes/$mmw[theme]/info.php")) {
$mmw[theme_dir] = "themes/$mmw[theme]";
$mmw[theme_img] = "themes/$mmw[theme]/img";
include("$mmw[theme_dir]/info.php");}
elseif($mmw[theme_switch] == NULL) {unset($_SESSION[theme]);
die("$sql_die_start ErroR Theme!<br>Cant find <b>$mmw[theme]/info.php</b> in <b>themes/</b>! $sql_die_end");}
$alpha_num = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$mmw[rand_id] = substr(str_shuffle($alpha_num), 0, 8);
?>