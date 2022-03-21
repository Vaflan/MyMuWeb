<?PHP
// Config For MyMuWeb 0.4
// by (c)Vaflan
// Please Safe All (c)Vaflan


// MSSQL settings
$mmw[dbhost] = 'IP Address';			// Ip SQL Server
$mmw[dbuser] = 'Login';				// Login SQL
$mmw[dbpass] = 'Password';			// Pass SQL
$mmw[database] = 'DataBase';			// DataBase SQL


// MSSQL CONNECT
$sql_die_start = '<table border="0" width="350" height="150" align="center" style="background:url(images/sql_die.png);" cellpadding="25"><tr><td valign="top"><b>Result:</b><br>';$sql_die_end = '</td></tr></table>';
if($mmw[dbuser]=='Login' || $mmw[database]=='DataBase' || $mmw[dbhost]=='IP Address' || $mmw[dbpass]=='Password') {die("$sql_die_start Please Check config.php! $sql_die_end");}
$connect_mssql = @mssql_connect($mmw[dbhost],$mmw[dbuser],$mmw[dbpass]) or die("$sql_die_start MSSQL server is offline OR I can't Access to it! $sql_die_end");
@mssql_select_db($mmw[database], $connect_mssql) or die("$sql_die_start Database don't exists OR I can't Access to it! $sql_die_end");


// MyMuWeb Config
$mmw[md5] = 'no';					// no(OFF) or yes(ON)
$mmw[webtitle] = 'MuOnline MMORPG Server';		// Web Title
$mmw[servername] = 'MuOnline Server';			// Server Name
$mmw[serverwebsite] = 'http://localhost/';		// WebSite
$mmw[max_stats] = '64000';				// Max Stats In Game
$mmw[pkmoney] = '1000000';				// Zen for Pk Clean (Min 1kk)
$mmw[move_zen] = '1000000';				// Zen for move (Min 1kk)
$mmw[gm] = 'yes';					// no(Not Show in TOP) or yes(Show in TOP)
$mmw[gm_guild] = 'GM Guild';				// GM guild name (Don't Show)
$mmw[max_post_news] = '5';				// Max News in 1 Page
$mmw[long_news_txt] = '160';				// Long News Text
$mmw[last_in_forum] = '5';				// Max Topic in Block "Last in Forum"
$mmw[max_post_forum] = '50';				// Max Topic in Forum
$mmw[comment_time_out] = '60';				// Comment Time Out
$mmw[min_send_zen] = '1000000';				// Minimum Zen for Send to Char (Can 0)
$mmw[service_send_zen] = '1000000';			// Service fee Zen for Send to Char (Can 0)
$mmw[zen_for_acc] = '50000000';				// Zen For New Account (Can 0)
$mmw[switch_ref] = 'yes';				// no(NO Referral) or yes(Referral)
$mmw[zen_for_ref] = '1000000000';			// Zen For Referral (Min 1kk)
$mmw[max_char_wh_zen] = '1000000000';			// Max Zen in Character and WareHouse
$mmw[max_private_message] = '20';			// Max Private Message
$mmw[max_length_private_message] = '300';		// How many Simbol in Private Message
$mmw[joinserver_port] = '55970';			// Join Server port for GM Message
$mmw[mp3_player] = 'yes';				// no(Not Show) or yes(Show) Mp3 Player
$mmw[language] = 'English';				// Default Language in Web
$mmw[votes_check] = 'ip';				// ip(Only Different IP) or acc(Only Different Account)


// Reset System
$mmw[reset_level_dw] = '400';				// Level For Reset DW,SM,GrM
$mmw[reset_level_dk] = '400';				// Level For Reset DK,BK,BM
$mmw[reset_level_elf] = '400';				// Level For Reset Elf,ME,HE
$mmw[reset_level_mg] = '400';				// Level For Reset MG,DM
$mmw[reset_level_dl] = '400';				// Level For Reset DL,LE
$mmw[reset_level_sum] = '400';				// Level For Reset Sum,Bsum,Dim
$mmw[resetslimit] = '500';				// Max Resets (Limit)
$mmw[resetmoney] = '25000000';				// Zen for Reset (Min 1kk)
$mmw[reset_system] = 'no';				// yes(Zen*Reset) or no(Default)
$mmw[resetpoints] = '0';				// Reset Points
$mmw[resetmode] = 'keep';				// reset(Points = 25) or keep(Default)
$mmw[levelupmode] = 'normal';				// extra(ResetPoints*Reset) or normal(Points+ResetPoints)
$mmw[clean_inventory] = 'no';				// no(NO Clean) or yes(Clean)
$mmw[clean_skills] = 'no';				// no(NO Clean) or yes(Clean)


// Castle Siege
$mmw[castle_siege] = 'no';				// yes(Isset in Web) no (no in Web)
$mmw[gs_cs_ip] = '127.0.0.1';				// Castle Siege IP
$mmw[gs_cs_port] = '55901';				// Castle Siege port
$mmw[mix_cs_memb_reset] = 'no';				// yes(Reset Zen - Mix Cs Reset Zen) or no(Default)
$mmw[num_for_mix_cs_reset] = '10';			// How many '/' Max Zen to create % (Can't 0)
$mmw[max_zen_cs_reset] = '100000000';			// Max Zen Need in Castle % For Reset Members Castle Siege (Min 1kk)


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


// Code
$alpha_num = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$mmw[rand_id] = substr(str_shuffle($alpha_num), 0, 8);


// Row Br || Okey || Die(Error)
$rowbr = "<div style='padding: 3px; font-size: 4px;'></div>";

$warning_green = "<font color='green'><u>/!\</u></font>";
$warning_red = "<font color='red'><u>/!\</u></font>";

$okey_start = "<div class='okey' align='center'>$warning_green <b>";
$okey_end = "</b></div>";

$die_start = "<div class='die' align='center'>$warning_red <b>";
$die_end = "</b></div>";
?>