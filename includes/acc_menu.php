<?PHP
// MyMuWeb Menu
// By Vaflan

    $avatar = mssql_fetch_row ( mssql_query("SELECT avatar FROM MEMB_INFO WHERE memb___id = '$_SESSION[user]'") );
	$credits = mssql_fetch_row ( mssql_query("SELECT credits FROM MEMB_CREDITS WHERE memb___id = '$_SESSION[user]'") );
   if ($avatar[0] == "" || $avatar[0] == " ") {
	$avatar[0] = "images/no_avatar.jpg";
  }

echo $rowbr;
 echo "<center><img src='".$avatar[0]."' border='0' width='110px' height='150px' alt='".mmw_lang_no_avatar."'></center>";
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