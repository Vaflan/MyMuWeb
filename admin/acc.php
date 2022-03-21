<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

// Account Editor
if(isset($_POST["edit_account_done"])) {
 $post_account = $_POST['account'];
 $post_pwd = $_POST['new_pwd'];
 $post_mode = $_POST['mode'];
 $post_email = $_POST['email'];
 $post_squestion = $_POST['squestion'];
 $post_sanswer = $_POST['sanswer'];
 $post_unblock_time = $_POST['unblock_time'];
 $post_block_date = $_POST['block_date'];
 $post_block_reason = $_POST['block_reason'];
 $post_admin_level = $_POST['admin_level'];

 $sql_account_check = mssql_query("SELECT memb___id FROM memb_info WHERE memb___id='$post_account'");
 $online_check = mssql_fetch_row( mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$post_account'") );
 if(empty($post_account) || empty($post_email) || empty($post_squestion) || empty($post_sanswer)) {echo "<img src=./images/warning.gif> Error: Some Fields Were Left Blank!  <br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(mssql_num_rows($sql_account_check) <= 0) {echo "$warning_red Error: Account $post_account Doesn't Exist!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
 elseif($online_check[0] != 0) {echo "$warning_red Error: Account $post_account Must Be Logged Off!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
 else {
  if(!empty($post_unblock_time)) {$block_menu = "[unblock_time]='$post_unblock_time',";}
  if($post_block_date!="no") {
   if($post_block_date=='yes') {$post_block_date = time();}
   else {$post_block_date = '0';}
   $block_menu = $block_menu . "[block_date]='$post_block_date',";
  }
  $block_menu = $block_menu . "[blocked_by]='$_SESSION[a_admin_login]',[block_reason]='$post_block_reason',";
  if(!empty($post_pwd) && $post_pwd!=' ') {
   if($mmw['md5']==yes) {$new_pass = "[memb__pwd2]='$post_pwd',[memb__pwd]=[dbo].[fn_md5]('$post_pwd','$post_account'),";}
   if($mmw['md5']==no) {$new_pass = "[memb__pwd2]='$post_pwd',[memb__pwd]='$post_pwd',";}
  }

  mssql_query("UPDATE memb_info SET $new_pass $block_menu [bloc_code]='$post_mode',[mail_addr]='$post_email',[fpas_ques]='$post_squestion',[fpas_answ]='$post_sanswer',[mmw_status]='$post_admin_level' WHERE memb___id='$post_account'");
  echo "$warning_green Account $post_account SuccessFully Edited!";
  writelog("edit_acc","Account $_POST[account] Has Been <font color=#FF0000>Edited</font> with the next->New Password:$_POST[new_pwd]|E-mail:$_POST[email]|Secret Question:$_POST[squestion]|Secret Answer:$_POST[sanswer]|Admin Level:$_POST[admin_level]");
 }
}

if(isset($_POST["edit_acc_wh_done"])) {
 $post_account = $_POST['account'];
 $post_warehouse = $_POST['wh'];
 $post_extwarehouse = $_POST['extrawh'];

 $sql_account_check = mssql_query("SELECT memb___id FROM memb_info WHERE memb___id='$post_account'");
 if(empty($post_account) || $post_warehouse<0 || $post_extwarehouse<0) {echo "$warning_red Error: Some Fields Were Left Blank!  <br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(mssql_num_rows($sql_account_check) <= 0) {echo "$warning_red Error: Account $post_account Doesn't Exist!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
 else {
  mssql_query("UPDATE warehouse SET [Money]='$post_warehouse',[extMoney]='$post_extwarehouse' WHERE AccountID='$post_account'");
  echo "$warning_green Acc Ware House $post_account SuccessFully Edited!";
  writelog("a_edit_acc_wh","Account <b>$post_account</b> Has Been <font color=#FF0000>Edited</font> with the next-> Extra WH: $post_extwarehouse | WH: $post_warehouse");
 }
}
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

 if($get_account_done[5]=='male'){$gender = 'Male';} else{$gender = 'Female';}
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

 if(empty($get_acc_chr[0]) || $get_acc_chr[0]==" ") {$get_acc_chr[0] = "No Char";} else{$get_acc_chr[0] = "<a href='?op=char&chr=$get_acc_chr[0]'>$get_acc_chr[0]</a>";}
 if(empty($get_acc_chr[1]) || $get_acc_chr[1]==" ") {$get_acc_chr[1] = "No Char";} else{$get_acc_chr[1] = "<a href='?op=char&chr=$get_acc_chr[1]'>$get_acc_chr[1]</a>";}
 if(empty($get_acc_chr[2]) || $get_acc_chr[2]==" ") {$get_acc_chr[2] = "No Char";} else{$get_acc_chr[2] = "<a href='?op=char&chr=$get_acc_chr[2]'>$get_acc_chr[2]</a>";}
 if(empty($get_acc_chr[3]) || $get_acc_chr[3]==" ") {$get_acc_chr[3] = "No Char";} else{$get_acc_chr[3] = "<a href='?op=char&chr=$get_acc_chr[3]'>$get_acc_chr[3]</a>";}
 if(empty($get_acc_chr[4]) || $get_acc_chr[4]==" ") {$get_acc_chr[4] = "No Char";} else{$get_acc_chr[4] = "<a href='?op=char&chr=$get_acc_chr[4]'>$get_acc_chr[4]</a>";}

 foreach($mmw[status_rules] as $key => $value) {
  $mmw_status_list .= "<option value=$key $admin_level[$key]>$value[name]</option>";
 }
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
			  <tr>
			    <td align="right">Password</td>
			    <td><?echo $get_account_done[1];?></td>
			  </tr>
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
			    <td><select name="unblock_time" size="1" id="unblock_time"><option value='0'>Forever</option><option value='1800'>30 m</option><option value='3600'>1 h</option><option value='21600'>6 h</option><option value='43200'>12 h</option><option value='86400'>1 day</option><option value='172800'>2 day</option><option value='259200'>3 day</option><option value='432000'>5 day</option><option value='864000'>10 day</option><option value='2592000'>30 day</option></select></td>
			  </tr>
			  <tr>
			    <td align="right">Block Date</td>
			    <td><select name="block_date" size="1" id="block_date"><option value='0'>Not Select Day</option><option value='no'><?echo date("H:i, d.m.Y", $get_account_done[10]);?></option><option value='yes'>Today <?echo date("H:i");?></option></select></td>
			  </tr>
			<?if($get_account_done[12]!=' ' && !empty($get_account_done[12])){?>
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
			    <td><?echo $gender;?></td>
			  </tr>
			  <tr>
			    <td align="right">Admin Level</td>
			    <td><select name="admin_level" size="1" id="admin_level"><?echo $mmw_status_list;?></select></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input name="Edit Account" type="submit" id="Edit Account" value="Edit Account"> <input name="account" type="hidden" id="account" value="<?echo $get_account_done[0];?>"> <input name="edit_account_done" type="hidden" id="edit_account_done" value"edit_account_done"> <input type="reset" name="Reset" value="Reset"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
		</td>
	</tr>
	<tr>
		<td align="center">
		<fieldset>
<?if($get_acc_wh_num > 0) {?>
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
	<tr>
		<td align="center">
		<fieldset>
<?} //end wh ?>
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
	<tr>
		<td align="center">
		<fieldset>
<?} //end acc ?>
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
                                      <span class="normal_text">Partial Match</span></label>
                                      <br>
                                      <label>
                                      <input type="radio" name="search_type" value="0">
                                      <span class="normal_text">Exact Match</span></label>
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

<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
<thead><tr>
<td align="center">#</td>
<td align="left">Account</td>
<td align="left">Mode</td>
<td align="left">Country</td>
<td align="left">Gender</td>
<td align="center">Status</td>
<td align="center">Edit</td>
</tr></thead>
<?
$search = clean_var(stripslashes($_POST['account_search']));
$search_type = clean_var(stripslashes($_POST['search_type']));

if($_POST['search_type']==0){$result = mssql_query("SELECT memb___id,memb__pwd,bloc_code,country,gender from MEMB_INFO where memb___id='$search'");}
if($_POST['search_type']==1){$result = mssql_query("SELECT memb___id,memb__pwd,bloc_code,country,gender from MEMB_INFO where memb___id like '%$search%'");}

for($i=0;$i < mssql_num_rows($result);++$i) {
 $row = mssql_fetch_row($result);
 $rank = $i+1;

 $status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[0]'");
 $status = mssql_fetch_row($status_reults);

 if($status[0] == 0){$status[0] ='<img src=images/offline.gif>';}
 if($status[0] == 1){$status[0] ='<img src=images/online.gif>';}

 if($row[2] == 0){$row[2] ='Normal';}
 if($row[2] == 1){$row[2] ="<table><tr><td bgcolor='yellow'><font color='#000000' size='1'>Blocked</font></td></tr></table>";}

 if($row[4] == 'male'){$row[4] = "<img src='images/male.gif'>";}
 elseif($row[4] == 'female'){$row[4] = "<img src='images/female.gif'>";}
 elseif($row[4] == NULL){$row[4] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #113</font></td></tr></table>";}
 if($row[3] == NULL){$row[3] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #112</font></td></tr></table>";}
 if($row[1] == NuLL){$row[1] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #111</font></td></tr></table>";}

 if($row[3] == '0'){$country = "Not Set";} else{$country = country($row[3]);}

 $account_table_edit = "<form action='' method='post'><input type='submit' value='Edit'><input name='account_search_edit' type='hidden' value=$row[0]></form>";
?>
 <tr>
  <td align='center'><?echo $rank;?>.</td>
  <td align='left'><?echo $row[0];?></td>
  <td align='left'><?echo $row[2];?></td>
  <td align='left'><?echo $country;?></td>
  <td align='left'><?echo $row[4];?></td>
  <td align='center'><?echo $status[0];?></td>
  <td align='center'><?echo $account_table_edit;?></td>
 </tr>
<?}?>
</table>

		</fieldset>
		</td>
	</tr>
<?}?>
</table>