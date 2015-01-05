<?php
// ErroR Info By Vaflan
// Ver. 2.1 + Anti Shell ;P

$error = intval($_GET['go']);
if($error < 1 || $error == NULL) {$error = '999<br>Fucking Sheller!';}
die('<br><center><b><font color=red><u>/!\</u></font> ErroR #'.$error.'<br>MyMuWeb by Vaflan</b></center>');
?>