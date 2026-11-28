var fader = [], fadeQ = [];
var RGB = new Array(256), k = 0, hex = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];
for (var i = 0; i < 16; i++) for (var j = 0; j < 16; j++) RGB[k++] = hex[i] + hex[j];

function FadeObj(number, id, colOff, colOn, spdIn, spdOut, def) {
	if (colOff.length === 3) {
		colOff = Array.from(colOff);
		colOff = colOff[0] + colOff[0] + colOff[1] + colOff[1] + colOff[2] + colOff[2];
	}
	if (colOn.length === 3) {
		colOn = Array.from(colOn);
		colOn = colOn[0] + colOn[0] + colOn[1] + colOn[1] + colOn[2] + colOn[2];
	}

	this.number = number;
	this.id = id;
	this.colOff = [parseInt(colOff.substring(0, 2), 16), parseInt(colOff.substring(2, 4), 16), parseInt(colOff.substring(4, 6), 16)];
	this.colOn = [parseInt(colOn.substring(0, 2), 16), parseInt(colOn.substring(2, 4), 16), parseInt(colOn.substring(4, 6), 16)];
	this.colNow = [].concat(this.colOff);
	this.spdIn = spdIn;
	this.spdOut = spdOut;
	this.def = def;
	this.direction = false;
	this.active = false;
	this.message = [];
	this.messageNow = 0;
}
/**
 * @deprecated Use FadeObj
 */
window.fadeObj = FadeObj;

function FadeCmd(number, message, direction) {
	this.number = number;
	this.message = message;
	this.direction = direction;
}

function fade(number, message, direction) {
	if (fader[number].def && fader[number].messageNow === 0 && fader[number].direction) {
		fadeQ[fadeQ.length] = new FadeCmd(number, 0, false);
		fadeQ[fadeQ.length] = new FadeCmd(number, message, direction);
	} else fadeQ[fadeQ.length] = new FadeCmd(number, message, direction);
	setTimeout(function () {
		fadeBegin(number);
	}, 20);
}

function fadeBegin(number) {
	for (var x = 0; x < fadeQ.length; x++) {
		for (var y = x + 1; y < fadeQ.length; y++) {
			if (fadeQ[x].number == fadeQ[y].number && fadeQ[x].message == fadeQ[y].message && fadeQ[x].direction != fadeQ[y].direction) {
				fadeQ.splice(x, 1);
				fadeQ.splice(y - 1, 1);
			}
		}
	}
	if (!fader[number].active) {
		for (var x = 0; x < fadeQ.length; x++) {
			if (fadeQ[x].number == number && fadeQ[x].direction != fader[number].direction) {
				var del = fadeQ.splice(x, 1);
				setTimeout(function () {
					fadeEng(number, del[0].message, del[0].direction);
				}, 0);
				break;
			}
		}
	}
}

function fadeEng(number, message, direction) {
	if (!fader[number].active) {
		fader[number].active = true;
		fader[number].direction = direction;
		fader[number].messageNow = parseInt(message);
		document.getElementById(fader[number].id).innerHTML = fader[number].message[message];
	}
	var iniCol = (direction) ? fader[number].colOff : fader[number].colOn;
	var endCol = (direction) ? fader[number].colOn : fader[number].colOff;
	var incCol = fader[number].colNow;
	var spd = (direction) ? fader[number].spdIn : fader[number].spdOut;
	for (var x = 0; x < 3; x++) {
		var incr = (endCol[x] - iniCol[x]) / spd;
		incCol[x] = (incr < 0) ? Math.max(incCol[x] + incr, endCol[x]) : Math.min(incCol[x] + incr, endCol[x]);
	}
	document.getElementById(fader[number].id).style.color = '#' + RGB[parseInt(incCol[0])] + RGB[parseInt(incCol[1])] + RGB[parseInt(incCol[2])];
	if (incCol[0] == endCol[0] && incCol[1] == endCol[1] && incCol[2] == endCol[2]) {
		fader[number].active = false;
		for (var x = 0; x < fadeQ.length; x++) {
			if (fadeQ[x].number == number) {
				var del = fadeQ.splice(x, 1);
				setTimeout(function () {
					fadeEng(number, del[0].message, del[0].direction);
				}, 0);
				return false;
			}
		}
		if (!direction) {
			if (fader[number].def) {
				setTimeout(function () {
					fadeEng(number, 0, true);
				}, 0);
			} else document.getElementById(fader[number].id).innerHTML = '&nbsp;';
		}
	} else setTimeout(function () {
		fadeEng(number, message, direction);
	}, 0);
}
/* ***** End: GreyWyvern's Buffered Text-fade Effect - v2.2a ******* */


