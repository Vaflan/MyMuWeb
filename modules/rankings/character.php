<?PHP
// PHP Script By Vaflan
// For MyMuWeb
// Ver. 1.7

$top_rank = clean_var(stripslashes($_POST['top_rank']));
$race = clean_var(stripslashes($_POST['sort']));

if(empty($_POST['top_rank'])){$top_rank = '100';}
if(empty($_POST['sort'])){$race = 'all';}

if($mmw['gm']=='no'){$no_gm_in_top = "and ctlcode!='32' and ctlcode!='8'";}
$query_race[all] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='0' $no_gm_in_top order by reset desc, clevel desc";
$query_race[dw] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='0' and class<='15' $no_gm_in_top order by reset desc, clevel desc";
$query_race[dk] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='16' and class<='31' $no_gm_in_top order by reset desc, clevel desc";
$query_race[elf] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='32' and class<='47' $no_gm_in_top order by reset desc, clevel desc";
$query_race[mg] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='48' and class<='63' $no_gm_in_top order by reset desc, clevel desc";
$query_race[dl] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='64' and class<='79' $no_gm_in_top order by reset desc, clevel desc";
$query_race[sum] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='80' and class<='95' $no_gm_in_top order by reset desc, clevel desc";
$query_race[rf] = "Select TOP $top_rank Name,Class,cLevel,Reset,AccountID from Character where class>='96' and class<='112' $no_gm_in_top order by reset desc, clevel desc";

$result = @mssql_query($query_race[$race]);
$row_num = @mssql_num_rows($result);

echo "<br>".mmw_lang_top." $top_rank ".mmw_lang_characters."<br>&nbsp;</br>
          <table class='sort-table' border='0' cellpadding='0' cellspacing='0'>                
          <thead><tr>
          <td>#</td>
          <td>".mmw_lang_character."</td>
          <td>".mmw_lang_reset."</td>
          <td>".mmw_lang_level."</td>
          <td>".mmw_lang_class."</td>
          <td>".mmw_lang_guild."</td>
          </tr></thead>";

if($row_num==0) {
 echo '<tr><td colspan="6">'.mmw_lang_no_characters.'</td></tr>';
}

for($i=0; $i<$row_num; ++$i) {
	$rank = $i+1;
	$row = mssql_fetch_row($result);
	$status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[4]'");
	$status = mssql_fetch_row($status_reults);
	$statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$row[4]'");
	$statusdc = mssql_fetch_row($statusdc_reults);
	if(empty($_SESSION['guild_'.$row[0]])) {
	 $guild_reults = mssql_query("Select G_Name from GuildMember where Name='$row[0]'");
	 $_SESSION['guild_'.$row[0]] = mssql_fetch_row($guild_reults);
	}
	$guild = $_SESSION['guild_'.$row[0]];

	if($status[0] == 1 && $statusdc[0] == $row[0]) {$status[0] ='<img src='.default_img('online.gif').' width=6 height=6>';}
	else {$status[0] ='<img src='.default_img('offline.gif').' width=6 height=6>';}

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