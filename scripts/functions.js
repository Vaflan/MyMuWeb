// All this JavaScript
// Were found and modified by Vaflan

function expandit(currentObject, hide) {
	var folder = document.getElementById(currentObject)
		? document.getElementById(currentObject).style
		: document.all[currentObject.sourceIndex + 1].style;

	folder.display = (folder.display !== 'none')
		? 'none'
		: '';

	if (hide) {
		var hide_objects = hide.split(',');
		for (i = 0; i < hide_objects.length; i++) {
			hide_objects[i] = hide_objects[i].replace(/^\s*(.*)/, '$1');
			hide_objects[i] = hide_objects[i].replace(/(.*?)\s*$/, '$1');
			if (document.getElementById(hide_objects[i])) {
				hidden = document.getElementById(hide_objects[i]).style;
				if (hidden.display === '') {
					hidden.display = 'none';
				}
			}
		}
	}
}

function CheckMsgLength(target, maxLength) {
	if (target.value.length > maxLength) {
		target.value = target.value.substr(0, maxLength);
	}
}

function priceValue(nStr) {
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1; //default x1 + x2
}

function calc_price(input, service, currency) {
	var a = input.value;
	var cost = document.getElementById(service);
	if (a > 1000000) {
		cost.innerHTML = (1 * a / 1000000);
	}
	if (a < 1000000 && a > 0) {
		cost.innerHTML = (1);
	}
	if (isNaN(cost.innerHTML) || a < 0) {
		cost.innerHTML = 'error';
	} else {
		cost.innerHTML = priceValue(cost.innerHTML) + currency;
	}
}

function flashIt(id, cl) {
	var c = document.getElementById(id);

	c.style.color = (c.style.color === 'red')
		? cl
		: 'red';
}

function showHelpTip(e, sHtml, bHideSelects = false) {
	// find anchor element
	var el = e.target || e.srcElement;
	while (el.tagName !== 'A')
		el = el.parentNode;

	// is there already a tooltip? If so, remove it
	if (el._helpTip) {
		helpTipHandler.hideHelpTip(el);
	}

	helpTipHandler.hideSelects = Boolean(bHideSelects);

	// create element and insert last into the body
	helpTipHandler.createHelpTip(el, sHtml);

	// position tooltip
	helpTipHandler.positionToolTip(e);

	// add a listener to the blur event.
	// When blurred remove tooltip and restore anchor
	el.onblur = helpTipHandler.anchorBlur;
	el.onkeydown = helpTipHandler.anchorKeyDown;
}

var helpTipHandler = {
	hideSelects: false,

	helpTip: null,

	showSelects: function (bVisible) {
		if (!this.hideSelects) return;
		// only IE actually do something in here
		var selects = [];
		if (document.all)
			selects = document.all.tags('SELECT');
		var l = selects.length;
		for    (var i = 0; i < l; i++)
			selects[i].runtimeStyle.visibility = bVisible ? '' : 'hidden';
	},

	create: function () {
		var d = document.createElement('DIV');
		d.className = 'help-tooltip';
		d.onmousedown = this.helpTipMouseDown;
		d.onmouseup = this.helpTipMouseUp;
		document.body.appendChild(d);
		this.helpTip = d;
	},

	createHelpTip: function (el, sHtml) {
		if (this.helpTip == null) {
			this.create();
		}

		var d = this.helpTip;
		d.style.position = 'absolute';
		d.innerHTML = sHtml;
		d._boundAnchor = el;
		el._helpTip = d;

		return d;
	},

	// Allow clicks on A elements inside tooltip
	helpTipMouseDown: function (e) {
		var d = this;
		var el = d._boundAnchor;
		if (!e) e = event;
		var t = e.target || e.srcElement;
		while (t.tagName !== 'A' && t != d)
			t = t.parentNode;
		if (t == d) return;

		el._onblur = el.onblur;
		el.onblur = null;
	},

	helpTipMouseUp: function () {
		var d = this;
		var el = d._boundAnchor;
		el.onblur = el._onblur;
		el._onblur = null;
		el.focus();
	},

	anchorBlur: function (e) {
		var el = this;
		helpTipHandler.hideHelpTip(el);
	},

	anchorKeyDown: function (e) {
		if (!e) e = window.event
		if (e.keyCode === 27) {    // ESC
			helpTipHandler.hideHelpTip(this);
		}
	},

	removeHelpTip: function (d) {
		d._boundAnchor = null;
		d.style.filter = 'none';
		d.innerHTML = '';
		d.onmousedown = null;
		d.onmouseup = null;
		d.parentNode.removeChild(d);
		//d.style.display = 'none';
	},

	hideHelpTip: function (el) {
		var d = el._helpTip;
		/**
		 * Mozilla (1.2+) starts a selection session when moved
		 * and this destroys the mouse events until reloaded
		 * d.style.top = -el.offsetHeight - 100 + 'px';
		 */

		d.style.visibility = 'hidden';
		//d._boundAnchor = null;

		el.onblur = null;
		el._onblur = null;
		el._helpTip = null;
		el.onkeydown = null;

		this.showSelects(true);
	},

	positionToolTip: function (e) {
		this.showSelects(false);
		var scroll = this.getScroll();
		var d = this.helpTip;

		// width
		if (d.offsetWidth >= scroll.width)
			d.style.width = scroll.width - 10 + 'px';
		else
			d.style.width = '';

		// left
		if (e.clientX > scroll.width - d.offsetWidth)
			d.style.left = scroll.width - d.offsetWidth + scroll.left + 'px';
		else
			d.style.left = e.clientX - 2 + scroll.left + 'px';

		// top
		if (e.clientY + d.offsetHeight + 18 < scroll.height)
			d.style.top = e.clientY + 18 + scroll.top + 'px';
		else if (e.clientY - d.offsetHeight > 0)
			d.style.top = e.clientY + scroll.top - d.offsetHeight + 'px';
		else
			d.style.top = scroll.top + 5 + 'px';

		d.style.visibility = 'visible';
	},

	// returns the scroll left and top for the browser viewport.
	getScroll: function () {
		if (document.all && typeof document.body.scrollTop != 'undefined') {    // IE model
			var ieBox = document.compatMode !== 'CSS1Compat';
			var cont = ieBox ? document.body : document.documentElement;
			return {
				left: cont.scrollLeft,
				top: cont.scrollTop,
				width: cont.clientWidth,
				height: cont.clientHeight
			};
		}
		else {
			return {
				left: window.pageXOffset,
				top: window.pageYOffset,
				width: window.innerWidth,
				height: window.innerHeight
			};
		}
	}
};