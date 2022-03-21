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

<table width="293" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="293" height="159"><fieldset>
      <legend>Search Form</legend>
      <form action="" method="post" name="search_" id="search_">
              <table width="210" border="0" cellspacing="2" cellpadding="0">
                <tr>
                  <td valign="middle">Search Type</td>
                  <td width="119"><p align="left">
                      <label>
                      <input type="radio" name="search_type_2" value="character" checked> Characters</label>
                      <br>
                      <label>
                      <input type="radio" name="search_type_2" value="guilds"> Guilds</label>
                      <br>
                  </p></td>
                </tr>
                <tr>
                  <td colspan="2">Search <input name="character_search" type="text" id="character_search" size="17" maxlength="10"></td>
                </tr>
                <tr>
                  <td width="79" rowspan="2" valign="middle">Search Metod</td>
                  <td width="119"><p align="left">
                      <label>
                      <input type="radio" name="search_type" value="1" checked> Exact Match</label>
                      <br>
                      <label>
                      <input type="radio" name="search_type" value="0"> Partial Match</label>
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