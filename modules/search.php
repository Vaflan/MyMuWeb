<?
require("config.php");
?>
<script language="Javascript" type="text/javascript">
function search_form()
{
if ( document.search_.character_search.value == "")
{
alert("Please enter some words.");
return false;
}
//return false;
document.search_.submit();
}
</script>
<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="293" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="293" height="159"><fieldset>
      <legend>Search Form</legend>
      <form action="" method="post" name="search_" id="search_">
              <table width="210" border="0" cellspacing="2" cellpadding="0">
                <tr>
                  <td valign="middle" class="normal_text_white">Search Type</td>
                  <td width="119"><p align="left">
                      <label>
                      <input type="radio" name="search_type_2" value="character" checked>
                      <span class="normal_text_white">Characters</span></label>
                      <br>
                      <label>
                      <input type="radio" name="search_type_2" value="guilds">
                      <span class="normal_text_white">Guilds</span></label>
                      <br>
                  </p></td>
                </tr>
                <tr>
                  <td colspan="2"><div align="left"><span class="normal_text_white">Search</span>
                          <input name="character_search" type="text" id="character_search" size="17" maxlength="10">
                  </div></td>
                </tr>
                <tr>
                  <td width="79" rowspan="2" valign="middle"><div align="left"><span class="normal_text_white">Search Metod </span></div></td>
                  <td width="119"><p align="left">
                      <label>
                      <input type="radio" name="search_type" value="1" checked>
                      <span class="normal_text_white">Exact Match</span></label>
                      <br>
                      <label>
                      <input type="radio" name="search_type" value="0">
                      <span class="normal_text_white">Partial Match</span></label>
                      <br>
                  </p></td>
                </tr>
                <tr>
                  <td colspan="2"><input type="submit" name="Submit" value="Submit New Search" onclick="return search_form();" class="button"></td>
                </tr>
              </table>
          </form>
    </fieldset></td>
  </tr>
</table>
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
<?
if (isset($_POST["character_search"])){
if($_POST['search_type_2'] == 'character'){include("modules/rankings/search.php"); }
elseif($_POST['search_type_2'] == 'guilds'){include("modules/rankings/search_guild.php");}
}
?>
      </td>
  </tr>
</table>