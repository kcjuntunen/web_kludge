var data;
function truncate(n) {
    return Math[n > 0 ? "floor" : "ceil"](n);
}

function loadData() {
    $.getJSON('https://thingspeak.com/channels/100117/feed/last.json' , function(data) {
	$("#count2").text(truncate(data.field8));
	if (data.field3 == 0) {
	    $("#draw2").text("Closed");
	} else {
	    $("#draw2").text("Open");
	}
    });

    $.getJSON('https://thingspeak.com/channels/100093/feed/last.json' , function(data) {
	$("#count1").text(truncate(data.field7));
	if (data.field2 == 0) {
	    $("#draw1").text("Closed");
	} else {
	    $("#draw1").text("Open");
	}
    });
}

loadData();
setInterval('loadData()', 15000);
