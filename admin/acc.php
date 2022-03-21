<?
if(isset($_POST["edit_account_done"])){edit_account($_POST['account'],$_POST['new_pwd'],$_POST['mode'],$_POST['email'],$_POST['squestion'],$_POST['sanswer'],$_POST['unblock_time'],$_POST['block_date'],$_POST['blocked_by'],$_POST['block_reason']);}
if(isset($_POST["edit_acc_wh_done"])){edit_acc_wh($_POST['account'],$_POST['wh'],$_POST['extrawh']);}

if(isset($_POST["account_search_edit"]) || isset($_GET["acc"])) {

if(isset($_GET['acc'])){$_POST['account_search_edit'] = $_GET['acc'];}
$account_edit = stripslashes($_POST['account_search_edit']);
if($mmw[md5]==1){$get_account = mssql_query("Select memb___id,memb__pwd2,sno__numb,bloc_code,country,gender,mail_addr,fpas_ques,fpas_answ,memb_name,block_date,unblock_time,blocked_by,block_reason from MEMB_INFO where memb___id='$account_edit'");}
elseif($mmw[md5]==0){$get_account = mssql_query("Select memb___id,memb__pwd,sno__numb,bloc_code,country,gender,mail_addr,fpas_ques,fpas_answ,memb_name,block_date,unblock_time,blocked_by,block_reason from MEMB_INFO where memb___id='$account_edit'");}
$get_account_done = mssql_fetch_row($get_account);

if($get_account_done[5] == 'male'){$get_account_done[5] = "<img src='images/male.gif'> Male";}
elseif($get_account_done[5] == 'female'){$get_account_done[5] = "<img src='images/female.gif'> Female";}
if($get_account_done[3] == 1){$mode = "<option value='1'>Blocked</option><option value='0'>Normal</option>";}
elseif($get_account_done[3] == 0){$mode = "<option value='0'>Normal</option><option value='1'>Blocked</option>";}
if($get_account_done[1] == NULL){$get_account_done[1] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #111</font></td></tr></table>";}
if($get_account_done[4] == NULL){$get_account_done[4] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #112</font></td></tr></table>";}
if($get_account_done[5] == NULL){$get_account_done[5] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #113</font></td></tr></table>";}

$get_wh = mssql_query("SELECT AccountID,Money,extMoney FROM warehouse WHERE accountid='$account_edit'");
$get_acc_wh = mssql_fetch_row($get_wh);
$get_acc_wh_num = mssql_num_rows($get_wh);
if($get_acc_wh[1]==""){$get_acc_wh[1] = 0;}
if($get_acc_wh[2]==""){$get_acc_wh[2] = 0;}

$online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$account_edit'");
$oc_row = mssql_fetch_row($online_check);

$get_chr = mssql_query("SELECT GameID1,GameID2,GameID3,GameID4,GameID5,GameIDC FROM AccountCharacter WHERE Id='$account_edit'");
$get_acc_chr = mssql_fetch_row($get_chr);
if($get_acc_chr[0]==$get_acc_chr[5] && $oc_row[0]=='1'){$get_acc_chr_online[0] = "<font color='#00FF00'>Online</font>";}else{$get_acc_chr_online[0] = "<font color='#FF0000'>Offline</font>";}
if($get_acc_chr[1]==$get_acc_chr[5] && $oc_row[0]=='1'){$get_acc_chr_online[1] = "<font color='#00FF00'>Online</font>";}else{$get_acc_chr_online[1] = "<font color='#FF0000'>Offline</font>";}
if($get_acc_chr[2]==$get_acc_chr[5] && $oc_row[0]=='1'){$get_acc_chr_online[2] = "<font color='#00FF00'>Online</font>";}else{$get_acc_chr_online[2] = "<font color='#FF0000'>Offline</font>";}
if($get_acc_chr[3]==$get_acc_chr[5] && $oc_row[0]=='1'){$get_acc_chr_online[3] = "<font color='#00FF00'>Online</font>";}else{$get_acc_chr_online[3] = "<font color='#FF0000'>Offline</font>";}
if($get_acc_chr[4]==$get_acc_chr[5] && $oc_row[0]=='1'){$get_acc_chr_online[4] = "<font color='#00FF00'>Online</font>";}else{$get_acc_chr_online[4] = "<font color='#FF0000'>Offline</font>";}

if($get_acc_chr[0]=="" || $get_acc_chr[0]==" "){$get_acc_chr[0] = "No Char";}elseif($_SESSION[a_admin_level] > 3){$get_acc_chr[0] = "<a href='?op=char&chr=$get_acc_chr[0]'>$get_acc_chr[0]</a>";}else{$get_acc_chr[0] = "<u>$get_acc_chr[0]</u>";}
if($get_acc_chr[1]=="" || $get_acc_chr[1]==" "){$get_acc_chr[1] = "No Char";}elseif($_SESSION[a_admin_level] > 3){$get_acc_chr[1] = "<a href='?op=char&chr=$get_acc_chr[1]'>$get_acc_chr[1]</a>";}else{$get_acc_chr[1] = "<u>$get_acc_chr[1]</u>";}
if($get_acc_chr[2]=="" || $get_acc_chr[2]==" "){$get_acc_chr[2] = "No Char";}elseif($_SESSION[a_admin_level] > 3){$get_acc_chr[2] = "<a href='?op=char&chr=$get_acc_chr[2]'>$get_acc_chr[2]</a>";}else{$get_acc_chr[2] = "<u>$get_acc_chr[2]</u>";}
if($get_acc_chr[3]=="" || $get_acc_chr[3]==" "){$get_acc_chr[3] = "No Char";}elseif($_SESSION[a_admin_level] > 3){$get_acc_chr[3] = "<a href='?op=char&chr=$get_acc_chr[3]'>$get_acc_chr[3]</a>";}else{$get_acc_chr[3] = "<u>$get_acc_chr[3]</u>";}
if($get_acc_chr[4]=="" || $get_acc_chr[4]==" "){$get_acc_chr[4] = "No Char";}elseif($_SESSION[a_admin_level] > 3){$get_acc_chr[4] = "<a href='?op=char&chr=$get_acc_chr[4]'>$get_acc_chr[4]</a>";}else{$get_acc_chr[4] = "<u>$get_acc_chr[4]</u>";}
?>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td>
        <fieldset>
        <legend>Account <?echo $get_account_done[0];?></legend>
		<form action="" method="post" name="edit_account_form" id="edit_account_form">
                                                                    <table width="100%" border="0" cellspacing="4" cellpadding="0">
                                                                      <tr>
                                                                        <td width="50%" scope="row"><div align="right" class="text_administrator">Account</div></td>
                                                                        <td width="50%" scope="row" class="text_administrator"><?echo $get_account_done[0];?></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Name</div></td>
                                                                        <td scope="row" class="text_administrator"><?echo $get_account_done[9];?></td>
                                                                      </tr>
									<?if($_SESSION[a_admin_level] > 6){?>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Password</div></td>
                                                                        <td scope="row"><span class="text_administrator"><?echo $get_account_done[1];?></span></td>
                                                                      </tr>
									<?}?>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">New Password</div></td>
                                                                        <td scope="row"><span id="psw"></span><span id="pswrd" style="font-size:7pt;"><a href="javascript://" onclick="document.getElementById('pswrd').style.display='none';document.getElementById('psw').innerHTML='<input type=\'text\' name=\'new_pwd\' size=\'12\' maxlength=\'10\'>';return false;">Change</a></span></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Mode</div></td>
                                                                        <td scope="row"><select name="mode" size="1" id="mode"><?echo $mode;?></select></td>
                                                                      </tr>
									<?if($get_account_done[3] == 1){?>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">By <?echo date("H:i, d.m.Y", $get_account_done[10]);?></div></td>
                                                                        <td scope="row"><div class="text_administrator">To <?echo date("H:i, d.m.Y", $get_account_done[10]+$get_account_done[11]);?></div></td>
                                                                      </tr>
									<?}?>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Block Time</div></td>
                                                                        <td scope="row"><select name="unblock_time" size="1" id="unblock_time"><option value='0'>Not Select</option><option value='21600'>6 h</option><option value='43200'>12 h</option><option value='86400'>1 day</option><option value='172800'>2 day</option><option value='259200'>3 day</option><option value='432000'>5 day</option><option value='864000'>10 day</option><option value='2592000'>30 day</option></select></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Block Date</div></td>
                                                                        <td scope="row"><select name="block_date" size="1" id="block_date"><option value='0'>Not Select</option><option value='no'>Not ToDay</option><option value='yes'>ToDay</option></select></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Blockec By</div></td>
                                                                        <td scope="row"><input name="blocked_by" type="text" id="blocked_by" value="<?echo $get_account_done[12];?>" size="17" maxlength="50"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Block Reason</div></td>
                                                                        <td scope="row"><input name="block_reason" type="text" id="block_reason" value="<?echo $get_account_done[13];?>" size="17" maxlength="200"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">E-mail address </div></td>
                                                                        <td scope="row"><input name="email" type="text" id="email" value="<?echo $get_account_done[6];?>" size="17" maxlength="50"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Secret Question </div></td>
                                                                        <td scope="row"><input name="squestion" type="text" id="squestion" value="<?echo $get_account_done[7];?>" size="10" maxlength="10"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Secret Answer </div></td>
                                                                        <td scope="row"><input name="sanswer" type="text" id="sanswer" value="<?echo $get_account_done[8];?>" size="10" maxlength="10"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Country</div></td>
                                                                        <td scope="row"><span class="text_administrator"><?echo country($get_account_done[4]);?></span></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Gender</div></td>
                                                                        <td scope="row"><span class="text_administrator"><?echo $get_account_done[5];?></span></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator"></div></td>
                                                                        <td scope="row"><input name="account" type="hidden" id="account" value="<?echo $get_account_done[0];?>">
                                                                        <input name="edit_account_done" type="hidden" id="edit_account_done" value"edit_account_done"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row" align="right"><input name="Edit Account" type="submit" class="button" id="Edit Account" value="Edit Account"></td>
                                                                        <td scope="row"><input type="reset" name="Reset" value="Reset" class="button"></td>
                                                                      </tr>
                                                                    </table>
		</form>
        </fieldset>
    </td>
  </tr>
</table>

<?if($get_acc_wh_num > 0 && $_SESSION[a_admin_level] > 3) {?>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td>
        <fieldset>
        <legend>Ware House <?echo $get_account_done[0];?></legend>
		<form action="" method="post" name="edit_acc_wh_form" id="edit_acc_wh_form">
                                                                    <table width="100%" border="0" cellspacing="4" cellpadding="0">
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Ware House</div></td>
                                                                        <td scope="row"><input name="wh" type="text" id="wh" value="<?echo $get_acc_wh[1];?>" size="12" maxlength="10"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Extra Ware House</div></td>
                                                                        <td scope="row"><input name="extrawh" type="text" id="extrawh" value="<?echo $get_acc_wh[2];?>" size="12"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator"></div></td>
                                                                        <td scope="row"><input name="account" type="hidden" id="account" value="<?echo $get_account_done[0];?>">
                                                                        <input name="edit_acc_wh_done" type="hidden" id="edit_acc_wh_done" value"edit_acc_wh_done"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row" align="right"><input name="Edit Ware House" type="submit" class="button" id="Edit Ware House" value="Edit Ware House"></td>
                                                                        <td scope="row"><input type="reset" name="Reset" value="Reset" class="button"></td>
                                                                      </tr>
                                                                    </table>
		</form>
        </fieldset>
    </td>
  </tr>
</table>
<?} //end wh?>

<table width="400" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td>
        <fieldset>
        <legend>Character's <?echo $get_account_done[0];?></legend>
              <table width="100%" border="0" cellspacing="4" cellpadding="0">
                  <tr>
                    <td scope="row" align="center"><div class="text_administrator"><?echo $get_acc_chr[0];?></div></td>
                    <td scope="row" align="center"><div class="text_administrator"><?echo $get_acc_chr[1];?></div></td>
                    <td scope="row" align="center"><div class="text_administrator"><?echo $get_acc_chr[2];?></div></td>
                    <td scope="row" align="center"><div class="text_administrator"><?echo $get_acc_chr[3];?></div></td>
                    <td scope="row" align="center"><div class="text_administrator"><?echo $get_acc_chr[4];?></div></td>
                  </tr>
                  <tr>
                    <td scope="row" align="center"><div class="text_administrator"><?echo $get_acc_chr_online[0];?></div></td>
                    <td scope="row" align="center"><div class="text_administrator"><?echo $get_acc_chr_online[1];?></div></td>
                    <td scope="row" align="center"><div class="text_administrator"><?echo $get_acc_chr_online[2];?></div></td>
                    <td scope="row" align="center"><div class="text_administrator"><?echo $get_acc_chr_online[3];?></div></td>
                    <td scope="row" align="center"><div class="text_administrator"><?echo $get_acc_chr_online[4];?></div></td>
                  </tr>
              </table>
        </fieldset>
    </td>
  </tr>
</table>

<?} //end acc?>

<table width="400" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td>
        <fieldset>
        <legend>Search Account</legend>
		<form action="" method="post" name="search_account" id="search_account">
			<table width="100%" border="0" cellspacing="2" cellpadding="0">
                                <tr>
                                  <td colspan="2"><span class="normal_text">Account:</span> <input name="account_search" type="text" id="account_search" size="17" maxlength="10"></td>
                                </tr>
                                <tr>
                                  <td width="70"><span class="normal_text">Search type</span></td>
                                  <td><p>
                                      <label>
                                      <input type="radio" name="search_type" value="1" checked>
                                      <span class="normal_text">Exact Match</span></label>
                                      <br>
                                      <label>
                                      <input type="radio" name="search_type" value="0">
                                      <span class="normal_text">Partial Match</span></label>
                                      <br>
                                  </p></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><input type="submit" name="Submit" value="Search Account"></td>
                                </tr>
			</table>
		</form>
        </fieldset>
    </td>
  </tr>
</table>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td scope="row" align="center">
	<?if(isset($_POST["account_search"])){include("admin/inc/search_acc.php");}?>
    </td>
  </tr>
</table>