// DS
function dstime(h, m) {
	dsehour = h;
	dsemin = m;
	dsetime();
}

function dsetime() {
	now = new Date();
	date = now.getDate();
	month = now.getMonth();
	year = now.getFullYear();
	ex = new Date(year, month, date, dsehour, dsemin - 5);

	var x;
	x = (ex.getTime() - now.getTime()) / 1000;
	endhour = Math.floor(x / 60 / 60); //script_by_vaflan
	endmin = Math.floor((x / 60 / 60 - Math.floor(x / 60 / 60)) * 60);
	x = (((x / 60 / 60 - Math.floor(x / 60 / 60)) * 60) - Math.floor((x / 60 / 60 - Math.floor(x / 60 / 60)) * 60)) * 60;
	endsec = Math.floor(x);

	if (endmin < 10) {
		endmin = '0' + endmin;
	}
	if (endsec < 10) {
		endsec = '0' + endsec;
	}
	if (endhour > 0) {
		endtime = endhour + ':' + endmin + ':' + endsec;
	} else {
		endtime = endmin + ':' + endsec;
	}
	if (endhour < 0) {
		endtime = 'Close';
	}
	if (endhour === -1 && endmin > 54) {
		endtime = 'Open';
	}
	document.getElementById('dstime').innerHTML = endtime;
	setTimeout('dsetime()', 1000);
}


// BC
function bctime(h, m) {
	bcehour = h;
	bcemin = m;
	bcetime();
}

function bcetime() {
	now = new Date();
	date = now.getDate();
	month = now.getMonth();
	year = now.getFullYear();
	ex = new Date(year, month, date, bcehour, bcemin - 5);

	var x;
	x = (ex.getTime() - now.getTime()) / 1000;
	endhour = Math.floor(x / 60 / 60);
	endmin = Math.floor((x / 60 / 60 - Math.floor(x / 60 / 60)) * 60);
	x = (((x / 60 / 60 - Math.floor(x / 60 / 60)) * 60) - Math.floor((x / 60 / 60 - Math.floor(x / 60 / 60)) * 60)) * 60;
	endsec = Math.floor(x);

	if (endmin < 10) {
		endmin = '0' + endmin;
	}
	if (endsec < 10) {
		endsec = '0' + endsec;
	}
	if (endhour > 0) {
		endtime = endhour + ':' + endmin + ':' + endsec;
	} else {
		endtime = endmin + ':' + endsec;
	}
	if (endhour < 0) {
		endtime = 'Close';
	}
	if (endhour === -1 && endmin > 54) {
		endtime = 'Open';
	}
	document.getElementById('bctime').innerHTML = endtime;
	setTimeout('bcetime()', 1000);
}


// CC
function cctime(h, m) {
	ccehour = h;
	ccemin = m;
	ccetime();
}

function ccetime() {
	now = new Date();
	date = now.getDate();
	month = now.getMonth();
	year = now.getFullYear();
	ex = new Date(year, month, date, ccehour, ccemin - 5);

	var x;
	x = (ex.getTime() - now.getTime()) / 1000;
	endhour = Math.floor(x / 60 / 60);
	endmin = Math.floor((x / 60 / 60 - Math.floor(x / 60 / 60)) * 60);
	x = (((x / 60 / 60 - Math.floor(x / 60 / 60)) * 60) - Math.floor((x / 60 / 60 - Math.floor(x / 60 / 60)) * 60)) * 60;
	endsec = Math.floor(x);

	if (endmin < 10) {
		endmin = '0' + endmin;
	}
	if (endsec < 10) {
		endsec = '0' + endsec;
	}
	if (endhour > 0) {
		endtime = endhour + ':' + endmin + ':' + endsec;
	} else {
		endtime = endmin + ':' + endsec;
	}
	if (endhour < 0) {
		endtime = 'Close';
	}
	if (endhour === -1 && endmin > 54) {
		endtime = 'Open';
	}
	document.getElementById('cctime').innerHTML = endtime;
	setTimeout('ccetime()', 1000);
}
