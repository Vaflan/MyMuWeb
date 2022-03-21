<style type="text/css">
#dragbar {cursor: move; padding-top: 2px; padding-left: 2px;}
a.pop-title,a.pop-title:hover {font-size: 8pt; color: #FFFFFF; font-family: Tahoma; font-weight: bold; padding-left: 2px; text-decoration: none;}
#pop-text {color: #000000; font-size: 8pt; font-family: Tahoma;}
#pop-text a {text-decoration: underline; color: #0000FF; font-size: 8pt; font-family: Tahoma;}
#pop-text a:hover {text-decoration: underline; color: #FF0000; font-size: 8pt; font-family: Tahoma;}
</style>
<script type="text/javascript" src="scripts/votebox.js">//script_by_vaflan</script>
<div id="showmmwimage" style="position: fixed; left: 320px; top: 240px; border-top:1px solid #D4D0C8; border-left:1px solid #D4D0C8; border-right:1px solid #404040; border-bottom:1px solid #404040;">	
<table align="center" cellspacing="2" cellpadding="0" style="background: #D4D0C8; border-top: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF; border-right:1px solid #808080; border-bottom: 1px solid #808080;">
   <tr>
      <td valign="top">
	<table width="100%" cellspacing="0" cellpadding="0" style="background:url(images/pop-up.png);"><tr>
		<td id="dragbar" valign="top" onMousedown="initializedrag(event)" onMouseover="dragswitch=1;if(ns4)drag_dropns(showmmwimage)" onMouseout="dragswitch=0"><img src="images/pop-logo.png" align="left"><a href="http://mymuweb.ru/" target="_blank" class="pop-title">MyMuWeb Pop-Under</a></td>
		<td width="18" align="right" valign="top" style="padding-top: 2px; padding-right: 2px; padding-bottom: 2px;"><a href="javascript://" onClick="hidebox(); return false" title="Close Window"><img src="images/pop-close.png" border="0" width="16" heigth="14"></a></td>
	</tr></table>
      </td>
   </tr>
   <tr>
      <td valign="top" style="border: 1px solid #808080;">
<table width="100%" cellspacing="0" cellpadding="0" style="background: #FFFFFF; border: 1px solid #000000;">
   <tr>
      <td align="center" id="pop-text">
<?
if(is_file('popunder.txt')) {include('popunder.txt');}
else {echo 'Please, create popunder.txt!';}
?>
      </td>
   </tr>
</table>
      </td>
   </tr>
</table>
</div>
<script>document.getElementById("showmmwimage").style.left = screen.width / 2 - (document.getElementById("pop-text").offsetWidth / 2);</script>