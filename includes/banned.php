<?PHP
// Ban IP For MyMuWeb by Vaflan

$banip_file = 'includes/banip.dat';

if(@filesize($banip_file) > 0) {
 $banip_base = file($banip_file);
 $banip_num = count($banip_base);
 for($i=0; $i<$banip_num; $i++) {
  $banip_row = explode("|",$banip_base[$i]);
  $banip_ip = str_replace(' ','',$banip_row[0]);
  if($_SERVER['REMOTE_ADDR'] == $banip_ip) {
   if(!empty($banip_row[1])) {$reason = "<br>Reason: $banip_row[1]";}
   die("$sql_die_start <b><font color=red>Your IP is Blocked!</font></b>$reason $sql_die_end");
   exit();
  }
 }
}
?>