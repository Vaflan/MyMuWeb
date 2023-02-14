<?PHP
// Creator =Master=
// Get from MuWeb 0.8
// Edited by Vaflan
// It's modified for MyMuWeb

class option{
 //error_reporting( E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING );
 private static $debug = 0;

static function register() {
       $account = stripslashes($_POST['account']);
       $password = stripslashes($_POST['password']);
       $repassword = stripslashes($_POST['repassword']);
       $email = stripslashes($_POST['email']);
       $squestion = stripslashes($_POST['question']);
       $sanswer = stripslashes($_POST['answer']);
       $verifyinput = stripslashes($_POST['verifyinput']);
       $country = stripslashes($_POST['country']);
       $gender = stripslashes($_POST['gender']);
       $fullname = stripslashes($_POST['fullname']);
       $referral = stripslashes($_SESSION['referral']);
       $ip = $_SERVER['REMOTE_ADDR'];

                      require("config.php");
                      include("includes/validate.class.php");

                      $elems[] = array('name'=>'account','label'=>$die_start. mmw_lang_invalid_account .$die_end, 'type'=>'text', 'uname'=>'true', 'required'=>true, 'len_min'=>4, 'len_max'=>10, 'cont'=>'alpha');
                      $elems[] = array('name'=>'email', 'label'=>$die_start. mmw_lang_invalid_email .$die_end, 'type'=>'text', 'required'=>true, 'len_max'=>50, 'cont'=>'email');
                      $elems[] = array('name'=>'password', 'label'=>$die_start. mmw_lang_invalid_password .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4,'len_max'=>10, 'cont'=>'alpha');
	              $elems[] = array('name'=>'repassword', 'label'=>$die_start. mmw_lang_invalid_repassword .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4, 'len_max'=>10, 'cont'=>'alpha', 'equal'=> array('password'));
	              $elems[] = array('name'=>'question', 'label'=>$die_start. mmw_lang_invalid_question .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4, 'len_max'=>10, 'cont'=>'alpha');
	              $elems[] = array('name'=>'answer', 'label'=>$die_start. mmw_lang_invalid_answer .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4, 'len_max'=>10, 'cont'=>'alpha');
                      $elems[] = array('name'=>'fullname','label'=>$die_start. mmw_lang_invalid_fullname .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>2, 'len_max'=>10, 'cont'=>'alpha');


                 $f = new FormValidator($elems);
	             $err = $f->validate($_POST);
	                if( $err === true ) {
	                	$valid = $f->getValidElems();
		                    foreach ( $valid as $k => $v ) {
			               if( $valid[$k][0][1] == false ) {
				             if( empty($valid[$k][0][2]) ) {
				                  echo $valid[$k][0][2];
						}else {
			                          echo $valid[$k][0][2];
				            }
			             }
		             }
                          } else {

                      $username_check = mssql_query("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$account'");
                      $username_verify = mssql_num_rows($username_check);

                      $email_check = mssql_query("SELECT mail_addr FROM MEMB_INFO WHERE mail_addr='$email'");
                      $email_verify = mssql_num_rows($email_check);

                      $ip_check = mssql_query("SELECT ip FROM MEMB_INFO WHERE ip='$ip'");
                      $ip_verify = mssql_num_rows($ip_check);

                               if($_SESSION[image_random_value] != md5($verifyinput)) {
                                         $error= 1;
                                         echo $die_start . mmw_lang_correctly_code . $die_end;
                                                                                         }
                               if($username_verify  > 0) {
                                         $error= 1;
                                         echo $die_start . mmw_lang_account_in_use . $die_end;
                                                         }
                               if($email_verify > 0) {
                                         $error= 1;
                                         echo $die_start . mmw_lang_email_in_use . $die_end;
                                                     }
                               if($country <= 0) {
                                         $error= 1;
                                         echo $die_start . mmw_lang_invalid_country . $die_end;
                                                     }
                               if($ip_verify >= $mmw[max_ip_acc] && $mmw[max_ip_acc] != 0) {
                                         $error= 1;
					 $result_max_ip_acc = str_replace("{NUMBER}",$mmw[max_ip_acc],mmw_lang_max_acc_one_ip);
                                         echo $die_start . $result_max_ip_acc . $die_end;
                                                     }

                               if($error!=1) {
				if($mmw['md5'] == yes) {
				 @mssql_query("INSERT INTO MEMB_INFO (memb___id,memb__pwd,memb_name,sno__numb,mail_addr,appl_days,modi_days,out__days,true_days,mail_chek,bloc_code,ctl1_code,memb__pwd2,fpas_ques,fpas_answ,country,gender,hide_profile,ref_acc,ip) VALUES ('$account',[dbo].[fn_md5]('$password','$account'),'$fullname','1234','$email',GETDATE(),GETDATE(),'2008-12-20','2008-12-20','1','0','0','$password','$squestion','$sanswer','$country','$gender','0','$referral','$ip')");
				}
				elseif($mmw['md5'] == no) {
				 @mssql_query("INSERT INTO MEMB_INFO (memb___id,memb__pwd,memb_name,sno__numb,mail_addr,appl_days,modi_days,out__days,true_days,mail_chek,bloc_code,ctl1_code,memb__pwd2,fpas_ques,fpas_answ,country,gender,hide_profile,ref_acc,ip) VALUES ('$account','$password','$fullname','1234','$email',GETDATE(),GETDATE(),'2008-12-20','2008-12-20','1','0','0','$password','$squestion','$sanswer','$country','$gender','0','$referral','$ip')");
				 @mssql_query("INSERT INTO VI_CURR_INFO (ends_days,chek_code,used_time,memb___id,memb_name,memb_guid,sno__numb,Bill_Section,Bill_value,Bill_Hour,Surplus_Point,Surplus_Minute,Increase_Days) VALUES ('2005','1',1234,'$account','$account',1,'7','6','3','6','6','2003-11-23 10:36:00','0')");
				}
				 $warehouse_items = '0x'.free_hex($mmw[free_hex],120);
				 @mssql_query("INSERT INTO warehouse (AccountID,Items,EndUseDate,DbVersion,extMoney) VALUES ('$account',$warehouse_items,GETDATE(),'2','$mmw[zen_for_acc]')");
				 if($mmw['disable_credits'] > 0) {@mssql_query("INSERT INTO credits (memb___id,credits) VALUES ('$account',0)");}
				 echo $okey_start . mmw_lang_account_created . $okey_end;
                               }
                       }
        }






static function reset($charactername) {
          if((isset($_SESSION['pass'])) && (isset($_SESSION['user']))); {
		require("config.php");
		$login = clean_var(stripslashes($_SESSION[user]));
		$charactername = stripslashes($charactername);

		$online_check_result = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$login'");
		$online_check = mssql_fetch_row($online_check_result);
		$wh_result = mssql_query("SELECT AccountID,extMoney FROM warehouse WHERE accountid='$login'");
		$wh_row = mssql_fetch_row($wh_result); if($wh_row[1]=="" || $wh_row[1]==" ") {$wh_row[1]="0";}

		$result = mssql_query("SELECT Clevel,Reset,Money,LevelUpPoint,class FROM Character WHERE Name='$charactername' AND AccountID='$login'");
		$character_check = mssql_num_rows($result);
		$row = mssql_fetch_row($result);

			if($row[4] >= 0 && $row[4] <= 15) {$reset_level = $mmw[reset_level_dw]; $reset_points = $mmw[reset_points_dw];}
			if($row[4] >= 16 && $row[4] <= 31) {$reset_level = $mmw[reset_level_dk]; $reset_points = $mmw[reset_points_dk];}
			if($row[4] >= 32 && $row[4] <= 47) {$reset_level = $mmw[reset_level_elf]; $reset_points = $mmw[reset_points_elf];}
			if($row[4] >= 48 && $row[4] <= 63) {$reset_level = $mmw[reset_level_mg]; $reset_points = $mmw[reset_points_mg];}
			if($row[4] >= 64 && $row[4] <= 79) {$reset_level = $mmw[reset_level_dl]; $reset_points = $mmw[reset_points_dl];}
			if($row[4] >= 80 && $row[4] <= 95) {$reset_level = $mmw[reset_level_sum]; $reset_points = $mmw[reset_points_sum];}
			if($row[4] >= 96 && $row[4] <= 112) {$reset_level = $mmw[reset_level_rf]; $reset_points = $mmw[reset_points_rf];}

		$reset_up = $row[1] + (1);
		$char_money = $row[2];
			//CastleSiege Member % Price
                           if($mmw[mix_cs_memb_reset]=="yes") {
				$guildm_results = mssql_query("Select G_name from GuildMember where name='$charactername'");
				$guildm = mssql_fetch_row($guildm_results);
				if($guildm[0]!=NULL || $guildm[0]!=" "){
					$cs_query = mssql_query("SELECT owner_guild,money FROM MuCastle_DATA");
					$cs_row = mssql_fetch_row($cs_query);
					if($cs_row[0]==$guildm[0]) {
						if($mmw[max_zen_cs_reset]>$cs_row[1]){$edited_zen_cs = $cs_row[1];} else{$edited_zen_cs = $mmw[max_zen_cs_reset];}
						$cs_memb_reset_zen = ( substr($mmw['reset_money'], 0, -6) * ceil( substr($edited_zen_cs, 0, -6) / $mmw[num_for_mix_cs_reset] ) ) / 100;
					}
				}
				$edited_res_money = $mmw['reset_money'] - ($cs_memb_reset_zen * 1000000);
                           }
                           else {$edited_res_money = $mmw['reset_money'];}
			//Reset * Zen
                           if($mmw[reset_system]=='yes') {$resetmoneysys = $edited_res_money * $reset_up;}
                           else {$resetmoneysys = $edited_res_money;}

                           if($mmw[reset_limit_price] != '0' && $mmw[reset_limit_price] <= $resetmoneysys) {$resetmoneysys = $mmw[reset_limit_price];}
                           $wh_money = $wh_row[1] - $resetmoneysys;
                           if($wh_money < 0) {$char_money = $char_money + $wh_money; $wh_money = 0;}
                           $resetpt = $row[3] + $reset_points;
                           $resetpt1 = $reset_points * $reset_up;

			//Check Inventory
                           if($mmw[check_inventory] == 'yes') {
                            $result = mssql_query("declare @vault varbinary(1728); set @vault=(SELECT Inventory FROM Character WHERE Name='$charactername'); print @vault;");
                            $inventory = substr(mssql_get_last_message(),2,$mmw[free_hex] * 12);
                            $test_invetory = free_hex($mmw[free_hex],12);
                           }


                            if(empty($charactername) || empty($login)){ $error=1;
	                                 echo $die_start . mmw_lang_left_blank . $die_end;
                                                           }
                            if($character_check <= 0) {$error=1;
                                         echo $die_start . $charactername . mmw_lang_character_does_not_exist . $die_end;
                                                           }
                            if($online_check[0] != 0) {$error=1;
                                         echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;
                                                  }
                            if($char_money < 0) {$error=1;
                                         echo $die_start . mmw_lang_for_reset_need .' '.zen_format($resetmoneysys)." Zen! $die_end";
                                                    	   }
                            if($row[0] < $reset_level || !isset($mmw[reset_level_rf])) {$error=1;
                                         echo $die_start . mmw_lang_for_reset_need ." $reset_level ".mmw_lang_level."! $die_end";
                                                           }
                            if($row[1] > $mmw['reset_limit_level']) {$error=1;
                                         echo $die_start . mmw_lang_reset_limit_to . " $mmw[reset_limit_level]! $die_end";
                                                           }
                            if($mmw[check_inventory] == 'yes' && $inventory!=$test_invetory) {$error=1;
                                         echo $die_start . mmw_lang_take_off_set . $die_end;
                                                           }

                            if(!$error){
				if($mmw['level_up_mode']=='normal') {$LevelUpPoint = "$resetpt";} else {$LevelUpPoint = "$resetpt1";}
				if($mmw['reset_mode']=='reset') {$reset_stats = "[strength]='25',[dexterity]='25',[vitality]='25',[energy]='25',";}
				if($mmw['reset_command']=='yes' && $row[4] >= 64 && $row[4] <= 79) {$reset_command = "[Leadership]='25',";}
				if($mmw['clean_inventory']=='yes') {$clean_inventory = "[inventory]=0x".free_hex($mmw[free_hex],108).",";}
				if($mmw['clean_skills']=='yes') {$clean_skills = "[magiclist]=0x".free_hex(20,18).",";}

				$sql_reset_script = "UPDATE character Set $clean_inventory $clean_skills $reset_stats $reset_command [clevel]='1',[experience]='0',[money]='$char_money',[LevelUpPoint]='$LevelUpPoint',[reset]='$reset_up' WHERE name='$charactername'";
				mssql_query($sql_reset_script);
				mssql_query("UPDATE warehouse SET [extMoney]='$wh_money' WHERE accountid='$login'");

				echo $okey_start . mmw_lang_character_reseted . $okey_end;
				writelog("resets","Character <b>$charactername</b> Has Been <font color=#FF0000>Reseted</font>, Before Reset: $row[1](reset), After Reset: $reset_up(reset), For: $resetmoneysys Zen");
                            }
                      }
}





static function add_stats($name) {
        if(isset($_SESSION['pass']) && isset($_SESSION['user'])) {
                 require("config.php");
                 require("includes/validate.class.php");
                 $login = stripslashes($_SESSION['user']);
                 $strength = stripslashes($_POST['str']);
                 $dexterity = stripslashes($_POST['agi']);
                 $vitality = stripslashes($_POST['vit']);
                 $energy = stripslashes($_POST['ene']);
                 $command = stripslashes($_POST['com']);

                 $online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$login'");
                 $online_check_row = mssql_fetch_row($online_check);

                 $result = mssql_query("select vitality,strength,energy,dexterity,levelupPoint,leadership from Character WHERE Name='$name'");
                 $row = mssql_fetch_row($result);

                 $new_str = $row[1] + $strength;
                 $new_agi = $row[3] + $dexterity;
                 $new_vit = $row[0] + $vitality;
                 $new_eng = $row[2] + $energy;
                 $new_com = $row[5] + $command;
                 $points = $row[4] - $vitality - $strength - $energy - $dexterity - $command;

			$nmbr = "/^\d*$/";

                        if(!preg_match($nmbr,$strength) || !preg_match($nmbr,$dexterity) || !preg_match($nmbr,$vitality) || !preg_match($nmbr,$energy) || !preg_match($nmbr,$command)) {$error=1;
                                 echo $die_start . mmw_lang_point_must_be_number . $die_end;
                        }
                        if ($online_check_row[0] != 0) {$error = 1;
                                 echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;
                        }
                        if ($points < 0) {$error = 1;
                                 echo $die_start . mmw_lang_dont_have_point ." $row[4]! $die_end";
                        }
                        if($new_str>$mmw[max_stats] || $new_agi>$mmw[max_stats] || $new_vit>$mmw[max_stats] || $new_eng>$mmw[max_stats] || $new_com>$mmw[max_stats]) {$error=1;
                                 echo "$die_start $mmw[max_stats] " . mmw_lang_max_point . $die_end;
                        }
                        if($error != 1) {
                                       mssql_query("UPDATE Character SET [Vitality]='$new_vit',[Strength]='$new_str',[Energy]='$new_eng',[Dexterity]='$new_agi',[leadership]='$new_com',[LevelUpPoint]='$points' WHERE Name='$name'");
                                       echo $okey_start . mmw_lang_character_stats_added . " $points $okey_end";
                                       writelog("stats","Character <b>$name</b> Has Been <font color=#FF0000>Updated</font> Stats with the next -> Strength: $new_str|Agiltiy: $new_agi|Vitality: $new_vit|Energy: $new_eng|Command: $new_command, Levelup Points Left: $points");
                      }
       }
}







static function clear_pk($name) {
       if(isset($_SESSION['pass']) && isset($_SESSION['user'])); {
                 require("config.php");
                 $name = stripslashes($name);
                 $login = stripslashes($_SESSION['user']);

                 $online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$login'");
                 $online_check_row = mssql_fetch_row($online_check);

                 $sql_Pk_check = mssql_query("SELECT PkLevel,PkCount,Money FROM Character WHERE PkLevel > 3 and Name='$name'");
                 $PkLevel_check = mssql_num_rows($sql_Pk_check);
                 $row_Pk = mssql_fetch_row($sql_Pk_check);

                 $wh_result = mssql_query("SELECT AccountID,extMoney FROM warehouse WHERE accountid='$login'");
                 $wh_row = mssql_fetch_row($wh_result); if($wh_row[1]=="" || $wh_row[1]==" ") {$wh_row[1]="0";}

                 $char_money = $row_Pk[2];
                 $wh_money = $wh_row[1] - $mmw['pkmoney'];
                 if($wh_money < 0) {$char_money = $char_money + $wh_money; $wh_money = 0;}

                         if (empty($name) || empty($login)) {$error = 1;
                                echo $die_start . mmw_lang_left_blank . $die_end;
                         }
                         if ($online_check_row[0] != 0) {$error = 1;
				echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;
                         }
                         if ($PkLevel_check <= 0) {$error = 1;
				echo $die_start . mmw_lang_is_not_killer . $die_end;
                         }
                         if ($char_money < 0) {$error = 1;
				echo $die_start . mmw_lang_clean_pk_need .' '.zen_format($mmw[pkmoney])." Zen! $die_end";
                         }

                         if($error != 1) {
				mssql_query("UPDATE warehouse SET [extMoney]='$wh_money' WHERE accountid='$login'");
				mssql_query("UPDATE Character SET [PkLevel]='3',[PkTime]='0',[Money]='$char_money' where  Name='$name'");
				echo $okey_start . mmw_lang_character_cleared . $okey_end;
				writelog("clearpk","Character <b>$name</b> Has Been <font color=#FF0000>Cleaned</font> His Pk Status");
                          }
             }
}







static function changepassword() {
     if ((isset($_SESSION['pass'])) && (isset($_SESSION['user']))); {
               require("config.php");
               require("includes/validate.class.php");
               $login = clean_var(stripslashes($_SESSION['user']));
               $oldpwd = clean_var(stripslashes($_POST['oldpassword']));
               $newpwd = clean_var(stripslashes($_POST['newpassword']));
               $renewpwd = clean_var(stripslashes($_POST['renewpassword']));

               $online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$login'");
               $online_check_row = mssql_fetch_row($online_check);

                  if($mmw['md5']==yes) {$sql_pw_check = mssql_query("SELECT * FROM dbo.MEMB_INFO WHERE memb___id='$login' AND memb__pwd = [dbo].[fn_md5]('$oldpwd','$login')");}
                  elseif($mmw['md5']==no) {$sql_pw_check = mssql_query("SELECT * FROM dbo.MEMB_INFO WHERE memb___id='$login' AND memb__pwd='$oldpwd'");}
                  $pw_check = mssql_num_rows($sql_pw_check);

	          $elems[] = array('name'=>'oldpassword', 'label'=>$die_start. mmw_lang_invalid_current_password .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4, 'len_max'=>10, 'cont' =>'alpha');
	          $elems[] = array('name'=>'newpassword', 'label'=>$die_start. mmw_lang_invalid_new_password .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4, 'len_max'=>10, 'cont' =>'alpha');
	          $elems[] = array('name'=>'renewpassword', 'label'=>$die_start. mmw_lang_invalid_repassword .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4,'len_max'=>10, 'cont' =>'alpha', 'equal'=> array('newpassword'));

                  $f = new FormValidator($elems);
	             $err = $f->validate($_POST);

	                if ( $err === true ) {
	                	$valid = $f->getValidElems();
		                    foreach ( $valid as $k => $v ) {
			               if ( $valid[$k][0][1] == false ) {
				             if ( empty($valid[$k][0][2]) ) {
				                  echo $valid[$k][0][2];
						}else {
			                          echo $valid[$k][0][2];
				            }
			             }
		             }
                               } else {

                  if ($online_check_row[0] != 0) {$error = 1;
                           echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;
                  }
                  if ($oldpwd==$newpwd) {$error = 1;
                           echo $die_start . mmw_lang_old_and_new_password . $die_end;
                  }
                  if ($pw_check <= 0) {$error = 1;
                           echo $die_start . mmw_lang_invalid_current_password . $die_end;
                  }
                  if($error!=1){
				if($mmw['md5']==yes){mssql_query("UPDATE MEMB_INFO SET [memb__pwd]=[dbo].[fn_md5]('$newpwd','$login'),[memb__pwd2]='$newpwd' WHERE memb___id ='$login'");}
				elseif($mmw['md5']==no){mssql_query("UPDATE MEMB_INFO SET [memb__pwd]='$newpwd',[memb__pwd2]='$newpwd' WHERE memb___id ='$login'");}

				$_SESSION['pass'] = $newpwd;
				echo $okey_start . mmw_lang_password_changed . $okey_end;
                  }
            }
      }
}







static function lostpassword() {
              require("config.php");
              require("includes/validate.class.php");
              $login = clean_var(stripslashes($_POST['username']));
              $quest = clean_var(stripslashes($_POST['quest']));
              $answer = clean_var(stripslashes($_POST['answer']));
              $email = clean_var(stripslashes($_POST['email']));

              $sql_user_check = mssql_query("SELECT memb___id FROM MEMB_INFO WHERE memb___id='$login'");
              $sql_mail_check = mssql_query("SELECT memb___id,mail_addr FROM MEMB_INFO WHERE memb___id='$login' and mail_addr='$email'");
              $sql_qa_check = mssql_query("SELECT memb___id,fpas_ques,fpas_answ FROM MEMB_INFO WHERE memb___id='$login' and fpas_ques='$quest' and fpas_answ='$answer'");

                    if($mmw['md5'] == yes) {$sql_pw_get = mssql_query("SELECT memb__pwd2,fpas_ques FROM MEMB_INFO WHERE memb___id='$login'");}
                    elseif($mmw['md5'] == no) {$sql_pw_get = mssql_query("SELECT memb__pwd,fpas_ques FROM MEMB_INFO WHERE memb___id='$login'");}

		$user_check = mssql_num_rows($sql_user_check);
		$mail_check = mssql_num_rows($sql_mail_check);
		$qa_check = mssql_num_rows($sql_qa_check);
		$pw_retrieval = mssql_fetch_row($sql_pw_get);

	          $elems[] = array('name'=>'username', 'label'=>$die_start. mmw_lang_invalid_account .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4, 'len_max'=>10, 'cont' =>'alpha');
	          $elems[] = array('name'=>'email', 'label'=>$die_start. mmw_lang_invalid_email .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4, 'len_max'=>50, 'cont' =>'email');
	          $elems[] = array('name'=>'quest', 'label'=>$die_start. mmw_lang_invalid_question .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4, 'len_max'=>10, 'cont' =>'alpha');
	          $elems[] = array('name'=>'answer', 'label'=>$die_start. mmw_lang_invalid_answer .$die_end, 'type'=>'text', 'required'=>true, 'len_min'=>4, 'len_max'=>10, 'cont' =>'alpha');

                  $f = new FormValidator($elems);
	             $err = $f->validate($_POST);
	                if ( $err === true ) {
	                	$valid = $f->getValidElems();
		                    foreach ( $valid as $k => $v ) {
			               if ( $valid[$k][0][1] == false ) {
				             if ( empty($valid[$k][0][2]) ) {
				                  echo $valid[$k][0][2];
						}else {
			                          echo $valid[$k][0][2];
				            }
			             }
		             }
                               } else {

                        if($user_check <= 0 || $mail_check <= 0) {$error = 1;
                                      echo $die_start . mmw_lang_account_or_email_address_is_incorrect . $die_end;
	                }
                        if($qa_check <= 0) {$error = 1;
                                      echo $die_start . mmw_lang_question_or_answer_incorrect . $die_end;
	                }
                        if($error != 1) {
	                              echo $okey_start . mmw_lang_your_password . " $pw_retrieval[0] $okey_end";
	                }
    }
}





static function profile($account) {
   require("config.php");
   $fullname = clean_var(stripslashes($_POST['fullname']));
   $age = clean_var(stripslashes($_POST['age']));
   $country = clean_var(stripslashes($_POST['country']));
   $avatar = clean_var(stripslashes($_POST['avatar']));
   $gender = clean_var(stripslashes($_POST['gender']));
   $hide_profile = clean_var(stripslashes($_POST['hide_profile']));
   $y = clean_var(stripslashes($_POST['y']));
   $msn = clean_var(stripslashes($_POST['msn']));
   $icq = clean_var(stripslashes($_POST['icq']));
   $skype = clean_var(stripslashes($_POST['skype']));

   mssql_query("Update memb_info set [memb_name]='$fullname',[country]='$country',[gender]='$gender',[age]='$age',[avatar]='$avatar',[hide_profile]='$hide_profile',[y]='$y',[msn]='$msn',[icq]='$icq',[skype]='$skype' where memb___id='$account'");
   echo $okey_start . mmw_lang_profile_edited . $okey_end;
   writelog("profile","Acc <font color=red>$account</font> Has Been Change: [memb_name]='$fullname',[country]='$country',[gender]='$gender',[age]='$age',[avatar]='$avatar',[hide_profile]='$hide_profile',[y]='$y',[msn]='$msn',[icq]='$icq',[skype]='$skype'");
}





static function move($name) {
	include("includes/move.php");
        require("config.php");
	$login = clean_var(stripslashes($_SESSION['user']));
        $map = clean_var(stripslashes($_POST['map']));
        $name = stripslashes($name);
	$mapnumber = $move[$map][0];
        $x = $move[$map][1];
	$y = $move[$map][2];

	$select_zen_sql = mssql_query("Select money from character where name='$name'");
	$select_zen = mssql_fetch_row($select_zen_sql);

	$wh_result = mssql_query("SELECT AccountID,extMoney FROM warehouse WHERE accountid='$login'");
	$wh_row = mssql_fetch_row($wh_result); if(empty($wh_row[1]) || $wh_row[1]==" ") {$wh_row[1]="0";}

	$char_money = $select_zen[0];
	$wh_money = $wh_row[1] - $mmw['move_zen'];
	if($wh_money < 0) {$char_money = $char_money + $wh_money; $wh_money = 0;}

		if(empty($name)) {
		   echo $die_start . mmw_lang_left_blank . $die_end;
		}
		elseif($char_money < 0) {
		   echo $die_start . mmw_lang_move_need .' '.zen_format($mmw[move_zen])." Zen! $die_end";
		}
		else {
		   mssql_query("UPDATE warehouse SET [extMoney]='$wh_money' WHERE accountid='$login'");
		   mssql_query("UPDATE character SET [mapnumber]='$mapnumber',[mapposx]='$x',[mapposy]='$y',[money]='$char_money' where name='$name'");
		   echo $okey_start . mmw_lang_character_moved . $okey_end;
		   writelog("move","Char <font color=red>$name</font> Has Been Moved To: $mapnumber, $x-$y|Char: $char_money Zen|Acc: $wh_money Zen");
		}
}






static function change_class($name) {
        require("config.php");
	include("includes/change_class.php");
	$login = clean_var(stripslashes($_SESSION['user']));
        $change_class = clean_var(stripslashes($_POST['class']));
        $name = stripslashes($name);
	$class = $class_list[$change_class][0];
        $price = $class_list[$change_class][1];

	$result = mssql_query("declare @vault varbinary(1728); set @vault=(SELECT Inventory FROM Character WHERE Name='$name'); print @vault;");
	$inventory = substr(mssql_get_last_message(),2,$mmw[free_hex] * 12);
	$test_invetory = free_hex($mmw[free_hex],12);

	$select_zen_sql = mssql_query("Select money from character where name='$name'");
	$select_zen = mssql_fetch_row($select_zen_sql);

	$wh_result = mssql_query("SELECT AccountID,extMoney FROM warehouse WHERE accountid='$login'");
	$wh_row = mssql_fetch_row($wh_result); if(empty($wh_row[1]) || $wh_row[1]==" ") {$wh_row[1]="0";}

	$char_money = $select_zen[0];
	$wh_money = $wh_row[1] - $price;
	if($wh_money < 0) {$char_money = $char_money + $wh_money; $wh_money = 0;}

		if(empty($name) || $change_class=='class') {
		   echo $die_start . mmw_lang_left_blank . $die_end;
		}
		elseif($inventory != $test_invetory) {
		   echo $die_start . mmw_lang_take_off_set . $die_end;
		}
		elseif($char_money < 0) {
		   echo $die_start . mmw_lang_change_class_need .' '.zen_format($price)." Zen! $die_end";
		}
		else {
		   mssql_query("UPDATE warehouse SET [extMoney]='$wh_money' WHERE accountid='$login'");
		   mssql_query("UPDATE character SET [class]='$class',[money]='$char_money',[MagicList]=0xFF,[Quest]=0xFF WHERE name='$name'");
		   echo $okey_start . mmw_lang_character_changed . $okey_end;
		   writelog("change_class","Char <font color=red>$name</font> Has Been Changed Class To: $class|Char: $char_money Zen|Acc: $wh_money Zen");
		}
}






static function warehouse($from,$to,$zen) {
        require("config.php");
	require("includes/validate.class.php");
	$login = clean_var(stripslashes($_SESSION['user']));
        $from = stripslashes($from);
        $to = stripslashes($to);
        $zen = stripslashes($zen);

	// From
	if($from=="ewh" || $from=="wh0") {
			$result = mssql_query("SELECT AccountID,Money,extMoney FROM warehouse WHERE accountid='$login'");
			$row_from = mssql_fetch_row($result);
			if($from=="wh0") {
				if($row_from[1]==""){$from_wh="0";} else{$from_wh=$row_from[1];}
				$from_query[0]="Update warehouse set [Money]='"; $from_query[1]="' where AccountID='$login'";
			}
			if($from=="ewh") {
				if($row_from[2]==""){$from_wh="0";} else{$from_wh=$row_from[2];}
				$from_query[0]="Update warehouse set [extMoney]='"; $from_query[1]="' where AccountID='$login'";
			}
		}
	elseif(substr($from,0,2)=="ch") {
			$result = mssql_query("SELECT AccountID,Money,Name FROM Character WHERE accountid='$login' AND Name='".substr($from,2)."'");
			$row_from = mssql_fetch_row($result);
			if($row_from[1]=="") {$from_wh="0";} else{$from_wh=$row_from[1];}
			$from_query[0]="Update Character set [Money]='"; $from_query[1]="' where AccountID='$login' AND Name='$row_from[2]'";
		}

	// To
	if($to=="ewh" || $to=="wh0") {
			$result = mssql_query("SELECT AccountID,Money,extMoney FROM warehouse WHERE accountid='$login'");
			$row_to = mssql_fetch_row($result);
			if($to=="wh0") {
				if($row_to[1]=="") {$to_wh="0";} else{$to_wh=$row_to[1];}
				$to_query[0]="Update warehouse set [Money]='"; $to_query[1]="' where AccountID='$login'";
			}
			if($to=="ewh") {
				if($row_to[2]=="") {$to_wh="0";} else{$to_wh=$row_to[2];}
				$to_query[0]="Update warehouse set [extMoney]='"; $to_query[1]="' where AccountID='$login'";
			}
		}
	elseif(substr($to,0,2)=="ch") {
			$result = mssql_query("SELECT AccountID,Money,Name FROM character WHERE accountid='$login' AND Name='".substr($to,2)."'");
			$row_to = mssql_fetch_row($result);
			if($row_to[1]=="") {$to_wh="0";} else{$to_wh=$row_to[1];}
			$to_query[0]="Update Character set [Money]='"; $to_query[1]="' where AccountID='$login' AND Name='$row_to[2]'";
		}

	$from_end = $from_wh - $zen; $to_end = $to_wh + $zen;

	if(!isset($from_wh) || !isset($to_wh) || !isset($zen)){$error=1; echo $die_start . mmw_lang_left_blank . $die_end;}
	  elseif(!preg_match("/^\d*$/", $zen)){$error=1; echo $die_start . mmw_lang_zen_must_be_number . $die_end;}
	     elseif($from == $to){$error=1; echo $die_start . mmw_lang_zen_cant_move . $die_end;}
		elseif($from_end < 0){$error=1; echo $die_start . mmw_lang_not_Zen_to_move . $die_end;}
		  elseif($to!="ewh" && $to_end > $mmw[max_char_wh_zen]){$error=1; echo $die_start . mmw_lang_zen_more_max . ' '.zen_format($mmw[max_char_wh_zen]).' Zen!' . $die_end;}

	if($error!=1){
		mssql_query($from_query[0].$from_end.$from_query[1]);
		mssql_query($to_query[0].$to_end.$to_query[1]);
		echo $okey_start . zen_format($zen).' '. mmw_lang_zen_moved . $okey_end;
		writelog("money","Acc <font color=red>$login</font> Has Been from: $from_wh <u>$from</u>|to: $to_wh <u>$to</u>|how many: <b>$zen</b>|from end: $from_end|to end: $to_end");
	}
}







static function comment_send($c_id_blog,$c_id_code) {
        require("config.php");
	$c_char = clean_var(stripslashes($_SESSION['char_set']));
	$result = mssql_query("SELECT TOP 1 c_date FROM MMW_comment WHERE c_char='$c_char' ORDER BY c_date DESC");
	$losttime = mssql_fetch_row($result);
	$timeout = $losttime[0] + $mmw[comment_time_out];
	$date = time();
	$needtime = $timeout - $date;

	if($timeout>$date) {echo $die_start . mmw_lang_cant_sent_comment_need_wait . " $needtime sec. $die_end";}
	elseif(empty($c_char)) {echo $die_start . mmw_lang_cant_add_no_char . $die_end;}
	elseif(!empty($_POST['c_message'])) {
		$bug_send = bugsend(stripslashes($_POST['c_message']));
		mssql_query("INSERT INTO MMW_comment(c_id_blog,c_id_code,c_char,c_text,c_date) VALUES ('$c_id_blog','$c_id_code','$c_char','$bug_send','$date')");
		echo $okey_start . mmw_lang_comment_sent . $okey_end;
	}
}







static function comment_delete($c_id) {
	require("config.php");
	$c_id = clean_var(stripslashes($c_id));
	$char_set = stripslashes($_SESSION['char_set']);
	$result = mssql_query("SELECT c_char FROM MMW_comment WHERE c_id='$c_id'");
	$row = mssql_fetch_row($result);

	if(empty($c_id)) {
		echo "$die_start Error: Some Fields Were Left Blank! $die_end";
	}
	elseif($row[0]==$char_set || $mmw[status_rules][$_SESSION[mmw_status]][comment_delete]==1) {
                mssql_query("Delete from MMW_comment where c_id='$c_id'");
                echo $okey_start . mmw_lang_comment_deleted . $okey_end;
	}
	else {
		echo $die_start . mmw_lang_cant_or_alread_delete . $die_end;
	}
}







static function forum_send($title,$text,$catalog) {
        require("config.php");
	$char_set = stripslashes($_SESSION['char_set']);
	$date = time();

	if(empty($title) || empty($text) || empty($catalog)) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	}
	elseif(!empty($title) && !empty($text) && !empty($catalog)) {
		$text = bugsend(stripslashes($text));
		$title = bugsend(stripslashes($title));
		$catalog = bugsend(stripslashes($catalog));
		mssql_query("INSERT INTO MMW_forum ([f_id],[f_char],[f_title],[f_text],[f_created],[f_catalog],[f_date],[f_lastchar]) VALUES ('$mmw[rand_id]','$char_set','$title','$text','$date','$catalog','$date','$char_set')");
		echo $okey_start . mmw_lang_topic_sent . $okey_end;
	}
	else {
		echo "$die_start Total ErroR! $die_end";
	}
 }







static function forum_delete($f_id) {
	require("config.php");
	$f_id = clean_var(stripslashes($f_id));
	$char_set = stripslashes($_SESSION['char_set']);
	$result = mssql_query("SELECT f_char FROM MMW_forum WHERE f_id='$f_id'");
	$row = mssql_fetch_row($result);

	if(empty($f_id)) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	}
	elseif($row[0]==$char_set || $mmw[status_rules][$_SESSION[mmw_status]][forum_delete]==1) {
                mssql_query("Delete from MMW_forum where f_id='$f_id'");
                mssql_query("Delete from MMW_comment where c_id_code='$f_id'");
                echo $okey_start . mmw_lang_topic_deleted . $okey_end;
	}
	else {
		echo $die_start . mmw_lang_cant_or_alread_delete . $die_end;
	}
}







static function forum_status($f_id,$f_status) {
	require("config.php");
	$f_id = clean_var(stripslashes($f_id));
	$f_status = clean_var(stripslashes($f_status));

	if(empty($f_id) || $f_status=='') {
		echo $die_start . mmw_lang_left_blank . $die_end;
	}
	elseif($mmw[status_rules][$_SESSION[mmw_status]][forum_status]==1) {
                mssql_query("UPDATE MMW_forum SET f_status='$f_status' where f_id='$f_id'");
                echo $okey_start . mmw_lang_topic_status . $okey_end;
	}
	else {
		echo $die_start . mmw_lang_cant_or_alread_delete . $die_end;
	}
}







static function request($login) {
	require("config.php");
	if(empty($_POST['subject']) || empty($_POST['msg'])) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	}
	else {
		$title = bugsend(stripslashes($_POST['subject']));
		$msg = str_replace("[br]", "<br>", bugsend(stripslashes($_POST['msg'])) );
        	$ip = $_SERVER['REMOTE_ADDR'];
        	$date = date('d.m.Y H:i:s');
        	$text = "Acc: <b>$login</b>, New Request Title: <u>$title</u><br><font color=#FF0000>$msg</font><br>All Those On <i>$date</i> By <u>$ip</u><hr>\n";
        	$fp = fopen("admin/request.htm","a");
        	fputs($fp, $text);
        	fclose($fp);
		echo $okey_start . mmw_lang_request_sent . $okey_end;
	}
}






static function send_msg() {
	require("config.php");
	$char_set = stripslashes($_SESSION['char_set']);
	$msg_to = stripslashes($_POST["new_message"]);
	$msg_subject = utf_to_win(stripslashes($_POST["subject"]));
	$msg_text = utf_to_win(stripslashes($_POST["msg"]));
	$date = date("m/d/y H:i:s");

	$msg_to_sql = mssql_query("SELECT GUID,MemoCount FROM T_FriendMain WHERE Name='$msg_to'");
	$msg_to_row = mssql_fetch_row($msg_to_sql);

	$char_class_sql = mssql_query("SELECT class FROM Character WHERE Name='$char_set'");
	$char_class_row = mssql_fetch_row($char_class_sql);
	$char_photo = char_class($char_class_row[0],photo);

	if(empty($char_set) || empty($msg_subject) || empty($msg_to)) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	}
	elseif($msg_to_row[0]!='' && $msg_to_row[0]!=' ') {
		$msg_id = $msg_to_row[1] + 1;
		if(1==1) { // 1==2 for old version convert
		 $hex = '';
		 for($i=0; $i<strlen($msg_text); $i++) {
		  $byte = dechex(ord($msg_text{$i}));
		  $hex .= str_repeat('0', 2 - strlen($byte)).$byte;
		 }
		 $msg_text = '0x'.strtoupper( str_replace(' ', '', $hex) );
		}
		else {$msg_text = "CAST('$msg_text' AS VARBINARY(1000))";}
		$query = "INSERT INTO T_FriendMail (MemoIndex, GUID, FriendName, wDate, Subject, bRead, Memo, Dir, Act, Photo) VALUES ('$msg_id','$msg_to_row[0]','$char_set','$date','$msg_subject','0',$msg_text,'143','2',$char_photo)";
		if(mssql_query($query)) {
			$mail_total_sql = mssql_query("SELECT bRead FROM T_FriendMail WHERE GUID='$msg_to_row[0]'");
			$mail_total_num = mssql_num_rows($mail_total_sql);
			mssql_query("UPDATE T_FriendMain set [MemoCount]='$msg_id',[MemoTotal]='$mail_total_num' WHERE Name='$msg_to'");
			echo $okey_start . mmw_lang_message_sent ." $msg_to! $okey_end";
		}
		else {
			echo "$die_start ErroR Query $msg_text! $die_end";
		}
	}
	else {
		echo "$die_start It does not work in an old version! $die_end";
	}
}









static function delete_msg() {
	require("config.php");
	$char_set = stripslashes($_SESSION['char_set']);
	$char_guid = stripslashes($_SESSION['char_guid']);
	$delete_msg_inbox = clean_var(stripslashes($_POST["delete_msg_inbox"]));

	$query = "DELETE From T_FriendMail WHERE GUID='$char_guid' and MemoIndex='$delete_msg_inbox'";
	if(mssql_query($query)) {
		$mail_total_sql = mssql_query("SELECT bRead FROM T_FriendMail WHERE GUID='$char_guid'");
		$mail_total_num = mssql_num_rows($mail_total_sql);
		mssql_query("UPDATE T_FriendMain SET [MemoTotal]='$mail_total_num' WHERE Name='$char_set'");
		echo $okey_start . mmw_lang_message_deleted . $okey_end;
	}
	else {
		echo $die_start . mmw_lang_cant_or_alread_delete . $die_end;
	}
}









static function edit_warehouse($hex_wh) {
	require("config.php");
	$login = clean_var(stripslashes($_SESSION['user']));
	$hex_wh = clean_var(stripslashes($hex_wh));
	$money = clean_var(stripslashes($_POST[Money]));
	$extmoney = clean_var(stripslashes($_POST[extMoney]));

      if(empty($hex_wh) || empty($login)) {echo $die_start . mmw_lang_left_blank . $die_end;}
       elseif($mmw[status_rules][$_SESSION[mmw_status]][hex_wh]!=1) {echo "$die_start You Can't Use HEX WareHouse! $die_end";}
        elseif(!preg_match("/^\d*$/", $money) || !preg_match("/^\d*$/", $extmoney)) {echo "$die_start Money must be a positive number! $die_end";}
         else {
		$query = "UPDATE warehouse SET [Items]=0x$hex_wh,[Money]=$money,[extMoney]=$extmoney WHERE AccountID='$login'";
		if(@mssql_query($query)) {
			echo "$okey_start $login WareHouse SuccessFully Edited! $okey_end";}
		else {
			echo "$die_start HEX ErroR bljat'! :( $die_end";
		}
                writelog("hex_wh","Acc: <b>$login</b> Has Been <font color=#FF0000>edit wh</font>: $hex_wh | [Money]=$money, [extMoney]=$extmoney");
	}
}









static function gm_msg($text) {
	require("config.php");
	$text = stripslashes($text);
	include("includes/shout_msg.php");

      if(empty($text)) {echo $die_start . mmw_lang_left_blank . $die_end;}
        elseif($mmw[status_rules][$_SESSION[mmw_status]][gm_msg]!=1) {echo "$die_start You Can't Send GM Message! $die_end";}
          else {
		if( send_gm_msg("127.0.0.1", $mmw[joinserver_port], $text) == "yes") {
			echo "$okey_start GM Msg SuccessFully Send! $okey_end";}
		else {
			echo "$die_start GM Msg ErroR blja! :( $die_end";
		}
                writelog("gm_msg","Char: <b>$char</b> Has Been <font color=#FF0000>Send Msg</font>: $text");
	}
}









static function gm_block($acc_mode) {
	require("config.php");
	$acc_mode = clean_var(stripslashes($acc_mode));
	$account = clean_var(stripslashes($_POST[account]));
	$character = clean_var(stripslashes($_POST[character]));
	$account_unblock = clean_var(stripslashes($_POST[account_unblock]));
	$unblock_time = clean_var(stripslashes($_POST[unblock_time]));
	$block_date = clean_var(stripslashes($_POST[block_date]));
	$block_reason = clean_var(stripslashes($_POST[block_reason]));

      if($acc_mode==0 && empty($account_unblock)) {echo $die_start . mmw_lang_left_blank . $die_end;}
        elseif($mmw[status_rules][$_SESSION[mmw_status]][gm_block]!=1) {echo "$die_start You Can't Send GM Message! $die_end";}
          else {
		if($acc_mode == '0') {
		 mssql_query("UPDATE memb_info SET [bloc_code]='0',[block_date]='0',[unblock_time]='0' WHERE memb___id='$account_unblock'");
		 echo "$okey_start Account $account_unblock is Unblocked! $okey_end $rowbr";
		}
		else {
		 if($block_date!="no") {
		  if($block_date=='yes') {$block_date = time();}
		  else {$block_date = '0';}
		  $block_menu = "[block_date]='$block_date',";
		 }
		 $block_menu .= "[unblock_time]='$unblock_time',[block_reason]='$block_reason',[blocked_by]='$_SESSION[char_set]',";
		 if(isset($character)) {$account = "(SELECT AccountID FROM Character WHERE Name='$character')";}
		 else {$account = "'$account'";}
		 $query = "UPDATE memb_info SET $block_menu [bloc_code]='1' WHERE memb___id=$account";
		 if(@mssql_query($query)) {echo "$okey_start Account $account is Blocked! $okey_end $rowbr";}
		 else {echo "$die_start $query $die_end $rowbr";}
		}
                writelog("gm_block","Account: <b>$account$account_unblock</b> Has Been <font color=#FF0000>block mode</font>: $acc_mode by $_SESSION[char_set]");
          }
}







static function send_zen($char,$zen) {
	require("config.php");
	$char = stripslashes($char);
	$zen = clean_var(stripslashes($zen));
	$char_set = stripslashes($_SESSION['char_set']);
	$login = clean_var(stripslashes($_SESSION['user']));

	$result = mssql_query("SELECT extMoney FROM warehouse WHERE accountid='$login'");
	$from = mssql_fetch_row($result);

	$result = mssql_query("Select AccountID FROM Character WHERE Name='$char'");
	$acc_to = mssql_fetch_row($result);
	$acc_to_result = mssql_query("SELECT extMoney FROM warehouse WHERE accountid='$acc_to[0]'");
	$acc_to_row = mssql_fetch_row($acc_to_result);

	$from_end = $from[0] - $zen;
	$to_end = $acc_to_row[0] + $zen;
	$from_end_and_service = $from_end - $mmw[service_send_zen];

      if(empty($char) || empty($zen) || empty($login)) {echo $die_start . mmw_lang_left_blank . $die_end;}
        elseif(!preg_match("/^\d*$/", $zen)){echo $die_start . mmw_lang_zen_must_be_number . $die_end;}
          elseif($login == $acc_to[0]) {echo $die_start . mmw_lang_zen_cant_move . $die_end;}
            elseif($zen < $mmw[min_send_zen] || $from_end < '0' || $to_end < '0') {echo $die_start . zen_format($mmw[min_send_zen]) . ' ' . mmw_lang_minimum_zen_can_send ." $from[0] $die_end";}
              elseif($from_end_and_service < '0') {echo $die_start . mmw_lang_no_zen_for_send_zen . ' ' . zen_format($mmw[service_send_zen]) . "! $die_end";}
		elseif($acc_to[0] != $login) {
			echo "$okey_start $zen " . mmw_lang_zen_sent . $okey_end;
			mssql_query("UPDATE warehouse SET [extMoney]='$to_end' WHERE AccountID='$acc_to[0]'");
			mssql_query("UPDATE warehouse SET [extMoney]='$from_end_and_service' WHERE AccountID='$login'");
			guard_mmw_mess($char,"It was sent to you in Extra Ware House: ".zen_format($zen).", From: $char_set.");
			writelog("send_zen","Char: <b>$char_set</b> Has Been <font color=#FF0000>Send Zen</font>: $zen, To: $char (Start:$from[0],End:$from_end | Start:$acc_to_row[0],End:$to_end)");
			}
}



}
?>
