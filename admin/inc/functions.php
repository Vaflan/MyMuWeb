<?
function writelog($logfile,$text){
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date('d.m.Y H:i:s');
        $text = $text . ", All Those On <i>$date</i> By <u>$ip</u> \n";
        $fp = fopen("logs/$logfile.php","a");
        fputs($fp, $text);
        fclose($fp);}


function clear_logs($name)
{  require("config.php");
   $new_data = "";
   $fp = fopen("logs/$name.php","w");
   fwrite ($fp, $new_data);
	echo "$warning_green Log $name SuccessFully Deleted!";
}

   // START LOGIN
	if(isset($_POST["admin_login"])) {
                $account = clean_var(stripslashes($_POST['adminusername']));
                $password = clean_var(stripslashes($_POST['adminpassword']));
                $securitycode = clean_var(stripslashes($_POST['securitycode']));

		if(($account == NULL) || ($password == NULL) || ($securitycode == NULL)) {die ("$warning_red <center><b>Fatal ErroR! by Vaflan</b></center>");}

		if($mmw[md5] == yes) {$login_sql = mssql_query("SELECT memb___id,admin FROM dbo.MEMB_INFO WHERE memb___id='$account' AND memb__pwd=[dbo].[fn_md5]('$password','$account')");}
		elseif ($mmw[md5] == no) {$login_sql = mssql_query("SELECT memb___id,admin FROM dbo.MEMB_INFO WHERE memb___id='$account' AND memb__pwd='$password'");}
		$login_row = mssql_fetch_row($login_sql);

		if(($login_row[0] != $account) || ($mmw[admin_securitycode] != $securitycode)) {
			echo '<script language="Javascript">alert("Ups! '.$_SERVER["REMOTE_ADDR"].' Username or Password or SecurityCode Invalid!"); window.location="'.$mmw[serverwebsite].'";</script>';
			}
		if($login_row[0] == $account && $login_row[1] < $mmw[min_level_to_ap]) {
			echo '<script language="Javascript">alert("Ups! '.$login_row[0].' You Can\'t Enter in Here!"); window.location="'.$mmw[serverwebsite].'";</script>';
			}
		if(($login_row[0] = $account) && ($mmw[admin_securitycode] = $securitycode) && ($password != '') && $login_row[1] >= $mmw[min_level_to_ap]) {
			$date = time();
			mssql_query("UPDATE MEMB_INFO SET [date_online]='$date' WHERE memb___id='$login_row[0]'");
			$_SESSION['a_admin_login'] = $login_row[0];
			$_SESSION['a_admin_pass'] = $password;
			$_SESSION['a_admin_security'] = $securitycode;
			$_SESSION['a_admin_level'] = $login_row[1];
			echo '<script language="Javascript">alert("Welcome '.$login_row[0].', Press Ok To Enter The Admin Control Panel!"); window.location="admin.php";</script>';
			}
		}
	// Logout
		if(isset($_POST["admin_logout"])) { 
			unset($_SESSION['a_admin_login']);
			unset($_SESSION['a_admin_pass']);
			unset($_SESSION['a_admin_security']);
			unset($_SESSION['a_admin_level']);
			echo '<script language="Javascript">alert("You Have Logged Out From Your Admin Control Panel, Press Ok To Go To The Main WebSite!"); window.location="'.$mmw[serverwebsite].'";</script>';
			}
	// CHECK LOGIN
		if (isset($_SESSION['a_admin_security'],$_SESSION['a_admin_pass'],$_SESSION['a_admin_login'],$_SESSION['a_admin_level'])){
			$admin = clean_var(stripslashes($_SESSION['a_admin_login']));
			$pass = clean_var(stripslashes($_SESSION['a_admin_pass']));
			$code = clean_var(stripslashes($_SESSION['a_admin_security']));
			$level = clean_var(stripslashes($_SESSION['a_admin_level']));

			if($mmw[md5] == yes) {$check_sql = mssql_query("SELECT memb___id,admin FROM dbo.MEMB_INFO WHERE memb___id='$admin' AND memb__pwd=[dbo].[fn_md5]('$pass','$admin')");}
			elseif ($mmw[md5] == no) {$check_sql = mssql_query("SELECT memb___id,admin FROM dbo.MEMB_INFO WHERE memb___id='$admin' AND memb__pwd='$pass'");}
			$check_row = mssql_fetch_row($check_sql);

			if($mmw[admin_securitycode] != $code || $admin != $check_row[0] || $level != $check_row[1] || $level < $mmw[min_level_to_ap]) {
				unset($_SESSION["a_admin_login"]);
				unset($_SESSION["a_admin_pass"]);
				unset($_SESSION["a_admin_security"]);
				unset($_SESSION["a_admin_level"]);
				echo '<script language="Javascript">alert("Dear '.$_SERVER["REMOTE_ADDR"].', Don\'t Try Fuckin Things!");window.location="'.$mmw[serverwebsite].'";</script>';
				}
			}
   // END LOGIN


function add_new_server($post_name,$post_version,$post_experience,$post_drops,$post_gsport,$post_serverip,$post_order,$post_type)
{     require("config.php");
      if (empty($post_name) ||  empty($post_version) || empty($post_experience) || empty($post_drops) || empty($post_gsport) || empty($post_serverip) || empty($post_order) ||  empty($post_type)){
	         echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                 elseif (ereg('[^0-9]', $post_order)){echo "$warning_red Error: Please Use Only Numbers At Displaying Order!  <br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
               else{
                      mssql_query("INSERT INTO MMW_servers(name,experience,drops,gsport,ip,display_order,version,type) VALUES ('$post_name','$post_experience','$post_drops','$post_gsport','$post_serverip','$post_order','$post_version','$post_type')");
                      echo "$warning_green $post_name Server SuccessFully Added!";

                      $log_dat = "New Server Named: $_POST[name] Has Been <font color=#FF0000>Added</font>";
                      writelog("server",$log_dat);
                   }
}



function edit_server($name,$version,$experience,$drops,$server_type,$gsport,$serverip,$order,$old_name)
{         require("config.php");
          if(empty($name) || empty($version) || empty($experience) || empty($drops) || empty($server_type) || empty($gsport) || empty($serverip) || empty($order) || empty($old_name)){
                   echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                       else{
                                mssql_query("Update MMW_servers set [name]='$name',[experience]='$experience',[drops]='$drops',[gsport]='$gsport',[ip]='$serverip',[display_order]='$order',[version]='$version',[type]='$server_type' where [name]='$old_name'");
                                echo "$warning_green $old_name Server SuccessFully Edited!";

                                $log_dat = "Server Named: $_POST[name] Has Been <font color=#FF0000>Edited</font>";
                                writelog("server",$log_dat);
                           }
}




function delete_server($post_server_name_delete)
{     require("config.php");
      if (empty($post_server_name_delete)){echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                else{
                        mssql_query("Delete from MMW_servers where name='$post_server_name_delete'");
                        echo "$warning_green $post_server_name_delete Server SuccessFully Deleted!";

                        $log_dat = "Server Named: $_POST[server_name_delete] Has Been <font color=#FF0000>Deleted</font>";
                        writelog("server",$log_dat);
                    }
}





function add_new_news($news_title,$news_category,$news_eng,$news_rus,$news_autor)
{
           require("config.php");
           $date = time();
           $news_eng = bugsend($news_eng);
           $news_rus = bugsend($news_rus);
               if (empty($news_title) || empty($news_category)){
                      echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                           else{
                                  mssql_query("INSERT INTO MMW_news(news_title,news_autor,news_category,news_date,news_eng,news_rus,news_id) VALUES ('$_POST[news_title]','$_SESSION[a_admin_login]','$_POST[category]','$date','$news_eng','$news_rus','$mmw[rand_id]')");
                                  echo "$warning_green News SuccessFully Added!";

                                  $log_dat = "News: $_POST[news_title] Has Been <font color=#FF0000>Added</font> Author: $_SESSION[a_admin_login]";
                                  writelog("news",$log_dat);
                               }
}




function delete_news($news_id)
{
        require("config.php");
           if (empty($news_id)){echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                else{
                       mssql_query("Delete from MMW_news where news_id='$news_id'");
                       mssql_query("Delete from MMW_comment where c_id_code='$news_id'");
                       echo "$warning_green News SuccessFully Deleted!";

                       $log_dat = "News: $_POST[news_title] Has Been <font color=#FF0000>Deleted</font>";
                       writelog("news",$log_dat);
                     }
}




function edit_news($news_title,$news_autor,$news_cateogry,$news_id,$news_eng,$news_rus)
{
        require("config.php");
        $date = date('d-m-Y H:i');
        $news_eng = bugsend($news_eng);
        $news_rus = bugsend($news_rus);
          if (empty($news_title) ||  empty($news_autor) || empty($news_cateogry) ||  empty($news_id)){
	          echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                    else{
                          mssql_query("Update MMW_news set [news_title]='$_POST[edit_news_title]',[news_autor]='$_POST[edit_news_autor]',[news_category]='$_POST[category]',[news_eng]='$news_eng',[news_rus]='$news_rus' where [news_id]='$_POST[news_id]'");
                          echo "$warning_green News SuccessFully Edited!";

                          $log_dat = "News: $_POST[edit_news_title] Has Been <font color=#FF0000>Edited</font> Author: $_POST[edit_news_autor]";
                          writelog("news",$log_dat);
                        }
}




function add_new_link($link_name,$link_address,$link_description)
{
          require("config.php");
          $date = date('d-m-Y H:i');
               if (empty($link_name) ||  empty($link_address) || empty($link_description)){
	              echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                           else{
                                   mssql_query("INSERT INTO MMW_links(link_name,link_address,link_description,link_date,link_id) VALUES ('$_POST[link_name]','$_POST[link_address]','$_POST[link_description]','$date','$mmw[rand_id]')");
                                   echo "$warning_green Link SuccessFully Added!";

                                   $log_dat = "Link $_POST[link_name] Has Been <font color=#FF0000>Added</font>";
                                   writelog("link",$log_dat);
                                }
}




function delete_link($link_id)
{        require("config.php");
         if (empty($link_id)){
	      echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                  else{
                         mssql_query("Delete from MMW_links where link_id='$link_id'");
                         echo "$warning_green Link SuccessFully Deleted!";

                         $log_dat = "Link $_POST[link_name] Has Been <font color=#FF0000>Deleted</font>";
                         writelog("link",$log_dat);
                       }
}



function edit_link($link_name,$link_address,$link_description,$link_id)
{        require("config.php");
         $date = date('d-m-Y H:i');
         if (empty($link_name) ||  empty($link_address) || empty($link_description) || empty($link_id)){
	       echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                  else{
                         mssql_query("Update MMW_links set [link_name]='$_POST[link_name]',[link_address]='$_POST[link_address]',[link_description]='$_POST[link_description]',[link_date]='$date' where link_id='$_POST[link_id]'");
                         echo "$warning_green Link SuccessFully Edited!";

                         $log_dat = "Link $_POST[link_name] Has Been <font color=#FF0000>Edited</font>";
                         writelog("link",$log_dat);
                      }
}




function edit_character() {
     require("config.php");
     $post_character = $_POST['character'];
     $post_level = $_POST['level'];
     $post_reset = $_POST['resets'];
     $post_zen = $_POST['zen'];
     $post_gm = $_POST['gm'];
     $post_strength = $_POST['strength'];
     $post_agility = $_POST['agility'];
     $post_vitality = $_POST['vitality'];
     $post_energy = $_POST['energy'];
     $post_command = $_POST['command'];
     $post_leveluppoint = $_POST['leveluppoint'];
     $post_pklevel = $_POST['pklevel'];
     $post_pktime = $_POST['pktime'];
     $post_mapnumber = $_POST['mapnumber'];
     $post_mapposx = $_POST['mapposx'];
     $post_mapposy = $_POST['mapposy'];
     $post_class = $_POST['class'];
     $get_account = mssql_query("SELECT accountid,Name from character where Name='$post_character'");
     $get_account_done = mssql_fetch_row($get_account);
     $name_check = mssql_num_rows($get_account); 

     $online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$get_account_done[0]'");
     $oc_row = mssql_fetch_row($online_check);
     $get_chr = mssql_query("SELECT GameIDC FROM AccountCharacter WHERE Id='$get_account_done[0]'");
     $get_acc_chr = mssql_fetch_row($get_chr);

          if (empty($post_character) ||  empty($post_level) || empty($post_strength) || empty($post_agility) || empty($post_vitality) || empty($post_energy)){
                  echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                   elseif ($name_check <= 0){ echo "$warning_red Error: Character $post_character Doesn't Exist!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                    elseif ($oc_row[0] != 0 && $get_acc_chr[0]==$get_account_done[1]){ echo "$warning_red Error: Character $post_character Must Be Logged Off!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                     elseif (ereg('[^0-9]', $post_level)){echo "$warning_red Error: Please Use Only Numbers At Level!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                      elseif (ereg('[^0-9]', $post_reset)){echo "$warning_red Error: Please Use Only Numbers At Reset!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                       elseif (ereg('[^0-9]', $post_zen)){echo "$warning_red Error: Please Use Only Numbers At Zen!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                        elseif (ereg('[^0-9]', $post_strength)){echo "$warning_red Error: Please Use Only Numbers At Strength!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                         elseif (ereg('[^0-9]', $post_agility)){echo "$warning_red Error: Please Use Only Numbers At Agiltiy!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                          elseif (ereg('[^0-9]', $post_vitality)){echo "$warning_red Error: Please Use Only Numbers At Vitality!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                           elseif (ereg('[^0-9]', $post_energy)){echo "$warning_red Error: Please Use Only Numbers At Energy!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                            elseif (ereg('[^0-9]', $post_command)){echo "$warning_red Error: Please Use Only Numbers At Command!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                             elseif (ereg('[^0-9]', $post_leveluppoint)){echo "$warning_red Error: Please Use Only Numbers At Level Up Point!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                              elseif (ereg('[^0-9]', $post_pklevel)){echo "$warning_red Error: Please Use Only Numbers At PK Level!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                               elseif (ereg('[^0-9]', $post_pktime)){echo "$warning_red Error: Please Use Only Numbers At PK Time!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                                elseif (ereg('[^0-9]', $post_mapnumber)){echo "$warning_red Error: Please Use Only Numbers At Map Number!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                                 elseif (ereg('[^0-9]', $post_mapposx)){echo "$warning_red Error: Please Use Only Numbers At Map x!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                                  elseif (ereg('[^0-9]', $post_mapposy)){echo "$warning_red Error: Please Use Only Numbers At Map y!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                             else{
                                     mssql_query("Update character set [clevel]='$post_level',[reset]='$post_reset',[money]='$post_zen',[ctlcode]='$post_gm',[strength]='$post_strength',[dexterity]='$post_agility',[vitality]='$post_vitality',[energy]='$post_energy',[leadership]='$post_command',[LevelUpPoint]='$post_leveluppoint',[PkLevel]='$post_pklevel',[PkTime]='$post_pktime',[mapnumber]='$post_mapnumber',[mapposx]='$post_mapposx',[mapposy]='$post_mapposy',[class]='$post_class' where name='$post_character'");
                                     echo "$warning_green Character $post_character SuccessFully Edited!";

                                     $log_dat = "Character $_POST[character] Has Been <font color=#FF0000>Edited</font> with the next->Level:$_POST[level]|Reset:$_POST[reset]|Zen:$_POST[zen]|Strengh:$_POST[strength]|Agiltiy:$_POST[agility]|Vitality:$_POST[vitality]|Energy:$_POST[energy]|Command:$_POST[command]|LevelUpPoint:$_POST[leveluppoint]|ResTime:$_POST[restime]|PkLevel:$_POST[pklevel]|PkTime:$_POST[pktime]|MapNumber:$_POST[mapnumber]|MapX:$_POST[mapposx]|Mapy:$_POST[mapposy]";
                                     writelog("edit_char",$log_dat);
                                 }

}





function edit_account($post_account,$post_pwd,$post_mode,$post_email,$post_squestion,$post_sanswer,$post_unblock_time,$post_block_date,$post_block_reason,$post_admin_level)
{
        require("config.php");
        $sql_account_check = mssql_query("SELECT memb___id FROM memb_info WHERE memb___id='$post_account'"); 
        $account_check = mssql_num_rows($sql_account_check); 
        $sql_online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$post_account'");
        $row2 = mssql_fetch_row($sql_online_check);
           if (empty($post_account) || empty($post_email) || empty($post_squestion) || empty($post_sanswer)){echo "<img src=./images/warning.gif> Error: Some Fields Were Left Blank!  <br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                   elseif ($account_check <= 0){echo "$warning_red Error: Account $post_account Doesn't Exist!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                    elseif ($row2[0] != 0){echo "$warning_red Error: Account $post_account Must Be Logged Off!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                     else{
				if($post_pwd!=""){$passmd5="[memb__pwd2]='$post_pwd',[memb__pwd]=[dbo].[fn_md5]('$post_pwd','$post_account'),"; $passdef="[memb__pwd2]='$post_pwd',[memb__pwd]='$post_pwd',";}
				if($post_unblock_time!=""){$block_menu = "[unblock_time]='$post_unblock_time',";} if($post_block_date!="no"){ if($post_block_date=='yes'){$post_block_date = time();}else{$post_block_date = '0';} $block_menu = $block_menu . "[block_date]='$post_block_date',";}
				$block_menu = $block_menu . "[blocked_by]='$_SESSION[a_admin_login]',[block_reason]='$post_block_reason',";
                            if($mmw['md5']==yes){$sql_script_edit_account = "Update memb_info set $passmd5 $block_menu [bloc_code]='$post_mode',[mail_addr]='$post_email',[fpas_ques]='$post_squestion',[fpas_answ]='$post_sanswer',[admin]='$post_admin_level' where memb___id='$post_account'";}
                                 elseif($mmw['md5']==no){$sql_script_edit_account = "Update memb_info set $passdef $block_menu [bloc_code]='$post_mode',[mail_addr]='$post_email',[fpas_ques]='$post_squestion',[fpas_answ]='$post_sanswer',[admin]='$post_admin_level' where memb___id='$post_account'";}

                                   mssql_query($sql_script_edit_account);
                                   echo "$warning_green Account $post_account SuccessFully Edited!";

                                   $log_dat = "Account $_POST[account] Has Been <font color=#FF0000>Edited</font> with the next->New Password:$_POST[new_pwd]|E-mail:$_POST[email]|Secret Question:$_POST[squestion]|Secret Answer:$_POST[sanswer]|Admin Level:$_POST[admin_level]";
                                   writelog("edit_acc",$log_dat);
                           }
}




function edit_acc_wh($post_account,$post_warehouse,$post_extwarehouse)
{
        require("config.php");
        $sql_account_check = mssql_query("SELECT memb___id FROM memb_info WHERE memb___id='$post_account'"); 
        $account_check = mssql_num_rows($sql_account_check); 
           if (empty($post_account) || $post_warehouse<0 || $post_extwarehouse<0){echo "$warning_red Error: Some Fields Were Left Blank!  <br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                   elseif ($account_check <= 0){echo "$warning_red Error: Account $post_account Doesn't Exist!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
                     else{
                                   mssql_query("Update warehouse set [Money]='$post_warehouse',[extMoney]='$post_extwarehouse' where AccountID='$post_account'");
                                   echo "$warning_green Acc Ware House $post_account SuccessFully Edited!";

                                   $log_dat = "Account <b>$post_account</b> Has Been <font color=#FF0000>Edited</font> with the next-> Extra WH: $post_extwarehouse | WH: $post_warehouse";
                                   writelog("edit_acc_wh",$log_dat);
                           }
}




function delete_acc($account)
{        require("config.php");
         if (empty($account)) {
	      echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
                  else {
			$sql_online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$account'");
			$check_connect = mssql_num_rows($sql_online_check);
			if($check_connect==0) {
				mssql_query("Delete from MEMB_INFO where memb___id='$account'");
				mssql_query("Delete from VI_CURR_INFO where memb___id='$account'");
				mssql_query("Delete from warehouse where AccountID='$account'");
				$no_error = '1';
			}
			else {
				echo "Testing";
			}

			if($no_error == 1) {
			echo "$warning_green Account $account SuccessFully Deleted!";
			$log_dat = "Account $account Has Been <font color=#FF0000>Deleted</font>";
			writelog("del_acc",$log_dat);
			}
                  }
}



function sql_query($sql_query)
{
        require("config.php");
           if (empty($sql_query)){echo "$warning_red Error: Some Fields Were Left Blank!  <br><a href='javascript:history.go(-1)'>Go Back.</a>";}
             else{
		   if(mssql_query("$sql_query"))
			{echo "$warning_green SQL Query SuccessFully Edited!";}
		   else
			{echo "$warning_red <b>Error:</b> $sql_query";}

                   writelog("sql_query","<font color=#FF0000>SQL Query:</font> <b>$sql_query</b>");
                 }
}







function add_vote($question,$answer1,$answer2,$answer3,$answer4,$answer5,$answer6)
{	require("config.php");
	if (empty($question)){
		echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
	else{
		$time = time();
		mssql_query("INSERT INTO MMW_votemain(question,answer1,answer2,answer3,answer4,answer5,answer6,add_date) VALUES ('$question','$answer1','$answer2','$answer3','$answer4','$answer5','$answer6','$time')");
		echo "$warning_green Vote SuccessFully Added!";

		$log_dat = "Vote: $question Has Been <font color=#FF0000>Added</font>";
		writelog("vote",$log_dat);
	}
}



function edit_vote($id_vote,$question,$answer1,$answer2,$answer3,$answer4,$answer5,$answer6)
{	require("config.php");
	if (empty($id_vote) || empty($question)){
		echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
	else{
		mssql_query("Update MMW_votemain set [question]='$question',[answer1]='$answer1',[answer2]='$answer2',[answer3]='$answer3',[answer4]='$answer4',[answer5]='$answer5',[answer6]='$answer6' where [ID]='$id_vote'");
		echo "$warning_green $old_name Server SuccessFully Edited!";

		$log_dat = "Vote: $id_vote ([question]='$question',[answer1]='$answer1',[answer2]='$answer2',[answer3]='$answer3',[answer4]='$answer4',[answer5]='$answer5',[answer6]='$answer6') Has Been <font color=#FF0000>Edited</font>";
		writelog("vote",$log_dat);
	}
}




function delete_vote($id_vote)
{	require("config.php");
	if (empty($id_vote)){echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
	else{
		mssql_query("Delete from MMW_votemain where ID='$id_vote'");
		mssql_query("Delete from MMW_voterow where id_vote='$id_vote'");
		echo "$warning_green Vote SuccessFully Deleted!";

		$log_dat = "Id Vote: $id_vote Has Been <font color=#FF0000>Deleted</font>";
		writelog("vote",$log_dat);
	}
}
?>