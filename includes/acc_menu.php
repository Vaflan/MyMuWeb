<?PHP
// MyMuWeb Menu
// By Vaflan

echo $rowbr;

if(isset($_SESSION['char_set'])) {

 echo "$setchar<br>";

 echo "<a href='?op=user&u=char'><b>".mmw_lang_character_panel."</b></a><br>";

 echo "<a href='?op=user&u=mail' id='upmess'><b>".mmw_lang_mail." [$msg_new_num/$msg_num] $msg_full</b></a><br>";

}

echo "<a href='?op=user&u=acc'><b>".mmw_lang_account_panel."</b></a><br>";

echo "<a href='?op=user&u=wh'><b>".mmw_lang_ware_house."</b></a><br>";

if($mmw[status_rules][$_SESSION[mmw_status]][gm_option] == 1) {

 echo "<a href='?op=user&u=gm'><b>".mmw_lang_gm_options."</b></a><br>";

}

echo $rowbr;
?>