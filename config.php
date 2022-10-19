<?php
// Config For MyMuWeb 0.9 by Vaflan
// Please Safe All (c)Vaflan

$mmw = array();
// List of Supported Timezones: https://www.php.net/manual/en/timezones.php
date_default_timezone_set('Europe/Riga');


// MSSQL settings
$mmw['sql']['host'] = '127.0.0.1';                          // Ip SQL Server
$mmw['sql']['user'] = 'USER';                               // Login SQL
$mmw['sql']['pass'] = 'PASSWORD';                           // Pass SQL
$mmw['sql']['database'] = 'MuOnline';                       // DataBase SQL
$mmw['sql']['user'] = 'dev';                                // Login SQL
$mmw['sql']['pass'] = 'dev';                                // Pass SQL


// MyMuWeb Config
$mmw['md5'] = false;                                        // Server MD5 - TRUE or FALSE
$mmw['language'] = 'English';                               // Default Language in Web
$mmw['webtitle'] = 'Name MuOnline Server';                  // Web Title
$mmw['servername'] = 'Name MuOnline';                       // Server Name
$mmw['serverwebsite'] = 'http://' . $_SERVER['HTTP_HOST'];  // WebSite
$mmw['theme'] = 'default';                                  // Name Of Folder in 'Themes/'
$mmw['themes_auto'] = true;                                 // TRUE(Get From Folder themes) or FALSE(Get From list from $mmw['themes'])
$mmw['themes'] = array(
	//array('FOLDER', 'NAME'),
	array('default', 'Default'),
);
$mmw['home_page'] = 'news.php';                             // Name Module from 'Modules/'
$mmw['max_stats'] = 32767;                                  // Max Stats In Game 32767 or 65534
$mmw['item_byte_size'] = 32;                                // 20(Season 0~2) or 32(Season 3~4) or other(WareHouse.Items.Length / 120 * 2)
$mmw['free_hex'] = $mmw['item_byte_size'];                  // DEPRECATED 'free_hex'
$mmw['max_ip_acc'] = 0;                                     // Max Account With one IP Address (if 0 no max)
$mmw['clear_pk_cost'] = 1000000;                            // Zen for Pk Clean (Min 1kk)
$mmw['move_zen'] = 1000000;                                 // Zen for move (Min 1kk)
$mmw['last_in_forum'] = 5;                                  // Max Topic in Block "Last in Forum"
$mmw['forum_of_new'] = '1 days';                            // New Topic in Forum with 'sec'
$mmw['forum_topic_hot'] = 15;                               // Topic is Hot with num of comments
$mmw['timeout_online'] = 100;                               // Time Out for Online on Web in 'sec'
$mmw['comment_time_out'] = 30;                              // Comment Time Out
$mmw['min_send_zen'] = 1000000;                             // Minimum Zen for Send to Char (Can 0)
$mmw['service_send_zen'] = 1000000;                         // Service fee Zen for Send to Char (Can 0)
$mmw['zen_for_acc'] = 50000000;                             // Zen For New Account (Can 0)
$mmw['referral']['switch'] = true;                          // FALSE(NO Referral) or TRUE(Referral)
$mmw['referral']['zen'] = 1000000000;                       // Zen For Referral (Min 1kk)
$mmw['max_char_wh_zen'] = 2000000000;                       // Max Zen in Character and WareHouse
$mmw['gm_show'] = true;                                     // FALSE(Not Show in TOP) or TRUE(Show in TOP)
$mmw['gm_guild'] = 'GM Guild';                              // GM guild name (Don't Show)
$mmw['inner_mail'] = true;                                  // FALSE(Not Show) or TRUE(Show) Inner mail, private messages
$mmw['private_message']['num'] = 50;                        // Max Private Message
$mmw['private_message']['length'] = 300;                    // How many Simbol in Private Message
$mmw['votes_check'] = 'acc';                                // ip(Only Different IP) or acc(Only Different Account)
$mmw['mp3_player'] = true;                                  // FALSE(Not Show) or TRUE(Show) Mp3 Player
$mmw['popunder'] = true;                                    // FALSE(Not Show) or TRUE(Show) PopUnder in MyMuWeb
$mmw['popunder_check'] = true;                              // If TRUE and Account Logined, PopUnder OFF.
$mmw['auto_func']['switch'] = true;                         // FALSE(Turn Off) or TRUE(Turn On) Auto Func.
$mmw['auto_func']['dir'] = 'includes/func/';                // Directory for auto functions includes.
$mmw['show_all_error'] = true;                              // Turn On or Off all Error's
$mmw['check_admin_panel'] = true;                           // Check admin panel, Who where be.
$mmw['look_after_all'] = false;                             // To look after all, Who where be.
$mmw['external_columns'] = [                                // Register with external columns (Some custom server emulator)
	//'AccountLevel' => '0',
];
$mmw['enable_credits'] = false;                             // Register and add new account to MEMB_CREDITS Table
$mmw['info_gm_and_blocked'] = true;                         // Show info about GM and Blocked Char

// Switch Character Options
$mmw['reset'] = true;                                       // TRUE(All Can Reset) FALSE(Options Off).
$mmw['add_points'] = true;                                  // TRUE(All Can Add Point) FALSE(Options Off).
$mmw['clear_pk'] = true;                                    // TRUE(All Can Clear PK) FALSE(Options Off).
$mmw['move'] = true;                                        // TRUE(All Can Move) FALSE(Options Off).
$mmw['move_list'] = array(
    //array('NUMBER_LOCATION','X','Y'),
    array('0', '125', '125'),
    array('1', '232', '126'),
    array('2', '211', '40'),
    array('3', '175', '112'),
    array('4', '209', '71'),
    array('6', '64', '116'),
    array('7', '24', '19'),
    array('8', '187', '58'),
    array('10', '15', '13')
);
$mmw['change_class'] = true;                                // TRUE(All Can Change Class) FALSE(Options Off).
$mmw['change_class_list'] = array(
    //array('NUMBER_CLASS','PRICE'),
    array(0, 1000000000),
    array(1, 10000000000),
    array(2, 100000000000),
    array(16, 1000000000),
    array(17, 10000000000),
    array(18, 100000000000),
    array(32, 1000000000),
    array(33, 10000000000),
    array(34, 100000000000),
    array(48, 3000000000),
    array(49, 300000000000),
    array(64, 3000000000),
    array(65, 300000000000),
    array(80, 1000000000),
    array(81, 10000000000),
    array(82, 10000000000),
);

// News
$mmw['max_post_news'] = 3;                                  // Max News in 1 Page
$mmw['long_news_txt'] = 0;                                  // Long News Text, if 0 this options off
$mmw['news_row_1'] = '<div><b>English:</b></div>';          // News Row 1
$mmw['news_row_2'] = '<div><b>Russian:</b></div>';          // News Row 2
$mmw['news_row_3'] = '<div><b>Latvian:</b></div>';          // News Row 3

// Chat
$mmw['chat_auto_reload'] = 10;                              // AutoReload ChatBox sec
$mmw['chat_max_post'] = 50;                                 // Max Post on ChatBox
$mmw['chat_timeout'] = 3;                                   // TimeOut Send Message sec

// Statistics
$mmw['gens'] = true;                                        // Show Gens Sort in Rankings
$mmw['characters_class'] = 7;                               // Maximal is 11 classes
$mmw['statistics_char'] = '0,1,2,16,17,18,32,33,34,48,50,64,66,80,81,82,96,98'; // List of Character
$mmw['statistics_maps'] = '0,1,2,3,4,6,7,8,10,30,31,33,34,41,42,51,56,57';      // List of Locations (Maps)

// Reset System
$mmw['reset_column'] = 'ResetCount';                        // Column name in database
$mmw['reset_level']['dw'] = 400;                            // Level For Reset DW,SM,GrM
$mmw['reset_level']['dk'] = 400;                            // Level For Reset DK,BK,BM
$mmw['reset_level']['fe'] = 400;                            // Level For Reset Elf,ME,HE
$mmw['reset_level']['mg'] = 400;                            // Level For Reset MG,DM
$mmw['reset_level']['dl'] = 400;                            // Level For Reset DL,LE
$mmw['reset_level']['sm'] = 400;                            // Level For Reset Sum,Bsum,Dim
$mmw['reset_level']['rf'] = 400;                            // Level For Reset RF,FM
$mmw['reset_limit_level'] = 999;                            // Max Reset (Limit)
$mmw['reset_limit_price'] = 0;                              // Limited Price For Reset or 0
$mmw['reset_money'] = 10000000;                             // Zen for Reset (Min 1kk)
$mmw['reset_money_system'] = true;                          // TRUE(Zen*Reset) or FALSE(Default)
$mmw['reset_points']['dw'] = 100;                           // Reset Points DW,SM,GrM
$mmw['reset_points']['dk'] = 100;                           // Reset Points DK,BK,BM
$mmw['reset_points']['fe'] = 100;                           // Reset Points Elf,ME,HE
$mmw['reset_points']['mg'] = 100;                           // Reset Points MG,DM
$mmw['reset_points']['dl'] = 100;                           // Reset Points DL,LE
$mmw['reset_points']['sm'] = 100;                           // Reset Points Sum,Bsum,Dim
$mmw['reset_points']['rf'] = 100;                           // Reset Points RF,FM
$mmw['reset_points_drop'] = true;                           // TRUE(Points = 25) or FALSE(Default)
$mmw['reset_command_drop'] = true;                          // TRUE(Command = 25) or FALSE(Default)
$mmw['reset_points_mode'] = true;                           // TRUE(ResetPoints*Reset) or FALSE(Default Points+ResetPoints)
$mmw['reset_check_inventory'] = false;                      // FALSE(NO Check) or TRUE(Check)
$mmw['reset_clean_inventory'] = false;                      // FALSE(NO Clean) or TRUE(Clean)
$mmw['reset_clean_skills'] = false;                         // FALSE(NO Clean) or TRUE(Clean)
$mmw['cs_memb_reset_discount'] = true;                      // TRUE(Reset Zen - CastleSiege Reset Zen Discount) or FALSE(Default)
$mmw['cs_memb_reset_must_have_zen'] = '100000000';          // Max Zen Need in CastleSiege Bank % For Reset Members Castle Siege
$mmw['cs_memb_reset_max_percent'] = '10';                   // How many % For Max Zen in CastleSiege Bank (Can't 0)

// Castle Siege and JoinServer
$mmw['server_timeout'] = 60;                                // cache Server TimeOut (sec)
$mmw['castle_siege']['switch'] = true;                      // TRUE(Is set in Web) FALSE(Turned off in Web)
$mmw['castle_siege']['data'] = 'includes/MuCastleData.dat'; // Default Server File MuCastleData.dat
$mmw['castle_siege']['ip'] = '127.0.0.1';                   // Castle Siege IP
$mmw['castle_siege']['port'] = '55901';                     // Castle Siege port
$mmw['joinserver']['ip'] = '127.0.0.1';                     // Join Server port for GM Message
$mmw['joinserver']['port'] = '55970';                       // Join Server port for GM Message


// Admin Panel SecurityCode & MMW status (5 - GameMaster, 10 - Administrator)
$mmw['admin_security_code'] = '4321';                       // Admin Panel Security Code (Max 10 simbyl)
$mmw['status_rules'] = array(
	// array(name,admin_panel,gm_option,gm_block,gm_msg,hex_wh,comment_delete,forum_add,forum_delete,forum_status,image_delete,chat_delete),
	10 => array('name' => 'Administrator', 'admin_panel' => 1, 'gm_option' => 1, 'gm_block' => 1, 'gm_msg' => 1, 'hex_wh' => 1, 'comment_delete' => 1, 'forum_add' => 1, 'forum_delete' => 1, 'forum_status' => 1, 'image_delete' => 1, 'chat_delete' => 1),
	5 => array('name' => 'Game Master', 'gm_option' => 1, 'gm_block' => 1, 'gm_msg' => 1, 'hex_wh' => 1, 'comment_delete' => 1, 'forum_add' => 1, 'forum_delete' => 1, 'forum_status' => 1, 'image_delete' => 1, 'chat_delete' => 1),
	0 => array('name' => 'Member'),
);


// Config of site made off. Thank You!
// Engine MyMuWeb. Don't Edit Please!
// All this engine by Vaflan!
if (!$mmw['show_all_error']) {
	error_reporting(0);
}
require_once __DIR__ . '/includes/mmw_sql.php';
@include_once __DIR__ . '/includes/installed.php';
$mmw['rand_id'] = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
$mmw['version'] = chr(hexdec('30')) . '.' . chr(hexdec('39'));
$mmw['warning']['red'] = '<u style="color:red;">&#47;&#33;&#92;</u>&nbsp;';
$mmw['warning']['green'] = '<u style="color:green;">&#47;&#33;&#92;</u>&nbsp;';
$mmw['die']['start'] = '<table style="border:0;padding:24px;width:350px;height:200px;margin:0 auto;background:url(images/sql_die.png);font-family:Arial,Helvetica,sans-serif;"><tr><td style="text-align:left;vertical-align:top;position:relative;"><b>SYSTEM RESPONSE</b><br>';
$mmw['die']['end'] = '</td></tr></table>';
if ($mmw['sql']['pass'] === 'Password' || $mmw['sql']['user'] === 'Login' || $mmw['sql']['database'] === 'DataBase' || $mmw['sql']['host'] === 'IP Address') {
	die($mmw['die']['start'] . 'Please Check config.php!' . $mmw['die']['end']);
}
if (!function_exists('mssql_connect')) {
	die($mmw['die']['start'] . 'Loading php_mssql.dll Falied!<br>Please Enable php_mssql.dll in your php.ini' . $mmw['die']['end']);
}
$mssql_connect = mssql_connect($mmw['sql']['host'], $mmw['sql']['user'], $mmw['sql']['pass']) or die($mmw['die']['start'] . 'MSSQL server is offline OR I can`t Access to it!' . $mmw['die']['end']);
mssql_select_db($mmw['sql']['database'], $mssql_connect) or die($mmw['die']['start'] . 'Database don`t exists OR I can`t Access to it!' . $mmw['die']['end']);
