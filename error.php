<?php
// ErroR Info By Vaflan
// Ver. 2.1 + Anti Shell ;P

$error = isset($_GET['go']) ? intval($_GET['go']) : 0;
if ($error < 1) {
    $error = '999<br>Fucking Sheller!';
}

die('<div style="font-weight:bold;text-align:center"><u style="color:red">/!\</u> ErroR #' . $error . '<br>MyMuWeb by Vaflan</div>');
