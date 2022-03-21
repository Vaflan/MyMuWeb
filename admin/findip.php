<table width="400" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td>
        <fieldset>
        <legend>Find Ip</legend>
           <form action="" method="post" name="search_ip" id="search_ip">
                      <table width="210" border="0" cellspacing="2" cellpadding="0">
                        <tr>
                          <td colspan="2"><span class="normal_text">Character:</span> <input name="ip_search" type="text" id="ip_search" size="17" maxlength="10"></td>
                        </tr>
                        <tr>
                          <td width="76" valign="middle"><span class="normal_text">Search type</span></td>
                          <td width="122"><p>
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
                          <td colspan="2"><input type="submit" name="Submit" value="Find ip"></td>
                        </tr>
                      </table>
           </form>
        </fieldset>
    </div></td>
  </tr>
</table>
<table width="600" border="0" cellspacing="4" cellpadding="0">
   <tr>
      <td align="center">
<?if(isset($_POST["ip_search"])){include("admin/inc/search_ip.php");}?>
      </td>
   </tr>
</table>