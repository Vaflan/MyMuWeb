<?
if(isset($_POST["edit_account_done"])){edit_account($_POST['account'],$_POST['new_pwd'],$_POST['mode'],$_POST['email'],$_POST['squestion'],$_POST['sanswer'],$_POST['unblock_time'],$_POST['block_date'],$_POST['block_reason'],$_POST['admin_level']);}
if(isset($_POST["edit_acc_wh_done"])){edit_acc_wh($_POST['account'],$_POST['wh'],$_POST['extrawh']);}
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>

<?
if(isset($_POST["account_search_edit"]) || isset($_GET["acc"])) {

if(isset($_GET['acc'])){$_POST['account_search_edit'] = $_GET['acc'];}
$account_edit = stripslashes($_POST['account_search_edit']);
if($mmw[md5]==yes){$get_account = mssql_query("Select memb___id,memb__pwd2,sno__numb,bloc_code,country,gender,mail_addr,fpas_ques,fpas_answ,memb_name,block_date,unblock_time,blocked_by,block_reason,mmw_status from MEMB_INFO where memb___id='$account_edit'");}
elseif($mmw[md5]==no){$get_account = mssql_query("Select memb___id,memb__pwd,sno__numb,bloc_code,country,gender,mail_addr,fpas_ques,fpas_answ,memb_name,block_date,unblock_time,blocked_by,block_reason,mmw_status from MEMB_INFO where memb___id='$account_edit'");}
$get_account_done = mssql_fetch_row($get_account);

if($get_account_done[3] == 1){$mode = "<option value='1'>Blocked</option><option value='0'>Normal</option>";}
elseif($get_account_done[3] == 0){$mode = "<option value='0'>Normal</option><option value='1'>Blocked</option>";}
if($get_account_done[1] == NULL){$get_account_done[1] = "<div style='background: #FF0000; color: #FFFFFF; font-size: 1pt;'>Error #111</font></div>";}
if($get_account_done[4] == NULL){$get_account_done[4] = "<div style='background: #FF0000; color: #FFFFFF; font-size: 1pt;'>Error #112</font></div>";}
if($get_account_done[5] == NULL){$get_account_done[5] = "<div style='background: #FF0000; color: #FFFFFF; font-size: 1pt;'>Error #113</font></div>";}
if($get_account_done[9] == NULL){$get_account_done[9] = "<div style='background: #FF0000; color: #FFFFFF; font-size: 1pt;'>Error #114</font></div>";}

$get_wh = mssql_query("SELECT AccountID,Money,extMoney FROM warehouse WHERE accountid='$account_edit'");
$get_acc_wh = mssql_fetch_row($get_wh);
$get_acc_wh_num = mssql_num_rows($get_wh);
if($get_acc_wh[1]==""){$get_acc_wh[1] = 0;}
if($get_acc_wh[2]==""){$get_acc_wh[2] = 0;}

if($get_account_done[14] >= 0){$admin_level[$get_account_done[14]] = "selected";} else{$admin_level[0] = "selected";}

$online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$account_edit'");
$oc_row = mssql_fetch_row($online_check);

$get_chr = mssql_query("SELECT GameID1,GameID2,GameID3,GameID4,GameID5,GameIDC FROM AccountCharacter WHERE Id='$account_edit'");
$get_acc_chr = mssql_fetch_row($get_chr);
$online_stats = "<font color='#00FF00'>Online</font>";
$offline_stats = "<font color='#FF0000'>Offline</font>";
if($get_acc_chr[0]==$get_acc_chr[5] && $oc_row[0]=='1'){$get_acc_chr_online[0] = $online_stats;}else{$get_acc_chr_online[0] = $offline_stats;}
if($get_acc_chr[1]==$get_acc_chr[5] && $oc_row[0]=='1'){$get_acc_chr_online[1] = $online_stats;}else{$get_acc_chr_online[1] = $offline_stats;}
if($get_acc_chr[2]==$get_acc_chr[5] && $oc_row[0]=='1'){$get_acc_chr_online[2] = $online_stats;}else{$get_acc_chr_online[2] = $offline_stats;}
if($get_acc_chr[3]==$get_acc_chr[5] && $oc_row[0]=='1'){$get_acc_chr_online[3] = $online_stats;}else{$get_acc_chr_online[3] = $offline_stats;}
if($get_acc_chr[4]==$get_acc_chr[5] && $oc_row[0]=='1'){$get_acc_chr_online[4] = $online_stats;}else{$get_acc_chr_online[4] = $offline_stats;}

if($get_acc_chr[0]=="" || $get_acc_chr[0]==" "){$get_acc_chr[0] = "No Char";}elseif($_SESSION[a_admin_level] > 3){$get_acc_chr[0] = "<a href='?op=char&chr=$get_acc_chr[0]'>$get_acc_chr[0]</a>";}else{$get_acc_chr[0] = "<u>$get_acc_chr[0]</u>";}
if($get_acc_chr[1]=="" || $get_acc_chr[1]==" "){$get_acc_chr[1] = "No Char";}elseif($_SESSION[a_admin_level] > 3){$get_acc_chr[1] = "<a href='?op=char&chr=$get_acc_chr[1]'>$get_acc_chr[1]</a>";}else{$get_acc_chr[1] = "<u>$get_acc_chr[1]</u>";}
if($get_acc_chr[2]=="" || $get_acc_chr[2]==" "){$get_acc_chr[2] = "No Char";}elseif($_SESSION[a_admin_level] > 3){$get_acc_chr[2] = "<a href='?op=char&chr=$get_acc_chr[2]'>$get_acc_chr[2]</a>";}else{$get_acc_chr[2] = "<u>$get_acc_chr[2]</u>";}
if($get_acc_chr[3]=="" || $get_acc_chr[3]==" "){$get_acc_chr[3] = "No Char";}elseif($_SESSION[a_admin_level] > 3){$get_acc_chr[3] = "<a href='?op=char&chr=$get_acc_chr[3]'>$get_acc_chr[3]</a>";}else{$get_acc_chr[3] = "<u>$get_acc_chr[3]</u>";}
if($get_acc_chr[4]=="" || $get_acc_chr[4]==" "){$get_acc_chr[4] = "No Char";}elseif($_SESSION[a_admin_level] > 3){$get_acc_chr[4] = "<a href='?op=char&chr=$get_acc_chr[4]'>$get_acc_chr[4]</a>";}else{$get_acc_chr[4] = "<u>$get_acc_chr[4]</u>";}
?>
		<legend>Account <?echo $get_account_done[0];?></legend>
			<form action="" method="post" name="edit_account_form" id="edit_account_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			  <tr>
			    <td width="42%" align="right">Account</td>
			    <td><?echo $get_account_done[0];?></td>
			  </tr>
			  <tr>
			    <td align="right">Name</td>
			    <td><?echo $get_account_done[9];?></td>
			  </tr>
			<?if($_SESSION[a_admin_level] > 6){?>
			  <tr>
			    <td align="right">Password</td>
			    <td><?echo $get_account_done[1];?></td>
			  </tr>
			<?}?>
			  <tr>
			    <td align="right">New Password</td>
			    <td><span id="psw"></span><span id="pswrd" style="font-size:7pt;"><a href="javascript://" onclick="document.getElementById('pswrd').style.display='none';document.getElementById('psw').innerHTML='<input type=\'text\' name=\'new_pwd\' size=\'12\' maxlength=\'10\'>';return false;">Change</a></span></td>
			  </tr>
			  <tr>
			    <td align="right">Mode</td>
			    <td><select name="mode" size="1" id="mode"><?echo $mode;?></select></td>
			  </tr>
			<?if($get_account_done[3] == 1){?>
			  <tr>
			    <td align="right">By <?echo date("H:i, d.m.Y", $get_account_done[10]);?></td>
			    <td>To <?echo date("H:i, d.m.Y", $get_account_done[10]+$get_account_done[11]);?></td>
			  </tr>
			<?}?>
			  <tr>
			    <td align="right">Block Time</td>
			    <td><select name="unblock_time" size="1" id="unblock_time"><option value='0'>Not Select</option><option value='21600'>6 h</option><option value='43200'>12 h</option><option value='86400'>1 day</option><option value='172800'>2 day</option><option value='259200'>3 day</option><option value='432000'>5 day</option><option value='864000'>10 day</option><option value='2592000'>30 day</option></select></td>
			  </tr>
			  <tr>
			    <td align="right">Block Date</td>
			    <td><select name="block_date" size="1" id="block_date"><option value='0'>Not Select</option><option value='no'>Not ToDay</option><option value='yes'>ToDay</option></select></td>
			  </tr>
			<?if($get_account_done[12] != ' ' && isset($get_account_done[12])){?>
			  <tr>
			    <td align="right">Blockec By</td>
			    <td><span class="text_administrator"><?echo $get_account_done[12];?></td>
			  </tr>
			<?}?>
			  <tr>
			    <td align="right">Block Reason</td>
			    <td><input name="block_reason" type="text" id="block_reason" value="<?echo $get_account_done[13];?>" size="17" maxlength="200"></td>
			  </tr>
			  <tr>
			    <td align="right">E-mail address</td>
			    <td><input name="email" type="text" id="email" value="<?echo $get_account_done[6];?>" size="17" maxlength="50"></td>
			  </tr>
			  <tr>
			    <td align="right">Secret Question</td>
			    <td><input name="squestion" type="text" id="squestion" value="<?echo $get_account_done[7];?>" size="10" maxlength="50"></td>
			  </tr>
			  <tr>
			    <td align="right">Secret Answer</td>
			    <td><input name="sanswer" type="text" id="sanswer" value="<?echo $get_account_done[8];?>" size="10" maxlength="10"></td>
			  </tr>
			  <tr>
			    <td align="right">Country</td>
			    <td><span class="text_administrator"><?echo country($get_account_done[4]);?></td>
			  </tr>
			  <tr>
			    <td align="right">Gender</td>
			    <td><?echo gender($get_account_done[5]);?></td>
			  </tr>
			<?if($_SESSION[a_admin_level] > 6){?>
			  <tr>
			    <td align="right">Admin Level</td>
			    <td><select name="admin_level" size="1" id="admin_level"><option value=0 <?echo $admin_level[0];?>><?echo mmw_status(0);?></option><option value=3 <?echo $admin_level[3];?>><?echo mmw_status(3);?></option><option value=6 <?echo $admin_level[6];?>><?echo mmw_status(6);?></option><option value=9 <?echo $admin_level[9];?>><?echo mmw_status(9);?></option></select></td>
			  </tr>
			<?}?>
			  <tr>
			    <td colspan="2" align="center"><input name="Edit Account" type="submit" id="Edit Account" value="Edit Account"> <input name="account" type="hidden" id="account" value="<?echo $get_account_done[0];?>"> <input name="edit_account_done" type="hidden" id="edit_account_done" value"edit_account_done"> <input type="reset" name="Reset" value="Reset"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
		</td>
	</tr>
<?if($get_acc_wh_num > 0 && $_SESSION[a_admin_level] > 3) {?>
	<tr>
		<td align="center">
		<fieldset>
		<legend>Ware House <?echo $get_account_done[0];?></legend>
			<form action="" method="post" name="edit_acc_wh_form" id="edit_acc_wh_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			  <tr>
			    <td width="42%" align="right">Ware House</td>
			    <td><input name="wh" type="text" id="wh" value="<?echo $get_acc_wh[1];?>" size="12" maxlength="10"></td>
			  </tr>
			  <tr>
			    <td align="right">Extra Ware House</td>
			    <td><input name="extrawh" type="text" id="extrawh" value="<?echo $get_acc_wh[2];?>" size="12"></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input name="Edit Ware House" type="submit" id="Edit Ware House" value="Edit Ware House"> <input name="account" type="hidden" id="account" value="<?echo $get_account_done[0];?>"> <input name="edit_acc_wh_done" type="hidden" id="edit_acc_wh_done" value"edit_acc_wh_done"> <input type="reset" name="Reset" value="Reset"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
		</td>
	</tr>
<?} //end wh ?>
	<tr>
		<td align="center">
		<fieldset>
		<legend>Character's <?echo $get_account_done[0];?></legend>
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			  <tr>
			    <td align="center"><?echo $get_acc_chr[0];?></td>
			    <td align="center"><?echo $get_acc_chr[1];?></td>
			    <td align="center"><?echo $get_acc_chr[2];?></td>
			    <td align="center"><?echo $get_acc_chr[3];?></td>
			    <td align="center"><?echo $get_acc_chr[4];?></td>
			  </tr>
			  <tr>
			    <td align="center"><?echo $get_acc_chr_online[0];?></td>
			    <td align="center"><?echo $get_acc_chr_online[1];?></td>
			    <td align="center"><?echo $get_acc_chr_online[2];?></td>
			    <td align="center"><?echo $get_acc_chr_online[3];?></td>
			    <td align="center"><?echo $get_acc_chr_online[4];?></td>
			  </tr>
			</table>
		</fieldset>
		</td>
	</tr>
<?} //end acc ?>
	<tr>
		<td align="center">
		<fieldset>
		<legend>Search Account</legend>
			<form action="" method="post" name="search_account" id="search_account">
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			  <tr>
			    <td width="42%" align="right">Account</td>
			    <td><input name="account_search" type="text" id="account_search" size="17" maxlength="10"></td>
			  </tr>
			  <tr>
			    <td align="right">Search type</td>
			    <td>
                                      <label>
                                      <input type="radio" name="search_type" value="1" checked>
                                      <span class="normal_text">Exact Match</span></label>
                                      <br>
                                      <label>
                                      <input type="radio" name="search_type" value="0">
                                      <span class="normal_text">Partial Match</span></label>
                                      <br></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Search Account"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
		</td>
	</tr>
<?if(isset($_POST["account_search"])){?>
	<tr>
		<td align="center">
		<fieldset>
		<legend>Search Account Results</legend>
			<?include("admin/inc/search_acc.php");?>
		</fieldset>
		</td>
	</tr>
<?}?>
</table>