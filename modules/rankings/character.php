<?
$top_rank=clean_var(stripslashes($_POST['top_rank']));
$race=clean_var(stripslashes($_POST['sort']));

if(!isset($_POST['top_rank'])){$top_rank="100";}
if(!isset($_POST['sort'])){$race = "all";}

if($mmw['gm']=='no'){
$query[all] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where ctlcode!='32' and ctlcode!='8' order by reset desc ,clevel desc";
$query[sm] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='0' and class<='1' and ctlcode!='32' and ctlcode!='8' order by reset desc ,clevel desc";
$query[bk] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='16' and class<='17' and ctlcode!='32' and ctlcode!='8' order by reset desc ,clevel desc";
$query[me] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='32' and class<='33' and ctlcode!='32' and ctlcode!='8' order by reset desc ,clevel desc";
$query[mg] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class='48' and ctlcode!='32' and ctlcode!='8' order by reset desc ,clevel desc";
$query[dl] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class='64' and ctlcode!='32' and ctlcode!='8' order by reset desc ,clevel desc";
}
elseif($mmw['gm']=='yes'){
$query[all] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character order by reset desc ,clevel desc";
$query[sm] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='0' and class<='1' order by reset desc ,clevel desc";
$query[bk] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='16' and class<='17' order by reset desc ,clevel desc";
$query[me] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='32' and class<='33' order by reset desc ,clevel desc";
$query[mg] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class='48' order by reset desc ,clevel desc";
$query[dl] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class='64' order by reset desc ,clevel desc";
}

$result = mssql_query($query[$race]);

echo '<table border=0 cellPadding=0 cellSpacing=0 >
          <br><span class="normal_text_white">Top '.$top_rank.' Characters</span><br>&nbsp;</br>
          <table class="sort-table" id="table-1" height=30 border="0" cellpadding="0" cellspacing="0">                
          <thead><tr>
          <td class=thead2>#</td>
          <td class=thead2>Name</td>
          <td class=thead2>Reset</td>
          <td class=thead2>Level</td>
          <td class=thead2>Class</td>
          <td class=thead2>Guild</td>
          </tr></thead>';

for($i=0;$i < mssql_num_rows($result);++$i)
         {
             $rank = $i+1;
             $row = mssql_fetch_row($result);
             $status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[4]'");
             $status = mssql_fetch_row($status_reults);
             $statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$row[4]'");
             $statusdc = mssql_fetch_row($statusdc_reults);
             $guild_reults = mssql_query("Select G_Name from GuildMember where Name='$row[0]'");
             $guild = mssql_fetch_row($guild_reults);

             if($status[0] == 1 && $statusdc[0] == $row[0]) 
		{$status[0] ='<img src=./images/online.gif width=6 height=6>';}
             elseif($status[0] == 1 && $statusdc[0] != $row[0]) 
		{$status[0] ='<img src=./images/sleep.gif width=6 height=6>';}
             else {$status[0] ='<img src=./images/offline.gif width=6 height=6>';}


echo 	"<tbody><tr>
            <td>$rank</td>
            <td>$status[0] <a href=?op=character&character=$row[0]>$row[0]</a></td>
            <td>$row[3]</td>
            <td>$row[2]</td>
            <td>".char_class($row[1],off)."</td>
            <td><a href=?op=guild&guild=$guild[0]>$guild[0]</a></td>
            </tr></tbody>";
          }
?>
</table>