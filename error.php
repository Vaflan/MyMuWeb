<?PHP
// ErroR Info By Vaflan
// Ver. 2.0
// + Anti Shell ;P

$error = stripslashes($_GET['go']);
if(@preg_match('/[^a-zA-Z0-9]/',$error) || $error == NULL) {$error = '999 !<br>Fucking Sheller';}
else {$error = $error;}
Die("<br><center><b><font color=red><u>/!\</u></font> ErroR #$error !<br>by Vaflan</b></center>");
?>