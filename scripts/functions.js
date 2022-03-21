function expandit(curobj, hide) {
	if(document.getElementById(curobj)) {
  		folder=document.getElementById(curobj).style;
	} else {
		if(ns6==1||operaaa==true) {
			folder=curobj.nextSibling.nextSibling.style;
		} else {
			folder=document.all[curobj.sourceIndex+1].style;
		}
   }
	if(folder.display=="none")
	{
		folder.display="";
	} else {
		folder.display="none";
	}
	if(hide) {
		var hide_objects = hide.split(",");
		for(i=0; i<hide_objects.length; i++) {
			hide_objects[i]=hide_objects[i].replace(/^\s*(.*)/, "$1");
			hide_objects[i]=hide_objects[i].replace(/(.*?)\s*$/, "$1");
			if(document.getElementById(hide_objects[i])) {
				hidden=document.getElementById(hide_objects[i]).style;
				if(hidden.display=="") {
					hidden.display="none";
				}
			}
		}
	}
}




////////////////////////////////////////////////



    var confirmMsg  = 'Вы действительно желаете';

function confirmLink(theLink, theQuery)
{
    if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
        return true;//script_by_vaflan
    }
    var is_confirmed = confirm(confirmMsg + ':\n' + theQuery);
    if (is_confirmed) {
        if ( typeof(theLink.href) != 'undefined' ) {
            theLink.href;
        } else if ( typeof(theLink.form) != 'undefined' ) {
            theLink.form.action;
        }
    }
    return is_confirmed;
}





///////////////////////////////////////////////////////////////




function ask_stats()
{
var detStatus=confirm("Are You Sure You Want To Add Those Stats?");
if (detStatus)
document.stats_normal.submit();
else
return false;
}




/////////////////////////////////////////////////////////////////




function check_password_form()
{
if ( document.change_password.oldpassword.value == "")
{
alert("Please enter Curent Password.");
return false;
}
if ( document.change_password.newpassword.value == "")
{
alert("Please enter New Password.");
return false;
}
if ( document.change_password.renewpassword.value == "")
{
alert("Please retype New Password.");
return false;
}
//return false;
document.change_password.submit();
}






/////////////////////////////////////////////////////////////////




function CheckLeng(Target,MaxLength)
 {
  if (Target.value.length > MaxLength)
    document.new_request.msg.value =
      document.new_request.msg.value.substr(0,MaxLength);
 }