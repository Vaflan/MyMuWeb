// All this Java Script
// Be Find By Vaflan
// And Edited By Vaflan

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




function confirmLink(theLink, theQuery) {
    if (typeof(window.opera) != 'undefined') {
        return true;//script_by_vaflan
    }
    var is_confirmed = confirm(theQuery);
    if (is_confirmed) {
        if ( typeof(theLink.href) != 'undefined' ) {
            theLink.href;
        } else if ( typeof(theLink.form) != 'undefined' ) {
            theLink.form.action;
        }
    }
    return is_confirmed;
}




/////////////////////////////////////////////////////////////////




function CheckLeng(Target,MaxLength) {
  if (Target.value.length > MaxLength)
    document.new_request.msg.value =
      document.new_request.msg.value.substr(0,MaxLength);
 }




/////////////////////////////////////////////////////////////////




function number(nStr) {
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {x1 = x1.replace(rgx, '$1' + ',' + '$2');}
	return x1; //default x1 + x2
}

function calc_price(input, service, currency) {	
	var a = input.value;
	var cost = document.getElementById(service);
	if(a > 1000000) {cost.innerHTML = (1 * a / 1000000);}
	if(a < 1000000 && a > 0) {cost.innerHTML = (1);}
	if(isNaN(cost.innerHTML) || a < 0) {cost.innerHTML = 'error';}
	else {cost.innerHTML = number(cost.innerHTML) + currency;}
}




/////////////////////////////////////////////////////////////////